<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  session_start();
header('Content-type:text/html;charset=utf-8');
//接收要编辑的新闻ID
$id = $_GET['id']; //0不会存在
if($id == 0){
    header('Refresh:3;url=news.html');
    echo '当前要编辑的问题不存在！';
    exit;
}
$sql = "select * from qa_list where Time = '".$id."' and UserName = '".$_SESSION['UserName']."'  ";

//调用数据库删除数据
include_once ("connect.php");
//组织SQL并执行
$res = mysql_query($sql);//拿到结果集
$new = mysql_fetch_assoc($res);//$new代表一个数组

//加载模版
include_once 'news_edit.html'; 

?>