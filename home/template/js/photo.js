
<script type="text/javascript">
$(document).ready(function(){
  $.ajax({
                type: "GET",
                url: "http://v5.home3d.cn/home/capi/source/space_photo.php",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                  if(data){
                    data=data.data.list;
                  }
                  for(var i=0,len=data.length;i<len;i++)
                  {
                    url0 = "http://qm.home3d.cn/home/"+data[i].filepath;
                    $(".container").append("<div class='imgShow'><a href='images/temp_img03.jpg'><img src='"+url0+"' /></a><p>标题</p></div>");
                  }
                }
              });
 });
</script>