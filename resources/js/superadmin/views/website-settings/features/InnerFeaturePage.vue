<template>
	<a-row :gutter="18" class="mb-20">
		<a-col :span="24">
			<a-button type="primary" @click="showAdd">
				<template #icon><PlusOutlined /></template>
				{{ $t("common.add") }}
			</a-button>

			<a-modal v-model:visible="visible" :title="addEditTitle">
				<a-form layout="vertical">
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('common.title')"
								name="title"
								:help="rules.title ? rules.title.message : null"
								:validateStatus="rules.title ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.title"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('common.title'),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('common.description')"
								name="description"
								:help="
									rules.description ? rules.description.message : null
								"
								:validateStatus="rules.description ? 'error' : null"
								class="required"
							>
								<a-textarea
									v-model:value="formData.description"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('common.description'),
										])
									"
									:rows="4"
								/>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('common.image')"
								name="image"
								:help="rules.image ? rules.image.message : null"
								:validateStatus="rules.image ? 'error' : null"
								class="required"
							>
								<Upload
									:formData="formData"
									folder="website"
									imageField="image"
									@onFileUploaded="
										(file) => {
											formData.image = file.file;
											formData.image_url = file.file_url;
										}
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>
				</a-form>
				<template #footer>
					<a-button
						key="submit"
						type="primary"
						:loading="loading"
						@click="onSubmit"
					>
						<template #icon>
							<SaveOutlined />
						</template>
						{{
							addEditType == "add"
								? $t("common.create")
								: $t("common.update")
						}}
					</a-button>
					<a-button key="back" @click="onClose">
						{{ $t("common.cancel") }}
					</a-button>
				</template>
			</a-modal>

			<a-table
				:columns="columns"
				:data-source="currentRecord.features"
				:pagination="false"
			>
				<template #bodyCell="{ column, record }">
					<template v-if="column.dataIndex === 'image'">
						<a-image :width="48" :src="record.image_url" />
					</template>
					<template v-if="column.dataIndex === 'action'">
						<a-space>
							<a-button type="primary" @click="editItem(record)">
								<template #icon><EditOutlined /></template>
							</a-button>
							<a-button type="primary" @click="showDeleteConfirm(record)">
								<template #icon><DeleteOutlined /></template>
							</a-button>
						</a-space>
					</template>
				</template>
			</a-table>
		</a-col>
	</a-row>
</template>

<script>
import { defineComponent, ref, createVNode } from "vue";
import {
	PlusOutlined,
	EditOutlined,
	DeleteOutlined,
	SaveOutlined,
	ExclamationCircleOutlined,
} from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import { forEach, filter } from "lodash-es";
import { Modal, message } from "ant-design-vue";
import Upload from "../../../../common/core/ui/file/Upload.vue";
import apiAdmin from "../../../../common/composable/apiAdmin";

export default defineComponent({
	props: ["tableData", "currentRecord", "langKey"],
	emits: ["success"],
	components: {
		PlusOutlined,
		EditOutlined,
		DeleteOutlined,
		SaveOutlined,
		Upload,
	},
	setup(props, { emit }) {
		const { addEditRequestAdmin, loading, rules } = apiAdmin();
		const addEditTitle = ref("");
		const visible = ref(false);
		const formData = ref({
			id: Math.random().toString(36).slice(2),
			title: "",
			description: "",
			image: null,
			image_url: "",
		});
		const addEditType = ref("add");
		const { t } = useI18n();
		const columns = ref([
			{
				title: t("common.title"),
				dataIndex: "title",
			},
			{
				title: t("common.description"),
				dataIndex: "description",
			},
			{
				title: t("common.image"),
				dataIndex: "image",
			},
			{
				title: t("common.action"),
				dataIndex: "action",
			},
		]);

		const showAdd = () => {
			rules.value = {};
			addEditType.value = "add";
			addEditTitle.value = t(`website_settings.add_feature`);

			formData.value = {
				id: Math.random().toString(36).slice(2),
				title: "",
				description: "",
				image: null,
				image_url: "",
			};

			visible.value = true;
		};

		const editItem = (record) => {
			rules.value = {};
			addEditType.value = "edit";
			addEditTitle.value = t(`website_settings.edit_feature`);

			formData.value = {
				...record,
			};

			visible.value = true;
		};

		const onSubmit = () => {
			rules.value = {};
			var newFullData = [];

			forEach(props.tableData, (currentData) => {
				if (currentData.id == props.currentRecord.id) {
					var submitData = { ...currentData };
					if (addEditType.value == "add") {
						submitData["features"] = [
							...currentData.features,
							formData.value,
						];
					} else {
						var featuresArray = [];
						forEach(currentData.features, (currentDataFeature) => {
							if (currentDataFeature.id == formData.value.id) {
								featuresArray.push(formData.value);
							} else {
								featuresArray.push(currentDataFeature);
							}
						});
						submitData["features"] = [...featuresArray];
					}
					newFullData.push(submitData);
				} else {
					newFullData.push(currentData);
				}
			});

			addEditRequestAdmin({
				url: `superadmin/website-settings/settings/update`,
				data: {
					lang_key: props.langKey,
					request_type: "add_edit",
					setting_type: "features_page",
					form_data: { lang_key: props.langKey, ...formData.value },
					all_form_data: newFullData,
				},
				successMessage:
					addEditType.value == "edit"
						? t(`website_settings.feature_updated`)
						: t(`website_settings.feature_created`),
				success: (res) => {
					emit("success", newFullData);
					visible.value = false;
				},
			});
		};

		const showDeleteConfirm = (record) => {
			Modal.confirm({
				title: t("common.delete") + "?",
				icon: createVNode(ExclamationCircleOutlined),
				content: t(`website_settings.feature_delete_message`),
				centered: true,
				okText: t("common.yes"),
				okType: "danger",
				cancelText: t("common.no"),
				onOk() {
					var newFullData = [];
					forEach(props.tableData, (currentData) => {
						if (currentData.id == props.currentRecord.id) {
							var submitData = { ...currentData };
							var featuresArray = [];
							forEach(currentData.features, (currentDataFeature) => {
								if (currentDataFeature.id != record.id) {
									featuresArray.push(currentDataFeature);
								}
							});
							submitData["features"] = [...featuresArray];
							newFullData.push(submitData);
						} else {
							newFullData.push(currentData);
						}
					});

					addEditRequestAdmin({
						url: `superadmin/website-settings/settings/update`,
						data: {
							lang_key: props.langKey,
							request_type: "delete",
							setting_type: "features_page",
							form_data: {},
							all_form_data: newFullData,
						},
						successMessage: t(`website_settings.feature_deleted`),
						success: (res) => {
							emit("success", newFullData);
						},
					});
				},
				onCancel() {},
			});
		};

		const onClose = () => {
			visible.value = false;
			rules.value = {};
			formData.value = {
				id: Math.random().toString(36).slice(2),
				title: "",
				description: "",
				image: null,
				image_url: "",
			};
		};

		return {
			columns,
			loading,
			formData,
			addEditType,
			addEditTitle,
			visible,
			rules,

			showAdd,
			editItem,
			onClose,
			onSubmit,
			showDeleteConfirm,
		};
	},
});
</script>

<style></style>
