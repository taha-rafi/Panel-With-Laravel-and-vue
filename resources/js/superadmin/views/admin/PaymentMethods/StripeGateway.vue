<template>
	<a-form layout="vertical">
		<div class="mb-20">
			<a-alert v-if="errorText != ''" :message="errorText" type="error" />
		</div>

		<a-row :gutter="16">
			<a-col :xs="24" :sm="24" :md="24" :lg="24">
				<a-form-item
					:label="$t('payment_settings.stripe_customer_name')"
					name="name"
					:help="rules.name ? rules.name.message : null"
					:validateStatus="rules.name ? 'error' : null"
					class="required"
				>
					<a-input
						v-model:value="formData.name"
						:placeholder="
							$t('common.placeholder_default_text', [
								$t('payment_settings.stripe_customer_name'),
							])
						"
					/>
				</a-form-item>
			</a-col>
		</a-row>

		<a-row :gutter="16">
			<a-col :xs="24" :sm="24" :md="12" :lg="12">
				<a-form-item
					:label="$t('payment_settings.stripe_customer_line1')"
					name="line1"
					:help="rules.line1 ? rules.line1.message : null"
					:validateStatus="rules.line1 ? 'error' : null"
					class="required"
				>
					<a-input
						v-model:value="formData.line1"
						:placeholder="
							$t('common.placeholder_default_text', [
								$t('payment_settings.stripe_customer_line1'),
							])
						"
					/>
				</a-form-item>
			</a-col>
			<a-col :xs="24" :sm="24" :md="12" :lg="12">
				<a-form-item
					:label="$t('payment_settings.stripe_customer_city')"
					name="city"
					:help="rules.city ? rules.city.message : null"
					:validateStatus="rules.city ? 'error' : null"
					class="required"
				>
					<a-input
						v-model:value="formData.city"
						:placeholder="
							$t('common.placeholder_default_text', [
								$t('payment_settings.stripe_customer_city'),
							])
						"
					/>
				</a-form-item>
			</a-col>
		</a-row>

		<a-row :gutter="16">
			<a-col :xs="24" :sm="24" :md="12" :lg="12">
				<a-form-item
					:label="$t('payment_settings.stripe_customer_state')"
					name="state"
					:help="rules.state ? rules.state.message : null"
					:validateStatus="rules.state ? 'error' : null"
					class="required"
				>
					<a-input
						v-model:value="formData.state"
						:placeholder="
							$t('common.placeholder_default_text', [
								$t('payment_settings.stripe_customer_state'),
							])
						"
					/>
				</a-form-item>
			</a-col>
			<a-col :xs="24" :sm="24" :md="12" :lg="12">
				<a-form-item
					:label="$t('payment_settings.stripe_customer_country')"
					name="country"
					:help="rules.country ? rules.country.message : null"
					:validateStatus="rules.country ? 'error' : null"
					class="required"
				>
					<a-input
						v-model:value="formData.country"
						:placeholder="
							$t('common.placeholder_default_text', [
								$t('payment_settings.stripe_customer_country'),
							])
						"
					/>
				</a-form-item>
			</a-col>
		</a-row>

		<a-row :gutter="16">
			<a-col :xs="24" :sm="24" :md="24" :lg="24">
				<a-form-item
					:label="$t('payment_settings.stripe_card_details')"
					name="card"
					:help="rules.card ? rules.card.message : null"
					:validateStatus="rules.card ? 'error' : null"
					class="required"
				>
					<StripeElements
						v-if="stripeLoaded"
						v-slot="{ elements }"
						ref="elms"
						:stripe-key="stripeKey"
						:instance-options="instanceOptions"
						:elements-options="elementsOptions"
					>
						<StripeElement
							ref="card"
							:elements="elements"
							:options="cardOptions"
							:style="{
								border: '1px solid #cecece',
								padding: '7px 11px',
								borderRadius: '2px',
							}"
						/>
					</StripeElements>
				</a-form-item>
			</a-col>
		</a-row>

		<a-row :gutter="16" class="mt-20">
			<a-col :xs="24" :sm="24" :md="24" :lg="24">
				<a-button type="primary" @click="pay" :loading="loading" block>
					{{ $t("payment_settings.complete_transcation") }}
				</a-button>
			</a-col>
		</a-row>
	</a-form>
