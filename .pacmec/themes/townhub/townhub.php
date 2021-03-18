<?php
/**
 *
 * Theme Name: Townhub PACMEC
 * Theme URI: https://managertechnology.com.co/
 * Text Domain: townhub
 * Description: Tema simple
 * Version: 0.1
 * Author: FelipheGomez
 * Author URI: https://github.com/FelipheGomez
 * Copyright 2020-2021 Manager Technology Colombia
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Townhub
 * @category   Themes
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 *
 */

#echo "Theme: Townhub incluido";

//add_style_head(siteinfo('siteurl')   . "/.pacmec/system/assets/css/plugins.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.99, false);

add_style_head(get_template_directory_uri()."/assets/css/reset.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/css/plugins.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/css/style.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/css/dashboard-style.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/css/color.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);

add_scripts_foot(get_template_directory_uri()."/assets/js/jquery.min.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
add_scripts_foot(get_template_directory_uri()."/assets/js/plugins.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
add_scripts_foot(get_template_directory_uri()."/assets/js/scripts.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
