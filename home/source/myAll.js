/*妹的，『代码写的烂不要紧，注释要加上』 @Flying_ICE */
$.pointchanging=               //大图下三个小圆点随着大图播放而变色的函数
{
    PointC:function(i)
    {
        if(i==1)
        {
            $(".changepoint").animate({margin:0},3000,function(){$(".changepoint span img:not(:eq(1))").attr("src","./template/default/image/point2.png")
            ;$(".changepoint span img:eq(1)").attr("src","./template/default/image/point1.png") ;
                $.pointchanging.PointC(2);
            });
        }
        else if(i==2)
        {
            $(".changepoint").animate({margin:0},3000,function(){$(".changepoint span img:not(:eq(2))").attr("src","./template/default/image/point2.png")
            ;$(".changepoint span img:eq(2)").attr("src","./template/default/image/point1.png");})
            $.pointchanging.PointC(3);
        }
        else if(i==3)
        {
            $(".changepoint").animate({margin:0},3000,function(){$(".changepoint span img:not(:eq(0))").attr("src","./template/default/image/point2.png")
            ;$(".changepoint span img:eq(0)").attr("src","./template/default/image/point1.png") ;});
            $.pointchanging.PointC(1);
        }
    }
}



    $(document).ready(function(){
/*成功案例successList滚动栏操作start*/ 
	//tagNumber记录点击次数，用来计算移动的距离
	var tagNumber=0;
	$("#arrowRight").click(function(){
		//每次移动115px
        if( tagNumber >0 ) return;
		var distance = (++tagNumber * -920) + "px";
		$(".logoList").animate({ left: distance}, 400);
	});

	$("#arrowLeft").click(function(){
		//判断，如果到了最左，则不移动
		if( tagNumber == 0 ) return;
		var distance = (--tagNumber * -920) + "px";
		$(".logoList").animate({ left: distance}, 400);
	});
/*滚动栏操作结束*/

/* 大图滚动播放*/
	var flag = 0;
	var timer = setInterval( function(){
		flag = ++flag % 3;
			$(".galleryContainer").animate({left: flag*-1028 + "px"}, 500);
	}, 3000);

/*大图下三个小圆点随着大图播放而变色*/
    $.pointchanging.PointC(1);


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


});
