<!DOCTYPE html>
<html>
<head>
	<title>列表页</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}">
</head>
<body>
	
	<div align="center">
		<h2>列表页</h2>
		<table border="1">
			<form action="" method="">
				<input type="text" placeholder="请输入商品名关键字" name="goods_name" value="{{$name}}">&nbsp;
				<input type="text" placeholder="请输入描述关键字" name="description" value="{{$description}}">&nbsp;
				<button>搜索</button>&nbsp;
				<a href="{{url('zk')}}">返回</a>
			</form>
			<tr>
				<th>ID</th>
				<th>商品名</th>
				<th>商品图片</th>
				<th>商品数量</th>
				<th>商品描述</th>
				<th>操作</th>
			</tr>
			@foreach ($data as $k => $v)
				<tr align="center">
				<td>{{$v->goods_id}}</td>
				<td><a href="{{url('zk/info',['id'=>$v->goods_id])}}">{{$v->goods_name}}</a></td>
				<td><a href="{{url('zk/info',['id'=>$v->goods_id])}}"><img width="60" height="40" src="http://uploads.1810.com/{{$v->goods_img}} "></a></td>
				<td>{{$v->goods_number}}</td>
				<td>{{$v->description}}</td>

				<td>
					<a href="{{url('zk/edit',['id'=>$v->goods_id])}}">编辑</a>
					<a href="{{url('zk/del',['id'=>$v->goods_id])}}">删除</a>
				</td>
			</tr>
			 @endforeach
			
		</table>
		{{$data->appends($query)->links()}}
	</div>
</body>
</html>
