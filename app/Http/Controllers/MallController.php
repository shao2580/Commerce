<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMallsPost;  //验证器
// use Illuminate\Support\Facades\Auth;
use DB;
use Mail;
use Log;

class MallController extends Controller
{
	/*主页视图*/
    public function index()
    {	
    	$query = request()->all();
    	// dd($query);
        $where=[];
        $name=$query['name']??'';
        $name = implode(',',$query);
        if ($name) {
            $where[]=['goods_name','like',"%$name%"];
        }
        // dd($name);
        $pagesize=config('app.pageSize',8);
        $data= DB::table('goods')->orderBy('goods_id','desc')->where($where)->paginate($pagesize);
        // dd($data);
    	return view('malls/index',compact('data','name'));
    }
    /*登录页*/
    public function login()
    {
    	return view('malls/login');
    }
    /*登录处理页*/
    public function dologin()
    {
    	
    		$name = request()->name;
    		$password =request()->password;
    		if (!$name) {
    			return ['code'=>0,'msg'=>'账号不能为空'];
    		}
    		if (!$password) {
    			return ['code'=>0,'msg'=>'密码不能为空'];
    		}
    		 $reg1 = "/^1[345678]\d{9}$/";
             $reg2 = "/^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/";
    		if (preg_match($reg1,$name)) {
    			$userInfo =DB::table('users')->where(['name'=>$name,'password'=>$password])->get();
    			if ($userInfo) {
    				return ['code'=>1,'msg'=>'登录成功'];
    			}else{
    				return ['code'=>0,'msg'=>'登录失败'];
    			}
    		
		
    		}else if (preg_match($reg2,$name)) {
    			$userInfo =DB::table('users')->where(['name'=>$name,'password'=>$password])->get();
    			if ($userInfo) {
    				return ['code'=>1,'msg'=>'登录成功'];
    			}else{
    				return ['code'=>0,'msg'=>'登录失败'];
    			}
    		}
    }	
    
    /*注册页*/
    public function reg()
    {
    	return view('malls/reg');
    }
    /*注册处理页*/
    public function doreg()
    {
    	// $data = request()->except('_token','pwd','code');
    	$data=request()->only('name','password');
    	
    	$data['password']=md5(md5($data['password']));
    	// dd($data);
    	$res=DB::table('users')->insert($data);
    	if($res){
    		return "<script>alert('注册成功');location.href='/malls'</script>";
    	}

    }
    /*判断用户名是否存在*/
    public function checkName(){
       $name = request()->name;
        $count = DB::table('users')->where('name',$name)->count();
        if ($count) {
            return ['code'=>1,'msg'=>'账号已存在'];  
            return false;       
        }
    }

    /*验证码发送*/
    public function send(){
      	$name = request()->get('name');	
      	request()->session()->flush();  //清除上次session
      	$this->checkName(); 			//检测唯一性	
      	$reg1 = "/^1[345678]\d{9}$/";
        $reg2 = "/^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/";
      	$rand =rand(100000,999999);
      	if (preg_match($reg1,$name)) {
            // 发送手机验证码
            $code =session(['code'=>$rand]);
           $res = sendTel($name,$rand);
           
           if ($res) {
	            successly('短信发送成功，请注意查收');
           }else{
           		fail('发送失败');
           }
			// dd($res1);
        }else if (preg_match($reg2,$name)) {
		        $name = request()->name;
		        request()->session()->flush();  //清除上次session
      			$this->checkName(); 			//检测唯一性	
      			$rand =rand(100000,999999);
		        if ($name) {
		            /* emailcon 发送的内容 */
		            $code =session(['code'=>$rand]);
		           	$res =Mail::send('malls/emailcon',['rand'=>$rand],function($message)use($name){
		                $message->subject('注册账号');  //邮箱标题
		                $message->to($name);           //接收方
		            });
		           	
		            if ($res) {	            
			            successly('邮件已发送,注意查收');			            
		            }else{
		            	fail('发送失败');
		            	
		            }
		            
		        }
        }
    }
   
   	/*验证码验证*/
   	public function checkCode(){
   		$code =request()->code;

   		$session= session('code');
   		
   		if (!$code) {
   			 return ['code'=>0,'msg'=>'验证码不能为空'];
   		}
   		if ($code!==$session) {
   			return ['code'=>0,'msg'=>'验证码错误'];
   		}
   	}

