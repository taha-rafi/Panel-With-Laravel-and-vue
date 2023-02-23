<template>
    <a-card class="page-content-container">
        <AddEdit
            :addEditType="addEditType"
            :visible="addEditVisible"
            :url="addEditUrl"
            @addEditSuccess="addEditSuccess"
            @closed="onCloseAddEdit"
            :formData="formData"
            :data="viewData"
            :pageTitle="pageTitle"
            :successMessage="successMessage"
        />

        <a-row :gutter="[15, 15]" class="mb-20">
            <a-col :xs="24" :sm="24" :md="12" :lg="8" :xl="8">
                <a-input-group compact>
                    <a-select
                        style="width: 25%"
                        v-model:value="table.searchColumn"
                        :placeholder="$t('common.select_default_text', [''])"
                    >
                        <a-select-option
                            v-for="filterableColumn in filterableColumns"
                            :key="filterableColumn.key"
                        >
                            {{ filterableColumn.value }}
                        </a-select-option>
                    </a-select>
                    <a-input-search
                        style="width: 75%"
                        v-model:value="table.searchString"
                        show-search
                        @change="onTableSearch"
                        @search="onTableSearch"
                        :loading="table.filterLoading"
                    />
                </a-input-group>
            </a-col>
        </a-row>

        <a-row class="mt-20">
            <a-col :span="24">
                <div class="table-responsive">
                    <a-table
                        :row-selection="{
                            selectedRowKeys: table.selectedRowKeys,
                            onChange: onRowSelectChange,
                        }"
                        :columns="columns"
                        :row-key="(record) => record.xid"
                        :data-source="table.data"
                        :pagination="table.pagination"
                        :loading="table.loading || loading"
                        @change="handleTableChange"
                    >
                        <template #bodyCell="{ column, record }">
                            <template v-if="column.dataIndex === 'name'">
                                <a-list-item>
                                    <a-list-item-meta>
                                        <template #title>
                                            {{ record.name }}
                                        </template>
                                        <template #avatar>
                                            <a-avatar
                                                shape="square"
                                                size="small"
                                                :src="record.image_url"
                                            />
                                        </template>
                                    </a-list-item-meta>
                                </a-list-item>
                            </template>
                            <template v-if="column.dataIndex === 'enabled'">
                                <a-switch
                                    v-model:checked="record.enabled"
                                    :checkedValue="1"
                                    :unCheckedValue="0"
                                    @change="changeLangStatus(record)"
                                    size="small"
                                    :disabled="
                                        (panelType == 'admin' &&
                                            !(
                                                permsArray.includes(
                                                    'translations_edit'
                                                ) ||
                                                permsArray.includes('admin')
                                            )) ||
                                        record.key == 'en'
                                            ? true
                                            : false
                                    "
                                />
                            </template>
                            <template v-if="column.dataIndex === 'action'">
                                <a-button
                                    v-if="
                                        ((panelType == 'admin' &&
                                            (permsArray.includes(
                                                'translations_edit'
                                            ) ||
                                                permsArray.includes(
                                                    'admin'
                                                ))) ||
                                            panelType == 'superadmin') &&
                                        record.key != 'en'
                                    "
                                    type="primary"
                                    @click="editItem(record)"
                                    style="margin-left: 4px"
                                >
                                    <template #icon><EditOutlined /></template>
                                </a-button>
                                <a-button
                                    v-if="
                                        ((panelType == 'admin' &&
                                            (permsArray.includes(
                                                'translations_delete'
                                            ) ||
                                                permsArray.includes(
                                                    'admin'
                                                ))) ||
                                            panelType == 'superadmin') &&
                                        record.key != 'en'
                                    "
                                    type="primary"
                                    @click="showDeleteConfirm(record.xid)"
                                    style="margin-left: 4px"
                                >
                                    <template #icon
                                        ><DeleteOutlined
                                    /></template>
                                </a-button>
                                <a-typography-link
                                    :href="`${downloadLangCsvUrl}/${record.xid}`"
                                    target="_blank"
                                >
                                    <a-button
                                        type="primary"
                                        style="margin-left: 4px"
                                    >
                                        <template #icon
                                            ><DownloadOutlined
                                        /></template>
                                    </a-button>
                                </a-typography-link>
                            </template>
                        </template>
                    </a-table>
                </div>
            </a-col>
        </a-row>
    </a-card>
</template>

<script>
import { onMounted } from "vue";
import {
    EditOutlined,
    DeleteOutlined,
    DownloadOutlined,
} from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import crud from "../../../../../../common/composable/crud";
import common from "../../../../../../common/composable/common";
import apiAdmin from "../../../../../../common/composable/apiAdmin";
import fields from "./fields";
import AddEdit from "./AddEdit.vue";
import { getUrlByAppType } from "../../../../../../common/scripts/functions";

export default {
    props: {
        panelType: {
            type: String,
            default: "admin",
        },
    },
    components: {
        EditOutlined,
        DeleteOutlined,
        DownloadOutlined,
        AddEdit,
    },
    setup() {
        const { addEditRequestAdmin, loading } = apiAdmin();
        const { permsArray, downloadLangCsvUrl } = common();
        const { url, addEditUrl, initData, columns, filterableColumns } =
            fields();
        const crudVariables = crud();
        const { t } = useI18n();

        onMounted(() => {
            crudVariables.tableUrl.value = {
                url,
            };
            crudVariables.table.filterableColumns = filterableColumns;

            crudVariables.fetch({
                page: 1,
            });

            crudVariables.crudUrl.value = addEditUrl;
            crudVariables.langKey.value = "langs";
            crudVariables.initData.value = { ...initData };
            crudVariables.formData.value = { ...initData };
        });

        const changeLangStatus = (recordData) => {
            addEditRequestAdmin({
                url: getUrlByAppType(`langs/${recordData.xid}`),
                data: {
                    name: recordData.name,
                    key: recordData.key,
                    enabled: recordData.enabled,
                    _method: "PUT",
                },
                successMessage: t("langs.status_updated"),
                success: (res) => {},
            });
        };

        return {
            permsArray,
            downloadLangCsvUrl,
            columns,
            ...crudVariables,
            filterableColumns,
            changeLangStatus,
            loading,
        };
    },
};
</script>
