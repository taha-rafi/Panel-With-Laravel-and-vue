<template>
    <a-row :span="16">
        <a-col>
            <a-button @click="showAdd" type="primary">
                <template #icon> <PlusOutlined /> </template>
                {{ $t("website_settings.add_footer_page") }}
            </a-button>
            <a-drawer
                v-model:visible="visible"
                :title="addEditTitle"
                :width="drawerWidth"
                :body-style="{ paddingBottom: '80px' }"
                :footer-style="{ textAlign: 'right' }"
            >
                <a-form layout="vertical">
                    <a-row :gutter="16">
                        <a-col :xs="24" :sm="24" :md="24" :lg="24">
                            <a-form-item
                                :label="$t('common.title')"
                                name="title"
                                :help="rules.title ? rules.title.message : null"
                                :validateStatus="rules.title ? 'error' : null"
                                class="required"
                                v-on:keyup="formData.slug = slugify($event.target.value)"
                            >
                                <a-input
                                    v-model:value="formData.title"
                                    :placeholder="
                                        $t('common.placeholder_default_text', [
                                            $t('common.title'),
                                        ])
                                    "
                                />
                            </a-form-item>
                        </a-col>
                    </a-row>

                    <a-row :gutter="16">
                        <a-col :xs="24" :sm="24" :md="24" :lg="24">
                            <a-form-item
                                :label="$t('common.slug')"
                                name="slug"
                                :help="rules.slug ? rules.slug.message : null"
                                :validateStatus="rules.slug ? 'error' : null"
                                class="required"
                            >
                                <a-input
                                    v-model:value="formData.slug"
                                    :placeholder="
                                        $t('common.placeholder_default_text', [
                                            $t('common.slug'),
                                        ])
                                    "
                                />
                            </a-form-item>
                        </a-col>
                    </a-row>

                    <a-row :gutter="16">
                        <a-col :xs="24" :sm="24" :md="24" :lg="24">
                            <a-form-item
                                :label="$t('common.page_content')"
                                name="page_content"
                                :help="
                                    rules.page_content ? rules.page_content.message : null
                                "
                                :validateStatus="rules.page_content ? 'error' : null"
                                class="required"
                            >
                                <ckeditor
                                    :editor="editor"
                                    v-model="formData.page_content"
                                ></ckeditor>

                                <!-- <QuillEditor
                                    ref="textEditor"
                                    v-model:content="formData.page_content"
                                    :content="formData.page_content"
                                    contentType="html"
                                    :placeholder="
                                        $t('common.placeholder_default_text', [
                                            $t('writer_document.content'),
                                        ])
                                    "
                                    toolbar="full"
                                    style="height: 300px"
                                /> -->
                            </a-form-item>
                        </a-col>
                    </a-row>

                    <a-row :gutter="16">
                        <a-col :xs="24" :sm="24" :md="24" :lg="24">
                            <a-form-item
                                :label="$t('front_setting.seo_keywords')"
                                name="seo_keywords"
                                :help="
                                    rules.seo_keywords ? rules.seo_keywords.message : null
                                "
                                :validateStatus="rules.seo_keywords ? 'error' : null"
                            >
                                <a-textarea
                                    v-model:value="formData.seo_keywords"
                                    :placeholder="
                                        $t('common.placeholder_default_text', [
                                            $t('front_setting.seo_keywords'),
                                        ])
                                    "
                                    :rows="2"
                                />
                            </a-form-item>
                        </a-col>
                    </a-row>
                    <a-row :gutter="16">
                        <a-col :xs="24" :sm="24" :md="24" :lg="24">
                            <a-form-item
                                :label="$t('front_setting.seo_description')"
                                name="seo_description"
                                :help="
                                    rules.seo_description
                                        ? rules.seo_description.message
                                        : null
                                "
                                :validateStatus="rules.seo_description ? 'error' : null"
                            >
                                <a-textarea
                                    v-model:value="formData.seo_description"
                                    :placeholder="
                                        $t('common.placeholder_default_text', [
                                            $t('front_setting.seo_description'),
                                        ])
                                    "
                                    :rows="2"
                                />
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
                            {{
                                addEditType == "add"
                                    ? $t("common.create")
                                    : $t("common.update")
                            }}
                        </a-button>
                        <a-button key="back" @click="onClose">
                            {{ $t("common.cancel") }}
                        </a-button>
                    </a-space>
                </template>
            </a-drawer>
        </a-col>
    </a-row>
    <a-row :gutter="[18, 18]" class="mt-20 mb-20">
        <a-col :span="24">
            <a-table
                :columns="columns"
                :row-key="(record) => record.id"
                :data-source="tableData"
                :pagination="false"
            >
                <template #bodyCell="{ column, record }">
                    <template v-if="column.dataIndex === 'action'">
                        <a-space>
                            <a-button type="primary" @click="editItem(record)">
                                <template #icon><EditOutlined /></template>
                            </a-button>
                            <a-button type="primary" @click="showDeleteConfirm(record)">
                                <template #icon><DeleteOutlined /></template>
                            </a-button>
                        </a-space>
                    </template>
                </template>
            </a-table>
        </a-col>
    </a-row>
</template>
<script>
import { onMounted, ref } from "vue";
import {
    PlusOutlined,
    EditOutlined,
    DeleteOutlined,
    SaveOutlined,
} from "@ant-design/icons-vue";
import landingWebsiteSetting from "../../composable/landingWebsiteSetting";
import fields from "./fields";
import common from "../../../common/composable/common";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
    props: ["langKey"],
    components: {
        PlusOutlined,
        EditOutlined,
        DeleteOutlined,
        SaveOutlined,
    },
    setup(props) {
        const landingWebsite = landingWebsiteSetting(props);
        const { details } = fields("footer_pages");
        const { slugify } = common();
        const textEditor = ref(null);
        const editor = ClassicEditor;

        onMounted(() => {
            landingWebsite.columns.value = details.value.columns;
            landingWebsite.settingType.value = details.value.setting_type;
            landingWebsite.langType.value = details.value.lang_type;
            landingWebsite.initData.value = details.value.init_data;
            landingWebsite.getData(props.langKey);
        });

        return {
            ...landingWebsite,
            slugify,
            textEditor,
            editor,

            drawerWidth: window.innerWidth <= 991 ? "90%" : "45%",
        };
    },
};
</script>
