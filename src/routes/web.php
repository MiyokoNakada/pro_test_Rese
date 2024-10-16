<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopManagerController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\PaymentController;



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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ShopController::class, 'index']);
    Route::get('/sort', [ShopController::class, 'sort']);
    Route::get('/search', [ShopController::class, 'search']);
    Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

    Route::post('/done', [BookingController::class, 'bookingDone']);
    Route::get('/booking_change', [BookingController::class, 'bookingChange']);
    Route::post('/booking_update', [BookingController::class, 'bookingUpdate']);
    Route::post('/booking_delete', [BookingController::class, 'bookingDelete']);

    Route::get('/mypage', [MypageController::class, 'mypage']);
    Route::post('/favourite', [MypageController::class, 'favourite']);
    Route::post('/unfavourite', [MypageController::class, 'unfavourite']);

    Route::get('/rating', [RatingController::class, 'showRating']);
    Route::post('/rating', [RatingController::class, 'rating']);
    Route::get('/rating/edit/{rating_id}', [RatingController::class, 'editRating']);
    Route::post('/rating/edit', [RatingController::class, 'updateRating']);
    Route::delete('/rating/delete/{rating_id}', [RatingController::class, 'deleteRating']);
    Route::get('/rating/all_reviews/{shop_id}', [RatingController::class, 'allReviews']);
    Route::delete('/rating/all_reviews/admin_delete', [RatingController::class, 'deleteReviews']);

    Route::get('/payment', [PaymentController::class, 'paymentPage']);
    Route::post('/payment', [PaymentController::class, 'payment']);

    Route::group(['middleware' => ['auth', 'can:admin']], function () {
        Route::get('/admin', [AdminController::class, 'admin']);
        Route::post('/admin/add_manager', [AdminController::class, 'addManager']);
        Route::post('/admin/send_email', [AdminController::class, 'sendEmail']);
    });

    Route::group(['middleware' => ['auth', 'can:shop_manager']], function () {
        Route::get('/shop_manager', [ShopManagerController::class, 'shopManager']);
        Route::post('/shop_manager/create', [ShopManagerController::class, 'createShop']);
        Route::post('/shop_manager/csv_import', [ShopManagerController::class, 'importCsv']);
        Route::get('/shop_manager/update_detail', [ShopManagerController::class, 'showShopDetail']);
        Route::post('/shop_manager/update_detail', [ShopManagerController::class, 'updateShopDetail']);
        Route::get('/shop_manager/booking_detail', [ShopManagerController::class, 'bookingDetail']);
        Route::post('/shop_manager/booking_detail', [ShopManagerController::class, 'storeVisit']);
        Route::post('/shop_manager/payment_amount', [PaymentController::class, 'setAmount']);
    });

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/thanks', [AuthController::class, 'thanks']);


