<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_booking_view', '1396519090', 'template/default/space_booking_view');?><!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="template/css/yunkangbase.css">
    <link rel="stylesheet" href="template/css/yunkangmain.css">

    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="template/js/jquery-v2.0.2.js"></script>
    <script src="template/js/scrollbox.js"></script>
    <script src="template/js/jquery-1.9.1.min.js"></script>
    <script src="template/js/mobiscroll.custom-2.5.4.min.js"></script>
   <!-- <script src="js/jquery.mobile.min.js"></script>  -->
    <title>接种预约</title>
</head>
<body>
     <div class="mainbody">
        <div class="listbox">
             <div class="listuppic"></div>
             <div class="listcontent">
                 <div class="logotitle">
                    <div class="leftcol"></div>
                    <div class="rightpic"><img src="template/img/logo.png"></div>
                    <div class="clear"></div>
                 </div>
                 <div class="listcontentbody">
                     <div class="listtil"><?=$list1['subject']?></div>
                     <div class="listcon">
                         <div class="l1">
                             <span class="l1_s1">接种地点：</span>
                             <span class="l1_s2"><?=$list1['location']?></span>
                         </div>
                         <div class="l1">
                             <span class="l1_s1">接种时间：</span>
                             <span class="l1_s2"><?php echo date('Y-m-d H:i',$bookingvalue['starttime']) ?></span>
                             <span class="l1_s2"><?php echo date('Y-m-d H:i',$bookingvalue['starttime']) ?></span>
                         </div>
                         <div class="l1">
                             <span class="l1_s1">接种名额：</span>
                             <span class="l1_s2"><?=$list1['people']?></span>
                         </div>                  
     </div>

<?php if($list) { ?>
<?php if(is_array($list)) { foreach($list as $value) { ?>
<div style="clear:both;height:20px;">

<span style="float: left;width: 100PX;">
<?=$value['username']?>
</span>
<span style="float: left;width: 100PX;">
<?=$value['telnumber']?>
</span>
<?php if($value['contact']==1) { ?>
<span style="float: left;width: 100PX;">
<input type="button"  value="已联系">
</span>
<?php } else { ?>
<span style="float: left;width: 100PX;">
<input type="button" class="contact" id="<?=$value['id']?>" value="联系" onclick="ChangeContact(<?=$value['id']?>);">

</span>

<?php } ?>
</div>
<?php } } ?>
<?php } ?>
  <div id="contactdetail"></div>
      <div>
      <?php if($commentcount1 >= 5) { ?>
       <input type = "button" onclick="getContact($('#page').val(),$('#perpage').val());" value = "更多"  id="wei" />
       <?php } ?>
        <input type="hidden" id="page" name="page" value="2"/>
        <input type="hidden" id="perpage" name="perpage" value="5"/>
        <input type="hidden" id="getpage" name="getpage" value="1"/>
        

    </div>

</body>
 <script>
 function ChangeContact(id)
 {
  $.ajax({

                type: "POST",
                url: "space.php?do=explain",
                data: "id="+id+"&booking=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                async: true,
                
                success: function (data) {
                  $("#"+id).val("已联系");
                }
              });
               

  
 }
    

    function getContact(page,perpage){
        
        $.ajax({

                type: "POST",
                url: "space.php?do=explain",
                data: "page="+page+"&perpage="+perpage+"&getpage=1&booking=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                async: true,
                
                success: function (data) {
                  var obj = jQuery.parseJSON(data);
                  var len = obj.length;
                  var html="";
                  if(len > 0)
                  {
                    for (var i in obj)
                    {
                        if(obj[i].contact==1)
                        {
                          html += "<div style='clear:both;height:20px;'><span style='float: left;width: 100PX;'>"+obj[i].username+"</span><span style='float: left;width: 100PX;'>"+obj[i].telnumber+"</span><span style='float: left;width: 100PX;'><input type='button'  value='已联系'></span></div>";

                        }
                        else
                        {
                          html += "<div style='clear:both;height:20px;'><span style='float: left;width: 100PX;'>"+obj[i].username+"</span><span style='float: left;width: 100PX;'>"+obj[i].telnumber+"</span><span style='float: left;width: 100PX;'><input type='button' class='contact' id="+obj[i].id+" value='联系' onclick='ChangeContact("+obj[i].id+");'></span></div>";
                        }
                        
                    }
                    $('#page').val(parseInt($('#page').val())+1);
                   $("#contactdetail").append(html);
                
                   }  
                   if(len < 5)
                   {
                       $("#wei").val("亲，没有了哦");
                   } 
                } 

            });
    };
</script>   

</html><?php ob_out();?>