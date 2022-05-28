<?php
$inputstr=$_GET['inputstr'];
$search_type=$_GET['search_type'];
include('../connect.php');
session_start();
$Use=$_SESSION['UserName'];
$responce;
if($search_type==0){
///列出全部内容	
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

        $result = mysql_query("SELECT COUNT(*) AS count FROM user_bind where User2 ='".$Use."' and Flag = 1  ");
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
		if($resultyx['IndustyType']=='1'){$IndustryType='温控系统';}
		if($resultyx['IndustyType']=='2'){$IndustryType='农业大棚';}

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
echo json_encode($responce);	
}
else {
	if($inputstr==''){
		///请输入您要搜索的内容
	echo json_encode($responce); 
	}	
	else {
		if($search_type==1){
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

        $count = 1;

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
	    $SQL = "SELECT * FROM user_bind WHERE User2='".$Use."'  and User3 = '".$inputstr."' " ;//. $where . " ORDER BY $sidx $sord LIMIT $start , $limit";
        $result = mysql_query($SQL);
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$num++;
			$SQLx = "SELECT * FROM use_login WHERE UserName='".$inputstr."' " ;//. $where . " ORDER BY $sidx $sord LIMIT $start , $limit";
			$resultx = mysql_query($SQLx); 
			$resultyx=mysql_fetch_assoc($resultx);
			if($resultyx['IndustyType']=='0'){$IndustryType='智能车库';}
		if($resultyx['IndustyType']=='1'){$IndustryType='温控系统';}
		if($resultyx['IndustyType']=='2'){$IndustryType='农业大棚';}

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
			
		}
			else if($search_type==2){
				
				
			}
				else if($search_type==3){
					
					
				}
					else if($search_type==4){
						
						
					}
						else if($search_type==5){
							
							
						}
							else if($search_type==6){
								
								
							}
		echo json_encode($responce); 
	}
}

?>





