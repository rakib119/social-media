<?php

use App\Http\Controllers\AamarPayController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\DashboardControllers\InfoController;
use App\Http\Controllers\DashboardControllers\PermissionController;
use App\Http\Controllers\DashboardControllers\social_media\NotificationController;
use App\Http\Controllers\DashboardControllers\BankAccountController;
use App\Http\Controllers\DashboardControllers\BankManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\socialMedia\PackagePurchaseController;
use App\Http\Controllers\socialMedia\SocialMediaController;
use App\Http\Controllers\socialMedia\UserInfoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::post('/signup/validate', [OtpController::class, 'validate_signup'])->name('signup.validate');
Route::get('/verify/otp', [OtpController::class, 'verify_otp'])->name('verify.otp');
Route::post('/validate/otp', [OtpController::class, 'validate_otp'])->name('validate.otp');
Route::post('/resend/otp', [OtpController::class, 'otp_resend'])->name('otp.resend');
Route::post('/send-email-otp', [OtpController::class, 'sendEmailOtp'])->name('send_email.otp');
Route::post('/verify-email-otp', [OtpController::class, 'verifyEmailOtp'])->name('verify_email.otp');
Route::post('/send-phone-otp', [OtpController::class, 'sendPhoneOtp'])->name('send_phone.otp');

Route::post('/verify-phone-otp', [OtpController::class, 'verifyPhoneOtp'])->name('verify_phone.otp');

Route::post('send/reset/otp', [ForgotPasswordController::class, 'sendResetOtp'])->name('send_reset_otp');
Route::get('password/verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.verify-otp');
Route::post('password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp.submit');
Route::get('reset/password/{id}', [ForgotPasswordController::class, 'showResetForm'])->name('reset.password.form');
Route::post('reset/password/{id}', [ForgotPasswordController::class, 'resetPassword'])->name('confirm.password.reset.submit');

Route::post('/register/step1', [RegisterController::class, 'step1'])->name('register.step1');
Route::post('/register/step2', [RegisterController::class, 'step2'])->name('register.step2');
Route::post('/register/step3', [RegisterController::class, 'step3'])->name('register.step3');
Route::post('/register/step4', [RegisterController::class, 'step4'])->name('register.step4');
Route::post('/register/step5', [RegisterController::class, 'step5'])->name('register.step5');

Route::controller(HomeController::class)->group(function(){
    Route::get('/notice', 'notice')->name('notice');
});

// HOME PAGE MANAGEMENT ROUTES
Route::middleware(['auth','RoutePermission'])->group(function () {

    Route::controller(BackendController::class)->prefix('admin')->group(function(){
        Route::get('/', 'dashboard')->name('dashboard');
    });
    Route::get('user/list',[BackendController::class, 'user_list'])->name('user.list');
    Route::get('user/details/{id}',[UserInfoController::class, 'user_details'])->name('user.details');
    //USER INFO
    Route::get('user/info/list', [BackendController::class, 'user_list'])->name('userInfoList');
    Route::put('user/info/verify', [UserInfoController::class, 'user_verify'])->name('userInfoVerify');
    Route::put('user/info/reject', [UserInfoController::class, 'user_reject'])->name('userInfoReject');

    //Settings
    Route::resource('info-setup', InfoController::class)->only('index','edit','update');
    Route::put('info-setup/photo/update/{id}',[InfoController::class, 'image_update'])->name('info-setup.photo-update');
    Route::post('info-setup/published',[InfoController::class, 'published'])->name('info-setup.publish');
    Route::post('ckeditor/upload', [InfoController::class, 'uploadCkFile'])->name('ckeditor.upload');

    //Package Purchase History
    Route::get('/package/purchase/history', [PackagePurchaseController::class, 'package_purchage_history'])->name('packagePurchage.history');
    Route::get('/package/purchase/details/{id}', [PackagePurchaseController::class, 'package_purchage_details'])->name('packagePurchage.details');
    Route::post('/package/purchase/status/update/{id}', [PackagePurchaseController::class, 'update_purchage_status'])->name('packagePurchage.status-update');
    Route::get('/package/purchase/invoice/{id}', [PackagePurchaseController::class, 'generatePDF'])->name('packagePurchase.invoice');

    //Bank Management
    Route::resource('bank', BankManagementController::class);
    Route::resource('bank-account', BankAccountController::class);

    //NOTIFICATION
    Route::resource('notification', NotificationController::class);
});

