<?php
/*
函数名：dbLoad($dbhost,$dbname,$dbuser,$dbpwd,$dbfile)
参数：
     $dbhost： 数据库主机 localhost
	 $dbname:  数据库名
	 $dbuser： 数据库账户 root
	 $dbpwd：  数据库密码
	 $dbfile： 要导入的sql文件及位置
         
作用：sql数据库文件覆盖原数据库

*/


function dbLoad($dbhost,$dbname,$dbuser,$dbpwd,$dbfile)
{    
	
	
	$cfg_dbhost = $dbhost;
    $cfg_dbname = $dbname;
    $cfg_dbuser = $dbuser;
	$cfg_dbpwd = $dbpwd;
	
	$filename = $dbfile;
    
	
	$sql = file_get_contents($filename);
    $arr = explode(';', $sql);
	
	
    $drop = "DROP DATABASE IF EXISTS ".$cfg_dbname;
	mysql_query($drop,$con)or die(mysql_error()."42");  
	
	$mysqli = new mysqli($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	$mysqli->query("set names 'utf8'");
	$mysqli->query("set character_set_client=utf8");
	$mysqli->query("set character_set_results=utf8");
	foreach ($arr as $value) 
	{
       $mysqli->query($value.';');
    }
	$mysqli->close();
    $mysqli = null;
	
}
	

?>

