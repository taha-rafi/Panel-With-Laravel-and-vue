import { onMounted, ref, createVNode, watch } from "vue";
import { ExclamationCircleOutlined } from "@ant-design/icons-vue";
import { Modal, message } from "ant-design-vue";
import { useI18n } from "vue-i18n";
import { forEach, filter } from "lodash-es";
import apiAdmin from "../../common/composable/apiAdmin";

const landingWebsiteSetting = (props) => {
    const { addEditRequestAdmin, loading, rules } = apiAdmin();
    const { t } = useI18n();
    const columns = ref([]);
    const tableData = ref([]);
    const addEditTitle = ref("");
    const visible = ref(false);
    const deletable = ref(true);
    const addable = ref(true);
    const formData = ref({});
    const addEditType = ref("add");
    const settingType = ref("");
    const langType = ref("");
    const initData = ref({});

    const getData = (langKey) => {
        axiosAdmin
            .get(`superadmin/website-settings/settings?lang_key=${langKey}&setting_type=${settingType.value}`)
            .then((response) => {
                tableData.value = response.data.data;
            });
    };

    const showAdd = () => {
        if (!addable.value) {
            message.error(t('common.not_allowed'));
        } else {
            visible.value = true;
            rules.value = {};
            addEditType.value = "add";
            addEditTitle.value = t(`website_settings.add_${langType.value}`);

            formData.value = { ...initData.value, id: Math.random().toString(36).slice(2) };
        }
    };

    const onSubmit = () => {
        rules.value = {};

        if (addEditType.value == "add") {
            var submitData = [formData.value, ...tableData.value];
        } else {
            var submitData = [];
            forEach(tableData.value, (currentData) => {
                if (currentData.id == formData.value.id) {
                    submitData.push(formData.value);
                } else {
                    submitData.push(currentData);
                }
            });
        }

        addEditRequestAdmin({
            url: `superadmin/website-settings/settings/update`,
            data: {
                lang_key: props.langKey,
                request_type: "add_edit",
                setting_type: settingType.value,
                form_data: { lang_key: props.langKey, ...formData.value },
                all_form_data: submitData,
            },
            successMessage:
                addEditType.value == "edit"
                    ? t(`website_settings.${langType.value}_updated`)
                    : t(`website_settings.${langType.value}_created`),
            success: (res) => {
                tableData.value = submitData;
                visible.value = false;
            },
        });
    };

    const editItem = (record) => {
        rules.value = {};

        visible.value = true;
        rules.value = {};
        addEditType.value = "edit";
        addEditTitle.value = t(`website_settings.edit_${langType.value}`);

        formData.value = {
            ...record,
        };
    };

    const showDeleteConfirm = (record) => {

        if (!deletable.value) {
            message.error(t('common.not_allowed'));
        } else {
            Modal.confirm({
                title: t("common.delete") + "?",
                icon: createVNode(ExclamationCircleOutlined),
                content: t(`website_settings.${langType.value}_delete_message`),
                centered: true,
                okText: t("common.yes"),
                okType: "danger",
                cancelText: t("common.no"),
                onOk() {
                    var submitData = filter(tableData.value, (currentData) => {
                        return currentData.id != record.id;
                    });

                    addEditRequestAdmin({
                        url: `superadmin/website-settings/settings/update`,
                        data: {
                            lang_key: props.langKey,
                            request_type: "delete",
                            setting_type: settingType.value,
                            form_data: {},
                            all_form_data: submitData,
                        },
                        successMessage: t(`website_settings.${langType.value}_deleted`),
                        success: (res) => {
                            tableData.value = submitData;
                        },
                    });
                },
                onCancel() { },
            });
        }


    };

    const onClose = () => {
        visible.value = false;
        rules.value = {};
        formData.value = { ...initData.value };
    };

    watch(
        () => props.langKey,
        (newVal, oldVal) => {
            getData(newVal);
        }
    );

    return {
        loading,
        rules,

        initData,
        columns,
        tableData,
        settingType,
        langType,
        getData,

        showAdd,
        visible,
        addable,
        deletable,
        addEditType,
        addEditTitle,
        formData,
        onSubmit,
        onClose,
        editItem,
        showDeleteConfirm,
    };
}

export default landingWebsiteSetting;
