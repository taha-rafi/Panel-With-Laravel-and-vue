import dashboard from "./dashboard";
import settings from "./settings";
import company from "./company";
import paymentTranscation from "./paymentTranscation";
import users from "./users";
import subscriptionPlan from "./subscriptionPlan";
import websiteSettings from "./websiteSettings";
import SetupAppSuperadmin from "./setupApp";
import WriterTemplateRoutes from './writerTemplate';
import WriterCategoryRoutes from './writerCategory';

export default [
    ...dashboard,
    ...settings,
    ...company,
    ...paymentTranscation,
    ...users,
    ...subscriptionPlan,
    ...websiteSettings,
    ...WriterTemplateRoutes,
    ...WriterCategoryRoutes,
    ...SetupAppSuperadmin,
];
