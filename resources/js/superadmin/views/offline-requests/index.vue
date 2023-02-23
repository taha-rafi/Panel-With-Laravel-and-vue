<template>
    <SuperAdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.offline_requests`)" class="p-0" />
        </template>
        <template #breadcrumb>
            <a-breadcrumb separator="-" style="font-size: 12px">
                <a-breadcrumb-item>
                    <router-link :to="{ name: 'admin.dashboard.index' }">
                        {{ $t(`menu.dashboard`) }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t(`menu.offline_requests`) }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </SuperAdminPageHeader>

    <a-card class="page-content-container">
        <a-row>
            <a-col :span="24">
                <a-tabs v-model:activeKey="filters.status" @change="setUrlData">
                    <a-tab-pane key="pending">
                        <template #tab>
                            <span>
                                <ClockCircleOutlined />
                                {{ $t("offline_request.pending") }}
                            </span>
                        </template>
                    </a-tab-pane>

                    <a-tab-pane key="approved">
                        <template #tab>
                            <span>
                                <CheckCircleOutlined />
                                {{ $t("offline_request.approved") }}
                            </span>
                        </template>
                    </a-tab-pane>
                    <a-tab-pane key="rejected">
                        <template #tab>
                            <span>
                                <CloseCircleOutlined />
                                {{ $t("offline_request.rejected") }}
                            </span>
                        </template>
                    </a-tab-pane>
                </a-tabs>
            </a-col>
        </a-row>

        <a-row class="mb-20">
            <a-input-group>
                <a-row :gutter="[15, 15]">
                    <a-col :xs="24" :sm="24" :md="8" :lg="6" :xl="4">
                        <a-select
                            v-model:value="filters.company_id"
                            :placeholder="
                                $t('common.select_default_text', [
                                    $t('offline_request.company'),
                                ])
                            "
                            :allowClear="true"
                            style="width: 100%"
                            optionFilterProp="title"
                            show-search
                            @change="setUrlData"
                        >
                            <a-select-option
                                v-for="allCompanies in companies"
                                :key="allCompanies.xid"
                                :title="allCompanies.name"
                                :value="allCompanies.xid"
                            >
                                {{ allCompanies.name }}
                            </a-select-option>
                        </a-select>
                    </a-col>
                    <a-col :xs="24" :sm="24" :md="8" :lg="6" :xl="4">
                        <a-select
                            v-model:value="filters.subscription_plan_id"
                            :placeholder="
                                $t('common.select_default_text', [
                                    $t('offline_request.subscription_plan'),
                                ])
                            "
                            :allowClear="true"
                            style="width: 100%"
                            optionFilterProp="title"
                            show-search
                            @change="setUrlData"
                        >
                            <a-select-option
                                v-for="allSubscriptionPlans in subscriptionPlans"
                                :key="allSubscriptionPlans.xid"
                                :title="allSubscriptionPlans.name"
                                :value="allSubscriptionPlans.xid"
                            >
                                {{ allSubscriptionPlans.name }}
                            </a-select-option>
                        </a-select>
                    </a-col>
                    <a-col :xs="24" :sm="24" :md="8" :lg="6" :xl="4">
                        <a-select
                            v-model:value="filters.offline_payment_mode_id"
                            :placeholder="
                                $t('common.select_default_text', [
                                    $t('offline_request.payment_mode'),
                                ])
                            "
                            :allowClear="true"
                            style="width: 100%"
                            optionFilterProp="title"
                            show-search
                            @change="setUrlData"
                        >
                            <a-select-option
                                v-for="allpaymentModes in paymentModes"
                                :key="allpaymentModes.xid"
                                :title="allpaymentModes.name"
                                :value="allpaymentModes.xid"
                            >
                                {{ allpaymentModes.name }}
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
                        bordered
                    >
                        <template #bodyCell="{ column, record }">
                            <template v-if="column.dataIndex === 'company'">
                                {{
                                    record.company && record.company.name
                                        ? record.company.name
                                        : "-"
                                }}
                            </template>

                            <template v-if="column.dataIndex === 'submitted_on'">
                                {{ formatDateTime(record.created_at) }}
                            </template>

                            <template v-if="column.dataIndex === 'subscription_plan'">
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

                            <template v-if="column.dataIndex === 'payment_method'">
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
                                <a-space>
                                    <a-tooltip
                                        :title="$t('offline_request.view_proof_document')"
                                    >
                                        <a
                                            :href="record.proof_document_url"
                                            target="_blank"
                                        >
                                            <a-button type="primary">
                                                <template #icon><EyeOutlined /></template>
                                            </a-button>
                                        </a>
                                    </a-tooltip>
                                    <ApproveRequest
                                        v-if="record.status == 'pending'"
                                        :offlineRequest="record"
                                        @success="setUrlData"
                                    />
                                    <RejectRequest
                                        v-if="record.status == 'pending'"
                                        :offlineRequest="record"
                                        @success="setUrlData"
                                    />
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
import { onMounted, ref } from "vue";
import {
    ClockCircleOutlined,
    CloseCircleOutlined,
    CheckCircleOutlined,
    EyeOutlined,
} from "@ant-design/icons-vue";
import fields from "./fields";
import datatable from "../../../common/composable/datatable";
import common from "../../../common/composable/common";
import SuperAdminPageHeader from "../../layouts/SuperAdminPageHeader.vue";
import OfflineRequestStatus from "../admin/offline-requests/OfflineRequestStatus.vue";
import ApproveRequest from "./ApproveRequest.vue";
import RejectRequest from "./RejectRequest.vue";

export default {
    components: {
        SuperAdminPageHeader,
        OfflineRequestStatus,
        ApproveRequest,
        RejectRequest,

        ClockCircleOutlined,
        CloseCircleOutlined,
        CheckCircleOutlined,
        EyeOutlined,
    },
    setup() {
        const { formatDateTime } = common();
        const { url, columns, filterableColumns, hashableColumns } = fields();
        const {
            table,
            tableUrl,
            fetch,
            handleTableChange,
            onTableSearch,
            hashable,
        } = datatable();
        const filters = ref({
            status: "pending",
            company_id: undefined,
            subscription_plan_id: undefined,
            offline_payment_mode_id: undefined,
        });
        const companies = ref([]);
        const subscriptionPlans = ref([]);
        const paymentModes = ref([]);

        onMounted(() => {
            getInitialData();
            setUrlData();
        });

        const getInitialData = () => {
            const companiesPromise = axiosAdmin.get(
                "superadmin/companies?fields=id,xid,name&limit=10000"
            );
            const subscriptionPlansPromise = axiosAdmin.get(
                "superadmin/subscription-plans?fields=id,xid,name&limit=10000"
            );
            const paymentModesPromise = axiosAdmin.get(
                "superadmin/offline-payment-modes?fields=id,xid,name&limit=10000"
            );

            Promise.all([
                companiesPromise,
                subscriptionPlansPromise,
                paymentModesPromise,
            ]).then(
                ([
                    companiesResponse,
                    subscriptionPlansResponse,
                    paymentModesResponse,
                ]) => {
                    companies.value = companiesResponse.data;
                    subscriptionPlans.value = subscriptionPlansResponse.data;
                    paymentModes.value = paymentModesResponse.data;
                }
            );
        };

        const setUrlData = () => {
            tableUrl.value = { url, filters };
            table.filterableColumns = filterableColumns;
            hashable.value = [...hashableColumns];

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
            formatDateTime,
            filters,
            setUrlData,

            companies,
            subscriptionPlans,
            paymentModes,
        };
    },
};
</script>
