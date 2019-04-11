<?php

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

Route::get('index',"Admin\IndexController@index");
Route::get('/',"Admin\IndexController@index");
Route::get('main',"Admin\IndexController@main");


//后台商品管理
Route::get('/brand',"Brand\BrandController@brand");     //品牌添加页面
Route::get('/brandget',"Brand\BrandController@brandGet");   //品牌展示
Route::post('/brandadd',"Brand\BrandController@brandAdd");   //品牌添加
Route::post('/brandlogo',"Brand\BrandController@brandLogo");   //品牌logo上传