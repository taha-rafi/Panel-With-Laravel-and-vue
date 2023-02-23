<template>
    <a-tooltip :title="$t('offline_request.reject_request')" @click="showModal">
        <a-button type="primary" style="background-color: #f50; border-color: #f50">
            <template #icon>
                <CloseCircleOutlined />
            </template>
        </a-button>
    </a-tooltip>
    <a-modal v-model:visible="visible" :maskClosable="false" :footer="null" centered>
        <a-result>
            <template #title>
                <span :style="{ color: '#7676e3' }">
                    {{ $t("offline_request.are_you_sure_reject_request") }}
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
                        @click="onClose"
                    >
                        {{ $t("common.no") }}
                    </a-button>
                    <a-button
                        type="primary"
                        :style="{ backgroundColor: '#ff4d4f', border: '#ff4d4f' }"
                        @click="onSubmit"
                        :loading="loading"
                    >
                        {{ $t("offline_request.yes_rejected") }}
                    </a-button>
                </a-space>
            </template>
        </a-result>
    </a-modal>
</template>

<script>
import { ref, onMounted } from "vue";
import { CloseCircleOutlined, InfoCircleOutlined } from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import apiAdmin from "../../../common/composable/apiAdmin";
import common from "../../../common/composable/common";

export default {
    props: ["offlineRequest"],
    emits: ["success"],
    components: {
        CloseCircleOutlined,
        InfoCircleOutlined,
    },
    setup(props, { emit }) {
        const { appSetting, dayjsObject } = common();
        const { t } = useI18n();
        const visible = ref(false);
        const { addEditRequestAdmin, loading, rules } = apiAdmin();
        const formData = ref({
            offline_request_id: undefined,
        });

        onMounted(() => {
            formData.value = {
                offline_request_id: props.offlineRequest.xid,
            };
        });

        const showModal = () => {
            visible.value = true;
        };

        const onSubmit = () => {
            addEditRequestAdmin({
                url: `superadmin/offline-requests/reject`,
                data: formData.value,
                successMessage: t("offline_request.request_rejected_successfully"),
                success: (res) => {
                    emit("success", true);
                },
            });
        };

        const onClose = () => {
            rules.value = {};
            visible.value = false;
        };

        return {
            appSetting,
            visible,
            loading,
            rules,
            formData,

            onClose,
            onSubmit,
            showModal,
        };
    },
};
</script>

<style></style>
