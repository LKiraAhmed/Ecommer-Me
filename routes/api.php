<?php

use App\Http\Controllers\Admins\LoginController;
use App\Http\Controllers\Admins\LogoutController;
use App\Http\Controllers\Admins\RegisterController;
use App\Http\Controllers\Admins\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Auth\LogoutController as AuthLogoutController;
use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;
use App\Http\Controllers\Auth\ResetPasswordController as AuthResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Products\ShowProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('admins')->group(function () {
    Route::post('/login',[LoginController::class,'login']);
    Route::post('/logout',[LogoutController::class,'logout']);
    Route::post('/Register',[RegisterController::class,'create']);
    Route::post('/Reset',[ResetPasswordController::class,'index']);
});


Route::prefix('auth')->group(function () {
    Route::post('/login',[AuthLoginController::class,'login']);
    Route::post('/logout',[AuthLogoutController::class,'logout']);
    Route::post('/Register',[AuthRegisterController::class,'create']);
    Route::post('/Reset',[AuthResetPasswordController::class,'index']);
});


Route::get('products/Show', [ShowProductController::class, 'show']);
Route::get('review/Show', ['Review\ShowReviewController@showAll']);
Route::get('review/Show', ['Review\ShowReviewController@showAll']);
Route::get('review/Show', ['Review\ShowReviewController@showAll']);

