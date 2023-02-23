<?php

namespace App\SuperAdmin\Classes;

use App\Classes\Common;
use App\Models\Lang;
use App\SuperAdmin\Models\GlobalSettings;
use App\SuperAdmin\Models\GlobalCompany;
use App\Models\SuperAdmin;
use App\Scopes\CompanyScope;

class SuperAdminCommon
{
    public static function createWebsiteSetting($langKey)
    {
        $globalCompany = GlobalCompany::first();

        // Landing Website
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'website_settings';
        $websiteSetting->name = 'Website Settings';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials = [
            'lang_key' => $langKey,
            'app_name' => 'Writerifly SAAS',
            'header_logo' => 'website_onrfwiwasmjtqiezpe0v.png',
            'header_logo_url' => 'https://writerifly.s3.ap-south-1.amazonaws.com/dark.png',
            'header_sidebar_logo' => 'website_r4ykpmmpmm3jw6bcyfdl.png',
            'header_sidebar_logo_url' => 'https://writerifly.s3.ap-south-1.amazonaws.com/light.png',
            'home_text' => 'Home',
            'features_text' => 'Features',
            'pricing_text' => 'Pricing',
            'contact_text' => 'Contact',
            'register_text' => 'Register',
            'login_button_show' => '1',
            'login_button_text' => 'Login',
            'register_button_show' => '1',
            'register_button_text' => 'Register',

            'header_title' => 'AI Writing Assistant & Content Generator',
            'header_sub_title' => 'Manage Your Business Content in Easy Way',
            'header_description' => 'Best-rated  AI based content writer assistant',
            'header_button1_show' => '1',
            'header_button1_text' => 'Start Free Trail',
            'header_button1_url' => 'https://writerifly.codeifly.in/register',
            'header_button2_show' => '1',
            'header_button2_text' => 'Explore All Features',
            'header_button2_url' => 'https://writerifly.codeifly.in/features',
            'header_features' => [
                'No hidden fees',
                'Start with a free account',
                'More than 100 Ai Tools',
                'Multiple Language Support',
                'Safe and Secure',
            ],
            'header_background_image' => 'website_zipwpvtlldca7ndfqsdq.png',
            'header_background_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_zipwpvtlldca7ndfqsdq.png',
            'header_client_show' => '0',
            'header_client_image' => 'website_sufx8t6co8v93vg91qte.png',
            'header_client_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_sufx8t6co8v93vg91qte.png',
            'header_client_name' => 'Denny Jones, founder of Growthio',
            'header_client_text' => '“You made it so simple. My new team is so much faster and easier to work with than my old site. I just choose the page, make the change.”',

            'contact_details' => 'Contact Details',
            'contact_title' => 'Get connected',
            'contact_description' => 'Lorem ipsum dolor sit amet, to the con adipiscing. Volutpat tempor to the condimentum vitae vel purus.',
            'contact_email_text' => 'Send Email',
            'contact_phone_text' => 'Call Us',
            'contact_address_text' => 'Address',
            'contact_email' => 'contact@writerifly.com',
            'contact_phone' => '123456789',
            'contact_address' => '1 Stree City State Country TN, 38401',
            'contact_form_title' => 'Get connected',
            'contact_form_description' => 'Contact Us',
            'contact_form_heading' => 'Send us a message to know more about us or just chit-chat.',
            'contact_form_name_text' => 'Name',
            'contact_form_email_text' => 'Email',
            'contact_form_message_text' => 'Message',
            'contact_form_send_message_text' => 'Send Message',
            'contact_form_background_image' => 'website_ec4jf6ab7xzgzzyibecf.jpeg',
            'contact_form_background_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_ec4jf6ab7xzgzzyibecf.jpeg',
            'contact_us_submit_message_text' => 'Thanks for contacting us. We will catch you soon.',

            'register_title' => 'Join Writerifly for free',
            'register_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Malesuada tellus vestibulum, commodo pulvinar.',
            'register_background' => 'website_lxk43slp6weuq9jalse3.svg',
            'register_background_url' => 'https://writerifly.codeifly.in/uploads/website/website_lxk43slp6weuq9jalse3.svg',
            'register_company_name_text' => 'Company Name',
            'register_email_text' => 'Email',
            'register_password_text' => 'Password',
            'register_confirm_password_text' => 'Confirm Passwrod',
            'register_submit_button_text' => 'SIGN UP FOR Free',
            'register_agree_text' => 'I agree to the Terms & Conditions of Writerifly',
            'register_agree_url' => 'I agree to the Terms & Conditions of Writerifly',
            'error_contact_support' => 'Some error occurred when inserting the data. Please try again or contact support',
            'register_success_text' => 'Thank you for registration. Please login to get started',

            'call_to_action_title' => 'Connect With Smart AI Tools',
            'call_to_action_description' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.',
            'call_to_action_widgets' => [
                [
                    'title' => 'Successful Docmument Generated',
                    'value' => '19087835+',
                ],
                [
                    'title' => 'AI Toolss',
                    'value' => '100+',
                ],
                [
                    'title' => 'Success Rate',
                    'value' => '98.99%',
                ],
            ],
            'call_to_action_no_email_sell_text' => 'We don’t share or sell your email address publicly',
            'call_to_action_email_text' => 'Enter email to get started',
            'call_to_action_submit_button_text' => 'Join Now',

            'feature_title' => 'Features which will increase your business growth and increase your business profit...',
            'feature_description' => 'Great & Powerful Features',
            'home_feature_points' => [
                'Blog Posts',
                'Social Media Posts',
                'Product Descriptions',
                'Email Marketing',
                'SEO Content',
                'Academic Writing',
                'News Articles',
                'Ad Copy',
                'Technical writing',
                'Personalized content',
                'Business Proposals',
                'Legal Writing',
                'Academic Research',
                'Personal Journaling',
            ],

            'price_title' => 'Choose a Plan',
            'price_description' => 'Manage your projects and your talent in a single system, resulting in empowered teams.',
            'price_card_title' => 'Trusted by secure payment service',
            'pricing_free_text' => 'Free',
            'pricing_no_card_text' => 'No credit card required',
            'pricing_billed_monthly_text' => 'Billed Monthly',
            'pricing_billed_yearly_text' => 'Billed Yearly',
            'pricing_monthly_text' => 'Monthly',
            'pricing_yearly_text' => 'Yearly',
            'pricing_month_text' => 'month',
            'pricing_year_text' => 'year',
            'pricing_get_started_button_text' => 'Get Started Now',
            'most_popular_image' => 'website_qs4fchjftnhb1t48d76h.png',
            'most_popular_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_qs4fchjftnhb1t48d76h.png',

            'testimonial_title' => 'Loved by Meat Processors and Butcher shops across America',
            'testimonial_description' => '',

            'favourite_apps_title' => '',
            'favourite_apps_description' => '',

            'faq_sub_title' => 'HAVE ANY QUESTIONS?',
            'faq_title' => 'Frequently Asked Questions',
            'faq_still_have_question_text' => 'Still have any questions?',
            'faq_contact_us_text' => 'Contact Us',
            'faq_background_image' => 'website_5nkfhn2vdwz1eodlo06h.svg',
            'faq_background_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_5nkfhn2vdwz1eodlo06h.svg',

            'client_title' => 'Trusted by Companies around the World',
            'client_description' => 'Vetted by leaders within the Meat Processing Industry.',

            'footer_description' => "Don't hesitate, Our experts will show you how our application can streamline the way your team works.",
            'footer_copyright_text' => 'Copyright 2023 @ Writerifly, All rights reserved',
            'footer_logo' => 'website_jazw9qtjklv4ohh7q9fd.png',
            'footer_logo_url' => 'https://writerifly.s3.ap-south-1.amazonaws.com/dark.png',
            'footer_links_text' => 'Links',
            'footer_pages_text' => 'Pages',
            'footer_contact_us_text' => 'Contact Us',
            'facebook_url' => '#',
            'twitter_url' => '#',
            'linkedin_url' => '#',
            'instagram_url' => '#',
            'youtube_url' => '#',
        ];
        $websiteSetting->save();

        // Landing Website Clients
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'website_clients';
        $websiteSetting->name = 'Website Clients Settings';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials = [
            0 => [
                'id' => '1hexby4e6ap',
                'name' => 'Client 1',
                'logo' => 'website_mq0fszzkwxd1teegothn.png',
                'logo_url' => 'https://writerifly.codeifly.in/uploads/website/website_mq0fszzkwxd1teegothn.png',
            ],
            1 => [
                'id' => '2hexby4e6ap',
                'name' => 'Client 2',
                'logo' => 'website_suaovrxkc5ekx8cxp9tc.png',
                'logo_url' => 'https://writerifly.codeifly.in/uploads/website/website_suaovrxkc5ekx8cxp9tc.png',
            ],
            2 => [
                'id' => '3hexby4e6ap',
                'name' => 'Client 3',
                'logo' => 'website_3z6oeclyrvbwyjy8gtnw.png',
                'logo_url' => 'https://writerifly.codeifly.in/uploads/website/website_3z6oeclyrvbwyjy8gtnw.png',
            ],
            3 => [
                'id' => '4hexby4e6ap',
                'name' => 'Client 4',
                'logo' => 'website_mh67eezo79ieaanholbn.png',
                'logo_url' => 'https://writerifly.codeifly.in/uploads/website/website_mh67eezo79ieaanholbn.png',
            ],
            4 => [
                'id' => '5hexby4e6ap',
                'name' => 'Client 5',
                'logo' => 'website_qumspxlcun6vbfij33sa.png',
                'logo_url' => 'https://writerifly.codeifly.in/uploads/website/website_qumspxlcun6vbfij33sa.png',
            ],
        ];
        $websiteSetting->save();

        // Header Features
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'header_features';
        $websiteSetting->name = 'Header Features';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials = [
            0 => [
                'id' => '21hexby4e6ap',
                'name' => 'Blog Posts',
                'description' => 'All Content Posts',
                'image' => 'website_avgx8cv6pqg437khfuz4.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_avgx8cv6pqg437khfuz4.png',
            ],
            1 => [
                'id' => '22hexby4e6ap',
                'name' => 'Social Media',
                'description' => 'Facebook, Instagram...',
                'image' => 'website_j4ngf9c2xpgvkeulgffk.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_j4ngf9c2xpgvkeulgffk.png',
            ],
            2 => [
                'id' => '23hexby4e6ap',
                'name' => 'Product Descriptions',
                'description' => 'Describe Your Product',
                'image' => 'website_urqs9f2dzs7m2osmaepk.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_urqs9f2dzs7m2osmaepk.png',
            ],
            3 => [
                'id' => '24hexby4e6ap',
                'name' => 'Email Marketing',
                'description' => 'Mail Releated Tools',
                'image' => 'website_ugurlnst4bl7drytyija.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_ugurlnst4bl7drytyija.png',
            ],
            4 => [
                'id' => '25hexby4e6ap',
                'name' => 'SEO Content',
                'description' => 'SEO Keywords, Tags...',
                'image' => 'website_1dqmh4iwhquu7nlbqrcm.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_1dqmh4iwhquu7nlbqrcm.png',
            ],
            5 => [
                'id' => '26hexby4e6ap',
                'name' => 'Academic Writing',
                'description' => 'Learning Releated...',
                'image' => 'website_17g75syjqsx0s3iyivnb.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_17g75syjqsx0s3iyivnb.png',
            ],
            6 => [
                'id' => '27hexby4e6ap',
                'name' => 'News Articles',
                'description' => 'News Blog Post',
                'image' => 'website_vwsecwwt36busnrjub9j.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_vwsecwwt36busnrjub9j.png',
            ],
            7 => [
                'id' => '28hexby4e6ap',
                'name' => 'Ad Copy',
                'description' => 'Google, Facebooks Ads',
                'image' => 'website_n9oky8zfxhqbimpidqd3.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_n9oky8zfxhqbimpidqd3.png',
            ],
        ];
        $websiteSetting->save();

        // Features Page
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'features_page';
        $websiteSetting->name = 'Features Page';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials =  [
            [
                "id" => "pu6o43vpo9",
                "title" => "Content Writing",
                "description" => "Write AI generated content for your business",
                "features" => [
                    [
                        "id" => "b5e58xp1h6m",
                        "title" => "Blog posts",
                        "description" => "AI writing script could help generate high-quality content for your blog, including article summaries, introductions, and even full blog posts.",
                        "image" => "website_8xy2xlb6cdkydil0ijby.png",
                        "image_url" => "https://writerifly.codeifly.in/uploads/website/website_8xy2xlb6cdkydil0ijby.png"
                    ],
                    [
                        "id" => "omlc24r338",
                        "title" => "SEO content",
                        "description" => "AI writing script could help create SEO-optimized content that ranks well in search engines and drives traffic to your website",
                        "image" => "website_2qjtbtr4vintlcvpe1rc.png",
                        "image_url" => "https://writerifly.codeifly.in/uploads/website/website_2qjtbtr4vintlcvpe1rc.png"
                    ],
                    [
                        "id" => "musykhbq37",
                        "title" => "Blog Titles",
                        "description" => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is tha",
                        "image" => "website_vwqdgo6vxztvwvrvlriv.png",
                        "image_url" => "https://writerifly.codeifly.in/uploads/website/website_vwqdgo6vxztvwvrvlriv.png"
                    ]
                ]
            ],
            [
                "id" => "uz2fpijzmk",
                "title" => "Email marketing",
                "description" => "Use predeined AI tools for your email marketing",
                "features" => [
                    [
                        "id" => "gki0xl9xwl",
                        "title" => "Business Emails",
                        "description" => "AI writing script could be used to generate email marketing campaigns, including subject lines and body text, that are tailored to your audience and help increase engagement rates",
                        "image" => "website_yu3rnjix97wklbepdrm6.png",
                        "image_url" => "https://writerifly.codeifly.in/uploads/website/website_yu3rnjix97wklbepdrm6.png"
                    ],
                    [
                        "id" => "8y1suzijyb",
                        "title" => "Email Campaigns",
                        "description" => "AI-powered writing tools can help automate the creation of email campaigns, making it easier and more efficient to create and send personalized emails to a large number of recipients",
                        "image" => "website_cikf1eod4ivfrtdhfn8c.png",
                        "image_url" => "https://writerifly.codeifly.in/uploads/website/website_cikf1eod4ivfrtdhfn8c.png"
                    ],
                    [
                        "id" => "bsfitmrezvu",
                        "title" => "Subject lines",
                        "description" => "The subject line is one of the most important elements of an email, as it can determine whether the recipient will open the email or not.",
                        "image" => "website_gxg4zutvxgchahaouglh.png",
                        "image_url" => "https://writerifly.codeifly.in/uploads/website/website_gxg4zutvxgchahaouglh.png"
                    ]
                ]
            ],
            [
                "id" => "u5kx5li1zwk",
                "title" => "Academic research",
                "description" => "Manage your academic business using AI tools",
                "features" => [
                    [
                        "id" => "app8vxzlk3",
                        "title" => "Propsal Generation",
                        "description" => "Your AI writing script could assist in generating academic research, by providing summaries of existing research, creating outlines, and even generating sections of content.",
                        "image" => "website_gljrbfynp8brcttsvfss.png",
                        "image_url" => "https://writerifly.codeifly.in/uploads/website/website_gljrbfynp8brcttsvfss.png"
                    ],
                    [
                        "id" => "gkmyw3ppqxv",
                        "title" => "Academic Topics",
                        "description" => "Your AI writing script could assist in generating academic research, by providing summaries of existing research, creating outlines, and even generating sections of content.",
                        "image" => "website_ccoydjvfyhd49mm8y3oj.png",
                        "image_url" => "https://writerifly.codeifly.in/uploads/website/website_ccoydjvfyhd49mm8y3oj.png"
                    ],
                    [
                        "id" => "91hq9yjf38",
                        "title" => "Study Materials",
                        "description" => "Your AI writing script could assist in generating academic research, by providing summaries of existing research, creating outlines, and even generating sections of content.",
                        "image" => "website_aevljhvafub6bzxsoknh.png",
                        "image_url" => "https://writerifly.codeifly.in/uploads/website/website_aevljhvafub6bzxsoknh.png"
                    ]
                ]
            ]
        ];
        $websiteSetting->save();

        // Landing Website Testimonials
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'website_testimonials';
        $websiteSetting->name = 'Website Testimonials Settings';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials = array(
            0 =>
            array(
                'id' => 'jbcfuvor1ef',
                'name' => 'Mitch',
                'image' => 'website_jauklsmhvwyiaa1qeeoz.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_jauklsmhvwyiaa1qeeoz.png',
                'comment' => "I've been using this AI writing tool for a few months now, and I have to say I am impressed. Its saved me so much time and effort in generating content for my blog and social media posts.",
                'rating' => 5,
            ),
            1 =>
            array(
                'id' => '8i20kbnxkrh',
                'name' => 'Aaron',
                'image' => 'website_i3hkcn8tgde8xziv1xrl.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_i3hkcn8tgde8xziv1xrl.png',
                'comment' => "As a busy marketer, I'm always looking for ways to streamline my content creation process. This AI writing tool has been a game-changer for me",
                'rating' => 5,
            ),
            2 =>
            array(
                'id' => 'y8h9ukt9fxm',
                'name' => 'William',
                'image' => 'website_b3fow9iqzna1hhnimfsm.png',
                'image_url' => 'https://writerifly.codeifly.in/uploads/website/website_b3fow9iqzna1hhnimfsm.png',
                'comment' => "I was skeptical about using an AI writing tool at first, but after giving this one a try, I'm a convert. The tool generates unique and engaging content that saves me time and hassle.",
                'rating' => 5,
            ),
        );
        $websiteSetting->save();

        // Landing Website Features
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'website_features';
        $websiteSetting->name = 'Website Features Settings';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials = [
            [
                "id" => "8jzmhcpnshn",
                "title" => "Generate Content For Your Business Or Client In One Click",
                "description" => "Generate content for your business or clients based on predefined AI tools",
                "image" => "website_x3hgl4cmlhtbg4mt7hoa.webp",
                "image_url" => "https://writerifly.codeifly.in/uploads/website/website_x3hgl4cmlhtbg4mt7hoa.webp",
                "features" => [
                    "Generate Using Predefined Templates",
                    "Store Them in Documents",
                    "Edit Content Using TextEditor",
                    "Workspace Based Documents"
                ]
            ],
            [
                "id" => "k8u7cwrwnt",
                "title" => "More Than 100 AI Tools",
                "description" => "You can use more than 100 AI tools for generating conetent",
                "image" => "website_5wxl7jknpxftyplpdxzv.webp",
                "image_url" => "https://writerifly.codeifly.in/uploads/website/website_5wxl7jknpxftyplpdxzv.webp",
                "features" => [
                    "Blog Post Related AI Tools",
                    "SEO Related AI Tools",
                    "Social Media Releated AI Tools",
                    "Email Releated Tools"
                ]
            ]
        ];
        $websiteSetting->save();

        // Landing Website FAQ
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'website_faqs';
        $websiteSetting->name = 'Website Faq Settings';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials = [
            [
                "id" => "ly41sgvy9hh",
                "question" => "Why do I need your software solutions?",
                "answer" => "We love this question because it does two things: it allows you to tell people why they can benefit from SaaS, and it allows you to sell your services specifically. Notice that we don’t ask “if” people need SaaS,"
            ],
            [
                "id" => "uxt7phaojq",
                "question" => "How can I check compatibility?",
                "answer" => "Here’s a common logistics and tech issue: compatibility. People want to make sure that your software solutions are compatible with the tools that they already use. Some might be investing in a new tool and want to make sure it works with their existing SaaS solutions from you."
            ],
            [
                "id" => "1z7cdfd25vz",
                "question" => "What is Software-as-a-Service (SaaS)?",
                "answer" => "This is always number one. So many people don’t understand SaaS or what it means to their business. Others just aren’t sure how it differs from a typical software product or company. There’s a lot to cover here, but even addressing the question shows your audience that you are ready to do so and be transparent about what you offer."
            ]
        ];
        $websiteSetting->save();

        // Landing Website Pricing Cards
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'pricing_cards';
        $websiteSetting->name = 'Pricing Cards';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials =   [
            [
                "id" => "1nv8m1ua7w4",
                "name" => "itune",
                "logo" => "website_gnwpi4gxi0eaexrbgkpx.svg",
                "logo_url" => "https://writerifly.codeifly.in/uploads/website/website_gnwpi4gxi0eaexrbgkpx.svg"
            ],
            [
                "id" => "bhxt4mzpgsq",
                "name" => "amex",
                "logo" => "website_b6hz84ts8fbc2fon4aym.svg",
                "logo_url" => "https://writerifly.codeifly.in/uploads/website/website_b6hz84ts8fbc2fon4aym.svg"
            ],
            [
                "id" => "ugxjxtffre",
                "name" => "Visa",
                "logo" => "website_rkdvbohqucirllo5tagr.svg",
                "logo_url" => "https://writerifly.codeifly.in/uploads/website/website_rkdvbohqucirllo5tagr.svg"
            ],
            [
                "id" => "aogu39r25jr",
                "name" => "Stripe",
                "logo" => "website_lpxskoghurfms1phperc.svg",
                "logo_url" => "https://writerifly.codeifly.in/uploads/website/website_lpxskoghurfms1phperc.svg"
            ],
            [
                "id" => "hojcguj4k9j",
                "name" => "MasterCard",
                "logo" => "website_3kofwfmmbe1dlodxyccj.svg",
                "logo_url" => "https://writerifly.codeifly.in/uploads/website/website_3kofwfmmbe1dlodxyccj.svg"
            ]
        ];


        $websiteSetting->save();


        $privacyHtml = '<div class="flex justify-center mb-20">
            <h1 class="text-qblack font-semibold text-3xl">Privacy Policy</h1>
         </div>
         <div class="mb-10 content-item w-full">
            <h2 class="text-qblack font-medium mb-5 text-[18px]">1. What Are Terms and Conditions?</h2>
            <p class="leading-7 text-[15px] text-qgraytwo">When you use our AI Writer script, we may collect information such as your name, email address, and payment information. We may also collect information about how you use our script, including your IP address, browser type, and device type. When you use our AI Writer script, we may collect information such as your name, email address, and payment information. We may also collect information about how you use our script, including your IP address, browser type, and device type. </p>
         </div>
         <hr />
         <h2 class="text-qblack font-medium mb-5 text-[18px] mt-10">2. Disclosure of your information:</h2>
         <p class="leading-7 text-[15px] text-qgraytwo mb-10">We may share your information with third-party service providers who assist us in providing our services, or as required by law. We do not sell, rent, or otherwise share your personal information with third parties for their own marketing purposes. You have the right to access, correct, or delete your personal information. You may also object to the processing of your personal information or request that we restrict the processing of your personal information. If you have any questions or concerns about your personal information, please contact us. </p>
         <hr />
         <div>
            <h2 class="text-qblack font-medium mb-5 text-[18px] mt-10">3. Changes to this policy:</h2>
            <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. We will notify you of any material changes to this Privacy Policy by posting the revised policy on our website. </p>
            <ul class="mt-5 list-disc ml-5">
               <li class="leading-7 text-[15px] text-qgraytwo">Information we collect</li>
               <li class="leading-7 text-[15px] text-qgraytwo">How we use your information</li>
               <li class="leading-7 text-[15px] text-qgraytwo">Your rights</li>
               <li class="leading-7 text-[15px] text-qgraytwo">Changes to this policy</li>
            </ul>
            <p class=mt-5>Thank you for trusting us with your personal information. If you have any questions or concerns about our Privacy Policy, please do not hesitate to contact us.</p>
         </div>';

        $aboutUsHtml = '<div class="flex justify-center mb-20">
            <h1 class="text-qblack font-semibold text-3xl">Welcome to our AI Writer script!</h1>
         </div>
         <div class="mb-10 content-item w-full">
            <p class="leading-7 text-[15px] text-qgraytwo">
            Our script was created with the goal of making content creation faster, easier, and more accessible for everyone. We believe that everyone has something valuable to share with the world, and our AI Writer script is here to help you do just that.
            Our script uses state-of-the-art artificial intelligence algorithms to generate high-quality content quickly and accurately. Whether you need blog posts, articles, product descriptions, or any other type of content, our AI Writer script can help you create it.
            </p>
         </div>
         <hr />
         <div>
         <h2 class="text-qblack font-medium mb-5 text-[18px] mt-10">What we are providing:</h2>
         <p class="leading-7 text-[15px] text-qgraytwo">We may share your information with third-party service providers who assist us in providing our services, or as required by law. We do not sell, rent, or otherwise share your personal information with third parties for their own marketing purposes. You have the right to access, correct, or delete your personal information. You may also object to the processing of your personal information or request that we restrict the processing of your personal information. If you have any questions or concerns about your personal information, please contact us. </p>
            <ul class="mt-5 list-disc ml-5">
                <li class="leading-7 text-[15px] text-qgraytwo">AI writing tool</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Natural language processing</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Machine learning</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Content generation</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Dynamic templates</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Blogging</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Social media marketing</li>
                <li class="leading-7 text-[15px] text-qgraytwo">SEO optimization</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Email marketing</li>
                <li class="leading-7 text-[15px] text-qgraytwo">News articlesg</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Chatbots</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Technical writing</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Content curation</li>
                <li class="leading-7 text-[15px] text-qgraytwo">Legal writing</li>
            </ul>
            <p class=mt-5>Thank you for trusting us with your personal information. If you have any questions or concerns about our Privacy Policy, please do not hesitate to contact us.</p>
         </div>';

        // Landing Footers Pages
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'footer_pages';
        $websiteSetting->name = 'Footers Pages';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials = [
            [
                "id" => "ao35w8ml7ym",
                "title" => "Privacy Policy",
                "slug" => "privacy-policy",
                "page_content" => $privacyHtml,
                "seo_keywords" => "privacy policy",
                "seo_description" => "privacy policy"
            ],
            [
                "id" => "7eqbe4vdlo",
                "title" => "About Us",
                "slug" => "about-us",
                "page_content" => $aboutUsHtml,
                "seo_keywords" => "aboutus",
                "seo_description" => "aboutus"
            ]
        ];
        $websiteSetting->save();

        // Landing Pages SEO
        $websiteSetting = new GlobalSettings();
        $websiteSetting->is_global = 1;
        $websiteSetting->company_id = $globalCompany->id;
        $websiteSetting->setting_type = 'website_seo';
        $websiteSetting->name = 'SEO Details';
        $websiteSetting->name_key = $langKey;
        $websiteSetting->credentials = [
            [
                'id' => '1jzmhcpnshn',
                'page_key' => 'home',
                'seo_title' => 'Home',
                'seo_author' => 'writerifly',
                'seo_keywords' => 'writerifly saas',
                'seo_description' => 'writerifly saas',
                'seo_image' => 'website_lnaqlb3xh6gmjwtxfdmz.png',
                'seo_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_lnaqlb3xh6gmjwtxfdmz.png',
            ],
            [
                'id' => '2jzmhcpnshn',
                'page_key' => 'register',
                'seo_title' => 'Register',
                'seo_author' => 'writerifly',
                'seo_keywords' => 'register, writerifly',
                'seo_description' => 'writerifly saas register',
                'seo_image' => 'website_lnaqlb3xh6gmjwtxfdmz.png',
                'seo_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_lnaqlb3xh6gmjwtxfdmz.png',
            ],
            [
                'id' => '3jzmhcpnshn',
                'page_key' => 'features',
                'seo_title' => 'Features',
                'seo_author' => 'writerifly',
                'seo_keywords' => 'features',
                'seo_description' => 'writerifly features page',
                'seo_image' => 'website_lnaqlb3xh6gmjwtxfdmz.png',
                'seo_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_lnaqlb3xh6gmjwtxfdmz.png',
            ],
            [
                'id' => '4jzmhcpnshn',
                'page_key' => 'contact',
                'seo_title' => 'Contact Us',
                'seo_author' => 'writerifly',
                'seo_keywords' => 'contact us',
                'seo_description' => 'writerifly contact us page',
                'seo_image' => 'website_lnaqlb3xh6gmjwtxfdmz.png',
                'seo_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_lnaqlb3xh6gmjwtxfdmz.png',
            ],
            [
                'id' => '5jzmhcpnshn',
                'page_key' => 'pricing',
                'seo_title' => 'Pricing',
                'seo_author' => 'writerifly',
                'seo_keywords' => 'pricing',
                'seo_description' => 'writerifly pricing page',
                'seo_image' => 'website_lnaqlb3xh6gmjwtxfdmz.png',
                'seo_image_url' => 'https://writerifly.codeifly.in/uploads/website/website_lnaqlb3xh6gmjwtxfdmz.png',
            ],
        ];
        $websiteSetting->save();
    }

