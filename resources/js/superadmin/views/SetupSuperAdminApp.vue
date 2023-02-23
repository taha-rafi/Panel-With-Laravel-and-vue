<template>
    <a-alert
        :message="$t('setup_superadmin_company.setup_not_completed')"
        :description="$t('setup_superadmin_company.setup_not_completed_description')"
        type="error"
        show-icon
    />
    <a-card class="setup-page-content-container">
        <a-row class="mt-40">
            <a-col :span="20" :offset="1">
                <a-steps :current="currentStep">
                    <a-step :status="currencyStepStatus">
                        <template #title>
                            {{ $t("setup_superadmin_company.currency") }}
                        </template>
                        <template #description>
                            <span>{{
                                $t("setup_superadmin_company.add_first_currency")
                            }}</span>
                        </template>
                    </a-step>
                    <a-step :status="companyWhiteLabelStepStatus">
                        <template #title>
                            {{ $t("setup_superadmin_company.white_label_settings") }}
                        </template>
                        <template #description>
                            <span>{{
                                $t("setup_superadmin_company.white_label_descrtipion")
                            }}</span>
                        </template>
                    </a-step>
                    <a-step :status="companySettingStepStatus">
                        <template #title>
                            {{ $t("setup_superadmin_company.company_settings") }}
                        </template>
                        <template #description>
                            <span>{{
                                $t("setup_superadmin_company.set_company_basic_settings")
                            }}</span>
                        </template>
                    </a-step>
                </a-steps>
                <a-divider></a-divider>

                <template v-if="appDetails && appDetails.app && appDetails.app.name">
                    <template v-if="currentStep == 0">
                        <a-button type="primary" @click="addCurrency">
                            <PlusOutlined />
                            {{ $t("currency.add") }}
                        </a-button>

                        <CurrencyTable
                            class="mb-40"
                            ref="currencyTableRef"
                            :showFilter="false"
                            panelType="superadmin"
                            @addOrEditSuccess="currencyAddSuccess"
                        />
                    </template>
                    <template v-if="currentStep == 1">
                        <WhiteLabelSetting />
                    </template>
                    <template v-if="currentStep == 2">
                        <EditSetupSetting
                            class="mb-40"
                            ref="companySettingRef"
                            :showSubmitButton="false"
                            @updateSuccess="companySettingUpdated"
                        />
                    </template>
                </template>
            </a-col>
        </a-row>
    </a-card>
    <a-row>
        <a-col :span="20" :offset="1">
            <div
                :style="{
                    position: 'absolute',
                    right: 0,
                    bottom: 0,
                    width: '100%',
                    borderTop: '1px solid #e9e9e9',
                    padding: '10px 16px',
                    background: '#fff',
                    textAlign: 'left',
                    zIndex: 1,
                    marginBottom: '10px',
                }"
            >
                <a-space>
                    <a-button
                        v-if="currentStep >= 1 && currentStep != 2"
                        type="primary"
                        :style="{ backgroundColor: '#faad14', border: '#faad14' }"
                        @click="goBack"
                    >
                        <DoubleLeftOutlined />
                        {{ $t("setup_superadmin_company.previous_step") }}
                    </a-button>
                    <a-button
                        v-if="currentStep < 2"
                        type="primary"
                        @click="goNext"
                        :disabled="currentStep >= correctStep && currentStep != 1"
                    >
                        {{ $t("setup_superadmin_company.next_step") }}
                        <DoubleRightOutlined />
                    </a-button>
                    <a-button
                        v-if="currentStep == 2 && companySettingRef"
                        type="primary"
                        :style="{ backgroundColor: '#52c41a', border: '#52c41a' }"
                        @click="submitCompanySetting"
                        :loading="companySettingRef.loading"
                    >
                        <SaveOutlined />
                        {{ $t("setup_superadmin_company.save_finish_setup") }}
                    </a-button>
                </a-space>
            </div>
        </a-col>
    </a-row>

    <a-modal
        v-model:visible="showFinalModal"
        :maskClosable="false"
        :closable="false"
        :footer="null"
        centered
    >
        <a-result>
            <template #title>
                <span v-if="setupCompleted" :style="{ color: '#7676e3' }">
                    {{ $t("setup_superadmin_company.setup_complete_message") }}
                </span>
                <span v-else :style="{ color: '#7676e3' }">
                    {{ $t("setup_superadmin_company.setup_running_message") }}
                </span>
            </template>
            <template #icon>
                <CheckCircleOutlined v-if="setupCompleted" />
                <InfoCircleOutlined v-else />
            </template>
            <template #extra>
                <a-button
                    v-if="setupCompleted"
                    type="primary"
                    :style="{ backgroundColor: '#52c41a', border: '#52c41a' }"
                    @click="goToDashboard"
                >
                    <HomeOutlined />
                    {{ $t("setup_superadmin_company.go_to_dashboard") }}
                </a-button>
                <SyncOutlined
                    v-else
                    :style="{ fontSize: '38px', color: '#5254cf' }"
                    spin
                />
            </template>
        </a-result>
    </a-modal>

    <a-modal
        v-model:visible="showConfirmWhiteLabelModal"
        :maskClosable="false"
        :footer="null"
        centered
    >
        <a-result>
            <template #title>
                <span :style="{ color: '#7676e3' }">
                    {{ $t("setup_superadmin_company.white_label_settings_completed") }}
                </span>
            </template>
            <template #icon>
                <InfoCircleOutlined />
            </template>
            <template #extra>
                <a-space>
                    <a-button
                        type="primary"
                        :style="{ backgroundColor: '#52c41a', border: '#52c41a' }"
                        @click="
                            () => {
                                showConfirmWhiteLabelModal = false;
                            }
                        "
                    >
                        {{ $t("common.no") }}
                    </a-button>
                    <a-button
                        type="primary"
                        :style="{ backgroundColor: '#ff4d4f', border: '#ff4d4f' }"
                        @click="confirmWhiteLabel"
                    >
                        {{ $t("setup_superadmin_company.yes_uploaded") }}
                    </a-button>
                </a-space>
            </template>
        </a-result>
    </a-modal>
