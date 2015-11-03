<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Auth\AuthController@getLogin');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

//home
Route::get('home','HomesController@index');
Route::get('home/company_list','HomesController@companyList');

//company
Route::resource('company','CompaniesController');
Route::get('generate_company_list/{type}','CompaniesController@generateCompanyList');
Route::get('company/history/{id}','CompaniesController@history');

//company file
Route::get('company/manage_company_files/{id}','CompaniesController@manageCompanyFiles');
Route::post('company/save_company_file/{id}', 'CompaniesController@saveCompanyFile');
Route::delete('company/delete_company_file/{id}/{company_id}', 'CompaniesController@deleteCompanyFile');

//company related tables
Route::delete('company/delete_company_remark/{id}', 'CompaniesController@deleteCompanyRemark');
Route::delete('company/delete_company_feature/{id}', 'CompaniesController@deleteCompanyFeature');
Route::delete('company/delete_company_achievement/{id}', 'CompaniesController@deleteCompanyAchievement');
Route::delete('company/delete_company_contact/{id}', 'CompaniesController@deleteCompanyContact');

//company contact
Route::post('company/edit_company_contact/{id}', 'CompaniesController@editCompanyContact');
Route::post('company/add_company_contact/{id}', 'CompaniesController@addCompanyContact');

//user
Route::resource('user','UsersController');
Route::get('manage_group_user', 'UsersController@manageGroupUser');
Route::get('user/edit_user_profile/{id}', 'UsersController@editByNormalUser');
Route::post('user/update_user_profile/{id}', 'UsersController@updateByNormalUser');
Route::post('add_normal_user', 'UsersController@addGroupUser');

//job
Route::resource('job','JobsController');

//job files
Route::get('job/manage_job_files/{id}','JobsController@manageJobFiles');
Route::post('job/save_job_file/{id}', 'JobsController@saveJobFile');
Route::delete('job/delete_job_file/{id}/{company_id}', 'JobsController@deleteJobFile');

//bid
Route::resource('bid','BidsController');
Route::get('bid/bid_job/{id}','BidsController@bidJob');

//bid files
Route::get('bid/manage_bid_files/{id}','BidsController@manageBidFiles');
Route::post('bid/save_bid_file/{id}', 'BidsController@saveBidFile');
Route::delete('bid/delete_bid_file/{id}/{company_id}', 'BidsController@deleteBidFile');

Route::controllers([
    'password' => 'Auth\PasswordController',
]);