    public static function createGlobalPaymentSettings($company)
    {
        if ($company->is_global == 1) {
            // For Superadmin Payment Gateway
            // Paypal
            $paypal = new GlobalSettings();
            $paypal->is_global = 1;
            $paypal->company_id = $company->id;
            $paypal->setting_type = 'payment_settings';
            $paypal->name = 'Paypal Payment Settings';
            $paypal->name_key = 'paypal';
            $paypal->credentials = [
                'paypal_client_id' => '',
                'paypal_secret' => '',
                'paypal_mode' => 'sandbox',
                'paypal_status' => 'active',
            ];
            $paypal->status = 1; // Also Remove this
            $paypal->save();

            // Stripe
            $stripe = new GlobalSettings();
            $stripe->is_global = 1;
            $stripe->company_id = $company->id;
            $stripe->setting_type = 'payment_settings';
            $stripe->name = 'Stripe Payment Settings';
            $stripe->name_key = 'stripe';
            $stripe->credentials = [
                'stripe_api_key' => '',
                'stripe_api_secret' => '',
                'stripe_webhook_key' => '',
                'stripe_status' => 'active',
            ];
            $stripe->status = 1; // Also Remove this
            $stripe->save();

            // Razorpay
            $razorpay = new GlobalSettings();
            $razorpay->is_global = 1;
            $razorpay->company_id = $company->id;
            $razorpay->setting_type = 'payment_settings';
            $razorpay->name = 'Razorpay Payment Settings';
            $razorpay->name_key = 'razorpay';
            $razorpay->credentials = [
                'razorpay_key' => '',
                'razorpay_secret' => '',
                'razorpay_webhook_secret' => '',
                'razorpay_status' => 'active',
            ];
            $razorpay->status = 1; // Also Remove this
            $razorpay->save();

            // Paystack
            $paystack = new GlobalSettings();
            $paystack->is_global = 1;
            $paystack->company_id = $company->id;
            $paystack->setting_type = 'payment_settings';
            $paystack->name = 'Paystack Payment Settings';
            $paystack->name_key = 'paystack';
            $paystack->credentials = [
                'paystack_client_id' => '',
                'paystack_secret' => '',
                'paystack_merchant_email' => '',
                'paystack_status' => 'inactive',
            ];
            $paystack->save();

            // Mollie
            $mollie = new GlobalSettings();
            $mollie->is_global = 1;
            $mollie->company_id = $company->id;
            $mollie->setting_type = 'payment_settings';
            $mollie->name = 'Mollie Payment Settings';
            $mollie->name_key = 'mollie';
            $mollie->credentials = [
                'mollie_api_key' => '',
                'mollie_status' => 'inactive',
            ];
            $mollie->save();

            // Authorize
            $authorize = new GlobalSettings();
            $authorize->is_global = 1;
            $authorize->company_id = $company->id;
            $authorize->setting_type = 'payment_settings';
            $authorize->name = 'Authorize Payment Settings';
            $authorize->name_key = 'authorize';
            $authorize->credentials = [
                'authorize_api_login_id' => '',
                'authorize_transaction_key' => '',
                'authorize_signature_key' => '',
                'authorize_environment' => 'sandbox',
                'authorize_status' => 'inactive',
            ];
            $authorize->save();
        }
    }

