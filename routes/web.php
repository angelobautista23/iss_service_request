<?php

use Illuminate\Support\Facades\Route;

// MODEL
use App\Model\Questionnaire;
use App\Model\Sampling;
use App\Model\Position;

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

Route::get('/link', function () {
    return 'link';
})->name('link');


Route::get('/', function () {
    return view('index');
})->name('login');

Route::get('/session_expired', function () {
    return view('session_expired');
})->name('session_expired');

Route::get('/success', function () {
    return view('success');
})->name('success');

Route::get('/vim', function () {
    return view('vim');
})->name('vim');

// ROUTE CONTROLLER
Route::get('/dashboard', 'RouteController@dashboard')->name('dashboard');
Route::get('/users', 'RouteController@users')->name('users');
Route::get('/service_types', 'RouteController@service_types')->name('service_types');
Route::get('/ticketing', 'RouteController@ticketing')->name('ticketing');
Route::get('/my_tickets', 'RouteController@my_tickets')->name('my_tickets');
Route::get('/holidays', 'RouteController@holidays')->name('holidays');

// REFERENCE TYPE CONTROLLER
Route::get('/view_reference_types', 'ReferenceTypeController@view_reference_types')->name('view_reference_types');
Route::post('/save_reference_type', 'ReferenceTypeController@save_reference_type')->name('save_reference_type');
Route::post('/reference_type_action', 'ReferenceTypeController@reference_type_action')->name('reference_type_action');
Route::get('/get_reference_type_by_id', 'ReferenceTypeController@get_reference_type_by_id')->name('get_reference_type_by_id');
Route::get('/get_reference_type_by_stat', 'ReferenceTypeController@get_reference_type_by_stat')->name('get_reference_type_by_stat');
Route::get('/get_cbo_reference_type_by_stat', 'ReferenceTypeController@get_cbo_reference_type_by_stat')->name('get_cbo_reference_type_by_stat');

// USER CONTROLLER
Route::get('/view_users', 'UserController@view_users')->name('view_users');
Route::post('/save_user', 'UserController@save_user')->name('save_user');
Route::post('/user_action', 'UserController@user_action')->name('user_action');
Route::post('/assign_user', 'UserController@assign_user')->name('assign_user');
Route::get('/get_user_by_id', 'UserController@get_user_by_id')->name('get_user_by_id');
Route::get('/get_user_by_stat', 'UserController@get_user_by_stat')->name('get_user_by_stat');
Route::get('/get_cbo_user_by_stat', 'UserController@get_cbo_user_by_stat')->name('get_cbo_user_by_stat');
Route::get('/get_cbo_rx_user_emails', 'UserController@get_cbo_rx_user_emails')->name('get_cbo_rx_user_emails');
Route::get('/get_cbo_user_staffs_by_stat', 'UserController@get_cbo_user_staffs_by_stat')->name('get_cbo_user_staffs_by_stat');

// SERVICE TYPE CONTROLLER
Route::get('/view_service_types', 'ServiceTypeController@view_service_types')->name('view_service_types');
Route::post('/save_service_type', 'ServiceTypeController@save_service_type')->name('save_service_type');
Route::post('/service_type_action', 'ServiceTypeController@service_type_action')->name('service_type_action');
Route::get('/get_service_type_by_id', 'ServiceTypeController@get_service_type_by_id')->name('get_service_type_by_id');
Route::get('/get_service_type_by_stat', 'ServiceTypeController@get_service_type_by_stat')->name('get_service_type_by_stat');
Route::get('/get_cbo_service_type_by_stat', 'ServiceTypeController@get_cbo_service_type_by_stat')->name('get_cbo_service_type_by_stat');

// TICKET CONTROLLER
Route::get('/view_tickets', 'TicketController@view_tickets')->name('view_tickets');
Route::get('/view_my_tickets', 'TicketController@view_my_tickets')->name('view_my_tickets');
Route::post('/save_ticket', 'TicketController@save_ticket')->name('save_ticket');
Route::post('/ticket_action', 'TicketController@ticket_action')->name('ticket_action');
Route::get('/get_ticket_by_id', 'TicketController@get_ticket_by_id')->name('get_ticket_by_id');
Route::get('/get_ticket_logs_by_id', 'TicketController@get_ticket_logs_by_id')->name('get_ticket_logs_by_id');
Route::get('/get_ticket_by_stat', 'TicketController@get_ticket_by_stat')->name('get_ticket_by_stat');
Route::get('/get_cbo_ticket_by_stat', 'TicketController@get_cbo_ticket_by_stat')->name('get_cbo_ticket_by_stat');
Route::post('/assign_ticket', 'TicketController@assign_ticket')->name('assign_ticket');
Route::post('/reassign_ticket', 'TicketController@reassign_ticket')->name('reassign_ticket');
Route::post('/for_verification_ticket', 'TicketController@for_verification_ticket')->name('for_verification_ticket');
Route::post('/comment_ticket', 'TicketController@comment_ticket')->name('comment_ticket');
Route::get('/view_open_tickets', 'TicketController@view_open_tickets')->name('view_open_tickets');
Route::get('/view_in_progress_tickets', 'TicketController@view_in_progress_tickets')->name('view_in_progress_tickets');

// HOLIDAY CONTROLLER
Route::get('/view_holidays', 'HolidayController@view_holidays')->name('view_holidays');
Route::post('/save_holiday', 'HolidayController@save_holiday')->name('save_holiday');
Route::post('/holiday_action', 'HolidayController@holiday_action')->name('holiday_action');
Route::get('/get_holiday_by_id', 'HolidayController@get_holiday_by_id')->name('get_holiday_by_id');
Route::get('/get_holiday_by_stat', 'HolidayController@get_holiday_by_stat')->name('get_holiday_by_stat');
Route::get('/get_cbo_holiday_by_stat', 'HolidayController@get_cbo_holiday_by_stat')->name('get_cbo_holiday_by_stat');
