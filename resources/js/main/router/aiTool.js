import Admin from '../../common/layouts/Admin.vue';
import AiTools from '../views/ai-tools/index.vue';
import Writer from '../views/ai-tools/writer/index.vue';

export default [
    {
        path: '/',
        component: Admin,
        children: [
            {
                path: '/admin/ai-tools/:cat',
                component: AiTools,
                name: 'admin.ai_tools.index',
                meta: {
                    requireAuth: true,
                    menuParent: "ai_tools",
                    menuKey: "ai_tools",
                }
            },
            {
                path: '/admin/writer/:category/:id',
                component: Writer,
                name: 'admin.writer.index',
                meta: {
                    requireAuth: true,
                    menuParent: "writer",
                    menuKey: "writer",
                }
            },
        ]

    }
]
