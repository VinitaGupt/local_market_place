
<?php


use Illuminate\Support\Facades\Route;

use Modules\YellowPages\Http\Controllers\ListingController;
use Modules\YellowPages\Http\Controllers\HomeController;
use Modules\YellowPages\Http\Controllers\VCardController;
use Modules\YellowPages\Http\Controllers\ReviewController;
use Modules\YellowPages\Http\Controllers\AuthModalController;
use Modules\YellowPages\Http\Controllers\ReportController;
use Modules\YellowPages\Http\Controllers\Admin\ManageReportController;
use Modules\YellowPages\Http\Controllers\Admin\AuthController;
use Modules\YellowPages\Http\Controllers\Admin\CardController;
use Modules\YellowPages\Http\Controllers\Admin\AdminController;
use Modules\YellowPages\Http\Controllers\Admin\PaymentController;
use Modules\YellowPages\Http\Controllers\Admin\CitiesController;
use Modules\YellowPages\Http\Controllers\Admin\CategoriesController;
use Modules\YellowPages\Http\Controllers\Admin\BusinessController;
use Modules\YellowPages\Http\Controllers\Admin\RatingController;
use Modules\YellowPages\Http\Controllers\Checker\CheckerController;
use Modules\YellowPages\Http\Controllers\VCard\VCardAuthcontroller;
use Modules\YellowPages\Http\Controllers\VCard\PlanController;
use Modules\YellowPages\Http\Controllers\VCard\VCardQRController;
use Modules\YellowPages\Http\Controllers\VCard\CreateVCardController;
use Modules\YellowPages\Http\Controllers\VCard\BusinessListingController;
use Modules\YellowPages\Http\Controllers\VCard\listingReviewController;


Route::get('yellow-pages/{any}', function ($any) {
  return redirect("/yp/".$any);
})->where('any', '.*');