</template>

<script>
import { defineComponent, ref, onMounted, reactive, toRefs } from "vue";
import {
    PlusOutlined,
    EditOutlined,
    DeleteOutlined,
    DoubleRightOutlined,
    DoubleLeftOutlined,
    SaveOutlined,
    SyncOutlined,
    CheckCircleOutlined,
    HomeOutlined,
    InfoCircleOutlined,
} from "@ant-design/icons-vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import CurrencyTable from "../../main/views/common/settings/currency/CurrencyTable.vue";
import EditSetupSetting from "./settings/company/EditSetupSetting.vue";
import WhiteLabelSetting from "./WhiteLabelSetting.vue";

export default defineComponent({
    components: {
        PlusOutlined,
        EditOutlined,
        DeleteOutlined,
        DoubleRightOutlined,
        DoubleLeftOutlined,
        SaveOutlined,
        SyncOutlined,
        CheckCircleOutlined,
        HomeOutlined,
        InfoCircleOutlined,

        CurrencyTable,
        EditSetupSetting,
        WhiteLabelSetting,
    },
    setup() {
        const router = useRouter();
        const store = useStore();
        const currencyTableRef = ref(null);
        const companyWhiteLableRef = ref(null);
        const companySettingRef = ref(null);
        const appDetails = ref([]);
        const currentStep = ref(0);
        const correctStep = ref(0);
        const stepStatus = reactive({
            currencyStepStatus: "wait",
            companyWhiteLabelStepStatus: "wait",
            companySettingStepStatus: "wait",
        });
        const showFinalModal = ref(false);
        const setupCompleted = ref(false);
        const showConfirmWhiteLabelModal = ref(false);

        onMounted(() => {
            checkStepNumber();
        });

        const checkStepNumber = () => {
            axiosAdmin.get("app").then((appResponse) => {
                appDetails.value = appResponse.data;

                // For Setting Status
                stepStatus.currencyStepStatus =
                    appDetails.value.total_currencies > 0 ? "finish" : "wait";
                stepStatus.companyWhiteLabelStepStatus = appDetails.value.app
                    .white_label_completed
                    ? "finish"
                    : "wait";
                stepStatus.companySettingStepStatus =
                    companySettingNotSetup() == false ? "finish" : "wait";

                // For Setting Step
                if (appDetails.value.total_currencies == 0) {
                    currentStep.value = 0;
                    correctStep.value = 0;
                    stepStatus.currencyStepStatus = "error";
                } else if (appDetails.value.app.white_label_completed == false) {
                    currentStep.value = 1;
                    correctStep.value = 1;
                    stepStatus.companyWhiteLabelStepStatus = "error";
                } else if (companySettingNotSetup()) {
                    currentStep.value = 2;
                    correctStep.value = 2;
                    stepStatus.companySettingStepStatus = "error";
                } else {
                    currentStep.value = 2;
                    correctStep.value = 2;

                    setupCompleted.value = true;
                    showFinalModal.value = true;
                }
            });
        };

        const companySettingNotSetup = () => {
            return appDetails.value.app.x_currency_id == null ? true : false;
        };

        const addCurrency = () => {
            currencyTableRef.value.addItem();
        };

        const currencyAddSuccess = (details) => {
            checkStepNumber();
        };

        const submitCompanySetting = () => {
            companySettingRef.value.onSubmit();
        };

        const companySettingUpdated = () => {
            showFinalModal.value = true;

            axiosAdmin
                .post(`/user`)
                .then(function (response) {
                    store.commit("auth/updateUser", response.data.user);

                    setupCompleted.value = true;
                })
                .catch(function (error) {});
        };

        const goToDashboard = () => {
            showFinalModal.value = false;

            router.push({
                name: "superadmin.dashboard.index",
            });
        };

        const goBack = () => {
            currentStep.value = currentStep.value == 0 ? 0 : currentStep.value - 1;
        };

        const goNext = () => {
            if (currentStep.value == 1) {
                showConfirmWhiteLabelModal.value = true;
            } else {
                currentStep.value = currentStep.value >= 2 ? 2 : currentStep.value + 1;
            }
        };

        const confirmWhiteLabel = () => {
            axiosAdmin
                .post(`superadmin/white-label-completed`)
                .then(function (response) {
                    store.dispatch("auth/updateApp");

                    showConfirmWhiteLabelModal.value = false;
                    currentStep.value =
                        currentStep.value >= 2 ? 2 : currentStep.value + 1;
                })
                .catch(function (error) {});
        };

        return {
            appDetails,
            currentStep,
            correctStep,
            ...toRefs(stepStatus),

            currencyTableRef,
            addCurrency,
            currencyAddSuccess,
            companySettingRef,
            submitCompanySetting,
            companySettingUpdated,
            showFinalModal,
            setupCompleted,
            goToDashboard,
            companyWhiteLableRef,

            goBack,
            goNext,

            showConfirmWhiteLabelModal,
            confirmWhiteLabel,
        };
    },
});
</script>

<style></style>
