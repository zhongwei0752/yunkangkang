<!DOCTYPE html>
<html>
  <head>
     <title>        <?php echo $web_title ? $web_title : $xiaoquname; ?></title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
     <link rel="stylesheet" type="text/css" href="./template/css/vincent_reset.css">
     <link rel="stylesheet" type="text/css" href="./template/css/style0.css">
     <script src="js/jquery.js"></script>
      <script type="text/javascript" charset="utf-8">
               $(document).ready(function(){
                  var length=$(".loupan_name").text().length;
                  if(length>5){
                    $(".loupan_name").attr("style","font-size:22px");
                  }
               })
           </script>

  </head>
  <body>
  <header class="header">
     <span class="loupan_name"><?php echo $xiaoquname; ?></span>
    <?php if($selected !='disable' && 0 ){  // 先永远地隐藏这个小菜单。它给技术带来好多麻烦?>
    <select name="" class="menu_select" onchange="top.location=this.value;" >
    <option value="" data-rel="back"    selected="selected" >&nbsp;&nbsp;&nbsp;&nbsp;菜单</option>
      <?php
            //$menu_array = get_menu_array($xiaoquid);
            if(!@include_once(S_ROOT.'./weixin/cache/data_menu_array_'.$xiaoquid.'.php')) {
              menu_array_cache($xiaoquid);
              @include_once(S_ROOT.'./weixin/cache/data_menu_array_'.$xiaoquid.'.php');
            }
            foreach ($menu_array as $value) {
                $menu_name = $value['name'];
                $value['url'] = str_replace( "wxkey_to_replace" , $wxkey , $value['url'] );
                $url = $value['url'];
                echo '<option value="'.$url.'">'.$menu_name.'</option>';
            }
      ?>

    </select>
    </div>
    <?php } ?>
  </header>