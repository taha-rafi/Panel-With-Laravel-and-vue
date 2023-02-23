<template>
	<SuperAdminPageHeader>
		<template #header>
			<a-page-header :title="$t(`menu.dashboard`)" style="padding: 0px" />
		</template>
	</SuperAdminPageHeader>

	<div class="dashboard-page-content-container">
		<SuperadminUpdateAppAlert />

		<div class="mt-30 mb-20">
			<a-row :gutter="[15, 15]">
				<a-col :xs="24" :sm="24" :md="12" :lg="6" :xl="6">
					<StateWidget bgColor="#6777ef">
						<template #image>
							<RocketOutlined style="color: #fff; font-size: 24px" />
						</template>
						<template #description>
							<h2 v-if="responseData.stats">
								{{ responseData.stats.totalCompaniesCount }}
							</h2>
							<p>{{ $t("superadmin_dashboard.total_companies") }}</p>
						</template>
					</StateWidget>
				</a-col>
				<a-col :xs="24" :sm="24" :md="12" :lg="6" :xl="6">
					<StateWidget bgColor="#63ed7a">
						<template #image>
							<DatabaseOutlined style="color: #fff; font-size: 24px" />
						</template>
						<template #description>
							<h2 v-if="responseData.stats">
								{{ responseData.stats.activeCompaniesCount }}
							</h2>
							<p>{{ $t("superadmin_dashboard.active_companies") }}</p>
						</template>
					</StateWidget>
				</a-col>
				<a-col :xs="24" :sm="24" :md="12" :lg="6" :xl="6">
					<StateWidget bgColor="#ffa426">
						<template #image>
							<EyeInvisibleOutlined style="color: #fff; font-size: 24px" />
						</template>
						<template #description>
							<h2 v-if="responseData.stats">
								{{ responseData.stats.inactiveCompaniesCount }}
							</h2>
							<p>{{ $t("superadmin_dashboard.inactive_companies") }}</p>
						</template>
					</StateWidget>
				</a-col>
				<a-col :xs="24" :sm="24" :md="12" :lg="6" :xl="6">
					<StateWidget bgColor="#fc544b">
						<template #image>
							<WarningOutlined style="color: #fff; font-size: 24px" />
						</template>
						<template #description>
							<h2 v-if="responseData.stats">
								{{ responseData.stats.expiredCompaniesCount }}
							</h2>
							<p>{{ $t("superadmin_dashboard.license_expired") }}</p>
						</template>
					</StateWidget>
				</a-col>
			</a-row>
		</div>

		<a-row :gutter="18" class="mt-30 mb-20">
			<a-col :span="24">
				<a-card :title="$t('superadmin_dashboard.recently_registered_companies')">
					<CompanyTable :showFilterInput="false" :perPageItems="5" />
					<template #extra>
						<a-button
							class="mt-10"
							type="link"
							@click="$router.push({ name: 'superadmin.companies.index' })"
						>
							{{ $t("common.view_all") }}
							<DoubleRightOutlined />
						</a-button>
					</template>
				</a-card>
			</a-col>
		</a-row>
	</div>
</template>

<script>
import { ref, onMounted, reactive, toRef, watch } from "vue";
import {
	RocketOutlined,
	DatabaseOutlined,
	EyeInvisibleOutlined,
	WarningOutlined,
	DoubleRightOutlined,
} from "@ant-design/icons-vue";
import SuperAdminPageHeader from "../layouts/SuperAdminPageHeader.vue";
import SuperadminUpdateAppAlert from "./SuperadminUpdateAppAlert.vue";
import StateWidget from "../../common/components/common/card/StateWidget.vue";
import CompanyTable from "./companies/CompanyTable.vue";

export default {
	components: {
		SuperAdminPageHeader,
		SuperadminUpdateAppAlert,

		StateWidget,
		RocketOutlined,
		DatabaseOutlined,
		EyeInvisibleOutlined,
		WarningOutlined,
		DoubleRightOutlined,

		CompanyTable,
	},
	setup() {
		const responseData = ref([]);

		onMounted(() => {
			axiosAdmin.get("superadmin/dashboard").then((dashboardResponse) => {
				responseData.value = dashboardResponse.data;
			});
		});

		return {
			responseData,
		};
	},
};
</script>
