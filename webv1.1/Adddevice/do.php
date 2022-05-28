<?php

include_once ("../connect.php");
session_start();
$IndustryType;
$runstr=0;
$Use=$_SESSION['UserName'];
$action = isset($_GET['action']) ? $_GET['action'] : "";
switch ($action) {
    case 'list' : //列表
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
		$startTime = date("Y-m-d H:i:s", strtotime('-300 minutes', time()));
		
        if (!$sidx)
            $sidx = 1;


        $result = mysql_query("SELECT COUNT(*) AS count FROM dev_verify");
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $count = $row['count'];
        //echo $count;

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) $page = $total_pages;
        $start = $limit * $page - $limit;
		$responce = (object) array('page' => $page, 'total' => $total_pages, 'records' =>$count, 'rows' => "");
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i = 0;
		$row;
        $sql="select * from user_device where UserName = '".$Use."' "; 
        $result_set = mysql_query($sql);
		
		while($row=mysql_fetch_array($result_set)){
		$strSN=$row['SN'];
		/////测是否在线/////
		$sql_queryt="SELECT * FROM device_online_list WHERE SN='".$strSN."'  order by Time desc limit 1";
		$result_sett=mysql_query($sql_queryt);
		$resultt=mysql_fetch_assoc($result_sett);
		if(mysql_num_rows($result_sett)>0)
		{	
			if(strtotime($startTime)<strtotime($resultt['Time']))
			{   
		            $runstr=1;
			}
			else $runstr=0;
		}else $runstr=0;
		//////////////////////
		$sql_query1="SELECT * from dev_verify where  SN = '".$strSN."'";
		$res1 = mysql_query($sql_query1);
		$result1=mysql_fetch_assoc($res1);
		
		$sql_query2="SELECT * from device where  SN = '".$strSN."'";
		$res2 = mysql_query($sql_query2);
		$row1=mysql_fetch_assoc($res2);
		if($row1['IndustryType']==0)$IndustryType='智能车库';
		else if($row1['IndustryType']==1)$IndustryType='温控系统';
		else if($row1['IndustryType']==2)$IndustryType='农业大棚';
		//else $IndustryType='错误';
		if($runstr == 1){
					$RunStatus= "在线";
					}else{
					$RunStatus = "离线";
					}
			$responce->rows[$i]['cell']=array($strSN,$row1[DevType],$result1[CheckCode],$row1[SecUsrTime],
			$row1[LocalName],$IndustryType,$row1[Address],$row1[Longtitude],$row1[Latitude],$RunStatus );
			$i++;
		}
        //print_r($responce);
        echo json_encode($responce);
        break;
    case 'add' : //新增
        $pro_title = htmlspecialchars(stripslashes(trim($_POST['pro_title'])));
        $pro_sn = htmlspecialchars(stripslashes(trim($_POST['pro_sn'])));
        $size = htmlspecialchars(stripslashes(trim($_POST['size'])));
        $os = htmlspecialchars(stripslashes(trim($_POST['os'])));
        $charge = htmlspecialchars(stripslashes(trim($_POST['charge'])));
        $price = htmlspecialchars(stripslashes(trim($_POST['price'])));
        if (mb_strlen($pro_title) < 1)
            die("产品名称不能为空");
        $addtime = date('Y-m-d H:i:s');
        $query = mysql_query("insert into products(sn,title,size,os,charge,price,addtime)values('$pro_sn','$pro_title','$size','$os','$charge','$price','$addtime')");
        if (mysql_affected_rows($link) != 1) {
            die("操作失败");
        } else {
            echo '1';
        }

        break;
    case 'del' : //删除
        $SNdel = $_POST['SNdel'];
		$sql_querydel="update dev_verify set CheckCode = '验证码失效' where SN='".$SNdel."' ";
		mysql_query($sql_querydel);
		$sql_querydel="delete from device where SN = '".$SNdel."' ";
		mysql_query($sql_querydel);
		$sql_querydel="delete from device_alarm_detail where SN = '".$SNdel."' ";
		mysql_query($sql_querydel);
		$sql_querydel="delete from device_alarm_show where SN = '".$SNdel."' ";
		mysql_query($sql_querydel);
		$sql_querydel="delete from device_data_save where SN = '".$SNdel."' ";
		mysql_query($sql_querydel);
		$sql_querydel="delete from device_online_list where SN = '".$SNdel."' ";
		mysql_query($sql_querydel);
		//////////////////////////////////////////////////////////////////////////
		$oldprot;
	    $sql_query2="SELECT * from device_protocol where SN = '".$SNdel."' ";
		$res2=mysql_query($sql_query2);
		$row1=mysql_fetch_assoc($res2);
		$oldprot=$row1[Protocol];
		//2.删除行
		$sql_query2="delete from device_protocol where SN = '".$SNdel."' ";
		mysql_query($sql_query2);
		//3.protocol查有没有
		$sql_query2="SELECT * from device_protocol where Protocol = '".$oldprot."' ";
		$res3=mysql_query($sql_query2);
		if(mysql_num_rows($res3)>0)
		{	

		}
		else {
					$sql_querydel="delete from protocol_master where Protocol = '".$oldprot."' ";
					mysql_query($sql_querydel);
					$sql_querydel="delete from protocol_detail where Protocol = '".$oldprot."' ";
					mysql_query($sql_querydel);
		}
			//////////////////////////////////////////////////////////
		$sql_querydel="delete from realtime_rules where SN = '".$SNdel."' ";
		mysql_query($sql_querydel);
		$sql_query="delete from user_device where SN = '".$SNdel."'  ";
	    $result_set=mysql_query($sql_query);
		
		if($result_set)echo '1';
		else die("操作失败");
        break;
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