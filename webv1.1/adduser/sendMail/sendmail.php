<?php

include_once ("connect.php");
	require './mailer/class.phpmailer.php';
	require './mailer/class.smtp.php';
	date_default_timezone_set('PRC');
	ignore_user_abort();
	set_time_limit(0);
	session_start();
    $username2=$_SESSION['UserName'];
	$strName = $_POST['strName']; 
	$strCompany = $_POST['strCompany']; 
	$strAddr = $_POST['strAddr']; 	
	$Lng = $_POST['Lng']; 
	$Lat = $_POST['Lat']; 
	$LocalType = $_POST['LocalType']; 	
	$userName = $_POST['strUserName'];    //htmlspecialchars(stripslashes(trim($_POST['user3name'])));
	$email = $_POST['strEmail'];//htmlspecialchars(stripslashes(trim($_POST['email'])));
	$phoNum = $_POST['strPhone'];//htmlspecialchars(stripslashes(trim($_POST['phone'])));
	$regTime = time();
	/////////////////////////////
	$interval = 60*1;
	$str = $userName.$phoNum.$regTime;
	$md5Num = md5($str);
	$pwd = substr("$md5Num", 6, 6);
	
		$mail = new PHPMailer(); 
		$mail->SMTPDebug = 3;
		$mail->isSMTP();
		$mail->SMTPAuth=true;
		$mail->Host = 'smtp.163.com';
		$mail->SMTPSecure = 'ssl';
		//设置ssl连接smtp服务器的远程服务器端口号 可选465或587
		$mail->Port = 587;
		$mail->Hostname = 'localhost';
		$mail->CharSet = 'UTF-8';
		$mail->FromName = 'yiwei';
		$mail->Username ='hubu_fpga';
		$mail->Password = 'hubu506'; //这里不填密码，应该填你的邮箱客户端授权码
		$mail->From = 'hubu_fpga@163.com';
		$mail->isHTML(true); 
		$mail->addAddress($email,'这个QQ的昵称'); //85301868 //
		$mail->Subject = '三级用户密码';
		$mail->Body = "<b style=\"color:red;\">PHPMailer</b>尊敬的三级用户".$userName."，这是你的登陆密码，请注意查收：".$pwd;
		//$mail->addAttachment('./src/20151002.png','test.png');
		$status = $mail->send();
		if($status) 
		{
			$sql_query = "INSERT INTO use_login (UserName,Password,Role,Company,Phone,Email,Address,IndustyType,Name,Longtitude,Latitude) VALUES('".$userName."','".$pwd."',3,'".$strCompany."','".$phoNum."','".$email."','".$strAddr."','".$LocalType."','".$strName."','".$Lng."','".$Lat."')";
			mysql_query($sql_query);
			$sql_queryx = "INSERT INTO user_bind (User2,User3,Flag,Time) VALUES('".$username2."','".$userName."' , 1 , now())";
			mysql_query($sql_queryx);
			$resultJson = array("state"=>200);//json格式的数组
		}
        else $resultJson = array("state"=>3);//json格式的数组
	
		echo urldecode(json_encode($resultJson));//Json格式输出

?>

