<template>
    <div class="setting-sidebar">
        <perfect-scrollbar
            :options="{
                wheelSpeed: 1,
                swipeEasing: true,
                suppressScrollX: true,
            }"
        >
            <a-menu v-model:selectedKeys="selectedKeys">
                <a-menu-item
                    key="company"
                    @click="$router.push({ name: 'superadmin.settings.company.index' })"
                >
                    <template #icon>
                        <LaptopOutlined />
                    </template>
                    {{ $t("menu.company") }}
                </a-menu-item>
                <a-menu-item
                    key="profile"
                    @click="$router.push({ name: 'superadmin.settings.profile.index' })"
                >
                    <template #icon>
                        <UserOutlined />
                    </template>
                    {{ $t("menu.profile") }}
                </a-menu-item>
                <a-menu-item
                    key="translations"
                    @click="
                        $router.push({ name: 'superadmin.settings.translations.index' })
                    "
                >
                    <template #icon>
                        <TranslationOutlined />
                    </template>
                    {{ $t("menu.translations") }}
                </a-menu-item>
                <a-menu-item
                    key="currencies"
                    @click="
                        $router.push({ name: 'superadmin.settings.currencies.index' })
                    "
                >
                    <template #icon>
                        <DollarOutlined />
                    </template>
                    {{ $t("menu.currencies") }}
                </a-menu-item>
                <a-menu-item
                    key="modules"
                    @click="$router.push({ name: 'superadmin.settings.modules.index' })"
                >
                    <template #icon>
                        <AppstoreAddOutlined />
                    </template>
                    {{ $t("menu.modules") }}
                </a-menu-item>
                <a-menu-item
                    key="storage_settings"
                    @click="$router.push({ name: 'superadmin.settings.storage.index' })"
                >
                    <template #icon>
                        <FolderOpenOutlined />
                    </template>
                    {{ $t("menu.storage_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="email_settings"
                    @click="$router.push({ name: 'superadmin.settings.email.index' })"
                >
                    <template #icon>
                        <MailOutlined />
                    </template>
                    {{ $t("menu.email_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="white_label"
                    @click="
                        $router.push({ name: 'superadmin.settings.white_label.index' })
                    "
                >
                    <template #icon>
                        <TrademarkCircleOutlined />
                    </template>
                    {{ $t("menu.white_label") }}
                </a-menu-item>
                <a-menu-item
                    key="database_backup"
                    @click="
                        $router.push({
                            name: 'superadmin.settings.database_backup.index',
                        })
                    "
                >
                    <template #icon>
                        <DatabaseOutlined />
                    </template>
                    {{ $t("menu.database_backup") }}
                </a-menu-item>
                <a-menu-item
                    key="update_app"
                    @click="
                        $router.push({ name: 'superadmin.settings.update_app.index' })
                    "
                >
                    <template #icon>
                        <HistoryOutlined />
                    </template>
                    {{ $t("menu.update_app") }}
                </a-menu-item>
            </a-menu>
        </perfect-scrollbar>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted, watch } from "vue";
import {
    LaptopOutlined,
    UserOutlined,
    TranslationOutlined,
    ShopOutlined,
    SolutionOutlined,
    ScheduleOutlined,
    DollarOutlined,
    AccountBookOutlined,
    AppstoreAddOutlined,
    ApartmentOutlined,
    FolderOpenOutlined,
    MailOutlined,
    HistoryOutlined,
    FormOutlined,
    DatabaseOutlined,
    TrademarkCircleOutlined,
} from "@ant-design/icons-vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import common from "../../../common/composable/common";

export default defineComponent({
    components: {
        LaptopOutlined,
        UserOutlined,
        TranslationOutlined,
        ShopOutlined,
        SolutionOutlined,
        ScheduleOutlined,
        DollarOutlined,
        AccountBookOutlined,
        AppstoreAddOutlined,
        ApartmentOutlined,
        FolderOpenOutlined,
        MailOutlined,
        HistoryOutlined,
        FormOutlined,
        DatabaseOutlined,
        TrademarkCircleOutlined,
    },
    setup() {
        const route = useRoute();
        const store = useStore();
        const selectedKeys = ref([]);

        onMounted(() => {
            const menuKey =
                typeof route.meta.menuKey == "function"
                    ? route.meta.menuKey(route)
                    : route.meta.menuKey;

            selectedKeys.value = [menuKey.replace("-", "_")];
        });

        watch(route, (newVal, oldVal) => {
            const menuKey =
                typeof newVal.meta.menuKey == "function"
                    ? newVal.meta.menuKey(newVal)
                    : newVal.meta.menuKey;

            selectedKeys.value = [menuKey.replace("-", "_")];
        });

        return {
            selectedKeys,
        };
    },
});
</script>

<style lang="less">
.setting-sidebar .ps {
    height: calc(100vh - 145px);
}
</style>
