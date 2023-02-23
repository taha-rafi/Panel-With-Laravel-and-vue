<template>
	<AdminPageHeader>
		<template #header>
			<a-page-header :title="$t(`menu.modules`)" class="p-0" />
		</template>
		<template #breadcrumb>
			<a-breadcrumb separator="-" style="font-size: 12px">
				<a-breadcrumb-item>
					<router-link :to="{ name: 'admin.dashboard.index' }">
						{{ $t(`menu.dashboard`) }}
					</router-link>
				</a-breadcrumb-item>
				<a-breadcrumb-item>
					{{ $t("menu.settings") }}
				</a-breadcrumb-item>
				<a-breadcrumb-item>
					{{ $t("menu.modules") }}
				</a-breadcrumb-item>
			</a-breadcrumb>
		</template>
	</AdminPageHeader>

	<a-row>
		<a-col :xs="24" :sm="24" :md="24" :lg="4" :xl="4" class="bg-setting-sidebar">
			<SettingSidebar />
		</a-col>
		<a-col :xs="24" :sm="24" :md="24" :lg="20" :xl="20">
			<ModuleSetting />
		</a-col>
	</a-row>
</template>

<script>
import { defineComponent } from "vue";
import { LeftCircleOutlined, RightCircleOutlined } from "@ant-design/icons-vue";
import SettingSidebar from "../SettingSidebar.vue";
import AdminPageHeader from "../../../../common/layouts/AdminPageHeader.vue";
import ModuleSetting from "../../common/settings/modules/index.vue";

export default defineComponent({
	components: {
		LeftCircleOutlined,
		RightCircleOutlined,
		SettingSidebar,
		AdminPageHeader,
		ModuleSetting,
	},
	setup() {
		return {};
	},
});
</script>
