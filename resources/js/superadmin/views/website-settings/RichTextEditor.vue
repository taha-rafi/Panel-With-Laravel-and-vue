<template>
	<QuillEditor toolbar="#my-toolbar" theme="snow" ref="quillObject">
		<template #toolbar>
			<div id="my-toolbar">
				<!-- Add buttons as you would before -->
				<button class="ql-bold"></button>
				<button class="ql-italic"></button>

				<!-- But you can also add your own -->
				<button @click="rawClicked">Raw</button>
			</div>
		</template>
	</QuillEditor>
</template>

<script>
import { ref } from "vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

export default {
	components: {
		QuillEditor,
	},
	setup() {
		const quillObject = ref(null);
		const rawClicked = () => {
			console.log(quillObject.value.getHTML());
		};

		return {
			quillObject,
			rawClicked,
		};
	},
};
</script>

<style></style>
