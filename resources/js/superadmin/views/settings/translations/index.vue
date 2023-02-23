<template>
    <SuperAdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.translations`)" class="p-0">
                <template #extra>
                    <a-space>
                        <ImportTranslation
                            :pageTitle="$t('translations.import_translations')"
                            :sampleFileUrl="sampleFileUrl"
                            importUrl="superadmin/translations/import"
                            @onUploadSuccess="langAdded"
                        />
                        <LangAddButton
                            @onAddSuccess="langAdded"
                            btnType="primary"
                            :tooltip="false"
                        >
                            {{ $t("langs.add") }}
                        </LangAddButton>
                        <a-button
                            type="primary"
                            @click="
                                $router.push({
                                    name: 'superadmin.settings.langs.index',
                                })
                            "
                        >
                            <EyeOutlined />
                            {{ $t("langs.view_all_langs") }}
                        </a-button>
                    </a-space>
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
                    {{ $t(`menu.settings`) }}
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t("menu.translations") }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </SuperAdminPageHeader>

    <a-row>
        <a-col
            :xs="24"
            :sm="24"
            :md="24"
            :lg="4"
            :xl="4"
            class="bg-setting-sidebar"
        >
            <SettingSidebar />
        </a-col>
        <a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
            <TranslationsSettings ref="transSettingRef" />
        </a-col>
    </a-row>
</template>

<script>
import { ref } from "vue";
import { EyeOutlined } from "@ant-design/icons-vue";
import SettingSidebar from "../SettingSidebar.vue";
import SuperAdminPageHeader from "../../../layouts/SuperAdminPageHeader.vue";
import TranslationsSettings from "../../../../main/views/common/settings/translations/index.vue";
import LangAddButton from "../../../../main/views/common/settings/translations/langs/AddButton.vue";
import ImportTranslation from "../../../../common/core/ui/Import.vue";

export default {
    components: {
        SettingSidebar,
        EyeOutlined,
        SuperAdminPageHeader,
        TranslationsSettings,
        LangAddButton,
        ImportTranslation,
    },
    setup() {
        const transSettingRef = ref(null);
        const sampleFileUrl = window.config.translatioins_sample_file;

        const langAdded = () => {
            transSettingRef.value.getData();
        };

        return {
            langAdded,
            transSettingRef,
            sampleFileUrl,
        };
    },
};
</script>