</template>

<script>
import { defineComponent, ref, onBeforeMount } from "vue";
import { StripeElements, StripeElement } from "vue-stripe-js";
import { loadStripe } from "@stripe/stripe-js";
import { useI18n } from "vue-i18n";
import { message } from "ant-design-vue";
import { useStore } from "vuex";
import common from "../../../../common/composable/common";

export default {
	props: ["paymentMethod", "subscribePlan", "planType"],
	components: {
		StripeElements,
		StripeElement,
	},
	setup(props, { emit }) {
		const { t } = useI18n();
		const store = useStore();
		const { appSetting } = common();
		const stripeKey = ref(props.paymentMethod.credentials.stripe_api_key);
		const instanceOptions = ref({});
		const elementsOptions = ref({});
		const cardOptions = ref({
			value: {
				postalCode: "",
			},
		});
		const stripeLoaded = ref(false);
		const card = ref(null);
		const elms = ref(null);
		const formData = ref({
			name: "",
			line1: "",
			city: "",
			state: "",
			country: "",
		});
		const rules = ref({});
		const loading = ref(false);
		const errorText = ref("");

		onBeforeMount(() => {
			const stripePromise = loadStripe(stripeKey.value);
			stripePromise.then(() => {
				stripeLoaded.value = true;
			});
		});

		const pay = () => {
			loading.value = true;
			var formError = false;
			rules.value = {};
			errorText.value = "";

			if (formData.value.name == "") {
				rules.value = {
					...rules.value,
					name: {
						message: t("payment_settings.required_message", [
							t("payment_settings.stripe_customer_name"),
						]),
					},
				};

				formError = true;
			}
			if (formData.value.line1 == "") {
				rules.value = {
					...rules.value,
					line1: {
						message: t("payment_settings.required_message", [
							t("payment_settings.stripe_customer_line1"),
						]),
					},
				};

				formError = true;
			}
			if (formData.value.city == "") {
				rules.value = {
					...rules.value,
					city: {
						message: t("payment_settings.required_message", [
							t("payment_settings.stripe_customer_city"),
						]),
					},
				};

				formError = true;
			}
			if (formData.value.state == "") {
				rules.value = {
					...rules.value,
					state: {
						message: t("payment_settings.required_message", [
							t("payment_settings.stripe_customer_state"),
						]),
					},
				};

				formError = true;
			}
			if (formData.value.country == "") {
				rules.value = {
					...rules.value,
					country: {
						message: t("payment_settings.required_message", [
							t("payment_settings.stripe_customer_country"),
						]),
					},
				};

				formError = true;
			}

			// Get stripe element
			const cardElement = card.value.stripeElement;

			// Access instance methods, e.g. createToken()
			elms.value.instance
				.createPaymentMethod("card", cardElement, {
					billing_details: {
						name: formData.value.name,
						address: {
							line1: formData.value.line1,
							city: formData.value.city,
							state: formData.value.state,
							country: formData.value.country,
						},
					},
				})
				.then((result) => {
					// Handle result.error or result.token
					if (result.error) {
						rules.value = {
							...rules.value,
							card: { message: result.error.message },
						};
						loading.value = false;
					}

					if (result.paymentMethod) {
						// Submitting Form with payment token
						axiosAdmin
							.post("stripe-payment", {
								stripe_token: result.paymentMethod.id,
								plan_id: props.subscribePlan.xid,
								email: appSetting.value.email,
								plan_type: props.planType,
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
							});
					}
				});
		};

		return {
			stripeKey,
			stripeLoaded,
			instanceOptions,
			elementsOptions,
			cardOptions,
			card,
			elms,
			pay,

			formData,
			rules,
			loading,
			errorText,
		};
	},
};
</script>

<style></style>
