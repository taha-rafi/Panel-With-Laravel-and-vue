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
            </a-menu>
        </perfect-scrollbar>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted, watch } from "vue";
import {
    LaptopOutlined,
    FilePdfOutlined,
    FormOutlined,
    BankOutlined,
} from "@ant-design/icons-vue";
import { useRoute } from "vue-router";

export default defineComponent({
    components: {
        LaptopOutlined,
        FilePdfOutlined,
        FormOutlined,
        BankOutlined,
    },
    setup() {
        const route = useRoute();
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
