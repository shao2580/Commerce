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
     <form action="{{('malls/login')}}" method="get" class="reg-login">
      <div class="lrBox">
       <div class="lrList"><input type="text" placeholder="收货人" /></div>
       <div class="lrList"><input type="text" placeholder="详细地址" /></div>
       <div class="lrList">
        <select>
         <option>省份/直辖市</option>
        </select>
       </div>
       <div class="lrList">
        <select>
         <option>区县</option>
        </select>
       </div>
       <div class="lrList">
        <select>
         <option>详细地址</option>
        </select>
       </div>
       <div class="lrList"><input type="text" placeholder="手机" /></div>
       <div class="lrList2"><input type="text" placeholder="设为默认地址" /> <button>设为默认</button></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="保存" />
      </div>
     </form><!--reg-login/-->
     
@include('public.footer')
@endsection