    /****************************/
    /*全部商品页*/
    public function prolist()
    {	
    	$query = request()->all();
    	// dd($query);
        $where=[];
        $name=$query['name']??'';
        $name = implode(',',$query);
        if ($name) {
            $where[]=[
            	'goods_name','like',"%$name%",
            	// ['is_new','=',1]
            ];
        }
        $pagesize=config('app.pageSize',8);
    	$data = DB::table('goods')->orderBy('goods_id','desc')->where($where)->paginate($pagesize);
    	return view('malls/prolist',compact('data','name','query'));

    	

    }
    /*商品详情页*/
    public function proinfo()
    {	
    	$goods_id = request()->goods_id;
    	// dd($goods_id);
    	$data=[];
    	if ($goods_id) {
    		$data[] = DB::table('goods')->where('goods_id',$goods_id)->first();

    		// 查相册表拿图片
    		// $res = DB::table('goods_photo')->where('goods_id',$goods_id)->first('url');
    		// $data[] = array_push($data,$res);
    		// dd($data);
    		if ($data) {
    			return view('malls/proinfo',compact('data'));
    		}
    	}

    	return view('malls/proinfo');
    }
    /*加入购物车*/
    public function addCart(){
    	$goods_id =request()->goods_id;  		
    	$buy_number = request()->buy_number;
    	// dd($goods_id);
    	// dd($buy_number);
    	// 验证
    	if (empty($goods_id)) {
    		return ('请选择一件商品');
    	}
    	if (empty($buy_number)) {
    		return ('请选择购买数量');
    	}
    	/*判断是否登录*/

    	//查询数据库有没有买过

    	/*存到数据库*/
    	$info = ['goods_id'=>$goods_id,'buy_number'=>$buy_number];
    	$res = DB::table('cart')->insert($info);
    	if ($res) {
    		return ['code'=>1,'msg'=>'添加成功'];  ;
    	}
    }

    /****************************/
    /*购物车*/
    public function car()
    {
    	/*判断是否登录*/

    	// 未登录

    	// 登录
    	$data=[];
    	$data = DB::table('cart')
    			->join('goods','cart.goods_id','=','goods.goods_id')
    			->where('cart.is_del',1)
    			->orderBy('cart_id','desc')
    			->get();
    	 
    	return view('malls/car',compact('data'));
    }
     /*购物车结算*/
    public function pay()
    {
    	return view('malls/pay');
    }
     /*购物车提交订单*/
    public function success()
    {
    	return view('malls/success');
    }
    /****************************************************************************************/
    //  /*立即支付*/
    // public function successly()
    // {
    //    //$id =request()->id;
    //    $id=rand(1,27);
    //    // dd($id);
    //     $where=[
    //         'order_id'=>$id,
    //         'is_del'=>1
    //     ];
    //    $data = DB::table('order')->where($where)->first();
    //     // dump($data);

    //     $config=config('alipay');    //配置
    //     // print_r($config);exit;
    //     require_once app_path('libs/alipay/pagepay/service/AlipayTradeService.php');  
    //     require_once app_path('libs/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');

    //       //商户订单号，商户网站订单系统中唯一订单号，必填
    //         $out_trade_no = "$data->order_no";
           
    //         //订单名称，必填
    //         $subject = "支付宝支付";

    //         //付款金额，必填
    //         $total_amount = "$data->order_amount";

    //         //商品描述，可空
    //         $body = "$data->order_talk";
            
    //         //构造参数
    //         $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
    //         $payRequestBuilder->setBody($body);
    //         $payRequestBuilder->setSubject($subject);
    //         $payRequestBuilder->setTotalAmount($total_amount);
    //         $payRequestBuilder->setOutTradeNo($out_trade_no);
            
    //         $aop = new \AlipayTradeService($config);

    //         /**
    //          * pagePay 电脑网站支付请求
    //          * @param $builder 业务参数，使用buildmodel中的对象生成。
    //          * @param $return_url 同步跳转地址，公网可以访问
    //          * @param $notify_url 异步通知地址，公网可以访问
    //          * @return $response 支付宝返回的信息
    //         */
            
    //         $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
          
    //         //输出表单
    //      //   var_dump($response);
    // }

    // /*支付宝同步通知*/
    // public function returnAlipay()
    // {
    //     $config=config('alipay');    //配置
    //     require_once app_path('libs/alipay/pagepay/service/AlipayTradeService.php');

    //     $arr=$_GET;
    //     // dump($arr);
    //     $alipaySevice = new \AlipayTradeService($config); 
    //     $result = $alipaySevice->check($arr);
    //     // dd($result);

    //     /* 实际验证过程建议商户添加以下校验。
    //     1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
    //     2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
    //     3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
    //     4、验证app_id是否为该商户本身。
    //     */
    //     if($result) {//验证成功
            
    //         //请在这里加上商户的业务逻辑程序代码
            
