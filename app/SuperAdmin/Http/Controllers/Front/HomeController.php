<?php

namespace App\SuperAdmin\Http\Controllers\Front;

use App\Classes\Common;
use App\Classes\Output;
use App\SuperAdmin\Http\Requests\Front\Contact\StoreRequest;
use App\SuperAdmin\Http\Requests\Front\Register\StoreRegisterRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\StaffMember;
use App\Models\SubscriptionPlan;
use App\Models\UserDetails;
use App\Models\Warehouse;
use App\Scopes\CompanyScope;
use App\SuperAdmin\Classes\SuperAdminCommon;
use App\SuperAdmin\Http\Requests\Front\CallToActionRequest;
use App\SuperAdmin\Models\GlobalCompany;
use App\SuperAdmin\Models\GlobalSettings;
use App\SuperAdmin\Notifications\Front\ContactUsEmail;
use App\SuperAdmin\Notifications\Front\NewUserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;


class HomeController extends FrontBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index($slug = null)
    {
        $this->seoDetail = $this->getPageSeoDetails('home');

        // Header Features
        $allHeaderFeatures = GlobalSettings::where('setting_type', 'header_features')
            ->where('name_key', $this->langKey)
            ->first();
        $allHeaderFeatures = $allHeaderFeatures->credentials;
        // $allHeaderFeatures = SuperAdminCommon::addUrlToAllSettings($allHeaderFeatures, 'logo');
        $this->headerFeatures = Common::convertToCollection($allHeaderFeatures);

        // Clients
        $clientsSetting = GlobalSettings::where('setting_type', 'website_clients')
            ->where('name_key', $this->langKey)
            ->first();
        $clients = $clientsSetting->credentials;
        // $clients = SuperAdminCommon::addUrlToAllSettings($clients, 'logo');
        $this->frontClients = Common::convertToCollection($clients);

        // Testimonials
        $testimonialsSetting = GlobalSettings::where('setting_type', 'website_testimonials')
            ->where('name_key', $this->langKey)
            ->first();
        $testimonials = $testimonialsSetting->credentials;
        $this->frontTestimonials = Common::convertToCollection($testimonials);

        // Features With Images
        $featuresSetting = GlobalSettings::where('setting_type', 'website_features')
            ->where('name_key', $this->langKey)
            ->first();
        $features = $featuresSetting->credentials;
        // $features = SuperAdminCommon::addUrlToAllSettings($features, 'image');
        $this->allHomePageFeatures = Common::convertToCollection($features);

        return view('front.home', $this->data);
    }

    public function features()
    {
        // SEO Details
        $this->seoDetail = $this->getPageSeoDetails('features');

        // Breadcrumb Details
        $this->showFullHeader = false;
        $this->breadcrumbTitle = $this->frontSetting->features_text;

        // Features
        $allNewFeatures = GlobalSettings::where('setting_type', 'features_page')
            ->where('name_key', $this->langKey)
            ->first();
        $allFeatures = $allNewFeatures->credentials;
        $this->allFeatures = Common::convertToCollection($allFeatures);

        return view('front.features', $this->data);
    }

    public function pricing()
    {
        // SEO Details
        $this->seoDetail = $this->getPageSeoDetails('pricing');

        // Breadcrumb Details
        $this->showFullHeader = false;
        $this->breadcrumbTitle = $this->frontSetting->pricing_text;

        // Subscription Plans
        $this->subscriptionPlans = SubscriptionPlan::where('default', '!=', 'trial')
            ->get();

        // FAQ
        $faqSetting = GlobalSettings::where('setting_type', 'website_faqs')
            ->where('name_key', $this->langKey)
            ->first();
        $allFaqs = $faqSetting->credentials;
        $this->allFaqs = Common::convertToCollection($allFaqs);

        // Pricing Cards
        $pricingCardSettings = GlobalSettings::where('setting_type', 'pricing_cards')
            ->where('name_key', $this->langKey)
            ->first();
        $pricingCardSettings = $pricingCardSettings->credentials;
        $pricingCardSettings = SuperAdminCommon::addUrlToAllSettings($pricingCardSettings, 'logo');
        $this->pricingCards = Common::convertToCollection($pricingCardSettings);

        return view('front.pricing', $this->data);
    }

    public function contact()
    {
        // SEO Details
        $this->seoDetail = $this->getPageSeoDetails('contact');

        // Breadcrumb Details
        $this->showFullHeader = false;
        $this->breadcrumbTitle = $this->frontSetting->contact_text;

        return view('front.contact', $this->data);
    }

    public function submitContactForm(StoreRequest $request)
    {
        $templateSubject = 'New Contact Enquiry';

        $templateContent = '<table><tbody style="color:#0000009c;">
                <tr>
                    <td><p>Name : </p></td>
                    <td><p>' . ucwords($request->name) . '</p></td>
                </tr>
                <tr>
                    <td><p>Email : </p></td>
                    <td><p>' . $request->email . '</p></td>
                </tr>
                <tr>
                    <td style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;min-width: 98px;vertical-align: super;"><p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Message : </p></td>
                    <td><p>' . $request->message . '</p></td>
                </tr>
        </tbody>
</table><br>';

        $emailSettingEnabled = GlobalSettings::withoutGlobalScope(CompanyScope::class)->where('setting_type', 'email')
            ->where('name_key', 'smtp')
            ->first();

        if ($emailSettingEnabled->status == 1 && $emailSettingEnabled->verified == 1) {
            $globalCompany = GlobalCompany::first();

            Notification::route('mail', $globalCompany->email)
                ->notify(new ContactUsEmail($templateSubject, $templateContent));
        }

        return Output::success($this->frontSetting->contact_us_submit_message_text);
    }

    public function page($slug = null)
    {
        $frontPageDetails = null;

        foreach ($this->footerPages as $footerPage) {
            if ($footerPage->slug == $slug) {
                $frontPageDetails = $footerPage;
            }
        }

        if ($frontPageDetails) {
            $this->isErrorPage = 0;
            $this->frontPageDetails = $frontPageDetails;

            // Breadcrumb Details
            $this->showFullHeader = false;
            $this->breadcrumbTitle = $frontPageDetails->title;

            // SEO Details
            $this->seoDetail = (object) [
                "id" => $frontPageDetails->id,
                "page_key" => $frontPageDetails->slug,
                "seo_title" => $frontPageDetails->title,
                "seo_author" => $this->frontSetting->app_name,
                "seo_keywords" => $frontPageDetails->seo_keywords,
                "seo_description" => $frontPageDetails->seo_description,
                "seo_image" => $this->frontSetting->header_logo,
                "seo_image_url" => $this->frontSetting->header_logo_url
            ];
        } else {
            $this->isErrorPage = 1;

            // Breadcrumb Details
            $this->showFullHeader = false;
            $this->breadcrumbTitle = 'Page Not Found';

            // SEO Details
            $this->seoDetail = (object) [
                "id" => 'error',
                "page_key" => 'error-x',
                "seo_title" => '404 Error',
                "seo_author" => $this->frontSetting->app_name,
                "seo_keywords" => $this->frontSetting->app_name,
                "seo_description" => $this->frontSetting->app_name,
                "seo_image" => $this->frontSetting->header_logo,
                "seo_image_url" => $this->frontSetting->header_logo_url
            ];
        }


        return view('front.page', $this->data);
    }

    public function register(Request $request)
    {
        $this->actionEmail = $request->has('email') && $request->email != '' ? $request->email : '';

        // SEO Details
        $this->seoDetail = $this->getPageSeoDetails('register');

        // Breadcrumb Details
        $this->showFullHeader = false;
        $this->breadcrumbTitle = $this->frontSetting->register_text;

        // Header Features
        $allHeaderFeatures = GlobalSettings::where('setting_type', 'header_features')
            ->where('name_key', $this->langKey)
            ->first();
        $allHeaderFeatures = $allHeaderFeatures->credentials;
        $allHeaderFeatures = SuperAdminCommon::addUrlToAllSettings($allHeaderFeatures, 'logo');
        $this->headerFeatures = Common::convertToCollection($allHeaderFeatures);

        return view('front.register', $this->data);
    }

    public function saveRegister(StoreRegisterRequest $request)
    {
        $company = new Company();

        DB::beginTransaction();
        try {
            $company->name = $request->company_name;
            $company->short_name = Str::lower($request->company_name);
            $company->email = $request->company_email;
            $company->total_users = 1;
            $company->is_global = 0;
            $company->save();

            $admin = StaffMember::create([
                'company_id' => $company->id,
                'name' => "Admin",
                'email' => $request->company_email,
                'password' => $request->password,
                'user_type' => 'staff_members',
                'email_verification_code' => Str::random(50),
                'status' => 'enabled',
            ]);

            $adminRole = Role::withoutGlobalScope(CompanyScope::class)->where('name', 'admin')->where('company_id', $company->id)->first();

            $admin->role_id = $adminRole->id;
            $admin->save();
            $admin->roles()->attach($adminRole->id);

            $company->admin_id = $admin->id;
            $company->save();


            $mailSetting = GlobalSettings::where('setting_type', 'email')->where('status', 1)->where('verified', 1)->first();
            if ($mailSetting) {
                // $message = $this->frontTranslations['register_thank_you'] . ' <a href="' . route('main', 'admin/login') . '">' . $this->frontTranslations['login'] . '</a>.';

                $globalCompany = GlobalCompany::first();
                $notficationData = [
                    'company' => $company,
                    'user' => $admin,
                ];
                Notification::route('mail', $globalCompany->email)->notify(new NewUserRegistered($notficationData));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return Output::error($e->getMessage());
            return Output::error($this->frontSetting->error_contact_support);
        }

        return Output::success($this->frontSetting->register_success_text);
    }

    public function callToAction(CallToActionRequest $request)
    {
        return Output::success('success');
    }

    public function changeLanguage()
    {
        $request = request();

        $langKey = $request->has('key') ? $request->key : 'en';

        session(['front_lang_key' => $langKey]);

        return Output::success('success');
    }

    // TODO - Verify Register
    // TODO - Change Language


}
