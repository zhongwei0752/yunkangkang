<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template//dialogcontent', '1387178548', './wx/template//dialogcontent');?><!DOCTYPE html>
<html>
  <head>
  	 <title><?=$appsubject['subject']?></title>
  	 <meta charset="utf-8">
  	 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
        <link rel = "stylesheet" type = "text/css" href = "./template/css/main.css">
        <link rel="stylesheet" href="./template/css/base.css" />
<link rel="stylesheet" href="./template/css/expressInfo.css" />
<link rel="stylesheet" type="text/css" href="./template/css/jquery-mobile-fluid960.min.css">
        <link rel="stylesheet" type="text/css" href="./template/css/style.css">
        

     <script src="template/js/jquery-v2.0.2.js"></script>
     <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
     <script type="text/javascript" src="template/js/detail.js"></script>
     <script id="detailTemplate" type="text/x-jquery-tmpl"> 
         

<div class = "article_content mb100">
<ul class = "chat" id = "list-panel">

</ul>
</div>

     </script>
     <script id="liTemplate" type="text/x-jquery-tmpl"> 
     	           
                   <?=BLOCK_TAG_START?>if cheak<?=BLOCK_TAG_END?>
                   <li>
<div> 
<?=BLOCK_TAG_START?>if image1url<?=BLOCK_TAG_END?>
<img src=".{{= image1url}}" class="fr" />
<?=BLOCK_TAG_START?>else<?=BLOCK_TAG_END?>
<img src="./images/noavatar_small.gif" class="fr" />
<?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>

<img src="template/img/right_triangle.png" class="right_triangle fr" />
<div class="chatMessage fr color1">
<p>{{= name}}:{{= message}}</p>
<span>{{= dialog_dateline}}</span>
</div>
</div>
</li>
<?=BLOCK_TAG_START?>else<?=BLOCK_TAG_END?>
<li>
<div>
<?=BLOCK_TAG_START?>if image1url<?=BLOCK_TAG_END?>
<img src=".{{= image1url}}" class="fl" />
<?=BLOCK_TAG_START?>else<?=BLOCK_TAG_END?>
<img src="./images/noavatar_small.gif" class="fl" />
<?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
<img src="template/img/left_triangle.png" class="left_triangle fl" />
<div class="chatMessage fl color2">
<p>{{= name}}:{{= message}}</p>
<span>{{= dialog_dateline}}</span>
</div>
</div>
</li>
<?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
     </script>
  </head>

  <body style="background-color: white;"> 
  		<h3><?=$dialog['subject']?></h3>
<span class = "info_content_span subtitle"><?php echo sgmdate('Y-m-d H:i:s',$dialog[q_dateline]); ?></span>
<div class = "article" id = "detail-panel">

</div>
<div class = "comment_add onlineComment">
<textarea placeholder = "请输入你的回复..." class = "comment_area" id = "answer"></textarea>
<?php if(($_COOKIE['uchome_viewuid'])) { ?>
<?php if(($_COOKIE['uchome_viewuid']==$_GET['viewuid'])) { ?>
<input type = "button" class = "ask_btn btn" value = "回复" onclick="ans(<?=$_GET['viewuid']?>,<?=$_GET['uid']?>,$('#answer').val(),<?=$_GET['id']?>,1)"/>
<?php } elseif(($_COOKIE['uchome_viewuid']==$uidwxkey['service'])) { ?>
<input type = "button" class = "ask_btn btn" value = "回复" onclick="ans(<?=$_GET['viewuid']?>,<?=$_GET['uid']?>,$('#answer').val(),<?=$_GET['id']?>,2)"/>
<?php } else { ?>
<input type = "button" class = "ask_btn btn" value = "回复" onclick='ans(<?=$_COOKIE['uchome_viewuid']?>,<?=$_GET['uid']?>,$("#answer").val(),<?=$_GET['id']?>,4)'/>
<?php } ?>
<?php } else { ?>
<input type = "button" class = "ask_btn btn" value = "回复" onclick='ans(<?=$_GET['viewuid']?>,<?=$_GET['uid']?>,$("#answer").val(),<?=$_GET['id']?>,3)'/>
<?php } ?>


</div>
<input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
    <input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
    <input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
    <input type="hidden" id="type" name="type" value="<?=$_GET['type']?>"/>
    <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
    <input type="hidden" id="status1" name="status1" value="1"/>
    <input type="hidden" id="status2" name="status2" value="2"/>
    <input type="hidden" id="page" name="page" value="0"/>
    <input type="hidden" id="perpage" name="perpage" value="5"/>
</body>
</html><?php ob_out();?>