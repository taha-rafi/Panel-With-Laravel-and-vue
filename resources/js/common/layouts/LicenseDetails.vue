<template>
    <a-alert
        v-if="appEnv == 'production'"
        message="Add Unlimited AI Tools According To Your Requriements"
        type="info"
        show-icon
    >
        <template #icon>
            <HighlightOutlined />
        </template>
        <template #description>
            These AI tools are only for demo purpose. You can create unlimited AI tools
            according to your requirements from superadmin panel.
            <br />
            <a
                href="https://docs-writerifly.codeifly.in/#/writer-template"
                target="_blank"
            >
                Click Here to check document to create AI templates
            </a>
        </template>
    </a-alert>
    <template
        v-if="
            $route &&
            $route.meta &&
            $route.meta.menuKey &&
            $route.meta.menuKey != 'setup_company'
        "
    >
        <a-alert
            v-if="remainingCharacters <= 0"
            :message="$t('subscription_plans.no_character_available')"
            :description="$t('subscription_plans.update_your_character_limit')"
            type="error"
            show-icon
        >
            <template #icon>
                <CrownOutlined />
            </template>
        </a-alert>

        <a-alert
            v-else-if="
                appSetting.subscription_plan &&
                appSetting.subscription_plan.default == 'trial'
            "
            :message="$t('subscription_plans.trial_plan')"
            :description="
                $t('subscription_plans.trial_plan_message', [
                    appSetting.licence_expire_on != ''
                        ? formatDate(appSetting.licence_expire_on)
                        : '',
                ])
            "
            type="warning"
            show-icon
            @close="() => $router.push({ name: 'admin.subscription.change_plan' })"
        >
            <template #icon>
                <CrownOutlined />
            </template>
            <template
                v-if="
                    $route.meta &&
                    $route.meta.menuParent &&
                    $route.meta.menuParent != 'subscription'
                "
                #closeText
            >
                <a-button type="primary">
                    {{ $t("subscription_plans.change_plan") }}
                    <DoubleRightOutlined />
                </a-button>
            </template>
        </a-alert>
    </template>
</template>

<script>
import common from "../composable/common";
import {
    FormOutlined,
    CrownOutlined,
    DoubleRightOutlined,
    HighlightOutlined,
} from "@ant-design/icons-vue";

export default {
    components: {
        FormOutlined,
        CrownOutlined,
        DoubleRightOutlined,
        HighlightOutlined,
    },
    setup() {
        const appEnv = window.config.app_env;
        const { appSetting, formatDate, remainingCharacters } = common();

        return {
            appEnv,
            appSetting,
            formatDate,
            remainingCharacters,
        };
    },
};
</script>

<style></style>
