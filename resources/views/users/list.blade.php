<!DOCTYPE html>
<html>
<head>
	<title>列表</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
</head>
<body>
	<div align="center">
		<br/>
		<div>
			<form action="" method="">
				<input type="text" name="name" value="{{$name}}" placeholder="请输入姓名关键字">
				<input type="text" name="age" value="{{$age}}" placeholder="请输入年龄搜索">
				<!-- <select name="age" value="{{$age}}">
					<option type="text" value="">===请选择年龄===</option>
					<option value="18" @if($age==18) selected @endif >18</option>
					<option value="19" @if($age==19) selected @endif >19</option>
					<option value="20" @if($age==20) selected @endif >20</option>
					<option value="21" @if($age==21) selected @endif >21</option>
					<option value="22" @if($age==22) selected @endif >22</option>
				</select> -->
				<button>搜索</button>&nbsp;&nbsp;&nbsp;
				<a href="{{'add'}}">添加</a>
				<a href="{{'list'}}">返回</a>

			</form>
			
		</div>
		<br/>
		<table border="1" align="center" width="580">
			<tr>
				<th>ID</th>				
				<th>姓名</th>
				<th>头像</th>
				<th>年龄</th>
				<th>性别</th>
				<th>操作</th>
			</tr>
			@foreach ($data as $key => $val)	
				<tr align="center">
					<td>{{$val->id}}</td>
					<td>{{$val->name}}</td>
					<td><img width="60" height="40" src="http://uploads.blog.com/{{$val->head}}"></td>
					<td>{{$val->age}}</td>
					<td>@if($val->sex==1) 男 @else 女 @endif</td>

			<td>
				<!-- <a href="/user/edit/{{$val->id}}">修改</a> -->   <!--什么都不加  不带绝对路径 http://www  -->	
				<a href="{{route('edituser',['id'=>$val->id])}}">修改</a>    
				<a href="{{route('destroyuser',['id'=>$val->id])}}">删除</a>	  <!-- route  起别名  id=>值-->
			</td>		
				</tr>
			@endforeach
		</table>
		{{$data->appends($query)->links()}}
	</div>
		
		
			@if (session('msg'))
			<div class="alert alert-success">
			{{ session('msg') }}
			</div>
			@endif	
		
</body>
</html>