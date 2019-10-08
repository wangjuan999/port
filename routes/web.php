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
//后台
Route::get('admin/index','AdminController@index');
Route::get('admin/index_v1','AdminController@index_v1');

//登录
Route::any('admin/login','LoginController@login');
Route::any('admin/login_do','LoginController@login_do');
Route::any('admin/send','LoginController@send');
///菜单跳转地址
Route::any('login/band','LoginController@band');


//微信公众号菜单管理
Route::any('addWechatCate','WechatCateController@addWechatCate');   // 个性化生成微信菜单
Route::any('doaddcate','WechatCateController@doaddcate');   // 个性化生成微信菜单
Route::any('listWechatCate','WechatCateController@listWechatCate');   // 个性化生成微信菜单
Route::any('createwechatcate','WechatCateController@createwechatcate');   // 个性化生成微信菜单
Route::any('deletewechatcate','WechatCateController@deletewechatcate');   // 个性化生成微信菜单