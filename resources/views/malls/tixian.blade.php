@extends('layouts.mall')
@section('title', '提现')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>银行卡</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{url('mall/images')}}/head.jpg" />
     </div><!--head-top/-->
     <div class="addYinhang">
     <h3>添加银行卡 <span class="glyphicon glyphicon-remove"></span></h3>
     <select>
      <option>工商银行</option>
      <option>中国银行</option>
      <option>农业银行</option>
      <option>邮政银行</option>
     </select>
     <input type="text" placeholder="输入银行卡号" />
     <div class="yhts">
      注意：此银行卡开户人必须和您实名认证的名字一样，否则提现无法成功到账
     </div><!--yhts/-->
     <div class="moren">
      <input type="checkbox" /> 设为默认银行
     </div><!--moren/-->
     <a href="#" class="addTian">添加</a>
    </div><!--addYinhang/-->
    
    <div class="jyjl">
         <h2 class="vipTitle">
          <span>银行卡绑定</span>
         </h2>
         <div class="yinhangka">
          <div class="yhangkaList">
           <h3>工商银行</h3>
           <div class="yinhangMeass">
            <span class="hui">账号 </span> 6222 0000 0000 0000
            
            <a class="removeyin" href="#">[删除]</a>
           </div><!--yinhangMeass-->
          </div><!--yhangkaList/-->
          
          <div class="yhangkaList">
           <div class="tianjiayinhang">
            <span class="glyphicon glyphicon-plus"></span><br />
            <span class="blue">添加一张银行卡</span>
           </div><!--tianjiayinhang/-->
          </div><!--yhangkaList/-->
          
          <div class="clearfix"></div>
         </div><!--yinhangka/-->
        </div><!--jyjl/--> 
        <div class="jyjl">
         <div class="chongzhi">
          <h3>填写提现金额</h3>
          <form action="vip.html" method="get" class="form-login-reg">
              <div class="flrLeft">
               <dl>
                <dt>账户余额：</dt>
                <dd>
                 <strong class="red" style="font-size:22px;">0.00</strong> <strong>元</strong>
                </dd>
                <div class="clearfix"></div>
               </dl>
               <dl>
                <dt>提现金额：</dt>
                <dd>
                 <input type="text" class="flrwidht1" /> <strong>元</strong> <span>必填！</span>
                </dd>
                <div class="clearfix"></div>
               </dl>
               <dl>
                <dt>验证码：</dt>
                <dd>
                 <input type="text" class="flrwidht2" /> <span>必填！</span> 
                 <img src="{{url('mall/images')}}/yzm.gif" width="77" height="33" />
                </dd>
                <div class="clearfix"></div>
               </dl>
               <div class="gongyue">
                <input type="checkbox" /> 本人已阅读,并已确认一下重要信息
               </div><!--gongyue/-->
               <div class="flrSub flrSub3">
                <input type="submit" value=" 确认提现 " />
               </div><!--flrSub/-->
              </div><!--flrLeft/-->
              <div class="clearfix"></div>
            </form><!--form-login-reg/-->
         </div><!--chongzhi/-->
         <div class="czts">
          <span>温馨提示</span><br />
          1.提款申请提交后，您的提现金额将从可用金额中扣除，无法在进行出借。<br />
          2.为防止信用卡套现、洗钱等违法行为，网站将针对异常提款(包括无消费充值资金)进行严格审核，审核时间在15个工作日之后。<br />
          3.提现银行账号的开户名必须与银行卡名一致，否则提现失败。
         </div><!--czts/-->
        </div><!--jyjl/-->
     
@include('public.footer')
@endsection