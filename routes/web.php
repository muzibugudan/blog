<?php

//前台路由
Route::get('index','Home\IndexController@index');
Route::get('lists/{id}','Home\IndexController@lists');
Route::get('detail/{id}','Home\IndexController@detail');
Route::post('collect','Home\IndexController@collect');

// 登录
Route::get('login','Home\LoginController@login');
Route::post('dologin','Home\LoginController@doLogin');
Route::get('loginout','Home\LoginController@loginOut');

//手机注册页路由
Route::get('phoneregister','Home\RegisterController@phoneReg');
// 邮箱注册页
Route::get('emailregister','Home\RegisterController@register');
// 邮箱激活页
Route::get('doregister','Home\RegisterController@doRegister');
// 发送验证码
Route::get('sendcode','Home\RegisterController@sendCode');
// 注册账号
Route::post('dophoneregister','Home\RegisterController@doPhoneRegister');



Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
//后台登录路由
    Route::get('login','LoginController@login');
//验证码
    Route::get('code','LoginController@code');
//加密算法
    Route::get('jiami','LoginController@jiami');
//错误验证提示
    Route::post('dologin','LoginController@doLogin');
});

Route::get('noaccess','Admin\LoginController@noaccess');

//,'hasRole'
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['isLogin']],function(){
//后台首页
    Route::get('index','LoginController@index');
//后台欢迎页
    Route::get('welcome','LoginController@welcome');
//退出登录
    Route::get('logout','LoginController@logout');
//    用户模块相关路由
    Route::get('user/del','UserController@delAll');
    Route::resource('user','UserController');
//    用户角色路由
    Route::get('user/auth/{id}','UserController@auth');
    Route::post('user/doauth','UserController@doAuth');

//    角色模块
    // 角色授权路由
    Route::get('role/auth/{id}','RoleController@auth');
    Route::post('role/doauth','RoleController@doAuth');
    Route::resource('role','RoleController');
//    权限路由
    Route::resource('permission','PermissionController');

//    分类路由
    Route::resource('cate','CateController');
//    修改排序
    Route::post('cate/changeOrder','CateController@changeOrder');
//    文章路由
    Route::resource('article','ArticleController');
//    文章上传路由
    Route::post('article/upload','ArticleController@upload');


//    网站配置模块路由
    Route::post('config/changecontent','ConfigController@changeContent');
    Route::get('config/putcontent','ConfigController@putContent');
    Route::resource('config','ConfigController');
});


