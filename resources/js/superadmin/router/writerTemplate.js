import SuperAdmin from '../layouts/SuperAdmin.vue';
import WriterTemplate from '../views/writer-template/index.vue';

export default [
    {
        path: '/',
        component: SuperAdmin,
        children: [
            {
                path: '/superadmin/writer-templates',
                component: WriterTemplate,
                name: 'superadmin.writer_template.index',
                meta: {
                    requireAuth: true,
                    menuParent: "writer_templates",
                    menuKey: "writer_templates",
                    permission: "superadmin"
                }
            },
        ]

    }
]
