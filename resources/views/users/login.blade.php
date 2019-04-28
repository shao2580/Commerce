<!DOCTYPE html>
<html>
<head>
	<title>用户登录</title>
</head>
<body>
	<div align="center" >
		<form action="{{url('user/login')}}" method="post">
			<caption>用户登录</caption>
			<table border="1">
				@csrf
				<tr>
					<td>用户名：</td>
					<td><input type="text" name="name"></td>
				</tr>
				<tr>
					<td>密码：</td>
					<td><input type="text" name="password"></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><button>登录</button></td>
				</tr>
			</table>
		</form>
	</div>
	
</body>
</html>