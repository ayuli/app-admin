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

//后台管理员管理
Route::get('adminAdd',"Admin\AdminController@adminAdd");//管理员添加

//后台商品管理
Route::get('/brand',"Admin\BrandController@brand");     //品牌添加页面
Route::get('/brandget',"Admin\BrandController@brandGet");   //品牌展示
Route::post('/brandadd',"Admin\BrandController@brandAdd");   //品牌添加
Route::post('/brandlogo',"Admin\BrandController@brandLogo");   //品牌logo上传

//个人中心
Route::get('/userCenter',"Index\UserController@userCenter");     //品牌添加页面