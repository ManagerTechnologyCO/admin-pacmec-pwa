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
add_style_head(get_template_directory_uri()."/assets/css/reset.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/css/plugins-club.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/css/style-club.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/css/dashboard-style.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/css/color-club.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);
add_style_head(get_template_directory_uri()."/assets/css/shop.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.8, true);

// Wompi
add_scripts_head("https://checkout.wompi.co/widget.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.6, true);

add_scripts_foot(get_template_directory_uri()."/assets/js/jquery.min.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
add_scripts_foot(get_template_directory_uri()."/assets/js/plugins.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
add_scripts_foot(get_template_directory_uri()."/assets/js/scripts.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);
//add_scripts_foot(get_template_directory_uri()."/assets/js/dashboard.js", ["type"=>"text/javascript", "charset"=>"UTF-8"], 0.8, true);

function component_hero_section($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/hero-section', $args);
}
add_shortcode('hero-section', 'component_hero_section');

function component_memberships1($atts, $content='') {
  $args = shortcode_atts([
    "limit" => 1,
    "filters_active" => false,
    "btns_explore" => false,
    "ordering" => 'created,desc',
    "membership_id" => null
  ], $atts);
  $membership_id = isset($args['membership_id']) ? $args['membership_id'] : (isset($_GET['membership_id']) ? $_GET['membership_id']: null);
  if($membership_id !== null){
    $membership_index = array_search($membership_id, array_column($GLOBALS['PACMEC']['memberships']['allow_signups'], 'id'));
    $membership = ($membership_index !== false) ? $GLOBALS['PACMEC']['memberships']['allow_signups'][$membership_index] : null;
    $data = [
      "membership_id" => $membership_id,
      "membership" => $membership,
    ];
    get_template_part('components/pages-membership', $data);
  } else {
    $data = [
      "limit" => $args['limit'],
      "filters_active" => $args['filters_active'],
      "btns_explore" => $args['btns_explore'],
      "ordering" => $args['ordering'],
      "memberships" => $GLOBALS['PACMEC']['memberships']['allow_signups'],
    ];
    get_template_part('components/memberships-style-1', $data);
  }
}
add_shortcode('memberships-style-1', 'component_memberships1');

function component_video_section($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/video-section', $args);
}
add_shortcode('video-section', 'component_video_section');

function component_block_icons($atts, $content='') {
  $args = shortcode_atts_global($atts);
  $args['steps'] = @json_decode(@base64_decode($args['steps']));
  get_template_part('components/block-icons', $args);
}
add_shortcode('block-icons', 'component_block_icons');

function component_block_app($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/block-app', $args);
}
add_shortcode('block-app', 'component_block_app');

function component_block_counters($atts, $content='') {
  $args = shortcode_atts_global($atts);
  $args['counters'] = @json_decode(@base64_decode($args['counters']));
  $records = [];
  if(is_array($args['counters']) && count($args['counters']) > 0){
    foreach ($args['counters'] as $key) {
      foreach ($GLOBALS['PACMEC']['total_records'] As $item) {
        if($item->name == $key) $records[] = $item;
      }
    }
  }
  $args['records'] = $records;
  get_template_part('components/block-counters', $args);
}
add_shortcode('block-counters', 'component_block_counters');

function component_testimonilas_carousel($atts, $content='') {
  $args = shortcode_atts_global($atts);
  if(!isset($args['limit'])) $args['limit'] = 7;
  $records = \PACMEC\Testimonilas::allLoad($args['limit']);
  $args['records'] = is_array($records) ? $records : [];
  get_template_part('components/testimonilas-carousel', $args);
}
add_shortcode('testimonilas-carousel', 'component_testimonilas_carousel');

function component_section_simple($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/section-simple', $args);
}
add_shortcode('section-simple', 'component_section_simple');

function component_block_contactus($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/block-contactus', $args);
}
add_shortcode('block-contactus', 'component_block_contactus');
