<?php  
 define(HOST, '58.215.187.8');  
  define(USER, 'zhongwei');  
  define(PW, '623610577');  
  define(DB, 'zhongwei');
/*    define(HOST, 'localhost');  
  define(USER, 'root');  
  define(PW, '2316663');  
  define(DB, 'new');*/
  $connect = mysql_connect(HOST, USER, PW)  
  or die('Could not connect to mysql server');  
  
  mysql_select_db(DB,$connect)  
  or die('Could not select database.');  
  //设置查询编码，不设查询时易出现乱码  
  mysql_query('set names utf8;');  
  
  switch($_REQUEST['category']) {  
    //显示数据库中所有省份  
    case 'province':  
        $str = "<option value='0'>请选择组件</option>";  
        $sql = "select * from uchome_menuset";  
        $result = mysql_query($sql) or die (mysql_error());  
          
        if (mysql_num_rows($result) > 0) {  
          while ($row = mysql_fetch_array($result)) {  
            //print_r($row);  
            $str .= "<option value='".$row['english']."'>".$row['subject']."</option>";  
          }  
        }  
        echo $str;  
        mysql_free_result($result);  
        break;  
  
    //显示城市  
    case 'city':  
        $str = "<option value='0'>全部</option>";  
        if($_REQUEST["province"] != "") {  
           //根据省份得到城市  
        $sql = "select * from uchome_".$_REQUEST['province']." where uid='$_REQUEST[uid]'";  
        $result = mysql_query($sql) or die (mysql_error());  
  
        if (mysql_num_rows($result) > 0) {  
          while ($row = mysql_fetch_array($result)) {  
            $str .= "<option value='".$row["".$_REQUEST['province']."id"]."'>".$row['subject']."</option>";  
          }  
        }  
        mysql_free_result($result);  
        }//end of if  
        echo $str;  
        break;  
          
  }//end of switch  
  
?>  