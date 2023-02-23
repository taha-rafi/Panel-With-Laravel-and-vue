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
                    height: '53px',
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
                                $router.push({ name: 'superadmin.dashboard.index' });
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
                                $router.push({ name: 'superadmin.companies.index' });
                            }
                        "
                        key="companies"
                    >
                        <ShopOutlined />
                        <span>{{ $t("menu.companies") }}</span>
                    </a-menu-item>

                    <LeftSideBarMainHeading
                        :title="$t('menu.writerSettings')"
                        :visible="menuCollapsed"
                    />

                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'superadmin.writer_category.index',
                                });
                            }
                        "
                        key="writer_categories"
                    >
                        <UnorderedListOutlined />
                        <span>{{ $t("menu.writer_categories") }}</span>
                    </a-menu-item>

                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'superadmin.writer_template.index',
                                });
                            }
                        "
                        key="writer_templates"
                    >
                        <SnippetsOutlined />
                        <span>{{ $t("menu.writer_templates") }}</span>
                    </a-menu-item>

                    <LeftSideBarMainHeading
                        :title="$t('menu.subscription_settings')"
                        :visible="menuCollapsed"
                    />

                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'superadmin.subscriptions.plans.index',
                                });
                            }
                        "
                        key="subscriptions"
                    >
                        <DollarOutlined />
                        <span>{{ $t("menu.subscriptions") }}</span>
                    </a-menu-item>

                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'superadmin.payment_transactions.index',
                                });
                            }
                        "
                        key="payment_transactions"
                    >
                        <CalculatorOutlined />
                        <span>{{ $t("menu.payment_transactions") }}</span>
                    </a-menu-item>

                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'superadmin.offline_requests.index',
                                });
                            }
                        "
                        key="offline_requests"
                    >
                        <ShopOutlined />
                        <span>{{ $t("menu.offline_requests") }}</span>
                    </a-menu-item>

                    <!-- <a-menu-item
						@click="
							() => {
								menuSelected();
								$router.push({
									name: 'superadmin.payment_settings.paypal.index',
								});
							}
						"
						key="payment_settings"
					>
						<DollarOutlined />
						<span>{{ $t("menu.payment_settings") }}</span>
					</a-menu-item> -->

                    <LeftSideBarMainHeading
                        :title="$t('menu.front_settings')"
                        :visible="menuCollapsed"
                    />

                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'superadmin.website_settings.header.index',
                                });
                            }
                        "
                        key="website_settings"
                    >
                        <GlobalOutlined />
                        <span>{{ $t("menu.website_settings") }}</span>
                    </a-menu-item>

                    <LeftSideBarMainHeading
                        :title="$t('menu.settings')"
                        :visible="menuCollapsed"
                    />
                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({ name: 'superadmin.users.index' });
                            }
                        "
                        key="users"
                    >
                        <TeamOutlined />
                        <span>{{ $t("menu.superadmins") }}</span>
                    </a-menu-item>
                    <a-menu-item
                        @click="
                            () => {
                                menuSelected();
                                $router.push({
                                    name: 'superadmin.settings.profile.index',
                                });
                            }
                        "
                        key="settings"
                    >
                        <SettingOutlined />
                        <span>{{ $t("menu.settings") }}</span>
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
    ShopOutlined,
    LogoutOutlined,
    CloseOutlined,
    SettingOutlined,
    TeamOutlined,
    DollarOutlined,
    GlobalOutlined,
    CalculatorOutlined,
    UnorderedListOutlined,
    SnippetsOutlined,
} from "@ant-design/icons-vue";
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import common from "../../common/composable/common";
import LeftSideBarMainHeading from "../../common/components/common/typography/LeftSideBarMainHeading.vue";
const { Sider } = Layout;

export default defineComponent({
    components: {
        Sider,
        PerfectScrollbar,
        Layout,

        HomeOutlined,
        ShopOutlined,
        LogoutOutlined,
        CloseOutlined,
        SettingOutlined,
        TeamOutlined,
        DollarOutlined,
        GlobalOutlined,
        CalculatorOutlined,
        UnorderedListOutlined,
        SnippetsOutlined,
        LeftSideBarMainHeading,
    },
    setup(props, { emit }) {
        const { appSetting, user, appModules, menuCollapsed } = common();
        const rootSubmenuKeys = [
            "dashboard",
            "companies",
            "subscriptions",
            "payment_transactions",
            "users",
            "payment_settings",
            "website_settings",
            "settings",
            "writer_categories",
            "writer_templates",
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
            } else if (route.meta.menuParent == "payment_settings") {
                menuKey = "payment_settings";
            } else if (route.meta.menuParent == "website_settings") {
                menuKey = "website_settings";
            } else if (route.meta.menuParent == "subscriptions") {
                menuKey = "subscriptions";
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
            } else if (newVal.meta.menuParent == "payment_settings") {
                selectedKeys.value = ["payment_settings"];
            } else if (newVal.meta.menuParent == "website_settings") {
                selectedKeys.value = ["website_settings"];
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
            user,
            appModules,
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
