<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\menu\MenuController;
use App\Http\Controllers\payment\PaymentController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\profile\ProfileController;
use App\Http\Controllers\voucher\VoucherController;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\calendar\CalendarController;
use App\Http\Controllers\authentications\RegisterUser;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\reservation\ReservationController;
use App\Http\Controllers\transaction\TransactionController;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\reports\ReservationReportsController;



// New created Routes



Route::get('/', [MenuController::class, 'index'])->name('home');
Route::get('/logout', [LoginBasic::class, 'logoutAccount'])->name('logout-process')->middleware(['auth']);
Route::get('/venue/details/{id}', [MenuController::class, 'viewDetails'])->name('details');
Route::post('/venue/search', [MenuController::class, 'search'])->name('search');

Route::middleware(['auth'])->group(function () {
  Route::post('/reservation/add', [ReservationController::class, 'store'])->name('reservation-add');

  Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

  Route::get('/reservation', [ProfileController::class, 'reservation'])->name('profile-reservation');

  Route::get('/vouchers-List', [VoucherController::class, 'display'])->name('vouchers-list');
  Route::post('/vouchers-List/add', [VoucherController::class, 'addVouchers'])->name('vouchers-add');
  Route::get('/My-vouchers', [VoucherController::class, 'myVouchersList'])->name('myVoucher');



  Route::post('/payment', [PaymentController::class, 'index'])->name('payment-view');
  Route::post('/payment/add', [PaymentController::class, 'payment'])->name('payment-add');
  Route::get('/payment/add/success', [PaymentController::class, 'success'])->name('payment-success');
  Route::post('/payment/receipt', [PaymentController::class, 'generateReceipt'])->name('payment.receipt');

});

Route::middleware(['guest'])->group(function () {
  Route::get('/login', [LoginBasic::class, 'index'])->name('login');
  Route::post('/login/process', [LoginBasic::class, 'login'])->name('auth-login-process')->middleware(['throttle:login']);
  Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
  Route::get('/auth/register-user', [RegisterUser::class, 'index'])->name('auth-register-user');
  Route::post('/auth/register-user/add', [RegisterUser::class, 'store'])->name('auth-register-user-add');

  Route::get('/auth/{provider}/redirect', [LoginBasic::class, 'redirect'])->name('auth.provider.redirect');
  Route::get('/auth/{provider}/callback', [LoginBasic::class, 'callback'])->name('auth.provider.callback');
});

Route::middleware(['auth', 'user-access:Admin,Employee'])->group(function () {

  Route::middleware(['role:Admin'])->group(function () {
    Route::get('admin/product', [ProductController::class, 'index'])->name('admin-product');
    Route::post('admin/product/add', [ProductController::class, 'store'])->name('admin-product-add');
    Route::post('admin/product/update', [ProductController::class, 'update'])->name('admin-product-update');
    Route::post('admin/product/delete', [ProductController::class, 'delete'])->name('admin-product-delete');
    Route::post('admin/product/filter', [ProductController::class, 'filter'])->name('admin-product-filter');

     Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
    Route::post('/auth/register-basic/add', [RegisterBasic::class, 'store'])->name('auth-register-basic-add');
    Route::post('/auth/register-basic/update', [RegisterBasic::class, 'update'])->name('auth-register-basic-update');
    Route::post('/auth/register-basic/delete', [RegisterBasic::class, 'delete'])->name('auth-register-basic-delete');
    Route::post('/auth/register-basic/search', [RegisterBasic::class, 'search'])->name('auth-register-basic-search');

    Route::get('/admin/vouchers-reports', [VoucherController::class, 'index'])->name('admin-vouchers');
    Route::post('/admin/vouchers-reports/add', [VoucherController::class, 'store'])->name('admin-vouchers-add');
    Route::post('/admin/vouchers-reports/update', [VoucherController::class, 'update'])->name('admin-vouchers-update');
    Route::post('/admin/vouchers-reports/delete', [VoucherController::class, 'delete'])->name('admin-vouchers-delete');
  });

  Route::get('admin/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');

  Route::get('/admin/reservation', [ReservationController::class, 'index'])->name('admin-reservation');

  Route::get('/admin/calendar', [CalendarController::class, 'index'])->name('admin-calendar');
  Route::get('/admin/payments', [TransactionController::class, 'index'])->name('admin-payment');

  Route::get('/reports/reservation', [ReservationReportsController::class, 'index'])->name('admin-reports');

  Route::get('/admin/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');

});
// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
