import { useI18n } from "vue-i18n";
import { getUrlByAppType } from "../../../../../../common/scripts/functions";

const fields = () => {
    const url = getUrlByAppType("langs?fields=id,xid,name,image,image_url,key,enabled");
    const addEditUrl = getUrlByAppType("langs");
    const { t } = useI18n();

    const initData = {
        name: "",
        key: "",
        image: undefined,
        image_url: undefined,
        enabled: true,
    };

    const columns = [
        {
            title: t("langs.name"),
            dataIndex: "name",
        },
        {
            title: t("langs.key"),
            dataIndex: "key",
        },
        {
            title: t("langs.enabled"),
            dataIndex: "enabled",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "name",
            value: t("langs.name")
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
