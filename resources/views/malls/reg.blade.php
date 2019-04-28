@extends('layouts.mall')
@section('title', '注册页')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{url('mall/images')}}/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('malls/doreg')}}" method="post" class="reg-login" enctype="multipart/form-data">
      <h3>已经有账号了？点此<a class="orange" href="{{url('malls/login')}}">登陆</a></h3>
      <div class="lrBox">
        @csrf
       <div class="lrList"><input type="text" id="name" name="name" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList2">
          <input type="text" id="code" name="code" placeholder="输入短信验证码" />
          <button type="button" id="sendcode">获取验证码</button>
       </div>
       <div class="lrList"><input type="password" id="password" name="password" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="password" id="pwd" name="pwd" placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" class="submitbtn" value="立即注册" />
      </div>
     </form><!--reg-login/-->
<script type="text/javascript">
  $(function(){
      /*账号*/
      $('#name').blur(function(){
          var name = $(this).val();
          // alert(name);
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

          $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            method: "post",
            url: "/malls/checkname",
            data: { name: name }
          }).done(function( msg ) {  
              if (msg.code==0) {  
              $('#name').next().remove();         
                $('#name').after("<span style='color:red'>"+msg.msg+"<span>");
              }
          });
      });

      /*验证码*/
      $('#sendcode').click(function(){
          var name = $('#name').val();
          $('#name').next().remove();
          var flag = false;
          var reg1 = /^1[345678]\d{9}$/;
          var reg2 = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
          if (name=='') {
             $('#name').after("<span style='color:red'>账号不能为空<span>");
             return false;
          }else if (!reg1.test(name) && !reg2.test(name)) {
              $('#name').after("<span style='color:red'>请输入正确的手机号或邮箱<span>");
              return false;   
          }else{
              $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              // 把账号传给控制器
              $.ajax({
                type:'post',                        // 类型
                url:"/malls/checkname",   // 路径 推荐用 check 其他验证也能用
                data:{name:name},         // 数据
                dataType:'json',            // 预期返回 类型 json
                async:false         //  同步
              }).done(function(msg){      //done(完成) 回调函数 也能在上面写成 success:function(){}
                if (msg.code==0) {
                  $('#name').next().remove();
                  $('#name').after("<span style='color:red'>"+msg.msg+"<span>");
                  flag = false;
                }else{
                  flag = true;
                }
              });
              
          }
          // 把邮箱传给控制器 控制器发送邮箱
          $.ajax({
            method: "post",
            url: "/malls/send",
            data: { name: name },
            async:false         //  同步
          }).done(function( msg ) {  
            console.log(msg); 
              if (msg.code==0) {           
                $('#name').after("<span style='color:red'>"+msg.msg+"<span>");
                flag = false;
              }
          },'json');

          if (flag==false) {
                return flag;
          };
      });

      /*密码*/
      $('#password').blur(function(){
          var password = $(this).val();
          $('#password').next().remove();
          if (password=='') {
             $(this).after("<span style='color:red'>密码不能为空<span>");
             return false;
          }
          var reg =/^[A-Za-z0-9]{6,18}$/;
          if (!reg.test(password)) {
              $(this).after("<span style='color:red'>密码由6~18位数字或字母<span>");
              return false;
          }
      });

      /*确认密码*/
      $('#pwd').blur(function(){
          var pwd = $(this).val();
          $('#pwd').next().remove();
          if (pwd=='') {
              $(this).after("<span style='color:red'>确认密码不能为空<span>");
              return false;
          }
          if (pwd!== $('#password').val()) {
              $(this).after("<span style='color:red'>确认密码必须和密码一致<span>");
              return false;
          }
      });

      /*提交*/
      $('.submitbtn').click(function(){
          /*账号*/
          var name_flag = code_flag = password_flag = pwd_flag = true;
        
              var name = $('#name').val();
              // alert(name);
              
              if (name=='') {
                $('#name').next().remove();
                $('#name').after("<span style='color:red'>账号不能为空<span>");
                name_flag = false;
              }
              
              $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              $.ajax({
                method: "post",
                url: "/malls/checkname",
                data: { name: name }
              }).done(function( msg ) {  
                  if (msg.code==1) {  
                  $('#name').next().remove();          
                    $('#name').after("<span style='color:red'>"+msg.msg+"<span>");
                    name_flag = false;
                  }
              });

              if (name_flag==false) {
                  return false;
              }

          /*验证码*/
              var code = $('#code').val();
                  // console.log(code);
                  if (code=='') {
                      $('#sendcode').next().remove();
                      $('#sendcode').after("<span style='color:red'>验证码不能为空<span>");
                      return false;
                  }
                  $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  // 把验证码传给控制器
                  $.ajax({
                    type:'post',                        // 类型
                    url:"/malls/checkcode",   // 路径 推荐用 check 其他验证也能用
                    data:{code:code},         // 数据
                    dataType:'json',            // 预期返回 类型 json
                    async:false         //  同步
                  }).done(function(msg){      //done(完成) 回调函数 也能在上面写成 success:function(){}
                    if (msg.code==0) {
                      $('#sendcode').next().remove();
                      $('#sendcode').after("<span style='color:red'>"+msg.msg+"<span>");
                      code_flag = false;
                    }else{
                      code_flag = true;
                    }
                  });
 
              if (code_flag==false) {
                    return false;
              };
              
          /*密码*/
              var password = $('#password').val();
              
              if (password=='') {
                $('#password').next().remove();
                 $('#password').after("<span style='color:red'>密码不能为空<span>");
                 password_flag = false;
              }
              if (password_flag == false) {
                  return false;
              }
          /*确认密码*/
              var pwd = $('#pwd').val();
              if (pwd=='') {
                $('#pwd').next().remove();
                  $('#pwd').after("<span style='color:red'>确认密码不能为空<span>");
                  pwd_flag = false;
              }
              if (pwd!== $('#password').val()) {
                $('#pwd').next().remove();
                  $('#pwd').after("<span style='color:red'>确认密码必须和密码一致<span>");
                  pwd_flag = false;
              }
              if (pwd_flag == false) {
                  return false;
              }

          if (name_flag && code_flag && password_flag && pwd_flag) {
              $('form').submit();
          }

      });    




  }); 
</script>
@include('public.footer')     
@endsection
