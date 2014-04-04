

$(function(){
    /****************加入购物车*****************/
  $(".addshoppingcar").click(function(){
      $(this).css({"backgroundColor":"#FF9326"});
      $(this).val("已加入购物车")    ;
  })
    /*****************查看订单****************
    $(".ViewOrder").click(function(){
        $(".content_ul2").css({"display":"block"});
        $(".content_ul").css({"display":"none"});
    })     */
    /****************购物车选取颜色和码数****************
    var k=1;
   $(".goods_diatel_table2 td").click(function(){


       if(k%2!=0)
       {
           $(this).css({"backgroundColor":"#5FC9C4"});
           $(this).css({"color":"#ffffff"});
       }
       else if(k%2==0)
       {
           $(this).css({"backgroundColor":"#E6E6E6"});
           $(this).css({"color":"#999999"});
       }
          k=k+1;

   })   */

    $(".goodstype1 li").click(function(){

        $(this).css({"backgroundColor":"#5FC9C4"});
        $(this).css({"color":"#ffffff"});

        $(this).siblings().css({"backgroundColor":"#E6E6E6"});
        $(this).siblings().css({"color":"#999999"});


    })

    $(".goodstype2 li").click(function(){


        $(this).css({"backgroundColor":"#5FC9C4"});
        $(this).css({"color":"#ffffff"});

        $(this).siblings().css({"backgroundColor":"#E6E6E6"});
        $(this).siblings().css({"color":"#999999"});

    })

     /**********************购物车选择结账*********************/

    $(".carbody_li_td1 img").click(function(){

        var c=$(this).parent().parent().find('.goods_diatel_td4').children('p').html() ;
        var b=$(this).parent().parent().find('#money').val();
        var d=$(this).parents(".wei").parent().find("#listid").val();
        var t=$("#time").val();
        var sum=$("#sum").val();
        var picchoose=parseInt($(this).attr("id") );
        if(picchoose%2!=0)
        { 
           /* $(this).parent().parent().parent().css({"display":"none"});*/
            sum=Number(sum)+Number(b*c);
            time=Number(t)+Number(1);
            $(".sumprice").html("<a href='javascript:document.carform.submit();' style='text-decoration: none;color:#FFF;'><span>结算(</span><span>"+time+"</span><span>)</span></a>");
            $("#time").val(time);
            $(".car3_bottommenu_td2_s2").html(sum);
            $("#sum").val(sum);
            $(this).attr("src","./template/change/img/okbuy1.png");
            //$(this).parents('.wei').parent().parent().find('#buyid').val("");
            $(this).parents('.wei').parent().parent().find('#click').val("");
             $.ajax({
            //dataType:"jsonp",
            url:"wx.php?do=upload",
            type: "POST",
            data:{
                "addcookie":'1',
                "id": d,
            },
            success:function(data){
              
              },
          });
            $(this).attr("id",function(){
                var a=picchoose;
                a=a+1;
                return a;

            });
        }
        else if(picchoose%2==0)
        { 
            sum=Number(sum)-Number(b*c);
            time=Number(t)-Number(1);
            $(".car3_bottommenu_td2_s2").html(sum);
            $("#sum").val(sum);
            $(".sumprice").html("<a href='javascript:document.carform.submit();' style='text-decoration: none;color:#FFF;'><span>结算(</span><span>"+time+"</span><span>)</span></a>");
            $("#time").val(time);
            //$(this).parents('.wei').parent().parent().find('#buyid').val("");
            $(this).parents('.wei').parent().parent().find('#click').val("");
            $(this).attr("src","./template/change/img/nobuy1.png");
            $.ajax({
            //dataType:"jsonp",
            url:"wx.php?do=upload",
            type: "POST",
            data:{
                "clearnocookie":'1',
                "id": d,
            },
            success:function(data){
              
              },
          });
            $(this).attr("id",function(){
                var a=picchoose;
                a=a+1;
                return a;
            });
        }



    })


    /****************购物车添加减少购物数量*****************/

    $(".reduce input").click(function(){
         
        var c=parseInt( $(this).parent().parent().children('.goods_diatel_td4').children('p').html()) ;
        var b=$(this).parent().parent().find('#money').val();
        var d=$(this).parents(".wei").parent().find("#listid").val();
        var sum=$(".car3_bottommenu_td2_s2").html();
        if(c>'0'){
           c=c-1;
           b=c*b;
           sum=Number(sum)-Number($(this).parent().parent().find('#money').val());
        
            $(this).parent().parent().children('.goods_diatel_td4').children('p').html(c);
            $(this).parents('.zhong').find('#click').val(d+"."+c);
            //$(this).parent().parent().children('.goods_diatel_td4').children('p').html(c);
            $(".car3_bottommenu_td2_s2").html(sum);
            $("#sum").val(sum);
            $(this).parents('.wei').parent().find('.carbody_sumprice_s3').html(b+"元");
            //$(".carbody_sumprice_s3").text(b+"元");
        }
           
    })

    $(".add input").click(function(){
        var b=$(this).parent().parent().find('#money').val();
        var c=parseInt( $(this).parent().parent().children('.goods_diatel_td4').children('p').html()) ;
        var d=$(this).parents(".wei").parent().find("#listid").val();
        var sum=$(".car3_bottommenu_td2_s2").html();
        c=c+1;
        b=c*b;
        sum=Number(sum)+ Number($(this).parent().parent().parent().find('#money').val());
        //$(".carbody_sumprice_s3").text(b+"元");
        $(this).parents('.wei').parent().find('.carbody_sumprice').children('.carbody_sumprice_s3').html(b+"元");
         $(".car3_bottommenu_td2_s2").html(sum);
         $("#sum").val(sum);
        $(this).parent().parent().children('.goods_diatel_td4').children('p').html(c);
        $(this).parents('.zhong').find('#click').val(d+"."+c);

    })
    /***************购物车删除项***************/
    $(".carbody_sumprice_s1 img").click(function(){
      var b=$(this).parent().parent().parent().find('#money').val();
      var c=$(this).parent().parent().parent().find('.goods_diatel_td4').children('p').html();
      var sum=$(".car3_bottommenu_td2_s2").html();
      var d=$(this).parent().children('#listid').val();
      //$(this).parent().parent().parent().parent().find('#buyid').val("");
      $(this).parent().parent().parent().parent().find('#click').val("");
       $.ajax({
        //dataType:"jsonp",
        url:"wx.php?do=upload",
        type: "POST",
        data:{
            "clearcookie":'1',
            "id": d,
        },
        success:function(data){
          $(".sumprice").html("<a href='javascript:document.carform.submit();' style='text-decoration: none;color:#FFF;'><span>结算(</span><span>"+data+"</span><span>)</span></a>");
          $("#sum").val(data);
          },
      });
      var disnum=b*c;
      sum=Number(sum)-Number(disnum);
      $(".car3_bottommenu_td2_s2").html(sum);
      $("#sum").val(sum);
      $(this).parent().parent().parent().css({"display":"none"});
    })

    /**************货到付款,在线支付,到店提货******************/
    $("#PayOnDelivery").click(function(){
         $(this).css({ "background-color": "#3F9E9A","color": "#fff"});
        $(this).siblings().css({ "background-color": " #DDDDDD","color": "#666"});
        $("#paystatus").val("PayOnDelivery");
        
    })
    $("#PayOnLine").click(function(){
        $(this).css({ "background-color": "#3F9E9A","color": "#fff"});
        $(this).siblings().css({ "background-color": " #DDDDDD","color": "#666"});
        $("#paystatus").val("PayOnLine");
        $("#zhong").css({"display":"none"});
        $("#wei").css({"display":"block"});

    })
    $("#PayOnShop").click(function(){
        $(this).css({ "background-color": "#3F9E9A","color": "#fff"});
        $(this).siblings().css({ "background-color": " #DDDDDD","color": "#666"});
        $("#paystatus").val("PayOnShop");

    })


})


