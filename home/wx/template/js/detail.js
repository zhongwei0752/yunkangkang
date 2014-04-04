function date (format, timestamp) {
  // http://kevin.vanzonneveld.net
  // +   original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
  // +      parts by: Peter-Paul Koch (http://www.quirksmode.org/js/beat.html)
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: MeEtc (http://yass.meetcweb.com)
  // +   improved by: Brad Touesnard
  // +   improved by: Tim Wiel
  // +   improved by: Bryan Elliott
  //
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // +   improved by: David Randall
  // +      input by: Brett Zamir (http://brett-zamir.me)
  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // +   improved by: Theriault
  // +  derived from: gettimeofday
  // +      input by: majak
  // +   bugfixed by: majak
  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +      input by: Alex
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // +   improved by: Theriault
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // +   improved by: Theriault
  // +   improved by: Thomas Beaucourt (http://www.webapp.fr)
  // +   improved by: JT
  // +   improved by: Theriault
  // +   improved by: Rafał Kukawski (http://blog.kukawski.pl)
  // +   bugfixed by: omid (http://phpjs.org/functions/380:380#comment_137122)
  // +      input by: Martin
  // +      input by: Alex Wilson
  // +   bugfixed by: Chris (http://www.devotis.nl/)
  // %        note 1: Uses global: php_js to store the default timezone
  // %        note 2: Although the function potentially allows timezone info (see notes), it currently does not set
  // %        note 2: per a timezone specified by date_default_timezone_set(). Implementers might use
  // %        note 2: this.php_js.currentTimezoneOffset and this.php_js.currentTimezoneDST set by that function
  // %        note 2: in order to adjust the dates in this function (or our other date functions!) accordingly
  // *     example 1: date('H:m:s \\m \\i\\s \\m\\o\\n\\t\\h', 1062402400);
  // *     returns 1: '09:09:40 m is month'
  // *     example 2: date('F j, Y, g:i a', 1062462400);
  // *     returns 2: 'September 2, 2003, 2:26 am'
  // *     example 3: date('Y W o', 1062462400);
  // *     returns 3: '2003 36 2003'
  // *     example 4: x = date('Y m d', (new Date()).getTime()/1000);
  // *     example 4: (x+'').length == 10 // 2009 01 09
  // *     returns 4: true
  // *     example 5: date('W', 1104534000);
  // *     returns 5: '53'
  // *     example 6: date('B t', 1104534000);
  // *     returns 6: '999 31'
  // *     example 7: date('W U', 1293750000.82); // 2010-12-31
  // *     returns 7: '52 1293750000'
  // *     example 8: date('W', 1293836400); // 2011-01-01
  // *     returns 8: '52'
  // *     example 9: date('W Y-m-d', 1293974054); // 2011-01-02
  // *     returns 9: '52 2011-01-02'
    var that = this,
      jsdate,
      f,
      formatChr = /\\?([a-z])/gi,
      formatChrCb,
      // Keep this here (works, but for code commented-out
      // below for file size reasons)
      //, tal= [],
      _pad = function (n, c) {
        n = n.toString();
        return n.length < c ? _pad('0' + n, c, '0') : n;
      },
      txt_words = ["Sun", "Mon", "Tues", "Wednes", "Thurs", "Fri", "Satur", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  formatChrCb = function (t, s) {
    return f[t] ? f[t]() : s;
  };
  f = {
    // Day
    d: function () { // Day of month w/leading 0; 01..31
      return _pad(f.j(), 2);
    },
    D: function () { // Shorthand day name; Mon...Sun
      return f.l().slice(0, 3);
    },
    j: function () { // Day of month; 1..31
      return jsdate.getDate();
    },
    l: function () { // Full day name; Monday...Sunday
      return txt_words[f.w()] + 'day';
    },
    N: function () { // ISO-8601 day of week; 1[Mon]..7[Sun]
      return f.w() || 7;
    },
    S: function () { // Ordinal suffix for day of month; st, nd, rd, th
      var j = f.j();
      return j < 4 | j > 20 && (['st', 'nd', 'rd'][j % 10 - 1] || 'th');
    },
    w: function () { // Day of week; 0[Sun]..6[Sat]
      return jsdate.getDay();
    },
    z: function () { // Day of year; 0..365
      var a = new Date(f.Y(), f.n() - 1, f.j()),
        b = new Date(f.Y(), 0, 1);
      return Math.round((a - b) / 864e5);
    },

    // Week
    W: function () { // ISO-8601 week number
      var a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3),
        b = new Date(a.getFullYear(), 0, 4);
      return _pad(1 + Math.round((a - b) / 864e5 / 7), 2);
    },

    // Month
    F: function () { // Full month name; January...December
      return txt_words[6 + f.n()];
    },
    m: function () { // Month w/leading 0; 01...12
      return _pad(f.n(), 2);
    },
    M: function () { // Shorthand month name; Jan...Dec
      return f.F().slice(0, 3);
    },
    n: function () { // Month; 1...12
      return jsdate.getMonth() + 1;
    },
    t: function () { // Days in month; 28...31
      return (new Date(f.Y(), f.n(), 0)).getDate();
    },

    // Year
    L: function () { // Is leap year?; 0 or 1
      var j = f.Y();
      return j % 4 === 0 & j % 100 !== 0 | j % 400 === 0;
    },
    o: function () { // ISO-8601 year
      var n = f.n(),
        W = f.W(),
        Y = f.Y();
      return Y + (n === 12 && W < 9 ? 1 : n === 1 && W > 9 ? -1 : 0);
    },
    Y: function () { // Full year; e.g. 1980...2010
      return jsdate.getFullYear();
    },
    y: function () { // Last two digits of year; 00...99
      return f.Y().toString().slice(-2);
    },

    // Time
    a: function () { // am or pm
      return jsdate.getHours() > 11 ? "pm" : "am";
    },
    A: function () { // AM or PM
      return f.a().toUpperCase();
    },
    B: function () { // Swatch Internet time; 000..999
      var H = jsdate.getUTCHours() * 36e2,
        // Hours
        i = jsdate.getUTCMinutes() * 60,
        // Minutes
        s = jsdate.getUTCSeconds(); // Seconds
      return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3);
    },
    g: function () { // 12-Hours; 1..12
      return f.G() % 12 || 12;
    },
    G: function () { // 24-Hours; 0..23
      return jsdate.getHours();
    },
    h: function () { // 12-Hours w/leading 0; 01..12
      return _pad(f.g(), 2);
    },
    H: function () { // 24-Hours w/leading 0; 00..23
      return _pad(f.G(), 2);
    },
    i: function () { // Minutes w/leading 0; 00..59
      return _pad(jsdate.getMinutes(), 2);
    },
    s: function () { // Seconds w/leading 0; 00..59
      return _pad(jsdate.getSeconds(), 2);
    },
    u: function () { // Microseconds; 000000-999000
      return _pad(jsdate.getMilliseconds() * 1000, 6);
    },

    // Timezone
    e: function () { // Timezone identifier; e.g. Atlantic/Azores, ...
      // The following works, but requires inclusion of the very large
      // timezone_abbreviations_list() function.
/*              return that.date_default_timezone_get();
*/
      throw 'Not supported (see source code of date() for timezone on how to add support)';
    },
    I: function () { // DST observed?; 0 or 1
      // Compares Jan 1 minus Jan 1 UTC to Jul 1 minus Jul 1 UTC.
      // If they are not equal, then DST is observed.
      var a = new Date(f.Y(), 0),
        // Jan 1
        c = Date.UTC(f.Y(), 0),
        // Jan 1 UTC
        b = new Date(f.Y(), 6),
        // Jul 1
        d = Date.UTC(f.Y(), 6); // Jul 1 UTC
      return ((a - c) !== (b - d)) ? 1 : 0;
    },
    O: function () { // Difference to GMT in hour format; e.g. +0200
      var tzo = jsdate.getTimezoneOffset(),
        a = Math.abs(tzo);
      return (tzo > 0 ? "-" : "+") + _pad(Math.floor(a / 60) * 100 + a % 60, 4);
    },
    P: function () { // Difference to GMT w/colon; e.g. +02:00
      var O = f.O();
      return (O.substr(0, 3) + ":" + O.substr(3, 2));
    },
    T: function () { // Timezone abbreviation; e.g. EST, MDT, ...
      // The following works, but requires inclusion of the very
      // large timezone_abbreviations_list() function.
/*              var abbr = '', i = 0, os = 0, default = 0;
      if (!tal.length) {
        tal = that.timezone_abbreviations_list();
      }
      if (that.php_js && that.php_js.default_timezone) {
        default = that.php_js.default_timezone;
        for (abbr in tal) {
          for (i=0; i < tal[abbr].length; i++) {
            if (tal[abbr][i].timezone_id === default) {
              return abbr.toUpperCase();
            }
          }
        }
      }
      for (abbr in tal) {
        for (i = 0; i < tal[abbr].length; i++) {
          os = -jsdate.getTimezoneOffset() * 60;
          if (tal[abbr][i].offset === os) {
            return abbr.toUpperCase();
          }
        }
      }
*/
      return 'UTC';
    },
    Z: function () { // Timezone offset in seconds (-43200...50400)
      return -jsdate.getTimezoneOffset() * 60;
    },

    // Full Date/Time
    c: function () { // ISO-8601 date.
      return 'Y-m-d\\TH:i:sP'.replace(formatChr, formatChrCb);
    },
    r: function () { // RFC 2822
      return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb);
    },
    U: function () { // Seconds since UNIX epoch
      return jsdate / 1000 | 0;
    }
  };
  this.date = function (format, timestamp) {
    that = this;
    jsdate = (timestamp === undefined ? new Date() : // Not provided
      (timestamp instanceof Date) ? new Date(timestamp) : // JS Date()
      new Date(timestamp * 1000) // UNIX timestamp (auto-convert to int)
    );
    return format.replace(formatChr, formatChrCb);
  };
  return this.date(format, timestamp);
}


