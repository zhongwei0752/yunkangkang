<?php
include_once('./common_inc.php');
$uid = $_COOKIE[uchome_viewuid] ;

//菜单列表
if ($_GET['type'] == 'menu') {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('reservation')."   where uid='$uid' ORDER BY dateline DESC ");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$sql = "select * from ".tname('reservationfield')." where reservationid='$value[reservationid]'  ";
				$query2 = $_SGLOBAL['db']->query($sql);
				$value2 = $_SGLOBAL['db']->fetch_array($query2);

				$pic = $value['imageurl'];
				$s[] = '<a   rel="external" class="news_link">
				          <table>
				            <tr>
				              <td class="news_pic">
				                  <img src="'.$pic.'" alt="">
				              </td>
				              <td class="news_info">
				                  <span class="main_span">'.$value['subject'].'</span><br>
				                  <span class="other_span">'.$value2['message'].'</span>
				              </td>
				              <td>
				                  <a href="reservation-detail.php?reservationid='.$value['reservationid'].'" title="" class="apply_btn3" style="">详情</a>
				                  <a href="javascript:order('.$value['reservationid'].')" title="" class="apply_btn3" style="">点餐</a>
				              </td>
				            </tr>
				          </table>
				     </a>';
				echo "<p>asdasdasdasdasd</p>";
	}
	echo json_encode($s);
}


?>