import { useI18n } from "vue-i18n";

const fields = () => {
    const { t } = useI18n();
    const url = "superadmin/writer-templates?fields=id,xid,name,form_fields,prompt_text,status,logo,logo_url,description,writer_category_id,x_writer_category_id";
    const addEditUrl = "superadmin/writer-templates";
    const hashableColumns = ['created_by', 'updated_by', 'writer_category_id'];

    const initData = {
        name: "",
        logo: undefined,
        logo_url: undefined,
        description: "",
        status: 1,
        form_fields: [],
        prompt_text: ""
    };

    const columns = [
        {
            title: t("writer_template.logo"),
            dataIndex: "logo",
        },
        {
            title: t("writer_template.name"),
            dataIndex: "name",
        },
        {
            title: t("writer_template.form_fields"),
            dataIndex: "form_fields",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "name",
            value: t("writer_template.name")
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
