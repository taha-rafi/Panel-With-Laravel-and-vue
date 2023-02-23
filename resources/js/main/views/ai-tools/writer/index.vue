<template>
    <AdminPageHeader>
        <template #header>
            <a-page-header :title="chagedTemplate?.name" class="p-0" />
        </template>
        <template #breadcrumb>
            <a-breadcrumb separator="-" style="font-size: 12px">
                <a-breadcrumb-item>
                    <router-link :to="{ name: 'admin.dashboard.index' }">
                        {{ $t(`menu.dashboard`) }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t(`menu.ai_tools`) }}
                </a-breadcrumb-item>
                <a-breadcrumb-item v-if="chagedTemplate && chagedTemplate.category">
                    <router-link
                        :to="{
                            name: 'admin.ai_tools.index',
                            params: { cat: chagedTemplate.category.xid },
                        }"
                    >
                        {{ chagedTemplate?.category?.name }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ chagedTemplate?.name }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </AdminPageHeader>

    <a-row>
        <a-col :xs="24" :sm="24" :md="24" :lg="8" :xl="8" class="bg-setting-sidebar">
            <div class="setting-sidebar">
                <div style="padding: 10px">
                    <a-form layout="vertical">
                        <a-row :gutter="16">
                            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                <a-form-item
                                    :label="$t('writer.ai_tool')"
                                    name="template_id"
                                    :help="
                                        rules.template_id
                                            ? rules.template_id.message
                                            : null
                                    "
                                    :validateStatus="rules.template_id ? 'error' : null"
                                    class="required"
                                >
                                    <a-select
                                        v-model:value="selectedTemplateId"
                                        :placeholder="
                                            $t('common.select_default_text', [
                                                $t('writer.ai_tool'),
                                            ])
                                        "
                                        @change="templateChanged"
                                    >
                                        <a-select-option
                                            v-for="allTemplate in allTemplates"
                                            :key="allTemplate.xid"
                                            :value="allTemplate.xid"
                                            :templateValue="allTemplate"
                                        >
                                            {{ allTemplate.name }}
                                        </a-select-option>
                                    </a-select>
                                </a-form-item>
                            </a-col>
                        </a-row>

                        <a-row
                            :gutter="[16, 16]"
                            v-for="templateField in templateFields"
                            :key="templateField.name"
                        >
                            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                <a-form-item
                                    :label="templateField.name"
                                    name="name"
                                    :help="
                                        rules[templateField.slug]
                                            ? rules[templateField.slug]['message']
                                            : null
                                    "
                                    :validateStatus="
                                        rules[templateField.slug] ? 'error' : null
                                    "
                                    class="required"
                                >
                                    <a-input
                                        v-if="templateField.type == 'text'"
                                        v-model:value="templateField.value"
                                        :placeholder="templateField.description"
                                    />
                                    <a-textarea
                                        v-else
                                        v-model:value="templateField.value"
                                        :placeholder="templateField.description"
                                    />
                                </a-form-item>
                            </a-col>
                        </a-row>

                        <a-row :gutter="16">
                            <a-col :xs="24" :sm="24" :md="12" :lg="12">
                                <a-form-item
                                    :label="$t('writer.content_quality')"
                                    name="content_quality"
                                    :help="
                                        rules.content_quality
                                            ? rules.content_quality.message
                                            : null
                                    "
                                    :validateStatus="
                                        rules.content_quality ? 'error' : null
                                    "
                                    class="required"
                                >
                                    <a-select
                                        v-model:value="contentQuality"
                                        :placeholder="
                                            $t('common.select_default_text', [
                                                $t('writer.ai_tool'),
                                            ])
                                        "
                                    >
                                        <a-select-option :value="0.1">
                                            {{ $t("common.low") }}
                                        </a-select-option>
                                        <a-select-option :value="0.3">
                                            {{ $t("common.average") }}
                                        </a-select-option>
                                        <a-select-option :value="0.5">
                                            {{ $t("common.good") }}
                                        </a-select-option>
                                        <a-select-option :value="0.7">
                                            {{ $t("common.premium") }}
                                        </a-select-option>
                                        <a-select-option :value="1.0">
                                            {{ $t("common.high") }}
                                        </a-select-option>
                                    </a-select>
                                </a-form-item>
                            </a-col>
                            <a-col :xs="24" :sm="24" :md="12" :lg="12">
                                <a-form-item
                                    :label="$t('writer.max_result_length')"
                                    name="max_result_length"
                                    :help="
                                        rules.max_result_length
                                            ? rules.max_result_length.message
                                            : null
                                    "
                                    :validateStatus="
                                        rules.max_result_length ? 'error' : null
                                    "
                                    class="required"
                                >
                                    <a-input-number
                                        v-model:value="maxResultLenght"
                                        :placeholder="
                                            $t('common.placeholder_default_text', [
                                                $t('writer.max_result_length'),
                                            ])
                                        "
                                        :min="10"
                                        :max="600"
                                        style="width: 100%"
                                    />
                                </a-form-item>
                            </a-col>
                        </a-row>

                        <a-row :gutter="16">
                            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                <a-form-item
                                    :label="$t('writer.language')"
                                    name="language"
                                    :help="rules.language ? rules.language.message : null"
                                    :validateStatus="rules.language ? 'error' : null"
                                    class="required"
                                >
                                    <a-input
                                        v-model:value="language"
                                        :placeholder="
                                            $t('common.placeholder_default_text', [
                                                $t('writer.document_name'),
                                            ])
                                        "
                                    />
                                </a-form-item>
                            </a-col>
                        </a-row>

                        <a-row>
                            <a-col :span="24">
                                <a-button
                                    type="primary"
                                    @click="onSubmit"
                                    :loading="loading"
                                    block
                                >
                                    <template #icon>
                                        <FileProtectOutlined />
                                    </template>
                                    {{ $t("writer.generate") }}
                                </a-button>
                            </a-col>
                        </a-row>
                    </a-form>
                </div>
            </div>
        </a-col>
        <a-col :xs="24" :sm="24" :md="24" :lg="16" :xl="16">
            <a-card class="page-content-container">
                <AiDoc :data="formData" />
            </a-card>
        </a-col>
    </a-row>
