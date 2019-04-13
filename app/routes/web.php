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
Route::get('adminInfo',"Admin\LoginController@adminInfo");//获取用户信息


//后台管理员管理
Route::get('adminAdd',"Admin\AdminController@adminAdd");//管理员添加
Route::post('adminInsert',"Admin\AdminController@adminInsert");//执行添加
Route::get('adminList',"Admin\AdminController@adminList");//管理员展示
Route::post('adminDel',"Admin\AdminController@adminDel");//管理员删除
Route::get('adminUpdate',"Admin\AdminController@adminUpdate");//管理员修改页面
Route::post('adminUpdataDo',"Admin\AdminController@adminUpdataDo");//管理员执行修改
Route::get('roleAdd',"Admin\AdminController@roleAdd");//角色添加
Route::post('roleInsert',"Admin\AdminController@roleInsert");//角色添加
Route::get('roleList',"Admin\AdminController@roleList");//角色展示
Route::post('roleDel',"Admin\AdminController@roleDel");//角色删除
Route::get('roleUpdate',"Admin\AdminController@roleUpdate");//角色修改页面
Route::post('roleUpdateDo',"Admin\AdminController@roleUpdateDo");//角色修改页面
Route::get('roleDo',"Admin\AdminController@roleDo");//赋予角色页面
Route::post('adminrole',"Admin\AdminController@adminrole");//执行赋予角色

//后台权限管理
Route::get('nodeAdd',"Admin\AdminController@nodeAdd");//权限添加
Route::get('nodeList',"Admin\AdminController@nodeList");//权限添加
Route::post('nodeInsert',"Admin\AdminController@nodeInsert");//权限添加
Route::post('nodeDel',"Admin\AdminController@nodeDel");//权限删除
Route::get('nodeUpdate',"Admin\AdminController@nodeUpdate");//权限修改页面
Route::post('nodeUpdataDo',"Admin\AdminController@nodeUpdataDo");//权限执行修改


//后台商品管理
Route::get('/brand',"Admin\BrandController@brand");     //品牌添加页面
Route::get('/brandget',"Admin\BrandController@brandGet");   //品牌展示
Route::post('/brandadd',"Admin\BrandController@brandAdd");   //品牌添加
Route::post('/branddel',"Admin\BrandController@brandDel");   //品牌假删
Route::get('/brandupda',"Admin\BrandController@brandUpda");   //品牌修改展示
Route::post('/brandupdado',"Admin\BrandController@brandUpdaDo");   //品牌修改执行
Route::post('/brandlogo',"Admin\BrandController@brandLogo");   //品牌logo上传

//商品分类管理
Route::get('/cate',"Admin\CateController@cate");   //分类添加展示
Route::post('/cateadd',"Admin\CateController@cateAdd");   //分类添加执行
Route::get('/categet',"Admin\CateController@cateGet");   //分类展示
Route::get('/cateupda',"Admin\CateController@cateUpda");   //分类修改
Route::post('/cateupdado',"Admin\CateController@cateUpdaDo");   //分类修改执行
Route::post('/catedel',"Admin\CateController@cateDel");   //分类删除


Route::get('goodsAdd',"Admin\GoodsController@goodsAdd"); //商品添加页面
Route::post('goodsAddDo',"Admin\GoodsController@goodsAddDo"); //商品添加页面
Route::get('changeType',"Admin\GoodsController@changeType"); //选择商品类型
Route::post('goodsUpload',"Admin\GoodsController@goodsUpload"); //商品文件上传
Route::get('goodsShow',"Admin\GoodsController@goodsShow"); //商品文件上传
Route::get('goodsUpdate',"Admin\GoodsController@goodsUpdate"); //商品修改

//前台登陆
Route::post('/register',"Index\UserController@register"); //注册
Route::get('/registersole',"Index\UserController@registersole"); //注册验证唯一
Route::get('/login',"Index\UserController@login"); //登陆
Route::get('/outlogin',"Index\UserController@outlogin"); //登陆

//个人中心
Route::get('/userCenter',"Index\UserController@userCenter");   //个人中心页面展示数据
//收货地址
Route::get('/getregion',"Index\AddressController@getregion");    //三级联动
Route::get('/selregion',"Index\AddressController@selregion");    //查询三级联动
Route::post('/address',"Index\AddressController@address");   //添加收货地址
Route::post('/upaddress',"Index\AddressController@upaddress");   //修改收货地址
Route::get('/addressGet',"Index\AddressController@addressGet");   //收货地址展示

//收藏
Route::post('/collection','Index\CollController@coll'); //收藏
Route::post('/uncollection','Index\CollController@uncoll'); //取消收藏


//前台商品
Route::get('/indexgoods','Index\GoodsController@goods'); //所有商品数据展示