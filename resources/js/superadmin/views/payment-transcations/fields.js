import { useI18n } from "vue-i18n";

const fields = () => {
    const url = "superadmin/payment-transcations?fields=id,xid,paid_on,transcation_id,company_id,x_company_id,company{id,xid,name},next_payment_date,payment_method";
    const { t } = useI18n();

    const columns = [
        {
            title: t("payment_transaction.paid_on"),
            dataIndex: "paid_on",
        },
        {
            title: t("payment_transaction.company"),
            dataIndex: "company",
        },
        {
            title: t("payment_transaction.transcation_id"),
            dataIndex: "transcation_id",
        },
        {
            title: t("payment_transaction.next_payment_date"),
            dataIndex: "next_payment_date",
        },
        {
            title: t("payment_transaction.payment_method"),
            dataIndex: "payment_method",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "transcation_id",
            value: t("payment_transaction.transcation_id")
        },
    ];

    return {
        url,
        columns,
        filterableColumns,
    }
}

export default fields;
