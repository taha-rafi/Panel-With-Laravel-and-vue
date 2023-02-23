import SuperAdmin from '../layouts/SuperAdmin.vue';
import CompanyEdit from '../views/settings/company/Edit.vue';
import ProfileEdit from '../views/settings/profile/Edit.vue';
import Translation from '../views/settings/translations/index.vue';
import Langs from '../views/settings/translations/langs/index.vue';
import Currencies from '../views/settings/currency/index.vue';
import Modules from '../views/settings/modules/index.vue';
import StorageEdit from '../views/settings/storage/Edit.vue';
import EmailEdit from '../views/settings/email/Edit.vue';
import UpdateApp from '../views/settings/update-app/index.vue';
import DatabaseBackup from '../views/settings/database-backup/index.vue';
import WhiteLabelSetting from '../views/settings/white-label/Edit.vue';

export default [
    {
        path: '/superadmin/settings/',
        component: SuperAdmin,
        children: [
            {
                path: 'company',
                component: CompanyEdit,
                name: 'superadmin.settings.company.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "company",
                    permission: "superadmin"
                }
            },
            {
                path: 'profile',
                component: ProfileEdit,
                name: 'superadmin.settings.profile.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "profile",
                    permission: "superadmin"
                }
            },
            {
                path: 'translations',
                component: Translation,
                name: 'superadmin.settings.translations.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "translations",
                    permission: "superadmin"
                }
            },
            {
                path: 'langs',
                component: Langs,
                name: 'superadmin.settings.langs.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "translations",
                    permission: "superadmin"
                }
            },
            {
                path: 'currencies',
                component: Currencies,
                name: 'superadmin.settings.currencies.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "currencies",
                    permission: "superadmin"
                }
            },
            {
                path: 'modules',
                component: Modules,
                name: 'superadmin.settings.modules.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "modules",
                    permission: "superadmin"
                }
            },
            {
                path: 'storage',
                component: StorageEdit,
                name: 'superadmin.settings.storage.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "storage_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'email',
                component: EmailEdit,
                name: 'superadmin.settings.email.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "email_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'white-label',
                component: WhiteLabelSetting,
                name: 'superadmin.settings.white_label.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "white_label",
                    permission: "superadmin"
                }
            },
            {
                path: 'database-backup',
                component: DatabaseBackup,
                name: 'superadmin.settings.database_backup.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "database_backup",
                    permission: "superadmin"
                }
            },
            {
                path: 'update-app',
                component: UpdateApp,
                name: 'superadmin.settings.update_app.index',
                meta: {
                    requireAuth: true,
                    menuParent: "settings",
                    menuKey: route => "update_app",
                    permission: "superadmin"
                }
            },
        ]

    }
];
