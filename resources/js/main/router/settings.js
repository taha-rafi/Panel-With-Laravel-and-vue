import Admin from '../../common/layouts/Admin.vue';
import CompanyEdit from '../views/settings/company/Edit.vue';
import ProfileEdit from '../views/settings/profile/Edit.vue';

export default [
    {
        path: '/admin/settings/',
        component: Admin,
        children: [
            {
                path: 'company',
                component: CompanyEdit,
                name: 'admin.settings.company.index',
                meta: {
                    requireAuth: true,
                    menuParent: "company",
                    menuKey: route => "company",
                }
            },
            {
                path: 'profile',
                component: ProfileEdit,
                name: 'admin.settings.profile.index',
                meta: {
                    requireAuth: true,
                    menuParent: "profile",
                    menuKey: route => "profile",
                }
            },
        ]

    }
]
