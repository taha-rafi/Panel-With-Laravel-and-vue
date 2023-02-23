<template>
	<a-button type="primary" @click="generateBack" :loading="loading">
		<PlusOutlined />
		{{ $t("database_backup.generate_backup") }}
	</a-button>
</template>

<script>
import { defineComponent, createVNode } from "vue";
import { useI18n } from "vue-i18n";
import { PlusOutlined } from "@ant-design/icons-vue";
import { ExclamationCircleOutlined } from "@ant-design/icons-vue";
import { Modal } from "ant-design-vue";
import apiAdmin from "../../../../../common/composable/apiAdmin";
import { getUrlByAppType } from "../../../../../common/scripts/functions";

export default defineComponent({
	emits: ["success"],
	components: {
		PlusOutlined,
		ExclamationCircleOutlined,
	},
	setup(props, { emit }) {
		const { t } = useI18n();
		const { addEditRequestAdmin, loading } = apiAdmin();

		const generateBack = () => {
			Modal.confirm({
				title: t("database_backup.generate_backup"),
				icon: createVNode(ExclamationCircleOutlined),
				content: t("database_backup.are_you_sure_generate_backup"),
				okText: t("common.yes"),
				okType: "danger",
				cancelText: t("common.no"),
				onOk() {
					addEditRequestAdmin({
						url: getUrlByAppType("generate-backups"),
						data: {},
						successMessage: t(
							"database_backup.backup_generated_successfully"
						),
						success: (response) => {
							emit("success", response);
						},
					});
				},
				onCancel() {},
			});
		};

		return {
			generateBack,
			loading,
		};
	},
});
</script>
