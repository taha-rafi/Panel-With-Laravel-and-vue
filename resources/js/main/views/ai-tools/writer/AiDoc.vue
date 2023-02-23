<template>
    <a-form layout="vertical">
        <a-row :gutter="16">
            <a-col :xs="24" :sm="24" :md="10" :lg="10">
                <a-form-item
                    :label="$t('writer.document_name')"
                    name="document_name"
                    :help="rules.document_name ? rules.document_name.message : null"
                    :validateStatus="rules.document_name ? 'error' : null"
                    class="required"
                >
                    <a-input
                        v-model:value="formData.document_name"
                        :placeholder="
                            $t('common.placeholder_default_text', [
                                $t('writer.document_name'),
                            ])
                        "
                    />
                </a-form-item>
            </a-col>
            <a-col :xs="24" :sm="24" :md="10" :lg="10">
                <a-form-item
                    :label="$t('work_space.name')"
                    name="workspace_id"
                    :help="rules.workspace_id ? rules.workspace_id.message : null"
                    :validateStatus="rules.workspace_id ? 'error' : null"
                >
                    <a-select
                        v-model:value="formData.workspace_id"
                        :placeholder="
                            $t('common.select_default_text', [$t('work_space.name')])
                        "
                        :allowClear="true"
                    >
                        <a-select-option
                            v-for="allWorkspace in allWorkspaces"
                            :key="allWorkspace.xid"
                            :value="allWorkspace.xid"
                        >
                            {{ allWorkspace.name }}
                        </a-select-option>
                    </a-select>
                </a-form-item>
            </a-col>
            <a-col :xs="24" :sm="24" :md="4" :lg="4">
                <a-form-item :label="$t('common.action')">
                    <a-tooltip
                        placement="topLeft"
                        :title="$t('common.save')"
                        arrow-point-at-center
                    >
                        <a-button
                            type="primary"
                            :disabled="data.xid && data.xid != undefined ? false : true"
                            @click="onSubmit"
                        >
                            <template #icon> <SaveOutlined /> </template>
                        </a-button>
                    </a-tooltip>
                </a-form-item>
            </a-col>
        </a-row>

        <a-row :gutter="16">
            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                <QuillEditor
                    ref="textEditor"
                    v-model:content="formData.content"
                    :content="formData.content"
                    contentType="html"
                    :placeholder="
                        $t('common.placeholder_default_text', [$t('writer.content')])
                    "
                    :style="{ height: 'calc(100vh - 350px)' }"
                />
            </a-col>
        </a-row>
        <a-row :gutter="16" class="mt-10 mb-10">
            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                <a-typography-text strong>
                    {{ $t("writer.total_characters") }} :
                    {{ totalCharacters }}
                </a-typography-text>
            </a-col>
        </a-row>
    </a-form>
</template>

<script>
import { ref, onMounted, computed, watch } from "vue";
import { SaveOutlined } from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import apiAdmin from "../../../../common/composable/apiAdmin";

export default {
    props: ["data"],
    components: {
        QuillEditor,
        SaveOutlined,
    },
    setup(props) {
        const { addEditRequestAdmin, loading, rules } = apiAdmin();
        const { t } = useI18n();
        const textEditor = ref(null);
        const formData = ref({
            document_name: "",
            content: "",
            workspace_id: undefined,
        });
        const totalCharacters = ref(0);
        const allWorkspaces = ref([]);

        onMounted(() => {
            getInitData();
        });

        const getInitData = () => {
            const workspacePromise = axiosAdmin.get("work-spaces?limit=10000");

            Promise.all([workspacePromise]).then(([workspaceResponse]) => {
                allWorkspaces.value = workspaceResponse.data;
            });
        };

        const recalculateCharacters = () => {
            totalCharacters.value =
                textEditor.value && textEditor.value.getText()
                    ? textEditor.value.getText().length - 1
                    : 0;
        };

        const onSubmit = () => {
            var newFormData = {
                ...formData.value,
                content: textEditor.value.getText(),
                _method: "PUT",
            };

            addEditRequestAdmin({
                url: `writer-documents/${props.data.xid}`,
                data: newFormData,
                successMessage: t("writer_document.updated"),
                success: (res) => {
                    recalculateCharacters();
                },
            });
        };

        watch(
            () => props.data,
            (newVal, oldVal) => {
                console.log(newVal, "opp");
                formData.value = {
                    document_name: props.data.document_name,
                    content: props.data.content,
                    workspace_id: props.data.workspace_id,
                };
            }
        );

        watch(
            () => formData.value.content,
            (newVal, oldVal) => {
                recalculateCharacters();
            }
        );

        return {
            loading,
            rules,

            onSubmit,

            textEditor,
            formData,
            totalCharacters,
            allWorkspaces,
        };
    },
};
</script>

<style></style>
