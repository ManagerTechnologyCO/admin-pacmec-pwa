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

/**
*
* VIEW API DOCS
*
* @param array  $atts
* @param string  $content
*/
function pacmec_api_docs($atts, $content='')
{
  try {
    $repair = shortcode_atts([
    ], $atts);
    echo '
    <main>
      <div class="pacmec-card-4">
        <header class="pacmec-container pacmec-blue">
          <h1>OPENAPI</h1>
        </header>
        <div class="pacmec-container" style="background: #FFF;">
          <redoc style="position:static;background;#FFF;" spec-url="'.infosite('siteurl').'/pacmec-api/openapi"></redoc>
        </div>
        <footer class="pacmec-container pacmec-blue">
          <h5>Footer</h5>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/redoc@next/bundles/redoc.standalone.js"> </script>
      </div>
    </main>
    ';
  } catch (\Exception $e) {
    return "Ups: pacmec_api_docs: " . $e->getMessage();
  }
}
add_shortcode('pacmec-api-docs', 'pacmec_api_docs');

/**
*
* Solvemedia CAPTCHA
*
* @param array  $atts
* @param string  $content
*/
function pacmec_solvemedia($atts, $content='')
{
  try {
    $repair = shortcode_atts([
      'C-key' => "hqf0HycsKOX3uP9.ggJtdy7tUdEOM8Ce",
      'V-key' => "d6VKOKzFJwZCcUdD5AVKCAe71Pk3wZxX",
      'H-key' => "7Th0LSusSK9vuGUX7NuB523TtUYzVU2j"
    ], $atts);
    $privkey = $repair['V-key'];
    $hashkey = $repair['H-key'];
    $solvemedia_response = solvemedia_check_answer($privkey,
    					$_SERVER["REMOTE_ADDR"],
    					$_POST["adcopy_challenge"],
    					$_POST["adcopy_response"],
    					$hashkey);
    if (!$solvemedia_response->is_valid) {
    	//handle incorrect answer
    	print "Error: ".$solvemedia_response->error;
    }
    else {
    	//process form here

    }
  } catch (\Exception $e) {
    return "Ups: pacmec_solvemedia: " . $e->getMessage();
  }
}
add_shortcode('pacmec-api-docs', 'pacmec_solvemedia');