    public static function addWebsiteImageUrl($settingData, $keyName)
    {
        if ($settingData && array_key_exists($keyName, $settingData)) {
            if ($settingData[$keyName] != '') {
                $imagePath = Common::getFolderPath('websiteImagePath');

                $settingData[$keyName . '_url'] = Common::getFileUrl($imagePath, $settingData[$keyName]);
            } else {
                $settingData[$keyName] = null;
                $settingData[$keyName . '_url'] = asset('images/website.png');
            }
        }

        return $settingData;
    }

    public static function addUrlToAllSettings($allSettings, $keyName)
    {
        $allData = [];

        foreach ($allSettings as $allSetting) {
            $allData[] = self::addWebsiteImageUrl($allSetting, $keyName);
        }

        return $allData;
    }

    public static function getAppPaymentSettings($showType = 'limited')
    {
        $allPaymentMethods = GlobalSettings::withoutGlobalScope(CompanyScope::class)->where('setting_type', 'payment_settings')
            ->where('status', 1)
            ->get();

        if ($showType == 'limited') {
            foreach ($allPaymentMethods as $allPaymentMethod) {
                if ($allPaymentMethod->name_key == 'paypal') {
                    $allPaymentMethod->credentials = [
                        'paypal_client_id' => $allPaymentMethod->credentials['paypal_client_id'],
                        'paypal_mode' => $allPaymentMethod->credentials['paypal_mode'],
                        'paypal_status' => $allPaymentMethod->credentials['paypal_status'],
                    ];
                } else if ($allPaymentMethod->name_key == 'stripe') {
                    $allPaymentMethod->credentials = [
                        'stripe_api_key' => $allPaymentMethod->credentials['stripe_api_key'],
                        'stripe_status' => $allPaymentMethod->credentials['stripe_status'],
                    ];
                } else if ($allPaymentMethod->name_key == 'razorpay') {
                    $allPaymentMethod->credentials = [
                        'razorpay_key' => $allPaymentMethod->credentials['razorpay_key'],
                        'razorpay_status' => $allPaymentMethod->credentials['razorpay_status'],
                    ];
                } else if ($allPaymentMethod->name_key == 'paystack') {
                    $allPaymentMethod->credentials = [
                        'paystack_client_id' => $allPaymentMethod->credentials['paystack_client_id'],
                        'paystack_status' => $allPaymentMethod->credentials['paystack_status'],
                    ];
                } else if ($allPaymentMethod->name_key == 'mollie') {
                    $allPaymentMethod->credentials = [
                        'mollie_api_key' => $allPaymentMethod->credentials['mollie_api_key'],
                        'mollie_status' => $allPaymentMethod->credentials['mollie_status'],
                    ];
                } else if ($allPaymentMethod->name_key == 'authorize') {
                    $allPaymentMethod->credentials = [
                        'authorize_api_login_id' => $allPaymentMethod->credentials['authorize_api_login_id'],
                        'authorize_environment' => $allPaymentMethod->credentials['authorize_environment'],
                        'authorize_status' => $allPaymentMethod->credentials['authorize_status'],
                    ];
                }
            }
        }


        return $allPaymentMethods;
    }

