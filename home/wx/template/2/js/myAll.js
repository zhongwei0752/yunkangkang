	var ele =function(id) {
		return document.getElementById(id);
	};

	function showMenu() {
		tagDown();
		var menu = ele ('menu');
		if( menu.style.display == 'none' ) {
			menu.style.display = 'block';
		} else {
			menu.style.display = 'none';
		}
		return false;
	}

	function tagDown() {
		var tag_menu = ele ('tag_menu');
		tag_menu.src='template/2/img/tag_menu_down.png';
	}

	function tagUp() {
		var tag_menu = ele ('tag_menu');
		tag_menu.src = 'template/2/img/tag_menu.png';
	}

	function clickMenu() {
		document.getElementById('menu').click();
	}

	function deeper() {
		document.getElementById('colorButton').style.background = '#444E78';
	}

	function deeperSmall() {
		document.getElementById('colorButtonSmall').style.background = '#444E78';
	}

	function shallower() {
		document.getElementById('colorButton').style.background = '#5B5999';
	}

	function shallowerSmall() {
		document.getElementById('colorButtonSmall').style.background = '#5B5999';
	}

//mobiscroll插件js 
