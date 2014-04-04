$(function(){
    $('.outside_box').css("height", $('.outside_box').css("width"));
    $('.inside_box').css("height", $('.inside_box').css("width"));

    window.onresize = function(){
        $('.outside_box').css("height", $('.outside_box').css("width"));
        $('.inside_box').css("height", $('.inside_box').css("width"));

    }




});