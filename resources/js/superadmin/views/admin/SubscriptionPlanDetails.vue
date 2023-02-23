<template>
    <AdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.current_plan`)" style="padding: 0px">
                <template #extra>
                    <a-button
                        type="primary"
                        @click="
                            () => $router.push({ name: 'admin.subscription.change_plan' })
                        "
                    >
                        <FormOutlined />
                        {{ $t("subscription_plans.change_plan") }}
                    </a-button>
                </template>
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
                    {{ $t("menu.current_plan") }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </AdminPageHeader>

    <a-row>
        <a-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
            <a-card
                class="page-content-container"
                v-if="responseData && responseData.current_subscription_plan"
            >
                <a-row :gutter="16">
                    <a-col :span="24">
                        <a-typography-title :level="5" strong>
                            {{ responseData.current_subscription_plan.name }}
                        </a-typography-title>
                        <a-divider />
                    </a-col>
                </a-row>

                <a-row :gutter="16">
                    <a-col :span="12">
                        <a-typography-text strong>
                            {{ $t("subscription_plans.monthly_price") }}
                        </a-typography-text>
                    </a-col>
                    <a-col :span="12">
                        {{
                            formatAmountUsingCurrencyObject(
                                responseData.current_subscription_plan.monthly_price,
                                responseData.currency
                            )
                        }}
                    </a-col>
                </a-row>
                <a-row :gutter="16" class="mt-20">
                    <a-col :span="12">
                        <a-typography-text strong>
                            {{ $t("subscription_plans.annual_price") }}
                        </a-typography-text>
                    </a-col>
                    <a-col :span="12">
                        {{
                            formatAmountUsingCurrencyObject(
                                responseData.current_subscription_plan.annual_price,
                                responseData.currency
                            )
                        }}
                    </a-col>
                </a-row>

                <a-row :gutter="16" class="mt-20">
                    <a-col :span="12">
                        <a-typography-text strong>
                            {{ $t("payment_transaction.last_paid_on") }}
                        </a-typography-text>
                    </a-col>
                    <a-col :span="12">
                        <span v-if="responseData.last_payment_transcation">
                            {{
                                formatDate(responseData.last_payment_transcation.paid_on)
                            }}
                        </span>
                        <span v-else>-</span>
                    </a-col>
                </a-row>

                <a-row :gutter="16" class="mt-20">
                    <a-col :span="12">
                        <a-typography-text strong>
                            {{ $t("payment_transaction.next_payment_date") }}
                        </a-typography-text>
                    </a-col>
                    <a-col :span="12">
                        <span v-if="responseData.last_payment_transcation">
                            {{
                                formatDate(
                                    responseData.last_payment_transcation
                                        .next_payment_date
                                )
                            }}
                        </span>
                        <span v-else-if="appSetting.licence_expire_on != ''">
                            {{ formatDate(appSetting.licence_expire_on) }}
                        </span>
                        <span v-else>-</span>
                    </a-col>
                </a-row>
            </a-card>
        </a-col>
    </a-row>
</template>

<script>
import { ref, onMounted, reactive, toRef, watch } from "vue";
import { FormOutlined } from "@ant-design/icons-vue";
import AdminPageHeader from "../../../common/layouts/AdminPageHeader.vue";
import common from "../../../common/composable/common";

export default {
    components: {
        FormOutlined,
        AdminPageHeader,
    },
    setup() {
        const responseData = ref([]);
        const { formatDate, formatAmountUsingCurrencyObject, appSetting } = common();

        onMounted(() => {
            axiosAdmin.get("subscription-plan-details").then((response) => {
                responseData.value = response.data;
            });
        });

        return {
            formatDate,
            formatAmountUsingCurrencyObject,
            responseData,

            appSetting,
        };
    },
};
</script>
