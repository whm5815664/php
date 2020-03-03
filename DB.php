<?php
       
	   //创建连接变量 接入数据库
	   $con=mysql_connect("localhost","root","");  
	   if(!$con){die("无法连接");}
	   mysql_query("set names 'utf8'");                
	   mysql_query("set character_set_client=utf8");
	   mysql_query("set character_set_results=utf8");
	   
	   //选择数据库
	   mysql_select_db("vegetable",$con);      //填写数据库名称           
?>