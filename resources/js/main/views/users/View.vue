<template>
    <a-drawer
        :title="user.name"
        :width="drawerWidth"
        :visible="visible"
        :body-style="{ paddingBottom: '80px' }"
        :maskClosable="false"
        @close="onClose"
    >
        <div class="user-details">
            <a-row :gutter="[16, 16]">
                <a-col :xs="24" :sm="24" :md="4" :lg="4">
                    <a-image :src="user.profile_image_url" />
                </a-col>
                <a-col :xs="24" :sm="24" :md="20" :lg="20">
                    <a-descriptions
                        :title="$t(`user.${user.user_type}_details`)"
                        layout="vertical"
                        :contentStyle="{ fontWeight: 500, marginBottom: '20px' }"
                    >
                        <a-descriptions-item :label="$t('user.name')">
                            {{ user.name }}
                        </a-descriptions-item>
                        <a-descriptions-item :label="$t('user.email')">
                            {{ user.email }}
                        </a-descriptions-item>
                        <a-descriptions-item :label="$t('user.phone')">
                            {{ user.phone ? user.phone : "-" }}
                        </a-descriptions-item>
                        <a-descriptions-item
                            :label="$t('user.billing_address')"
                            :span="2"
                        >
                            {{ user.address ? user.address : "-" }}
                        </a-descriptions-item>
                        <a-descriptions-item
                            :label="$t('user.credit_period')"
                            v-if="user.details"
                        >
                            {{
                                user.details.credit_period
                                    ? `${user.details.credit_period} day(s)`
                                    : "-"
                            }}
                        </a-descriptions-item>
                        <a-descriptions-item
                            :label="$t('user.credit_limit')"
                            v-if="user.details"
                        >
                            {{
                                user.details.credit_limit
                                    ? formatAmountCurrency(user.details.credit_limit)
                                    : "-"
                            }}
                        </a-descriptions-item>
                    </a-descriptions>
                </a-col>
            </a-row>
        </div>
    </a-drawer>
</template>
<script>
import { defineComponent, ref, watch, computed } from "vue";
import { useI18n } from "vue-i18n";
import { forEach } from "lodash-es";
import common from "../../../common/composable/common";

export default defineComponent({
    props: ["user", "visible"],
    emits: ["closed"],
    setup(props, { emit }) {
        const { formatAmountCurrency } = common();
        const { t } = useI18n();

        const onClose = () => {
            emit("closed");
        };

        return {
            formatAmountCurrency,
            onClose,
            drawerWidth: window.innerWidth <= 991 ? "90%" : "60%",
        };
    },
});
</script>

<style lang="less">
.user-details {
    .ant-descriptions-item {
        padding-bottom: 5px;
    }
}
</style>
