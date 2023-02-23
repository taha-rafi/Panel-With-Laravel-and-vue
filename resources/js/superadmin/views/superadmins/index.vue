<template>
    <SuperAdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.superadmins`)" class="p-0">
                <template #extra>
                    <a-button type="primary" @click="addItem">
                        <PlusOutlined />
                        {{ $t("superadmin.add") }}
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
                    {{ $t(`menu.superadmins`) }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </SuperAdminPageHeader>

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

        <a-row class="mb-20">
            <a-input-group>
                <a-row :gutter="[15, 15]">
                    <a-col :xs="24" :sm="24" :md="12" :lg="12" :xl="6">
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
            </a-input-group>
        </a-row>

        <a-row>
            <a-col :span="24">
                <div class="table-responsive">
                    <a-table
                        :columns="columns"
                        :row-key="(record) => record.xid"
                        :data-source="table.data"
                        :pagination="table.pagination"
                        :loading="table.loading"
                        @change="handleTableChange"
                        bordered
                    >
                        <template #bodyCell="{ column, text, record }">
                            <template v-if="column.dataIndex === 'name'">
                                <a-card-meta
                                    class="superadmin-avatar"
                                    :style="{ marginBottom: '0px' }"
                                >
                                    <template #title>
                                        <a-typography-text strong>
                                            {{ record.name }}
                                        </a-typography-text>
                                    </template>
                                    <template #avatar>
                                        <a-image
                                            :width="'40px'"
                                            :height="'40px'"
                                            :src="record.profile_image_url"
                                        />
                                    </template>
                                    <template #description>
                                        <small>
                                            {{ record.phone }}
                                        </small>
                                    </template>
                                </a-card-meta>
                            </template>
                            <template v-if="column.dataIndex === 'status'">
                                <a-tag :color="statusColors[text]">
                                    {{ $t(`common.${text}`) }}
                                </a-tag>
                            </template>
                            <template v-if="column.dataIndex === 'action'">
                                <a-button
                                    type="primary"
                                    @click="editItem(record)"
                                    style="margin-left: 4px"
                                >
                                    <template #icon><EditOutlined /></template>
                                </a-button>
                                <a-button
                                    v-if="
                                        globalSetting.x_admin_id != record.xid &&
                                        user.xid != record.xid
                                    "
                                    type="primary"
                                    @click="showDeleteConfirm(record.xid)"
                                    style="margin-left: 4px"
                                >
                                    <template #icon><DeleteOutlined /></template>
                                </a-button>
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
import { PlusOutlined, EditOutlined, DeleteOutlined } from "@ant-design/icons-vue";
import fields from "./fields";
import crud from "../../../common/composable/crud";
import common from "../../../common/composable/common";
import AddEdit from "./AddEdit.vue";
import SuperAdminPageHeader from "../../layouts/SuperAdminPageHeader.vue";

export default {
    components: {
        PlusOutlined,
        EditOutlined,
        DeleteOutlined,
        AddEdit,
        SuperAdminPageHeader,
    },
    setup() {
        const { url, addEditUrl, initData, columns, filterableColumns } = fields();
        const crudVariables = crud();
        const { formatDate, statusColors, globalSetting, user } = common();

        onMounted(() => {
            setUrlData();
        });

        const setUrlData = () => {
            crudVariables.tableUrl.value = { url };
            crudVariables.table.filterableColumns = filterableColumns;

            crudVariables.fetch({
                page: 1,
            });

            crudVariables.crudUrl.value = addEditUrl;
            crudVariables.langKey.value = "superadmin";
            crudVariables.initData.value = { ...initData };
            crudVariables.formData.value = { ...initData };
        };

        return {
            statusColors,
            globalSetting,
            user,
            columns,
            filterableColumns,
            ...crudVariables,
            setUrlData,
            formatDate,
        };
    },
};
</script>

<style lang="less">
.superadmin-avatar .ant-card-meta-title {
    margin-bottom: 0px !important;
}
</style>
