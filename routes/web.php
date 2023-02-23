<?php

use Examyou\RestAPI\Facades\ApiRoute;

// Admin Routes
ApiRoute::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    ApiRoute::get('all-langs', ['as' => 'api.extra.all-langs', 'uses' => 'AuthController@allEnabledLangs']);
    ApiRoute::get('all-categories', ['as' => 'api.extra.all-categories', 'uses' => 'AuthController@allCategories']);
    ApiRoute::get('lang-trans', ['as' => 'api.extra.lang-trans', 'uses' => 'AuthController@langTrans']);
    ApiRoute::post('change-theme-mode', ['as' => 'api.extra.change-theme-mode', 'uses' => 'AuthController@changeThemeMode']);

    // Check visibility of module according to subscription plan
    ApiRoute::post('check-subscription-module-visibility', ['as' => 'api.extra.check-subscription-module-visibility', 'uses' => 'AuthController@checkSubscriptionModuleVisibility']);
    ApiRoute::post('visible-subscription-modules', ['as' => 'api.extra.visible-subscription-modules', 'uses' => 'AuthController@visibleSubscriptionModules']);

    ApiRoute::group(['middleware' => ['api.auth.check']], function () {
        ApiRoute::post('dashboard', ['as' => 'api.extra.dashboard', 'uses' => 'AuthController@dashboard']);
        ApiRoute::post('upload-file', ['as' => 'api.extra.upload-file', 'uses' => 'AuthController@uploadFile']);
        ApiRoute::post('profile', ['as' => 'api.extra.profile', 'uses' => 'AuthController@profile']);
        ApiRoute::post('user', ['as' => 'api.extra.user', 'uses' => 'AuthController@user']);
        ApiRoute::get('timezones', ['as' => 'api.extra.user', 'uses' => 'AuthController@getAllTimezones']);
    });

    // Routes Accessable to thouse user who have permissions realted to route
    ApiRoute::group(['middleware' => ['api.permission.check', 'api.auth.check', 'license-expire']], function () {
        $options = [
            'as' => 'api'
        ];

        // OpenAi Write
        ApiRoute::get('ai-tools/cateogry/{id}', ['as' => 'api.ai_tools.category', 'uses' => 'AiToolsController@getAiCategory']);
        ApiRoute::get('ai-tools/templates/{id}', ['as' => 'api.ai_tools.template', 'uses' => 'AiToolsController@getTemplate']);
        ApiRoute::post('ai-tools/all-categories', ['as' => 'api.ai_tools.all_categories', 'uses' => 'AiToolsController@allCategories']);
        ApiRoute::post('ai-tools/write', ['as' => 'api.ai_tools.write', 'uses' => 'AiToolsController@write']);
        ApiRoute::get('remaining-characters', ['as' => 'api.ai_tools.remaining_characters', 'uses' => 'AiToolsController@remainingCharacters']);


        // Imports
        ApiRoute::post('users/import', ['as' => 'api.users.import', 'uses' => 'UsersController@import']);

        // Create Menu Update
        ApiRoute::post('companies/update-create-menu', ['as' => 'api.companies.update-create-menu', 'uses' => 'CompanyController@updateCreateMenu']);

        ApiRoute::resource('users', 'UsersController', $options);
        ApiRoute::resource('companies', 'CompanyController', ['as' => 'api', 'only' => ['update']]);
        ApiRoute::resource('permissions', 'PermissionController', ['as' => 'api', 'only' => ['index']]);
        ApiRoute::resource('roles', 'RolesController', $options);
        ApiRoute::resource('work-spaces', 'WorkSpaceController', $options);
        ApiRoute::resource('writer-documents', 'WriterDocumentController', ['as' => 'api', 'only' => ['index', 'update', 'destroy']]);
    });
});
