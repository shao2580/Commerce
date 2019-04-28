<!DOCTYPE html>
<html>
<head>
	<title>修改页</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script type="text/javascript" src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
</head>
<body>
	<div align="center">
		<form action="{{url('/zk/update/'.$data->goods_id)}}" method="post" enctype="multipart/form-data">
			<table border="1">
				@csrf
				<tr>
					<td>商品名：</td>
					<td><input type="text" name="goods_name" value="{{$data->goods_name}}"></td>
				</tr>
				<tr>
					<td>商品数量：</td>
					<td><input type="text" name="goods_number" value="{{$data->goods_number}}"></td>
				</tr>
				<tr>
					<td>商品描述：</td>
					<td><input type="text" name="description" value="{{$data->description}}"></td>
				</tr>
				<tr>
					<td>商品图片：</td>
					<td><img width="200" height="160" src="http://uploads.1810.com/{{$data->goods_img}}"><br/>
						<input type="file" name="goods_img">
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<button>确认修改</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>