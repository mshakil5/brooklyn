<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyDetailsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\EstimateController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/', 'middleware' => ['auth', 'is_admin']], function(){
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard');

    // Admin Management Routes
    Route::get('/admin', 'App\Http\Controllers\Admin\AdminController@index')->name('admin.index');
    Route::post('/admin', 'App\Http\Controllers\Admin\AdminController@store')->name('admin.store');
    Route::get('/admin/{id}/edit', 'App\Http\Controllers\Admin\AdminController@edit')->name('admin.edit');
    Route::post('/admin-update', 'App\Http\Controllers\Admin\AdminController@update')->name('admin.update');
    Route::delete('/admin/{id}', 'App\Http\Controllers\Admin\AdminController@destroy')->name('admin.delete');
    Route::post('/admin-status', 'App\Http\Controllers\Admin\AdminController@toggleStatus')->name('admin.toggleStatus');


    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user-update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::post('/user-status', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');

    // Slider
    Route::get('/slider', [SliderController::class, 'getSlider'])->name('allslider');
    Route::post('/slider', [SliderController::class, 'sliderStore']);
    Route::get('/slider/{id}/edit', [SliderController::class, 'sliderEdit']);
    Route::post('/slider-update', [SliderController::class, 'sliderUpdate']);
    Route::delete('/slider/{id}', [SliderController::class, 'sliderDelete'])->name('slider.delete');
    Route::post('/slider-status', [SliderController::class, 'toggleStatus']);
    Route::post('/sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.updateOrder');

    // Contact
    Route::get('/contacts', [ContactController::class,'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class,'show'])->name('contacts.show');
    Route::delete('/contacts/{id}/delete', [ContactController::class,'destroy'])->name('contacts.delete');
    Route::post('/contacts/toggle-status', [ContactController::class,'toggleStatus'])->name('contacts.toggleStatus');

    // FAQ
    Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');
    Route::post('/faq', [FAQController::class, 'store'])->name('faq.store');
    Route::get('/faq/{id}/edit', [FAQController::class, 'edit'])->name('faq.edit');
    Route::post('/faq-update', [FAQController::class, 'update'])->name('faq.update');
    Route::delete('/faq/{id}', [FAQController::class, 'destroy'])->name('faq.delete');

    Route::get('/company-details', [CompanyDetailsController::class, 'index'])->name('admin.companyDetails');
    Route::post('/company-details', [CompanyDetailsController::class, 'update'])->name('admin.companyDetails');

    Route::get('/company/seo-meta', [CompanyDetailsController::class, 'seoMeta'])->name('admin.company.seo-meta');
    Route::post('/company/seo-meta/update', [CompanyDetailsController::class, 'seoMetaUpdate'])->name('admin.company.seo-meta.update');

    Route::get('/about-us', [CompanyDetailsController::class, 'aboutUs'])->name('admin.aboutUs');
    Route::post('/about-us', [CompanyDetailsController::class, 'aboutUsUpdate'])->name('admin.aboutUs');

    Route::get('/privacy-policy', [CompanyDetailsController::class, 'privacyPolicy'])->name('admin.privacy-policy');
    Route::post('/privacy-policy', [CompanyDetailsController::class, 'privacyPolicyUpdate'])->name('admin.privacy-policy');

    Route::get('/terms-and-conditions', [CompanyDetailsController::class, 'termsAndConditions'])->name('admin.terms-and-conditions');
    Route::post('/terms-and-conditions', [CompanyDetailsController::class, 'termsAndConditionsUpdate'])->name('admin.terms-and-conditions');
    
    Route::get('/mail-body', [CompanyDetailsController::class, 'mailBody'])->name('admin.mail-body');
    Route::post('/mail-body', [CompanyDetailsController::class, 'mailBodyUpdate'])->name('admin.mail-body');

    Route::get('/home-footer', [CompanyDetailsController::class, 'homeFooter'])->name('admin.home-footer');
    Route::post('/home-footer', [CompanyDetailsController::class, 'homeFooterUpdate'])->name('admin.home-footer');

    Route::get('/copyright', [CompanyDetailsController::class, 'copyright'])->name('admin.copyright');
    Route::post('/copyright', [CompanyDetailsController::class, 'copyrightUpdate'])->name('admin.copyright');

    Route::get('/master', [MasterController::class, 'index'])->name('master.index');
    Route::post('/master', [MasterController::class, 'store'])->name('master.store');
    Route::get('/master/{id}/edit', [MasterController::class, 'edit'])->name('master.edit');
    Route::post('/master-update', [MasterController::class, 'update'])->name('master.update');
    Route::delete('/master/{id}', [MasterController::class, 'destroy'])->name('master.delete');

    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::post('/sections/update-order', [SectionController::class, 'updateOrder'])->name('sections.updateOrder');
    Route::post('/sections/toggle-status', [SectionController::class, 'toggleStatus'])->name('sections.toggleStatus');

    // Category crud
    Route::get('/category', [CategoryController::class, 'index'])->name('allcategory');
    Route::get('/parent-categories', [CategoryController::class, 'parentCategories'])->name('parent.categories');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit']);
    Route::post('/category-update', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::post('/category-status', [CategoryController::class, 'toggleStatus']);

    
    Route::get('/galleries',           [GalleryController::class, 'index'])->name('admin.galleries');
    Route::post('/galleries',          [GalleryController::class, 'store']);
    Route::get('/galleries/{id}/edit', [GalleryController::class, 'edit']);
    Route::post('/galleries-update',   [GalleryController::class, 'update']);
    Route::delete('/galleries/{id}',   [GalleryController::class, 'destroy'])->name('galleries.destroy');


    // ============================================
    // ABOUT US MANAGEMENT - ROUTE ORDER MATTERS!
    // ============================================

    // 1. Main Index Page (NO parameters)
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');

    // 2. DataTable AJAX Routes (MUST be before {id} routes)
    Route::get('/about/stats-data', [AboutController::class, 'getStatsData'])->name('about.stats.data');
    Route::get('/about/highlights-data', [AboutController::class, 'getHighlightsData'])->name('about.highlights.data');
    Route::get('/about/milestones-data', [AboutController::class, 'getMilestonesData'])->name('about.milestones.data');
    Route::get('/about/values-data', [AboutController::class, 'getValuesData'])->name('about.values.data');
    Route::get('/about/certs-data', [AboutController::class, 'getCertsData'])->name('about.certs.data');

    // 3. Content Update (Hero & Story - NO {id})
    Route::post('/about-content-update', [AboutController::class, 'updateContent'])->name('about.content.update');
    Route::post('/about-image-upload', [AboutController::class, 'uploadImage'])->name('about.image.upload');

    // 4. Stats CRUD
    Route::post('/about-stat', [AboutController::class, 'storeStat'])->name('about.stat.store');
    Route::post('/about-stat-update', [AboutController::class, 'updateStat'])->name('about.stat.update');
    Route::post('/about-stat-status', [AboutController::class, 'toggleStatStatus'])->name('about.stat.toggleStatus');
    Route::get('/about-stat/{id}/edit', [AboutController::class, 'editStat'])->name('about.stat.edit');
    Route::delete('/about-stat/{id}', [AboutController::class, 'destroyStat'])->name('about.stat.delete');

    // 5. Highlights CRUD
    Route::post('/about-highlight', [AboutController::class, 'storeHighlight'])->name('about.highlight.store');
    Route::post('/about-highlight-update', [AboutController::class, 'updateHighlight'])->name('about.highlight.update');
    Route::post('/about-highlight-status', [AboutController::class, 'toggleHighlightStatus'])->name('about.highlight.toggleStatus');
    Route::get('/about-highlight/{id}/edit', [AboutController::class, 'editHighlight'])->name('about.highlight.edit');
    Route::delete('/about-highlight/{id}', [AboutController::class, 'destroyHighlight'])->name('about.highlight.delete');

    // 6. Milestones CRUD
    Route::post('/about-milestone', [AboutController::class, 'storeMilestone'])->name('about.milestone.store');
    Route::post('/about-milestone-update', [AboutController::class, 'updateMilestone'])->name('about.milestone.update');
    Route::post('/about-milestone-status', [AboutController::class, 'toggleMilestoneStatus'])->name('about.milestone.toggleStatus');
    Route::get('/about-milestone/{id}/edit', [AboutController::class, 'editMilestone'])->name('about.milestone.edit');
    Route::delete('/about-milestone/{id}', [AboutController::class, 'destroyMilestone'])->name('about.milestone.delete');

    // 7. Values CRUD
    Route::post('/about-value', [AboutController::class, 'storeValue'])->name('about.value.store');
    Route::post('/about-value-update', [AboutController::class, 'updateValue'])->name('about.value.update');
    Route::post('/about-value-status', [AboutController::class, 'toggleValueStatus'])->name('about.value.toggleStatus');
    Route::get('/about-value/{id}/edit', [AboutController::class, 'editValue'])->name('about.value.edit');
    Route::delete('/about-value/{id}', [AboutController::class, 'destroyValue'])->name('about.value.delete');

    // 8. Certs CRUD
    Route::post('/about-cert', [AboutController::class, 'storeCert'])->name('about.cert.store');
    Route::post('/about-cert-update', [AboutController::class, 'updateCert'])->name('about.cert.update');
    Route::post('/about-cert-status', [AboutController::class, 'toggleCertStatus'])->name('about.cert.toggleStatus');
    Route::get('/about-cert/{id}/edit', [AboutController::class, 'editCert'])->name('about.cert.edit');
    Route::delete('/about-cert/{id}', [AboutController::class, 'destroyCert'])->name('about.cert.delete');

    // Services
    Route::get('/service', [ServiceController::class, 'getService'])->name('allservice');
    Route::post('/service', [ServiceController::class, 'serviceStore']);
    Route::get('/service/{id}/edit', [ServiceController::class, 'serviceEdit']);
    Route::post('/service-update', [ServiceController::class, 'serviceUpdate']);
    Route::delete('/service/{id}', [ServiceController::class, 'serviceDelete'])->name('service.delete');
    Route::post('/service-status', [ServiceController::class, 'toggleStatus']);
    Route::post('/services/update-order', [ServiceController::class, 'updateOrder'])->name('services.updateOrder');

    // Estimates
    Route::get('/estimates', [EstimateController::class, 'index'])->name('estimates.index');
    Route::get('/estimates/{id}', [EstimateController::class, 'show'])->name('estimates.show');
    Route::delete('/estimates/{id}/delete', [EstimateController::class, 'destroy'])->name('estimates.delete');
    Route::post('/estimates/toggle-read', [EstimateController::class, 'toggleRead'])->name('estimates.toggleRead');



});