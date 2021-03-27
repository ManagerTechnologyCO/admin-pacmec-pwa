<?php
/**
 *
 * Theme Name: Console Club
 * Theme URI: https://managertechnology.com.co/
 * Text Domain: console-club
 * Description: Tema Blub Panel
 * Version: 0.1
 * Author: FelipheGomez
 * Author URI: https://github.com/FelipheGomez
 * Copyright 2020-2021 Manager Technology Colombia
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Console club
 * @category   Themes
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 *
 */
add_style_head(get_template_directory_uri()."/assets/css/style.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/primeui/themes/casablanca/theme.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head("/.pacmec/system/dist/font-awesome/4.7.0/css/font-awesome.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head("/.pacmec/system/dist/jquery-ui/1.12.1/jquery-ui.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/primeui/primeui-all.min.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_scripts_head("/.pacmec/system/dist/jquery-ui/1.12.1/external/jquery/jquery.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
add_scripts_head("/.pacmec/system/dist/jquery-ui/1.12.1/jquery-ui.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
#<script type="text/javascript" src="%PATH%/jquery.js"></script>
#<script type="text/javascript" src="%PATH%/jquery-ui.js"></script>
add_scripts_head(get_template_directory_uri()."/assets/primeui/primeui-all.min.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
