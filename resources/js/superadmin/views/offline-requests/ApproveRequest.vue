<template>
    <a-tooltip :title="$t('offline_request.approve_request')" @click="showModal">
        <a-button type="primary" style="background-color: #87d068; border-color: #87d068">
            <template #icon>
                <CheckCircleOutlined />
            </template>
        </a-button>
    </a-tooltip>
    <a-modal
        :visible="visible"
        :closable="false"
        :centered="true"
        :title="$t('offline_request.approve_request')"
        @ok="onSubmit"
        :width="drawerWidth"
    >
        <a-descriptions size="small" :column="2">
            <a-descriptions-item :label="$t('offline_request.subscription_plan')">
                {{ offlineRequest.subscription_plan.name }}
            </a-descriptions-item>
            <a-descriptions-item :label="$t('offline_request.plan_type')">
                {{ $t(`subscription_plans.${offlineRequest.plan_type}`) }}
            </a-descriptions-item>
            <a-descriptions-item :label="$t('offline_request.payment_mode')">
                {{ offlineRequest.offline_payment_mode.name }}
            </a-descriptions-item>
            <a-descriptions-item :label="$t('offline_request.proof_document')">
                <a-typography-link
                    :href="offlineRequest.proof_document_url"
                    target="_blank"
                >
                    <EyeOutlined /> {{ $t("common.view") }}
                </a-typography-link>
            </a-descriptions-item>
            <a-descriptions-item :label="$t('writer.total_characters')">
                {{ offlineRequest.subscription_plan.max_characters }}
            </a-descriptions-item>
        </a-descriptions>
        <a-divider></a-divider>

        <a-form layout="vertical">
            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="12" :lg="12">
                    <a-form-item
                        :label="$t('offline_request.payment_date')"
                        name="paid_on"
                        :help="rules.paid_on ? rules.paid_on.message : null"
                        :validateStatus="rules.paid_on ? 'error' : null"
                        class="required"
                    >
                        <a-date-picker
                            v-model:value="formData.paid_on"
                            :format="appSetting.date_format"
                            valueFormat="YYYY-MM-DD"
                            style="width: 100%"
                        />
                    </a-form-item>
                </a-col>
                <a-col :xs="24" :sm="24" :md="12" :lg="12">
                    <a-form-item
                        :label="$t('payment_transaction.amount')"
                        name="amount"
                        :help="rules.amount ? rules.amount.message : null"
                        :validateStatus="rules.amount ? 'error' : null"
                        class="required"
                    >
                        <a-input-number
                            v-model:value="formData.amount"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('payment_transaction.amount'),
                                ])
                            "
                            min="0"
                            style="width: 100%"
                        >
                            <template #addonBefore>
                                {{ appSetting.currency.symbol }}
                            </template>
                        </a-input-number>
                    </a-form-item>
                </a-col>
            </a-row>

            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="24" :lg="24">
                    <a-form-item
                        :label="$t('payment_transaction.license_expires_on')"
                        name="license_expires_on"
                        :help="rules.license_expires_on ? rules.paid_on.message : null"
                        :validateStatus="rules.license_expires_on ? 'error' : null"
                    >
                        <a-date-picker
                            v-model:value="formData.license_expires_on"
                            :format="appSetting.date_format"
                            :placeholder="$t('payment_transaction.no_date_selected')"
                            valueFormat="YYYY-MM-DD"
                            style="width: 100%"
                            :disabled="true"
                        />
                    </a-form-item>
                </a-col>
            </a-row>
        </a-form>
        <template #footer>
            <a-button
                key="submit"
                type="primary"
                :loading="loading"
                @click="onSubmit"
                style="background-color: #87d068; border-color: #87d068"
            >
                <template #icon>
                    <CheckCircleOutlined />
                </template>
                {{ $t("offline_request.approve") }}
            </a-button>
            <a-button key="back" @click="onClose">
                {{ $t("common.cancel") }}
            </a-button>
        </template>
    </a-modal>
</template>

<script>
import { ref, onMounted, watch } from "vue";
import { CheckCircleOutlined, EyeOutlined } from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import apiAdmin from "../../../common/composable/apiAdmin";
import SubscriptionPlanAddButton from "../subscriptions/subscription-plans/AddButton.vue";
import OfflinePaymentModeAddButton from "../subscriptions/offline-payment-modes/AddButton.vue";
import common from "../../../common/composable/common";

