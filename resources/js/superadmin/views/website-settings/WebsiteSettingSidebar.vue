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
                    key="website_header_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.header.index',
                        })
                    "
                >
                    <template #icon>
                        <GlobalOutlined />
                    </template>
                    {{ $t("menu.website_header_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_clients_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.clients.index',
                        })
                    "
                >
                    <template #icon>
                        <TeamOutlined />
                    </template>
                    {{ $t("menu.website_clients_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_testimonials_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.testimonials.index',
                        })
                    "
                >
                    <template #icon>
                        <MessageOutlined />
                    </template>
                    {{ $t("menu.website_testimonials_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_features_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.features.index',
                        })
                    "
                >
                    <template #icon>
                        <ProfileOutlined />
                    </template>
                    {{ $t("menu.website_features_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_contact_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.contact.index',
                        })
                    "
                >
                    <template #icon>
                        <ContactsOutlined />
                    </template>
                    {{ $t("menu.website_contact_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_price_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.price.index',
                        })
                    "
                >
                    <template #icon>
                        <MoneyCollectOutlined />
                    </template>
                    {{ $t("menu.website_price_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_faq_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.faq.index',
                        })
                    "
                >
                    <template #icon>
                        <QuestionCircleOutlined />
                    </template>
                    {{ $t("menu.website_faq_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_footer_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.footer.index',
                        })
                    "
                >
                    <template #icon>
                        <PicCenterOutlined />
                    </template>
                    {{ $t("menu.website_footer_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_call_to_action_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.call_to_action.index',
                        })
                    "
                >
                    <template #icon>
                        <CodeOutlined />
                    </template>
                    {{ $t("menu.website_call_to_action_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_register_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.register.index',
                        })
                    "
                >
                    <template #icon>
                        <FileSearchOutlined />
                    </template>
                    {{ $t("menu.website_register_settings") }}
                </a-menu-item>
                <a-menu-item
                    key="website_seo_settings"
                    @click="
                        $router.push({
                            name: 'superadmin.website_settings.seo.index',
                        })
                    "
                >
                    <template #icon>
                        <TrophyOutlined />
                    </template>
                    {{ $t("menu.website_seo_settings") }}
                </a-menu-item>
            </a-menu>
        </perfect-scrollbar>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted, watch } from "vue";
import {
    GlobalOutlined,
    TeamOutlined,
    MessageOutlined,
    ProfileOutlined,
    ContactsOutlined,
    MoneyCollectOutlined,
    QuestionCircleOutlined,
    PicCenterOutlined,
    TrophyOutlined,
    CodeOutlined,
    FileSearchOutlined,
} from "@ant-design/icons-vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import common from "../../../common/composable/common";

export default defineComponent({
    components: {
        GlobalOutlined,
        TeamOutlined,
        MessageOutlined,
        ProfileOutlined,
        ContactsOutlined,
        MoneyCollectOutlined,
        QuestionCircleOutlined,
        PicCenterOutlined,
        TrophyOutlined,
        CodeOutlined,
        FileSearchOutlined,
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
