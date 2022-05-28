<?
include_once ("connect.php");
$startTime;

$action = isset($_GET['action']) ? $_GET['action'] : "";
switch ($action) {
    case 'add' : //列表
        $username = htmlspecialchars(stripslashes(trim($_POST['username'])));
        $passwd = htmlspecialchars(stripslashes(trim($_POST['passwd'])));
       	$startTime = date("Y-m-d H:i:s", strtotime('-300 minutes', time()));
	//$QueryTime = date("Y-m-d H:i:s", time());
	//$sql_query="SELECT * FROM dev_verify WHERE SN='".$SN."' and CheckCode ='".$CheckCode."' and Time between '".$startTime."' and '".$QueryTime."'";
	$sql_query="SELECT * FROM dev_verify WHERE SN='".$username."' and CheckCode ='".$passwd."' order by Time desc";
	//echo $sql_query;
	$result_set=mysql_query($sql_query);
	if(mysql_num_rows($result_set)>0)
	{
		//1.查到数据
		$row=mysql_fetch_row($result_set);
		//提取发布验证码的时间和设备协议
		$DevPro = $row[2];	
		$ValidTime = $row[3];
		//echo "验证码时间".$row[3]."<br>"; 			
		if(strtotime($startTime)<strtotime($ValidTime))
		{   
               
				echo '1';
		}
			else die("验证失败");
    }
	else die("验证失败");
	  break;
 }
////
?>