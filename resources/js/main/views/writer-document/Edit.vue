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
                <a-col :xs="24" :sm="24" :md="24" :lg="24">
                    <a-form-item
                        :label="$t('work_space.name')"
                        name="workspace_id"
                        :help="rules.workspace_id ? rules.workspace_id.message : null"
                        :validateStatus="rules.workspace_id ? 'error' : null"
                    >
                        <span style="display: flex">
                            <a-select
                                v-model:value="newFormData.workspace_id"
                                :placeholder="
                                    $t('common.select_default_text', [
                                        $t('work_space.name'),
                                    ])
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
                            <WorkspaceAddButton @onAddSuccess="getInitData" />
                        </span>
                    </a-form-item>
                </a-col>
            </a-row>
            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="24" :lg="24">
                    <a-form-item
                        :label="$t('writer_document.document_name')"
                        name="document_name"
                        :help="rules.document_name ? rules.document_name.message : null"
                        :validateStatus="rules.document_name ? 'error' : null"
                        class="required"
                    >
                        <a-input
                            v-model:value="newFormData.document_name"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('writer_document.document_name'),
                                ])
                            "
                        />
                    </a-form-item>
                </a-col>
            </a-row>
            <a-row :gutter="16">
                <a-col :xs="24" :sm="24" :md="24" :lg="24">
                    <a-form-item
                        :label="$t('writer_document.content')"
                        name="content"
                        :help="rules.content ? rules.content.message : null"
                        :validateStatus="rules.content ? 'error' : null"
                        class="required"
                    >
                        <QuillEditor
                            ref="textEditor"
                            v-model:content="newFormData.content"
                            :content="newFormData.content"
                            contentType="text"
                            :placeholder="
                                $t('common.placeholder_default_text', [
                                    $t('writer_document.content'),
                                ])
                            "
                            style="height: 200px"
                        />
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
import { defineComponent, ref, watch, onMounted } from "vue";
import { PlusOutlined, LoadingOutlined, SaveOutlined } from "@ant-design/icons-vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import apiAdmin from "../../../common/composable/apiAdmin";
import Upload from "../../../common/core/ui/file/Upload.vue";
import common from "../../../common/composable/common";
import WorkspaceAddButton from "../work-space/AddButton.vue";

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
        QuillEditor,
        WorkspaceAddButton,
    },
    setup(props, { emit }) {
        const { user, appSetting } = common();
        const { addEditRequestAdmin, loading, rules } = apiAdmin();
        const newFormData = ref({
            document_name: "",
            content: "",
        });
        const textEditor = ref(null);
        const allWorkspaces = ref([]);
        const workspaceUrl = "work-spaces?limit=10000";

        onMounted(() => {
            getInitData();
        });

        const getInitData = () => {
            const workspacePromise = axiosAdmin.get(workspaceUrl);

            Promise.all([workspacePromise]).then(([workspaceResponse]) => {
                allWorkspaces.value = workspaceResponse.data;
            });
        };

        const onSubmit = () => {
            addEditRequestAdmin({
                url: props.url,
                data: newFormData.value,
                successMessage: props.successMessage,
                success: (res) => {
                    emit("addEditSuccess", res.xid);
                },
            });
        };

        const onClose = () => {
            rules.value = {};
            emit("closed");
        };

        watch(
            () => props.visible,
            (newVal, oldVal) => {
                if (props.addEditType == "edit" && newVal) {
                    newFormData.value = {
                        document_name: props.data.document_name,
                        content: props.data.content,
                        workspace_id: props.data.x_workspace_id,
                        _method: "PUT",
                    };

                    if (textEditor.value) {
                        textEditor.value.setHTML(props.formData.content);
                    }
                } else {
                    newFormData.value = {
                        document_name: "",
                        content: "",
                        workspace_id: undefined,
                    };

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
            appSetting,

            textEditor,
            newFormData,
            allWorkspaces,
            getInitData,

            drawerWidth: window.innerWidth <= 991 ? "90%" : "45%",
        };
    },
});
</script>
