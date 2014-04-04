
$(document).ready(function(){

      // alert("1122")
    /*注册登录按钮特效*/
    $(".zhuce_1").mouseover(function(){
        $(".zhuce_1 img").attr("src","./template/default/image/zhuceleft2.fw.png")
    })
    $(".zhuce_1").mouseout(function(){
        $(".zhuce_1 img").attr("src","./template/default/image/zhuceleft.fw.png")
    })

    $(".zhuce_2").mouseover(function(){
        $(".zhuce_2 img").attr("src","./template/default/image/zhuceright2.fw.png")
    })
    $(".zhuce_2").mouseout(function(){
        $(".zhuce_2 img").attr("src","./template/default/image/zhuceright.fw.png")
    })



})