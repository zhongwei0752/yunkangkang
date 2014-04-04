$(function(){
	var id = 0;
	var timer = setInterval(function(){
		var next = (id + 1)%4;
		$("#pic" + id).animate({"opacity": 0}, 1000);
		$("#pic" + next).animate({"opacity": 1}, 1000);
		$(".bannerDot li").eq(id).html("<img src = './template/12/img/unselected_dot.png' />");
		$(".bannerDot li").eq(next).html("<img src = './template/12/img/selected_dot.png' />");
		
		id = next;
	}, 2000);

	/*mobiscroll*/
	$('#demo').mobiscroll().select({
		theme: 'android-ics light',
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