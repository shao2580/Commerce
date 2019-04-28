@extends('layouts.mall')
@section('title', '首页')
@section('content')
     <header>
        <a href="javascript:history.back(-1);" class="back-off fl"><!--  -->
           <!-- <span class="glyphicon glyphicon-menu-left"></span> -->
        </a>
        <div class="head-mid">
          <h1>1810微商城-首页</h1>
        </div>
     </header>

     <div class="head-top">
      <img src="{{url('mall/images')}}/head.jpg" />
      <dl>
       <dt><a href="user.html"><img src="{{url('mall/images')}}/touxiang.jpg" /></a></dt>
       <dd>
        <h1 class="username">三级分销终身荣誉会员</h1>
        <ul>
         <li><a href="{{url('malls/prolist')}}"><strong>34</strong><p>全部商品</p></a></li>
         <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
         <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
         <div class="clearfix"></div>
        </ul>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--head-top/-->
     <form action="" method="get" class="search">
      <input type="text" name="name" value="{{$name}}" placeholder="请输入商品名" class="seaText fl" />
      <input type="submit" value="搜索" class="seaSub fr" />
     </form><!--search/-->
     <ul class="reg-login-click">
      <li><a href="{{url('malls/login')}}">登录</a></li>
      <li><a href="{{url('malls/reg')}}" class="rlbg">注册</a></li>
      <div class="clearfix"></div>
     </ul><!--reg-login-click/-->
     <div id="sliderA" class="slider">
      <img src="{{url('mall/images')}}/image1.jpg" />
      <img src="{{url('mall/images')}}/image2.jpg" />
      <img src="{{url('mall/images')}}/image3.jpg" />
      <img src="{{url('mall/images')}}/image4.jpg" />
      <img src="{{url('mall/images')}}/image5.jpg" />
     </div><!--sliderA/-->
     <ul class="pronav">
      <li><a href="{{url('malls/prolist')}}">食品</a></li>
      <li><a href="{{url('malls/prolist')}}">家具</a></li>
      <li><a href="{{url('malls/prolist')}}">家电</a></li>
      <li><a href="{{url('malls/prolist')}}">数码</a></li>
      <div class="clearfix"></div>
     </ul><!--pronav/-->
     
     <div class="index-pro1">

          @foreach ($data as $key => $val)
          <div class="index-pro1-list" >
          <dl > 
          <dt><a href="{{url('malls/proinfo')}}?goods_id={{$val->goods_id}}" ><img src="http://uploads.1810.com/{{$val->goods_img}}"    /></a></dt>
          <dd class="ip-text"><a href="{{url('malls/proinfo')}}?goods_id={{$val->goods_id}}">{{$val->goods_name}}</a><span><!-- 已售：24 --></span></dd>
          <dd class="ip-price"><strong>¥{{$val->shop_price}}</strong> <span>¥{{$val->market_price}}</span></dd>
         </dl>
          </div>

         @endforeach
        </div><!-- index-pro1/ -->

     <div class="clearfix" ></div>
     <br/>
    <div align="center"><a href="javascript:;" id="loadMore" style="cursor: pointer;">加载更多</a></div>
    <br/>
     <div class="prolist">
      <dl>
       <dt><a href="{{url('malls/proinfo')}}"><img src="{{url('mall/images')}}/prolist1.jpg" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="{{url('malls/proinfo')}}">四叶草</a></h3>
        <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
      <dl>
       <dt><a href="{{url('malls/proinfo')}}"><img src="{{url('mall/images')}}/prolist1.jpg" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="{{url('malls/proinfo')}}">四叶草</a></h3>
        <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--prolist/-->
     <div class="joins"><a href="fenxiao.html"><img src="{{url('mall/images')}}/jrwm.jpg" /></a></div>
     <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>
 
@include('public.footer')     
@endsection
