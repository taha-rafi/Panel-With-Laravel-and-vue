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
            <a-row>
                <a-col :xs="24" :sm="24" :md="6" :lg="6">
                    <a-form-item
                        :label="$t('writer_template.logo')"
                        name="logo"
                        :help="rules.logo ? rules.logo.message : null"
                        :validateStatus="rules.logo ? 'error' : null"
                    >
                        <Upload
                            :formData="newFormData"
                            folder="templates"
                            imageField="logo"
                            @onFileUploaded="
                                (file) => {
                                    newFormData.logo = file.file;
                                    newFormData.logo_url = file.file_url;
                                }
                            "
                        />
                    </a-form-item>
                </a-col>
                <a-col :xs="24" :sm="24" :md="18" :lg="18">
                    <a-row :gutter="16">
                        <a-col :xs="24" :sm="24" :md="24" :lg="24">
                            <a-form-item
                                :label="$t('writer_template.writer_category')"
                                name="writer_category_id"
                                :help="
                                    rules.writer_category_id
                                        ? rules.writer_category_id.message
                                        : null
                                "
                                :validateStatus="
                                    rules.writer_category_id ? 'error' : null
                                "
                                class="required"
                            >
                                <span style="display: flex">
                                    <a-select
                                        v-model:value="newFormData.writer_category_id"
                                        :placeholder="
                                            $t('common.select_default_text', [
                                                $t('writer_template.writer_category'),
                                            ])
                                        "
                                        :allowClear="true"
                                    >
                                        <a-select-option
                                            v-for="writerCategory in writerCategories"
                                            :key="writerCategory.xid"
                                            :value="writerCategory.xid"
                                        >
                                            {{ writerCategory.name }}
                                        </a-select-option>
                                    </a-select>
                                    <WriterCategoryAddButton
                                        @onAddSuccess="writerCategoryAdded"
                                    />
                                </span>
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-col :xs="24" :sm="24" :md="24" :lg="24">
                        <a-form-item
                            :label="$t('writer_template.name')"
                            name="name"
                            :help="rules.name ? rules.name.message : null"
                            :validateStatus="rules.name ? 'error' : null"
                            class="required"
                        >
                            <a-input
                                v-model:value="newFormData.name"
                                :placeholder="
                                    $t('common.placeholder_default_text', [
                                        $t('writer_template.name'),
                                    ])
                                "
                            />
                        </a-form-item>
                    </a-col>
                    <a-col :xs="8" :sm="8" :md="12" :lg="12">
                        <a-form-item
                            :label="$t('writer_template.status')"
                            name="status"
                            :help="rules.status ? rules.status.message : null"
                            :validateStatus="rules.status ? 'error' : null"
                        >
                            <a-radio-group
                                v-model:value="newFormData.status"
                                buttonStyle="solid"
                                size="small"
                            >
                                <a-radio-button :value="1">Active</a-radio-button>
                                <a-radio-button :value="0">Inactive</a-radio-button>
                            </a-radio-group>
                        </a-form-item>
                    </a-col>
                </a-col>
            </a-row>
            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="24" :lg="24">
                    <a-form-item
                        :label="$t('writer_template.description')"
                        name="description"
                        :help="rules.description ? rules.description.message : null"
                        :validateStatus="rules.description ? 'error' : null"
                        class="required"
                    >
                        <a-textarea
                            v-model:value="newFormData.description"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('writer_template.description'),
                                ])
                            "
                            style="width: 100%"
                        >
                        </a-textarea>
                    </a-form-item>
                </a-col>
            </a-row>

            <FormItemHeading>
                {{ $t("writer_template.form_fields") }}
            </FormItemHeading>

            <template v-if="formFields.length > 0">
                <a-row
                    :gutter="16"
                    v-for="(formField, index) in formFields"
                    :key="formField.id"
                >
                    <a-col :span="8">
                        <a-form-item :name="['form_fields', index, 'name']">
                            <a-input
                                v-model:value="formField.name"
                                :placeholder="$t('writer_template.field_name')"
                            />
                        </a-form-item>
                    </a-col>
                    <a-col :span="8">
                        <a-form-item :name="['form_fields', index, 'description']">
                            <a-input
                                v-model:value="formField.description"
                                :placeholder="$t('writer_template.field_description')"
                            />
                        </a-form-item>
                    </a-col>
                    <a-col :span="6">
                        <a-form-item :name="['form_fields', index, 'name']">
                            <a-select
                                v-model:value="formField.type"
                                :placeholder="
                                    $t('common.select_default_text', [
                                        $t('writer_template.field_type'),
                                    ])
                                "
                            >
                                <a-select-option value="text">
                                    {{ $t("writer_template.text") }}
                                </a-select-option>
                                <a-select-option value="email">
                                    {{ $t("writer_template.textarea") }}
                                </a-select-option>
                            </a-select>
                        </a-form-item>
                    </a-col>
                    <a-col :span="2">
                        <MinusCircleOutlined @click="removeFormField(formField)" />
                    </a-col>
                </a-row>
            </template>

            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="24" :lg="24">
                    <a-form-item>
                        <a-button
                            type="dashed"
                            block
                            @click="addFormField"
                            :disabled="addFormButtonStatus"
                        >
                            <PlusOutlined />
                            {{ $t("writer_template.add_form_field") }}
                        </a-button>
                    </a-form-item>
                </a-col>
            </a-row>

            <FormItemHeading>
                {{ $t("writer_template.prompt_text") }}
            </FormItemHeading>

            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="24" :lg="24">
                    <a-form-item
                        :label="$t('writer_template.prompt_text')"
                        name="prompt_text"
                        :help="rules.prompt_text ? rules.prompt_text.message : null"
                        :validateStatus="rules.prompt_text ? 'error' : null"
                        class="required"
                    >
                        <QuillEditor
                            toolbar="#my-toolbar"
                            ref="textEditor"
                            v-model:content="newFormData.prompt_text"
                            :content="newFormData.prompt_text"
                            contentType="text"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('writer_template.prompt_text'),
                                ])
                            "
                            style="height: 200px"
                        >
                            <template #toolbar>
                                <div id="my-toolbar">
                                    <a-row
                                        :gutter="16"
                                        v-if="formFields && formFields.length > 0"
                                    >
                                        <a-col
                                            :xs="8"
                                            :sm="8"
                                            :md="6"
                                            :lg="4"
                                            v-for="selectedFormField in formFields"
                                            :key="selectedFormField.id"
                                        >
                                            <a-button
                                                @click="
                                                    insertFormText(selectedFormField.name)
                                                "
                                                type="link"
                                                style="padding: 0px"
                                            >
                                                {{ selectedFormField.name }}
                                            </a-button>
                                        </a-col>
                                    </a-row>
                                </div>
                            </template>
                        </QuillEditor>
                    </a-form-item>
                </a-col>
            </a-row>
        </a-form>
        <template #footer>
            <a-button
                type="primary"
                @click="onSubmit"
                style="margin-right: 8px"
                :loading="loading"
            >
                <template #icon> <SaveOutlined /> </template>
                {{ addEditType == "add" ? $t("common.create") : $t("common.update") }}
            </a-button>
            <a-button @click="onClose">
                {{ $t("common.cancel") }}
            </a-button>
        </template>
    </a-drawer>