Route::middleware(['auth'])->group(function ()
{
    Route::resource('permission', PermissionController::class)->only('index','store','edit','update');
    Route::post('select-options', [PermissionController::class, 'get_options'])->name('permission.getOptions');
    Route::post('get-role', [PermissionController::class, 'get_role'])->name('permission.getRole');
    Route::post('update-role', [PermissionController::class, 'update_role'])->name('role.update');


    // Aamar Pay Route
    Route::get('payment/online',[AamarPayController::class,'payment'])->name('pay.online');
    Route::get('renewal-fees/{id}',[AamarPayController::class, 'submitRenewalFees'])->name('pay.renewal_fees');


});
Route::middleware(['web'])->group(function () {
    //without verify csf use this route
    Route::post('payment/success',[AamarPayController::class,'success'])->name('pay.success');
    Route::post('payment/fail',[AamarPayController::class,'fail'])->name('pay.fail');
    Route::get('payment/cancel',[AamarPayController::class,'cancel'])->name('pay.cancel');
});
// Social Media Route
Route::middleware(['auth'])->group(function () {
    Route::get('/',[SocialMediaController::class, 'social_home'])->name('home');
    Route::get('/my-account',[SocialMediaController::class, 'my_account'])->name('social.myAccount');
    Route::get('/profile/{slug?}',[SocialMediaController::class, 'social_profile'])->name('social.profile');
    Route::post('/upload-photo',[SocialMediaController::class, 'upload_photo'])->name('social.upload_photo');
    Route::post('/submit-step/{step}', [UserInfoController::class, 'submitStep'])->name('submitStep');
    Route::get('/load-step/{step}', [UserInfoController::class, 'loadStep'])->name('loadStep');

    Route::get('/verify-account',[UserInfoController::class, 'myInfo'])->name('social.myInfo');
    Route::get('/load-division', [UserInfoController::class, 'loadDivision'])->name('loadDivision');
    Route::get('/load-district', [UserInfoController::class, 'loadDistrict'])->name('loadDistrict');
    Route::get('/load-upazila', [UserInfoController::class, 'loadUpazila'])->name('loadUpazila');
    Route::get('/generate-pdf/{id}', [UserInfoController::class, 'generatePDF'])->name('generatePDF');


    Route::get('/make-payment',[PackagePurchaseController::class, 'make_payment'])->name('social.makePayment');
    Route::get('/upgrade-to-premium',[PackagePurchaseController::class, 'upgrade_to_premium'])->name('social.upgrade');
    Route::get('/pay-renewal-fees',[PackagePurchaseController::class, 'pay_renewal_fees'])->name('social.pay_renewal_fees');
    Route::get('/offile-renewal-fees/{id}',[PackagePurchaseController::class, 'offline_renewal_fees'])->name('social.offline_renewal_fees');
    Route::get('/choose-plan/{id}',[PackagePurchaseController::class, 'choose_plane'])->name('social.choose_plane');
    Route::get('/load-package-subtotal',[PackagePurchaseController::class, 'load_package_subtotal'])->name('social.load_subtotal');
    Route::get('/load-payment-method',[PackagePurchaseController::class, 'load_payment_method'])->name('social.load_payment_method');
    Route::get('/load-bank-name', [PackagePurchaseController::class, 'loadBankName'])->name('loadBankName');
    Route::get('/load-bank-dtls', [PackagePurchaseController::class, 'loadBankDtls'])->name('loadBankDtls');
    Route::get('/load-dropdown-company-bank', [PackagePurchaseController::class, 'loadDropdownCompanyBank'])->name('loadDropdownCompanyBank');
    Route::post('/submit-payment', [PackagePurchaseController::class, 'submitPayment'])->name('submitManualPayment');
    Route::post('/submit-payment-v2', [PackagePurchaseController::class, 'submitPaymentV2'])->name('submitManualPaymentV2');
    Route::post('/submit-renewal-fees', [PackagePurchaseController::class, 'submitRenewalFees'])->name('submitRenewalFees');

    Route::get('/get-notifications', [NotificationController::class, 'get_notifications'])->name('get_notifications');
    Route::get('/read-notification', [NotificationController::class, 'read_notification'])->name('read_notification');

});
