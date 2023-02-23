<template>
    <AdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.change_plan`)" style="padding: 0px">
            </a-page-header>
        </template>
        <template #breadcrumb>
            <a-breadcrumb separator="-" style="font-size: 12px">
                <a-breadcrumb-item>
                    <router-link :to="{ name: 'admin.dashboard.index' }">
                        {{ $t(`menu.dashboard`) }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t(`menu.subscription`) }}
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t("menu.change_plan") }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </AdminPageHeader>

    <a-row>
        <a-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
            <PaymentMethodsModal
                v-if="responseData && responseData.currency"
                :visible="paymentMethodsModalVisible"
                :subscribePlan="currentSelectedPlan"
                :currency="responseData.currency"
                :planType="packageType"
                @closed="onPaymentMethodsModalClose"
                @offlinePaymentSuccess="offlinePaymentSuccess"
            />

            <a-card class="page-content-container">
                <a-row :gutter="16" class="mb-20">
                    <a-col :span="24">
                        <a-alert
                            v-if="paymentSuccess"
                            :message="$t('common.success')"
                            :description="
                                $t('payment_settings.payment_success_give_some_time')
                            "
                            type="success"
                            show-icon
                            closable
                            @close="() => (paymentSuccess = false)"
                        />
                    </a-col>
                </a-row>

                <a-row :gutter="16" class="mb-20">
                    <a-col :span="24">
                        <a-radio-group v-model:value="packageType">
                            <a-radio-button value="monthly">
                                {{ $t("subscription_plans.monthly") }}
                            </a-radio-button>
                            <a-radio-button value="annual">
                                {{ $t("subscription_plans.yearly") }}
                            </a-radio-button>
                        </a-radio-group>
                    </a-col>
                </a-row>

                <a-row
                    :gutter="[16, 16]"
                    v-if="
                        responseData && appSetting && responseData.all_subscription_plans
                    "
                >
                    <a-col
                        :span="24"
                        v-for="allSubscriptionPlan in responseData.all_subscription_plans"
                        :key="allSubscriptionPlan.xid"
                    >
                        <a-card style="padding-bottom: 20px" hoverable>
                            <a-row :gutter="16">
                                <a-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
                                    <a-typography-title :level="3">
                                        {{ allSubscriptionPlan.name }}
                                    </a-typography-title>
                                    {{ allSubscriptionPlan.description }}
                                </a-col>
                                <a-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8">
                                    <ul
                                        v-for="subscritpionPlanFeature in allSubscriptionPlan.features"
                                        :key="subscritpionPlanFeature"
                                    >
                                        <li>{{ subscritpionPlanFeature }}</li>
                                    </ul>
                                </a-col>
                                <a-col :xs="24" :sm="24" :md="24" :lg="4" :xl="4">
                                    <a-typography-title :level="3">
                                        {{
                                            packageType == "monthly"
                                                ? formatAmountUsingCurrencyObject(
                                                      allSubscriptionPlan.monthly_price,
                                                      responseData.currency
                                                  )
                                                : formatAmountUsingCurrencyObject(
                                                      allSubscriptionPlan.annual_price,
                                                      responseData.currency
                                                  )
                                        }}
                                    </a-typography-title>
                                    <span>
                                        {{
                                            packageType == "monthly"
                                                ? $t("subscription_plans.per_month")
                                                : $t("subscription_plans.per_year")
                                        }}
                                    </span>
                                </a-col>
                                <a-col :xs="24" :sm="24" :md="24" :lg="4" :xl="4">
                                    <a-typography-text
                                        v-if="
                                            allSubscriptionPlan.xid ==
                                                appSetting.x_subscription_plan_id &&
                                            appSetting.package_type == packageType
                                        "
                                        type="success"
                                        strong
                                    >
                                        {{ $t("menu.current_plan") }}
                                    </a-typography-text>
                                    <a-button
                                        type="primary"
                                        @click="subscribeThisPlan(allSubscriptionPlan)"
                                        block
                                    >
                                        {{ $t("payment_transaction.subscribe") }}
                                        <DoubleRightOutlined />
                                    </a-button>
                                </a-col>
                            </a-row>
                        </a-card>
                    </a-col>
                </a-row>
            </a-card>
        </a-col>
    </a-row>
</template>

<script>
import { ref, onMounted, reactive, toRef, watch } from "vue";
import { FormOutlined, DoubleRightOutlined } from "@ant-design/icons-vue";
import { useRouter } from "vue-router";
import AdminPageHeader from "../../../common/layouts/AdminPageHeader.vue";
import SubscriptionSidebar from "./SubscriptionSidebar.vue";
import common from "../../../common/composable/common";
import PaymentMethodsModal from "./PaymentMethodsModal.vue";

export default {
    components: {
        FormOutlined,
        DoubleRightOutlined,
        AdminPageHeader,
        SubscriptionSidebar,
        PaymentMethodsModal,
    },
    setup() {
        const router = useRouter();
        const { formatAmountUsingCurrencyObject, appSetting } = common();
        const responseData = ref([]);
        const packageType = ref(appSetting.value.package_type);
        const currentSelectedPlan = ref({});
        const paymentMethodsModalVisible = ref(false);
        const paymentSuccess = ref(false);

        onMounted(() => {
            fetchAllPlans();
        });

        const fetchAllPlans = () => {
            axiosAdmin.get("all-subscription-plans").then((response) => {
                responseData.value = response.data;
            });
        };

        const subscribeThisPlan = (selectedPlan) => {
            currentSelectedPlan.value = selectedPlan;
            paymentMethodsModalVisible.value = true;
        };

        const offlinePaymentSuccess = (reloadPage) => {
            paymentMethodsModalVisible.value = false;

            // Redirect to offline requests page
            router.push({
                name: "admin.subscription.offline_requests",
                state: { success: true },
            });
        };

        const onPaymentMethodsModalClose = (reloadPage) => {
            paymentMethodsModalVisible.value = false;

            if (reloadPage) {
                paymentSuccess.value = true;
                fetchAllPlans();
            }
        };

        return {
            formatAmountUsingCurrencyObject,
            appSetting,
            packageType,
            responseData,

            subscribeThisPlan,
            paymentMethodsModalVisible,
            currentSelectedPlan,
            onPaymentMethodsModalClose,
            paymentSuccess,
            offlinePaymentSuccess,
        };
    },
};
</script>
