<template>
    <div class="setting-sidebar">
        <perfect-scrollbar
            :options="{
                wheelSpeed: 1,
                swipeEasing: true,
                suppressScrollX: true,
            }"
        >
            <a-menu v-model:selectedKeys="selectedKeys">
                <a-menu-item
                    key="subscription_plans"
                    @click="
                        $router.push({
                            name: 'superadmin.subscriptions.plans.index',
                        })
                    "
                >
                    {{ $t("menu.subscription_plans") }}
                </a-menu-item>

                <a-menu-item
                    key="offline_payment_modes"
                    @click="
                        $router.push({
                            name: 'superadmin.subscriptions.offline_payment_modes.index',
                        })
                    "
                >
                    {{ $t("menu.offline_payment_modes") }}
                </a-menu-item>

                <!-- <a-menu-item
					key="paypal"
					@click="
						$router.push({ name: 'superadmin.payment_settings.paypal.index' })
					"
				>
					{{ $t("menu.paypal") }}
				</a-menu-item> -->
                <a-menu-item
                    key="stripe"
                    @click="
                        $router.push({ name: 'superadmin.payment_settings.stripe.index' })
                    "
                >
                    {{ $t("menu.stripe") }}
                </a-menu-item>
                <!-- <a-menu-item
					key="razorpay"
					@click="
						$router.push({
							name: 'superadmin.payment_settings.razorpay.index',
						})
					"
				>
					{{ $t("menu.razorpay") }}
				</a-menu-item>
				<a-menu-item
					key="paystack"
					@click="
						$router.push({
							name: 'superadmin.payment_settings.paystack.index',
						})
					"
				>
					{{ $t("menu.paystack") }}
				</a-menu-item>
				<a-menu-item
					key="mollie"
					@click="
						$router.push({ name: 'superadmin.payment_settings.mollie.index' })
					"
				>
					{{ $t("menu.mollie") }}
				</a-menu-item>
				<a-menu-item
					key="authorize"
					@click="
						$router.push({
							name: 'superadmin.payment_settings.authorize.index',
						})
					"
				>
					{{ $t("menu.authorize") }}
				</a-menu-item> -->
            </a-menu>
        </perfect-scrollbar>
    </div>
</template>

<script>
import { defineComponent, ref, onMounted, watch } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import common from "../../../common/composable/common";

export default defineComponent({
    setup() {
        const route = useRoute();
        const store = useStore();
        const selectedKeys = ref([]);

        onMounted(() => {
            const menuKey =
                typeof route.meta.menuKey == "function"
                    ? route.meta.menuKey(route)
                    : route.meta.menuKey;

            selectedKeys.value = [menuKey.replace("-", "_")];
        });

        watch(route, (newVal, oldVal) => {
            const menuKey =
                typeof newVal.meta.menuKey == "function"
                    ? newVal.meta.menuKey(newVal)
                    : newVal.meta.menuKey;

            selectedKeys.value = [menuKey.replace("-", "_")];
        });

        return {
            selectedKeys,
        };
    },
});
</script>

<style lang="less">
.setting-sidebar .ps {
    height: calc(100vh - 145px);
}
</style>
