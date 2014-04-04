

$(function(){
////////////////////////////////////////////////更改帮助菜单每个大项目的字体和表格风格//////////////////////////////////
    $(".list2 ul:eq(0) li:eq(0) span").css({"list-style-type":"none","color":"#5D6977","fontFamily":"微软雅黑",
        "fontSize":"15px","border-left":"4px solid #5D6977","padding-left":"7px","margin-left":"0px",
        "letter-spacing":"1px"});
    $(".list2 ul:eq(1) li:eq(0) span").css({"list-style-type":"none","color":"#5D6977","fontFamily":"微软雅黑",
        "fontSize":"15px","border-left":"4px solid #5D6977","padding-left":"7px","margin-left":"0px",
        "letter-spacing":"1px"});
    $(".list2 ul:eq(2) li:eq(0) span").css({"list-style-type":"none","color":"#5D6977","fontFamily":"微软雅黑",
        "fontSize":"15px","border-left":"4px solid #5D6977","padding-left":"7px","margin-left":"0px",
        "letter-spacing":"1px"});
    $(".list2 ul:eq(3) li:eq(0) span").css({"list-style-type":"none","color":"#5D6977","fontFamily":"微软雅黑",
        "fontSize":"15px","border-left":"4px solid #5D6977","padding-left":"7px","margin-left":"0px",
        "letter-spacing":"1px"});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(".contentbox .contenttext p:eq(0) span").css({"color":"#666666","font-size":"16px","font-weight":"600"});
    $(".contentbox .contenttext p:eq(2) span").css({"color":"#666666","font-size":"16px","font-weight":"600"});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   $(".searchbox .search_text textarea").focus(function(){
       var text_value=$(this).val();
       if(text_value=="请输入问题关键字")
       {
           $(this).val(" ");
           $(this).css("color","#666666");
       }
   })
    $(".search_text textarea").blur(function(){
        var text_value=$(this).val();
        if(text_value==" "||text_value=="")
        {
            $(this).val("请输入问题关键字");
            $(this).css("color","#CCCCCC");
        }
    })



})