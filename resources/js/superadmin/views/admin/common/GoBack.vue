<template>
	<a-button v-if="!visible" type="link" @click="goBack" :style="{ paddingLeft: '0px' }">
		<template #icon><ArrowLeftOutlined /></template>
		{{ $t("common.back") }}
	</a-button>
</template>

<script>
import { ArrowLeftOutlined } from "@ant-design/icons-vue";

export default {
	props: ["visible"],
	components: {
		ArrowLeftOutlined,
	},
	setup(props, { emit }) {
		const goBack = () => {
			emit("clicked");
		};

		return {
			goBack,
		};
	},
};
</script>
