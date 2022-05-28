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
$SQLSTR =  "select * from log where UserName = '".$username."'  order by Time DESC ;	 ";
$result = mysql_query($SQLSTR);
	while($row=mysql_fetch_array($result)){
		$responce->rows[$i]['cell']=array($row['UserName'],$row['Operate'],$row['Time']);
		$i++;
		//if($i>9)break;
	}
//////
//$responce->rows[0]['cell']=array('1','1',$i);
echo json_encode($responce); 

?>