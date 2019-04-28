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

Route::get('/', function () {    //根目录 进主页    resources\views\welcome.blade.php
    return view('welcome');
});

// Route::get('/', function () {    //根目录 进静态页面   resources\views\index.blade.php
//     return view('index');  
// });

// Route::get('/','IndexController@index');  //根目录 进控制器  app\Http\Controller\ IndexController@index

// Route::get('/index','IndexController@index'); //index目录 进控制器 app\Http\Controller\IndexController@index

// Route::get('/form', function () {    //form目录 进表单页面   resources\views\index.blade.php
//     // return '<form action="/do" method="post">'.csrf_field().'<input type="text" name="name"><button>提交</button></form>';  
//       return '<form action="/do" method="post"><input type="hidden" name="_token" value='.csrf_token().'><input type="text" name="name"><button>提交</button></form>'; 
// });

// Route::post('/do','IndexController@doadd');                  //添加页 跳转 doadd  多种路由

// Route::match(['get','post'],'/do','IndexController@doadd');  //添加页 跳转 doadd  多种路由

// Route::any('do','IndexController@doadd');                    //添加页 跳转 doadd  多种路由

// Route::get('/index/{id}','IndexController@doadd');   //get传值

// Route::get('/index/{id}',function($id){           //get传值 id 变量  必选参数
// 	echo "ID=".$id;
// });  

// Route::get('/index/{id?}', 'IndexController@doadd')->where('id','\d+');      //get传值 id 变量  可选参数

// Route::prefix('goods')->group(function(){      //路由分组
// 	 Route::get('add','IndexController@add'); 
// 	 Route::get('list','IndexController@lists'); 
// 	 Route::get('exit','IndexController@exit'); 
// 	 Route::get('del','IndexController@del'); 
// });

/*路由视图*/
// Route::prefix('user')->middleware('islogin')->group(function(){
Route::prefix('user')->group(function(){
	Route::get('add',function(){           ///添加视图页
		return view('users/add');
	});
	Route::post('login','UserController@login');	//登录处理
	Route::post('send','UserController@send');      //找回密码 控制器
	Route::post('doadd','UserController@store'); 	//添加处理
	Route::get('list','UserController@index'); 		//列表页
	Route::post('checkname','UserController@checkName');             //验证name 唯一性
	Route::get('edit/{id}','UserController@edit')->name('edituser'); //编辑
	Route::post('update/{id}','UserController@update'); 			 //修改
	Route::get('destroy/{id}','UserController@destroy')->name('destroyuser');  //删除
});

/******登录**找回******/
// Route::get('/log',function(){      //找回密码视图页
// 	return view('users/log');
// });
// Route::get('/login',function(){		//登录视图页
// 	return view('users/login');
// });
Route::get('/sendSms','UserController@sendSms');		//短信验证发送

Route::get('/show/{$id}','UserController@show');		//缓存
/*设置 cookie*/
Route::get('/test',function(){
	return response('天天开心！',200)->header('X-CSRF-TOKEN',csrf_token())->cookie('class','1810',3);
});

/*获取 cookie*/
Route::get('/get',function(){
	echo request()->cookie('class');
});
/*************友情链接**************/
Route::prefix('link')->group(function(){
	Route::get('add','FriendController@create');       
	Route::post('doadd','FriendController@store');
	Route::get('list','FriendController@index');
	Route::post('checkname','FriendController@checkName');
	Route::post('checknamet','FriendController@checkNamet');
	Route::get('edit/{id}','FriendController@edit')->name('editlink');
	Route::post('update/{id}','FriendController@update'); 
	Route::get('destroy/{id}','FriendController@destroy')->name('destroylink'); 
});

/*****自动***登录***注册**********/
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

/****************商城*  mall  **********************/
Route::prefix('malls')->group(function(){
	Route::get('','MallController@index');//主页面       
	Route::get('login','MallController@login');//登录页    
	Route::post('dologin','MallController@dologin');//登录页    
	Route::get('reg','MallController@reg');//注册页 	 
	Route::post('doreg','MallController@doreg');//注册页 
	Route::post('checkname','MallController@checkName');//验证账号唯一性  
	Route::post('send','MallController@send');//验证码	 
	Route::post('checkcode','MallController@checkCode');//验证码验证

	Route::get('prolist','MallController@prolist');//全部商品页 
	Route::get('proinfo','MallController@proinfo');//商品详情页 
	Route::post('addCart','MallController@addCart');//加入购物车

	Route::get('car','MallController@car');//购物车页 
	Route::get('pay','MallController@pay');//购物车结算页	 
	Route::get('success','MallController@success');//提交订单	
	Route::get('successly','MallController@successly');//立即支付
	Route::get('returnAlipay','MallController@returnAlipay');//同步通知
	Route::post('notifyAlipay','MallController@notifyAlipay');//异步通知
	
	Route::get('user','MallController@user');//我的	 
	Route::get('order','MallController@order');//我的	 
	Route::get('quan','MallController@quan');// 我的优惠券
	Route::get('addAddress','MallController@addAddress');// 收货地址
	Route::get('address','MallController@address');// 添加收货地址
	Route::get('shoucang','MallController@shoucang');// 我的收藏
	Route::get('jilu','MallController@jilu');// 我的浏览记录
	Route::get('tixian','MallController@tixian');//提现
	
});


Route::get('/zk','ZhoukaoController@index');
Route::get('/zk/info/{id}','ZhoukaoController@info');
Route::get('/zk/edit/{id}','ZhoukaoController@edit');
Route::post('/zk/update/{id}','ZhoukaoController@update');
Route::get('/zk/del/{id}','ZhoukaoController@del');