</template>

<script>
import { defineComponent, ref, onMounted, watch, computed } from "vue";
import {
    PlusOutlined,
    LoadingOutlined,
    SaveOutlined,
    MinusCircleOutlined,
} from "@ant-design/icons-vue";
import { some, filter } from "lodash-es";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import apiAdmin from "../../../common/composable/apiAdmin";
import Upload from "../../../common/core/ui/file/Upload.vue";
import common from "../../../common/composable/common";
import WriterCategoryAddButton from "../writer-category/AddButton.vue";
import FormItemHeading from "../../../common/components/common/typography/FormItemHeading.vue";

export default defineComponent({
    props: [
        "formData",
        "data",
        "visible",
        "url",
        "addEditType",
        "pageTitle",
        "successMessage",
    ],
    components: {
        PlusOutlined,
        LoadingOutlined,
        SaveOutlined,
        Upload,
        MinusCircleOutlined,
        WriterCategoryAddButton,
        FormItemHeading,
        QuillEditor,
    },
    setup(props, { emit }) {
        const writerCategories = ref([]);
        const writercategoryUrl = "superadmin/writer-categories?limit=10000";
        const newFormData = ref({
            writer_category_id: undefined,
            name: "",
            logo: undefined,
            logo_url: undefined,
            description: "",
            status: 1,
            prompt_text: "",
            form_fields: [],
        });
        const formFields = ref([]);
        const textEditor = ref(null);
        const { addEditRequestAdmin, loading, rules } = apiAdmin();

        onMounted(() => {
            const writerCategoryPromise = axiosAdmin.get(writercategoryUrl);

            Promise.all([writerCategoryPromise]).then(([writerCategoryResponse]) => {
                writerCategories.value = writerCategoryResponse.data;
            });
        });

        const removeFormField = (item) => {
            let index = formFields.value.indexOf(item);
            if (index !== -1) {
                formFields.value.splice(index, 1);
            }
        };

        const addFormField = () => {
            formFields.value.push({
                name: "",
                description: "",
                type: "text",
                required: 0,
                id: Math.random().toString(36).slice(2),
            });
        };

        const onSubmit = () => {
            const allFormFields = filter(formFields.value, (newFormField) => {
                return newFormField.name != "";
            });
            addEditRequestAdmin({
                url: props.url,
                data: {
                    ...newFormData.value,
                    form_fields: allFormFields,
                },
                successMessage: props.successMessage,
                success: (res) => {
                    emit("addEditSuccess", res.xid);
                },
            });
        };

        const editor = computed(() => {
            return textEditor.value.getQuill();
        });

        const insertFormText = (mergeFieldText) => {
            const selectedPointArray = editor.value.getSelection(true);
            var newFieldTextValue =
                selectedPointArray.length > 0
                    ? `##${mergeFieldText}##`
                    : ` ##${mergeFieldText}## `;
            editor.value.deleteText(selectedPointArray.index, selectedPointArray.length);
            editor.value.insertText(selectedPointArray.index, newFieldTextValue);
        };

        const onClose = () => {
            rules.value = {};
            emit("closed");
        };

        const addFormButtonStatus = computed(() => {
            if (formFields.value.length == 0) {
                return false;
            } else {
                return some(formFields.value, { name: "" });
            }
        });

        const writerCategoryAdded = () => {
            axiosAdmin.get(writercategoryUrl).then((response) => {
                writerCategories.value = response.data;
            });
        };

        watch(
            () => props.visible,
            (newVal, oldVal) => {
                if (props.addEditType == "edit" && newVal) {
                    newFormData.value = {
                        writer_category_id: props.data.x_writer_category_id,
                        name: props.data.name,
                        logo: props.data.logo,
                        logo_url: props.data.logo_url,
                        description: props.data.description,
                        status: props.data.status,
                        prompt_text: props.data.prompt_text,
                        _method: "PUT",
                    };
                    formFields.value = props.data.form_fields;

                    if (textEditor.value) {
                        textEditor.value.setHTML(props.formData.body);
                    }
                } else {
                    newFormData.value = {
                        writer_category_id: undefined,
                        name: "",
                        logo: undefined,
                        logo_url: undefined,
                        description: "",
                        status: 1,
                        prompt_text: "",
                    };
                    formFields.value = [];

                    if (textEditor.value) {
                        textEditor.value.setHTML("");
                    }
                }
            }
        );

        return {
            loading,
            rules,
            onClose,
            onSubmit,
            writerCategories,
            writercategoryUrl,
            writerCategoryAdded,

            newFormData,
            formFields,

            textEditor,
            insertFormText,
            removeFormField,
            addFormField,
            addFormButtonStatus,

            drawerWidth: window.innerWidth <= 991 ? "90%" : "55%",
        };
    },
});
</script>
