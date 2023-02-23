<template>
	<div
		v-if="
			(panelType == 'admin' &&
				(permsArray.includes('currencies_create') ||
					permsArray.includes('admin'))) ||
			panelType == 'superadmin'
		"
	>
		<template v-if="customType == 'menu'">
			<a-menu-item @click="showAdd" key="categories">
				<template #icon>
					<slot name="icon"></slot>
				</template>
				<slot></slot>
			</a-menu-item>
		</template>
		<template v-else>
			<a-tooltip
				v-if="tooltip"
				placement="topLeft"
				:title="$t('currency.add')"
				arrow-point-at-center
			>
				<a-button @click="showAdd" class="ml-5 no-border-radius" :type="btnType">
					<template #icon> <PlusOutlined /> </template>
					<slot></slot>
				</a-button>
			</a-tooltip>
			<a-button
				v-else
				@click="showAdd"
				class="ml-5 no-border-radius"
				:type="btnType"
			>
				<template #icon> <PlusOutlined /> </template>
				<slot></slot>
			</a-button>
		</template>

		<AddEdit
			:addEditType="addEditType"
			:visible="visible"
			:url="addEditUrl"
			@addEditSuccess="addEditSuccess"
			@closed="onClose"
			:formData="formData"
			:data="formData"
			:pageTitle="$t('currency.add')"
			:successMessage="$t('currency.created')"
		/>
	</div>
</template>
<script>
import { defineComponent, ref } from "vue";
import { PlusOutlined } from "@ant-design/icons-vue";
import fields from "./fields";
import AddEdit from "./AddEdit.vue";
import common from "../../../../../common/composable/common";

export default defineComponent({
	props: {
		panelType: {
			type: String,
			default: "admin",
		},
		btnType: {
			default: "default",
		},
		tooltip: {
			default: true,
		},
		customType: {
			default: "button",
		},
	},
	emits: ["onAddSuccess"],
	components: {
		PlusOutlined,
		AddEdit,
	},
	setup(props, { emit }) {
		const { permsArray } = common();
		const { initData, addEditUrl } = fields(props.panelType);
		const visible = ref(false);
		const addEditType = ref("add");
		const formData = ref({ ...initData });

		const showAdd = () => {
			visible.value = true;
		};

		const addEditSuccess = () => {
			visible.value = false;
			formData.value = { ...initData };
			emit("onAddSuccess");
		};

		const onClose = () => {
			visible.value = false;
		};

		return {
			permsArray,
			visible,
			addEditType,
			addEditUrl,
			formData,
			addEditSuccess,
			onClose,
			showAdd,
		};
	},
});
</script>
