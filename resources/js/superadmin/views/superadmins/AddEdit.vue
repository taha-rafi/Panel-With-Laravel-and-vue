<template>
	<a-drawer
		:title="pageTitle"
		:width="drawerWidth"
		:visible="visible"
		:body-style="{ paddingBottom: '80px' }"
		:footer-style="{ textAlign: 'right' }"
		:maskClosable="false"
		@close="onClose"
	>
		<a-form layout="vertical">
			<a-row>
				<a-col :xs="24" :sm="24" :md="6" :lg="6">
					<a-form-item
						:label="$t('user.profile_image')"
						name="profile_image"
						:help="rules.profile_image ? rules.profile_image.message : null"
						:validateStatus="rules.profile_image ? 'error' : null"
					>
						<Upload
							:formData="formData"
							folder="user"
							imageField="profile_image"
							@onFileUploaded="
								(file) => {
									formData.profile_image = file.file;
									formData.profile_image_url = file.file_url;
								}
							"
						/>
					</a-form-item>
				</a-col>
				<a-col :xs="24" :sm="24" :md="18" :lg="18">
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('user.name')"
								name="name"
								:help="rules.name ? rules.name.message : null"
								:validateStatus="rules.name ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.name"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('user.name'),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('user.email')"
								name="email"
								:help="rules.email ? rules.email.message : null"
								:validateStatus="rules.email ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.email"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('user.email'),
										])
									"
								/>
							</a-form-item>
						</a-col>
						<a-col :xs="24" :sm="24" :md="12" :lg="12">
							<a-form-item
								:label="$t('user.phone')"
								name="phone"
								:help="rules.phone ? rules.phone.message : null"
								:validateStatus="rules.phone ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.phone"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('user.phone'),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>
					<a-row :gutter="16">
						<a-col :span="24">
							<a-form-item
								:label="$t('user.password')"
								name="password"
								:help="rules.password ? rules.password.message : null"
								:validateStatus="rules.password ? 'error' : null"
								class="required"
							>
								<a-input-password
									v-model:value="formData.password"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('user.password'),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>
					<a-row :gutter="16">
						<a-col :span="24">
							<a-form-item
								:label="$t('user.status')"
								name="status"
								:help="rules.status ? rules.status.message : null"
								:validateStatus="rules.status ? 'error' : null"
								class="required"
							>
								<a-select
									v-model:value="formData.status"
									:placeholder="
										$t('common.select_default_text', [
											$t('user.status'),
										])
									"
									:allowClear="true"
								>
									<a-select-option value="enabled">
										{{ $t("common.enabled") }}
									</a-select-option>
									<a-select-option value="disabled">
										{{ $t("common.disabled") }}
									</a-select-option>
								</a-select>
							</a-form-item>
						</a-col>
					</a-row>
				</a-col>
			</a-row>
		</a-form>
		<template #footer>
			<a-space>
				<a-button
					key="submit"
					type="primary"
					:loading="loading"
					@click="onSubmit"
				>
					<template #icon>
						<SaveOutlined />
					</template>
					{{ addEditType == "add" ? $t("common.create") : $t("common.update") }}
				</a-button>
				<a-button key="back" @click="onClose">
					{{ $t("common.cancel") }}
				</a-button>
			</a-space>
		</template>
	</a-drawer>
</template>

<script>
import { defineComponent, ref, onMounted } from "vue";
import { PlusOutlined, LoadingOutlined, SaveOutlined } from "@ant-design/icons-vue";
import apiAdmin from "../../../common/composable/apiAdmin";
import Upload from "../../../common/core/ui/file/Upload.vue";
import FormItemHeading from "../../../common/components/common/typography/FormItemHeading.vue";

export default defineComponent({
	props: [
		"formData",
		"data",
		"visible",
		"url",
		"addEditType",
		"pageTitle",
		"successMessage",
	],
	components: {
		PlusOutlined,
		LoadingOutlined,
		SaveOutlined,
		Upload,
		FormItemHeading,
	},
	setup(props, { emit }) {
		const { addEditRequestAdmin, loading, rules } = apiAdmin();

		const onSubmit = () => {
			addEditRequestAdmin({
				url: props.url,
				data: props.formData,
				successMessage: props.successMessage,
				success: (res) => {
					emit("addEditSuccess", res.xid);
				},
			});
		};

		const onClose = () => {
			rules.value = {};
			emit("closed");
		};

		return {
			loading,
			rules,
			onClose,
			onSubmit,

			drawerWidth: window.innerWidth <= 991 ? "90%" : "45%",
		};
	},
});
</script>