Route::prefix('search')->group(function () {
    Route::post('/SearchProduct', ['Search\SearchController@search']);
});
Route::middleware(['JwtMiddleware'])->group(function () {

    Route::prefix('address')->group(function () {
        Route::post('/Create', ['Addresse\AddAddresseController@store']);
        Route::post('/Delete', ['Addresse\DeleteAddresseController@destroy']);
        Route::post('/Edit', ['Addresse\EditAddresseController@update']);
        Route::get('/Show', ['Addresse\ShowAddresseController@index']);
    });

    Route::prefix('carts')->group(function () {
        Route::post('/Create', ['Carts\AddCartController@addcart']);
        Route::post('/Delete', ['Carts\RemoveCartController@destroy']);
        Route::post('/Edit', ['Carts\EditCartController@update']);
        Route::get('/Show', ['Carts\ShowCartController@show']);
    });

    Route::prefix('categorie')->group(function () {
        Route::post('/Create', ['Categorie\AddCategorieController@store']);
        Route::post('/Delete', ['Categorie\RemoveCategorieController@destroy']);
        Route::post('/Edit', ['Categorie\EditCategorieController@update']);
        Route::get('/Show', ['Categorie\ShowCategorieController@index']);
    });

    Route::prefix('chat')->group(function () {
        Route::post('/admin', ['Chat\ChatController@adminChats']);
        Route::post('/start', ['Chat\ChatController@startChat']);
    });

    Route::prefix('coupon')->group(function () {
        Route::post('/Create', ['Coupon\AddCouponController@store']);
        Route::post('/Delete', ['Coupon\RemoveCouponController@destroy']);
        Route::post('/Edit', ['Coupon\EditCouponController@update']);
        Route::get('/Show', ['Coupon\ShowCouponController@index']);
    });

    Route::prefix('message')->group(function () {
        Route::post('/sendMessage', ['Message\MessageController@sendMessage']);
        Route::post('/chatMessages', ['Message\MessageController@chatMessages']);
        Route::post('/markAsRead', ['Message\MessageController@markAsRead']);
    });

    Route::prefix('order-item')->group(function () {
        Route::post('/Create', ['order_item\AddOrderItemController@store']);
        Route::post('/Delete', ['order_item\RemoveeOrderItemController@destroy']);
        Route::post('/Edit', ['order_item\EditOrderItemController@update']);
        Route::get('/Showindex', ['order_item\ShowOrderItemController@index']);
        Route::get('/Show', ['order_item\ShowOrderItemController@show']);
    });

    Route::prefix('orders')->group(function () {
        Route::post('/Create', ['Orders\AddOrderController@store']);
        Route::post('/Delete', ['Orders\RemoveOrderController@destroy']);
        Route::post('/Edit', ['Orders\EditOrderController@update']);
        Route::get('/Show', ['Orders\ShowOrderController@index']);
    });

    Route::prefix('product-comment')->group(function () {
        Route::post('/Create', ['product_comment\AddProductCommentController@store']);
        Route::post('/Delete', ['product_comment\DeleteProductCommentController@destroy']);
        Route::post('/Edit', ['product_comment\EditProductCommentController@update']);
        Route::get('/Showindex', ['product_comment\ShowProductCommentController@index']);
        Route::get('/Show', ['product_comment\ShowProductCommentController@show']);
    });

    Route::prefix('products')->group(function () {
        Route::post('/Create', ['Products\AddProductController@store']);
        Route::post('/Delete', ['Products\DeleteProductController@destroy']);
        Route::post('/Edit', ['Products\EditProductController@update']);
        Route::post('/Show', ['Products\ShowProductController@show']);
    });

    Route::prefix('refund')->group(function () {
        Route::post('/Create', ['Refund\AddRefundController@store']);
        Route::post('/Delete', ['Refund\DeleteRefundController@destroy']);
        Route::post('/Edit', ['Refund\EditRefundController@update']);
        Route::get('/Show', ['Refund\ShowRefundController@show']);
        Route::get('/ShowOne', ['Refund\ShowRefundController@showOne']);
    });

    Route::prefix('review')->group(function () {
        Route::post('/Create', ['Review\AddReviewController@store']);
        Route::post('/Delete', ['Review\DeleteReviewController@destroy']);
        Route::post('/Edit', ['Review\EditReviewController@update']);
        Route::post('/showAll', ['Review\ShowReviewController@showAll']);
        Route::post('/show', ['Review\ShowReviewController@show']);
        Route::post('/productReviews', ['Review\ShowReviewController@productReviews']);
    });


    Route::prefix('shipment')->group(function () {
        Route::post('/Create', ['Shipment\AddShipmentController@store']);
        Route::post('/Delete', ['Shipment\DeleteShipmentController@destroy']);
        Route::post('/Edit', ['Shipment\EditShipmentController@update']);
        Route::get('/Show/index', ['Shipment\ShowShipmentController@index']);
        Route::get('/ShowAll', ['Shipment\ShowShipmentController@showAll']);
        Route::get('/Show', ['Shipment\ShowShipmentController@show']);

    });

    Route::prefix('stock-management')->group(function () {
        Route::post('/Create', ['StockManagement\AddStockController@store']);
        Route::post('/Delete', ['StockManagement\DeleteStockController@destroy']);
        Route::post('/Edit', ['StockManagement\EditStockController@update']);
        Route::get('/Show/index', ['StockManagement\ShowStockController@index']);
        Route::get('/Show', ['StockManagement\ShowStockController@show']);
    });

    Route::prefix('support-ticket')->group(function () {
        Route::post('/Create', ['SupportTicket\AddSupportTicketController@store']);
        Route::post('/Delete', ['SupportTicket\DeleteSupportTicketController@destroy']);
        Route::post('/Edit', ['SupportTicket\EditSupportTicketController@update']);
        Route::get('/Show/index', ['SupportTicket\ShowSupportTicketController@index']);
        Route::get('/Show', ['SupportTicket\ShowSupportTicketController@@show']);
    });

    Route::prefix('support-ticket-reply')->group(function () {
        Route::post('/Create', ['SupportTicketReply\AddSupportTicketReplyController@store']);
        Route::post('/Delete', ['SupportTicketReply\DeleteSupportTicketReplyController@destroy']);
        Route::post('/Edit', ['SupportTicketReply\EditSupportTicketReplyController@update']);
        Route::get('/Show/index', ['SupportTicketReply\ShowSupportTicketReplyController@index']);
        Route::get('/Show', ['SupportTicketReply\ShowSupportTicketReplyController@show']);
    });

    Route::prefix('transaction-history')->group(function () {
        Route::post('/Create', ['TransactionHistory\AddTransactionController@store']);
        Route::post('/Delete', ['TransactionHistory\DeleteTransactionController@destroy']);
        Route::post('/Edit', ['TransactionHistory\EditTransactionController@update']);
        Route::get('/Show/index', ['TransactionHistory\ShowTransactionController@index']);
        Route::get('/Show', ['TransactionHistory\ShowTransactionController@show']);
    });

    Route::prefix('wishlist')->group(function () {
        Route::post('/Create', ['Wishlist\AddWishlistController@store']);
        Route::post('/Delete', ['Wishlist\RemoveWishlistController@destroy']);
        Route::post('/Edit', ['Wishlist\EditWishlistController@update']);
        Route::get('/Show', ['Wishlist\ShowWishlistController@index']);
    });
});
