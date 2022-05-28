<?php
$SN =$_GET['SN'];	
$indexnum=(int)$_GET['indexnum'];
$ProtocolStr;
$count;


include_once ("../connect.php");

$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction  



	$sql_query="SELECT * FROM device_protocol WHERE SN='".$SN."' and UseFlag = 1 ";
    $res = mysql_query($sql_query);
    $result=mysql_fetch_assoc($res);
    $ProtocolStr=$result[Protocol];

$SQLSTRx =  "SELECT COUNT(*) AS count FROM device_alarm_show where  SN='".$SN."' and Protocol='".$ProtocolStr."' order by Time desc ";

$resultx = mysql_query($SQLSTRx);
$rowx = mysql_fetch_array($resultx,MYSQL_ASSOC);
$count = $rowx['count'];

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)

//$responce = (object) array('page' => $page, 'total' => $total_pages, 'records' =>$count, 'rows' => "");

$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;


	$SQLSTR =  "SELECT * FROM device_alarm_show where SN='".$SN."' and Protocol = '".$ProtocolStr."' order by Time desc";
	$result = mysql_query($SQLSTR);
	$row;
	$i=0;
	$num=0;
	$ofset;
	$opstr;
	$index=1;
	while($row=mysql_fetch_array($result)){
		if(($indexnum-1)*30<$index  &&  $index<=$indexnum*30){
			$i++;
			$ofset=$row['Offset'];
			$sql_query1="SELECT * from protocol_detail where  Protocol = '".$ProtocolStr."' and Offset = '".$ofset."' ";
			$res1 = mysql_query($sql_query1);
			$result1=mysql_fetch_assoc($res1);
			$opstr=$row['Operation'];
			if($opstr){$opstr='已处理';}
			else $opstr='未处理';
			$responce->rows[$num]['cell']=array($i,$row['Offset'],$row['ActVar'], $row['AlaCode'], $row['Time'],$opstr,$row['EndTime']);
			// $responce->rows[$num]['cell']=array($i,$result1[ItemName],"3","4","5","6","7");
			$num++;
		}
		$index++;
		
	}

		echo json_encode($responce); 

?>