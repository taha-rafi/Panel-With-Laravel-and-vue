<template>
	<div>
		<div v-for="(dataArray, index) in dynamicValidateForm" :key="index">
			<a-row :gutter="[16, 16]">
				<a-col :xs="10" :sm="10" :md="11" :lg="11">
					<a-form-item :name="['dataArray', index, 'title']">
						<a-input
							v-model:value="dataArray.title"
							:placeholder="$t('common.title')"
							:rules="{
								required: true,
								message: $t('front_setting.required_text', [
									$t('common.title'),
								]),
							}"
						/>
					</a-form-item>
				</a-col>
				<a-col :xs="10" :sm="10" :md="11" :lg="11">
					<a-form-item :name="['dataArray', index, 'value']">
						<a-input
							v-model:value="dataArray.value"
							:placeholder="$t('common.value')"
							:rules="{
								required: true,
								message: $t('front_setting.required_text', [
									$t('common.value'),
								]),
							}"
						/>
					</a-form-item>
				</a-col>
				<a-col :xs="4" :sm="4" :md="2" :lg="2">
					<MinusCircleOutlined @click="removeItem(dataArray)" />
				</a-col>
			</a-row>
		</div>

		<a-row :gutter="16">
			<a-col :xs="24" :sm="24" :md="24" :lg="24">
				<a-form-item>
					<a-button type="dashed" block @click="addItem">
						<PlusOutlined />
						{{ addText }}
					</a-button>
				</a-form-item>
			</a-col>
		</a-row>
	</div>
</template>

<script>
import { defineComponent, ref, onMounted } from "vue";
import { PlusOutlined, MinusCircleOutlined } from "@ant-design/icons-vue";

export default defineComponent({
	props: ["data", "addText"],
	components: {
		PlusOutlined,
		MinusCircleOutlined,
	},
	setup(props, { emit }) {
		const dynamicValidateForm = ref([]);

		onMounted(() => {
			dynamicValidateForm.value = props.data;
		});

		const removeItem = (item) => {
			let index = dynamicValidateForm.value.indexOf(item);

			if (index !== -1) {
				dynamicValidateForm.value.splice(index, 1);
			}
		};

		const addItem = () => {
			dynamicValidateForm.value.push({
				title: "",
				value: "",
			});
		};

		return {
			dynamicValidateForm,

			removeItem,
			addItem,
		};
	},
});
</script>

<style></style>
