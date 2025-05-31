<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/setting', [SettingController::class, 'showSettings'])->name('showSettings');
    Route::post('/setting/update', [SettingController::class, 'updateSettings'])->name('settings.update');

    Route::get('/contents/create', [ContentController::class, 'create'])->name('contents.create');
    Route::get('/contents/export', [ContentController::class, 'export'])->name('contents.export');
    Route::get('/contents', [ContentController::class, 'showContent'])->name('contents.index');
    Route::get('/contents/{id}', [ContentController::class, 'showContentById'])->name('contents.show');
    Route::post('/contents', [ContentController::class, 'store'])->name('contents.store');
    Route::post('/contents/{id}/update', [ContentController::class, 'updateContent'])->name('contents.update');
    Route::delete('/contents/{content}', [ContentController::class, 'destroy'])->name('contents.destroy');

    Route::group(['prefix' => 'email'], function () {
        Route::get('/', [EmailController::class, 'getAll']);
        Route::get('/receiver', [EmailController::class, 'getEmailByReceiver']);
        Route::post('/create', [EmailController::class, 'create'])->name('email.create');
    });

});
