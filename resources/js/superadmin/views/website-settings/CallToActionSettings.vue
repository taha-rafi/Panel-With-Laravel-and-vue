<template>
    <SuperAdminPageHeader>
        <template #header>
            <a-page-header
                :title="$t(`menu.website_call_to_action_settings`)"
                class="p-0"
            >
                <template #extra>
                    <LangAddButton btnType="primary" :tooltip="false">
                        {{ $t("langs.add") }}
                    </LangAddButton>
                </template>
            </a-page-header>
        </template>
        <template #breadcrumb>
            <a-breadcrumb separator="-" style="font-size: 12px">
                <a-breadcrumb-item>
                    <router-link :to="{ name: 'admin.dashboard.index' }">
                        {{ $t(`menu.dashboard`) }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t("menu.website_settings") }}
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t("menu.website_call_to_action_settings") }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </SuperAdminPageHeader>

    <a-row>
        <a-col :xs="24" :sm="24" :md="24" :lg="4" :xl="4" class="bg-setting-sidebar">
            <WebsiteSettingSidebar />
        </a-col>
        <a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
            <a-card class="page-content-container">
                <a-tabs v-model:activeKey="activeKey" @change="langChanged">
                    <a-tab-pane
                        v-for="allLang in allLangs"
                        :key="allLang.key"
                        :value="allLang.key"
                    >
                        <template #tab>
                            <span>
                                <a-avatar
                                    shape="square"
                                    :size="20"
                                    :src="allLang.image_url"
                                />
                                {{ allLang.name }}
                            </span>
                        </template>

                        <a-row :gutter="16">
                            <a-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                                <a-form layout="vertical">
                                    <a-row :gutter="16">
                                        <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                            <a-form-item
                                                :label="
                                                    $t(
                                                        'website_settings.call_to_action_title'
                                                    )
                                                "
                                                name="call_to_action_title"
                                                :help="
                                                    rules.call_to_action_title
                                                        ? rules.call_to_action_title
                                                              .message
                                                        : null
                                                "
                                                :validateStatus="
                                                    rules.call_to_action_title
                                                        ? 'error'
                                                        : null
                                                "
                                            >
                                                <a-input
                                                    v-model:value="
                                                        formData.call_to_action_title
                                                    "
                                                    :placeholder="
                                                        $t(
                                                            'common.placeholder_default_text',
                                                            [
                                                                $t(
                                                                    'website_settings.call_to_action_title'
                                                                ),
                                                            ]
                                                        )
                                                    "
                                                />
                                            </a-form-item>
                                        </a-col>
                                    </a-row>

                                    <a-row :gutter="16">
                                        <a-col :span="24">
                                            <a-form-item
                                                :label="
                                                    $t(
                                                        'website_settings.call_to_action_description'
                                                    )
                                                "
                                                name="call_to_action_description"
                                                :help="
                                                    rules.call_to_action_description
                                                        ? rules.call_to_action_description
                                                              .message
                                                        : null
                                                "
                                                :validateStatus="
                                                    rules.call_to_action_description
                                                        ? 'error'
                                                        : null
                                                "
                                            >
                                                <a-textarea
                                                    v-model:value="
                                                        formData.call_to_action_description
                                                    "
                                                    :placeholder="
                                                        $t(
                                                            'common.placeholder_default_text',
                                                            [
                                                                $t(
                                                                    'website_settings.call_to_action_description'
                                                                ),
                                                            ]
                                                        )
                                                    "
                                                    :rows="4"
                                                />
                                            </a-form-item>
                                        </a-col>
                                    </a-row>

                                    <a-row :gutter="16">
                                        <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                            <a-form-item
                                                :label="
                                                    $t(
                                                        'website_settings.call_to_action_no_email_sell_text'
                                                    )
                                                "
                                                name="call_to_action_no_email_sell_text"
                                                :help="
                                                    rules.call_to_action_no_email_sell_text
                                                        ? rules
                                                              .call_to_action_no_email_sell_text
                                                              .message
                                                        : null
                                                "
                                                :validateStatus="
                                                    rules.call_to_action_no_email_sell_text
                                                        ? 'error'
                                                        : null
                                                "
                                            >
                                                <a-input
                                                    v-model:value="
                                                        formData.call_to_action_no_email_sell_text
                                                    "
                                                    :placeholder="
                                                        $t(
                                                            'common.placeholder_default_text',
                                                            [
                                                                $t(
                                                                    'website_settings.call_to_action_no_email_sell_text'
                                                                ),
                                                            ]
                                                        )
                                                    "
                                                />
                                            </a-form-item>
                                        </a-col>
                                    </a-row>

                                    <a-row :gutter="16">
                                        <a-col :xs="24" :sm="24" :md="12" :lg="12">
                                            <a-form-item
                                                :label="
                                                    $t(
                                                        'website_settings.call_to_action_email_text'
                                                    )
                                                "
                                                name="call_to_action_email_text"
                                                :help="
                                                    rules.call_to_action_email_text
                                                        ? rules.call_to_action_email_text
                                                              .message
                                                        : null
                                                "
                                                :validateStatus="
                                                    rules.call_to_action_email_text
                                                        ? 'error'
                                                        : null
                                                "
                                            >
                                                <a-input
                                                    v-model:value="
                                                        formData.call_to_action_email_text
                                                    "
                                                    :placeholder="
                                                        $t(
                                                            'common.placeholder_default_text',
                                                            [
                                                                $t(
                                                                    'website_settings.call_to_action_email_text'
                                                                ),
                                                            ]
                                                        )
                                                    "
                                                />
                                            </a-form-item>
                                        </a-col>
                                        <a-col :xs="24" :sm="24" :md="12" :lg="12">
                                            <a-form-item
                                                :label="
                                                    $t(
                                                        'website_settings.call_to_action_submit_button_text'
                                                    )
                                                "
                                                name="call_to_action_submit_button_text"
                                                :help="
                                                    rules.call_to_action_submit_button_text
                                                        ? rules
                                                              .call_to_action_submit_button_text
                                                              .message
                                                        : null
                                                "
                                                :validateStatus="
                                                    rules.call_to_action_submit_button_text
                                                        ? 'error'
                                                        : null
                                                "
                                            >
                                                <a-input
                                                    v-model:value="
                                                        formData.call_to_action_submit_button_text
                                                    "
                                                    :placeholder="
                                                        $t(
                                                            'common.placeholder_default_text',
                                                            [
                                                                $t(
                                                                    'website_settings.call_to_action_submit_button_text'
                                                                ),
                                                            ]
                                                        )
                                                    "
                                                />
                                            </a-form-item>
                                        </a-col>
                                    </a-row>

                                    <a-divider />

                                    <a-row :gutter="16">
                                        <a-col :xs="24" :sm="24" :md="12" :lg="12">
                                            <a-typography-title
                                                :level="5"
                                                :style="{ marginBottom: '20px' }"
                                            >
                                                {{
                                                    $t(
                                                        "website_settings.footer_contact_widget"
                                                    )
                                                }}
                                            </a-typography-title>
                                            <DyanmicForm
                                                v-if="formData.call_to_action_widgets"
                                                :data="formData.call_to_action_widgets"
                                                :addText="
                                                    $t(
                                                        'website_settings.call_to_action_add_widget'
                                                    )
                                                "
                                            />
                                        </a-col>
                                    </a-row>

                                    <a-row :gutter="16">
                                        <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                            <a-form-item>
                                                <a-button
                                                    type="primary"
                                                    @click="onSubmit"
                                                    :loading="loading"
                                                >
                                                    <template #icon>
                                                        <SaveOutlined />
                                                    </template>
                                                    {{ $t("common.update") }}
                                                </a-button>
                                            </a-form-item>
                                        </a-col>
                                    </a-row>
                                </a-form>
                            </a-col>
                        </a-row>
                    </a-tab-pane>
                </a-tabs>
            </a-card>
        </a-col>
    </a-row>
</template>

<script>
import {
    EyeOutlined,
    PlusOutlined,
    EditOutlined,
    DeleteOutlined,
    ExclamationCircleOutlined,
    SaveOutlined,
} from "@ant-design/icons-vue";
import landingWebsite from "../../composable/landingWebsite";
import SuperAdminPageHeader from "../../layouts/SuperAdminPageHeader.vue";
import WebsiteSettingSidebar from "./WebsiteSettingSidebar.vue";
import LangAddButton from "../../../main/views/common/settings/translations/langs/AddButton.vue";
import DyanmicForm from "./features/DyanmicForm.vue";

export default {
    components: {
        EyeOutlined,
        PlusOutlined,
        EditOutlined,
        DeleteOutlined,
        ExclamationCircleOutlined,
        SaveOutlined,

        LangAddButton,
        WebsiteSettingSidebar,
        SuperAdminPageHeader,
        DyanmicForm,
    },
    setup() {
        const websiteSettings = landingWebsite();

        return {
            ...websiteSettings,
        };
    },
};
</script>
