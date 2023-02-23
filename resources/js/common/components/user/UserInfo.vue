<template>
	<div v-if="user">
		<a-badge>
			<a-avatar :size="30" :src="user.profile_image_url" />
			{{ user.name }}
		</a-badge>
	</div>
	<div v-else>
		<span>
			{{ $t("user.walk_in_customer") }}
		</span>
	</div>
</template>

<script>
export default {
	props: ["user", "size"],
};
</script>
