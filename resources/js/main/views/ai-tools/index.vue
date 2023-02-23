<template>
    <AdminPageHeader>
        <template #header>
            <a-page-header :title="writerCategory?.name" class="p-0" />
        </template>
        <template #breadcrumb>
            <a-breadcrumb separator="-" style="font-size: 12px">
                <a-breadcrumb-item>
                    <router-link :to="{ name: 'admin.dashboard.index' }">
                        {{ $t(`menu.dashboard`) }}
                    </router-link>
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ $t(`menu.ai_tools`) }}
                </a-breadcrumb-item>
                <a-breadcrumb-item>
                    {{ writerCategory?.name }}
                </a-breadcrumb-item>
            </a-breadcrumb>
        </template>
    </AdminPageHeader>

    <div class="dashboard-page-content-container">
        <a-row class="mt-20" v-if="writerCategory && writerCategory.name">
            <a-col :span="24">
                <a-alert
                    type="success"
                    style="background-color: white; border-color: white"
                    show-icon
                >
                    <template #icon>
                        <a-avatar :size="42" :src="writerCategory.logo_url" />
                    </template>
                    <template #message>
                        {{ writerCategory.name }}
                    </template>
                    <template #description>
                        {{ writerCategory.description }}
                    </template>
                </a-alert>
            </a-col>
        </a-row>

        <a-row :gutter="[15, 15]" class="mt-30 mb-20">
            <a-col
                v-for="allTemplate in allTemplates"
                :key="allTemplate.xid"
                :xs="24"
                :sm="24"
                :md="12"
                :lg="8"
                :xl="8"
            >
                <a-card hoverable>
                    <template #title>
                        <a-space>
                            <a-avatar
                                shape="square"
                                :size="24"
                                :src="allTemplate.logo_url"
                            />
                            <a-typography-text class="mt-5" strong>
                                {{ allTemplate.name }}
                            </a-typography-text>
                        </a-space>
                    </template>
                    <a-card-meta>
                        <template #description>
                            <a-row :gutter="16">
                                <a-col :span="24">
                                    {{ allTemplate.description }}
                                </a-col>
                            </a-row>
                        </template>
                    </a-card-meta>
                    <template #actions>
                        <a-button
                            type="link"
                            @click="
                                () => {
                                    $router.push({
                                        name: 'admin.writer.index',
                                        params: {
                                            category: allTemplate.x_writer_category_id,
                                            id: allTemplate.xid,
                                        },
                                    });
                                }
                            "
                        >
                            <template #icon>
                                <PlayCircleOutlined />
                            </template>
                            {{ $t("writer.start_writing") }}
                        </a-button>
                    </template>
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
import { ref, onMounted, watch } from "vue";
import { PlayCircleOutlined } from "@ant-design/icons-vue";
import { useRoute } from "vue-router";
import common from "../../../common/composable/common";
import AdminPageHeader from "../../../common/layouts/AdminPageHeader.vue";

export default {
    components: {
        PlayCircleOutlined,
        AdminPageHeader,
    },
    setup() {
        const { permsArray } = common();

        const route = useRoute();
        const writerCategory = ref({});
        const allTemplates = ref([]);

        onMounted(() => {
            getInitData(route.params.cat);
        });

        const getInitData = (writerCategoryId) => {
            const writerCategoryPromise = axiosAdmin.get(
                `ai-tools/cateogry/${writerCategoryId}`
            );

            Promise.all([writerCategoryPromise]).then(([writerCategoryResponse]) => {
                writerCategory.value = writerCategoryResponse.data.category;
                allTemplates.value = writerCategoryResponse.data.all_templates;
            });
        };

        watch(route, (newVal, oldVal) => {
            console.log(newVal.meta.menuKey);
            if (newVal.params.cat && newVal.params.cat != undefined) {
                getInitData(newVal.params.cat);
            }
        });

        return {
            permsArray,

            writerCategory,
            allTemplates,
        };
    },
};
</script>
