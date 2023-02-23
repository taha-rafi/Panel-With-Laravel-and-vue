<?php

use App\Models\Company;
use App\Scopes\CompanyScope;

// Get App Type
if (!function_exists('app_type')) {

    function app_type()
    {
        if (env('APP_TYPE')) {
            return env('APP_TYPE');
        } else {
            return "non-saas";
        }
    }
}

// Front Landing settings Language Key
if (!function_exists('front_lang_key')) {

    function front_lang_key()
    {
        if (session()->has('front_lang_key')) {
            return session('front_lang_key');
        }

        session(['front_lang_key' => 'en']);
        return session('front_lang_key');
    }
}

// This is app setting for logged in company
if (!function_exists('company')) {

    function company($reset = false)
    {
        if (session()->has('company') && $reset == false) {
            return session('company');
        }

        // If it is non-saas
        if (app_type() == 'non-saas') {
            $company = Company::with(['currency' => function ($query) {
                return $query->withoutGlobalScope(CompanyScope::class);
            }, 'subscriptionPlan'])->first();

            if ($company) {
                session(['company' => $company]);
                return session('company');
            }

            return null;
        } else {
            $user = user();

            if ($user && $user->company_id != "") {
                $company = Company::withoutGlobalScope('company')->with(['currency' => function ($query) use ($user) {
                    return $query->withoutGlobalScope(CompanyScope::class)
                        ->where('company_id', $user->company_id);
                }, 'subscriptionPlan' => function ($query) use ($user) {
                    return $query->select('id', 'modules', 'monthly_price', 'annual_price');
                }])->where('id', $user->company_id)->first();

                session(['company' => $company]);
                return session('company');
            }

            return null;
        }
    }
}

if (!function_exists('super_admin')) {

    /**
     * Return currently logged in user
     */
    function super_admin()
    {
        if (session()->has('super_admin')) {
            return session('super_admin');
        }

        $user = auth('api')->user();

        if ($user) {

            session(['super_admin' => $user]);
            return session('super_admin');
        }

        return null;
    }
}

if (!function_exists('user')) {

    /**
     * Return currently logged in user
     */
    function user()
    {
        if (session()->has('user')) {
            return session('user');
        }

        $user = auth('api')->user();

        // TODO - Check if
        if ($user) {
            $user = $user->load(['role' => function ($query) use ($user) {
                return $query->withoutGlobalScope(CompanyScope::class)
                    ->where('company_id', $user->company_id);
            }, 'role.perms']);

            session(['user' => $user]);
            return session('user');
        }

        return null;
    }
}
