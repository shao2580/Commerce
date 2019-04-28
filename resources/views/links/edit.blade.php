<!DOCTYPE html>
<html>
<head>
	<title>友链修改页</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script type="text/javascript" src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
</head>
<body>
	<div align="center">
		<form action="{{url('link/update',$data->id)}}" method="post" enctype="multipart/form-data">
			<table border="1">
				@csrf
				<caption>友链修改页&nbsp;&nbsp;&nbsp;<a href="{{url('link/list')}}">列表页</a></caption>
				<tr>
					<td>网站名称：</td>
					<td>
						<input type="text" name="name" value="{{$data->name}}">
					</td>
				</tr>
				<tr>
					<td>网站网址：</td>
					<td>
						<input type="text" name="url" value="{{$data->url}}">
					</td>
				</tr>
				<tr>
					<td>链接类型</td>
					<td>
						<input type="radio" name="type" value="1" checked  >LOGO链接
						<input type="radio" name="type" value="2">文字链接
					</td>
				</tr>
				<tr>
					<td>图片LOGO：</td>
					<td>
						<!-- <input type="text" name="logo"><br/> -->
						<img src="http://uploads.blog.com/{{$data->logo}}">
						<input type="file" name="logo" value="上传图片">
					</td>
				</tr>
				<tr>
					<td>网站联系人：</td>
					<td>
						<input type="text" name="contacts" value="{{$data->contacts}}">
					</td>
				</tr>
				<tr>
					<td>网站介绍：</td>
					<td>
						<textarea name="content" >{{$data->content}}</textarea>
					</td>
				</tr>
				<tr>
					<td>是否显示：</td>
					<td>
						<input type="radio" name="is_show" checked value="1">是
						<input type="radio" name="is_show" value="2">否
					</td>
				</tr>
				<input type="hidden" name=""  id="hid" value="{{$data->id}}">
				<tr>
					<td colspan="2" align="center">
						@if ($errors->any())
							<div class="alert alert-danger">
							@foreach ($errors->all() as $error)
							<p>{{ $error }}</p>
							@endforeach
							</div>
						@endif
						<br/>
						<!-- <button>提交</button> -->
						<input type="button" name="" value="提交">
						<input type="reset" name="" value="重置">
					</td>
				</tr>
			</table>
		</form>
	</div>
	<script type="text/javascript">
		$(function(){

			$("input[name='name']").blur(function(){
				var name=$(this).val();
				$(this).next().remove();
				if (name=='') {
					
					$(this).after("<span style='color:red'>用户名不能为空<span>");
					return false;
				}
				var reg=/^[\w\u4e00-\u9fa5]{2,20}$/;
				$(this).next().remove();
				if (!reg.test(name)) {
					
					$(this).after("<span style='color:red'>用户名必须为2~20位汉字、字母、数字、下划线组成<span>");
					return false;
				}

				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				 var id=$('#hid').val();
				// console.log($id);
				$.ajax({
				  method: "POST",
				  url: "/link/checkname",
				  data: { name: name,id:id }
				}).done(function( msg ) {
					$("input[name='name']").next().remove();
				  	if (msg.code==0) {
				  		
				  		$("input[name='name']").after("<span style='color:red'>"+msg.msg+"<span>")
				  	}
				});	
			});

			$("input[name='url']").blur(function(){
				var url=$(this).val();
				$(this).next().remove();
				if (url=='') {
					
					$(this).after("<span style='color:red'>网址不能为空<span>");
					return false;
				}
				var reg=/^http\:\/\/www\.\w{3,10}\.com$/;
				console.log(reg);
				if (!reg.test(url)) {
					$(this).next().remove();
					$(this).after("<span style='color:red'>网址必须http://开头<span>");
					return false;
				}
			});

			/*提交*/
			$("input[type='button']").click(function(){
				// var name_flag = url_flag = true;
				var obj_name=$("input[name='name']");
				var name=obj_name.val();
				$("input[name='name']").next().remove();
				if (name=='') {
					
					obj_name.after("<span style='color:red'>用户名不能为空<span>");
					// name_flag = false;
					return false;
				}
				var reg=/^[\w\u4e00-\u9fa5]{2,20}$/;
				$("input[name='name']").next().remove();
				obj_name.next().remove();
				if (!reg.test(name)) {
					
					obj_name.after("<span style='color:red'>用户名必须为2~20位汉字、字母、数字、下划线组成<span>");
					// name_flag = false;
					return false;
				}

				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				 var id=$('#hid').val();
				var fals=false;
				$.ajax({
					// async:false,   // 要设置为同步（默认true）
				  method: "POST",
				  url: "/link/checknamet",
				  data: { name:name,id:id }
				}).done(function(msg) {
					obj_name.next().remove();
				  	if(msg.code==0){
							$("input[name='name']").after("<span style='color:red'>"+msg.msg+"<span>");	
							fals=false;
						}else{

							fals=true;
						}
				});	
			

				var obj_url=$("input[name='url']");
				var url=obj_url.val();
				obj_url.next().remove();
				if (url=='') {
					
					obj_url.after("<span style='color:red'>网址不能为空<span>");
					// url_flag = false;
					return false;
				}
				var reg=/^http\:\/\/www\.\w{3,10}\.com$/;
				if (!reg.test(url)) {
					$("input[name='url']").next().remove();
					obj_url.after("<span style='color:red'>网址必须http://开头<span>");
					return false;
				}
				// if (name_flag && url_flag) {
					$('form').submit();
				// };
				
			});
					if(fals==false){
					return fals;
				}
	});		

	
		
		
	</script>
</body>
</html>