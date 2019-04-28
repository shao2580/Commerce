@extends('layouts.mall')
@section('title', '收货地址')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>收货地址</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{url('mall/images')}}/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><a href="{{url('malls/address')}}" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
       <td width="25%" align="center" style="background:#fff url({{url('mall/images')}}/xian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">删除信息</a></td>
      </tr>
     </table>
     
     <div class="dingdanlist" onClick="window.location.href='proinfo.html'">
      <table>
       
       <tr>
        <td width="50%">
         <h3>张先生 185444171241</h3>
         <time>上海普陀区曹杨路1040弄中友大厦19楼</time>
        </td>
        <td align="right"><a href="{{url('malls/address')}}" class="hui"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
     
@include('public.footer')
@endsection