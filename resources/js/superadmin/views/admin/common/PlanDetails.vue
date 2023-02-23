<template>
	<a-descriptions size="small" :column="2" v-if="subscribePlan">
		<a-descriptions-item :label="$t('subscription_plans.subscription_plan')">
			{{ subscribePlan.name }}
		</a-descriptions-item>
		<a-descriptions-item :label="$t('payment_transaction.amount')">
			{{
				planType == "monthly"
					? formatAmountUsingCurrencyObject(
							subscribePlan.monthly_price,
							currency
					  )
					: formatAmountUsingCurrencyObject(
							subscribePlan.annual_price,
							currency
					  )
			}}
		</a-descriptions-item>
		<a-descriptions-item :label="$t('subscription_plans.plan_type')">
			{{ $t(`subscription_plans.${planType}`) }}
		</a-descriptions-item>
	</a-descriptions>
</template>

<script>
import common from "../../../../common/composable/common";

export default {
	props: ["subscribePlan", "planType", "currency"],
	setup(props, { emit }) {
		const { formatAmountUsingCurrencyObject } = common();
		return {
			formatAmountUsingCurrencyObject,
		};
	},
};
</script>
