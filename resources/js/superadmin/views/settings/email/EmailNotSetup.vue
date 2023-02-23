<template>
	<a-alert v-if="!visible" type="error" show-icon closable>
		<template #icon>
			<MailOutlined />
		</template>
		<template #message>
			{{ $t("messages.email_setting_not_configured") }}
		</template>
		<template #description>
			{{ $t("messages.please_configure_email_settings") }}
		</template>
		<template #closeText>
			<a-button
				@click="() => $router.push({ name: 'superadmin.settings.email.index' })"
			>
				<template #icon>
					<SendOutlined />
				</template>
				{{ $t("common.configure") }}
			</a-button>
		</template>
	</a-alert>
</template>

<script>
import { ref, computed } from "vue";
import { MailOutlined, SendOutlined } from "@ant-design/icons-vue";
import { useStore } from "vuex";

export default {
	components: {
		MailOutlined,
		SendOutlined,
	},
	setup() {
		const store = useStore();
		const visible = computed(() => store.state.auth.emailSettingVerified);

		return {
			visible,
		};
	},
};
</script>

<style></style>
