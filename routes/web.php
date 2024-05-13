<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::get('/', function () {
            return view('welcome');
        });

        Route::prefix("dashboard")->group(function () {
            Route::middleware('guest')->controller(LoginController::class)->group(function () {
                Route::get('login', 'showDashboardLoginForm');
                Route::post('login', 'dashboardLogin');
            });

            Route::name('dashboard.')->middleware(['isAdmin'])->group(function () {
                Route::get('/', [DashboardController::class, 'home'])->name('home');
                Route::get('logout', [LoginController::class, 'logout'])->name('logout');
            });
        });
    }
);
