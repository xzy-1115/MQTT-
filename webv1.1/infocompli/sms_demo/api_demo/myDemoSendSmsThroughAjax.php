<!DOCTYPE html>
<html>
<head>
	<title>myDemo for sending Sms through ajax</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="C:\Web_Dev\DataBase\phpwamp_8.8.8.8
	\wwwroot\api_demo\jquery-1.10.1.js">></script>
	<script>
		 $("#submit").bind("click", function () { 
			$.ajax({ 
			   type: "post", 
			   url: "SmsDemo.php", 
			   data: "name=" + $("#phpNumID").val(), 
			   success: function (result) { 
			   alert(result.msg); //拿到结果 
			   } 
			  }); 
			});
	</script>
</head>
<body>
<h1>This is a demo for sending short message </h1>
<form action="SmsDemo.php" method="post">
	<p>电话号码<input type="text" name="phoNum" id="phpNumID"></p>
	<p>	<input type="submit" name="submit" id="submit" value="点击发送验证码"></p>
</form>

</body>
</html>