    //         //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //         //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

    //         //商户订单号
    //         $where['order_no'] = htmlspecialchars($_GET['out_trade_no']);
    //         //实际金额
    //         $where['order_amount'] = htmlspecialchars($_GET['total_amount']);
    //         //支付宝交易号
    //         $trade_no = htmlspecialchars($_GET['trade_no']);

    //         $count = DB::table('order')->where($where)->count();
    //         $result = json_encode($arr);
    //         if (!$count) {
    //             Log::channel('alipay')->info('订单和金额,没有等前记录:'.$result."支付宝交易号：".$trade_no);
    //         }
    //         if (htmlspecialchars($_GET['seller_id']) !=config('alipay.seller_id') || htmlspecialchars($_GET['app_id']) !=config('alipay.app_id')) {
    //             Log::channel('alipay')->info('商户不符:'.$result."支付宝交易号：".$trade_no);
    //         }

    //         Log::channel('alipay')->info("验证成功<br />支付宝交易号：".$trade_no);
      

    //         //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
    //         return redirect('malls');
    //     }
    //     else {
    //         //验证失败
    //         echo "验证失败";
    //     }
    // }

    // /*支付宝异步通知*/
    // public function notifyAlipay()
    // {
    //     $config=config('alipay');    //配置
    //     require_once app_path('libs/alipay/pagepay/service/AlipayTradeService.php');

    //     $arr=$_POST;
    //     $alipaySevice = new \AlipayTradeService($config); 
    //     $alipaySevice->writeLog(var_export($_POST,true));
    //     $result = $alipaySevice->check($arr);

    //     /* 实际验证过程建议商户添加以下校验。
    //     1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
    //     2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
    //     3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
    //     4、验证app_id是否为该商户本身。
    //     */
    //     if($result) {//验证成功
    //         //请在这里加上商户的业务逻辑程序代
            
    //         //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            
    //         //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            
    //         //商户订单号

    //         $out_trade_no = $_POST['out_trade_no'];

    //         //支付宝交易号

    //         $trade_no = $_POST['trade_no'];

    //         //交易状态
    //         $trade_status = $_POST['order_status'];


    //         if($_POST['trade_status'] == 'TRADE_FINISHED') {

    //             //判断该笔订单是否在商户网站中已经做过处理
    //                 //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
    //                 //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
    //                 //如果有做过处理，不执行商户的业务程序
                        
    //             //注意：
    //             //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
    //             Log::channel('alipay')->info('退款日期超过可退款期限,不予处理:'.$result."支付宝交易号：".$trade_no);
    //         }
    //         else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
    //             //判断该笔订单是否在商户网站中已经做过处理
    //                 //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
    //                 //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
    //                 //如果有做过处理，不执行商户的业务程序  
                    
    //             //商户订单号
    //             $where['order_no'] = htmlspecialchars($_POST['out_trade_no']);
    //             //实际金额
    //             $where['order_amount'] = htmlspecialchars($_POST['total_amount']);
    //             //支付宝交易号
    //             $trade_no = htmlspecialchars($_POST['trade_no']);

    //             $count = DB::table('order')->where($where)->count();
    //             $result = json_encode($arr);
    //             if (!$count) {
    //                 Log::channel('alipay')->info('订单和金额,没有等前记录:'.$result."支付宝交易号：".$trade_no);
    //             }
    //             if (htmlspecialchars($_POST['seller_id']) !=config('alipay.seller_id') || htmlspecialchars($_POST['app_id']) !=config('alipay.app_id')) {
    //                 Log::channel('alipay')->info('商户不符:'.$result."支付宝交易号：".$trade_no);
    //             }

    
    //             //注意：
    //             //付款完成后，支付宝系统发送该交易状态通知
                
    //             // 更改订单支付状态   -------会溢卖   一般下单成功就改 这些
    //             // 更改库存
    //             // 根据订单号查订单商品购买数量，最后到商品表减去相应购买数量
    //             Log::channel('alipay')->info("验证成功<br />支付宝交易号：".$trade_no);
    //             // code.......
    //         }
    //         //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
    //         echo "success"; //请不要修改或删除
    //     }else {
    //         //验证失败
    //         echo "fail";

