<template>
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

        <a-menu-item @click="logout" key="logout">
            <LogoutOutlined />
            <span>{{ $t("menu.logout") }}</span>
        </a-menu-item>
    </a-menu>
</template>

<script>
import { defineComponent, ref, watch, onMounted, computed } from "vue";
import { Layout } from "ant-design-vue";
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import { HomeOutlined, LogoutOutlined } from "@ant-design/icons-vue";
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import common from "../../common/composable/common";
const { Sider } = Layout;

export default defineComponent({
    props: ["collapsed"],
    components: {
        Sider,
        PerfectScrollbar,
        Layout,

        HomeOutlined,
        LogoutOutlined,
    },
    setup(props, { emit }) {
        const { appSetting, user, appModules, cssSettings } = common();
        const rootSubmenuKeys = ["dashboard"];
        const store = useStore();
        const route = useRoute();

        const openKeys = ref([]);
        const selectedKeys = ref([]);
        const mode = ref("horizontal");

        onMounted(() => {
            setSelectedKeys(route);
        });

        const logout = () => {
            store.dispatch("auth/logout");
        };

        const menuSelected = () => {
            emit("menuSelected");
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

        const setSelectedKeys = (newVal) => {
            const menuKey =
                typeof newVal.meta.menuKey == "function"
                    ? newVal.meta.menuKey(newVal)
                    : newVal.meta.menuKey;

            if (newVal.meta.menuParent == "settings") {
                selectedKeys.value = ["settings"];
            } else {
                selectedKeys.value = [menuKey.replace("-", "_")];
            }

            if (cssSettings.value.headerMenuMode == "horizontal") {
                openKeys.value = [];
            } else {
                openKeys.value = [newVal.meta.menuParent];
            }
        };

        watch(route, (newVal, oldVal) => {
            setSelectedKeys(newVal);
        });

        return {
            mode,
            selectedKeys,
            openKeys,
            logout,
            innerWidth: window.innerWidth,

            onOpenChange,
            menuSelected,
            appSetting,
            user,
            appModules,
        };
    },
});
</script>

<style lang="less"></style>
