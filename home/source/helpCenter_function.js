$(function(){
    $.getUrlParam = function(name)
    {
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) return unescape(r[2]); return null;
    }

  // alert( $.getUrlParam('id'));
    if( $.getUrlParam('id')==69||$.getUrlParam('id')==72)
    {
        $("#contenttext2 img").css("float","left" );
        $("#contenttext2 p").css("margin-top","20px");
        $("#contenttext2 p").css("font-weight","normal");
    }

   $(".searchbox .search_buttom").click(function(){
      window.location.href="http://www.baidu.com/s?wd="+$(".searchbox .search_text textarea").val();
     //  window.location.href="http://localhost/v5/home/myhelp.php?id=999&keyword="+$(".searchbox .search_text textarea").val();
    })
////////////////////////////////////其他功能按钮点击效果////////////////////////////////////////////////////////////////
    $(".menubox .list2 ul:eq(0) li:eq(1)").click(function(){             //开通流程
      $(".menubox .list2 ul:eq(0) li:eq(1) .buttom").attr("src","./template/default/image/buttom2.png");
      $(".menubox .list2 ul:eq(0) li:eq(1)").css({"background-color":"#3EB7B0","color":"#ffffff"});
      $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
      $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
      window.location.href="http://v5.home3d.cn/home/myhelp.php?id=60";
    })
    $(".menubox .list2 ul:eq(0) li:eq(2)").click(function(){             //管理员手册
        $(".menubox .list2 ul:eq(0) li:eq(2) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(0) li:eq(2)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=70";
    })
    $(".menubox .list2 ul:eq(0) li:eq(3)").click(function(){             //用户手册
        $(".menubox .list2 ul:eq(0) li:eq(3) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(0) li:eq(3)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=69";
    })
    $(".menubox .list2 ul:eq(1) li:eq(1)").click(function(){             //在线客服
        $(".menubox .list2 ul:eq(1) li:eq(1) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(1) li:eq(1)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=61";
    })
    $(".menubox .list2 ul:eq(1) li:eq(2)").click(function(){             //留言板
        $(".menubox .list2 ul:eq(1) li:eq(2) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(1) li:eq(2)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=59";
    })
    $(".menubox .list2 ul:eq(2) li:eq(1)").click(function(){             //品牌企业合作
        $(".menubox .list2 ul:eq(2) li:eq(1) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(2) li:eq(1)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=62";
    })
    $(".menubox .list2 ul:eq(2) li:eq(2)").click(function(){             //媒体合作
        $(".menubox .list2 ul:eq(2) li:eq(2) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(2) li:eq(2)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=63";
    })
    $(".menubox .list2 ul:eq(2) li:eq(3)").click(function(){             //收费细节
        $(".menubox .list2 ul:eq(2) li:eq(3) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(2) li:eq(3)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=72";
    })
    $(".menubox .list2 ul:eq(3) li:eq(1)").click(function(){             //产品介绍
        $(".menubox .list2 ul:eq(3) li:eq(1) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(3) li:eq(1)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=49";
    })
    $(".menubox .list2 ul:eq(3) li:eq(2)").click(function(){             //联系方式
        $(".menubox .list2 ul:eq(3) li:eq(2) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(3) li:eq(2)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=48";
    })
    $(".menubox .list2 ul:eq(3) li:eq(3)").click(function(){             //人才招聘
        $(".menubox .list2 ul:eq(3) li:eq(3) .buttom").attr("src","./template/default/image/buttom2.png");
        $(".menubox .list2 ul:eq(3) li:eq(3)").css({"background-color":"#3EB7B0","color":"#ffffff"});
        $(".menubox .list2 .HaveChoose").css({"background-color":"#EEEEEE","color":"#999999"});
        $(".menubox .list2 .HaveChoose .buttom").attr("src","./template/default/image/buttom1_1.png");
        window.location.href="http://v5.home3d.cn/home/myhelp.php?id=71";
    })
})
