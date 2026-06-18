<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// cache clear
Route::get('/clear', function() {
  Auth::logout();
  session()->flush();
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  return "Cleared!";
});

 Route::fallback(function () {
    return redirect('/');
});

require __DIR__.'/admin.php';

Auth::routes();

Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/store', [FrontendController::class, 'contactStore'])->name('contact.store');
Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('aboutUs');
Route::get('/service', [FrontendController::class, 'service'])->name('service');
Route::get('/testimonial', [FrontendController::class, 'testimonial'])->name('testimonial');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');



Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/terms-of-service', [FrontendController::class, 'termsOfService'])->name('termsOfService');
Route::get('/sitemap', [FrontendController::class, 'sitemap'])->name('sitemap');



Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user', 'verified']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');

});