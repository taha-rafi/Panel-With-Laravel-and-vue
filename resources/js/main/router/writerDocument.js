import Admin from '../../common/layouts/Admin.vue';
import WriterDocument from '../views/writer-document/index.vue';

export default [
    {
        path: '/',
        component: Admin,
        children: [
            {
                path: '/admin/writer-documents',
                component: WriterDocument,
                name: 'admin.writer_documents.index',
                meta: {
                    requireAuth: true,
                    menuParent: "writer_document",
                    menuKey: "writer_documents",
                    permission: "writer_document_view"
                }
            },
        ]

    }
]
