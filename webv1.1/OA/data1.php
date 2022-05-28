<?php
include('dbconfig.php');
session_start();
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction  
/////////////////
//protocol_detail查字段的上下限
//device_alarm_detail;  报警上下限 报警类型
//device_alarm_show; 报警显示的种种
//
$username=$_SESSION['UserName'];//"wld";//
$db = mysql_connect($dbhost, $dbuser, $dbpassword)
or die("Connection Error: " . mysql_error());
mysql_select_db($database) or die("Error conecting to db.");
mysql_query("set names 'utf8'");

$count = 10;

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)

$responce = (object) array('page' => $page, 'total' => $total_pages, 'records' =>$count, 'rows' => "");

$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

//////
$i=0;

$SQLSTR =  "select * from user_bind where User2 = '".$username."' and Flag =1 ";
$result = mysql_query($SQLSTR);
while($row=mysql_fetch_array($result)){
	$sql =  "select * from oa_list where UserName = '".$row['User3']."'  order by Time DESC ;	 ";
	$sqlresult = mysql_query($sql);
	while($row2=mysql_fetch_array($sqlresult)){
		$responce->rows[$i]['cell']=array($row2['UserName'],$row2['Time'],$row2['SN'],$row2['Message']);
		$i++;
	}
}

echo json_encode($responce); 

?>