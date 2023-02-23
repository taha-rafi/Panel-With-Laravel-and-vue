import SuperAdmin from '../layouts/SuperAdmin.vue';
import PaymentTranscation from '../views/payment-transcations/index.vue';
import OfflineRequests from '../views/offline-requests/index.vue';

export default [
    {
        path: '/',
        component: SuperAdmin,
        children: [
            {
                path: '/superadmin/payment-transactions',
                component: PaymentTranscation,
                name: 'superadmin.payment_transactions.index',
                meta: {
                    requireAuth: true,
                    menuParent: "payment_transactions",
                    menuKey: route => "payment_transactions",
                    permission: 'superadmin'
                }
            },
            {
                path: '/superadmin/offline-requests',
                component: OfflineRequests,
                name: 'superadmin.offline_requests.index',
                meta: {
                    requireAuth: true,
                    menuParent: "offline_requests",
                    menuKey: route => "offline_requests",
                    permission: 'superadmin'
                }
            }
        ]

    }
];
