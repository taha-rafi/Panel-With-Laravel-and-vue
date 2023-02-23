import { useI18n } from "vue-i18n";

const fields = () => {
    const url = "superadmin/subscription-plans?fields=id,xid,name,description,monthly_price,annual_price,max_characters,default,features,is_popular,stripe_monthly_plan_id,stripe_annual_plan_id,paystack_monthly_plan_id,paystack_annual_plan_id,razorpay_monthly_plan_id,razorpay_annual_plan_id,notify_before,duration";
    const addEditUrl = "superadmin/subscription-plans";
    const { t } = useI18n();

    const initData = {
        name: "",
        default: "no",
        description: "",
        max_characters: "",
        annual_price: "",
        monthly_price: "",
        paystack_monthly_plan_id: "",
        paystack_annual_plan_id: "",
        stripe_monthly_plan_id: "",
        stripe_annual_plan_id: "",
        razorpay_monthly_plan_id: "",
        razorpay_annual_plan_id: "",
        features: [],
        is_popular: 0,
        duration: undefined,
        notify_before: undefined,
    };

    const columns = [
        {
            title: t("subscription_plans.name"),
            dataIndex: "name",
        },
        {
            title: t("subscription_plans.pricing_details"),
            dataIndex: "pricing_details",
            width: '30%'
        },
        {
            title: t("subscription_plans.max_characters"),
            dataIndex: "max_characters",
        },
        {
            title: t("common.action"),
            dataIndex: "action",
        },
    ];

    const filterableColumns = [
        {
            key: "name",
            value: t("subscription_plans.name")
        },
    ];

    return {
        url,
        addEditUrl,
        initData,
        columns,
        filterableColumns,
    }
}

export default fields;
