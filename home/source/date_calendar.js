// JavaScript Document
/***************************
 *JCalendar日历控件
 *@author brull
 *@email [email]brull@163.com[/email]
 *@date 2007-4-16
 ***************************/
/*
 *@param year 年份
 *@param month 月份
 *@param date 日期
 */
 /*如果参数不足三个那么就初始化为当天日期*/
function JCalendar (year,month,date) {
	//实例变量
	var _date = arguments.length == 0 ? new Date() : new Date(year,month-1,date);
	this.year = _date.getFullYear();
	this.month = _date.getMonth() + 1;
	this.fday = new Date(this.year,this.month-1,1).getDay();//每月第一天的星期数
	this.dayNum = new Date(this.year,this.month,0).getDate();//每月的天数
	//成员变量
	JCalendar.cur_year = this.year;
	JCalendar.cur_month = this.month;
	JCalendar.cur_date = _date.getDate();
}
JCalendar.prototype.show = function(){
	var date = new Array();
	var html_str = new Array();
	var date_index = 0;
	var weekDay = ["日","一","二","三","四","五","六"];
	for(var i = 0; i < this.fday; i++){
		date.push("&nbsp;");
	}
	for(var j = 1; j <= this.dayNum; j++){
		date.push(j);
	}
	html_str.push("<table id='calendar'><caption><a title='上一年份' href=\"javascript:JCalendar.update(-12)\" style='font-size:16px;margin-right:5px;'>&laquo;</a><a title='上一月份' href=\"javascript:JCalendar.update(-1)\" style='margin-right:10px;'>▲</a><span id='calendar_title'>" + this.year + "年" + this.month + "月</span><a title='下一月份' href=\"javascript:JCalendar.update(1)\" style='margin-left:10px;'>▼</a><a title='下一年份' href=\"javascript:JCalendar.update(12)\" style='font-size:16px;margin-left:2px;'>&raquo;</a></caption><thead><tr>");
	for(var i = 0; i < 7; i++){
		html_str.push("<td>" + weekDay[i] + "</td>");
	}
	html_str.push("</tr></thead><tbody>");
	for(var i = 0; i < 6; i++){
		html_str.push("<tr>");
		for(var j = 0; j < 7; j++){
			tmp = date[date_index++];
			tmp = tmp ? tmp : "&nbsp;";
			if(JCalendar.cur_date == tmp)
				html_str.push("<td><span id='c_today' style='background-color:#036;color:#FFF;'>" + tmp + "</span></td>");
			else if(tmp == "&nbsp;")
				html_str.push("<td>" + tmp + "</td>");
			else
				html_str.push("<td><div onmouseover=\"this.style.backgroundColor='#CCC'\" onmouseout=\"this.style.backgroundColor=''\" onclick='JCalendar.click(this)'>" + tmp + "</div></td>");
		}
		html_str.push("</tr>");
	}
	html_str.push("</tbody></table>");
	return html_str.join("");
}
//静态方法
JCalendar.update = function(_month){
	var date = new Date(JCalendar.cur_year,JCalendar.cur_month - 1 + _month,1);
	var fday = date.getDay();//每月第一天的星期数
	var year = date.getFullYear();
	var month = date.getMonth() + 1;
	var dayNum = new Date(JCalendar.cur_year,JCalendar.cur_month  + _month,0).getDate();//每月的天数
	var tds = document.getElementById("calendar").getElementsByTagName("td");
	for(var i = 7; i < tds.length; i++)//清空
		tds[i].innerHTML = "&nbsp;";
	document.getElementById("calendar_title").innerHTML = year + "年" + month + "月";
	JCalendar.cur_year = year;
	JCalendar.cur_month = month;
	for(var j = 1; j <= dayNum; j++){
		if(j == JCalendar.cur_date)
			tds[6 + fday + j].innerHTML = "<span id='c_today' style='background-color:#036;color:#FFF;'>" + j + "</span>";
		else
			tds[6 + fday + j].innerHTML = "<div onmouseover=\"this.style.backgroundColor='#CCC'\" onmouseout=\"this.style.backgroundColor=''\" onclick='JCalendar.click(this)'>" + j + "</div>";
	}
	JCalendar.onupdate(year,month,JCalendar.cur_date);
}
JCalendar.onupdate = function(year,month,date){//日历更改时执行的函数，可以更改为自己需要函数,控件传递过来的参数为当前日期
	alert(year + "年" + month + "月" + date + "日");
}
JCalendar.click = function(obj){
	var tmp = document.getElementById("c_today");
	tmp.parentNode.innerHTML = "<div onmouseover=\"this.style.backgroundColor='#CCC'\" onmouseout=\"this.style.backgroundColor=''\" onclick='JCalendar.click(this)'>" + tmp.innerHTML + "</div>";
	JCalendar.cur_date = parseInt(obj.innerHTML);
	obj.parentNode.innerHTML = "<span id='c_today' style='background-color:#036;color:#FFF;'>" + obj.innerHTML + "</span>";
	JCalendar.onclick(JCalendar.cur_year,JCalendar.cur_month,JCalendar.cur_date);
}
JCalendar.onclick = function(year,month,date){//点击日期时执行的函数，可以更改为自己需要函数,控件传递过来的参数为当前日期
	alert(year + "年" + month + "月" + date + "日");
}