Route::group(['prefix' => 'yp', 'middleware' => 'language'], function () {
    Route::get('/login', [AuthModalController::class, 'index'])->name('yp.login');
    Route::post('/authLogin', [AuthModalController::class, 'login'])->name('yp.authLogin');
    Route::get('/new-account', [AuthModalController::class, 'newAccount'])->name('yp.newAccount');
    Route::post('/logout', [AuthModalController::class, 'logout'])->name('yp.logout');
    Route::get('/', [HomeController::class, 'index'])->name('yp.home');
    Route::get('/listing_plan', [HomeController::class, 'listing_plan'])->name('yp.listing_plan');
    Route::get('/bazzar_plan', [HomeController::class, 'bazzar_plan'])->name('yp.bazzar_plan');
    Route::get('/add_listing', [HomeController::class, 'add_listing'])->name('yp.add_listing');
    Route::get('/showSearchcategory', [HomeController::class, 'showSearchcategory']);
    Route::get('/plans', [HomeController::class, 'plan'])->name('yp.plan');
    Route::get('category/{category_name}', [ListingController::class, 'showByCategory'])->name('category.show');

    Route::post('/reviews/store/{listing}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/submit', [ReviewController::class, 'submit_review'])->name('review.submit');
    Route::group(['middleware' => 'auth.custom'], function(){
      Route::get('/getLocationData', [ListingController::class, 'getLocationData'])->name('yp.getLocationData');
      Route::post('/store-listing', [ListingController::class, 'store'])->name('yp.listing.store');
      Route::get('/submit-listing', [ListingController::class, 'submit_listing'])->name('yp.listing.submit');
      Route::get('/Save-listing/{id}', [ListingController::class, 'save_listing'])->name('yp.listing.save');
    });

    ##------------------------- END ---------------------##


    
    Route::get('/create-web-page', [VCardController::class, 'index'])->name('yp.vcard');
    Route::get('/vCard/logout', [VCardController::class, 'logout'])->name('vCard.logout');
    ##------------------------- END ---------------------##

   
    Route::get('/scan/myweb/{slug}', [CreateVCardController::class, 'vcardScan'])->name('vCard.scan');
    Route::get('/share/myweb/{slug}', [CreateVCardController::class, 'vcardShare'])->name('vCard.share');
    Route::get('/vcard/{vcard_id}/{slug}', [VcardQRController::class, 'scanAndView'])->name('vCard.scanView');
     ##------------------------- VCard QR ---------------------##
     Route::get('/user/qr/', [VcardQRController::class, 'generateQrCode'])->name('vCard.generateQr');
     Route::get('vcard/qr-code/download', [VcardQRController::class, 'downloadQrCode'])->name('vCard.downloadQrCode');
     ##------------------------- END ---------------------##

    Route::group(['middleware' => 'auth.custom'], function(){

    // Route::group(['middleware' => 'check.subscription'], function(){
     Route::group(['middleware' => 'check.vcard.business'], function(){
    ##------------------------- Vcard  ---------------------##

      Route::get('/user/dashboard', [VCardController::class, 'dashboard'])->name('vCard.dashboard');
      Route::get('/user/createCard', [VCardController::class, 'createCard'])->name('vCard.createCard');
    ##------------------------- END ---------------------##
    
    ##------------------------- Carete VCard ---------------------##
    Route::post('/user/CardStore', [CreateVCardController::class, 'store'])->name('vCard.store');
    Route::get('/vcard-edit/{id}', [CreateVCardController::class, 'vcardEdit'])->name('vCard.vcard-edit');
    Route::post('/vcard-delete/{id}', [CreateVCardController::class, 'vcarddelete'])->name('vCard.vcard-delete');
    Route::put('/vcard-update/{id}', [CreateVCardController::class, 'vcardUpdate'])->name('vCard.update');
    Route::get('user/vcard-list', [CreateVCardController::class, 'VcardList'])->name('vCard.list');

     ##------------------------- END ---------------------##
     ##------------------------- Dashboard User data ---------------------##
     Route::get('/user/user-edit/{id}', [vCardAuthcontroller::class, 'userEdit'])->name('vCard.userEdit');
     Route::put('/user/user-update/{id}', [vCardAuthcontroller::class, 'userUpdate'])->name('vCard.userUpdate');
     Route::get('/user/password-reset', [vCardAuthcontroller::class, 'passwordReset'])->name('vCard.passwordReset');
     Route::put('/user/password-update/{id}', [vCardAuthcontroller::class, 'passwordUpdate'])->name('vCard.passwordUpdate');
     ##------------------------- END ---------------------##

     ##------------------------- Dashboard Listing data ---------------------##
     Route::get('/user/business-listing', [BusinessListingController::class, 'businessListing'])->name('vCard.business-listing');
     Route::get('/user/business-listing-register', [BusinessListingController::class, 'businessRegister'])->name('vCard.business-listing-register');
     Route::get('/user/save-listing', [BusinessListingController::class, 'saveBusiness'])->name('vCard.business-save');
     Route::post('/user/listing-delete/{id}', [BusinessListingController::class, 'listingDelete'])->name('vCard.listing-delete');
     Route::post('/user/Savelisting-delete/{id}', [BusinessListingController::class, 'SavelistingDelete'])->name('vCard.Savelisting-delete');
     Route::get('/user/listing-edit/{id}', [BusinessListingController::class, 'listingEdit'])->name('vCard.listing-edit');
     Route::put('/user/listing-update/{id}', [BusinessListingController::class, 'listingUpdate'])->name('vCard.listing-update');
     ##------------------------- END ---------------------##

     ##------------------------- Dashboard Review data ---------------------##
     Route::get('user/rating', [listingReviewController::class, 'Rating'])->name('vCard.Rating');
     ##------------------------- END ---------------------##

     ##------------------------- Dashboard Report ---------------------##
     Route::get('/user/report', [ReportController::class, 'index'])->name('vCard.report');
     Route::post('/user/Report-submit', [ReportController::class, 'store'])->name('vCard.report-submit');
     Route::get('/user/list', [ReportController::class, 'list'])->name('vCard.report-list');
     ##------------------------- END ---------------------##
  ##------------------------- Vcard Stripe Integrate ---------------------##
     Route::get('/user/paymentHistory', [PlanController::class, 'paymentHistory'])->name('vCard.paymentHistory');
     Route::get('/user/ActivePlan', [PlanController::class, 'plan'])->name('vCard.plan');

 });
    Route::get('/user/MembershipPlan', [PlanController::class, 'planDetails'])->name('vCard.planDetails');
    Route::post('plan/stripe-checkout', [PlanController::class, 'stripeCheckout'])->name('vcard.stripeCheckout');
    Route::get('plan/payment-success', [PlanController::class, 'paymentSuccess'])->name('vcard.paymentSuccess');
    Route::get('plan/payment-cancel', [PlanController::class, 'paymentCancel'])->name('vcard.paymentCancel');
    ##------------------------- END ---------------------##
  });


  // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<    End yellowPages user Side   >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>



  // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<    Start yellowPages Admin Side   >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


    ##------------------------- Admin Auth---------------------##
    Route::group(['middleware' => 'admin.guest'], function(){
    Route::get('/admin/login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('/admin/authenticate', [AuthController::class, 'authenticate'])->name('admin.authenticate');
    });
    ##------------------------- END ---------------------##

    ##------------------------- Admin Dashboard ---------------------##
    Route::group(['middleware' => 'admin.auth'], function(){
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

     #this route is use for admin users
     Route::get('admin/user-listing', [AdminController::class, 'userListing'])->name('admin.user-listing');
     Route::get('admin/user-register', [AdminController::class, 'userRegister'])->name('admin.user-register');
     Route::post('admin/users-store', [AdminController::class, 'userStore'])->name('admin.users-store');
     Route::post('admin/users-delete/{id}', [AdminController::class, 'userDelete'])->name('admin.users-delete');
     Route::get('admin/user-edit/{id}', [AdminController::class, 'userEdit'])->name('admin.user-edit');
     Route::put('admin/user-update/{id}', [AdminController::class, 'userUpdate'])->name('admin.user-update');

     #this route is use for admin cities
     Route::get('admin/cities-listing', [CitiesController::class, 'citiesListing'])->name('admin.cities-listing');
     Route::get('admin/cities-register', [CitiesController::class, 'citiesRegister'])->name('admin.cities-register');
     Route::post('admin/cities-store', [CitiesController::class, 'citiesStore'])->name('admin.cities-store');
     Route::post('admin/cities-delete/{id}', [CitiesController::class, 'citiesDelete'])->name('admin.cities-delete');
     Route::get('admin/cities-edit/{id}', [CitiesController::class, 'citiesEdit'])->name('admin.cities-edit');
     Route::put('admin/cities-update/{id}', [CitiesController::class, 'citiesUpdate'])->name('admin.cities-update');

     #this route is use for admin Categories
     Route::get('admin/categories-listing', [CategoriesController::class, 'categoriesListing'])->name('admin.categories-listing');
     Route::get('admin/categories-register', [CategoriesController::class, 'categoriesRegister'])->name('admin.categories-register');
     Route::post('admin/categories-store', [CategoriesController::class, 'categoriesStore'])->name('admin.categories-store');
     Route::post('admin/categories-delete/{id}', [CategoriesController::class, 'categoriesDelete'])->name('admin.categories-delete');
     Route::get('admin/categories-edit/{id}', [CategoriesController::class, 'categoriesEdit'])->name('admin.categories-edit');
     Route::put('admin/categories-update/{id}', [CategoriesController::class, 'categoriesUpdate'])->name('admin.categories-update');

      #this route is use for admin Categories
     Route::get('admin/business-listing', [BusinessController::class, 'businessListing'])->name('admin.business-listing');
     Route::post('admin/listing-delete/{id}', [BusinessController::class, 'listingDelete'])->name('admin.listing-delete');
     Route::get('admin/listing-edit/{id}', [BusinessController::class, 'listingEdit'])->name('admin.listing-edit');
     Route::put('admin/listing-update/{id}', [BusinessController::class, 'listingUpdate'])->name('admin.listing-update');
    });

     #this route is use for admin paymnet details
     Route::get('admin/paymentHistory', [PaymentController::class, 'paymentHistory'])->name('admin.paymentHistory');
     Route::get('admin/purchasePlan', [PaymentController::class, 'purachsePlan'])->name('admin.purachsePlan');

     #this route is use for admin Rating details
     Route::get('admin/Rating', [RatingController::class, 'Rating'])->name('admin.Rating');


     #this route is use for admin Rating details
     Route::get('admin/Report', [ManageReportController::class, 'Report'])->name('admin.Report');
     Route::post('admin/reports/status/{id}', [ManageReportController::class, 'updateStatus'])->name('admin.Reportstatus');

    #this route is use for admin Vcard details
     Route::get('admin/vcard-list', [CardController::class, 'VcardList'])->name('admin.Vcardlist');
     Route::get('admin/vcard-edit/{id}', [CardController::class, 'vcardEdit'])->name('admin.vcard-edit');
     Route::post('admin/vcard-delete/{id}', [CardController::class, 'vcarddelete'])->name('admin.vcard-delete');
     Route::put('admin/vcard-update/{id}', [CardController::class, 'vcardUpdate'])->name('admin.update');
    ##------------------------------------------ END -----------------------------------##

    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<    End yellowPages Admin Side   >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<   Start yellowPages Checker Side   >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    Route::get('checker/listing', [CheckerController::class, 'CheckListing'])->name('checker.listing');
    Route::get('checker/listing-approve/{id}', [CheckerController::class, 'approveListing'])->name('checker.listing-approve');
    Route::put('checker/listing-approve-status/{id}', [CheckerController::class, 'approveListingStatus'])->name('checker.listing-approval-status');


    Route::get('checker/card', [CheckerController::class, 'CheckCard'])->name('checker.card');
    Route::get('checker/card-approve/{id}', [CheckerController::class, 'approveCard'])->name('checker.Card-approve');
    Route::put('checker/card-approve-status/{id}', [CheckerController::class, 'approveCardStatus'])->name('checker.Card-approval-status');

    Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');

    // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<    End yellowPages Checker Side   >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    Route::get('/{city_arr}/{slug}', [CreateVCardController::class, 'view'])->name('vCard.view');

    Route::get('/{city_arr}/{slug}', [CreateVCardController::class, 'cardView'])->name('cardView.view');

   Route::get('{city_name}', [ListingController::class, 'showByCity'])->name('city.show');
    Route::get('{category}/{city}', [ListingController::class, 'index'])->name('yp.listing');
   
   Route::get('{city_slug}/{listing_title}/{listing_id}', [ListingController::class, 'listing'])->name('yp.listing-details');

  ##------------------------- NewCard ---------------------##


  ##------------------------- END ---------------------##
   
});
