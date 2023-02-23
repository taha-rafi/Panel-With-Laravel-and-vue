import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

const fields = (settingType) => {
    const { t } = useI18n();

    const details = computed(() => {
        if (settingType == 'website_clients') {
            return {
                columns: [
                    {
                        title: t("common.name"),
                        dataIndex: "name",
                    },
                    {
                        title: t("common.logo"),
                        dataIndex: "logo",
                    },
                    {
                        title: t("common.action"),
                        dataIndex: "action",
                    },
                ],
                lang_type: 'client',
                setting_type: settingType,
                init_data: {
                    id: Math.random().toString(36).slice(2),
                    name: "",
                    logo: null,
                    logo_url: "",
                }
            };
        } else if (settingType == 'pricing_cards') {
            return {
                columns: [
                    {
                        title: t("common.name"),
                        dataIndex: "name",
                    },
                    {
                        title: t("common.logo"),
                        dataIndex: "logo",
                    },
                    {
                        title: t("common.action"),
                        dataIndex: "action",
                    },
                ],
                lang_type: 'pricing_card',
                setting_type: settingType,
                init_data: {
                    id: Math.random().toString(36).slice(2),
                    name: "",
                    logo: null,
                    logo_url: "",
                }
            };
        } else if (settingType == 'header_features') {
            return {
                columns: [
                    {
                        title: t("common.name"),
                        dataIndex: "name",
                    },
                    {
                        title: t("common.description"),
                        dataIndex: "description",
                    },
                    {
                        title: t("common.image"),
                        dataIndex: "image",
                    },
                    {
                        title: t("common.action"),
                        dataIndex: "action",
                    },
                ],
                lang_type: 'feature',
                setting_type: settingType,
                init_data: {
                    id: Math.random().toString(36).slice(2),
                    name: "",
                    description: "",
                    image: null,
                    image_url: "",
                }
            };
        } else if (settingType == 'features_page') {
            return {
                columns: [
                    {
                        title: t("common.title"),
                        dataIndex: "title",
                    },
                    {
                        title: t("common.description"),
                        dataIndex: "description",
                    },
                    {
                        title: t("common.action"),
                        dataIndex: "action",
                    },
                ],
                lang_type: 'feature',
                setting_type: settingType,
                init_data: {
                    id: Math.random().toString(36).slice(2),
                    title: "",
                    description: "",
                    features: []
                }
            };
        } else if (settingType == 'website_testimonials') {
            return {
                columns: [
                    {
                        title: t("common.name"),
                        dataIndex: "name",
                    },
                    {
                        title: t("common.image"),
                        dataIndex: "image",
                    },
                    {
                        title: t("common.comment"),
                        dataIndex: "comment",
                    },
                    {
                        title: t("common.rating"),
                        dataIndex: "rating",
                    },
                    {
                        title: t("common.action"),
                        dataIndex: "action",
                    },
                ],
                lang_type: 'testimonial',
                setting_type: settingType,
                init_data: {
                    id: Math.random().toString(36).slice(2),
                    name: "",
                    image: null,
                    image_url: "",
                    comment: "",
                    rating: 1,
                }
            };
        } else if (settingType == 'website_features') {
            return {
                columns: [
                    {
                        title: t("common.title"),
                        dataIndex: "title",
                    },
                    {
                        title: t("common.description"),
                        dataIndex: "description",
                    },
                    {
                        title: t("common.image"),
                        dataIndex: "image",
                    },
                    {
                        title: t("common.action"),
                        dataIndex: "action",
                    },
                ],
                lang_type: 'feature',
                setting_type: settingType,
                init_data: {
                    id: Math.random().toString(36).slice(2),
                    title: "",
                    description: "",
                    image: null,
                    image_url: "",
                    features: [],
                }
            };
        } else if (settingType == 'website_faqs') {
            return {
                columns: [
                    {
                        title: t("common.question"),
                        dataIndex: "question",
                    },
                    {
                        title: t("common.answer"),
                        dataIndex: "answer",
                    },
                    {
                        title: t("common.action"),
                        dataIndex: "action",
                    },
                ],
                lang_type: 'faq',
                setting_type: settingType,
                init_data: {
                    id: Math.random().toString(36).slice(2),
                    question: "",
                    answer: "",
                }
            };
        } else if (settingType == 'footer_pages') {
            return {
                columns: [
                    {
                        title: t("common.title"),
                        dataIndex: "title",
                    },
                    {
                        title: t("common.slug"),
                        dataIndex: "slug",
                    },
                    {
                        title: t("common.action"),
                        dataIndex: "action",
                    },
                ],
                lang_type: 'footer_page',
                setting_type: settingType,
                init_data: {
                    id: Math.random().toString(36).slice(2),
                    title: "",
                    slug: "",
                    page_content: "",
                    seo_keywords: "",
                    seo_description: "",
                }
            };
        } else if (settingType == 'website_seo') {
            return {
                columns: [
                    {
                        title: t("website_settings.page_key"),
                        dataIndex: "page_key",
                    },
                    {
                        title: t("website_settings.seo_title"),
                        dataIndex: "seo_title",
                    },
                    {
                        title: t("website_settings.seo_author"),
                        dataIndex: "seo_author",
                    },
                    {
                        title: t("website_settings.seo_keywords"),
                        dataIndex: "seo_keywords",
                    },
                    {
                        title: t("website_settings.seo_description"),
                        dataIndex: "seo_description",
                    },
                    {
                        title: t("common.action"),
                        dataIndex: "action",
                    },
                ],
                lang_type: 'seo',
                setting_type: settingType,
                init_data: {
                    id: Math.random().toString(36).slice(2),
                    page_key: "",
                    seo_title: "",
                    seo_author: "",
                    seo_keywords: "",
                    seo_description: "",
                    seo_image: null,
                    seo_image_url: "",
                }
            };
        }
    });

    return {
        details,
    }
}

export default fields;
