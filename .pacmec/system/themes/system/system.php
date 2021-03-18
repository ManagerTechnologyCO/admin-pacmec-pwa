<?php
/**
 * Theme Name: System
 * Theme URI: https://managertechnology.com.co/
 * Text Domain: sys-pacmec
 * Description: Tema del sistema
 * Version: 0.1
 * Author: FelipheGomez
 * Author URI: https://github.com/FelipheGomez
 * Copyright 2020-2021 Manager Technology Colombia
 */

#echo "Theme: System incluido";

if(pageinfo("component") == 'pages-error')
{
  add_style_head(siteinfo('siteurl')   . "/.pacmec/system/assets/css/style-error.css",  ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8", "media" => "all"], null, false);
}
