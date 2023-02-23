<template>
	<SuperAdminPageHeader>
		<template #header>
			<a-page-header :title="$t(`payment_settings.mollie_settings`)" class="p-0">
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
					{{ $t("menu.mollie") }}
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
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('payment_settings.mollie_api_key')"
								name="mollie_api_key"
								:help="
									rules.mollie_api_key
										? rules.mollie_api_key.message
										: null
								"
								:validateStatus="rules.mollie_api_key ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.mollie_api_key"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('payment_settings.mollie_api_key'),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('payment_settings.mollie_status')"
								name="mollie_status"
								:help="
									rules.mollie_status
										? rules.mollie_status.message
										: null
								"
								:validateStatus="rules.mollie_status ? 'error' : null"
								class="required"
							>
								<a-switch
									v-model:checked="formData.mollie_status"
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

		onMounted(() => {
			axiosAdmin.get("superadmin/payment-settings/mollie").then((response) => {
				formData.value = response.data.data;
			});
		});

		const onSubmit = () => {
			addEditRequestAdmin({
				url: `superadmin/payment-settings/mollie/update`,
				data: formData.value,
				successMessage: t("payment_settings.credential_saved"),
				success: (res) => {},
			});
		};

		return {
			loading,
			rules,
			formData,

			onSubmit,
		};
	},
};
</script>
