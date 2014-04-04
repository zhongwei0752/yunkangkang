$.function1={
    pointchange:function(k)
    {
        if(k==1)
        {
            $(".feedbodytitlepic2 img").attr("src","img/loop1.png");
            setTimeout("$.function1.pointchange(2)",2000);
        }
        if(k==2)
        {
            $(".feedbodytitlepic2 img").attr("src","img/loop2.png");
            setTimeout("$.function1.pointchange(3)",2000);
        }
        if(k==3)
        {
            $(".feedbodytitlepic2 img").attr("src","img/loop3.png");
            setTimeout("$.function1.pointchange(4)",2000);
        }
        if(k==4)
        {
            $(".feedbodytitlepic2 img").attr("src","img/loop4.png");
            setTimeout("$.function1.pointchange(5)",2000);
        }
        if(k==5)
        {
            $(".feedbodytitlepic2 img").attr("src","img/loop5.png");
            setTimeout("$.function1.pointchange(1)",2000);
        }
    }
}

$(function(){

    $('.li1').css("height", $('.li1').css("width"));
    $('.li2').css("height", $('.li1').css("width"));


    window.onresize = function(){
        $('.li1').css("height", $('.li1').css("width"));
        $('.li2').css("height", $('.li1').css("width"));

    }


    var id = 0;
    var timer = setInterval(function(){
        var next = (id + 1)%5;
        $("#pic" + id).animate({"opacity": 0}, 1000);
        $("#pic" + next).animate({"opacity": 1}, 1000);
        id = next;
    }, 2000);

    $.function1.pointchange(1);

    $(".vote_content_li ul li").click(function(){

        $(".vote_content_li ul li .vote_li_td3 img").attr("src","./template/img/tick.png");
        $(this).find('.vote_li_td3').find('img').attr("src","./template/img/tick-h.png");

    });

  /*  $(".vote_content_li ul li:eq(0)").click(function(){

       $(".vote_content_li ul li:eq(0) .vote_li_td3 img").attr("src","./template/img/tick-h.png");
       $(".vote_content_li ul li:eq(1) .vote_li_td3 img").attr("src","./template/img/tick.png");
       $(".vote_content_li ul li:eq(2) .vote_li_td3 img").attr("src","./template/img/tick.png");
    });
    $(".vote_content_li ul li:eq(1)").click(function(){
        //  alert("ok");
        $(".vote_content_li ul li:eq(0) .vote_li_td3 img").attr("src","./template/img/tick.png");
        $(".vote_content_li ul li:eq(1) .vote_li_td3 img").attr("src","./template/img/tick-h.png");
        $(".vote_content_li ul li:eq(2) .vote_li_td3 img").attr("src","./template/img/tick.png");
    });
    $(".vote_content_li ul li:eq(2)").click(function(){
        //  alert("ok");
        $(".vote_content_li ul li:eq(0) .vote_li_td3 img").attr("src","./template/img/tick.png");
        $(".vote_content_li ul li:eq(1) .vote_li_td3 img").attr("src","./template/img/tick.png");
        $(".vote_content_li ul li:eq(2) .vote_li_td3 img").attr("src","./template/img/tick-h.png");
    });  */

    $(".feed_li_diatel p").each(function(){
        var maxwidth=120;
        if($(this).text().length>maxwidth){
            $(this).text($(this).text().substring(0,maxwidth));
            $(this).html($(this).html()+'...');
        }
    });


});