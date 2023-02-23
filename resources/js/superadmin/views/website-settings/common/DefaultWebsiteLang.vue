<template>
    <a-drawer
        :title="pageTitle"
        :width="drawerWidth"
        :visible="visible"
        :body-style="{ paddingBottom: '80px' }"
        :footer-style="{ textAlign: 'right' }"
        :maskClosable="false"
        @close="onClose"
    >
        <a-form layout="vertical">
            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="12" :lg="12">
                    <a-form-item
                        :label="$t('company.default_timezone')"
                        name="timezone"
                        :help="rules.timezone ? rules.timezone.message : null"
                        :validateStatus="rules.timezone ? 'error' : null"
                        class="required"
                    >
                        <a-select
                            v-model:value="formData.timezone"
                            :placeholder="
                                $t('common.select_default_text', [
                                    $t('company.default_timezone'),
                                ])
                            "
                            optionFilterProp="value"
                            show-search
                        >
                            <a-select-option
                                v-for="(timezoneValue, timezoneKey) in timezones"
                                :key="timezoneKey"
                                :value="timezoneValue"
                            >
                                {{ timezoneValue }}
                            </a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
            </a-row>
        </a-form>
        <template #footer>
            <a-space>
                <a-button
                    key="submit"
                    type="primary"
                    :loading="loading"
                    @click="onSubmit"
                >
                    <template #icon>
                        <SaveOutlined />
                    </template>
                    {{ $t("common.update") }}
                </a-button>
                <a-button key="back" @click="onClose">
                    {{ $t("common.cancel") }}
                </a-button>
            </a-space>
        </template>
    </a-drawer>
</template>

<script>
import { onMounted, ref, watch } from "vue";
import { SaveOutlined } from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import apiAdmin from "../../../../common/composable/apiAdmin";

export default {
    components: {
        SaveOutlined,
    },
    setup() {
        const { addEditRequestAdmin, loading, rules } = apiAdmin();
        const { t } = useI18n();
        const formData = ref({});

        const allLangsUrl = "all-langs";
        const websiteLangUrl = "superadmin/global-company/website-lang";
        const allLangs = ref([]);

        onMounted(() => {
            const allLangsUrlPromise = axiosAdmin.get(allLangsUrl);
            const websiteLangUrlPromise = axiosAdmin.get(websiteLangUrl);

            Promise.all([allLangsUrlPromise, websiteLangUrlPromise]).then(
                ([allLangsUrlResponse, websiteLangUrlResponse]) => {
                    allLangs.value = allLangsUrlResponse.data;

                    formData.value = {
                        website_lang_id: websiteLangUrlResponse.data.lang.xid,
                    };
                }
            );
        });

        const onSubmit = () => {
            // addEditRequestAdmin({
            //     url: `superadmin/global-company/${company.xid}`,
            //     data: formData.value,
            //     successMessage: t("company.updated"),
            //     success: (res) => {},
            // });
        };

        return {
            formData,
            loading,
            rules,
            allLangs,
            onSubmit,

            drawerWidth: window.innerWidth <= 991 ? "90%" : "45%",
        };
    },
};
</script>
