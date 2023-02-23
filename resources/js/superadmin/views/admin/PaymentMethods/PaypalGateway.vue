<template>
	<div class="loading-app-container">
		<a-result>
			<template #icon> </template>
			<template #title>
				<span :style="{ color: '#7676e3' }">
					{{ $t("subscription_plans.redirecting_please_wait") }}
				</span>
			</template>
			<template #extra>
				<SyncOutlined :style="{ fontSize: '38px', color: '#5254cf' }" spin />
			</template>
		</a-result>
	</div>
</template>

<script>
import { SyncOutlined } from "@ant-design/icons-vue";

export default {
	components: {
		SyncOutlined,
	},
	setup(props, { emit }) {
		return {};
	},
};
</script>

<style lang="less" scoped>
.loading-app-container {
	height: 100%;
	width: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
}
</style>
