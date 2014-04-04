$( function(){
	var id = 0;
	var timer = setInterval( function(){
		var next = (id + 1)%5;
		$("#pic" + id).animate({"opacity": 0}, 1000);
		$("#pic" + next).animate({"opacity": 1}, 1000);
		$("#dot" + id).attr("src", "./template/10/img/dot_gray.png");
		$("#dot" + next).attr("src", "./template/10/img/dot_white.png");
		id = next;
	}, 2000);

});
