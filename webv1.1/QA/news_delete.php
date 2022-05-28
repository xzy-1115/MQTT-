<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 session_start();
header('Content-type:text/html;charset=utf-8');
$id = $_GET['time'];
if($id == 0){
    header('Refresh:3;url=news.php');
    echo '当前要删除的问题不存在！';
    exit;
}
//调用数据库删除数据
include_once ("connect.php");
//组织SQL并执行
mysql_query("delete from qa_list where  UserName = '".$_SESSION['UserName']."' and Time = '".$id."'  ");
//提示
header('Refresh:1;url=news.html');
echo '删除成功';

?>