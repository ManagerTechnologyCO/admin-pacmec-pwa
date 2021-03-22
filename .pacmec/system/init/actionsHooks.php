<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    PACMEC
 * @category   System
 * @copyright  2020-2021 Manager Technology CO
 * @license    license.txt
 * @version    Release: @package_version@
 * @link       http://github.com/ManagerTechnologyCO/PACMEC
 * @version    1.0.1
 */

function pacmec_menu_item_to_li($item1, $target="_self", $tree = true, $enable_tag = true, $enable_icon_m = true)
{
  $icon_more = isset($item1->childs) && count($item1->childs)>0 ? \PHPStrap\Util\Html::tag("i", "", ["fa fa-caret-down"]) : "";
  $icon      = \PHPStrap\Util\Html::tag("i", "", [$item1->icon]);
  $title = _autoT($item1->title);
  $link = \PHPStrap\Util\Html::tag("a", "\n{$icon}".($enable_tag==true?" {$title}":"").($enable_icon_m==true?" {$icon_more}":""), [], ["href"=>$item1->tag_href, "target"=>$target]);
  if(isset($item1->childs) && count($item1->childs)>0 && $tree == true){
    $subitems = "";
    foreach ($item1->childs as $subitem) {
      $subitems .= pacmec_menu_item_to_li($subitem);
    }
    $ul_more = "\n".\PHPStrap\Util\Html::tag("ul", $subitems, []);
  } else {
    $ul_more = "";
  }
  $item_html = \PHPStrap\Util\Html::tag("li", "{$link}{$ul_more}");
  return $item_html;
}

/**
*
* Create UL single/inline
*
* @param array  $atts
* @param string  $content
*/
function pacmec_ul_no_list_style($atts, $content='')
{
  try {
    $repair = shortcode_atts([
      "target" => "_self",
      "class" => [],
      "iconpro" => "",
      "menu_slug" => false,
    ], $atts);
    if($repair['menu_slug'] == false){
      throw new \Exception("Menu no detectado.", 1);
    } else {
      $menu = pacmec_load_menu($repair['menu_slug']);
      if($menu !== false){
        $r_html = "";
        foreach ($menu->items as $key => $item1) {
          $r_html .= pacmec_menu_item_to_li($item1, $repair['target']);
        }
        $styles = isset($repair['class']) ? $repair['class'] : ["no-list-style"];
        return \PHPStrap\Util\Html::tag("ul", $r_html, $styles);
      } else {
      throw new \Exception("Menu no encontrado.", 1);
      }
    }
  } catch (\Exception $e) {
    return "Ups: pacmec_ul_no_list_style: " . $e->getMessage();
  }
}
add_shortcode('pacmec-ul-no-list-style', 'pacmec_ul_no_list_style');

function pacmec_nav_top_menu($atts, $content='')
{
  try {
    return \PHPStrap\Util\Html::tag("nav", pacmec_ul_no_list_style($atts, $content));
  } catch (\Exception $e) {
    return "Ups: pacmec_ul_no_list_style: " . $e->getMessage();
  }
}
add_shortcode('pacmec-nav-top-menu', 'pacmec_nav_top_menu');

/**
*
* Create UL Socials Icons
*
* @param array  $atts
* @param string  $content
*/
function pacmec_ul_no_list_style_one_level_social_icons($atts, $content='')
{
  try {
    $repair = shortcode_atts([
      "target" => "_self",
      "enable_tag" => false,
      "class" => [],
      "iconpro" => "",
      "menu_slug" => false,
    ], $atts);
    if($repair['menu_slug'] == false){
      throw new \Exception("Menu no detectado.", 1);
    } else {
      $menu = pacmec_load_menu($repair['menu_slug']);
      if($menu !== false){
        $r_html = "";
        foreach ($menu->items as $key => $item1) {
          $r_html .= pacmec_menu_item_to_li($item1, $repair['target'], false, $repair['enable_tag']);
        }
        $styles = isset($repair['class']) ? $repair['class'] : ["no-list-style"];
        return \PHPStrap\Util\Html::tag("ul", $r_html, $styles);
      } else {
      throw new \Exception("Menu no encontrado.", 1);
      }
    }
  } catch (\Exception $e) {
    return "Ups: pacmec_ul_no_list_style_one_level_social_icons: " . $e->getMessage();
  }
}
add_shortcode('pacmec-ul-no-list-style-one-level-social-icons', 'pacmec_ul_no_list_style_one_level_social_icons');

// do_shortcode('[pacmec-forms class="custom-form" form_id="1"][/pacmec-forms]');
