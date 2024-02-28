<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\LendetController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\TestimonialController;

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

Route::get('/', [LandingController::class, 'home'])->name('landing.home');
Route::get('/privacy', [LandingController::class, 'privacy'])->name('landing.privacy');
Route::get('/terms', [LandingController::class, 'terms'])->name('landing.terms');
Route::get('/how_it_works', [LandingController::class, 'how_it_works'])->name('landing.how_it_works');
Route::get('/refund_policy', [LandingController::class, 'refund_policy'])->name('landing.refund_policy');
Route::post('/contact_us', [LandingController::class, 'contact_us'])->name('landing.contact_us');

Route::group(['middleware' => ['role:member|admin|super-admin']], function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/set-locale/{locale}', [DashboardController::class, 'setLocale'])->name('admin.set-locale');
    Route::group(['middleware' => ['role:admin|super-admin']], function () {
        Route::group(['middleware' => ['role:super-admin']], function () {
            Route::get('/admin/lendet/multimedia/canvas_collision', [LendetController::class, 'canvas_collision'])->name('admin.lendet.multimedia.canvas_collision');
            Route::get('/admin/lendet/multimedia/pixijs_hanoi', [LendetController::class, 'pixijs_hanoi'])->name('admin.lendet.multimedia.pixijs_hanoi');
            Route::get('/admin/lendet/multimedia/pixijs_tictactoe', [LendetController::class, 'pixijs_tictactoe'])->name('admin.lendet.multimedia.pixijs_tictactoe');
            Route::get('/admin/lendet/databaze-avancuar/sql-to-xml', [LendetController::class, 'sql_to_xml'])->name('admin.lendet.databaze_avancuar.sql_to_xml');
            Route::post('/admin/lendet/databaze-avancuar/upload_sql', [LendetController::class, 'upload_sql'])->name('admin.lendet.databaze_avancuar.upload_sql');
            Route::get('/admin/lendet/databaze-avancuar/convert_sql_to_xml', [LendetController::class, 'convert_sql_to_xml'])->name('admin.lendet.databaze_avancuar.convert_sql_to_xml');
            Route::post('/admin/lendet/databaze-avancuar/generate_xml', [LendetController::class, 'generate_xml'])->name('admin.lendet.databaze_avancuar.generate_xml');
            Route::get('/admin/lendet/ekstratimi-i-web/apriori', [LendetController::class, 'apriori'])->name('admin.lendet.ekstratimi_i_web.apriori');
        });
        Route::resource('admin/navigation', NavigationController::class, [
            'names' => [
                'index' => 'admin.navigation',
                'create' => 'admin.navigation.create',
                'store' => 'admin.navigation.store',
                'show' => 'admin.navigation.show',
                'edit' => 'admin.navigation.edit',
                'update' => 'admin.navigation.update',
                'destroy' => 'admin.navigation.destroy',
            ],
        ]);
        Route::post('admin/navigation/updateOrder', [NavigationController::class, 'updateOrder'])->name('admin.navigation.updateOrder');
        Route::resource('admin/testimonial', TestimonialController::class, [
            'names' => [
                'index' => 'admin.testimonial',
                'create' => 'admin.testimonial.create',
                'store' => 'admin.testimonial.store',
                'show' => 'admin.testimonial.show',
                'edit' => 'admin.testimonial.edit',
                'update' => 'admin.testimonial.update',
                'destroy' => 'admin.testimonial.destroy',
            ],
        ]);
        Route::resource('admin/slider', SliderController::class, [
            'names' => [
                'index' => 'admin.slider',
                'create' => 'admin.slider.create',
                'store' => 'admin.slider.store',
                'show' => 'admin.slider.show',
                'edit' => 'admin.slider.edit',
                'update' => 'admin.slider.update',
                'destroy' => 'admin.slider.destroy',
            ],
        ]);
        Route::post('admin/slider/updateOrder', [SliderController::class, 'updateOrder'])->name('admin.slider.updateOrder');
        Route::resource('admin/plan', PlanController::class, [
            'names' => [
                'index' => 'admin.plan',
                'create' => 'admin.plan.create',
                'store' => 'admin.plan.store',
                'show' => 'admin.plan.show',
                'edit' => 'admin.plan.edit',
                'update' => 'admin.plan.update',
                'destroy' => 'admin.plan.destroy',
            ],
        ]);
        Route::post('admin/plan/updateOrder', [PlanController::class, 'updateOrder'])->name('admin.plan.updateOrder');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
