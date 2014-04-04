<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_xexe', '1395382809', 'template/default/space_xexe');?><head>
<link href="http://www.gzevergrandefc.com/css/Public.css" rel="stylesheet" type="text/css" />
<style>
.Banglist{
display:block;
}
</style>
</head>
<div class="bang">
<div id="list">
<?=$data?>
</div>
</div>
<script src="http://www.gzevergrandefc.com/js/jquery-1.7.2.js" type="text/javascript"></script>

<script>
 $("#list .Banglist").eq(0).show().siblings().hide();
</script>
<?php ob_out();?>