export default {
    props: ["offlineRequest"],
    emits: ["success"],
    components: {
        CheckCircleOutlined,
        EyeOutlined,

        SubscriptionPlanAddButton,
        OfflinePaymentModeAddButton,
    },
    setup(props, { emit }) {
        const { appSetting, dayjsObject } = common();
        const { t } = useI18n();
        const visible = ref(false);
        const { addEditRequestAdmin, loading, rules } = apiAdmin();
        const formData = ref({
            offline_request_id: undefined,
            subscription_plan_id: undefined,
            plan_type: undefined,
            offline_payment_mode_id: undefined,
            amount: undefined,
            paid_on: undefined,
            license_expires_on: undefined,
        });
        const subscriptionPlans = ref([]);
        const paymentModes = ref([]);
        const subscriptionPlanUrl =
            "superadmin/subscription-plans?fields=id,xid,name&limit=10000";
        const paymentModesUrl =
            "superadmin/offline-payment-modes?fields=id,xid,name&limit=10000";

        onMounted(() => {
            getInitialData();
        });

        const getInitialData = () => {
            const subscriptionPlansPromise = axiosAdmin.get(subscriptionPlanUrl);
            const paymentModesPromise = axiosAdmin.get(paymentModesUrl);

            Promise.all([subscriptionPlansPromise, paymentModesPromise]).then(
                ([subscriptionPlansResponse, paymentModesResponse]) => {
                    subscriptionPlans.value = subscriptionPlansResponse.data;
                    paymentModes.value = paymentModesResponse.data;

                    formData.value = {
                        ...formData.value,
                        offline_request_id: props.offlineRequest.xid,
                        subscription_plan_id: props.offlineRequest.x_subscription_plan_id,
                        plan_type: props.offlineRequest.plan_type,
                        offline_payment_mode_id:
                            props.offlineRequest.x_offline_payment_mode_id,
                    };
                }
            );
        };

        const subscriptionPlanAdded = () => {
            axiosAdmin.get(subscriptionPlanUrl).then((response) => {
                subscriptionPlans.value = response.data;
            });
        };

        const offlinePaymentModeAdded = () => {
            axiosAdmin.get(paymentModesUrl).then((response) => {
                paymentModes.value = response.data;
            });
        };

        const showModal = () => {
            visible.value = true;
        };

        const onSubmit = () => {
            addEditRequestAdmin({
                url: `superadmin/offline-requests/approve`,
                data: formData.value,
                successMessage: t("offline_request.request_approved_successfully"),
                success: (res) => {
                    rules.value = {};
                    visible.value = false;
                    emit("success", true);
                },
            });
        };

        const onClose = () => {
            rules.value = {};
            visible.value = false;
        };

        const setLicenseExpired = () => {
            if (
                formData.value.plan_type == "monthly" &&
                formData.value.paid_on != undefined
            ) {
                formData.value = {
                    ...formData.value,
                    license_expires_on: dayjsObject(formData.value.paid_on).add(
                        1,
                        "month"
                    ),
                };
            } else if (
                formData.value.plan_type == "annual" &&
                formData.value.paid_on != undefined
            ) {
                formData.value = {
                    ...formData.value,
                    license_expires_on: dayjsObject(formData.value.paid_on).add(
                        1,
                        "year"
                    ),
                };
            } else {
                formData.value = {
                    ...formData.value,
                    license_expires_on: undefined,
                };
            }
        };

        watch(
            () => formData.value.paid_on,
            (newVal, oldVal) => {
                setLicenseExpired();
            }
        );

        watch(
            () => formData.value.plan_type,
            (newVal, oldVal) => {
                setLicenseExpired();
            }
        );

        return {
            appSetting,
            visible,
            loading,
            rules,
            formData,
            subscriptionPlans,
            paymentModes,

            subscriptionPlanAdded,
            offlinePaymentModeAdded,
            onClose,
            onSubmit,
            showModal,

            drawerWidth: window.innerWidth <= 991 ? "90%" : "30%",
        };
    },
};
</script>

<style></style>
