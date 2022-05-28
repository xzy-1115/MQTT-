<?php
include_once ("../connect.php");
session_start();
$NAME = $_POST['USERNAME'];					//用户名				                        
//$ADDRESS=$_POST['ADDRESS'];			
//

//$INDUSTRYTYPE = $_POST['INDUSTRYTYPE'];	   	
//$COMPANY = $_POST['COMPANY'];	                     
$UserName1=$_SESSION['UserName'];
$OLDPS=$_POST['OLDPS'];
$NEWPS=$_POST['NEWPS'];
$NEWPSVF=$_POST['NEWPSVF'];

$PHONE_NUM=$_POST['PHONE_NUM'];
//$EMAIL_STR=$_POST['EMAIL_STR'];
$MESSVFSTR=$_POST['MESSVFSTR'];
$verify_code=$_POST['verify_code'];

if($NAME==''){
	    $resultJson = array("state"=>0);
}
else {
	    if($MESSVFSTR==$verify_code)
		{
				$sql_queryx="select * from  use_login  where UserName='".$UserName1."'"; 
				$resultx=mysql_query($sql_queryx);
				$rowx = mysql_fetch_assoc($resultx); 
				if($rowx[Password]==$OLDPS)
				{
					if($NEWPS==$NEWPSVF)	
					{
						// if($INDUSTRYTYPE=='1')
						// {
						// 	$INDUSTRYTYPE='温控系统';
						// }else if($INDUSTRYTYPE=='2')
						// {
						// 	$INDUSTRYTYPE='农业大棚';
						// }
						// else if($INDUSTRYTYPE=='0')
						// {
						// 	$INDUSTRYTYPE='智能车库';
						// }

							//update use_login set Name = 0 ,Company=,IndustyType= where UserName='".$SN."' 
							 $sql_query="update use_login set Password='".$NEWPS."' , Phone='".$PHONE_NUM."',Name ='".$NAME."' where UserName='".$UserName1."' "; 
							
							 if(mysql_query($sql_query)){
								 $resultJson = array("state"=>200);
							  }
							  else $resultJson = array("state"=>2);
					}
					else  $resultJson = array("state"=>4);
				}
				else   $resultJson = array("state"=>3);
		}		
		else  $resultJson = array("state"=>1);
}		 
	
echo urldecode(json_encode($resultJson));//Json格式输出
?>