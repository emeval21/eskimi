<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// list campaigns
Route::get('campaigns', 'CampaignController@index');

// list one campaign
Route::get('campaign/{id}', 'CampaignController@show');

// Create new campaign
Route::post('campaigns', 'CampaignController@store');

// Update campaign
Route::put('campaign', 'CampaignController@update');

// Update campaign
Route::post('campaign/{id}', 'CampaignController@update');

// Delete campaign
Route::delete('campaign/{id}', 'CampaignController@destroy');
