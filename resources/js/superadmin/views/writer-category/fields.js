import { useI18n } from "vue-i18n";

const fields = () => {
    const { t } = useI18n();
    const url = "superadmin/writer-categories?fields=id,xid,name,description,logo,logo_url,created_by,x_created_by,createdBy{id,xid,name},updated_by,x_updated_by,updatedBy{id,xid,name}";
    const addEditUrl = "superadmin/writer-categories";
    const hashableColumns = ['created_by', 'updated_by'];


    const initData = {
        name: "",
        logo: undefined,
        logo_url: undefined,
        description: "",

    };

    const columns = [
        {
            title: t("writer_category.logo"),
            dataIndex: "logo",
        },
        {
            title: t("writer_category.name"),
            dataIndex: "name",
            key: "name",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "name",
            value: t("writer_category.name")
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
