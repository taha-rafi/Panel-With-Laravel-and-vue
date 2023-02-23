<template>
    <a-typography-paragraph class="mt-40">
        <blockquote>
            <a-typography-text type="warning" strong>
                {{ $t("setup_superadmin_company.white_label_update_details") }}
            </a-typography-text>
        </blockquote>
    </a-typography-paragraph>

    <a-alert
        class="mt-20"
        :message="$t('setup_superadmin_company.hard_reload_message')"
        type="warning"
        show-icon
    />

    <a-form layout="vertical">
        <div class="mt-40">
            <FormItemHeading>
                {{ $t("setup_superadmin_company.default_company_logo") }}
            </FormItemHeading>
        </div>

        <a-row :gutter="16" class="mb-40" v-if="formData && formData.dark_logo">
            <a-col :xs="24" :sm="24" :md="6" :lg="6">
                <a-form-item :label="$t('company.dark_logo')" name="dark_logo">
                    <Upload
                        :formData="formData"
                        folder="company"
                        imageField="dark_logo"
                        @onFileUploaded="
                            (file) => {
                                formData.dark_logo = file.file;
                                formData.dark_logo_url = file.file_url;
                            }
                        "
                    />
                </a-form-item>
            </a-col>
            <a-col :xs="24" :sm="24" :md="6" :lg="6">
                <a-form-item :label="$t('company.light_logo')" name="light_logo">
                    <Upload
                        :formData="formData"
                        folder="company"
                        imageField="light_logo"
                        @onFileUploaded="
                            (file) => {
                                formData.light_logo = file.file;
                                formData.light_logo_url = file.file_url;
                            }
                        "
                    />
                </a-form-item>
            </a-col>
            <a-col :xs="24" :sm="24" :md="6" :lg="6">
                <a-form-item
                    :label="$t('company.small_dark_logo')"
                    name="small_dark_logo"
                >
                    <Upload
                        :formData="formData"
                        folder="company"
                        imageField="small_dark_logo"
                        @onFileUploaded="
                            (file) => {
                                formData.small_dark_logo = file.file;
                                formData.small_dark_logo_url = file.file_url;
                            }
                        "
                    />
                </a-form-item>
            </a-col>
            <a-col :xs="24" :sm="24" :md="6" :lg="6">
                <a-form-item
                    :label="$t('company.small_light_logo')"
                    name="small_light_logo"
                >
                    <Upload
                        :formData="formData"
                        folder="company"
                        imageField="small_light_logo"
                        @onFileUploaded="
                            (file) => {
                                formData.small_light_logo = file.file;
                                formData.small_light_logo_url = file.file_url;
                            }
                        "
                    />
                </a-form-item>
            </a-col>
        </a-row>
    </a-form>
</template>

<script>
import { onMounted, ref } from "vue";
import Upload from "./white-label/Upload.vue";
import FormItemHeading from "../../common/components/common/typography/FormItemHeading.vue";

export default {
    components: {
        Upload,
        FormItemHeading,
    },
    setup() {
        const formData = ref({});

        onMounted(() => {
            axiosAdmin.get("superadmin/default-logo-details").then((response) => {
                var responseData = response.data;

                formData.value = {
                    dark_logo: responseData.dark_logo,
                    dark_logo_url: responseData.dark_logo_url,
                    light_logo: responseData.light_logo,
                    light_logo_url: responseData.light_logo_url,
                    small_dark_logo: responseData.small_dark_logo,
                    small_light_logo: responseData.small_light_logo,
                    small_dark_logo_url: responseData.small_dark_logo_url,
                    small_light_logo_url: responseData.small_light_logo_url,
                };
            });
        });

        return {
            formData,
        };
    },
};
</script>
