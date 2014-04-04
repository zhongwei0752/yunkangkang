// Windows Phone 8
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
  var msViewportStyle = document.createElement("style")
  msViewportStyle.appendChild(
    document.createTextNode(
      "@-ms-viewport{width:auto!important}"
    )
  )
  document.getElementsByTagName("head")[0].appendChild(msViewportStyle)
}

function $d(id) {
	return document.getElementById(id);
}

var R = {
    get : function(item, string){
        var value = string.match(new RegExp("[\?\&]" + item + "=([^\&]*)(\&?)", "i"));
        return value ? value[1] : value;
    }
};

function encodeHTML(source) {
  return String(source)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;");
};

function random(len) {
  len = len || 32;
  var $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var maxPos = $chars.length;
  var str = '';
  for (i = 0; i < len; i++) {
    str += $chars.charAt(Math.floor(Math.random() * maxPos));
  }
  return str;
}

$.ajaxSetup({
  async    : false,
  type     : 'POST',
  dataType : 'json'
});

;(function($){
  // 延迟执行 $.sleep(funciton(){}).done(function(){$.post(url, function(){})....});
  $.sleep = function(callback, sleep){
    var dtd = $.Deferred();
    sleep = (sleep || 1) * 1000;
    callback && callback();
    setTimeout(function(){dtd.resolve()}, sleep);
    return dtd.promise();
  };

  $.postJSON = function(url, data, callback){
    return $.ajax({
      type      : 'POST',
      url       : url,
      data      : data,
      async     : false,
      dataType  : 'json',
      success   : callback,
      error : function(){
        if($.dialog){
          $.alert('Request server error.');
        }else{
          alert('Request server error.');
        }
      }
    });
  };

  $.fn.postJSON = function(url, data, callback, message){
    var dtd, loader = $(this);
    loader.sloader(null, message).done(function(){
      dtd = $.ajax({
        type      : 'POST',
        url       : url,
        data      : data,
        async     : false,
        dataType  : 'json',
        success   : callback,
        error : function(){
          if($.dialog){
            $.alert('Request server error.');
          }else{
            alert('Request server error.');
          }
          loader.sloader(false);
        }
      }).done(function(){
        loader.sloader(false);
      });
    });
    return dtd;
  };

  $.fn.sloader = function(toggle, message){
    var self = $(this);
    message = message || 'loading';
    if(toggle == null){
      return $.sleep(function(){
        if(self.data('loader')) return false;
        self.attr({"data-loading-text":'<i class="icon-spinner icon-spin"></i> ' + message});
        self.data('loader', true);
        self.button('loading');
      });
    }else{
      self.data('loader', false);
      self.button('reset');
    }
  };

  $.fn.formJSON = function(gn) {
    var a = {};
    this.each(function() {
      var n = this.id || this.name;
      if (!n) {
        return;
      }
      var v = $.fieldValue(this);
      if (v !== null && typeof v != 'undefined') {
        a[n] = !a[n] ? v : [].concat(a[n]).concat(v);
      }
    });
    if(gn){
      var g = {};
      g[gn] = a;
      return g;
    }
    return a;
  };

  $.fieldValue = function(el) {
    var n = el.id || el.name, t = el.type, tag = el.tagName.toLowerCase();
    if (!n || el.disabled || t == 'reset' || t == 'button' || t == 'submit' || t == 'image' ||
      ((t == 'checkbox' || t == 'radio') && !el.checked) ||
      (tag == 'select' && el.selectedIndex == -1)) {
      return null;
    }
    if (tag == 'select') {
      var index = el.selectedIndex;
      if (index < 0) { return null; }
      var a = [], ops = el.options;
      var one = (t == 'select-one');
      var max = (one ? index+1 : ops.length);
      for(var i=(one ? index : 0); i < max; i++) {
        var op = ops[i];
        if (op.selected) {
          var v = op.value;
          if (!v) {
            v = (op.attributes && op.attributes['value'] && !(op.attributes['value'].specified)) ? op.text : op.value;
          }
          if (one) { return v; }
          a.push(v);
        }
      }
      return a;
    }
    return $(el).val();
  };


})(jQuery);

$(function(){
  if($.dialog){
    (function (config) {
      config['okValue']     = '确定';
      config['cancelValue'] = '取消';
      config['title']       = '信息';
      config['fixed']       = true;
    })($.dialog.defaults);
  }
});

