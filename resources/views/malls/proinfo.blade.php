@extends('layouts.mall')
@section('title', '商品详情')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
      <img src="http://uploads.1810.com/{{$data[0]->goods_img}}" />
      <img src="{{url('mall/images')}}/image2.jpg" />
      <img src="{{url('mall/images')}}/image3.jpg" />
      <img src="{{url('mall/images')}}/image4.jpg" />
      <img src="{{url('mall/images')}}/image5.jpg" />
     </div><!--sliderA/-->
     <table class="jia-len">
      <input type="hidden" id="goods_id" value="{{$data[0]->goods_id}}">
      <tr goods_id={{$data[0]->goods_id}}>
       <th><strong class="orange">{{$data[0]->shop_price}}</strong></th>
       <td>
        <div class="spinner">
          <button class="decrease">-</button>
          <input type="text"  class="spinnerExample value passive" value="1" >
          <button class="increase">+</button>
        </div>
       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$data[0]->goods_name}}</strong>
        <p class="hui">{{$data[0]->keywords}}</p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     <div class="height2"></div>
     <h3 class="proTitle">商品规格</h3>
     <ul class="guige">
      <li class="guigeCur"><a href="javascript:;">50ML</a></li>
      <li><a href="javascript:;">100ML</a></li>
      <li><a href="javascript:;">150ML</a></li>
      <li><a href="javascript:;">200ML</a></li>
      <li><a href="javascript:;">300ML</a></li>
      <div class="clearfix"></div>
     </ul><!--guige/-->
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
      <img src="http://uploads.1810.com/{{$data[0]->goods_img}}" width="636" height="822" />
     </div><!--proinfoList/-->
     <div class="proinfoList">
      {{$data[0]->content}}
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="{{url('malls/index')}}"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><a id="addCart" href="javascript:;" style="cursor: pointer;">加入购物车</a></td>
      </tr>

     </table>
    </div><!--maincont-->
    <br/>
    <br/>
<script type="text/javascript">
  $(function(){
      // 获取库存
      var goods_number = {{$data[0]->goods_number}};
      // console.log(goods_number);
      /*点击加号*/
      $('.increase').click(function(){
            var _this = $(this);
           
            var buy_number = parseInt($('.value').val());   //购买数量   //将字符串转为整数

            // 判断是否大于库存
            if (buy_number>=goods_number) {
                // 把+号失效
                _this('disabled',true);   //禁用
            }else{
                buy_number=buy_number+1;
                $('.value').val(buy_number);
                // - 号生效
                _this.parent().first('disabled',false);
            }
      })
       // 点击减号
        $('.decrease').click(function(){
            var _this = $(this);
           
            var buy_number = parseInt($('.value').val());   //购买数量   //将字符串转为整数

            // 判断是否大于库存
            if (buy_number<=1) {
                // 把-号失效
                _this.parent().next('disabled',true);   //禁用
            }else{
                buy_number=buy_number-1;
                $('.value').val(buy_number);
                // + 号生效
                _this.next().next('disabled',false);
            }
        })
         // 失去焦点
        $('.value').blur(function(){
            var _this = $(this);
            var buy_number=_this.val();  //获取文本框的值

            // 验证
            var reg = /^\d{1,}$/;
            if (buy_number==''||buy_number<=1||!reg.test(buy_number)) {
                _this.val(1);
            }else if (parseInt(buy_number)>=parseInt(goods_number)) {
                 _this.val(goods_number);
            }else{
                _this.val(parseInt(buy_number));
            }  
        }) 

        // 点击加入购物车
        $('#addCart').click(function(){
            // 获取商品id  购买数量
            var goods_id ={{$data[0]->goods_id}};
            // console.log(goods_id);

            var buy_number = $('.value').val();
            console.log(buy_number);
            if (goods_id=='') {
                alert('请选择一个商品');
                return false;
            }
            if (buy_number=='') {
                alert('请选择要购买的数量');
                return false;
            }
            
             $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
         // 把账号传给控制器
              $.ajax({
                type:'post',                        // 类型
                url:"/malls/addCart",   // 路径 推荐用 check 其他验证也能用
                data:{goods_id:goods_id,buy_number:buy_number},         // 数据
                dataType:'json',            // 预期返回 类型 json
              }).done(function(msg){      //done(完成) 回调函数 也能在上面写成 success:function(){}
                  if (msg.code==1) {
                      location.href="{{url('malls/car')}}";
                  }
              });
          
        })
  })
</script>
@endsection