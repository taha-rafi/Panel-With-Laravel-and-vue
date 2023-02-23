<template>
	<a-row
		class="mt-20"
		v-if="
			appSetting.update_app_notification &&
			productStatus == 'update_available' &&
			appType == 'non-saas'
		"
	>
		<a-col :span="24">
			<a-alert
				v-if="productStatus == 'update_available'"
				type="success"
				:message="$t('update_app.update_available')"
				showIcon
				@close="() => $router.push({ name: 'admin.settings.update_app.index' })"
			>
				<template #description>
					{{
						$t("messages.new_app_version_avaialbe", [product.product.version])
					}}
				</template>
				<template #closeText>
					<a-button type="primary">
						<template #icon>
							<CloudDownloadOutlined />
						</template>
						{{ $t("update_app.update_now") }}
					</a-button>
				</template>
			</a-alert>
		</a-col>
	</a-row>
</template>

<script>
import { watch, onMounted, computed, ref, defineComponent } from "vue";
import { SyncOutlined, CloudDownloadOutlined } from "@ant-design/icons-vue";
import axios from "axios";
import common from "../../common/composable/common";
import { getUrlByAppType } from "../../common/scripts/functions";

export default defineComponent({
	components: {
		SyncOutlined,
		CloudDownloadOutlined,
	},
	setup() {
		const { appSetting, appType } = common();
		const appVersion = window.config.app_version;
		const productStatus = ref("fetching");
		const product = ref([]);

		onMounted(() => {
			if (appSetting.value.update_app_notification && appType == "non-saas") {
				axiosAdmin(getUrlByAppType("update-app")).then((response) => {
					axios
						.post("https://envato.codeifly.com/product", {
							verified_name: window.config.product_name,
							domain: window.location.host,
						})
						.then((res) => {
							product.value = res.data;

							if (product.value.product.version != appVersion) {
								productStatus.value = "update_available";
							} else {
								productStatus.value = "success";
							}
						});
				});
			}
		});

		return {
			appSetting,
			productStatus,
			product,
			appType,
		};
	},
});
</script>
