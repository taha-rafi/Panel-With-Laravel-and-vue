<template>
    <a-card class="page-content-container">
        <a-row class="mt-20">
            <a-col :span="24">
                <a-alert
                    type="warning"
                    showIcon
                    :message="$t('database_backup.backup_locaion_is')"
                />

                <div class="table-responsive mt-20">
                    <a-table
                        :columns="columns"
                        :row-key="(record) => record.id"
                        :data-source="results"
                        :pagination="false"
                    >
                        <template #bodyCell="{ column, record }">
                            <template v-if="column.dataIndex == 'action'">
                                <a-space>
                                    <a-typography-link :href="record.url" target="_blank">
                                        {{ $t("common.download") }}
                                    </a-typography-link>
                                    <a-button
                                        type="link"
                                        @click="deleteBackup(record.name)"
                                    >
                                        {{ $t("common.delete") }}
                                    </a-button>
                                </a-space>
                            </template>
                        </template>
                    </a-table>
                </div>
            </a-col>
        </a-row>
    </a-card>
</template>

<script>
import { onMounted, ref, createVNode } from "vue";
import {
    PlusOutlined,
    EditOutlined,
    DeleteOutlined,
    ExclamationCircleOutlined,
} from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import { Modal } from "ant-design-vue";
import { getUrlByAppType } from "../../../../../common/scripts/functions";
import fields from "./fields";

export default {
    components: {
        PlusOutlined,
        EditOutlined,
        DeleteOutlined,
        ExclamationCircleOutlined,
    },
    setup() {
        const { t } = useI18n();
        const { url, columns } = fields();
        const results = ref([]);

        onMounted(() => {
            axiosAdmin.post(getUrlByAppType("database-backups")).then((response) => {
                results.value = response.data.data;
            });
        });

        const backupCreated = (response) => {
            results.value = response.data;
        };

        const deleteBackup = (fileName) => {
            Modal.confirm({
                title: t("database_backup.delete_backup"),
                icon: createVNode(ExclamationCircleOutlined),
                content: t("database_backup.are_you_sure_delete_backup"),
                okText: t("common.yes"),
                okType: "danger",
                cancelText: t("common.no"),
                onOk() {
                    axiosAdmin
                        .post(getUrlByAppType("delete-backup"), { file_name: fileName })
                        .then((response) => {
                            results.value = response.data.data;
                        });
                },
                onCancel() {},
            });
        };

        return {
            columns,
            results,
            deleteBackup,
            backupCreated,
        };
    },
};
</script>
