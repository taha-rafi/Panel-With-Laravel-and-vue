import { useI18n } from "vue-i18n";

const fields = () => {
    const url = "superadmin/offline-requests?fields=id,xid,created_at,proof_document,proof_document_url,subscription_plan_id,x_subscription_plan_id,subscriptionPlan{id,xid,name,max_characters},plan_type,offline_payment_mode_id,x_offline_payment_mode_id,offlinePaymentMode{id,xid,name},status,submitted_by_id,x_submitted_by_id,submittor{id,xid,name},company_id,x_company_id,company{id,xid,name}";
    const { t } = useI18n();
    const hashableColumns = ['company_id', 'subscription_plan_id', 'offline_payment_mode_id'];

    const columns = [
        {
            title: t("offline_request.company"),
            dataIndex: "company",
        },
        {
            title: t("offline_request.submitted_by"),
            dataIndex: "submitted_by",
        },
        {
            title: t("offline_request.subscription_plan"),
            dataIndex: "subscription_plan",
        },
        {
            title: t("offline_request.plan_type"),
            dataIndex: "plan_type",
        },
        {
            title: t("offline_request.payment_method"),
            dataIndex: "payment_method",
        },
        {
            title: t("offline_request.submitted_on"),
            dataIndex: "submitted_on",
        },
        {
            title: t("offline_request.status"),
            dataIndex: "status",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [

    ];

    return {
        url,
        columns,
        filterableColumns,
        hashableColumns,
    }
}

export default fields;
