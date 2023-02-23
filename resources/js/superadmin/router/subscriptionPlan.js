import SuperAdmin from '../layouts/SuperAdmin.vue';
import SubscriptionPlanIndex from '../views/subscriptions/subscription-plans/index.vue';
import OfflinePaymentModeIndex from '../views/subscriptions/offline-payment-modes/index.vue';
import PaypalSetting from '../views/subscriptions/payment-settings/Paypal.vue';
import StripeSetting from '../views/subscriptions/payment-settings/Stripe.vue';
import RazorpaySetting from '../views/subscriptions/payment-settings/Razorpay.vue';
import PaystackSetting from '../views/subscriptions/payment-settings/Paystack.vue';
import MollieSetting from '../views/subscriptions/payment-settings/Mollie.vue';
import AuthorizeSetting from '../views/subscriptions/payment-settings/Authorize.vue';

export default [
    {
        path: '/subscriptions',
        component: SuperAdmin,
        children: [
            {
                path: 'plans',
                component: SubscriptionPlanIndex,
                name: 'superadmin.subscriptions.plans.index',
                meta: {
                    requireAuth: true,
                    menuParent: "subscriptions",
                    menuKey: "subscription_plans",
                    permission: 'superadmin'
                }
            },
            {
                path: 'offline-payment-modes',
                component: OfflinePaymentModeIndex,
                name: 'superadmin.subscriptions.offline_payment_modes.index',
                meta: {
                    requireAuth: true,
                    menuParent: "subscriptions",
                    menuKey: "offline_payment_modes",
                    permission: 'superadmin'
                }
            },
            {
                path: 'paypal',
                component: PaypalSetting,
                name: 'superadmin.payment_settings.paypal.index',
                meta: {
                    requireAuth: true,
                    menuParent: "subscriptions",
                    menuKey: route => "paypal",
                    permission: "superadmin"
                }
            },
            {
                path: 'stripe',
                component: StripeSetting,
                name: 'superadmin.payment_settings.stripe.index',
                meta: {
                    requireAuth: true,
                    menuParent: "subscriptions",
                    menuKey: route => "stripe",
                    permission: "superadmin"
                }
            },
            {
                path: 'razorpay',
                component: RazorpaySetting,
                name: 'superadmin.payment_settings.razorpay.index',
                meta: {
                    requireAuth: true,
                    menuParent: "subscriptions",
                    menuKey: route => "razorpay",
                    permission: "superadmin"
                }
            },
            {
                path: 'paystack',
                component: PaystackSetting,
                name: 'superadmin.payment_settings.paystack.index',
                meta: {
                    requireAuth: true,
                    menuParent: "subscriptions",
                    menuKey: route => "paystack",
                    permission: "superadmin"
                }
            },
            {
                path: 'mollie',
                component: MollieSetting,
                name: 'superadmin.payment_settings.mollie.index',
                meta: {
                    requireAuth: true,
                    menuParent: "subscriptions",
                    menuKey: route => "mollie",
                    permission: "superadmin"
                }
            },
            {
                path: 'authorize',
                component: AuthorizeSetting,
                name: 'superadmin.payment_settings.authorize.index',
                meta: {
                    requireAuth: true,
                    menuParent: "subscriptions",
                    menuKey: route => "authorize",
                    permission: "superadmin"
                }
            },
        ]
    }
];
