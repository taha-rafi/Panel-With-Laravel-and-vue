<template>
	<a-drawer
		:title="pageTitle"
		:width="drawerWidth"
		:visible="visible"
		:body-style="{ paddingBottom: '80px' }"
		:footer-style="{ textAlign: 'right' }"
		:maskClosable="false"
		@close="onClose"
	>
		<a-form layout="vertical">
			<a-tabs v-model:activeKey="activeTabKey">
				<a-tab-pane key="basic_details" :tab="$t('company.basic_details')">
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('company.name')"
								name="name"
								:help="rules.name ? rules.name.message : null"
								:validateStatus="rules.name ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.name"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('company.name'),
										])
									"
								/>
							</a-form-item>
						</a-col>
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('company.short_name')"
								name="short_name"
								:help="rules.short_name ? rules.short_name.message : null"
								:validateStatus="rules.short_name ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.short_name"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('company.short_name'),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('company.email')"
								name="email"
								:help="rules.email ? rules.email.message : null"
								:validateStatus="rules.email ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.email"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('company.email'),
										])
									"
								/>
							</a-form-item>
						</a-col>
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('company.phone')"
								name="phone"
								:help="rules.phone ? rules.phone.message : null"
								:validateStatus="rules.phone ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.phone"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('company.phone'),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('company.default_timezone')"
								name="timezone"
								:help="rules.timezone ? rules.timezone.message : null"
								:validateStatus="rules.timezone ? 'error' : null"
								class="required"
							>
								<a-select
									v-model:value="formData.timezone"
									:placeholder="
										$t('common.select_default_text', [
											$t('company.default_timezone'),
										])
									"
									optionFilterProp="value"
									show-search
								>
									<a-select-option
										v-for="(timezoneValue, timezoneKey) in timezones"
										:key="timezoneKey"
										:value="timezoneValue"
									>
										{{ timezoneValue }}
									</a-select-option>
								</a-select>
							</a-form-item>
						</a-col>
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('common.status')"
								name="status"
								:help="rules.status ? rules.status.message : null"
								:validateStatus="rules.status ? 'error' : null"
								class="required"
							>
								<a-select
									v-model:value="formData.status"
									:placeholder="
										$t('common.select_default_text', [
											$t('common.status'),
										])
									"
									optionFilterProp="value"
								>
									<a-select-option value="pending">
										{{ $t("common.pending") }}
									</a-select-option>
									<a-select-option value="active">
										{{ $t("common.active") }}
									</a-select-option>
									<a-select-option value="inactive">
										{{ $t("common.inactive") }}
									</a-select-option>
								</a-select>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('company.address')"
								name="address"
								:help="rules.address ? rules.address.message : null"
								:validateStatus="rules.address ? 'error' : null"
							>
								<a-textarea
									v-model:value="formData.address"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('company.address'),
										])
									"
									:rows="4"
								/>
							</a-form-item>
						</a-col>
					</a-row>
				</a-tab-pane>
				<a-tab-pane key="logo_details" :tab="$t('company.logo')">
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="6" :lg="6">
							<a-form-item
								:label="$t('company.dark_logo')"
								name="dark_logo"
								:help="rules.dark_logo ? rules.dark_logo.message : null"
								:validateStatus="rules.dark_logo ? 'error' : null"
							>
								<Upload
									:formData="formData"
									folder="company"
									imageField="dark_logo"
									@onFileUploaded="
										(file) => {
											formData.dark_logo = file.file;
											formData.dark_logo_url = file.file_url;
										}
									"
								/>
							</a-form-item>
						</a-col>
						<a-col :xs="24" :sm="24" :md="6" :lg="6">
							<a-form-item
								:label="$t('company.light_logo')"
								name="light_logo"
								:help="rules.light_logo ? rules.light_logo.message : null"
								:validateStatus="rules.light_logo ? 'error' : null"
							>
								<Upload
									:formData="formData"
									folder="company"
									imageField="light_logo"
									@onFileUploaded="
										(file) => {
											formData.light_logo = file.file;
											formData.light_logo_url = file.file_url;
										}
									"
								/>
							</a-form-item>
						</a-col>
						<a-col :xs="24" :sm="24" :md="6" :lg="6">
							<a-form-item
								:label="$t('company.small_dark_logo')"
								name="small_dark_logo"
								:help="
									rules.small_dark_logo
										? rules.small_dark_logo.message
										: null
								"
								:validateStatus="rules.small_dark_logo ? 'error' : null"
							>
								<Upload
									:formData="formData"
									folder="company"
									imageField="small_dark_logo"
									@onFileUploaded="
										(file) => {
											formData.small_dark_logo = file.file;
											formData.small_dark_logo_url = file.file_url;
										}
									"
								/>
							</a-form-item>
						</a-col>
						<a-col :xs="24" :sm="24" :md="6" :lg="6">
							<a-form-item
								:label="$t('company.small_light_logo')"
								name="small_light_logo"
								:help="
									rules.small_light_logo
										? rules.small_light_logo.message
										: null
								"
								:validateStatus="rules.small_light_logo ? 'error' : null"
							>
								<Upload
									:formData="formData"
									folder="company"
									imageField="small_light_logo"
									@onFileUploaded="
										(file) => {
											formData.small_light_logo = file.file;
											formData.small_light_logo_url = file.file_url;
										}
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>
				</a-tab-pane>
			</a-tabs>

			<FormItemHeading>
				{{ $t("user.admin_account_details") }}
			</FormItemHeading>

			<a-row class="mb-20">
				<a-col :span="24">
					<EmailNotSetup />
				</a-col>
			</a-row>

			<a-row :gutter="16">
				<a-col :xs="24" :sm="24" :md="12" :lg="12">
					<a-form-item
						:label="$t('user.email')"
						name="user_email"
						:help="rules.user_email ? rules.user_email.message : null"
						:validateStatus="rules.user_email ? 'error' : null"
						class="required"
					>
						<a-input
							v-model:value="formData.user_email"
							:placeholder="
								$t('common.placeholder_default_text', [$t('user.email')])
							"
						/>
					</a-form-item>
				</a-col>
				<a-col :xs="24" :sm="24" :md="12" :lg="12">
					<a-form-item
						:label="$t('user.password')"
						name="user_password"
						:help="rules.user_password ? rules.user_password.message : null"
						:validateStatus="rules.user_password ? 'error' : null"
						class="required"
					>
						<a-input-password
							v-model:value="formData.user_password"
							:placeholder="
								$t('common.placeholder_default_text', [
									$t('user.password'),
								])
							"
						/>
						<small class="small-text-message">
							{{ $t("messages.company_admin_password_message") }}
						</small>
					</a-form-item>
				</a-col>
			</a-row>
		</a-form>
		<template #footer>
			<a-space>
				<a-button
					key="submit"
					type="primary"
					:loading="loading"
					@click="onSubmit"
				>
					<template #icon>
						<SaveOutlined />
					</template>
					{{ addEditType == "add" ? $t("common.create") : $t("common.update") }}
				</a-button>
				<a-button key="back" @click="onClose">
					{{ $t("common.cancel") }}
				</a-button>
			</a-space>
		</template>
	</a-drawer>
