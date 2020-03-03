<?php
/*
函数名：dbSave($dbhost,$dbname,$dbuser,$dbpwd))
参数：
     $dbhost： 数据库主机 localhost
	 $dbname:  数据库名
	 $dbuser： 数据库账户 root
	 $dbpwd：  数据库密码
         
作用：仿phpadmin数据库导出sql


*/
 

function dbSave($dbhost,$dbname,$dbuser,$dbpwd)
{ 
 
 header("Content-type:text/html;charset=utf-8");
 
 date_default_timezone_set("Asia/Shanghai");
 $dateTime=date("Y-m-d");
 
 //配置信息
 $cfg_dbhost = $dbhost;
 $cfg_dbname = $dbname;
 $cfg_dbuser = $dbuser;
 $cfg_dbpwd = $dbpwd;
 $cfg_db_language = 'utf8';
 
 
 $to_file_name = $cfg_dbname.$dateTime.".sql";  //执行后输出地址及文件


 $link = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
 mysql_select_db($cfg_dbname);
 
 mysql_query("set names ".$cfg_db_language);
 
 $tables = mysql_query("SHOW TABLES FROM $cfg_dbname");
 
 $tabList = array();
 while($row = mysql_fetch_row($tables))
 {
  $tabList[] = $row[0];
 }
 
 echo "运行中<br/>";
 $info = "-- ----------------------------\r\n";
 $info .= "-- 日期：".date("Y-m-d H:i:s",time())."\r\n";
 $info .= "-- ----------------------------\r\n\r\n";
 file_put_contents($to_file_name,$info,FILE_APPEND);
 
 //创建数据库
 $sqlStr="CREATE DATABASE `".$cfg_dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `".$cfg_dbname."`;\r\n\r\n";
 file_put_contents($to_file_name,$sqlStr,FILE_APPEND);
 
 //将每个表的表结构导出到文件
 foreach($tabList as $val)
 {
  $sql = "show create table ".$val;
  $res = mysql_query($sql,$link);
  $row = mysql_fetch_array($res);
  $info = "-- ----------------------------\r\n";
  $info .= "-- Table structure for `".$val."`\r\n";
  $info .= "-- ----------------------------\r\n";
  $info .= "DROP TABLE IF EXISTS `".$val."`;\r\n";
  $sqlStr = $info.$row[1].";\r\n\r\n";
  file_put_contents($to_file_name,$sqlStr,FILE_APPEND);
  mysql_free_result($res);
 }
 
 //将每个表的数据导出到文件
 foreach($tabList as $val)
 {
  $sql = "select * from ".$val;
  $res = mysql_query($sql,$link);
  //如果表中没有数据，则继续下一张表
  if(mysql_num_rows($res)<1) continue;
  //
  $info = "-- ----------------------------\r\n";
  $info .= "-- Records for `".$val."`\r\n";
  $info .= "-- ----------------------------\r\n";
  file_put_contents($to_file_name,$info,FILE_APPEND);
  //读取数据
  while($row = mysql_fetch_row($res))
  {
   $sqlStr = "INSERT INTO `".$val."` VALUES (";
   foreach($row as $zd)
   {
    $sqlStr .= "'".$zd."', ";
   }
   //去掉最后一个逗号和空格
   $sqlStr = substr($sqlStr,0,strlen($sqlStr)-2);
   $sqlStr .= ");\r\n";
   file_put_contents($to_file_name,$sqlStr,FILE_APPEND);
  }
  //释放资源
  mysql_free_result($res);
  file_put_contents($to_file_name,"\r\n",FILE_APPEND);
 }
 
 echo "OK!";
 

} 
?>