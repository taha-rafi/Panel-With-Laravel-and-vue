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
					{{ $t("website_settings.seo") }}
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

						<Seo :langKey="activeKey" />
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
import Seo from "./Seo.vue";

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
		Seo,
	},
	setup() {
		const websiteSettings = landingWebsite();

		return {
			...websiteSettings,
		};
	},
};
</script>
