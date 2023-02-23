import { useI18n } from "vue-i18n";

const fields = () => {
    const url = "superadmin/users?fields=id,xid,name,email,phone,profile_image,profile_image_url,status";
    const addEditUrl = "superadmin/users";
    const { t } = useI18n();

    const initData = {
        name: "",
        email: "",
        phone: "",
        address: "",
        profile_image: undefined,
        profile_image_url: undefined,
        status: "enabled",
    };

    const columns = [
        {
            title: t("user.name"),
            dataIndex: "name",
        },
        {
            title: t("user.email"),
            dataIndex: "email",
        },
        {
            title: t("common.status"),
            dataIndex: "status",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "name",
            value: t("user.name")
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
