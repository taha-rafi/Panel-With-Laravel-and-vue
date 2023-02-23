import SuperAdmin from '../layouts/SuperAdmin.vue';
import UserIndex from '../views/superadmins/index.vue';

export default [
    {
        path: '/',
        component: SuperAdmin,
        children: [
            {
                path: '/superadmin/users',
                component: UserIndex,
                name: 'superadmin.users.index',
                meta: {
                    requireAuth: true,
                    menuParent: "users",
                    menuKey: "users",
                    permission: 'superadmin'
                }
            },
        ]

    }
]
