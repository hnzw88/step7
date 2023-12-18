<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

//--------------------------------------------------------------------------

//商品一覧画面表示
Route::get('/products', 'App\Http\Controllers\ProductController@index') -> name('index');

//商品新規登録
Route::get('/products/create', 'App\Http\Controllers\ProductController@create') -> name('create');
Route::post('/products/store', 'App\Http\Controllers\ProductController@store') -> name('store');

//詳細表示
Route::get('/products/show/{product}', 'App\Http\Controllers\ProductController@show') -> name('show');

//編集
Route::get('/products/edit/{product}', 'App\Http\Controllers\ProductController@edit') -> name('edit');
Route::post('/products/update','App\Http\Controllers\ProductController@update') -> name('update');

//削除
Route::post('/destroyproduct/{id}','App\Http\Controllers\ProductController@destroy') -> name('destroy');

//検索機能
Route::get('/search', 'App\Http\Controllers\ProductController@search') -> name('search');