
$(function(){

    $("#backtop").hide();
    $(window).scroll(function(){
        if ($(window).scrollTop()>100){
            $("#backtop").fadeIn();
        }
        else{
            jQuery("#backtop").fadeOut();
        }
    });

    $("#backtop").click(function(){
        $("body,html").animate({scrollTop:0},1000);
        return false;
    });

    $("#backtop").mouseover(function(){
        $("#backtop img").attr("src","./template/default/image/back_top2.fw.png");
    })
    $("#backtop").mouseout(function(){
        $("#backtop img").attr("src","./template/default/image/back_top.png");
    })
})