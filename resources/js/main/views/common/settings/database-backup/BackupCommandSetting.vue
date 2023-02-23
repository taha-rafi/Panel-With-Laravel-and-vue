<template>
    <a-button type="primary" @click="openDrawer">
        <template #icon> <SettingOutlined /> </template>
        {{ $t("database_backup.settings") }}
    </a-button>

    <a-drawer
        :title="$t('database_backup.backup_command_setting')"
        :width="drawerWidth"
        :visible="visible"
        :body-style="{ paddingBottom: '80px' }"
        :footer-style="{ textAlign: 'right' }"
        :maskClosable="false"
        @close="onClose"
    >
        <a-form layout="vertical">
            <a-row :gutter="16" class="mb-10">
                <a-col :span="24">
                    <a-alert
                        type="warning"
                        showIcon
                        :message="$t('database_backup.put_dump_path_command_on_env_file')"
                    />
                </a-col>
            </a-row>

            <a-row :gutter="16">
                <a-col :span="24">
                    <a-typography-paragraph>
                        <blockquote>
                            <a-typography-text type="warning">
                                {{ $t("database_backup.window_command_path") }}
                            </a-typography-text>
                        </blockquote>
                        <blockquote>
                            <a-typography-text type="warning">
                                {{ $t("database_backup.laragon_command_path") }}
                            </a-typography-text>
                        </blockquote>
                        <blockquote>
                            <a-typography-text type="warning">
                                {{ $t("database_backup.linux_command_path") }}
                            </a-typography-text>
                        </blockquote>
                    </a-typography-paragraph>
                </a-col>
            </a-row>
        </a-form>
        <template #footer>
            <a-button @click="onClose">
                {{ $t("common.cancel") }}
            </a-button>
        </template>
    </a-drawer>
</template>

<script>
import { defineComponent, ref } from "vue";
import { SettingOutlined } from "@ant-design/icons-vue";

export default defineComponent({
    components: {
        SettingOutlined,
    },
    setup() {
        const visible = ref(false);

        const openDrawer = () => {
            visible.value = true;
        };

        const onClose = () => {
            visible.value = false;
        };

        return {
            visible,
            onClose,
            openDrawer,

            drawerWidth: window.innerWidth <= 991 ? "90%" : "35%",
        };
    },
});
</script>
