<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>1810微商城-@yield('title')</title>
    <link rel="shortcut icon" href="{{url('mall/images')}}/favicon.ico" />   

    <!-- <script src="{{url('mall/js')}}/jquery.min.js"></script> -->
    <script src="{{url('mall/js/jquery-3.3.1.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap -->
    <link href="{{url('mall/css')}}/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('mall/css')}}/style.css" rel="stylesheet">
    <link href="{{url('mall/css')}}/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.{{url('mall/js')}}/1.4.2/respond.min.js"></script>
    <![endif]--> 
    
    <script src="{{url('mall/js')}}/bootstrap.min.js"></script>
    <script src="{{url('mall/js')}}/style.js"></script>
    <!--焦点轮换-->
    <script src="{{url('mall/js')}}/jquery.excoloSlider.js"></script>
      <script>
    $(function () {
     $("#sliderA").excoloSlider();
    });
  </script>
     <!--jq加减-->
    <script src="{{url('mall/js')}}/jquery.spinner.js"></script>
    <script>
  // $('.spinnerExample').spinner({});
   </script>

  </head>
  <body>
    <div class="maincont">
     @yield('content')
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
     
 
  </body>
</html>
