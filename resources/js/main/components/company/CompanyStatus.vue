<template>
	<a-tag v-if="status == 'active'" color="green">
		<template #icon>
			<CheckCircleOutlined />
		</template>
		{{ $t("common.active") }}
	</a-tag>
	<a-tag v-else-if="status == 'inactive'" color="red">
		<template #icon>
			<CloseCircleOutlined />
		</template>
		{{ $t("common.inactive") }}
	</a-tag>
	<span v-else>-</span>
</template>

<script>
import { CheckCircleOutlined, CloseCircleOutlined } from "@ant-design/icons-vue";

export default {
	props: ["status"],
	components: {
		CheckCircleOutlined,
		CloseCircleOutlined,
	},
};
</script>

<style></style>
