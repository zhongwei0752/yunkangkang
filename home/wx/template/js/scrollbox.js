$(function(){
    $('#demo,#tb_size,#tb_num,#tb_get,#tb_method').mobiscroll().select({
		theme: 'android-ics light',
		display: 'bottom',
		mode: 'mixed',
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
    })

    $('#show_size').click(function(){
     	$('#tb_size').mobiscroll('show');
     	return false;
    });

    $('#show_num').click(function(){
     	$('#tb_num').mobiscroll('show');
     	return false;
    });

    $('#show_get').click(function(){
     	$('#tb_get').mobiscroll('show');
     	return false;
    });

    $('#show_method').click(function(){
     	$('#tb_method').mobiscroll('show');
     	return false;
    });

    $('#tb_size, #tb_num, #tb_get, #tb_method').change(function(){
    	var id = $(this).attr('id');
    	var newText = $(this).find(":selected").text();
    	setText(id, newText);
	}); 

	function setText(id, newText){
		var newID = "#show_" + id.substr(3);
		$(newID).html(newText + "<img src = 'img/arrow_down.png' />");
	}

	$('#tb_time').mobiscroll().date({
        theme: 'android-ics light',
        lang: 'zh',
        display: 'bottom',
        mode: 'scroller',
        dateOrder: 'yymmdd'
    });

    $('#tb_time').change(function(){
    	var curTime = $('#tb_time').val();
    	var newTime = curTime.substr(0, 4) + '-' + curTime.substr(4, 2) + '-' + curTime.substr(-2);
    	$('#show_time').html(newTime);
    });

    $('#show_time').click(function(){
        $('#tb_time').mobiscroll('show'); 
        return false;
    });  
});