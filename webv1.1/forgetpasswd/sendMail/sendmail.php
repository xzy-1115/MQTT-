<?php

include_once ("connect.php");
	require './mailer/class.phpmailer.php';
	require './mailer/class.smtp.php';
	date_default_timezone_set('PRC');
	ignore_user_abort();
	set_time_limit(0);
	
    
	$strName = $_POST['USERNAME']; 
	$strEMAIL = $_POST['EMAIL']; 
	$EmailS;
	$PasswdS;
	$sql_query="SELECT * FROM use_login WHERE UserName='".$strName."' ";
	$result_set=mysql_query($sql_query);
	$resultx=mysql_fetch_assoc($result_set);
	$EmailS= $resultx[Email];
	$PasswdS= $resultx[Password];
	if($EmailS==$strEMAIL)
	{
		
	$regTime = time();
	/////////////////////////////
	$interval = 60*1;
	///找密码
	$pwd = $PasswdS;
	
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
		$mail->addAddress($EmailS,'这个QQ的昵称'); //85301868 //
		$mail->Subject = '用户密码找回';
		$mail->Body = "<b style=\"color:red;\">PHPMailer</b>尊敬的用户".$strName."，这是你的登陆密码，请注意查收：".$pwd;
		//$mail->addAttachment('./src/20151002.png','test.png');
		$status = $mail->send();
		if($status) 
		{
			$resultJson = array("state"=>200);//成功
			//echo "成功";
		}
        
	}else  $resultJson = array("state"=>0);//邮箱不对
		echo urldecode(json_encode($resultJson));//Json格式输出

?>

