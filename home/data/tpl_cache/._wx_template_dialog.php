<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/dialog', '1387354147', './wx/template/dialog');?><!DOCTYPE html> 
<html> 
<head> 
   <meta name="viewport" content="width=device-width,initial-scale=1" />  
   <meta http-equiv="content-type"content="text/html; charset=UTF-8"/>  
   <title><?=$appname?></title> 
   <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
   <link rel="stylesheet" href="template/2/css/jquery-mobile-fluid960.min.css">
   		<?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
<link rel = "stylesheet" type = "text/css" href = "template/css/main.css">
<link rel="stylesheet" href="template/css/mobiscroll.custom-2.5.4.min.css">
<?php } else { ?>
<link rel = "stylesheet" type = "text/css" href = "template/<?=$bac['moblieclicknum']?>/css/main.css">
<link rel="stylesheet" href="template/<?=$bac['moblieclicknum']?>/css/mobiscroll.custom-2.5.4.min.css">
<?php } ?>
   
   <script src="template/js/jquery-v2.0.2.js"></script>
   <script src="template/js/mobiscroll.custom-2.5.4.min.js"></script>
   <script src="template/js/scrollbox.js"></script>
   <script src="template/js/js/jquery.query.js" type="text/javascript"></script>
   <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
   <script type="text/javascript" src="template/js/feed.js"></script>
    
<script id="detailTemplate" type="text/x-jquery-tmpl">
<li>
<a href = "wx.php?do=detail&id={{= id}}&uid={{= askid}}&wxkey=<?=$_GET['wxkey']?>&viewuid={{= q_uid}}&idtype=dialogid&type=dialog&cheak=1">
<div class="listOuter">
<h4>{{= subject}}</h4><br/>
<h4 style="font-size:10px;color:#999;">{{= name}}发布于{{= q_dateline}}</h4>
</div>

</a>
</li>
 
</script>

</head>
   <body> 
<div class = "navigation">
<span>在线沟通</span>
<?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
<a href = "#" id = "show" class = "menu_btn"><img src = "./template/img/menu_btn.png" id = "show" /></a>
<?php } else { ?>
<a href = "#" id = "show" class = "menu_btn"><img src = "./template/<?=$bac['moblieclicknum']?>/img/menu_btn.png" id = "show" /></a>

<?php } ?>
</div>
<ul class = "list mt55">
<div id="detail-panel"></div>	
</ul>
<input type = "button"  onclick="getComment($('#idtype').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());" value = "更多" class = "more_button"  />
<input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
            <input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
            <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
             <input type="hidden" id="viewuid" name="viewuid" value="<?=$viewuid?>"/>
            <input type="hidden" id="page" name="page" value="2"/>
            <input type="hidden" id="perpage" name="perpage" value="4"/>
            <br />
            <br />
            <br />
            <br />
            <br />
<div class = "comment_add onlineComment">
<textarea placeholder = "输入你的问题..." class = "comment_area" id = "question"></textarea>
<span id="uploadquestion">
<input type = "button"  class = "ask_btn btn" value = "发起提问" onclick='ask($("#uid").val(),$("#question").val(),<?=$viewuid?>)'/>
<span>
</div>
<div style = "display: none;">
<select name="" id="demo" class="f-dd">
<option value="wx.php?do=home&uid=<?=$_GET['uid']?>">首页</option>
    <?php if(is_array($zhongwei)) { foreach($zhongwei as $value) { ?>
                <option value="wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value['english']?>"><?=$value['subject']?></option>
                <?php } } ?>
                <?php if($zhongwei1) { ?>
                <?php if(is_array($zhongwei1)) { foreach($zhongwei1 as $value1) { ?>
                <option value="wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value1['english']?>"><?=$value1['subject']?></option>
                <?php } } ?>
                <?php } ?>
</select>
</div>
<script>
function ask(askid,subject,q_uid){
$.ajax({
//dataType:"jsonp",
url:"http://v5.home3d.cn/home/capi/cp.php?ac=dialog&op=ask",
type: "POST",
data:{
"askid":askid,
"subject": subject,
"q_uid":q_uid
},
success:function(data){
alert("发表成功");
$("#uploadquestion").html("<input type = 'button'  class = 'ask_btn btn' value = '发表成功'/>");
window.location.reload();
},
error:function(data){
console.log("error");
}
});
}
</script>
</body>
     
</html>  <?php ob_out();?>