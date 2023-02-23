<?php

use Examyou\RestAPI\Facades\ApiRoute;

ApiRoute::group(['namespace' => 'App\SuperAdmin\Http\Controllers\Api'], function () {
    ApiRoute::get('global-setting', ['as' => 'api.extra.global-setting', 'uses' => 'SuperAdminAuthController@globalSetting']);
    ApiRoute::get('app', ['as' => 'api.extra.app', 'uses' => 'SuperAdminAuthController@appDetails']);

    // Authentication routes
    ApiRoute::group(['prefix' => 'auth'], function () {
        ApiRoute::post('login', ['as' => 'api.extra.login', 'uses' => 'SuperAdminAuthController@superAdminLogin']);
        ApiRoute::post('refresh-token', ['as' => 'api.extra.refresh-token', 'uses' => 'SuperAdminAuthController@refreshToken']);
        ApiRoute::post('logout', ['as' => 'api.extra.logout', 'uses' => 'SuperAdminAuthController@logout']);
    });
});
