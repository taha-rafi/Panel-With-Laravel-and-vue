<template>
	<SuperAdminPageHeader>
		<template #header>
			<a-page-header :title="$t(`menu.website_contact_settings`)" class="p-0">
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
					{{ $t("menu.website_contact_settings") }}
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
							<a-col :xs="24" :sm="24" :md="24" :lg="4" :xl="4">
								<div
									:style="{
										borderRight: '1px solid #f0f0f0',
										height: 'calc(100vh - 259px)',
									}"
								>
									<a-menu v-model:selectedKeys="subTabActiveKey">
										<a-menu-item key="basic_text">
											{{ $t("website_settings.basic_settings") }}
										</a-menu-item>
										<a-menu-item key="details_crud">
											{{ $t("website_settings.contact_form") }}
										</a-menu-item>
									</a-menu>
								</div>
							</a-col>

							<a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
								<template v-if="subTabActiveKey[0] == 'details_crud'">
									<a-form layout="vertical">
										<a-row :gutter="16">
											<a-col :xs="24" :sm="24" :md="24" :lg="24">
												<a-form-item
													:label="
														$t(
															'website_settings.contact_form_title'
														)
													"
													name="contact_form_title"
													:help="
														rules.contact_form_title
															? rules.contact_form_title
																	.message
															: null
													"
													:validateStatus="
														rules.contact_form_title
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_form_title
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_form_title'
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
															'website_settings.contact_form_description'
														)
													"
													name="contact_form_description"
													:help="
														rules.contact_form_description
															? rules
																	.contact_form_description
																	.message
															: null
													"
													:validateStatus="
														rules.contact_form_description
															? 'error'
															: null
													"
												>
													<a-textarea
														v-model:value="
															formData.contact_form_description
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_form_description'
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
															'website_settings.contact_form_background_image'
														)
													"
													name="contact_form_background_image"
													:help="
														rules.contact_form_background_image
															? rules
																	.contact_form_background_image
																	.message
															: null
													"
													:validateStatus="
														rules.contact_form_background_image
															? 'error'
															: null
													"
												>
													<Upload
														:formData="formData"
														folder="website"
														imageField="contact_form_background_image"
														@onFileUploaded="
															(file) => {
																formData.contact_form_background_image =
																	file.file;
																formData.contact_form_background_image_url =
																	file.file_url;
															}
														"
													/>
												</a-form-item>
											</a-col>
										</a-row>

										<FormItemHeading>
											{{
												$t(
													"website_settings.contact_form_settings"
												)
											}}
										</FormItemHeading>

										<a-row :gutter="16">
											<a-col :xs="24" :sm="24" :md="24" :lg="24">
												<a-form-item
													:label="
														$t(
															'website_settings.contact_form_heading'
														)
													"
													name="contact_form_heading"
													:help="
														rules.contact_form_heading
															? rules.contact_form_heading
																	.message
															: null
													"
													:validateStatus="
														rules.contact_form_heading
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_form_heading
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_form_heading'
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
															'website_settings.contact_form_name_text'
														)
													"
													name="contact_form_name_text"
													:help="
														rules.contact_form_name_text
															? rules.contact_form_name_text
																	.message
															: null
													"
													:validateStatus="
														rules.contact_form_name_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_form_name_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_form_name_text'
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
															'website_settings.contact_form_email_text'
														)
													"
													name="contact_form_email_text"
													:help="
														rules.contact_form_email_text
															? rules
																	.contact_form_email_text
																	.message
															: null
													"
													:validateStatus="
														rules.contact_form_email_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_form_email_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_form_email_text'
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
															'website_settings.contact_form_message_text'
														)
													"
													name="contact_form_message_text"
													:help="
														rules.contact_form_message_text
															? rules
																	.contact_form_message_text
																	.message
															: null
													"
													:validateStatus="
														rules.contact_form_message_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_form_message_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_form_message_text'
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
															'website_settings.contact_form_send_message_text'
														)
													"
													name="contact_form_send_message_text"
													:help="
														rules.contact_form_send_message_text
															? rules
																	.contact_form_send_message_text
																	.message
															: null
													"
													:validateStatus="
														rules.contact_form_send_message_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_form_send_message_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_form_send_message_text'
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
															'website_settings.contact_us_submit_message_text'
														)
													"
													name="contact_us_submit_message_text"
													:help="
														rules.contact_us_submit_message_text
															? rules
																	.contact_us_submit_message_text
																	.message
															: null
													"
													:validateStatus="
														rules.contact_us_submit_message_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_us_submit_message_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_us_submit_message_text'
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
								</template>
								<template v-else>
									<a-form layout="vertical">
										<a-row :gutter="16">
											<a-col :xs="24" :sm="24" :md="24" :lg="24">
												<a-form-item
													:label="
														$t(
															'website_settings.contact_title'
														)
													"
													name="contact_title"
													:help="
														rules.contact_title
															? rules.contact_title.message
															: null
													"
													:validateStatus="
														rules.contact_title
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_title
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_title'
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
															'website_settings.contact_description'
														)
													"
													name="contact_description"
													:help="
														rules.contact_description
															? rules.contact_description
																	.message
															: null
													"
													:validateStatus="
														rules.contact_description
															? 'error'
															: null
													"
												>
													<a-textarea
														v-model:value="
															formData.contact_description
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_description'
																	),
																]
															)
														"
														:rows="4"
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
															'website_settings.contact_email_text'
														)
													"
													name="contact_email_text"
													:help="
														rules.contact_email_text
															? rules.contact_email_text
																	.message
															: null
													"
													:validateStatus="
														rules.contact_email_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_email_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_email_text'
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
															'website_settings.contact_phone_text'
														)
													"
													name="contact_phone_text"
													:help="
														rules.contact_phone_text
															? rules.contact_phone_text
																	.message
															: null
													"
													:validateStatus="
														rules.contact_phone_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_phone_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_phone_text'
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
															'website_settings.contact_address_text'
														)
													"
													name="contact_address_text"
													:help="
														rules.contact_address_text
															? rules.contact_address_text
																	.message
															: null
													"
													:validateStatus="
														rules.contact_address_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.contact_address_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.contact_address_text'
																	),
																]
															)
														"
													/>
												</a-form-item>
											</a-col>
										</a-row>

										<FormItemHeading>
											{{ $t("website_settings.contact_details") }}
										</FormItemHeading>

										<a-row :gutter="16">
											<a-col :xs="24" :sm="24" :md="12" :lg="12">
												<a-form-item
													:label="$t('common.email')"
													name="contact_email"
													:help="
														rules.contact_email
															? rules.contact_email.message
															: null
													"
													:validateStatus="
														rules.contact_email
															? 'error'
															: null
													"
												>
													<a-input
														v-model:value="
															formData.contact_email
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[$t('common.email')]
															)
														"
													/>
												</a-form-item>
											</a-col>
											<a-col :xs="24" :sm="24" :md="12" :lg="12">
												<a-form-item
													:label="$t('common.phone')"
													name="contact_phone"
													:help="
														rules.contact_phone
															? rules.contact_phone.message
															: null
													"
													:validateStatus="
														rules.contact_phone
															? 'error'
															: null
													"
												>
													<a-input
														v-model:value="
															formData.contact_phone
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[$t('common.phone')]
															)
														"
													/>
												</a-form-item>
											</a-col>
										</a-row>

										<a-row :gutter="16">
											<a-col :span="24">
												<a-form-item
													:label="$t('common.address')"
													name="contact_address"
													:help="
														rules.contact_address
															? rules.contact_address
																	.message
															: null
													"
													:validateStatus="
														rules.contact_address
															? 'error'
															: null
													"
												>
													<a-input
														v-model:value="
															formData.contact_address
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[$t('common.address')]
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
								</template>
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
