<template>
	<SuperAdminPageHeader>
		<template #header>
			<a-page-header :title="$t(`payment_settings.authorize_settings`)" class="p-0">
				<template #extra>
					<a-button type="primary" @click="onSubmit">
						<template #icon> <SaveOutlined /> </template>
						{{ $t("common.update") }}
					</a-button>
				</template>
			</a-page-header>
		</template>
		<template #breadcrumb>
			<a-breadcrumb separator="-" style="font-size: 12px">
				<a-breadcrumb-item>
					<router-link :to="{ name: 'admin.dashboard.index' }">
						{{ $t(`menu.dashboard`) }}
					</router-link>
				</a-breadcrumb-item>
				<a-breadcrumb-item>
					{{ $t("menu.payment_settings") }}
				</a-breadcrumb-item>
				<a-breadcrumb-item>
					{{ $t("menu.authorize") }}
				</a-breadcrumb-item>
			</a-breadcrumb>
		</template>
	</SuperAdminPageHeader>

	<a-row>
		<a-col :xs="24" :sm="24" :md="24" :lg="4" :xl="4" class="bg-setting-sidebar">
			<SubscriptionSidebar />
		</a-col>
		<a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
			<a-card class="page-content-container">
				<a-form layout="vertical">
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('payment_settings.authorize_api_login_id')"
								name="authorize_api_login_id"
								:help="
									rules.authorize_api_login_id
										? rules.authorize_api_login_id.message
										: null
								"
								:validateStatus="
									rules.authorize_api_login_id ? 'error' : null
								"
								class="required"
							>
								<a-input
									v-model:value="formData.authorize_api_login_id"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('payment_settings.authorize_api_login_id'),
										])
									"
								/>
							</a-form-item>
						</a-col>
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('payment_settings.authorize_transaction_key')"
								name="authorize_transaction_key"
								:help="
									rules.authorize_transaction_key
										? rules.authorize_transaction_key.message
										: null
								"
								:validateStatus="
									rules.authorize_transaction_key ? 'error' : null
								"
								class="required"
							>
								<a-input
									v-model:value="formData.authorize_transaction_key"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t(
												'payment_settings.authorize_transaction_key'
											),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :span="24">
							<a-form-item
								:label="$t('payment_settings.authorize_signature_key')"
								name="authorize_signature_key"
								:help="
									rules.authorize_signature_key
										? rules.authorize_signature_key.message
										: null
								"
								:validateStatus="
									rules.authorize_signature_key ? 'error' : null
								"
								class="required"
							>
								<a-input
									v-model:value="formData.authorize_signature_key"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t(
												'payment_settings.authorize_signature_key'
											),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('payment_settings.authorize_environment')"
								name="authorize_environment"
								:help="
									rules.authorize_environment
										? rules.authorize_environment.message
										: null
								"
								:validateStatus="
									rules.authorize_environment ? 'error' : null
								"
								class="required"
							>
								<a-select
									v-model:value="formData.authorize_environment"
									:placeholder="
										$t('payment_settings.authorize_environment')
									"
								>
									<a-select-option key="sandbox" value="sandbox">
										{{ $t("payment_settings.sandbox") }}
									</a-select-option>
									<a-select-option key="live" value="live">
										{{ $t("payment_settings.live") }}
									</a-select-option>
								</a-select>
							</a-form-item>
						</a-col>
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('payment_settings.webhook_url')"
								name="webhook_url"
							>
								<a-typography-text type="success">
									{{ webhookUrl }}
								</a-typography-text>
								<br />
								<small class="small-text-message">
									{{ $t("user.password_blank") }}
								</small>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('payment_settings.authorize_status')"
								name="authorize_status"
								:help="rules.name ? rules.authorize_status.message : null"
								:validateStatus="rules.authorize_status ? 'error' : null"
								class="required"
							>
								<a-switch
									v-model:checked="formData.authorize_status"
									checkedValue="active"
									unCheckedValue="inactive"
								/>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item>
								<a-button
									type="primary"
									@click="onSubmit"
									:loading="loading"
								>
									<template #icon> <SaveOutlined /> </template>
									{{ $t("common.update") }}
								</a-button>
							</a-form-item>
						</a-col>
					</a-row>
				</a-form>
			</a-card>
		</a-col>
	</a-row>
</template>
<script>
import { onMounted, ref } from "vue";
import {
	EyeOutlined,
	PlusOutlined,
	EditOutlined,
	DeleteOutlined,
	ExclamationCircleOutlined,
	SaveOutlined,
} from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import apiAdmin from "../../../../common/composable/apiAdmin";
import SuperAdminPageHeader from "../../../layouts/SuperAdminPageHeader.vue";
import SubscriptionSidebar from "../SubscriptionSidebar.vue";

export default {
	components: {
		EyeOutlined,
		PlusOutlined,
		EditOutlined,
		DeleteOutlined,
		ExclamationCircleOutlined,
		SaveOutlined,

		SubscriptionSidebar,
		SuperAdminPageHeader,
	},
	setup() {
		const { addEditRequestAdmin, loading, rules } = apiAdmin();
		const { t } = useI18n();
		const formData = ref({});
		const webhookUrl = ref("");

		onMounted(() => {
			axiosAdmin.get("superadmin/payment-settings/authorize").then((response) => {
				formData.value = response.data.data;
				webhookUrl.value = response.data.webhook_url;
			});
		});

		const onSubmit = () => {
			addEditRequestAdmin({
				url: `superadmin/payment-settings/authorize/update`,
				data: formData.value,
				successMessage: t("payment_settings.credential_saved"),
				success: (res) => {},
			});
		};

		return {
			loading,
			rules,
			formData,
			webhookUrl,

			onSubmit,
		};
	},
};
</script>
