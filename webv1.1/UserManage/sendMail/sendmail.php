<?php
//
include_once ("connect.php");
$action = isset($_GET['action']) ? $_GET['action'] : "";
switch ($action) {
    case 'add' : //列表
	//邮件发送
	require './mailer/class.phpmailer.php';
	require './mailer/class.smtp.php';
	date_default_timezone_set('PRC');
	ignore_user_abort();
	set_time_limit(0);
	/////////////////////////////
	$user2Name = htmlspecialchars(stripslashes(trim($_POST['user2name'])));
	$userName = htmlspecialchars(stripslashes(trim($_POST['user3name'])));
	$email = htmlspecialchars(stripslashes(trim($_POST['email'])));
	$phoNum = htmlspecialchars(stripslashes(trim($_POST['phone'])));
	//$user4name = htmlspecialchars(stripslashes(trim($_POST['user4name'])));
	//$company = htmlspecialchars(stripslashes(trim($_POST['company'])));
	//$IndustryType = htmlspecialchars(stripslashes(trim($_POST['IndustryType'])));
   
	$regTime = time();
	/////////////////////////////
	$interval = 60*1;
	$str = $userName.$phoNum.$regTime;
	$md5Num = md5($str);
	$pwd = substr("$md5Num", 6, 6);
    
	$sql_query="SELECT * FROM use_login WHERE UserName='".$userName."' ";
	$result_set=mysql_query($sql_query);
	if(mysql_num_rows($result_set)>0)
	{
			die("此用户名已经被使用");
	}
	else{
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
		$mail->addAttachment('./src/20151002.png','test.png');
		$status = $mail->send();
		if($status) 
		{
			$sql_query="insert into use_login(UserName,Password,Role,Company,Phone,Email,IndustyType,Name) values('".$userName."', '".$pwd."', 3,'','".$phoNum."','".$email."','','')  ";
			$result_set=mysql_query($sql_query);
			$sql_queryy="insert into user_bind(User2,User3,Flag,Time) values('".$user2Name."','".$userName."', 1 ,now()) ";
			mysql_query($sql_queryy);
			echo '1';
		}
        else die("验证失败");

	}
	  break;
 }	
?>

