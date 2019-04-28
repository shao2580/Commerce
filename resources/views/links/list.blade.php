<!DOCTYPE html>
<html>
<head>
	<title>友链列表页</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
</head>
<body>
	<div align="center">
		<table border="1" >
			<br/>
			<div>
				<form action="" method="">
					<input type="text" name="name" value="{{$name}}" placeholder="请输入网站名称关键字">
					<button>搜索</button>&nbsp;&nbsp;&nbsp;
					<a href="{{url('/link/add')}}">添加</a>
					<a href="{{url('/link/list')}}">返回</a>

				</form>
			
			</div>
			<br/>		
			<tr>
				<th>
					<input type="checkbox" name="">
				</th>
				<th>ID</th>
				<th>网站名称</th>
				<th>网站网址</th>
				<th>网站LOGO</th>
				<th>网站联系人</th>
				<th>网站介绍</th>
				<th>状态</th>
				<th>管理操作</th>
			</tr>
			@foreach ($data as $key => $val)
				<tr align="center">
					<td>
						<input type="checkbox" name="">
					</td>
					<td>{{$val->id}}</td>
					<td>{{$val->name}}</td>
					<td>{{$val->url}}</td>
					<td><img width="60" height="40" src="http://uploads.blog.com/{{$val->logo}}"></td>
					<td>{{$val->contacts}}</td>
					<td>{{$val->content}}</td>
					<td>@if($val->is_show==1) 显示 @else 不显示 @endif</td>
					<td>
						<a href="{{route('editlink',['id'=>$val->id])}}">修改</a>
						<a href="{{route('destroylink',['id'=>$val->id])}}">删除</a>
					</td>
				</tr>
			@endforeach 
			
		</table>
		{{$data->appends($query)->links()}}
	</div>
	
</body>
</html>