<template>
	<SuperAdminPageHeader>
		<template #header>
			<a-page-header :title="$t(`menu.website_register_settings`)" class="p-0">
				<template #extra>
					<LangAddButton btnType="primary" :tooltip="false">
						{{ $t("langs.add") }}
					</LangAddButton>
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
					{{ $t("menu.website_settings") }}
				</a-breadcrumb-item>
				<a-breadcrumb-item>
					{{ $t("menu.website_register_settings") }}
				</a-breadcrumb-item>
			</a-breadcrumb>
		</template>
	</SuperAdminPageHeader>

	<a-row>
		<a-col :xs="24" :sm="24" :md="24" :lg="4" :xl="4" class="bg-setting-sidebar">
			<WebsiteSettingSidebar />
		</a-col>
		<a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
			<a-card class="page-content-container">
				<a-tabs v-model:activeKey="activeKey" @change="langChanged">
					<a-tab-pane
						v-for="allLang in allLangs"
						:key="allLang.key"
						:value="allLang.key"
					>
						<template #tab>
							<span>
								<a-avatar
									shape="square"
									:size="20"
									:src="allLang.image_url"
								/>
								{{ allLang.name }}
							</span>
						</template>

						<a-row :gutter="16">
							<a-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
								<a-form layout="vertical">
									<a-row :gutter="16">
										<a-col :xs="24" :sm="24" :md="24" :lg="24">
											<a-form-item
												:label="
													$t('website_settings.register_title')
												"
												name="register_title"
												:help="
													rules.register_title
														? rules.register_title.message
														: null
												"
												:validateStatus="
													rules.register_title ? 'error' : null
												"
											>
												<a-input
													v-model:value="
														formData.register_title
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.register_title'
																),
															]
														)
													"
												/>
											</a-form-item>
										</a-col>
									</a-row>

									<a-row :gutter="16">
										<a-col :span="24">
											<a-form-item
												:label="
													$t(
														'website_settings.register_description'
													)
												"
												name="register_description"
												:help="
													rules.register_description
														? rules.register_description
																.message
														: null
												"
												:validateStatus="
													rules.register_description
														? 'error'
														: null
												"
											>
												<a-textarea
													v-model:value="
														formData.register_description
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.register_description'
																),
															]
														)
													"
													:rows="4"
												/>
											</a-form-item>
										</a-col>
									</a-row>

									<a-row :gutter="16">
										<a-col :xs="24" :sm="8" :md="8" :lg="8">
											<a-form-item
												:label="
													$t(
														'website_settings.register_background'
													)
												"
												name="register_background"
												:help="
													rules.register_background
														? rules.register_background
																.message
														: null
												"
												:validateStatus="
													rules.register_background
														? 'error'
														: null
												"
											>
												<Upload
													:formData="formData"
													folder="website"
													imageField="register_background"
													@onFileUploaded="
														(file) => {
															formData.register_background =
																file.file;
															formData.register_background_url =
																file.file_url;
														}
													"
												/>
											</a-form-item>
										</a-col>
									</a-row>

									<a-row :gutter="16">
										<a-col :xs="24" :sm="24" :md="12" :lg="12">
											<a-form-item
												:label="
													$t(
														'website_settings.register_agree_text'
													)
												"
												name="register_agree_text"
												:help="
													rules.register_agree_text
														? rules.register_agree_text
																.message
														: null
												"
												:validateStatus="
													rules.register_agree_text
														? 'error'
														: null
												"
											>
												<a-input
													v-model:value="
														formData.register_agree_text
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.register_agree_text'
																),
															]
														)
													"
												/>
											</a-form-item>
										</a-col>
										<a-col :xs="24" :sm="24" :md="12" :lg="12">
											<a-form-item
												:label="
													$t(
														'website_settings.register_agree_url'
													)
												"
												name="register_agree_url"
												:help="
													rules.register_agree_url
														? rules.register_agree_url.message
														: null
												"
												:validateStatus="
													rules.register_agree_url
														? 'error'
														: null
												"
											>
												<a-input
													v-model:value="
														formData.register_agree_url
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.register_agree_url'
																),
															]
														)
													"
												/>
											</a-form-item>
										</a-col>
									</a-row>

									<FormItemHeading>
										{{ $t("website_settings.text_settings") }}
									</FormItemHeading>

									<a-row :gutter="16">
										<a-col :xs="24" :sm="24" :md="12" :lg="12">
											<a-form-item
												:label="
													$t(
														'website_settings.register_email_text'
													)
												"
												name="register_email_text"
												:help="
													rules.register_email_text
														? rules.register_email_text
																.message
														: null
												"
												:validateStatus="
													rules.register_email_text
														? 'error'
														: null
												"
											>
												<a-input
													v-model:value="
														formData.register_email_text
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.register_email_text'
																),
															]
														)
													"
												/>
											</a-form-item>
										</a-col>
										<a-col :xs="24" :sm="24" :md="12" :lg="12">
											<a-form-item
												:label="
													$t(
														'website_settings.register_password_text'
													)
												"
												name="register_password_text"
												:help="
													rules.register_password_text
														? rules.register_password_text
																.message
														: null
												"
												:validateStatus="
													rules.register_password_text
														? 'error'
														: null
												"
											>
												<a-input
													v-model:value="
														formData.register_password_text
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.register_password_text'
																),
															]
														)
													"
												/>
											</a-form-item>
										</a-col>
									</a-row>

									<a-row :gutter="16">
										<a-col :xs="24" :sm="24" :md="12" :lg="12">
											<a-form-item
												:label="
													$t(
														'website_settings.register_confirm_password_text'
													)
												"
												name="register_confirm_password_text"
												:help="
													rules.register_confirm_password_text
														? rules
																.register_confirm_password_text
																.message
														: null
												"
												:validateStatus="
													rules.register_confirm_password_text
														? 'error'
														: null
												"
											>
												<a-input
													v-model:value="
														formData.register_confirm_password_text
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.register_confirm_password_text'
																),
															]
														)
													"
												/>
											</a-form-item>
										</a-col>
										<a-col :xs="24" :sm="24" :md="12" :lg="12">
											<a-form-item
												:label="
													$t(
														'website_settings.register_submit_button_text'
													)
												"
												name="register_submit_button_text"
												:help="
													rules.register_submit_button_text
														? rules
																.register_submit_button_text
																.message
														: null
												"
												:validateStatus="
													rules.register_submit_button_text
														? 'error'
														: null
												"
											>
												<a-input
													v-model:value="
														formData.register_submit_button_text
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.register_submit_button_text'
																),
															]
														)
													"
												/>
											</a-form-item>
										</a-col>
									</a-row>

									<a-row :gutter="16">
										<a-col :xs="24" :sm="24" :md="12" :lg="12">
											<a-form-item
												:label="
													$t(
														'website_settings.error_contact_support'
													)
												"
												name="error_contact_support"
												:help="
													rules.error_contact_support
														? rules.error_contact_support
																.message
														: null
												"
												:validateStatus="
													rules.error_contact_support
														? 'error'
														: null
												"
											>
												<a-input
													v-model:value="
														formData.error_contact_support
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.error_contact_support'
																),
															]
														)
													"
												/>
											</a-form-item>
										</a-col>
										<a-col :xs="24" :sm="24" :md="12" :lg="12">
											<a-form-item
												:label="
													$t(
														'website_settings.register_success_text'
													)
												"
												name="register_success_text"
												:help="
													rules.register_success_text
														? rules.register_success_text
																.message
														: null
												"
												:validateStatus="
													rules.register_success_text
														? 'error'
														: null
												"
											>
												<a-input
													v-model:value="
														formData.register_success_text
													"
													:placeholder="
														$t(
															'common.placeholder_default_text',
															[
																$t(
																	'website_settings.register_success_text'
																),
															]
														)
													"
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
													<template #icon>
														<SaveOutlined />
													</template>
													{{ $t("common.update") }}
												</a-button>
											</a-form-item>
										</a-col>
									</a-row>
								</a-form>
							</a-col>
						</a-row>
					</a-tab-pane>
				</a-tabs>
			</a-card>
		</a-col>
	</a-row>
</template>

<script>
import { onMounted, ref, computed } from "vue";
import {
	EyeOutlined,
	PlusOutlined,
	EditOutlined,
	DeleteOutlined,
	ExclamationCircleOutlined,
	SaveOutlined,
} from "@ant-design/icons-vue";
import landingWebsite from "../../composable/landingWebsite";
import SuperAdminPageHeader from "../../layouts/SuperAdminPageHeader.vue";
import WebsiteSettingSidebar from "./WebsiteSettingSidebar.vue";
import LangAddButton from "../../../main/views/common/settings/translations/langs/AddButton.vue";
import FormItemHeading from "../../../common/components/common/typography/FormItemHeading.vue";
import Upload from "../../../common/core/ui/file/Upload.vue";

export default {
	components: {
		EyeOutlined,
		PlusOutlined,
		EditOutlined,
		DeleteOutlined,
		ExclamationCircleOutlined,
		SaveOutlined,

		LangAddButton,
		WebsiteSettingSidebar,
		SuperAdminPageHeader,
		FormItemHeading,
		Upload,
	},
	setup() {
		const websiteSettings = landingWebsite();

		return {
			...websiteSettings,
		};
	},
};
</script>
