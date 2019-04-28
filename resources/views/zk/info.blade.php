<!DOCTYPE html>
<html>
<head>
	<title>详情页</title>
</head>
<body>
	<div align="center">
		<h2>详情页</h2>

		<table>
			<tr>
				<td>商品名：</td>
				<td>{{$data->goods_name}}</td>
			</tr>
			<tr>
				<td>商品数量：</td>
				<td>{{$data->goods_number}}</td>
			</tr>
			<tr>
				<td>商品描述：</td>
				<td>{{$data->description}}</td>
			</tr>
			<tr>
				<td>商品图片</td>
				<td><img width="200" height="160" src="http://uploads.1810.com/{{$data->goods_img}}"></td>
			</tr>
		</table>
	</div>
	
</body>
</html>