<template>
	<a-row
		:gutter="[15, 15]"
		class="mb-20"
		v-if="
			visibleSubscriptionModules &&
			!visibleSubscriptionModules.includes(moduleName) &&
			appSetting.x_admin_id == user.xid
		"
	>
		<a-col :span="24">
			<a-alert
				:message="$t('subscription_plans.limit_exceed')"
				:description="$t('subscription_plans.upgrade_your_plan')"
				type="error"
				show-icon
				@close="() => $router.push({ name: 'admin.subscription.change_plan' })"
			>
				<template #closeText>
					<a-button type="primary">
						<template #icon>
							<FormOutlined />
						</template>
						{{ $t("subscription_plans.upgrade_plan") }}
					</a-button>
				</template>
			</a-alert>
		</a-col>
	</a-row>
</template>

<script>
import { defineComponent } from "vue";
import { FormOutlined } from "@ant-design/icons-vue";
import common from "../../../composable/common";

export default defineComponent({
	props: ["moduleName"],
	components: {
		FormOutlined,
	},
	setup(props) {
		const { visibleSubscriptionModules, appSetting, user } = common();

		return {
			visibleSubscriptionModules,
			appSetting,
			user,
		};
	},
});
</script>
