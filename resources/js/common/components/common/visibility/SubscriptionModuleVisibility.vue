<template>
	<template
		v-if="
			visibleSubscriptionModules && visibleSubscriptionModules.includes(moduleName)
		"
	>
		<slot></slot>
	</template>
</template>

<script>
import { defineComponent } from "vue";
import common from "../../../composable/common";

export default defineComponent({
	props: ["moduleName"],
	setup(props) {
		const { visibleSubscriptionModules } = common();

		return {
			visibleSubscriptionModules,
		};
	},
});
</script>
