@extends('layouts.mall')
@section('title', '所有商品')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl">
        <span class="glyphicon glyphicon-menu-left"></span>
      </a>
      <div class="head-mid">
        <h1>所有商品</h1>   
      </div>
     </header>
     <ul class="pro-select">
      <li class="pro-selCur"><a href="javascript:;">新品</a></li>
      <li><a href="javascript:;">销量</a></li>
      <li><a href="javascript:;">价格</a></li>
     </ul><!--pro-select/-->
     <form action="" method="get" class="search" style="margin:5px;">
          <input type="text" name="name" value="{{$name}}" class="seaText fl" placeholder="请输入所要购买的物品" />
          <input type="submit" value="搜索" class="seaSub fr" />
       </form>
     <div class="prolist">
      @foreach ($data as $key=>$val)
      <dl>
       <dt><a href="{{url('malls/proinfo')}}?goods_id={{$val->goods_id}}"><img src="http://uploads.1810.com/{{$val->goods_img}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="{{url('malls/proinfo')}}?goods_id={{$val->goods_id}}">{{$val->goods_name}}</a></h3>
        <div class="prolist-price"><strong>¥{{$val->shop_price}}</strong> <span>¥{{$val->market_price}}</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
      @endforeach
      <div align="center">
        {{$data->appends($query)->links()}}
      </div>
     </div><!--prolist/-->
@include('public.footer')     
@endsection
