import { computed, ref, onMounted } from "vue";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import apiAdmin from "../../common/composable/apiAdmin";

const landingWebsite = () => {
    const { addEditRequestAdmin, loading, rules } = apiAdmin();
    const { t } = useI18n();
    const formData = ref({});
    const store = useStore();
    const activeKey = ref("en");
    const subTabActiveKey = ref(["basic_text"]);

    onMounted(() => {
        langChanged(activeKey.value);
    });

    const langChanged = (langKey) => {
        axiosAdmin
            .get(`superadmin/website-settings/website?lang_key=${langKey}`)
            .then((response) => {
                const result = response.data.data;
                formData.value = {
                    ...result,
                    lang_key: langKey,
                };
            });
    };

    const onSubmit = () => {
        addEditRequestAdmin({
            url: `superadmin/website-settings/website/update`,
            data: formData.value,
            successMessage: t("website_settings.setting_saved"),
            success: (res) => { },
        });
    };

    return {
        loading,
        rules,
        formData,
        allLangs: computed(() => store.state.auth.allLangs),
        activeKey,
        subTabActiveKey,

        onSubmit,
        langChanged,
    };
}

export default landingWebsite;