function HTMLDecode(input) {
    var converter = document_createElement_x_x("DIV");
    converter.innerHTML = input;
    var output = converter.innerText;
    converter = null;
    return output;
}

function getDetail(idtype, id, uid,page,perpage){
  if (idtype=="introduceid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=introduce&uid="+uid+"&id="+id+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
          data=data.data;
          
        data.introduce.dateline = date('Y-m-d H:i',data.introduce.dateline);
        var converter = data.introduce.message;   
        converter.innerHTML = data.introduce.message;
        
          $("#detailTemplate").tmpl(data ).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
  if(idtype=="productid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=product&uid="+uid+"&id="+id+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
          data=data.data;
          
        data.product.dateline = date('Y-m-d H:i',data.product.dateline);    

          $("#detailTemplate").tmpl(data ).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
   if(idtype=="developmentid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=development&uid="+uid+"&id="+id+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
          data=data.data;
          
        data.development.dateline = date('Y-m-d H:i',data.development.dateline);    

          $("#detailTemplate").tmpl(data ).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
   if(idtype=="industryid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=industry&uid="+uid+"&id="+id+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
          data=data.data;
          
        data.industry.dateline = date('Y-m-d H:i',data.industry.dateline);    

          $("#detailTemplate").tmpl(data ).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
   if(idtype=="casesid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=cases&uid="+uid+"&id="+id+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
          data=data.data;
          
        data.cases.dateline = date('Y-m-d H:i',data.cases.dateline);    

          $("#detailTemplate").tmpl(data ).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
   if(idtype=="branchid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=branch&uid="+uid+"&id="+id+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
          data=data.data;
          
        data.branch.dateline = date('Y-m-d H:i',data.branch.dateline);    

          $("#detailTemplate").tmpl(data ).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
   if(idtype=="jobid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=job&uid="+uid+"&id="+id+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
          data=data.data;
          
        data.job.dateline = date('Y-m-d H:i',data.job.dateline);    

          $("#detailTemplate").tmpl(data ).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
   if(idtype=="talkid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=talk&uid="+uid+"&id="+id+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
          data=data.data;
          
        data.talk.dateline = date('Y-m-d H:i',data.talk.dateline);    

          $("#detailTemplate").tmpl(data ).appendTo('#detail-panel');
          $('#page').val(parseInt($('#page').val())+1);
        }else{
        alert(data.msg);
        }

      }
      });
  }
     if(idtype=="goodsid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=goods&uid="+uid+"&id="+id+"&page="+page+"&perpage="+perpage+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
           //alert(""+uid+"");
          data=data.data.goodscod;
           if (data.length<=0){
            
             $(".more_button").val("亲，没有了哦!");
        }
           for (var i = 0, len = data.length; i < len; ++i) {
              data[i].dateline = date('Y-m-d H:i',data[i].dateline);
            }
          $('#page').val(parseInt($('#page').val())+1);
          $("#detailTemplate").tmpl(data).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
  if(idtype=="stratchid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=stratch&uid="+uid+"&id="+id+"&page="+page+"&perpage="+perpage+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
           //alert(""+uid+"");
          data=data.data;
           if (data.length<=0){
            
             $(".more_button").val("亲，没有了哦!");
        }
           for (var i = 0, len = data.length; i < len; ++i) {
              data[i].dateline = date('Y-m-d H:i',data[i].dateline);
            }
          $('#page').val(parseInt($('#page').val())+1);
          $("#detailTemplate").tmpl(data).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
  if(idtype=="debateid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=debate&uid="+uid+"&id="+id+"&page="+page+"&perpage="+perpage+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
           //alert(""+uid+"");
          data=data.data;
           if (data.length<=0){
            
             $(".more_button").val("亲，没有了哦!");
        }
           for (var i = 0, len = data.length; i < len; ++i) {
              data[i].dateline = date('Y-m-d H:i',data[i].dateline);
            }
          $('#page').val(parseInt($('#page').val())+1);
          $("#detailTemplate").tmpl(data).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
  if(idtype=="pollid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=poll&uid="+uid+"&id="+id+"&page="+page+"&perpage="+perpage+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
           //alert(""+uid+"");
          data=data.data;
           if (data.length<=0){
            
             $(".more_button").val("亲，没有了哦!");
        }
           for (var i = 0, len = data.length; i < len; ++i) {
              data[i].dateline = date('Y-m-d H:i',data[i].dateline);
            }
          $('#page').val(parseInt($('#page').val())+1);
          $("#detailTemplate").tmpl(data).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
   if(idtype=="eventid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=event&uid="+uid+"&id="+id+"&page="+page+"&perpage="+perpage+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
           //alert(""+uid+"");
          data=data.data.eventgo;
           if (data.length<=0){
            
             $(".more_button").val("亲，没有了哦!");
        }
           for (var i = 0, len = data.length; i < len; ++i) {
              data[i].dateline = date('Y-m-d H:i',data[i].dateline);
            }
          $('#page').val(parseInt($('#page').val())+1);
          $("#detailTemplate").tmpl(data).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
   if(idtype=="auctionid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=auction&uid="+uid+"&id="+id+"&page="+page+"&perpage="+perpage+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
           //alert(""+uid+"");
          data=data.data.auctionbuy;
           if (data.length<=0){
            
             $(".more_button").val("亲，没有了哦!");
        }
           for (var i = 0, len = data.length; i < len; ++i) {
              data[i].dateline = date('Y-m-d H:i',data[i].dateline);
            }
          $('#page').val(parseInt($('#page').val())+1);
          $("#detailTemplate").tmpl(data).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
  if(idtype=="seckillid"){
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=seckill&uid="+uid+"&id="+id+"&page="+page+"&perpage="+perpage+"",
       
      success: function( data ) {
        /* Get the movies array from the data */

        if(data.code==0){
           //alert(""+uid+"");
          data=data.data.seckillbuy;
           if (data.length<=0){
            
             $(".more_button").val("亲，没有了哦!");
        }
           for (var i = 0, len = data.length; i < len; ++i) {
              data[i].dateline = date('Y-m-d H:i',data[i].dateline);
            }
          $('#page').val(parseInt($('#page').val())+1);
          $("#detailTemplate").tmpl(data).appendTo('#detail-panel');
        }else{
        alert(data.msg);
        }

      }
      });
  }
      if(idtype=="dialogid"){
    //var uid=$.query.get('uid');
    //var id=$.query.get('id');
    //console.log("http://localhost/new1/v5/home/capi/space.php?do=dialog&uid="+uid+"&dialog="+id+"");
    $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=dialog&uid="+uid+"&dialog="+id+"&page="+page+"&perpage="+perpage+"",
       
      success: function( data ) {
        /* Get the movies array from the data */
    //console.log(data);
        if(data.code==0){
          data.data.list.dateline = date('Y-m-d H:i',data.data.list.dateline);
          list = data.data.list;

          q = data.data.q;
          if(list){
          for(var i = 0;i < list.length;i ++){
            var l = list[i];
            if(l.uid == uid) l.pos = true;
            else l.pos = false;
            //console.log(l.pos)
          }    
          }
      //console.log(q);
          $("#detailTemplate").tmpl(q).appendTo('#detail-panel');
          if(list){
          $("#liTemplate").tmpl(list).appendTo('#list-panel');
          }
        }else{
        alert(data.msg);
        }

      }
      });
  }
}


function getComment(idtype, id,uid, page, perpage){
   $("#morebtn .ui-btn-text").html("正在加载...");
   $("#morebtn").addClass('ui-disabled');
  $.ajax({
      dataType: "jsonp",
      url: "http://v5.home3d.cn/home/capi/space.php?do=comment&idtype=" + idtype + "&uid=" + uid + "&id=" + id + "&page=" + page + "&perpage=" + perpage,
       
      success: function( data ) {
        /* Get the movies array from the data */
        $("#morebtn .ui-btn-text").html("更多");
        $("#morebtn").removeClass('ui-disabled');
        if(data.code==0){
          data=data.data.comment;
          if (data.length<=0)
            
             $(".more_button").val("亲，没有了哦!");
          else{
            for (var i = 0, len = data.length; i < len; ++i) {
              data[i].dateline = date('Y-m-d H:i',data[i].dateline);
            }
            $("#commentTemplate").tmpl(data).appendTo('#comment-panel');
            $('#page').val(parseInt($('#page').val())+1);
          }
        }else{
        alert(data.data.commentcount);
        }
      }
      });
  $("#morebtn").removeClass('ui-disabled');
}
    function setCookie(name, value, seconds) {  
      seconds = seconds || 0;   //seconds有值就直接赋值，没有为0，这个根php不一样。 
      value=encodeURI(value); 
      var expires = "";  
       if (seconds != 0 ) {      //设置cookie生存时间  
       var date = new Date();  
       date.setTime(date.getTime()+(seconds*1000));  
       expires = "; expires="+date.toGMTString();  
       }  
       document.cookie = name+"="+escape(value)+expires+"; path=/";   //转码并赋值  
      }  


function cpComment(idtype, id, message,nickname){
  var pattern = /^[\s]{0,}$/g;
  $("#publishbtn").addClass('ui-disabled');
 $("#feedsubmit").html("发表成功");
 $("#feedsubmit1").val("发表成功");
  if (!pattern.test(message)&&!pattern.test(nickname)){

    $.ajax({
        dataType: "jsonp",
        url: "http://v5.home3d.cn/home/capi/cp.php?ac=comment&id="+id+"&commentsubmit=true&idtype="+idtype+"&nickname="+nickname+"&message="+message,
         
        success: function( data ) {
          if(data.code==0){
            $("#comment-panel").before("<li><span>"+nickname+": </span>"+message+"</li> ");
            setCookie('usernickname',""+nickname+"",'31536000');

          }else{
          alert(data.msg);
          }
        }
    });
  }else{
    $("#publishbtn").removeClass('ui-disabled');
    alert("昵称和评论内容两者不能为空！");
  }
}

function ans(uid,rid,message,dialogid,status,wxkey){
  $.ajax({
    
    url:"http://v5.home3d.cn/home/capi/cp.php?ac=dialog",
    type: "POST",
    data:{
      "uid":uid,
      "rid": rid,
      "message":message,
      "dialogid":dialogid,
      "status":status
    },
    success:function(data){
      console.log(data);
      window.location.reload();
    },
    error:function(data){
      console.log(data);
    }
  });
}

$(function(){
  getDetail($('#idtype').val(), $('#id').val(), $('#uid').val(),'1','10');
  getComment($('#idtype').val(), $('#id').val(), $('#uid').val(),'1','10');
  
  
})

function getTemplate( key ) {
    return $( "#" + key + "Template" ).template();
}
