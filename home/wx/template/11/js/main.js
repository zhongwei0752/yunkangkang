$(function(){
	$('.mainBlock').css("height", $('.mainBlock').css("width"));

	window.onresize = function(){
		$('.mainBlock').css("height", $('.mainBlock').css("width"));
	}

    $('.menu_choice').css("height", $('.menu_choice').css("width"));

    window.onresize = function(){
        $('.menu_choice').css("height", $('.menu_choice').css("width"));
    }
});

$(function(){
	/*mobiscroll*/
	$('#demo').mobiscroll().select({
		theme: 'android-ics',
		display: 'bottom',
		mode: 'scroller',
		inputClass: 'i-txt',
		width: 200,
		lang: 'zh'
	});
    $('#show').click(function(){
     	$('#demo').mobiscroll('show');
     	return false;
    });
    $('#demo').change(function(){
    	window.location.href = $("#demo :selected").attr("value");
    });
});

