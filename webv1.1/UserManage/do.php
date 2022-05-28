<?php
session_start();
include_once ("connect.php");
$Use=$_SESSION['UserName'];
$action = isset($_GET['action']) ? $_GET['action'] :$_POST['action'];

switch ($action) {
    case 'list' : //列表
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
//		$page = 1;
//		$limit = 12;
//		$sidx = 'id';
//		$sord = 'asc';
        if (!$sidx)
            $sidx = 1;

        $result = mysql_query("SELECT COUNT(*) AS count FROM user_bind where User2 ='".$Use."' and Flag = 1 order by Time desc ");
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $count = $row['count'];

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - $limit;
        if ($start < 0)
            $start = 0;
		

        $responce = new stdClass();
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
		$num=0;
	    $SQL = "SELECT * FROM user_bind WHERE User2='".$Use."'  and Flag = 1 order By Time desc" ;//. $where . " ORDER BY $sidx $sord LIMIT $start , $limit";
        $result = mysql_query($SQL);
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
          //  $responce->rows[$i]['Num'] =$num;
			$num++;
         //   $opt = "<a href='#'>修改</a>";
			$SQLx = "SELECT * FROM use_login WHERE UserName='".$row[User3]."' " ;//. $where . " ORDER BY $sidx $sord LIMIT $start , $limit";
			$resultx = mysql_query($SQLx); 
			$resultyx=mysql_fetch_assoc($resultx);
			if($resultyx['IndustyType']=='0'){$IndustryType='智能车库';}
		if($resultyx['IndustyType']=='1'){$IndustryType='农业大棚';}
		if($resultyx['IndustyType']=='2'){$IndustryType='温控系统';}

            $responce->rows[$i]['cell'] = array(
			    $num,
                $row[User3],
                $resultyx['Name'],
                $resultyx['Phone'],
                $resultyx['Email'],
                $resultyx['Company'],
              $IndustryType
              //  $opt
            );
            $i++;
        }
        //print_r($responce);
        echo json_encode($responce);
        break;
     case 'add' : //新增
        $username = htmlspecialchars(stripslashes(trim($_POST['username'])));
        $passwd = htmlspecialchars(stripslashes(trim($_POST['passwd'])));
        $sql_query="SELECT * FROM use_login WHERE UserName='".$username."' and Password='".$passwd."' ";
		$result_set=mysql_query($sql_query);
		$result=mysql_fetch_assoc($result_set);
		$Role= $result[Role];
		if(mysql_num_rows($result_set)>0)
		{
			if($Role==3)
			{
			  $sql_queryx="SELECT * FROM user_bind WHERE User2='".$Use."' and User3='".$username."' ";
	          $result_setx=mysql_query($sql_queryx);
			  if( mysql_num_rows($result_setx)>0){
				  echo '1';
			  }
			  else {
				$sql_queryy="insert into user_bind(User2,User3,Flag,Time) values('".$Use."','".$username."', 1 ,now()) ";
			    $result_sety=mysql_query($sql_queryy);
				echo '1';
			  }
			}
			else die("验证失败");
	    }
	    else die("验证失败");
  
        break;
    case 'del' : //删除
        $ids = $_POST['ids'];
		$user3name=$_POST['usr3name'];
		$sql_query="delete from user_bind where User2 = '".$Use."' and User3 = '".$user3name."' ;  ";
	    $result_set=mysql_query($sql_query);
		$sql_query="delete from use_login where UserName = '".$user3name."' ;  ";
	    $result_set=mysql_query($sql_query);
		echo $user3name;
        //delAllSelect($ids, $link);
        break;
///////////////
   case 'adddev' : //新增
        $username = htmlspecialchars(stripslashes(trim($_POST['username'])));
        $passwd = htmlspecialchars(stripslashes(trim($_POST['passwd'])));
		$user3name = htmlspecialchars(stripslashes(trim($_POST['user3name'])));
		$startTime = date("Y-m-d H:i:s", strtotime('-300 minutes', time()));
		$sql_query="SELECT * FROM dev_verify WHERE SN='".$username."' and CheckCode ='".$passwd."' order by Time desc";
		$result_set=mysql_query($sql_query);
		if(mysql_num_rows($result_set)>0)
	    {
		//1.查到数据
	//	$row=mysql_fetch_row($result_set);
		//提取发布验证码的时间和设备协议
	//	$ValidTime = $row[3];
		//echo "验证码时间".$row[3]."<br>"; 			
	//	if(strtotime($startTime)<strtotime($ValidTime))
	//	{   
	        //验证成功
			
			
			$sql_queryc="SELECT * FROM use_login WHERE UserName='".$user3name."' ";
			$result_setc=mysql_query($sql_queryc);
			$result=mysql_fetch_assoc($result_setc);
			$Cpany= $result[Company];
			
			  $sql_queryc="SELECT * FROM device WHERE SN='".$username."' ";
	          $result_setc=mysql_query($sql_queryc);
			  if( mysql_num_rows($result_setc)>0){
				  $sql_queryx="SELECT * FROM user_device WHERE SN='".$username."' and UserName='".$user3name."' and UseFlag = 1 ";
				  $result_setx=mysql_query($sql_queryx);
				  if( mysql_num_rows($result_setx)>0){
					  echo '此设备已经存在';
				  }
				  else {
					$sql_queryy="insert into user_device(SN,UserName,Time,UseFlag,Company) values('".$username."','".$user3name."',now(), 1 ,'".$Cpany."') ";
					$result_sety=mysql_query($sql_queryy);
					echo '1';
				  }
			  }
			  else 
			  {
				 echo '此设备没有注册'; 
			  }
	//	}
			/*else 
			{

				die("验证失败");
	
			}*/
        }
		else  die("验证失败");
        break;
    case 'deldev' : //删除
        $name3 = $_POST['name3'];
		$devstring=$_POST['devstring'];
		$sql_query="delete from user_device where UserName = '".$name3."' and SN = '".$devstring."' ;  ";
	    $result_set=mysql_query($sql_query);
		echo $name3;
        //delAllSelect($ids, $link);
        break;
//////////////////	

    case '' :
        echo 'Bad request.';
        break;
}

//批量删除操作
function delAllSelect($ids, $link) {
    if (empty($ids))
        die("0");
    mysql_query("update products set deleted=1 where id in($ids)");
    if (mysql_affected_rows($link)) {
        echo $ids;
    } else {
        die("0");
    }
}

//处理接收jqGrid提交查询的中文字符串
function uniDecode($str, $charcode) {
    $text = preg_replace_callback("/%u[0-9A-Za-z]{4}/", toUtf8, $str);
    return mb_convert_encoding($text, $charcode, 'utf-8');
}

function toUtf8($ar) {
    foreach ($ar as $val) {
        $val = intval(substr($val, 2), 16);
        if ($val < 0x7F) { // 0000-007F
            $c .= chr($val);
        } elseif ($val < 0x800) { // 0080-0800
            $c .= chr(0xC0 | ($val / 64));
            $c .= chr(0x80 | ($val % 64));
        } else { // 0800-FFFF
            $c .= chr(0xE0 | (($val / 64) / 64));
            $c .= chr(0x80 | (($val / 64) % 64));
            $c .= chr(0x80 | ($val % 64));
        }
    }
    return $c;
}

?>