    public static function createSuperAdmin($resetAdminCompany = false)
    {
        $enLang = Lang::where('key', 'en')->first();

        // Global Company for superadmin
        // Added here because on creating company observer will call
        // And on observer currency will be created
        $globalCompany = new GlobalCompany();
        $globalCompany->is_global = 1;
        $globalCompany->name = 'Writerifly SAAS';
        $globalCompany->short_name = 'Writerifly';
        $globalCompany->email = 'superadmin_company@example.com';
        $globalCompany->phone = '+9199999999';
        $globalCompany->address = '7 street, city, state, 762782';
        $globalCompany->verified = true;
        $globalCompany->primary_color = '#80cbc4';
        $globalCompany->lang_id = $enLang->id;
        $globalCompany->save();

        // if (env('APP_ENV') == 'production') {
        Common::addCurrencies($globalCompany);
        // }

        // Creating SuperAdmin
        $superAdmin = SuperAdmin::create([
            'company_id' => $globalCompany->id,
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => '12345678',
            'is_superadmin' => true,
            'user_type' => 'super_admins',
            'status' => 'enabled',
        ]);

        $globalCompany->admin_id = $superAdmin->id;
        $globalCompany->save();

        // Settings
        Common::insertInitSettings($globalCompany);

        // Creating Landing Website Page Settings
        // For en language
        self::createWebsiteSetting("en");

        self::createGlobalPaymentSettings($globalCompany);
    }