    //     }
    // }
    /*****************************************************************************************/
    /*手机支付*/
    public function successly()
    {
        header("Content-type: text/html; charset=utf-8");

        //$id =request()->id;
        $id=rand(1,27);
       // dump($id);
        $where=[
            'order_id'=>$id,
            'is_del'=>1
        ];
        $data = DB::table('order')->where($where)->first();
        // dd($data);
        
        $config=config('alipay');    //配置
        // print_r($config);exit;
        require_once app_path('libs/wapalipay/wappay/service/AlipayTradeService.php');  
        require_once app_path('libs/wapalipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php');

        //商户订单号，商户网站订单系统中唯一订单号，必填
         $out_trade_no = $data->order_no;

        if (!empty($out_trade_no)){
             
            //订单名称，必填
            $subject = "支付宝支付";

            //付款金额，必填
            $total_amount = $data->order_amount;

            //商品描述，可空
            $body = $data->order_talk;
            
            //超时时间
            $timeout_express="1m";

            $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setTimeExpress($timeout_express);

            $payResponse = new \AlipayTradeService($config);
            $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

            return ;
        }
    }

    /*同步通知*/
    public function returnAlipay()
    {
        $config=config('alipay');    //配置
        dump($config);
        require_once app_path('libs/wapalipay/wappay/service/AlipayTradeService.php');

        $arr=$_GET;
        dump($arr);
        $alipaySevice = new \AlipayTradeService($config); 
        dump($alipaySevice);
        $result = $alipaySevice->check($arr);
        dd($result);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
         if($result) {//验证成功
            
            //请在这里加上商户的业务逻辑程序代码
            
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号
            $where['order_no'] = htmlspecialchars($_GET['out_trade_no']);
            //实际金额
            $where['order_amount'] = htmlspecialchars($_GET['total_amount']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);

            $count = DB::table('order')->where($where)->count();
            $result = json_encode($arr);
            if (!$count) {
                Log::channel('alipay')->info('订单和金额,没有等前记录:'.$result."支付宝交易号：".$trade_no);
            }
            if (htmlspecialchars($_GET['seller_id']) !=config('wapalipay.seller_id') || htmlspecialchars($_GET['app_id']) !=config('wapalipay.app_id')) {
                Log::channel('alipay')->info('商户不符:'.$result."支付宝交易号：".$trade_no);
            }

            Log::channel('alipay')->info("验证成功<br />支付宝交易号：".$trade_no);
      

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            return redirect('malls');
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }

    /*异步通知*/
    public function notifyAlipay()
    {

        $config=config('alipay');    //配置
        require_once app_path('libs/wapalipay/wappay/service/AlipayTradeService.php');

        $arr=$_POST;
        $alipaySevice = new \AlipayTradeService($config); 
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代

            
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            
            //商户订单号

            $out_trade_no = $_POST['order_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];


            if($_POST['trade_status'] == 'TRADE_FINISHED') {

                //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序
                        
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                Log::channel('alipay')->info('退款日期超过可退款期限,不予处理:'.$result."支付宝交易号：".$trade_no);
            }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序    
                    
                // 商户订单号
                $where['order_no'] = htmlspecialchars($_POST['out_trade_no']);
                //实际金额
                $where['order_amount'] = htmlspecialchars($_POST['total_amount']);
                //支付宝交易号
                $trade_no = htmlspecialchars($_POST['trade_no']);

                $count = DB::table('order')->where($where)->count();
                $result = json_encode($arr);
                if (!$count) {
                    Log::channel('alipay')->info('订单和金额,没有等前记录:'.$result."支付宝交易号：".$trade_no);
                }
                if (htmlspecialchars($_POST['seller_id']) !=config('alipay.seller_id') || htmlspecialchars($_POST['app_id']) !=config('alipay.app_id')) {
                    Log::channel('alipay')->info('商户不符:'.$result."支付宝交易号：".$trade_no);
                }

                 //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                
                // 更改订单支付状态   -------会溢卖   一般下单成功就改 这些
                // 更改库存
                // 根据订单号查订单商品购买数量，最后到商品表减去相应购买数量
                Log::channel('alipay')->info("验证成功<br />支付宝交易号：".$trade_no);
                // code.......
            }
             //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success"; //请不要修改或删除
        }else {
            //验证失败
            echo "fail";

        }
    }

     /*我的*/
    public function user()
    {
    	return view('malls/user');
    }
     /*我的订单*/
    public function order()
    {
    	return view('malls/order');
    }
    /*我的优惠券*/
    public function quan()
    {
    	return view('malls/quan');
    }
     /*收货地址*/
    public function addAddress()
    {
    	return view('malls/addAddress');
    }
     /*添加收货地址*/
    public function address()
    {
    	return view('malls/address');
    }
      /*我的收藏*/
    public function shoucang()
    {
    	return view('malls/shoucang');
    }
       /*浏览记录*/
    public function jilu()
    {
    	return view('malls/jilu');
    }
       /*提现*/
    public function tixian()
    {
    	return view('malls/tixian');
    }

}
