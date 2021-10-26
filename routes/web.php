<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/add-campaign', function () {
    return view('pages.add_campaign');
});

Route::get('/edit-campaign', function () {
    return view('pages.edit_campaign');
});

Route::get('/add-files', function () {
    return view('pages.add_files');
});