<template>
    <SuperAdminPageHeader>
        <template #header>
            <a-page-header
                :title="$t(`menu.languages`)"
                @back="
                    () =>
                        $router.push({
                            name: 'superadmin.settings.translations.index',
                        })
                "
                class="p-0"
            >
                <template #extra>
                    <a-space>
                        <ImportTranslation
                            :pageTitle="$t('translations.import_translations')"
                            :sampleFileUrl="sampleFileUrl"
                            importUrl="superadmin/translations/import"
                        />
                        <a-button type="primary" @click="addItem">
                            <PlusOutlined />
                            {{ $t("langs.add") }}
                        </a-button>
                    </a-space>
                </template>
            </a-page-header>
        </template>
        <template #breadcrumb>
            <a-breadcrumb separator="-" style="font-size: 12px">
                <a-breadcrumb-item>
                    <router-link :to="{ name: 'superadmin.dashboard.index' }">
                        {{ $t(`menu.dashboard`) }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t(`menu.settings`) }}
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    <router-link
                        :to="{ name: 'superadmin.settings.translations.index' }"
                    >
                        {{ $t(`menu.translations`) }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t(`menu.languages`) }}
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
            <LanguageSettings ref="langSettingRef" panelType="superadmin" />
        </a-col>
    </a-row>
</template>

<script>
import { ref } from "vue";
import { PlusOutlined } from "@ant-design/icons-vue";
import SettingSidebar from "../../SettingSidebar.vue";
import SuperAdminPageHeader from "../../../../layouts/SuperAdminPageHeader.vue";
import LanguageSettings from "../../../../../main/views/common/settings/translations/langs/index.vue";
import ImportTranslation from "../../../../../common/core/ui/Import.vue";

export default {
    components: {
        PlusOutlined,
        SettingSidebar,
        SuperAdminPageHeader,
        LanguageSettings,
        ImportTranslation,
    },
    setup() {
        const langSettingRef = ref(null);
        const sampleFileUrl = window.config.translatioins_sample_file;

        const addItem = () => {
            langSettingRef.value.addItem();
        };

        return {
            langSettingRef,
            addItem,
            sampleFileUrl,
        };
    },
};
</script>
