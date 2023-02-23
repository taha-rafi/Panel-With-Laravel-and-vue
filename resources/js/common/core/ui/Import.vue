<template>
	<div>
		<a-button type="primary" @click="showModal">
			<CloudDownloadOutlined />
			{{ pageTitle }}
		</a-button>
		<a-modal v-model:visible="visible" :title="pageTitle">
			<a-row :gutter="16" class="mb-10">
				<a-col :xs="24" :sm="24" :md="24" :lg="24">
					<a-typography-paragraph>
						<ul>
							<li>
								<a-typography-link :href="sampleFileUrl" target="_blank">
									{{
										$t("messages.click_here_to_download_sample_file")
									}}
								</a-typography-link>
							</li>
						</ul>
					</a-typography-paragraph>
				</a-col>
			</a-row>
			<a-row :gutter="16">
				<a-col :xs="24" :sm="24" :md="24" :lg="24">
					<a-form layout="vertical">
						<a-form-item
							:label="$t('common.file')"
							name="file"
							:help="rules.file ? rules.file.message : null"
							:validateStatus="rules.file ? 'error' : null"
						>
							<a-upload
								:accept="'.xlsx,.csv'"
								v-model:file-list="fileList"
								name="file"
								:before-upload="beforeUpload"
								:maxCount="1"
							>
								<a-button :loading="loading">
									<template #icon>
										<UploadOutlined></UploadOutlined>
									</template>
									{{ $t("common.upload") }}
								</a-button>
							</a-upload>
						</a-form-item>
					</a-form>
				</a-col>
			</a-row>
			<template #footer>
				<a-button type="primary" :loading="loading" @click="importItems">
					{{ $t("common.import") }}
				</a-button>
				<a-button key="back" @click="handleCancel">
					{{ $t("common.cancel") }}
				</a-button>
			</template>
		</a-modal>
	</div>
</template>
<script>
import { defineComponent, ref } from "vue";
import { CloudDownloadOutlined, UploadOutlined } from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
import apiAdmin from "../../composable/apiAdmin";
import UploadFile from "./file/UploadFile.vue";

export default defineComponent({
	props: ["pageTitle", "sampleFileUrl", "importUrl"],
	emits: ["onUploadSuccess"],
	components: {
		CloudDownloadOutlined,
		UploadFile,
		UploadOutlined,
	},
	setup(props, { emit }) {
		const { addEditFileRequestAdmin, loading, rules } = apiAdmin();
		const { t } = useI18n();
		const fileList = ref([]);
		const visible = ref(false);

		const beforeUpload = (file) => {
			fileList.value = [...fileList.value, file];
			return false;
		};

		const importItems = () => {
			const formData = {};
			if (fileList && fileList.value && fileList.value[0] != undefined) {
				formData.file = fileList.value[0];
			}

			loading.value = true;

			addEditFileRequestAdmin({
				url: props.importUrl,
				data: formData,
				successMessage: t("messages.imported_successfully"),
				success: (res) => {
					handleCancel();

					emit("onUploadSuccess");
				},
			});
		};

		const showModal = () => {
			visible.value = true;
		};

		const handleCancel = (e) => {
			fileList.value = [];
			visible.value = false;
		};

		return {
			fileList,
			rules,
			loading,

			visible,
			showModal,
			handleCancel,
			importItems,

			beforeUpload,
		};
	},
});
</script>
