<template>
    <AdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.transcations`)" style="padding: 0px">
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
                    {{ $t("menu.transcations") }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </AdminPageHeader>

    <a-row>
        <a-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
            <a-card class="page-content-container">
                <a-row class="mb-20">
                    <a-input-group>
                        <a-row :gutter="[15, 15]">
                            <a-col :xs="24" :sm="24" :md="12" :lg="12" :xl="6">
                                <a-input-group compact>
                                    <a-select
                                        style="width: 25%"
                                        v-model:value="table.searchColumn"
                                        :placeholder="
                                            $t('common.select_default_text', [''])
                                        "
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
                            >
                                <template #bodyCell="{ column, record }">
                                    <template v-if="column.dataIndex === 'paid_on'">
                                        {{ formatDate(record.paid_on) }}
                                    </template>

                                    <template
                                        v-if="column.dataIndex === 'next_payment_date'"
                                    >
                                        {{ formatDate(record.next_payment_date) }}
                                    </template>

                                    <template v-if="column.dataIndex === 'plan'">
                                        {{ record.subscription_plan.name }}
                                    </template>

                                    <template v-if="column.dataIndex === 'action'">
                                        -
                                    </template>
                                </template>
                            </a-table>
                        </div>
                    </a-col>
                </a-row>
            </a-card>
        </a-col>
    </a-row>
</template>

<script>
import { onMounted } from "vue";
import { FormOutlined } from "@ant-design/icons-vue";
import AdminPageHeader from "../../../common/layouts/AdminPageHeader.vue";
import fields from "./fields";
import datatable from "../../../common/composable/datatable";
import common from "../../../common/composable/common";

export default {
    components: {
        FormOutlined,
        AdminPageHeader,
    },
    setup() {
        const { formatDate } = common();
        const { url, columns, filterableColumns } = fields();
        const { table, tableUrl, fetch, handleTableChange, onTableSearch } = datatable();

        onMounted(() => {
            setUrlData();
        });

        const setUrlData = () => {
            tableUrl.value = { url };
            table.filterableColumns = filterableColumns;

            fetch({
                page: 1,
            });
        };

        return {
            table,
            handleTableChange,
            onTableSearch,
            columns,
            filterableColumns,

            formatDate,
        };
    },
};
</script>
