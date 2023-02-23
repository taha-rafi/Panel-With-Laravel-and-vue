<template>
	<SuperAdminPageHeader>
		<template #header>
			<a-page-header :title="$t(`menu.companies`)" class="p-0">
				<template #extra>
					<a-button type="primary" @click="addItem">
						<PlusOutlined />
						{{ $t("company.add") }}
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
					{{ $t(`menu.companies`) }}
				</a-breadcrumb-item>
			</a-breadcrumb>
		</template>
	</SuperAdminPageHeader>

	<a-card class="page-content-container">
		<a-row class="mb-20">
			<a-col :span="24">
				<EmailNotSetup />
			</a-col>
		</a-row>

		<CompanyTable ref="companyTableRef" />
	</a-card>
</template>
<script>
import { ref } from "vue";
import { PlusOutlined } from "@ant-design/icons-vue";
import SuperAdminPageHeader from "../../layouts/SuperAdminPageHeader.vue";
import EmailNotSetup from "../settings/email/EmailNotSetup.vue";
import CompanyTable from "./CompanyTable.vue";

export default {
	components: {
		PlusOutlined,
		SuperAdminPageHeader,
		EmailNotSetup,
		CompanyTable,
	},
	setup() {
		const companyTableRef = ref(null);

		const addItem = () => {
			companyTableRef.value.addItem();
		};

		return {
			addItem,
			companyTableRef,
		};
	},
};
</script>
