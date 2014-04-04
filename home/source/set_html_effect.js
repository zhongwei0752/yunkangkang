$(function(){

   $("#firstButton img").mouseover(function(){
        $("#firstButton img").attr("src","./template/default/image/img/use_now2.png");
    })
    $("#firstButton img").mouseout(function(){
        $("#firstButton img").attr("src","./template/default/image/img/use_now3.png");
    })

    $("#secondButton img").mouseover(function(){
        $("#secondButton img").attr("src","./template/default/image/img/buy_now2.png");
    })
    $("#secondButton img").mouseout(function(){
        $("#secondButton img").attr("src","./template/default/image/img/buy_now3.png");
    })

    $("#thirdButton img").mouseover(function(){
        $("#thirdButton img").attr("src","./template/default/image/img/buy_now_green6.png");
    })
    $("#thirdButton img").mouseout(function(){
        $("#thirdButton img").attr("src","./template/default/image/img/buy_now_green5.png");
    })
})