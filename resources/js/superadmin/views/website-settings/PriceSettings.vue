<template>
    <SuperAdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.website_price_settings`)" class="p-0">
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
                    {{ $t("menu.website_price_settings") }}
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
                                        <a-menu-item key="details_crud">
                                            {{ $t("website_settings.pricing_cards") }}
                                        </a-menu-item>
                                    </a-menu>
                                </div>
                            </a-col>

                            <a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
                                <template v-if="subTabActiveKey[0] == 'details_crud'">
                                    <PriceCard :langKey="activeKey" />
                                </template>
                                <template v-else>
                                    <a-col :span="24">
                                        <a-form layout="vertical">
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
                                                                'website_settings.price_title'
                                                            )
                                                        "
                                                        name="price_title"
                                                        :help="
                                                            rules.price_title
                                                                ? rules.price_title
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.price_title
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-input
                                                            v-model:value="
                                                                formData.price_title
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.price_title'
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
                                                                'website_settings.price_description'
                                                            )
                                                        "
                                                        name="price_description"
                                                        :help="
                                                            rules.price_description
                                                                ? rules.price_description
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.price_description
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-textarea
                                                            v-model:value="
                                                                formData.price_description
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.price_description'
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
                                                                'website_settings.most_popular_image'
                                                            )
                                                        "
                                                        name="most_popular_image"
                                                        :help="
                                                            rules.most_popular_image
                                                                ? rules.most_popular_image
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.most_popular_image
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <Upload
                                                            :formData="formData"
                                                            folder="website"
                                                            imageField="most_popular_image"
                                                            @onFileUploaded="
                                                                (file) => {
                                                                    formData.most_popular_image =
                                                                        file.file;
                                                                    formData.most_popular_image_url =
                                                                        file.file_url;
                                                                }
                                                            "
                                                        />
                                                    </a-form-item>
                                                </a-col>
                                            </a-row>

                                            <FormItemHeading>
                                                {{ $t("website_settings.text_settings") }}
                                            </FormItemHeading>

                                            <a-row :gutter="16">
                                                <a-col
                                                    :xs="24"
                                                    :sm="24"
                                                    :md="12"
                                                    :lg="12"
                                                >
                                                    <a-form-item
                                                        :label="
                                                            $t(
                                                                'website_settings.pricing_billed_monthly_text'
                                                            )
                                                        "
                                                        name="pricing_billed_monthly_text"
                                                        :help="
                                                            rules.pricing_billed_monthly_text
                                                                ? rules
                                                                      .pricing_billed_monthly_text
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.pricing_billed_monthly_text
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-input
                                                            v-model:value="
                                                                formData.pricing_billed_monthly_text
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.pricing_billed_monthly_text'
                                                                        ),
                                                                    ]
                                                                )
                                                            "
                                                        />
                                                    </a-form-item>
                                                </a-col>
                                                <a-col
                                                    :xs="24"
                                                    :sm="24"
                                                    :md="12"
                                                    :lg="12"
                                                >
                                                    <a-form-item
                                                        :label="
                                                            $t(
                                                                'website_settings.pricing_billed_yearly_text'
                                                            )
                                                        "
                                                        name="pricing_billed_yearly_text"
                                                        :help="
                                                            rules.pricing_billed_yearly_text
                                                                ? rules
                                                                      .pricing_billed_yearly_text
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.pricing_billed_yearly_text
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-input
                                                            v-model:value="
                                                                formData.pricing_billed_yearly_text
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.pricing_billed_yearly_text'
                                                                        ),
                                                                    ]
                                                                )
                                                            "
                                                        />
                                                    </a-form-item>
                                                </a-col>
                                            </a-row>

                                            <a-row :gutter="16">
                                                <a-col
                                                    :xs="24"
                                                    :sm="24"
                                                    :md="12"
                                                    :lg="12"
                                                >
                                                    <a-form-item
                                                        :label="
                                                            $t(
                                                                'website_settings.pricing_monthly_text'
                                                            )
                                                        "
                                                        name="pricing_monthly_text"
                                                        :help="
                                                            rules.pricing_monthly_text
                                                                ? rules
                                                                      .pricing_monthly_text
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.pricing_monthly_text
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-input
                                                            v-model:value="
                                                                formData.pricing_monthly_text
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.pricing_monthly_text'
                                                                        ),
                                                                    ]
                                                                )
                                                            "
                                                        />
                                                    </a-form-item>
                                                </a-col>
                                                <a-col
                                                    :xs="24"
                                                    :sm="24"
                                                    :md="12"
                                                    :lg="12"
                                                >
                                                    <a-form-item
                                                        :label="
                                                            $t(
                                                                'website_settings.pricing_yearly_text'
                                                            )
                                                        "
                                                        name="pricing_yearly_text"
                                                        :help="
                                                            rules.pricing_yearly_text
                                                                ? rules
                                                                      .pricing_yearly_text
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.pricing_yearly_text
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-input
                                                            v-model:value="
                                                                formData.pricing_yearly_text
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.pricing_yearly_text'
                                                                        ),
                                                                    ]
                                                                )
                                                            "
                                                        />
                                                    </a-form-item>
                                                </a-col>
                                            </a-row>

                                            <a-row :gutter="16">
                                                <a-col
                                                    :xs="24"
                                                    :sm="24"
                                                    :md="12"
                                                    :lg="12"
                                                >
                                                    <a-form-item
                                                        :label="
                                                            $t(
                                                                'website_settings.pricing_month_text'
                                                            )
                                                        "
                                                        name="pricing_month_text"
                                                        :help="
                                                            rules.pricing_month_text
                                                                ? rules.pricing_month_text
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.pricing_month_text
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-input
                                                            v-model:value="
                                                                formData.pricing_month_text
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.pricing_month_text'
                                                                        ),
                                                                    ]
                                                                )
                                                            "
                                                        />
                                                    </a-form-item>
                                                </a-col>
                                                <a-col
                                                    :xs="24"
                                                    :sm="24"
                                                    :md="12"
                                                    :lg="12"
                                                >
                                                    <a-form-item
                                                        :label="
                                                            $t(
                                                                'website_settings.pricing_year_text'
                                                            )
                                                        "
                                                        name="pricing_year_text"
                                                        :help="
                                                            rules.pricing_year_text
                                                                ? rules.pricing_year_text
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.pricing_year_text
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-input
                                                            v-model:value="
                                                                formData.pricing_year_text
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.pricing_year_text'
                                                                        ),
                                                                    ]
                                                                )
                                                            "
                                                        />
                                                    </a-form-item>
                                                </a-col>
                                            </a-row>

                                            <FormItemHeading>
                                                {{ $t("website_settings.pricing_cards") }}
                                            </FormItemHeading>

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
                                                                'website_settings.price_card_title'
                                                            )
                                                        "
                                                        name="price_card_title"
                                                        :help="
                                                            rules.price_card_title
                                                                ? rules.price_card_title
                                                                      .message
                                                                : null
                                                        "
                                                        :validateStatus="
                                                            rules.price_card_title
                                                                ? 'error'
                                                                : null
                                                        "
                                                    >
                                                        <a-input
                                                            v-model:value="
                                                                formData.price_card_title
                                                            "
                                                            :placeholder="
                                                                $t(
                                                                    'common.placeholder_default_text',
                                                                    [
                                                                        $t(
                                                                            'website_settings.price_card_title'
                                                                        ),
                                                                    ]
                                                                )
                                                            "
                                                        />
                                                    </a-form-item>
                                                </a-col>
                                            </a-row>

                                            <a-row :gutter="16">
                                                <a-col
                                                    :xs="24"
                                                    :sm="24"
                                                    :md="24"
                                                    :lg="24"
                                                >
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
import { onMounted, ref, computed } from "vue";
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
import PriceCard from "./PriceCard.vue";
import FormItemHeading from "../../../common/components/common/typography/FormItemHeading.vue";
import Upload from "../../../common/core/ui/file/Upload.vue";

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

        PriceCard,
        FormItemHeading,
        Upload,
    },
    setup() {
        const websiteSettings = landingWebsite();

        return {
            ...websiteSettings,
        };
    },
};
</script>
