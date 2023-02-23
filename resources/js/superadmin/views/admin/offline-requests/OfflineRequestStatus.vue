<template>
    <a-tag :color="color">
        <template #icon>
            <CheckCircleOutlined v-if="status == 'approved'" />
            <CloseCircleOutlined v-else-if="status == 'rejected'" />
            <ClockCircleOutlined v-else />
        </template>
        {{ $t(`offline_request.${status}`) }}
    </a-tag>
</template>

<script>
import { computed } from "vue";
import {
    ClockCircleOutlined,
    CloseCircleOutlined,
    CheckCircleOutlined,
} from "@ant-design/icons-vue";

export default {
    props: ["status"],
    components: {
        CheckCircleOutlined,
        CloseCircleOutlined,
        ClockCircleOutlined,
    },
    setup(props) {
        const color = computed(() => {
            if (props.status == "rejected") {
                return "error";
            } else if (props.status == "approved") {
                return "success";
            } else {
                return "default";
            }
        });

        return {
            color,
        };
    },
};
</script>

<style></style>
