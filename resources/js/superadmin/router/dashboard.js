import SuperAdmin from '../layouts/SuperAdmin.vue';
import Dashboard from '../views/Dashboard.vue';

export default [
    {
        path: '/',
        component: SuperAdmin,
        children: [
            {
                path: '/superadmin/dashboard',
                component: Dashboard,
                name: 'superadmin.dashboard.index',
                meta: {
                    requireAuth: true,
                    menuParent: "dashboard",
                    menuKey: route => "dashboard",
                    permission: 'superadmin'
                }
            }
        ]

    }
];
