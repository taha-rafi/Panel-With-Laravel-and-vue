<template>
	<div :style="{ marginBottom: '20px' }">
		<template v-for="tag in tags" :key="tag">
			<a-tooltip v-if="tag.length > 20" :title="tag">
				<a-tag
					closable
					@close="handleClose(tag)"
					:style="{ marginBottom: '20px' }"
				>
					{{ `${tag.slice(0, 20)}...` }}
				</a-tag>
			</a-tooltip>
			<a-tag
				v-else
				closable
				@close="handleClose(tag)"
				:style="{ marginBottom: '20px' }"
			>
				{{ tag }}
			</a-tag>
		</template>
		<a-input
			v-if="inputVisible"
			ref="inputRef"
			v-model:value="inputValue"
			type="text"
			size="small"
			:style="{ width: '100px' }"
			@blur="handleInputConfirm"
			@keyup.enter="handleInputConfirm"
		/>
		<a-tag v-else style="background: #fff; border-style: dashed" @click="showInput">
			<plus-outlined />
			{{ addText }}
		</a-tag>
	</div>
</template>

<script>
import { defineComponent, watch, ref, reactive, toRefs, nextTick } from "vue";
import { PlusOutlined } from "@ant-design/icons-vue";

export default defineComponent({
	props: ["data", "addText"],
	emits: ["onEntry"],
	components: {
		PlusOutlined,
	},
	setup(props, { emit }) {
		const inputRef = ref();
		const state = reactive({
			tags: props.data,
			inputVisible: false,
			inputValue: "",
		});

		const handleClose = (removedTag) => {
			const tags = state.tags.filter((tag) => tag !== removedTag);
			state.tags = tags;

			emit("onEntry", tags);
		};

		const showInput = () => {
			state.inputVisible = true;
			nextTick(() => {
				inputRef.value.focus();
			});
		};

		const handleInputConfirm = () => {
			const inputValue = state.inputValue;
			let tags = state.tags;

			if (inputValue && tags.indexOf(inputValue) === -1) {
				tags = [...tags, inputValue];
			}

			Object.assign(state, {
				tags,
				inputVisible: false,
				inputValue: "",
			});

			emit("onEntry", tags);
		};

		watch(
			() => props.data,
			(newVal, oldVal) => {
				state.tags = newVal;
			}
		);

		return { ...toRefs(state), handleClose, showInput, handleInputConfirm, inputRef };
	},
});
</script>