</template>

<script>
import { ref, onMounted, computed, watch } from "vue";
import { FileProtectOutlined } from "@ant-design/icons-vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import { find, forEach, toLower } from "lodash-es";
import AiDoc from "./AiDoc.vue";
import { useI18n } from "vue-i18n";
import apiAdmin from "../../../../common/composable/apiAdmin";
import common from "../../../../common/composable/common";
import AdminPageHeader from "../../../../common/layouts/AdminPageHeader.vue";

export default {
    components: {
        FileProtectOutlined,
        AdminPageHeader,
        AiDoc,
    },
    setup() {
        const { permsArray } = common();
        const store = useStore();
        const { t } = useI18n();
        const { addEditRequestAdmin, loading, rules } = apiAdmin();
        const route = useRoute();
        const templateId = route.params.id;
        const allTemplates = ref([]);
        const currentTemplate = ref({});
        const selectedTemplateId = ref(templateId);
        const templateFields = ref([]);
        const formData = ref({
            document_name: "",
            content: "",
            workspace_id: undefined,
            xid: undefined,
        });
        const chagedTemplate = ref({});
        const contentQuality = ref(0.5);
        const maxResultLenght = ref(200);
        const language = ref("english");

        onMounted(() => {
            getInitData();
        });

        const getInitData = () => {
            const writerTemplatePromise = axiosAdmin.get(
                `ai-tools/templates/${templateId}`
            );

            Promise.all([writerTemplatePromise]).then(([writerTemplateResponse]) => {
                currentTemplate.value = writerTemplateResponse.data.template;
                allTemplates.value = writerTemplateResponse.data.all_templates;

                setTemplateFields(currentTemplate.value.form_fields);

                chagedTemplate.value = currentTemplate.value;
            });
        };

        const templateChanged = (templateIdValue, templateOption) => {
            setTemplateFields(templateOption.templateValue.form_fields);

            chagedTemplate.value = templateOption.templateValue;
        };

        const setTemplateFields = (allFormFields) => {
            var allFieldsData = [];

            forEach(allFormFields, (fieldValue) => {
                allFieldsData.push({
                    name: fieldValue.name,
                    slug: toLower(fieldValue.name),
                    description: fieldValue.description,
                    type: fieldValue.type,
                    value: "",
                });
            });

            templateFields.value = allFieldsData;
        };

        const resetTemplateFields = () => {
            var allFieldsData = [];

            forEach(templateFields.value, (fieldValue) => {
                allFieldsData.push({
                    name: fieldValue.name,
                    slug: toLower(fieldValue.name),
                    description: fieldValue.description,
                    type: fieldValue.type,
                    value: "",
                });
            });

            templateFields.value = allFieldsData;
        };

        const onSubmit = () => {
            var aiFormData = {
                template_id: selectedTemplateId.value,
                form_fields: templateFields.value,
                content_quality: contentQuality.value,
                max_result_length: maxResultLenght.value,
                language: language.value,
            };

            addEditRequestAdmin({
                url: "ai-tools/write",
                data: aiFormData,
                successMessage: t("writer.content_generated"),
                success: (res) => {
                    resetTemplateFields();
                    contentQuality.value = 0.5;
                    language.value = "english";

                    formData.value = {
                        document_name: res.document_name,
                        content: res.content,
                        workspace_id: res.workspace_id,
                        xid: res.xid,
                    };

                    store.commit(
                        "auth/updateRemainingCharacter",
                        res.remaining_character
                    );
                },
            });
        };

        return {
            permsArray,
            selectedTemplateId,
            loading,
            rules,

            templateFields,
            currentTemplate,
            allTemplates,

            chagedTemplate,
            templateChanged,
            onSubmit,

            formData,
            contentQuality,
            maxResultLenght,
            language,
        };
    },
};
</script>
