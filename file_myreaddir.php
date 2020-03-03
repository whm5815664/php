<?php
/*
函数名：myreaddir($dir) 
参数：
     $dir： 文件夹名（目录）
         
返回值：
     目标文件夹下所有文件名   
	 
例：
     $facearray = myreaddir("../test");

*/



function myreaddir($dir) 
{
        $handle=opendir($dir);
        $i=0;
        while(!!$file = readdir($handle)) 
		{
            if (($file!=".")and($file!="..")) {
                $list[$i]=$file;
                $i=$i+1;
            }
        }
        closedir($handle);
        return $list;
}

?>



					
        