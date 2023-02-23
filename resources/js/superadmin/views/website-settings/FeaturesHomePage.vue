<template>
	<a-row :span="16">
		<a-col>
			<a-button @click="showAdd" type="primary">
				<template #icon> <PlusOutlined /> </template>
				{{ $t("website_settings.add_feature") }}
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

					<a-row :gutter="16">
						<a-col :xs="24" :sm="24" :md="24" :lg="24">
							<a-typography-title
								:level="5"
								:style="{ marginBottom: '10px' }"
							>
								{{ $t("website_settings.features_lists") }}
							</a-typography-title>
							<DynamicFormFeatures
								:data="formData.features"
								:addText="$t('website_settings.add_feature')"
								@onEntry="(allTags) => (formData.features = allTags)"
							/>
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
					<template v-if="column.dataIndex === 'image'">
						<a-image
							v-if="record.image"
							:width="70"
							:src="record.image_url"
						/>
						<span v-else>-</span>
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
import { onMounted } from "vue";
import {
	PlusOutlined,
	EditOutlined,
	DeleteOutlined,
	SaveOutlined,
} from "@ant-design/icons-vue";
import landingWebsiteSetting from "../../composable/landingWebsiteSetting";
import Upload from "../../../common/core/ui/file/Upload.vue";
import fields from "./fields";
import DynamicFormFeatures from "./features/DynamicFormFeatures.vue";

export default {
	props: ["langKey"],
	components: {
		PlusOutlined,
		EditOutlined,
		DeleteOutlined,
		SaveOutlined,

		Upload,
		DynamicFormFeatures,
	},
	setup(props) {
		const landingWebsite = landingWebsiteSetting(props);
		const { details } = fields("website_features");

		onMounted(() => {
			landingWebsite.columns.value = details.value.columns;
			landingWebsite.settingType.value = details.value.setting_type;
			landingWebsite.langType.value = details.value.lang_type;
			landingWebsite.initData.value = details.value.init_data;
			landingWebsite.getData(props.langKey);
		});

		return {
			...landingWebsite,
		};
	},
};
</script>
