import SuperAdmin from '../layouts/SuperAdmin.vue';
import WriterCategory from '../views/writer-category/index.vue';

export default [
    {
        path: '/',
        component: SuperAdmin,
        children: [
            {
                path: '/superadmin/writer-category',
                component: WriterCategory,
                name: 'superadmin.writer_category.index',
                meta: {
                    requireAuth: true,
                    menuParent: "writer_category",
                    menuKey: "writer_categories",
                    permission: "superadmin"
                }
            },
        ]

    }
]
