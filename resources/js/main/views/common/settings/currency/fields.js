import { useI18n } from "vue-i18n";

const fields = (panelType) => {
    const url = panelType == 'admin'
        ? "currencies?fields=id,xid,name,symbol,position,code"
        : "superadmin/currencies?fields=id,xid,name,symbol,position,code";
    const addEditUrl = panelType == 'admin' ? "currencies" : "superadmin/currencies";
    const { t } = useI18n();

    const initData = {
        name: "",
        symbol: "",
        position: "",
        code: "",
    };

    const columns = [
        {
            title: t("currency.name"),
            dataIndex: "name",
        },
        {
            title: t("currency.symbol"),
            dataIndex: "symbol",
        },
        {
            title: t("currency.position"),
            dataIndex: "position",
        },
        {
            title: t("currency.code"),
            dataIndex: "code",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "name",
            value: t("common.name")
        },
    ];

    return {
        url,
        addEditUrl,
        initData,
        columns,
        filterableColumns
    }
}

export default fields;
