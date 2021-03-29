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
add_shortcode('townhub-hero-section', 'component_hero_section');

function component_memberships1($atts, $content='') {
  $args = shortcode_atts([
    "limit" => 1,
    "active_pays" => false,
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
      "active_pays" => $args['active_pays'],
      "memberships" => $GLOBALS['PACMEC']['memberships']['allow_signups'],
    ];
    get_template_part('components/memberships-style-1', $data);
  }
}
add_shortcode('townhub-memberships-style-1', 'component_memberships1');

function component_video_section($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/video-section', $args);
}
add_shortcode('townhub-video-section', 'component_video_section');

function component_block_icons($atts, $content='') {
  $args = shortcode_atts_global($atts);
  $args['steps'] = @json_decode(@base64_decode($args['steps']));
  get_template_part('components/block-icons', $args);
}
add_shortcode('townhub-block-icons', 'component_block_icons');

function component_block_app($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/block-app', $args);
}
add_shortcode('townhub-block-app', 'component_block_app');

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
add_shortcode('townhub-block-counters', 'component_block_counters');

function component_testimonilas_carousel($atts, $content='') {
  $args = shortcode_atts_global($atts);
  if(!isset($args['limit'])) $args['limit'] = 7;
  $records = \PACMEC\Testimonilas::allLoad($args['limit']);
  $args['records'] = is_array($records) ? $records : [];
  get_template_part('components/testimonilas-carousel', $args);
}
add_shortcode('townhub-testimonilas-carousel', 'component_testimonilas_carousel');

function component_section_simple($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/section-simple', $args);
}
add_shortcode('townhub-section-simple', 'component_section_simple');

function component_block_contactus($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/block-contactus', $args);
}
add_shortcode('townhub-block-contactus', 'component_block_contactus');

function component_me_membership($atts, $content='') {
  $args = shortcode_atts_global($atts);
  if(meMembership()){
    $membership_id = (isset($_SESSION['membership']->id) && $_SESSION['membership']->id>0) ? $_SESSION['membership']->membership->id : 0;
    do_shortcode("[townhub-memberships-style-1 membership_id=\"{$membership_id}\"][/townhub-memberships-style-1]");
  } else {
    do_shortcode("[townhub-memberships-style-1 active_pays=\"true\" limit=\"12\"][/townhub-memberships-style-1]");
  }
}
add_shortcode('townhub-me-membership', 'component_me_membership');

function component_me_profile_editor($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/me-profile-editor', $args);
}
add_shortcode('townhub-me-profile-editor', 'component_me_profile_editor');

function component_me_change_pass($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/me-change-pass', $args);
}
add_shortcode('townhub-me-change-pass', 'component_me_change_pass');

function component_me_wallets($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/me-wallets', $args);
}
add_shortcode('townhub-me-wallets', 'component_me_wallets');

function component_me_beneficiaries($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/me-beneficiaries', $args);
}
add_shortcode('townhub-me-beneficiaries', 'component_me_beneficiaries');

function component_me_payment($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/me-payment', $args);
}
add_shortcode('townhub-me-payment', 'component_me_payment');

function component_me_add_payment($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/me-add-payment', $args);
}
add_shortcode('townhub-me-add-payment', 'component_me_add_payment');

function component_me_history_recharges($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/me-history-recharges', $args);
}
add_shortcode('townhub-me-history-recharges', 'component_me_history_recharges');

function component_me_history_affiliates($atts, $content='') {
  $args = shortcode_atts_global($atts);
  get_template_part('components/me-history-affiliates', $args);
}
add_shortcode('townhub-me-history-affiliates', 'component_me_history_affiliates');

function component_pricing_table($atts, $content='') {
  $args = shortcode_atts_global($atts);
  $args['steps'] = @json_decode(@base64_decode($args['steps']));
  get_template_part('components/pricing-table', $args);
}
add_shortcode('townhub-pricing-table', 'component_pricing_table');
