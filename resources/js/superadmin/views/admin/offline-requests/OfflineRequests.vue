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
                <a-alert
                    v-if="userComesFromSubscriptionPage"
                    class="mb-20"
                    :message="$t('offline_request.created')"
                    :description="$t('offline_request.created_message')"
                    type="success"
                    show-icon
                    closable
                >
                    <template #icon>
                        <CheckCircleOutlined />
                    </template>
                </a-alert>

                <a-row class="mb-20">
                    <a-input-group>
                        <a-row :gutter="[15, 15]">
                            <a-col :xs="24" :sm="24" :md="12" :lg="12" :xl="6">
                                <a-select
                                    v-model:value="filters.status"
                                    :placeholder="
                                        $t('common.select_default_text', [
                                            $t('offline_request.status'),
                                        ])
                                    "
                                    :allowClear="true"
                                    style="width: 100%"
                                    @change="setUrlData"
                                >
                                    <a-select-option key="pending" value="pending">
                                        {{ $t("offline_request.pending") }}
                                    </a-select-option>
                                    <a-select-option key="approved" value="approved">
                                        {{ $t("offline_request.approved") }}
                                    </a-select-option>
                                    <a-select-option key="rejected" value="rejected">
                                        {{ $t("offline_request.rejected") }}
                                    </a-select-option>
                                </a-select>
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
                                    <template v-if="column.dataIndex === 'submitted_on'">
                                        {{ formatDateTime(record.created_at) }}
                                    </template>

                                    <template
                                        v-if="column.dataIndex === 'subscription_plan'"
                                    >
                                        {{
                                            record.subscription_plan &&
                                            record.subscription_plan.name
                                                ? record.subscription_plan.name
                                                : "-"
                                        }}
                                    </template>

                                    <template v-if="column.dataIndex === 'plan_type'">
                                        {{ $t(`subscription_plans.${record.plan_type}`) }}
                                    </template>

                                    <template
                                        v-if="column.dataIndex === 'payment_method'"
                                    >
                                        {{
                                            record.offline_payment_mode &&
                                            record.offline_payment_mode.name
                                                ? record.offline_payment_mode.name
                                                : "-"
                                        }}
                                    </template>

                                    <template v-if="column.dataIndex === 'submitted_by'">
                                        {{
                                            record.submittor && record.submittor.name
                                                ? record.submittor.name
                                                : "-"
                                        }}
                                    </template>

                                    <template v-if="column.dataIndex === 'status'">
                                        <OfflineRequestStatus :status="record.status" />
                                    </template>

                                    <template v-if="column.dataIndex === 'action'">
                                        <a-typography-link
                                            :href="record.proof_document_url"
                                            target="_blank"
                                        >
                                            {{ $t("common.view") }}
                                        </a-typography-link>
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
import { onMounted, ref } from "vue";
import { FormOutlined, CheckCircleOutlined } from "@ant-design/icons-vue";
import AdminPageHeader from "../../../../common/layouts/AdminPageHeader.vue";
import fields from "./fields";
import datatable from "../../../../common/composable/datatable";
import common from "../../../../common/composable/common";
import OfflineRequestStatus from "./OfflineRequestStatus.vue";

export default {
    components: {
        FormOutlined,
        CheckCircleOutlined,

        AdminPageHeader,
        OfflineRequestStatus,
    },
    setup(props) {
        const { formatDateTime } = common();
        const { url, columns, filterableColumns } = fields();
        const { table, tableUrl, fetch, handleTableChange, onTableSearch } = datatable();
        const userComesFromSubscriptionPage = ref(false);
        const filters = ref({
            status: undefined,
        });

        onMounted(() => {
            // Checking if on this page
            // user comes direcly or from subscription page
            if (history && history.state && history.state.success) {
                userComesFromSubscriptionPage.value = true;

                // Changing history state success to false
                history.state.success = false;
            }

            setUrlData();
        });

        const setUrlData = () => {
            tableUrl.value = { url, filters };
            table.filterableColumns = filterableColumns;

            fetch({
                page: 1,
            });
        };

        return {
            formatDateTime,
            table,
            handleTableChange,
            onTableSearch,
            columns,
            filters,
            setUrlData,
            filterableColumns,
            userComesFromSubscriptionPage,
        };
    },
};
</script>
