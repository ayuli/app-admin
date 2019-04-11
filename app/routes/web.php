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

//后台管理员登录
Route::get('adminLogin',"Admin\LoginController@adminLogin");//登录页面
Route::get('codeImg/{tmp}',"Admin\LoginController@codeImg");//验证码
Route::post('adminLoginDo',"Admin\LoginController@adminLoginDo");//登录执行


//后台管理员管理
Route::get('adminAdd',"Admin\AdminController@adminAdd");//管理员添加
Route::post('adminInsert',"Admin\AdminController@adminInsert");//执行添加
Route::get('adminList',"Admin\AdminController@adminList");//管理员展示
Route::post('adminDel',"Admin\AdminController@adminDel");//管理员删除
Route::get('adminUpdate',"Admin\AdminController@adminUpdate");//管理员修改页面
Route::post('adminUpdataDo',"Admin\AdminController@adminUpdataDo");//管理员执行修改
//后台商品管理
Route::get('/brand',"Admin\BrandController@brand");     //品牌添加页面
Route::get('/brandget',"Admin\BrandController@brandGet");   //品牌展示
Route::post('/brandadd',"Admin\BrandController@brandAdd");   //品牌添加
Route::post('/branddel',"Admin\BrandController@brandDel");   //品牌假删
Route::get('/brandupda',"Admin\BrandController@brandUpda");   //品牌修改展示
Route::post('/brandupdado',"Admin\BrandController@brandUpdaDo");   //品牌修改执行
Route::post('/brandlogo',"Admin\BrandController@brandLogo");   //品牌logo上传
//个人中心
Route::get('/userCenter',"Index\UserController@userCenter");
//收货地址
Route::get('/getregion',"Index\AddressController@getregion");


