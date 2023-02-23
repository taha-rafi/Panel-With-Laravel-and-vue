import { useI18n } from "vue-i18n";

const fields = () => {
    const url = "superadmin/offline-payment-modes?fields=id,xid,name,description";
    const addEditUrl = "superadmin/offline-payment-modes";
    const { t } = useI18n();

    const initData = {
        name: "",
        description: "",
    };

    const columns = [
        {
            title: t("offline_payment_mode.name"),
            dataIndex: "name",
        },
        {
            title: t("offline_payment_mode.description"),
            dataIndex: "description",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "name",
            value: t("offline_payment_mode.name")
        },
    ];

    return {
        url,
        addEditUrl,
        initData,
        columns,
        filterableColumns,
    }
}

export default fields;