</template>

<script>
import { defineComponent, ref, onMounted } from "vue";
import { PlusOutlined, LoadingOutlined, SaveOutlined } from "@ant-design/icons-vue";
import apiAdmin from "../../../common/composable/apiAdmin";
import Upload from "../../../common/core/ui/file/Upload.vue";
import FormItemHeading from "../../../common/components/common/typography/FormItemHeading.vue";
import EmailNotSetup from "../settings/email/EmailNotSetup.vue";

export default defineComponent({
	props: [
		"formData",
		"data",
		"visible",
		"url",
		"addEditType",
		"pageTitle",
		"successMessage",
	],
	components: {
		PlusOutlined,
		LoadingOutlined,
		SaveOutlined,
		Upload,
		FormItemHeading,
		EmailNotSetup,
	},
	setup(props, { emit }) {
		const { addEditRequestAdmin, loading, rules } = apiAdmin();
		const timezones = ref([]);
		const activeTabKey = ref("basic_details");

		onMounted(() => {
			axiosAdmin.get("timezones").then((response) => {
				timezones.value = response.data.timezones;
			});
		});

		const onSubmit = () => {
			addEditRequestAdmin({
				url: props.url,
				data: props.formData,
				successMessage: props.successMessage,
				success: (res) => {
					emit("addEditSuccess", res.xid);
				},
			});
		};

		const onClose = () => {
			rules.value = {};
			emit("closed");
		};

		return {
			loading,
			rules,
			onClose,
			onSubmit,
			timezones,

			activeTabKey,
			drawerWidth: window.innerWidth <= 991 ? "90%" : "45%",
		};
	},
});
</script>
