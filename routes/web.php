<?php

use App\Http\Middleware\Web;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\EventsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\CoachController;
use App\Http\Controllers\Dashboard\CourtController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\GalleryController;
use App\Http\Controllers\Dashboard\BranchController;
use App\Http\Controllers\Dashboard\MissionController;
use App\Http\Controllers\Dashboard\PackageController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\ObjectiveController;
use App\Http\Controllers\Dashboard\PressController;
use App\Http\Controllers\Web\WebPressController;
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
        Route::middleware([Web::class])->group(function () {
            Route::get('/', [HomeController::class, 'index'])->name('home');
            Route::get('/events', [EventsController::class, 'index'])->name('events');
            Route::get('/events/{event}', [EventsController::class, 'show'])->name('events_details');
            Route::get('/press', [WebPressController::class, 'index'])->name('press.index');
            Route::get('/press/{slug}', [WebPressController::class, 'show'])->name('press_details');
            Route::post('/contact-us',  [HomeController::class, 'contactus'])->name('contactus');
        });

        Route::prefix("dashboard")->group(function () {
            Route::middleware('guest')->controller(LoginController::class)->group(function () {
                Route::get('login', 'showDashboardLoginForm');
                Route::post('login', 'dashboardLogin');
            });

            Route::name('dashboard.')->middleware(['isAdmin'])->group(function () {
                Route::get('/', [DashboardController::class, 'home'])->name('home');
                Route::get('logout', [LoginController::class, 'logout'])->name('logout');

                //branches
                Route::name('branches.')->prefix('branches')->controller(BranchController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('{branch}/edit', 'edit')->name('edit');
                    Route::put('{branch}/update', 'update')->name('update');
                    Route::delete('{branch}', 'destroy')->name('destroy');
                });

                //courts
                Route::name('courts.')->prefix('courts')->controller(CourtController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('{court}/edit', 'edit')->name('edit');
                    Route::put('{court}/update', 'update')->name('update');
                    Route::delete('{court}', 'destroy')->name('destroy');
                });

                //coaches
                Route::name('coaches.')->prefix('coaches')->controller(CoachController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('{coach}/edit', 'edit')->name('edit');
                    Route::put('{coach}/update', 'update')->name('update');
                    Route::delete('{coach}', 'destroy')->name('destroy');
                });

                //packages
                Route::name('packages.')->prefix('packages')->controller(PackageController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('{package}/edit', 'edit')->name('edit');
                    Route::put('{package}/update', 'update')->name('update');
                    Route::delete('{package}', 'destroy')->name('destroy');
                });

                //missions
                Route::name('missions.')->prefix('missions')->controller(MissionController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('{mission}/edit', 'edit')->name('edit');
                    Route::put('{mission}/update', 'update')->name('update');
                    Route::delete('{mission}', 'destroy')->name('destroy');
                });


                //objectives
                Route::name('objectives.')->prefix('objectives')->controller(ObjectiveController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('{objective}/edit', 'edit')->name('edit');
                    Route::put('{objective}/update', 'update')->name('update');
                    Route::delete('{objective}', 'destroy')->name('destroy');
                });

                //events
                Route::name('events.')->prefix('events')->controller(EventController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('{event}/edit', 'edit')->name('edit');
                    Route::put('{event}/update', 'update')->name('update');
                    Route::delete('{event}', 'destroy')->name('destroy');
                });

                //press
                Route::name('press.')->prefix('press')->controller(PressController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('{press}/edit', 'edit')->name('edit');
                    Route::put('{press}/update', 'update')->name('update');
                    Route::delete('{press}', 'destroy')->name('destroy');
                });

                //events
                Route::name('gallery.')->prefix('gallery')->controller(GalleryController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('{gallery}/edit', 'edit')->name('edit');
                    Route::put('{gallery}/update', 'update')->name('update');
                    Route::delete('{gallery}', 'destroy')->name('destroy');
                });
                //questions
                Route::name('questions.')->prefix('questions')->controller(QuestionController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('{question}/edit', 'edit')->name('edit');
                    Route::put('{question}/update', 'update')->name('update');
                    Route::delete('{question}', 'destroy')->name('destroy');
                });
            });
        });
    }
);
