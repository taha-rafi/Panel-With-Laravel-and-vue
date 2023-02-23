<template>
    <SuperAdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.white_label`)" class="p-0" />
        </template>
        <template #breadcrumb>
            <a-breadcrumb separator="-" style="font-size: 12px">
                <a-breadcrumb-item>
                    <router-link :to="{ name: 'admin.dashboard.index' }">
                        {{ $t(`menu.dashboard`) }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t("menu.settings") }}
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t("menu.white_label") }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </SuperAdminPageHeader>

    <a-row>
        <a-col :xs="24" :sm="24" :md="24" :lg="4" :xl="4" class="bg-setting-sidebar">
            <SettingSidebar />
        </a-col>
        <a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
            <a-card class="page-content-container">
                <WhiteLabelSetting />
            </a-card>
        </a-col>
    </a-row>
</template>

<script>
import SettingSidebar from "../SettingSidebar.vue";
import SuperAdminPageHeader from "../../../layouts/SuperAdminPageHeader.vue";
import WhiteLabelSetting from "../../WhiteLabelSetting.vue";

export default {
    components: {
        SettingSidebar,
        SuperAdminPageHeader,
        WhiteLabelSetting,
    },
    setup() {
        return {};
    },
};
</script>
