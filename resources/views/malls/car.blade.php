@extends('layouts.mall')
@section('title', '购物车')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{url('mall/images')}}/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">2</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url({{url('mall/images')}}/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     
     <div class="dingdanlist">
      <table>
       <tr>
        <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" id="allbox" name="1" /> 全选</a></td>
       </tr>
       @foreach ($data as $key=>$val)
        
       <tr>
        <td width="4%"><input type="checkbox" class="box" name="1" /></td>
        <td class="dingimg" width="15%"><img src="http://uploads.1810.com/{{$val->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$val->goods_name}}</h3>
         <time>下单时间：{{$val->create_time}}</time>
        </td>
        <td align="right"><!-- <input type="text" class="spinnerExample" /> -->
          <div class="spinner">
          <button class="decrease">-</button>
          <input type="text" class="spinnerExample value passive" value="{{$val->buy_number}}" >
          <button class="increase">+</button>
          </div>
        </td>
       </tr>
       <tr>
        <th colspan="4"><strong class="orange">¥{{$val->shop_price}}</strong></th>
       </tr>
       @endforeach

       <tr>
        <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" /> 删除</a></td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange">¥69.88</strong></td>
       <td width="40%"><a href="{{url('malls/pay')}}" class="jiesuan">去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
<script type="text/javascript">
  $(function(){
      /*全选*/
           $('#allbox').click(function(){
                var status=$(this).prop('checked');
                $('.box').prop('checked',status);

                // 调用商品总价
                countTotal();
            });

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
          
          // 更改购买数量 发送到控制器
            function changeBuyNumber(goods_id,buy_number){
                $.ajax({
                    url:"{:url('Cart/changeBuyNumber')}",
                    method:'post',
                    data:{goods_id:goods_id,buy_number:buy_number},
                    async:false,
                    success: function(res){
                                // 错误给出提示 正确不提示
                                if (res.code==2) {
                                    layer.msg(res.font,{icon:res.code});
                                }
                              }
                });
            }

            // 给当前复选框选中
            function boxChecked(_this){
                _this.parents('tr').find("input[class='box']").prop('checked',true);
            }

            //获取小计 发送到控制器
            function getSubTotal(goods_id,_this){
                $.post(
                    "{:url('Cart/getSubTotal')}",
                    {goods_id:goods_id},
                    function(res){
                       _this.parents('td').next('td').text('￥'+res);
                       
                    }
                );
            }    

            // 重新计算总价  发送到控制器
            function countTotal(){
                // 获取所有选中的复选框 对应的商品id
                var _box=$('.box');
                var goods_id='';
                _box.each(function(index){
                    if ($(this).prop('checked')==true) {
                        goods_id+=$(this).parents('tr').attr('goods_id')+',';
                    }
                })
               goods_id = goods_id.substr(0,goods_id.length-1);
               // 把id发送给服务器 
               $.post(
                    "{:url('Cart/countTotal')}",
                    {goods_id:goods_id},
                    function(res){
                        $('#count').text(res);
                    }   
               );
            }


        // 点击结算
        $('.jiesuan').click(function(){
            // 获取商品id  购买数量
            var goods_id = {{$data[0]->goods_id}};
            var buy_number = $('.value').val();
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
                url:"/malls/",   // 路径 推荐用 check 其他验证也能用
                data:{goods_id:goods_id,buy_number:buy_number},         // 数据
                dataType:'json',            // 预期返回 类型 json
              }).done(function(msg){      //done(完成) 回调函数 也能在上面写成 success:function(){}
                 localhost.href="malls/pay";
              });
          
        })
  })
</script>
 @endsection