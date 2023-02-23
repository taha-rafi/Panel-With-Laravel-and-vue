<template>
    <a-layout-sider
        :width="240"
        :style="{
            margin: '0 0 0 0',
            overflowY: 'auto',
            position: 'fixed',
            paddingTop: '8px',
            zIndex: 998,
        }"
        :trigger="null"
        :collapsed="menuCollapsed"
        :theme="appSetting.left_sidebar_theme"
        class="sidebar-right-border"
    >
        <div v-if="menuCollapsed" class="logo">
            <img
                :style="{
                    height: '32px',
                }"
                :src="
                    appSetting.left_sidebar_theme == 'dark'
                        ? appSetting.small_dark_logo_url
                        : appSetting.small_light_logo_url
                "
            />
        </div>
        <div v-else>
            <img
                :style="{
                    width: '150px',
                    paddingLeft: appSetting.rtl ? '0px' : '30px',
                    paddingRight: appSetting.rtl ? '30px' : '0px',
                    paddingTop: '5px',
                    paddingBottom: '20px',
                    marginLeft: appSetting.rtl ? '0px' : '10px',
                    marginRight: appSetting.rtl ? '10px' : '0px',
                }"
                :src="
                    appSetting.left_sidebar_theme == 'dark'
                        ? appSetting.dark_logo_url
                        : appSetting.light_logo_url
                "
            />
            <CloseOutlined
                v-if="innerWidth <= 991"
                :style="{
                    marginLeft: appSetting.rtl ? '0px' : '45px',
                    marginRight: appSetting.rtl ? '45px' : '0px',
                    verticalAlign: 'super',
                    color: appSetting.left_sidebar_theme == 'dark' ? '#fff' : '#000000',
                }"
                @click="menuSelected"
            />
        </div>

        <div class="main-sidebar">
            <perfect-scrollbar
                :options="{
                    wheelSpeed: 1,
                    swipeEasing: true,
                    suppressScrollX: true,
                }"
            >
                <a-menu
                    :theme="appSetting.left_sidebar_theme"
                    :openKeys="openKeys"
                    v-model:selectedKeys="selectedKeys"
                    :mode="mode"
                    @openChange="onOpenChange"
                    :style="{ borderRight: 'none' }"
                >
                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({ name: 'admin.dashboard.index' });
                            }
                        "
                        key="dashboard"
                    >
                        <HomeOutlined />
                        <span>{{ $t("menu.dashboard") }}</span>
                    </a-menu-item>
                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'admin.work_spaces.index',
                                });
                            }
                        "
                        key="work_spaces"
                    >
                        <FolderOpenOutlined />
                        <span>{{ $t("menu.work_spaces") }}</span>
                    </a-menu-item>
                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'admin.writer_documents.index',
                                });
                            }
                        "
                        key="writer_documents"
                    >
                        <FileTextOutlined />
                        <span>{{ $t("menu.writer_documents") }}</span>
                    </a-menu-item>

                    <LeftSideBarMainHeading
                        :title="$t('menu.ai_tools')"
                        :visible="menuCollapsed"
                    />

                    <a-menu-item
                        v-for="allWriterCategory in allCategories"
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'admin.ai_tools.index',
                                    params: { cat: allWriterCategory.xid },
                                });
                            }
                        "
                        :key="`writer_+${allWriterCategory.xid}`"
                    >
                        <a-space>
                            <a-avatar :size="18" :src="allWriterCategory.logo_url" />
                            <span>{{ allWriterCategory.name }}</span>
                        </a-space>
                    </a-menu-item>

                    <component
                        v-for="(appModule, index) in appModules"
                        :key="index"
                        v-bind:is="appModule + 'Menu'"
                        @menuSelected="menuSelected"
                    />

                    <LeftSideBarMainHeading
                        :title="$t('menu.subscription')"
                        :visible="menuCollapsed"
                    />
                    <a-menu-item
                        key="current_plan"
                        @click="$router.push({ name: 'admin.subscription.current_plan' })"
                    >
                        <template #icon>
                            <LaptopOutlined />
                        </template>
                        {{ $t("menu.current_plan") }}
                    </a-menu-item>
                    <a-menu-item
                        key="transcations"
                        @click="$router.push({ name: 'admin.subscription.transcations' })"
                    >
                        <template #icon>
                            <FilePdfOutlined />
                        </template>
                        {{ $t("menu.transcations") }}
                    </a-menu-item>
                    <a-menu-item
                        key="offline_requests"
                        @click="
                            $router.push({
                                name: 'admin.subscription.offline_requests',
                                state: { success: false },
                            })
                        "
                    >
                        <template #icon>
                            <BankOutlined />
                        </template>
                        {{ $t("menu.offline_requests") }}
                    </a-menu-item>
                    <a-menu-item
                        key="change_plan"
                        @click="$router.push({ name: 'admin.subscription.change_plan' })"
                    >
                        <template #icon>
                            <FormOutlined />
                        </template>
                        {{ $t("menu.change_plan") }}
                    </a-menu-item>

                    <LeftSideBarMainHeading
                        :title="$t('menu.settings')"
                        :visible="menuCollapsed"
                    />

                    <a-menu-item
                        key="company"
                        @click="$router.push({ name: 'admin.settings.company.index' })"
                    >
                        <template #icon>
                            <LaptopOutlined />
                        </template>
                        {{ $t("menu.company") }}
                    </a-menu-item>
                    <a-menu-item
                        key="profile"
                        @click="$router.push({ name: 'admin.settings.profile.index' })"
                    >
                        <template #icon>
                            <UserOutlined />
                        </template>
                        {{ $t("menu.profile") }}
                    </a-menu-item>

                    <a-menu-item @click="logout" key="logout">
                        <LogoutOutlined />
                        <span>{{ $t("menu.logout") }}</span>
                    </a-menu-item>
                </a-menu>
            </perfect-scrollbar>
        </div>
    </a-layout-sider>
