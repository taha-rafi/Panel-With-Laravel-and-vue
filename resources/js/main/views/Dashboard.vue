<template>
    <AdminPageHeader>
        <template #header>
            <a-page-header :title="$t(`menu.dashboard`)" style="padding: 0px" />
        </template>
    </AdminPageHeader>

    <div class="dashboard-page-content-container">
        <a-row :gutter="[8, 8]" class="mt-30 mb-10">
            <a-col :xs="24" :sm="24" :md="12" :lg="6" :xl="6">
                <DateRangePicker
                    ref="serachDateRangePicker"
                    @dateTimeChanged="
                        (changedDateTime) => (filters.dates = changedDateTime)
                    "
                />
            </a-col>
        </a-row>

        <div class="mt-30 mb-20">
            <a-row :gutter="[15, 15]">
                <a-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                    <StateWidget bgColor="#08979c">
                        <template #image>
                            <FolderOpenOutlined style="color: #fff; font-size: 24px" />
                        </template>
                        <template #description>
                            <h2 v-if="responseData.stateData">
                                {{ responseData.stateData.workspace_count }}
                            </h2>
                            <p>{{ $t("dashboard.total_workspace") }}</p>
                        </template>
                    </StateWidget>
                </a-col>

                <a-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                    <StateWidget bgColor="#389e0d">
                        <template #image>
                            <FileTextOutlined style="color: #fff; font-size: 24px" />
                        </template>
                        <template #description>
                            <h2 v-if="responseData.stateData">
                                {{ responseData.stateData.document_count }}
                            </h2>
                            <p>{{ $t("dashboard.document_generated") }}</p>
                        </template>
                    </StateWidget>
                </a-col>

                <a-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                    <StateWidget bgColor="#d46b08">
                        <template #image>
                            <RiseOutlined style="color: #fff; font-size: 24px" />
                        </template>
                        <template #description>
                            <h2 v-if="responseData.stateData">
                                {{ responseData.stateData.character_generated }}
                            </h2>
                            <p>{{ $t("dashboard.character_generated") }}</p>
                        </template>
                    </StateWidget>
                </a-col>
            </a-row>
        </div>

        <a-row :gutter="[18, 18]" class="mt-30 mb-20">
            <a-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                <a-card :title="$t('dashboard.generated_character_history')">
                    <CharacterHistory :data="responseData" />
                </a-card>
            </a-col>
        </a-row>
    </div>
</template>

<script>
import { onMounted, reactive, ref, watch } from "vue";
import {
    FolderOpenOutlined,
    FileTextOutlined,
    RiseOutlined,
} from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import AdminPageHeader from "../../common/layouts/AdminPageHeader.vue";
import StateWidget from "../../common/components/common/card/StateWidget.vue";
import DateRangePicker from "../../common/components/common/calendar/DateRangePicker.vue";
import CharacterHistory from "../components/dashboard/CharacterHistory.vue";

export default {
    components: {
        AdminPageHeader,
        StateWidget,
        DateRangePicker,
        CharacterHistory,

        FolderOpenOutlined,
        FileTextOutlined,
        RiseOutlined,
    },
    setup() {
        const { t } = useI18n();
        const responseData = ref([]);
        const filters = reactive({
            dates: [],
        });

        onMounted(() => {
            getInitData();
        });

        const getInitData = () => {
            const dashboardPromise = axiosAdmin.post("dashboard", filters);

            Promise.all([dashboardPromise]).then(([dashboardResponse]) => {
                responseData.value = dashboardResponse.data;
            });
        };

        watch([filters], (newVal, oldVal) => {
            getInitData();
        });

        return {
            filters,
            responseData,
        };
    },
};
</script>

<style lang="less">
.ant-card-extra,
.ant-card-head-title {
    padding: 0px;
}

.ant-card-head-title {
    margin-top: 10px;
}
</style>
