<?php

use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ConfigController;

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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\SsrReportController;
use App\Http\Controllers\UploadSsrController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ssr')->middleware('auth')->name('home');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')
	->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')
	->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')
	->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')
	->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')
	->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')
	->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')
	->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')
	->name('change.perform');

Route::group(['middleware' => 'auth'], function () {
	// Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
	Route::redirect('/dashboard', '/ssr')->middleware('auth');

	Route::get('/profile', [UserProfileController::class, 'show'])
		->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])
		->name('profile.update');

	Route::get('ssr', [SsrReportController::class, 'show'])
		->defaults('view', 'pages.ssr')
		->name('ssr');
	Route::get('ssr/{cache_id?}', [SsrReportController::class, 'show'])
		->defaults('view', 'pages.ssr')
		->name('ssr');

	// Route::get('ssr-summary/category', [SsrReportController::class, 'summary'])
	// 	->defaults('view', 'pages.ssr-summary')
	// 	->name('ssr-summary.category');

	// Route::get('ssr-summary/department', [SsrReportController::class, 'summary'])
	// 	->defaults('view', 'pages.ssr-summary')
	// 	->name('ssr-summary.department');

	// Route::get('ssr-summary/condition', [SsrReportController::class, 'summary'])
	// 	->defaults('view', 'pages.ssr-summary')
	// 	->name('ssr-summary.condition');

	Route::get('ssr-summary/{groupping}', [SsrReportController::class, 'summary'])
		->defaults('view', 'pages.ssr-summary')
		->name('ssr-summary.groupping');

	Route::redirect('ssr-summary', '/ssr-summary/category')
		->name('ssr-summary');

	Route::get('/upload-ssr', [UploadSsrController::class, 'show'])
		->defaults('view', 'pages.upload-ssr')
		->name('upload-ssr');
	Route::post('/upload-ssr', [UploadSsrController::class, 'upload'])
		->defaults('view', 'pages.upload-ssr')
		->name('upload-ssr');

	Route::get('config/ssr', [ConfigController::class, 'ssr'])
		->defaults('view', 'pages.config.ssr')
		->name('config.ssr');
	Route::post('config/ssr', [ConfigController::class, 'saveSsr'])
		->defaults('view', 'pages.config.ssr');

	Route::get('user-management/{user_id}', [UserProfileController::class, 'show'])->name('user-management.edit');
	Route::post('user-management/{user_id}', [UserProfileController::class, 'update'])->name('user-management.update');
	Route::post('user-management/active/{user_id}', [UserProfileController::class, 'active'])->name('user-management.active');
	Route::post('user-management/inactive/{user_id}', [UserProfileController::class, 'inactive'])->name('user-management.inactive');


	Route::get('logout', [LoginController::class, 'logout'])->name('logout');
	Route::post('logout', [LoginController::class, 'logout']);
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
});
