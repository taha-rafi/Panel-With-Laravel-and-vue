import Admin from '../../common/layouts/Admin.vue';
import WriterForm from '../views/writer-form/index.vue';

export default [
    {
        path: '/',
        component: Admin,
        children: [
            {
                path: '/admin/writer-form',
                component: WriterForm,
                name: 'admin.writer_form.index',
                meta: {
                    requireAuth: true,
                    menuParent: "writer_form",
                    menuKey: "writer_forms",
                    permission: "writer_form_view"
                }
            },
        ]

    }
]
