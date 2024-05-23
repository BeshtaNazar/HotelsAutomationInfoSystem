<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReservationController;


Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('search-result', [SearchController::class, 'searchResultView'])->name('search.result');
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::middleware("guest")->group(function () {
    Route::get('register', [UserController::class, 'registerView']);
    Route::get('login', [UserController::class, 'loginView'])->name('login.view');
    Route::get('forgot-password', [UserController::class, 'forgotPasswordView'])->name('forgot.password.view');
    Route::get('password/reset/{token}', [UserController::class, 'resetPasswordView'])->name('reset.password.view');
    Route::post('password/reset', [UserController::class, 'resetPassword'])->name('reset.password');
    Route::post('forgot-password', [UserController::class, 'sendResetLink'])->name('forgot.password.link');
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
});
Route::middleware('hotelActive')->group(function () {
    Route::prefix('hotel/{hotelName}')->group(function () {
        Route::get('index', [HotelController::class, 'show'])->name('hotel.show');
        Route::get('rooms/index', [RoomController::class, 'show'])->name('rooms.show');
        Route::get('rooms/available', [RoomController::class, 'showAvailableRooms'])->name('rooms.show.available');
    });
});
Route::middleware("auth")->group(function () {
    Route::prefix('reservation')->group(function () {
        Route::get('create', [ReservationController::class, 'create'])->name('reservation.create');
        Route::post('store', [ReservationController::class, 'store'])->name('reservation.store');
        Route::put('cancel/{reservation}', [ReservationController::class, 'cancel'])->name('reservation.cancel')->middleware('reservationOwnership');
    });
    Route::prefix('account')->group(function () {
        Route::get('profile', [UserController::class, 'show']);
        Route::get('reservations', [UserController::class, 'showReservations'])->name('account.reservations');
        Route::patch('update', [UserController::class, 'update']);
        Route::patch('change-password', [UserController::class, 'change_password']);

    });
    Route::prefix('hotel')->group(function () {
        Route::get('list', [HotelController::class, 'listView'])->name('hotel.list');
        Route::get('create', [HotelController::class, 'createView'])->name('hotel.create');
        Route::post('create', [HotelController::class, 'store'])->name('hotel.store');
        Route::get('manage', [HotelController::class, 'manageView'])->name('hotel.manage');
        Route::middleware(["admin"])->group(function () {
            Route::get("requests", [HotelController::class, 'requestsView'])->name('hotel.requests');
        });
        Route::prefix('{hotelName}')->group(function () {
            Route::middleware("hotelOwnership")->group(function () {
                Route::get('preview', [HotelController::class, 'show'])->name('hotel.preview');
                Route::get('edit', [HotelController::class, 'createView'])->name('hotel.edit');
                Route::get('upload/photo', [HotelController::class, 'uploadPhotoView'])->name('hotel.upload.photo');
                Route::post('upload/photo', [HotelController::class, 'uploadPhotoStore'])->name('hotel.upload.photo.store');
                Route::get('list-confirm', [HotelController::class, 'listConfirm'])->name('hotel.list.confirm');
                Route::get('approve', [HotelController::class, 'approve'])->middleware('admin')->name('hotel.approve');
                Route::get('reservations', [HotelController::class, 'showReservations'])->name('hotel.reservations');
                Route::prefix('rooms')->group(function () {
                    Route::get('preview', [RoomController::class, 'show'])->name('rooms.preview');
                    Route::post('preview', [RoomController::class, 'showAvailableRooms'])->name('rooms.preview.available');
                    Route::get('list', [RoomController::class, 'listView'])->name('room.list');
                    Route::get('create', [RoomController::class, 'createView'])->name('room.create');
                    Route::post('create', [RoomController::class, 'store'])->name('room.store');
                    Route::get('edit/{room}', [RoomController::class, 'createView'])->name('room.edit');
                });
            });
        });
    });
    Route::prefix('update')->group(function () {
        Route::put('hotel/{hotel}', [HotelController::class, 'update'])->middleware('hotelOwnership')->name('hotel.update');
        Route::put('room/{room}', [RoomController::class, 'update'])->middleware('roomOwnership')->name('room.update');
    });
    Route::prefix('delete')->group(function () {
        Route::middleware("hotelOwnership")->group(function () {
            Route::delete('hotel/{hotel}', [HotelController::class, 'delete'])->name('hotel.delete');
            Route::put('hotel/{hotel}', [HotelController::class, 'deleteActive'])->name('hotel.delete.active');
        });
        Route::middleware('roomOwnership')->group(function () {
            Route::delete('room/{room}', [RoomController::class, 'delete'])->name('room.delete');
            Route::put('room/{room}', [RoomController::class, 'deleteActive'])->name('room.delete.active');
        });
    });
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});


