

$(function(){




	$('.wrapperImg').css("height", $('.wrapperImg').css("width"));
  //  $('.touchscrollwrapper').css("height",$(window).height());

    window.onresize = function(){
		$('.wrapperImg').css("height", $('.wrapperImg').css("width"));
     //   $('.touchscrollwrapper').css("height",$(window).height());
	};

    $('.scroller1').css({"opacity":0});
	/*菜单按钮点击*/
	$('#menu').click(function(){
		var left = $('.itemInnerFrame').css('left');
		if(left != "0px") {
			$('.itemInnerFrame').stop().animate({left: 0}, 500);
			$('.scroller1').stop().animate({opacity: "0"}, 200, function(){
				$('.scroller1').css("display", "none");
			});
		}
		else{
			$('.itemInnerFrame').stop().animate({left: "-37.5%"}, 500);
			$('.scroller1').css("display", "block");
			$('.scroller1').stop().animate({opacity: "1"}, 1000);
		}
	});


    /*菜单按钮点击
    $('#menu').click(function(){
        var left = $('.itemInnerFrame').css('left');
        if(left != "0px") {
            $('.itemInnerFrame').stop().animate({left: 0}, 500);
            $('.sidebar').stop().animate({opacity: "0"}, 200, function(){
                $('.sidebar').css("display", "none");
            });
        }
        else{
            $('.itemInnerFrame').stop().animate({left: "-37.5%"}, 500);
            $('.sidebar').css("display", "block");
            $('.sidebar').stop().animate({opacity: "1"}, 1000);
        }
    }); */

	/*回到页首
	$('.toTop').click(function(){
		$('html, body').animate({scrollTop: 0}, 500);
	});  */

	/*主页图片切换
	var id = 0;
	var timer = setInterval(function(){
		var next = (id + 1)%4;
	//	$('#bannerPic').attr("src", "./template/8/img/exp" + id + ".jpg");
	//	$('#borderPic').attr("src", "./template/8/img/dot" + id + ".png");
        $('#bannerPic').attr("src", "http://v5.home3d.cn/home/$home1[imageurl]");
        $('#borderPic').attr("src", "./template/8/img/dot" + id + ".png");
		id = next;
	}, 2000); */
});
