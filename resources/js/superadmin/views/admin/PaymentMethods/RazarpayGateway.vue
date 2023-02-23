<template>
	<a-row :gutter="16">
		<a-col :xs="24" :sm="24" :md="24" :lg="24">
			<div class="mb-20">
				<a-alert v-if="errorText != ''" :message="errorText" type="error" />
			</div>

			<a-button
				@click="makePayment"
				type="primary"
				class="mb-20"
				:loading="loading"
				block
			>
				Pay
			</a-button>
		</a-col>
	</a-row>
</template>

<script>
import { ref, onMounted } from "vue";
import { useStore } from "vuex";
import { message } from "ant-design-vue";
import common from "../../../../common/composable/common";

export default {
	props: ["paymentMethod", "subscribePlan", "planType"],
	setup(props, { emit }) {
		const store = useStore();
		const { globalSetting, appSetting } = common();
		const loading = ref(false);
		const errorText = ref("");

		onMounted(() => {});

		const makePayment = () => {
			loading.value = true;

			axiosAdmin
				.post("razorpay-subscription", {
					plan_id: props.subscribePlan.xid,
					plan_type: props.planType,
				})
				.then((response) => {
					var options = {
						key: props.paymentMethod.credentials.razorpay_key,
						subscription_id: response.data.subscriprion,
						name: globalSetting.value.name,
						description: props.subscribePlan.description,
						image: globalSetting.value.light_logo_url,
						handler: function (response) {
							confirmRazorpayPayment(response);
						},
						notes: {
							package_id: props.subscribePlan.xid,
							package_type: props.planType,
							company_id: appSetting.value.xid,
						},
					};

					var rzp1 = new Razorpay(options);
					rzp1.open();

					loading.value = false;
				})
				.catch((error) => {
					loading.value = false;
				});
		};

		const confirmRazorpayPayment = (response) => {
			loading.value = true;

			const paymentId = response.razorpay_payment_id;
			const subscriptionId = response.razorpay_subscription_id;
			const razorpaySignature = response.razorpay_signature;

			axiosAdmin
				.post("razorpay-payment", {
					payment_id: paymentId,
					plan_id: props.subscribePlan.xid,
					subscription_id: subscriptionId,
					type: props.planType,
					razorpay_signature: razorpaySignature,
				})
				.then((response) => {
					if (response.data.success) {
						store.dispatch("auth/updateApp");
						message.success(response.data.message);
						emit("success", true);
					} else {
						errorText.value = response.data.message;
					}

					loading.value = false;
				})
				.catch((error) => {
					loading.value = false;
				});
		};

		return {
			loading,
			makePayment,
			errorText,
		};
	},
};
</script>
