<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\DashboardController;
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
Route::post('/contact_us', [LandingController::class, 'contact_us'])->name('landing.contact_us');

Route::group(['middleware' => ['role:member|admin|super-admin']], function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::group(['middleware' => ['role:admin|super-admin']], function () {
        Route::group(['middleware' => ['role:super-admin']], function () {

        });
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
