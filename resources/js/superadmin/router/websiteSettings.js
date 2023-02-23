import SuperAdmin from '../layouts/SuperAdmin.vue';
import ClientSettings from '../views/website-settings/ClientSettings.vue';
import TestimonialsSettings from '../views/website-settings/TestimonialsSettings.vue';
import FeaturesSettings from '../views/website-settings/FeaturesSettings.vue';
import ContactSettings from '../views/website-settings/ContactSettings.vue';
import PriceSettings from '../views/website-settings/PriceSettings.vue';
import FaqSettings from '../views/website-settings/FaqSettings.vue';
import FooterSettings from '../views/website-settings/FooterSettings.vue';
import HeaderSettings from '../views/website-settings/HeaderSettings.vue';
import SeoSettings from '../views/website-settings/SeoSettings.vue';
import CallToActionSettings from '../views/website-settings/CallToActionSettings.vue';
import RegisterSettings from '../views/website-settings/RegisterSettings.vue';

export default [
    {
        path: '/superadmin/website-settings/',
        component: SuperAdmin,
        children: [
            {
                path: 'header',
                component: HeaderSettings,
                name: 'superadmin.website_settings.header.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_header_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'clients',
                component: ClientSettings,
                name: 'superadmin.website_settings.clients.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_clients_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'testimonials',
                component: TestimonialsSettings,
                name: 'superadmin.website_settings.testimonials.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_testimonials_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'features',
                component: FeaturesSettings,
                name: 'superadmin.website_settings.features.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_features_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'contact',
                component: ContactSettings,
                name: 'superadmin.website_settings.contact.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_contact_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'price',
                component: PriceSettings,
                name: 'superadmin.website_settings.price.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_price_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'faq',
                component: FaqSettings,
                name: 'superadmin.website_settings.faq.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_faq_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'footer',
                component: FooterSettings,
                name: 'superadmin.website_settings.footer.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_footer_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'call-to-action',
                component: CallToActionSettings,
                name: 'superadmin.website_settings.call_to_action.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_call_to_action_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'register',
                component: RegisterSettings,
                name: 'superadmin.website_settings.register.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_register_settings",
                    permission: "superadmin"
                }
            },
            {
                path: 'seo',
                component: SeoSettings,
                name: 'superadmin.website_settings.seo.index',
                meta: {
                    requireAuth: true,
                    menuParent: "website_settings",
                    menuKey: route => "website_seo_settings",
                    permission: "superadmin"
                }
            },
        ]

    }
];
