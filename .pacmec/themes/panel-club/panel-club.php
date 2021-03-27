<?php
/**
 *
 * Theme Name: Panel Club
 * Theme URI: https://managertechnology.com.co/
 * Text Domain: panel-club
 * Description: Panel Club
 * Version: 0.1
 * Author: FelipheGomez
 * Author URI: https://github.com/FelipheGomez
 * Copyright 2020-2021 Manager Technology Colombia
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Panel club
 * @category   Themes
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 *
 */

add_style_head(get_template_directory_uri()."/assets/css/bootstrap.min.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/styles/headers.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_scripts_head("/.pacmec/system/dist/jquery-ui/1.12.1/external/jquery/jquery.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
add_scripts_foot(get_template_directory_uri()."/assets/js/bootstrap.bundle.min.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);

add_style_head("/.pacmec/system/dist/select2/4.1.0/css/select2.min.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_scripts_head("/.pacmec/system/dist/select2/4.1.0/js/select2.min.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
