<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('home');
})->name('home');


Route::middleware("guest")->group(function () {
    Route::get('register', [UserController::class, 'registerView']);
    Route::get('login', [UserController::class, 'loginView']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
});
Route::middleware('hotelAcitve')->group(function () {
    Route::get('hotel/{hotelName}/index', [HotelController::class, 'show'])->name('hotel.show');
});
Route::middleware("auth")->group(function () {
    Route::prefix('account')->group(function () {
        Route::get('profile', [UserController::class, 'show']);
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
                Route::get('edit', [HotelController::class, 'createView'])->name('hotel.edit.new');
                Route::get('upload/photo', [HotelController::class, 'uploadPhotoView'])->name('hotel.upload.photo');
                Route::post('upload/photo', [HotelController::class, 'uploadPhotoStore'])->name('hotel.upload.photo.store');
                Route::get('list-confirm', [HotelController::class, 'listConfirm'])->name('hotel.list.confirm');
                Route::prefix('rooms')->group(function () {
                    Route::get('preview', [RoomController::class, 'show'])->name('rooms.preview');
                    Route::get('list', [RoomController::class, 'listView'])->name('room.list');
                    Route::get('create', [RoomController::class, 'createView'])->name('room.create');
                    Route::post('create', [RoomController::class, 'store'])->name('room.store');
                    Route::get('edit/{room}', [RoomController::class, 'createView'])->name('room.edit.new');
                });
            });
        });
    });
    Route::prefix('update')->group(function () {
        Route::put('hotel/{hotel}', [HotelController::class, 'update'])->middleware('hotelOwnership')->name('hotel.update');
        Route::put('room/{room}', [RoomController::class, 'update'])->middleware('roomOwnership')->name('room.update');
    });
    Route::prefix('delete')->group(function () {
        Route::delete('hotel/{hotel}', [HotelController::class, 'delete'])->middleware("hotelOwnership")->name('hotel.delete');
        Route::delete('room/{room}', [RoomController::class, 'delete'])->middleware('roomOwnership')->name('room.delete');
    });
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});