</template>

<script>
import { defineComponent, ref, watch, onMounted, computed } from "vue";
import { Layout } from "ant-design-vue";
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import {
    HomeOutlined,
    LogoutOutlined,
    UserOutlined,
    SettingOutlined,
    CloseOutlined,
    ShoppingOutlined,
    ShoppingCartOutlined,
    AppstoreOutlined,
    ShopOutlined,
    BarChartOutlined,
    CalculatorOutlined,
    TeamOutlined,
    WalletOutlined,
    BankOutlined,
    RocketOutlined,
    LaptopOutlined,
    CarOutlined,
    DollarCircleOutlined,
    FolderOpenOutlined,
    FileTextOutlined,
    FilePdfOutlined,
    FormOutlined,
} from "@ant-design/icons-vue";
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import common from "../../common/composable/common";
import LeftSideBarMainHeading from "../components/common/typography/LeftSideBarMainHeading.vue";
const { Sider } = Layout;

export default defineComponent({
    components: {
        Sider,
        PerfectScrollbar,
        Layout,
        LeftSideBarMainHeading,

        HomeOutlined,
        LogoutOutlined,
        UserOutlined,
        SettingOutlined,
        CloseOutlined,
        ShoppingOutlined,
        ShoppingCartOutlined,
        AppstoreOutlined,
        ShopOutlined,
        BarChartOutlined,
        CalculatorOutlined,
        TeamOutlined,
        WalletOutlined,
        BankOutlined,
        RocketOutlined,
        LaptopOutlined,
        CarOutlined,
        DollarCircleOutlined,

        FolderOpenOutlined,
        FileTextOutlined,
        FilePdfOutlined,
        FormOutlined,
    },
    setup(props, { emit }) {
        const {
            appSetting,
            appType,
            user,
            permsArray,
            appModules,
            menuCollapsed,
            willSubscriptionModuleVisible,
            allCategories,
        } = common();
        const rootSubmenuKeys = [
            "dashboard",
            "current_plan",
            "transcations",
            "offline_requests",
            "change_plan",
            "users",
            "settings",
            "subscription",
        ];
        const store = useStore();
        const route = useRoute();

        const innerWidth = window.innerWidth;
        const openKeys = ref([]);
        const selectedKeys = ref([]);
        const mode = ref("inline");

        onMounted(() => {
            var menuKey =
                typeof route.meta.menuKey == "function"
                    ? route.meta.menuKey(route)
                    : route.meta.menuKey;

            if (route.meta.menuParent == "settings") {
                menuKey = "settings";
            }

            if (route.meta.menuParent == "subscription") {
                menuKey = "subscription";
            }

            if (route.meta.menuParent == "ai_tools") {
                menuKey = `writer_+${route.params.cat}`;
            }

            if (route.meta.menuParent == "writer") {
                menuKey = `writer_+${route.params.category}`;
            }

            if (innerWidth <= 991) {
                openKeys.value = [];
            } else {
                openKeys.value = menuCollapsed.value ? [] : [route.meta.menuParent];
            }

            selectedKeys.value = [menuKey.replace("-", "_")];
        });

        const logout = () => {
            store.dispatch("auth/logout");
        };

        const menuSelected = () => {
            if (innerWidth <= 991) {
                store.commit("auth/updateMenuCollapsed", true);
            }
        };

        const onOpenChange = (currentOpenKeys) => {
            const latestOpenKey = currentOpenKeys.find(
                (key) => openKeys.value.indexOf(key) === -1
            );

            if (rootSubmenuKeys.indexOf(latestOpenKey) === -1) {
                openKeys.value = currentOpenKeys;
            } else {
                openKeys.value = latestOpenKey ? [latestOpenKey] : [];
            }
        };

        watch(route, (newVal, oldVal) => {
            const menuKey =
                typeof newVal.meta.menuKey == "function"
                    ? newVal.meta.menuKey(newVal)
                    : newVal.meta.menuKey;

            if (innerWidth <= 991) {
                openKeys.value = [];
            } else {
                openKeys.value = [newVal.meta.menuParent];
            }

            if (newVal.meta.menuParent == "settings") {
                selectedKeys.value = ["settings"];
            } else if (newVal.meta.menuParent == "subscription") {
                selectedKeys.value = ["subscription"];
            } else if (route.meta.menuParent == "writer") {
                selectedKeys.value = [`writer_+${route.params.category}`];
            } else if (route.meta.menuParent == "ai_tools") {
                selectedKeys.value = [`writer_+${route.params.cat}`];
            } else {
                selectedKeys.value = [menuKey.replace("-", "_")];
            }
        });

        watch(
            () => menuCollapsed.value,
            (newVal, oldVal) => {
                const menuKey =
                    typeof route.meta.menuKey == "function"
                        ? route.meta.menuKey(route)
                        : route.meta.menuKey;

                if (innerWidth <= 991 && menuCollapsed.value) {
                    openKeys.value = [];
                } else {
                    openKeys.value = menuCollapsed.value ? [] : [route.meta.menuParent];
                }

                if (route.meta.menuParent == "settings") {
                    selectedKeys.value = ["settings"];
                } else if (route.meta.menuParent == "subscription") {
                    selectedKeys.value = ["subscription"];
                } else if (route.meta.menuParent == "ai_tools") {
                    selectedKeys.value = [`writer_+${route.params.cat}`];
                } else if (route.meta.menuParent == "writer") {
                    selectedKeys.value = [`writer_+${route.params.category}`];
                } else {
                    selectedKeys.value = [menuKey.replace("-", "_")];
                }
            }
        );

        return {
            mode,
            selectedKeys,
            openKeys,
            logout,
            innerWidth: window.innerWidth,

            onOpenChange,
            menuSelected,
            menuCollapsed,
            appSetting,
            appType,
            user,
            permsArray,
            appModules,
            willSubscriptionModuleVisible,

            allCategories,
        };
    },
});
</script>

<style lang="less">
.main-sidebar .ps {
    height: calc(100vh - 62px);
}

@media only screen and (max-width: 1150px) {
    .ant-layout-sider.ant-layout-sider-collapsed {
        left: -80px !important;
    }
}
</style>
