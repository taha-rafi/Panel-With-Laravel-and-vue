<template>
	<SuperAdminPageHeader>
		<template #header>
			<a-page-header :title="$t(`menu.website_settings`)" class="p-0">
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
					{{ $t("website_settings.footer") }}
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
										<a-menu-item key="social_links">
											{{ $t("website_settings.social_links") }}
										</a-menu-item>
										<a-menu-item key="details_crud">
											{{ $t("website_settings.footer_pages") }}
										</a-menu-item>
									</a-menu>
								</div>
							</a-col>

							<a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
								<template v-if="subTabActiveKey[0] == 'details_crud'">
									<Footer :langKey="activeKey" />
								</template>
								<template
									v-else-if="subTabActiveKey[0] == 'social_links'"
								>
									<a-form layout="vertical">
										<a-row :gutter="16">
											<a-col :xs="24" :sm="24" :md="24" :lg="24">
												<a-form-item
													:label="
														$t(
															'website_settings.facebook_url'
														)
													"
													name="facebook_url"
													:help="
														rules.facebook_url
															? rules.facebook_url.message
															: null
													"
													:validateStatus="
														rules.facebook_url
															? 'error'
															: null
													"
												>
													<a-input
														v-model:value="
															formData.facebook_url
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.facebook_url'
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
												<a-form-item
													:label="
														$t('website_settings.twitter_url')
													"
													name="twitter_url"
													:help="
														rules.twitter_url
															? rules.twitter_url.message
															: null
													"
													:validateStatus="
														rules.twitter_url ? 'error' : null
													"
												>
													<a-input
														v-model:value="
															formData.twitter_url
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.twitter_url'
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
												<a-form-item
													:label="
														$t(
															'website_settings.linkedin_url'
														)
													"
													name="linkedin_url"
													:help="
														rules.linkedin_url
															? rules.linkedin_url.message
															: null
													"
													:validateStatus="
														rules.linkedin_url
															? 'error'
															: null
													"
												>
													<a-input
														v-model:value="
															formData.linkedin_url
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.linkedin_url'
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
												<a-form-item
													:label="
														$t(
															'website_settings.instagram_url'
														)
													"
													name="instagram_url"
													:help="
														rules.instagram_url
															? rules.instagram_url.message
															: null
													"
													:validateStatus="
														rules.instagram_url
															? 'error'
															: null
													"
												>
													<a-input
														v-model:value="
															formData.instagram_url
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.instagram_url'
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
												<a-form-item
													:label="
														$t('website_settings.youtube_url')
													"
													name="youtube_url"
													:help="
														rules.youtube_url
															? rules.youtube_url.message
															: null
													"
													:validateStatus="
														rules.youtube_url ? 'error' : null
													"
												>
													<a-input
														v-model:value="
															formData.youtube_url
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.youtube_url'
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
															'website_settings.footer_copyright_text'
														)
													"
													name="footer_copyright_text"
													:help="
														rules.footer_copyright_text
															? rules.footer_copyright_text
																	.message
															: null
													"
													:validateStatus="
														rules.footer_copyright_text
															? 'error'
															: null
													"
												>
													<a-input
														v-model:value="
															formData.footer_copyright_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.footer_copyright_text'
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
															'website_settings.footer_description'
														)
													"
													name="footer_description"
													:help="
														rules.footer_description
															? rules.footer_description
																	.message
															: null
													"
													:validateStatus="
														rules.footer_description
															? 'error'
															: null
													"
												>
													<a-textarea
														v-model:value="
															formData.footer_description
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.footer_description'
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
														$t('website_settings.footer_logo')
													"
													name="footer_logo"
													:help="
														rules.footer_logo
															? rules.footer_logo.message
															: null
													"
													:validateStatus="
														rules.footer_logo ? 'error' : null
													"
												>
													<Upload
														:formData="formData"
														folder="website"
														imageField="footer_logo"
														@onFileUploaded="
															(file) => {
																formData.footer_logo =
																	file.file;
																formData.footer_logo_url =
																	file.file_url;
															}
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
															'website_settings.footer_links_text'
														)
													"
													name="footer_links_text"
													:help="
														rules.footer_links_text
															? rules.footer_links_text
																	.message
															: null
													"
													:validateStatus="
														rules.footer_links_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.footer_links_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.footer_links_text'
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
															'website_settings.footer_pages_text'
														)
													"
													name="footer_pages_text"
													:help="
														rules.footer_pages_text
															? rules.footer_pages_text
																	.message
															: null
													"
													:validateStatus="
														rules.footer_pages_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.footer_pages_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.footer_pages_text'
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
															'website_settings.footer_contact_us_text'
														)
													"
													name="footer_contact_us_text"
													:help="
														rules.footer_contact_us_text
															? rules.footer_contact_us_text
																	.message
															: null
													"
													:validateStatus="
														rules.footer_contact_us_text
															? 'error'
															: null
													"
													class="required"
												>
													<a-input
														v-model:value="
															formData.footer_contact_us_text
														"
														:placeholder="
															$t(
																'common.placeholder_default_text',
																[
																	$t(
																		'website_settings.footer_contact_us_text'
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
							</a-col>
						</a-row>
					</a-tab-pane>
				</a-tabs>
			</a-card>
		</a-col>
	</a-row>
</template>

<script>
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
import Footer from "./Footer.vue";
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
		Footer,
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
