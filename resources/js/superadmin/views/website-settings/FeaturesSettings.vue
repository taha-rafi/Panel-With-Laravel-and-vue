<template>
	<SuperAdminPageHeader>
		<template #header>
			<a-page-header :title="$t(`menu.website_features_settings`)" class="p-0">
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
					{{ $t("website_settings.features") }}
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
											{{
												$t(
													"website_settings.home_page_feature_widget"
												)
											}}
										</a-menu-item>
										<a-menu-item key="details_crud">
											{{
												$t("website_settings.features_home_page")
											}}
										</a-menu-item>
										<a-menu-item key="features_page">
											{{ $t("website_settings.features_page") }}
										</a-menu-item>
									</a-menu>
								</div>
							</a-col>

							<a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
								<template v-if="subTabActiveKey[0] == 'details_crud'">
									<FeaturesHomePage :langKey="activeKey" />
								</template>
								<template
									v-else-if="subTabActiveKey[0] == 'features_page'"
								>
									<FeaturesPage :langKey="activeKey" />
								</template>
								<template v-else>
									<a-col :span="24">
										<a-form layout="vertical">
											<a-row :gutter="16">
												<a-col
													:xs="24"
													:sm="24"
													:md="24"
													:lg="24"
												>
													<a-form-item
														:label="
															$t(
																'website_settings.feature_title'
															)
														"
														name="feature_title"
														:help="
															rules.feature_title
																? rules.feature_title
																		.message
																: null
														"
														:validateStatus="
															rules.feature_title
																? 'error'
																: null
														"
													>
														<a-input
															v-model:value="
																formData.feature_title
															"
															:placeholder="
																$t(
																	'common.placeholder_default_text',
																	[
																		$t(
																			'website_settings.feature_title'
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
																'website_settings.feature_description'
															)
														"
														name="feature_description"
														:help="
															rules.feature_description
																? rules
																		.feature_description
																		.message
																: null
														"
														:validateStatus="
															rules.feature_description
																? 'error'
																: null
														"
													>
														<a-textarea
															v-model:value="
																formData.feature_description
															"
															:placeholder="
																$t(
																	'common.placeholder_default_text',
																	[
																		$t(
																			'website_settings.feature_description'
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
												<a-col
													:xs="24"
													:sm="24"
													:md="24"
													:lg="24"
												>
													<a-typography-title
														:level="5"
														:style="{ marginBottom: '10px' }"
													>
														{{
															$t(
																"website_settings.features_lists"
															)
														}}
													</a-typography-title>
													<DynamicFormFeatures
														v-if="
															formData.home_feature_points
														"
														:data="
															formData.home_feature_points
														"
														:addText="
															$t(
																'website_settings.add_feature'
															)
														"
														@onEntry="
															(allTags) =>
																(formData.home_feature_points = allTags)
														"
													/>
												</a-col>
											</a-row>

											<a-row :gutter="16">
												<a-col
													:xs="24"
													:sm="24"
													:md="24"
													:lg="24"
												>
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
import FeaturesHomePage from "./FeaturesHomePage.vue";
import FeaturesPage from "./FeaturesPage.vue";
import DynamicFormFeatures from "./features/DynamicFormFeatures.vue";

export default {
	components: {
		EyeOutlined,
		PlusOutlined,
		EditOutlined,
		DeleteOutlined,
		ExclamationCircleOutlined,
		SaveOutlined,
		FeaturesHomePage,
		FeaturesPage,
		DynamicFormFeatures,

		LangAddButton,
		WebsiteSettingSidebar,
		SuperAdminPageHeader,
	},
	setup() {
		const websiteSettings = landingWebsite();

		const updateFeaturePoints = (resultArray) => {
			addEditForm.formData.links_widget = resultArray;
			onSubmit();
		};

		return {
			...websiteSettings,
			updateFeaturePoints,
		};
	},
};
</script>
