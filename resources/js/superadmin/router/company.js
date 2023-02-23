import SuperAdmin from '../layouts/SuperAdmin.vue';
import Company from '../views/companies/index.vue';

export default [
    {
        path: '/',
        component: SuperAdmin,
        children: [
            {
                path: '/superadmin/companies',
                component: Company,
                name: 'superadmin.companies.index',
                meta: {
                    requireAuth: true,
                    menuParent: "companies",
                    menuKey: route => "companies",
                    permission: 'superadmin'
                }
            }
        ]

    }
];
