<template>
    <div class="notificaiton-setting-bar">
        <perfect-scrollbar
            :options="{
                wheelSpeed: 1,
                swipeEasing: true,
                suppressScrollX: true,
            }"
        >
            <a-card class="page-content-container">
                <template #title>
                    <div :style="{ marginTop: '8px', paddingBottom: '14px' }">
                        {{ $t("mail_settings.send_mail_for") }}
                    </div>
                </template>
                <a-checkbox-group
                    v-model:value="settings"
                    style="width: 100%"
                    @change="settingsChanged"
                >
                    <a-row>
                        <!-- Staff Member -->
                        <a-col :span="24" class="mb-5">
                            <a-typography-title :level="5">
                                {{ $t("menu.staff_members") }}
                                <TooltipCompany />
                            </a-typography-title>
                        </a-col>
                        <a-col :span="24" class="mb-5">
                            <a-checkbox value="staff_member_create">
                                {{ $t("common.on_create") }}
                            </a-checkbox>
                        </a-col>
                        <a-col :span="24" class="mb-5">
                            <a-checkbox value="staff_member_update">
                                {{ $t("common.on_update") }}
                            </a-checkbox>
                        </a-col>
                        <a-col :span="24" class="mb-5">
                            <a-checkbox value="staff_member_delete">
                                {{ $t("common.on_delete") }}
                            </a-checkbox>
                        </a-col>
                        <a-divider />
                    </a-row>
                </a-checkbox-group>
            </a-card>
        </perfect-scrollbar>
    </div>
</template>
<script>
import { onMounted, ref } from "vue";
import { message } from "ant-design-vue";
import { useI18n } from "vue-i18n";
import apiAdmin from "../../../../../common/composable/apiAdmin";
import { getUrlByAppType } from "../../../../../common/scripts/functions";
import TooltipCompany from "./TooltipCompany.vue";

export default {
    props: ["sendMailSettings"],
    components: {
        TooltipCompany,
    },
    setup(props) {
        const { addEditRequestAdmin } = apiAdmin();
        const { t } = useI18n();
        const settings = ref([]);

        onMounted(() => {
            settings.value = props.sendMailSettings.credentials;
        });

        const settingsChanged = (checkedValue) => {
            addEditRequestAdmin({
                url: getUrlByAppType(`settings/email/send-mail-settings`),
                data: { name_key: "company", settings: checkedValue },
                success: (res) => {
                    message.success(t("mail_settings.send_mail_setting_saved"));
                },
            });
        };

        return {
            settings,
            settingsChanged,
        };
    },
};
</script>

<style lang="less">
.notificaiton-setting-bar .ps {
    height: calc(100vh - 145px);
}
</style>
