<template>
    <div :style="affixStyle">
        <a-dropdown
            :placement="
                appSetting.rtl
                    ? position == 'top'
                        ? 'bottomLeft'
                        : 'topLeft'
                    : position == 'top'
                    ? 'bottomRight'
                    : 'topRight'
            "
        >
            <a-button
                v-if="position == 'bottom'"
                type="primary"
                shape="circle"
                :style="{ width: '50px', height: '50px' }"
            >
                <template #icon><PlusOutlined /></template>
            </a-button>
            <a-button v-else type="link" shape="round" :style="{ padding: '0px' }">
                <template #icon><PlusCircleOutlined /></template>
            </a-button>
            <template #overlay>
                <a-menu>
                    <StaffAddButton
                        v-if="addMenus.includes('staff_member')"
                        customType="menu"
                    >
                        <template #icon>
                            <TeamOutlined />
                        </template>
                        <span>{{ $t("topbar_add_button.add_staff_member") }}</span>
                    </StaffAddButton>

                    <CurrencyAddButton
                        v-if="addMenus.includes('currency')"
                        customType="menu"
                    >
                        <template #icon>
                            <DollarOutlined />
                        </template>
                        <span>{{ $t("topbar_add_button.add_currency") }}</span>
                    </CurrencyAddButton>

                    <LanguageAddButton
                        v-if="addMenus.includes('language')"
                        customType="menu"
                    >
                        <template #icon>
                            <TranslationOutlined />
                        </template>
                        <span>{{ $t("topbar_add_button.add_language") }}</span>
                    </LanguageAddButton>

                    <RoleAddButton v-if="addMenus.includes('role')" customType="menu">
                        <template #icon>
                            <FundViewOutlined />
                        </template>
                        <span>{{ $t("topbar_add_button.add_role") }}</span>
                    </RoleAddButton>
                </a-menu>
            </template>
        </a-dropdown>
    </div>
</template>

<script>
import { computed } from "vue";
import {
    PlusOutlined,
    TeamOutlined,
    DollarOutlined,
    FundViewOutlined,
    TranslationOutlined,
    PlusCircleOutlined,
} from "@ant-design/icons-vue";
import common from "../composable/common";
import StaffAddButton from "../../main/views/users/StaffAddButton.vue";
import CurrencyAddButton from "../../main/views/common/settings/currency/AddButton.vue";
import LanguageAddButton from "../../main/views/common/settings/translations/langs/AddButton.vue";
import RoleAddButton from "../../main/views/settings/roles/AddButton.vue";
export default {
    props: {
        position: {
            default: "bottom",
        },
    },
    components: {
        PlusOutlined,
        TeamOutlined,
        DollarOutlined,
        FundViewOutlined,
        TranslationOutlined,
        PlusCircleOutlined,

        StaffAddButton,
        CurrencyAddButton,
        LanguageAddButton,
        RoleAddButton,
    },
    setup(props, { emit }) {
        const { permsArray, appSetting, addMenus } = common();
        const menuSelected = () => {};
        const affixStyle = computed(() => {
            if (props.position == "bottom") {
                if (appSetting.value.rtl) {
                    return { position: "fixed", left: "40px", bottom: "30px" };
                } else {
                    return { position: "fixed", right: "40px", bottom: "30px" };
                }
            } else {
                return {};
            }
        });

        return {
            permsArray,
            appSetting,
            addMenus,
            menuSelected,
            affixStyle,

            innerWidth: window.innerWidth,
        };
    },
};
</script>
