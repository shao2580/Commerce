<!DOCTYPE html>
<html>
<head>
	<title>修改页</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script type="text/javascript" src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
</head>
<body>
	<div align="center">
		

		<form action="{{url('/user/update/'.$data->id)}}" method="post" enctype="multipart/form-data">
			<h4>
				修改页 &nbsp;&nbsp;&nbsp;
				<a href="{{'/user/list'}}">列表</a>
			</h4>

			<table border="1" >
				{{csrf_field()}}
				<tr>
					<td>姓名：</td>
					<td><input type="text" name="name" value="{{$data->name}}"></td>
				</tr>
				<tr>
					<td>年龄：</td>
					<td><input type="text" name="age" value="{{$data->age}}"></td>
				</tr>
				<!-- <tr>
					<td>性别：</td>
					<td>
						<input type="radio" name="sex" checked="" value="1">男
						<input type="radio" name="sex" value="2">女
					</td>
				</tr> -->
				<tr>
					<td>头像：</td>
					<td><img src="http://uploads.blog.com/{{$data->head}}"><input type="file" name="edit_head"></td>
				</tr>
				<input type="hidden" name="head" value="{{$data->head}}">
				<tr>

					<td colspan="2" align="center">
						@if ($errors->any())
							<div class="alert alert-danger">
							<!-- <ul> -->
							@foreach ($errors->all() as $error)
							<p>{{ $error }}</p>
							@endforeach
							<!-- </ul> -->
							</div>
						@endif
						<br/>
						<input type="button" name="" value="提交">&nbsp;&nbsp;&nbsp;
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
				var reg=/^[\w\u4e00-\u9fa5]{3,20}$/;
				if (!reg.test(name)) {
					$(this).after("<span style='color:red'>用户名必须为3~20位汉字、字母、数字、下划线组成<span>");
					return false;
				}

				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
				  method: "POST",
				  url: "/user/checkname",
				  data: { name: name }
				}).done(function( msg ) {
					// $(this).next().remove();
				  	if (msg.code==0) {
				  		$("input[name='name']").after("<span style='color:red'>"+msg.msg+"<span>")
				  	}
				});	
			});

			$("input[name='age']").blur(function(){
				var age=$(this).val();
				$(this).next().remove();
				if (age=='') {
					$(this).after("<span style='color:red'>年龄不能为空<span>");
					return false;
				}
				var reg=/^\d{1,3}$/;
				if (!reg.test(age)) {
					$(this).after("<span style='color:red'>年龄必须为1~3位数字<span>");
					return false;
				}
			});

			/*提交*/
			$("input[type='button']").click(function(){
				var obj_name=$("input[name='name']");
				var name=obj_name.val();
				obj_name.next().remove();
				if (name=='') {
					obj_name.after("<span style='color:red'>用户名不能为空<span>");
					return false;
				}
				var reg=/^[\w\u4e00-\u9fa5]{3,20}$/;
				if (!reg.test(name)) {
					obj_name.after("<span style='color:red'>用户名必须为3~20位汉字、字母、数字、下划线组成<span>");
					return false;
				}

				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
				  method: "POST",
				  url: "/user/checkname",
				  data: { name: name }
				}).done(function( msg ) {
					obj_name.next().remove();
				  	if (msg.code==0) {
				  		obj_name.after("<span style='color:red'>"+msg.msg+"<span>")
				  	}
				});	

				var obj_age=$("input[name='age']");
				var age=obj_age.val();
				obj_age.next().remove();
				if (age=='') {
					obj_age.after("<span style='color:red'>年龄不能为空<span>");
					return false;
				}
				var reg=/^\d{1,3}$/;
				if (!reg.test(age)) {
					obj_age.after("<span style='color:red'>年龄必须为1~3位数字<span>");
					return false;
				}

				$('form').submit();
			})
		
		})
			
	</script>
</body>
</html>