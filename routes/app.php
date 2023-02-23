<?php

use Examyou\RestAPI\Facades\ApiRoute;

ApiRoute::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    ApiRoute::get('global-setting', ['as' => 'api.extra.global-setting', 'uses' => 'AuthController@companySetting']);
    ApiRoute::get('app', ['as' => 'api.extra.app', 'uses' => 'AuthController@app']);

    // Authentication routes
    ApiRoute::group(['prefix' => 'auth'], function () {
        ApiRoute::post('login', ['as' => 'api.extra.login', 'uses' => 'AuthController@login']);
        ApiRoute::post('refresh-token', ['as' => 'api.extra.refresh-token', 'uses' => 'AuthController@refreshToken']);
        ApiRoute::post('logout', ['as' => 'api.extra.logout', 'uses' => 'AuthController@logout']);
    });
});
