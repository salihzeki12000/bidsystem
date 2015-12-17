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
Route::get('company/job_history/{id}','CompaniesController@jobHistory');
Route::get('company/bid_history/{id}','CompaniesController@bidHistory');

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
Route::get('manage_group_user/{id}', 'UsersController@manageGroupUser');
Route::get('user/edit_user_profile/{id}', 'UsersController@editByNormalUser');
Route::post('user/update_user_profile/{id}', 'UsersController@updateByNormalUser');
Route::post('add_normal_user', 'UsersController@addGroupUser');

//job
Route::resource('job','JobsController');
Route::get('match/{id}','JobsController@matchLsp');
Route::get('search_job', 'JobsController@searchJob');
Route::post('show_search_job_result', 'JobsController@showSearchJobResult');
Route::get('job_progress_tracking/{id}','CompaniesController@jobProgressTracking');

//job files
Route::get('job/manage_job_files/{id}','JobsController@manageJobFiles');
Route::post('job/save_job_file/{id}', 'JobsController@saveJobFile');
Route::delete('job/delete_job_file/{id}/{company_id}', 'JobsController@deleteJobFile');

//bid
Route::resource('bid','BidsController');
Route::get('bid/bid_job/{id}','BidsController@bidJob');
Route::post('bid/update_bid_status', 'BidsController@updateBidStatus');
Route::get('bid_progress_tracking/{id}','CompaniesController@bidProgressTracking');
Route::get('received_bids/{id}','CompaniesController@receivedBids');

//bid files
Route::get('bid/manage_bid_files/{id}','BidsController@manageBidFiles');
Route::post('bid/save_bid_file/{id}', 'BidsController@saveBidFile');
Route::delete('bid/delete_bid_file/{id}/{company_id}', 'BidsController@deleteBidFile');

//message
Route::post('message/send_message','MessagesController@sendMessage');
Route::post('message/send_reply_message','MessagesController@sendReplyMessage');
Route::post('message/read_message','MessagesController@readMessage');
Route::get('messages/{id}','MessagesController@showAllMessages');
Route::resource('messages','MessagesController');

//appointment
Route::get('show_all_appointments/{id}','AppointmentsController@showAllAppointments');
Route::post('appointments/response_appointment','AppointmentsController@responseToAppointmentRequest');
Route::post('appointments/modify_appointment/{id}','AppointmentsController@modifyAppointment');
Route::post('appointments/modify_appointment_response/{id}','AppointmentsController@modifyAppointmentResponse');
Route::resource('appointments','AppointmentsController');

//credit
Route::get('credit/new_credit_transaction/{id}','CompanyCreditTransactionsController@newCreditTransaction');
Route::post('credit/change_expiry_date','CompanyCreditTransactionsController@changeExpiryDate');
Route::resource('credit','CompanyCreditTransactionsController');

//ticket
Route::resource('ticket','TicketsController');
Route::post('ticket/save_response','TicketsController@saveResponse');
Route::get('ticket_category','TicketsController@manageCategory');
Route::post('ticket/save_category','TicketsController@saveCategory');
Route::get('ticket_admin_email','TicketsController@adminEmail');
Route::get('ticket/show_my_tickets/{id}','TicketsController@showMyTickets');
Route::post('ticket/save_admin_email','TicketsController@saveAdminEmail');

//rating
Route::post('rating/rate_company','RatingsController@rateCompany');
Route::post('rating/save_rating','RatingsController@saveRating');
Route::get('rating/finish_rating','RatingsController@finishRating');
Route::get('rating/list_companies','RatingsController@listCompanies');
Route::get('rating/show_all_ratings/{id}','RatingsController@showAllRatings');

//user performance
Route::get('user_performance','UserPerformancesController@userPerformance');

//system drop downs
Route::get('system','SystemConfigurationsController@index');
Route::post('system/add','SystemConfigurationsController@add');
Route::post('system/edit','SystemConfigurationsController@edit');
Route::post('system/delete','SystemConfigurationsController@delete');

Route::controllers([
    'password' => 'Auth\PasswordController',
]);