<?php

use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\IndexController;
use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Route::get('/admin', [IndexController::class, 'index'])->name('admin.index');

Route::get('/admin/calendar', [CalendarController::class, 'index'])->name('admin.calendar.index');

Route::get('/admin/calendar/records', [CalendarController::class, 'records'])->name('admin.calendar.records');

Route::post('/admin/calendar/create-records', [CalendarController::class, 'createRecords'])->name('admin.calendar.create.records');
Route::post('/admin/calendar/get-data-record', [CalendarController::class, 'getDataRecord'])->name('admin.calendar.data.record');
Route::post('/admin/calendar/action-with-events', [CalendarController::class, 'actionWithEvents'])->name('admin.calendar.actions.record');
Route::post('/admin/calendar/search-autocomplete', [CalendarController::class, 'searchAutocomplete'])->name('admin.calendar.searchAutocomplete');
//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
