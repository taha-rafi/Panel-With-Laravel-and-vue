import Admin from '../../../common/layouts/Admin.vue';
import SubscriptionPlanDetails from '../../views/admin/SubscriptionPlanDetails.vue';
import Transcations from '../../views/admin/Transcations.vue';
import OfflineRequests from '../../views/admin/offline-requests/OfflineRequests.vue';
import ChangePlan from '../../views/admin/ChangePlan.vue';

export default [
    {
        path: '/',
        component: Admin,
        children: [
            {
                path: '/admin/subscription/current-plan',
                component: SubscriptionPlanDetails,
                name: 'admin.subscription.current_plan',
                meta: {
                    requireAuth: true,
                    menuParent: "current_plan",
                    menuKey: route => "current_plan",
                }
            },
            {
                path: '/admin/subscription/transcations',
                component: Transcations,
                name: 'admin.subscription.transcations',
                meta: {
                    requireAuth: true,
                    menuParent: "transcations",
                    menuKey: route => "transcations",
                }
            },
            {
                path: '/admin/subscription/offline-requests',
                component: OfflineRequests,
                name: 'admin.subscription.offline_requests',
                meta: {
                    requireAuth: true,
                    menuParent: "offline_requests",
                    menuKey: route => "offline_requests",
                }
            },
            {
                path: '/admin/subscription/change-plan',
                component: ChangePlan,
                name: 'admin.subscription.change_plan',
                meta: {
                    requireAuth: true,
                    menuParent: "change_plan",
                    menuKey: route => "change_plan",
                }
            }
        ]

    }
]
