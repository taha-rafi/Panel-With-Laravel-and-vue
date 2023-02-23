<template>
    <SuperAdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.website_header_settings`)" class="p-0">
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
                    {{ $t("website_settings.header") }}
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
                            <a-col :xs="24" :sm="24" :md="24" :lg="4" :xl="4">
                                <div
                                    :style="{
                                        borderRight: '1px solid #f0f0f0',
                                        height: 'calc(100vh - 259px)',
                                    }"
                                >
                                    <a-menu v-model:selectedKeys="subTabActiveKey">
                                        <a-menu-item key="basic_text">
                                            {{ $t("website_settings.basic_settings") }}
                                        </a-menu-item>
                                        <a-menu-item key="header_settings">
                                            {{ $t("website_settings.header_settings") }}
                                        </a-menu-item>
                                        <a-menu-item key="header_client">
                                            {{ $t("website_settings.header_client") }}
                                        </a-menu-item>
                                        <a-menu-item key="details_crud">
                                            {{ $t("website_settings.header_features") }}
                                        </a-menu-item>
                                    </a-menu>
                                </div>
                            </a-col>

                            <a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
                                <template v-if="subTabActiveKey[0] == 'details_crud'">
                                    <HeaderFeatures :langKey="activeKey" />
                                </template>
                                <template
                                    v-else-if="subTabActiveKey[0] == 'header_settings'"
                                >
                                    <a-form layout="vertical">
                                        <a-row :gutter="16">
                                            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_title'
                                                        )
                                                    "
                                                    name="header_title"
                                                    :help="
                                                        rules.header_title
                                                            ? rules.header_title.message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_title
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.header_title
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.header_title'
                                                                    ),
                                                                ]
                                                            )
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                        </a-row>

                                        <a-row :gutter="16">
                                            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_sub_title'
                                                        )
                                                    "
                                                    name="header_sub_title"
                                                    :help="
                                                        rules.header_sub_title
                                                            ? rules.header_sub_title
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_sub_title
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.header_sub_title
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.header_sub_title'
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
                                                            'website_settings.header_description'
                                                        )
                                                    "
                                                    name="header_description"
                                                    :help="
                                                        rules.header_description
                                                            ? rules.header_description
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_description
                                                            ? 'error'
                                                            : null
                                                    "
                                                >
                                                    <a-textarea
                                                        v-model:value="
                                                            formData.header_description
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.header_description'
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
                                            <a-col :xs="24" :sm="8" :md="8" :lg="8">
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_background_image'
                                                        )
                                                    "
                                                    name="header_background_image"
                                                    :help="
                                                        rules.header_background_image
                                                            ? rules
                                                                  .header_background_image
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_background_image
                                                            ? 'error'
                                                            : null
                                                    "
                                                >
                                                    <Upload
                                                        :formData="formData"
                                                        folder="website"
                                                        imageField="header_background_image"
                                                        @onFileUploaded="
                                                            (file) => {
                                                                formData.header_background_image =
                                                                    file.file;
                                                                formData.header_background_image_url =
                                                                    file.file_url;
                                                            }
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                        </a-row>

                                        <a-row :gutter="16">
                                            <a-col :span="8">
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_button1_show'
                                                        )
                                                    "
                                                    name="header_button1_show"
                                                    :help="
                                                        rules.header_button1_show
                                                            ? rules.header_button1_show
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_button1_show
                                                            ? 'error'
                                                            : null
                                                    "
                                                >
                                                    <a-switch
                                                        v-model:checked="
                                                            formData.header_button1_show
                                                        "
                                                        checkedValue="1"
                                                        unCheckedValue="0"
                                                    />
                                                </a-form-item>
                                            </a-col>
                                            <a-col
                                                :span="8"
                                                v-if="formData.header_button1_show == '1'"
                                            >
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_button1_text'
                                                        )
                                                    "
                                                    name="header_button1_text"
                                                    :help="
                                                        rules.header_button1_text
                                                            ? rules.header_button1_text
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_button1_text
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.header_button1_text
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.header_button1_text'
                                                                    ),
                                                                ]
                                                            )
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                            <a-col
                                                :span="8"
                                                v-if="formData.header_button1_show == '1'"
                                            >
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_button1_url'
                                                        )
                                                    "
                                                    name="header_button1_url"
                                                    :help="
                                                        rules.header_button1_url
                                                            ? rules.header_button1_url
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_button1_url
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.header_button1_url
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.header_button1_url'
                                                                    ),
                                                                ]
                                                            )
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                        </a-row>

                                        <a-row :gutter="16">
                                            <a-col :span="8">
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_button2_show'
                                                        )
                                                    "
                                                    name="header_button2_show"
                                                    :help="
                                                        rules.header_button2_show
                                                            ? rules.header_button2_show
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_button2_show
                                                            ? 'error'
                                                            : null
                                                    "
                                                >
                                                    <a-switch
                                                        v-model:checked="
                                                            formData.header_button2_show
                                                        "
                                                        checkedValue="1"
                                                        unCheckedValue="0"
                                                    />
                                                </a-form-item>
                                            </a-col>
                                            <a-col
                                                :span="8"
                                                v-if="formData.header_button2_show == '1'"
                                            >
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_button2_text'
                                                        )
                                                    "
                                                    name="header_button2_text"
                                                    :help="
                                                        rules.header_button2_text
                                                            ? rules.header_button2_text
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_button2_text
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.header_button2_text
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.header_button2_text'
                                                                    ),
                                                                ]
                                                            )
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                            <a-col
                                                :span="8"
                                                v-if="formData.header_button2_show == '1'"
                                            >
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_button2_url'
                                                        )
                                                    "
                                                    name="header_button2_url"
                                                    :help="
                                                        rules.header_button2_url
                                                            ? rules.header_button2_url
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_button2_url
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.header_button2_url
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.header_button2_url'
                                                                    ),
                                                                ]
                                                            )
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                        </a-row>

                                        <a-row :gutter="16">
                                            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                                <a-typography-title
                                                    :level="5"
                                                    :style="{
                                                        marginBottom: '10px',
                                                    }"
                                                >
                                                    {{
                                                        $t(
                                                            "website_settings.header_features"
                                                        )
                                                    }}
                                                </a-typography-title>
                                                <DynamicFormFeatures
                                                    :data="formData.header_features"
                                                    :addText="
                                                        $t('website_settings.add_feature')
                                                    "
                                                    @onEntry="
                                                        (allTags) =>
                                                            (formData.header_features = allTags)
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
                                </template>
                                <template
                                    v-else-if="subTabActiveKey[0] == 'header_client'"
                                >
                                    <a-form layout="vertical">
                                        <a-row :gutter="16">
                                            <a-col :span="24">
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_client_show'
                                                        )
                                                    "
                                                    name="header_client_show"
                                                    :help="
                                                        rules.header_client_show
                                                            ? rules.header_client_show
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_client_show
                                                            ? 'error'
                                                            : null
                                                    "
                                                >
                                                    <a-switch
                                                        v-model:checked="
                                                            formData.header_client_show
                                                        "
                                                        checkedValue="1"
                                                        unCheckedValue="0"
                                                    />
                                                </a-form-item>
                                            </a-col>
                                        </a-row>

                                        <template
                                            v-if="formData.header_client_show == '1'"
                                        >
                                            <a-row :gutter="16">
                                                <a-col
                                                    :xs="24"
                                                    :sm="24"
                                                    :md="24"
                                                    :lg="24"
                                                >
                                                    <a-form-item
                                                        :label="
                                                            $t(
                                                                'website_settings.header_client_name'
                                                            )
                                                        "
                                                        name="header_client_name"
                                                        :help="
                                                            rules.header_client_name
                                                                ? rules.header_client_name
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.header_client_name
                                                                ? 'error'
                                                                : null
                                                        "
                                                        class="required"
                                                    >
                                                        <a-input
                                                            v-model:value="
                                                                formData.header_client_name
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.header_client_name'
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
                                                                'website_settings.header_client_text'
                                                            )
                                                        "
                                                        name="header_client_text"
                                                        :help="
                                                            rules.header_client_text
                                                                ? rules.header_client_text
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.header_client_text
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-textarea
                                                            v-model:value="
                                                                formData.header_client_text
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.header_client_text'
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
                                                <a-col :xs="24" :sm="8" :md="8" :lg="8">
                                                    <a-form-item
                                                        :label="
                                                            $t(
                                                                'website_settings.header_client_image'
                                                            )
                                                        "
                                                        name="header_client_image"
                                                        :help="
                                                            rules.header_client_image
                                                                ? rules
                                                                      .header_client_image
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.header_client_image
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <Upload
                                                            :formData="formData"
                                                            folder="website"
                                                            imageField="header_client_image"
                                                            @onFileUploaded="
                                                                (file) => {
                                                                    formData.header_client_image =
                                                                        file.file;
                                                                    formData.header_client_image_url =
                                                                        file.file_url;
                                                                }
                                                            "
                                                        />
                                                    </a-form-item>
                                                </a-col>
                                            </a-row>
                                        </template>

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
                                </template>
                                <template v-else>
                                    <a-form layout="vertical">
                                        <a-row :gutter="16">
                                            <a-col :xs="24" :sm="24" :md="24" :lg="24">
                                                <a-form-item
                                                    :label="
                                                        $t('website_settings.app_name')
                                                    "
                                                    name="app_name"
                                                    :help="
                                                        rules.app_name
                                                            ? rules.app_name.message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.app_name ? 'error' : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="formData.app_name"
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.app_name'
                                                                    ),
                                                                ]
                                                            )
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                        </a-row>

                                        <a-row :gutter="16">
                                            <a-col :xs="24" :sm="8" :md="12" :lg="12">
                                                <a-form-item
                                                    :label="
                                                        $t('website_settings.header_logo')
                                                    "
                                                    name="header_logo"
                                                    :help="
                                                        rules.header_logo
                                                            ? rules.header_logo.message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_logo ? 'error' : null
                                                    "
                                                >
                                                    <Upload
                                                        :formData="formData"
                                                        folder="website"
                                                        imageField="header_logo"
                                                        @onFileUploaded="
                                                            (file) => {
                                                                formData.header_logo =
                                                                    file.file;
                                                                formData.header_logo_url =
                                                                    file.file_url;
                                                            }
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                            <a-col :xs="24" :sm="16" :md="12" :lg="12">
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.header_sidebar_logo'
                                                        )
                                                    "
                                                    name="header_sidebar_logo"
                                                    :help="
                                                        rules.header_sidebar_logo
                                                            ? rules.header_sidebar_logo
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.header_sidebar_logo
                                                            ? 'error'
                                                            : null
                                                    "
                                                >
                                                    <Upload
                                                        :formData="formData"
                                                        folder="website"
                                                        imageField="header_sidebar_logo"
                                                        @onFileUploaded="
                                                            (file) => {
                                                                formData.header_sidebar_logo =
                                                                    file.file;
                                                                formData.header_sidebar_logo_url =
                                                                    file.file_url;
                                                            }
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                        </a-row>

                                        <a-row :gutter="16">
                                            <a-col :span="8">
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.login_button_show'
                                                        )
                                                    "
                                                    name="login_button_show"
                                                    :help="
                                                        rules.login_button_show
                                                            ? rules.login_button_show
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.login_button_show
                                                            ? 'error'
                                                            : null
                                                    "
                                                >
                                                    <a-switch
                                                        v-model:checked="
                                                            formData.login_button_show
                                                        "
                                                        checkedValue="1"
                                                        unCheckedValue="0"
                                                    />
                                                </a-form-item>
                                            </a-col>
                                            <a-col
                                                :span="16"
                                                v-if="formData.login_button_show == '1'"
                                            >
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.login_button_text'
                                                        )
                                                    "
                                                    name="login_button_text"
                                                    :help="
                                                        rules.login_button_text
                                                            ? rules.login_button_text
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.login_button_text
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.login_button_text
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.login_button_text'
                                                                    ),
                                                                ]
                                                            )
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                        </a-row>

                                        <a-row :gutter="16">
                                            <a-col :span="8">
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.register_button_show'
                                                        )
                                                    "
                                                    name="register_button_show"
                                                    :help="
                                                        rules.register_button_show
                                                            ? rules.register_button_show
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.register_button_show
                                                            ? 'error'
                                                            : null
                                                    "
                                                >
                                                    <a-switch
                                                        v-model:checked="
                                                            formData.register_button_show
                                                        "
                                                        checkedValue="1"
                                                        unCheckedValue="0"
                                                    />
                                                </a-form-item>
                                            </a-col>
                                            <a-col
                                                :span="16"
                                                v-if="
                                                    formData.register_button_show == '1'
                                                "
                                            >
                                                <a-form-item
                                                    :label="
                                                        $t(
                                                            'website_settings.register_button_text'
                                                        )
                                                    "
                                                    name="register_button_text"
                                                    :help="
                                                        rules.register_button_text
                                                            ? rules.register_button_text
                                                                  .message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.register_button_text
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.register_button_text
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.register_button_text'
                                                                    ),
                                                                ]
                                                            )
                                                        "
                                                    />
                                                </a-form-item>
                                            </a-col>
                                        </a-row>

                                        <FormItemHeading>
                                            {{ $t("website_settings.text_settings") }}
                                        </FormItemHeading>

                                        <a-row :gutter="16">
                                            <a-col :xs="24" :sm="24" :md="12" :lg="12">
                                                <a-form-item
                                                    :label="
                                                        $t('website_settings.home_text')
                                                    "
                                                    name="home_text"
                                                    :help="
                                                        rules.home_text
                                                            ? rules.home_text.message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.home_text ? 'error' : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="formData.home_text"
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.home_text'
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
                                                            'website_settings.features_text'
                                                        )
                                                    "
                                                    name="features_text"
                                                    :help="
                                                        rules.features_text
                                                            ? rules.features_text.message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.features_text
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.features_text
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.features_text'
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
                                                            'website_settings.pricing_text'
                                                        )
                                                    "
                                                    name="pricing_text"
                                                    :help="
                                                        rules.pricing_text
                                                            ? rules.pricing_text.message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.pricing_text
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.pricing_text
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.pricing_text'
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
                                                            'website_settings.contact_text'
                                                        )
                                                    "
                                                    name="contact_text"
                                                    :help="
                                                        rules.contact_text
                                                            ? rules.contact_text.message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.contact_text
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.contact_text
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.contact_text'
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
                                                            'website_settings.register_text'
                                                        )
                                                    "
                                                    name="register_text"
                                                    :help="
                                                        rules.register_text
                                                            ? rules.register_text.message
                                                            : null
                                                    "
                                                    :validateStatus="
                                                        rules.register_text
                                                            ? 'error'
                                                            : null
                                                    "
                                                    class="required"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formData.register_text
                                                        "
                                                        :placeholder="
                                                            $t(
                                                                'common.placeholder_default_text',
                                                                [
                                                                    $t(
                                                                        'website_settings.register_text'
                                                                    ),
                                                                ]
                                                            )
                                                        "
                                                    />
                                                </a-form-item>
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
                                </template>
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
import HeaderFeatures from "./HeaderFeatures.vue";
import Upload from "../../../common/core/ui/file/Upload.vue";
import FormItemHeading from "../../../common/components/common/typography/FormItemHeading.vue";
import DynamicFormFeatures from "./features/DynamicFormFeatures.vue";
import DefaultWebsiteLang from "./common/DefaultWebsiteLang.vue";

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
        HeaderFeatures,
        Upload,
        FormItemHeading,
        DynamicFormFeatures,
        DefaultWebsiteLang,
    },
    setup() {
        const websiteSettings = landingWebsite();

        return {
            ...websiteSettings,
        };
    },
};
</script>
