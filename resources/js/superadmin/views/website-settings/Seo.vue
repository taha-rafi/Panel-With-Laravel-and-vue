<template>
	<a-row :span="16">
		<a-col>
			<a-modal v-model:visible="visible" :title="addEditTitle">
				<a-form layout="vertical">
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('website_settings.seo_title')"
								name="seo_title"
								:help="rules.seo_title ? rules.seo_title.message : null"
								:validateStatus="rules.seo_title ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.seo_title"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('website_settings.seo_title'),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('website_settings.seo_author')"
								name="seo_author"
								:help="rules.seo_author ? rules.seo_author.message : null"
								:validateStatus="rules.seo_author ? 'error' : null"
								class="required"
							>
								<a-input
									v-model:value="formData.seo_author"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('website_settings.seo_author'),
										])
									"
								/>
							</a-form-item>
						</a-col>
					</a-row>

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('website_settings.seo_keywords')"
								name="seo_keywords"
								:help="
									rules.seo_keywords ? rules.seo_keywords.message : null
								"
								:validateStatus="rules.seo_keywords ? 'error' : null"
							>
								<a-textarea
									v-model:value="formData.seo_keywords"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('website_settings.seo_keywords'),
										])
									"
									:rows="2"
								/>
							</a-form-item>
						</a-col>
					</a-row>
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('website_settings.seo_description')"
								name="seo_description"
								:help="
									rules.seo_description
										? rules.seo_description.message
										: null
								"
								:validateStatus="rules.seo_description ? 'error' : null"
							>
								<a-textarea
									v-model:value="formData.seo_description"
									:placeholder="
										$t('common.placeholder_default_text', [
											$t('website_settings.seo_description'),
										])
									"
									:rows="2"
								/>
							</a-form-item>
						</a-col>
					</a-row>
					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-form-item
								:label="$t('website_settings.seo_image')"
								name="seo_image"
								:help="rules.seo_image ? rules.seo_image.message : null"
								:validateStatus="rules.seo_image ? 'error' : null"
							>
								<Upload
									:formData="formData"
									folder="website"
									imageField="seo_image"
									@onFileUploaded="
										(file) => {
											formData.seo_image = file.file;
											formData.seo_image_url = file.file_url;
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
		</a-col>
	</a-row>
	<a-row :gutter="[18, 18]" class="mt-20 mb-20">
		<a-col :span="24">
			<a-table
				:columns="columns"
				:row-key="(record) => record.id"
				:data-source="tableData"
				:pagination="false"
			>
				<template #bodyCell="{ column, record }">
					<template v-if="column.dataIndex === 'action'">
						<a-space>
							<a-button type="primary" @click="editItem(record)">
								<template #icon><EditOutlined /></template>
							</a-button>
						</a-space>
					</template>
				</template>
			</a-table>
		</a-col>
	</a-row>
</template>
<script>
import { onMounted } from "vue";
import { PlusOutlined, EditOutlined, SaveOutlined } from "@ant-design/icons-vue";
import landingWebsiteSetting from "../../composable/landingWebsiteSetting";
import fields from "./fields";
import common from "../../../common/composable/common";
import Upload from "../../../common/core/ui/file/Upload.vue";

export default {
	props: ["langKey"],
	components: {
		PlusOutlined,
		EditOutlined,
		SaveOutlined,
		Upload,
	},
	setup(props) {
		const landingWebsite = landingWebsiteSetting(props);
		const { details } = fields("website_seo");
		const { slugify } = common();

		onMounted(() => {
			landingWebsite.columns.value = details.value.columns;
			landingWebsite.settingType.value = details.value.setting_type;
			landingWebsite.langType.value = details.value.lang_type;
			landingWebsite.initData.value = details.value.init_data;
			landingWebsite.deletable.value = false;
			landingWebsite.addable.value = false;
			landingWebsite.getData(props.langKey);
		});

		return {
			...landingWebsite,
			slugify,
		};
	},
};
</script>
