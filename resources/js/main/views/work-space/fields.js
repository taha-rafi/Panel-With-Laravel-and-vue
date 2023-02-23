import { useI18n } from "vue-i18n";

const fields = () => {
    const { t } = useI18n();
    const url = "work-spaces?fields=id,xid,name";
    const addEditUrl = "work-spaces";
    const hashableColumns = [];

    const initData = {
        name: "",
    };

    const columns = [
        {
            title: t("work_space.name"),
            dataIndex: "name",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "name",
            value: t("work_space.name")
        },
    ];

    return {
        url,
        initData,
        columns,
        filterableColumns,
        addEditUrl,
        hashableColumns
    }
}

export default fields;
