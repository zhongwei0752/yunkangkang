jQuery(document).ready(function(){
   
    jQuery("#backtop").hide();

   
    jQuery(window).scroll(function(){
        if (jQuery(window).scrollTop()>100){
            jQuery("#backtop").fadeIn();
        }
        else{
            jQuery("#backtop").fadeOut();
        }
    });

   
    jQuery("#backtop").click(function(){
        jQuery("body,html").animate({scrollTop:0},1000);
        return false;
    });
});