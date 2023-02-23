import Admin from '../../common/layouts/Admin.vue';
import WorkSpace from '../views/work-space/index.vue';

export default [
    {
        path: '/',
        component: Admin,
        children: [
            {
                path: '/admin/work-spaces',
                component: WorkSpace,
                name: 'admin.work_spaces.index',
                meta: {
                    requireAuth: true,
                    menuParent: "work_space",
                    menuKey: "work_spaces",
                    permission: "work_space_view"
                }
            },
        ]

    }
]