    public static function formatAmountCurrency($amount)
    {
        $newAmount = $amount;
        $superAdminCurrency = GlobalCompany::select('id', 'currency_id')->with('currency')->first();

        if ($superAdminCurrency->currency->position == "front") {
            $newAmountString = $superAdminCurrency->currency->symbol . '' . $newAmount;
        } else {
            $newAmountString = $newAmount . '' . $superAdminCurrency->currency->symbol;
        }

        return $newAmountString < 0 ? '-' . $newAmountString : $newAmountString;
    }

    public static function aiToolsData()
    {
        $toolsData = [
            [
                'name' => 'Blog Tools',
                'description' => 'AI writing script could help generate high-quality content for your blog, including article summaries, introductions, and even full blog posts',
                'logo' => '',
                'templates' => [
                    [
                        'name' => 'Blog Title',
                        'logo' => '',
                        'description' => 'Write a high quality blog title using your keyword',
                        'form_fields' => [
                            [
                                "name" => "Keyword",
                                "description" => "Enter keyword for your blog",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6iphp7t"
                            ]
                        ],
                        'prompt_text' => 'Write a blog title with keyword ##Keyword##'
                    ],
                    [
                        'name' => 'Blog Summary',
                        'logo' => '',
                        'description' => 'Write a summary for your blog title',
                        'form_fields' => [
                            [
                                "name" => "Blog Title",
                                "description" => "Enter blog title",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6iphp8t"
                            ]
                        ],
                        'prompt_text' => 'Write a blog summary for blog title ##Blog Title##'
                    ],
                    [
                        'name' => 'Blog Ideas',
                        'logo' => '',
                        'description' => 'Get Ideas for your new blogs',
                        'form_fields' => [
                            [
                                "name" => "Blog Keyword",
                                "description" => "Enter blog keyword",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6iph001"
                            ],
                            [
                                "name" => "No Of Ideas",
                                "description" => "Enter number for which you want to want blog idea",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6iph002"
                            ]
                        ],
                        'prompt_text' => 'Write ##No Of Ideas## blog idea for blog which have keywords ##Blog Keyword##'
                    ],
                    [
                        'name' => 'Blog Paragraph',
                        'logo' => '',
                        'description' => 'Write a blog paragraph for your blog title',
                        'form_fields' => [
                            [
                                "name" => "Blog Title",
                                "description" => "Enter blog title",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6ip1003"
                            ]
                        ],
                        'prompt_text' => 'Write a blog paragraph for blog title ##Blog Title##'
                    ],
                ]
            ],
            [
                'name' => 'Business Tools',
                'description' => 'AI writing script could help generate high-quality content for your business, including business name, introductions, and even full blog posts',
                'logo' => '',
                'templates' => [
                    [
                        'name' => 'Business Title',
                        'logo' => '',
                        'description' => 'Write a business name which have keyword',
                        'form_fields' => [
                            [
                                "name" => "Keyword",
                                "description" => "Enter keyword for your blog",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6ipo07t"
                            ]
                        ],
                        'prompt_text' => 'Write a business name with keyword ##Keyword##'
                    ],
                    [
                        'name' => 'Business Introduction',
                        'logo' => '',
                        'description' => 'Write a business introduction using name',
                        'form_fields' => [
                            [
                                "name" => "Business Name",
                                "description" => "Enter business name",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6iphp8t"
                            ],
                            [
                                "name" => "Keywords",
                                "description" => "Enter business keywords which is releated to business",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6ip11p8t"
                            ],
                        ],
                        'prompt_text' => 'Write a business indroduction which have name ##Business Name## and have keywords ##Keywords##'
                    ],
                    [
                        'name' => 'Business Ideas',
                        'logo' => '',
                        'description' => 'Get Ideas for your business',
                        'form_fields' => [
                            [
                                "name" => "Business Keyword",
                                "description" => "Enter business keyword",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6iph001"
                            ],
                            [
                                "name" => "No Of Ideas",
                                "description" => "Enter number for which you want to want business idea",
                                "type" => "text",
                                "required" => 1,
                                "id" => "9m0o6iph002"
                            ]
                        ],
                        'prompt_text' => 'Write ##No Of Ideas## business idea which have keywords ##Business Keyword##'
                    ],
                ]
            ]
        ];

        return $toolsData;
    }
}
