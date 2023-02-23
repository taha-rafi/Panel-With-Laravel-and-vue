import Translation from '../../views/settings/translations/index.vue';
import Modules from '../../views/settings/modules/index.vue';
import StorageEdit from '../../views/settings/storage/Edit.vue';
import EmailEdit from '../../views/settings/email/Edit.vue';
import DatabaseBackup from '../../views/settings/database-backup/index.vue';
import UpdateApp from '../../views/settings/update-app/index.vue';

// Defining route prefix and permission
// According to app_type
const appType = window.config.app_type;
const routePrefix = appType == 'non-saas' ? 'admin' : 'superadmin';

export default [
    {
        path: 'translations',
        component: Translation,
        name: `${routePrefix}.settings.translations.index`,
        meta: {
            requireAuth: true,
            menuParent: "settings",
            menuKey: route => "translations",
            permission: appType == "non-saas" ? "translations_view" : "superadmin"
        }
    },
    {
        path: 'modules',
        component: Modules,
        name: `${routePrefix}.settings.modules.index`,
        meta: {
            requireAuth: true,
            menuParent: "settings",
            menuKey: route => "modules",
            permission: appType == "non-saas" ? "modules_view" : "superadmin"
        }
    },
    {
        path: 'storage',
        component: StorageEdit,
        name: `${routePrefix}.settings.storage.index`,
        meta: {
            requireAuth: true,
            menuParent: "settings",
            menuKey: route => "storage_settings",
            permission: appType == "non-saas" ? "storage_edit" : "superadmin"
        }
    },
    {
        path: 'email',
        component: EmailEdit,
        name: `${routePrefix}.settings.email.index`,
        meta: {
            requireAuth: true,
            menuParent: "settings",
            menuKey: route => "email_settings",
            permission: appType == "non-saas" ? "email_edit" : "superadmin"
        }
    },
    {
        path: 'database-backup',
        component: DatabaseBackup,
        name: 'admin.settings.database_backup.index',
        meta: {
            requireAuth: true,
            menuParent: "settings",
            menuKey: route => "database_backup",
            permission: appType == "non-saas" ? "database_backup" : "superadmin"
        }
    },
    {
        path: 'update-app',
        component: UpdateApp,
        name: `${routePrefix}.settings.update_app.index`,
        meta: {
            requireAuth: true,
            menuParent: "settings",
            menuKey: route => "update_app",
            permission: appType == "non-saas" ? "update_app" : "superadmin"
        }
    }
];
