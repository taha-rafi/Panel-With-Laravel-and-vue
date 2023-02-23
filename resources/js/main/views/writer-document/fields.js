import { useI18n } from "vue-i18n";

const fields = () => {
    const { t } = useI18n();
    const url = "writer-documents?fields=id,xid,document_name,writer_template_id,x_writer_template_id,writerTemplate{id,xid,name},workspace_id,x_workspace_id,workspace{id,xid,name},created_by,x_created_by,createdBy{id,xid,name},content,character_count,created_at";
    const addEditUrl = "writer-documents";
    const hashableColumns = ['writer_template_id', 'updated_by'];

    const initData = {
        document_name: "",
        content: "",
        workspace_id: undefined
    };

    const columns = [
        {
            title: t("writer_document.document_name"),
            dataIndex: "document_name",
        },
        {
            title: t("writer_document.writer_template"),
            dataIndex: "writer_template_id",
        },
        {
            title: t("writer_document.workspace"),
            dataIndex: "workspace_id",
        },
        {
            title: t("writer_document.character_count"),
            dataIndex: "character_count",
        },
        {
            title: t("common.created_at"),
            dataIndex: "created_at",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "name",
            value: t("writer_document.document_name")
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
