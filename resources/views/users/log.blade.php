<!DOCTYPE html>
<html>
<head>
	<title>找回密码</title>
</head>
<body>
	<div align="center" >
		<form action="{{url('user/send')}}" method="post">
			<caption>找回密码</caption>
			<table border="1">
				@csrf
				<tr>
					<td>邮箱：</td>
					<td><input type="text" name="email"></td>
				</tr>
				<!-- <tr>
					<td>密码：</td>
					<td><input type="text" name="password"></td>
				</tr> -->
				<tr>
					<td colspan="2" align="center"><button>发送</button></td>
				</tr>
			</table>
		</form>
	</div>
	
</body>
</html>