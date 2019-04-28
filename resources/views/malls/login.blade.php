@extends('layouts.mall')
@section('title', '登录页')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员登录</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{url('mall/images')}}/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('malls/dologin')}}" method="post" class="reg-login">
      <h3>还没有三级分销账号？点此<a class="orange" href="{{url('malls/reg')}}">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" id="name" name="name" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList"><input type="password" id="password" name="password" placeholder="请输入输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" id="submitbut" value="立即登录" />
      </div>
     </form><!--reg-login/-->
<script type="text/javascript">
  $(function(){
      /*账号*/
      $('#name').blur(function(){
          var name =$(this).val();
          $(this).next().remove();
          if (name=='') {
              $(this).after("<span style='color:red'>账号不能为空<span>");
              return false;
          }
          var reg1 = /^1[345678]\d{9}$/;
          var reg2 = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
          if (!reg1.test(name) && !reg2.test(name)) {
              $(this).after("<span style='color:red'>请输入正确的手机号或邮箱<span>");
              return false;   
          }
      })
      /*密码*/
      $('#password').blur(function(){
          var password =$(this).val();
          $(this).next().remove();
           if (password=='') {
              $(this).after("<span style='color:red'>密码不能为空<span>");
              return false;
          }
      });

      /*提交*/
      $('#submitbut').click(function(){
          var name =$('#name').val();
          $('#name').next().remove();
          if (name=='') {
              $('#name').after("<span style='color:red'>账号不能为空<span>");
              return false;
          }
          var reg1 = /^1[345678]\d{9}$/;
          var reg2 = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
          if (!reg1.test(name) && !reg2.test(name)) {
              $('#name').after("<span style='color:red'>请输入正确的手机号或邮箱<span>");
              return false;   
          }
          var password =$('#password').val();
          $('#password').next().remove();
           if (password=='') {
              $('#password').after("<span style='color:red'>密码不能为空<span>");
              return false;
          }

          //把账号 密码通过ajax传给控制器
         $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            method: "post",
            url: "/malls/dologin",
            data: { name:name,password:password }
          }).done(function( msg ) {  
              if (msg.code==1) {  

                location.href="{{url('malls')}}";
              }
              
          });


      });
  });
</script>
@include('public.footer')     
@endsection
