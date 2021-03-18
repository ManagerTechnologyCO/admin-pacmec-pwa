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

function retrieveJsonPostData()
{
  $rawData = file_get_contents("php://input");
  return json_decode($rawData);
}

function pacmec_init_header()
{
	foreach(glob(PACMEC_PATH."includes/init/*.php") as $file){
		require_once $file;
		$classNameFile = basename($file);
		$className = str_replace([".php"],'', $classNameFile);
		if(
      !class_exists('PACMEC\\'.$className) && !interface_exists('PACMEC\\'.$className)
    ){
			echo "Clase no encontrada {$className}";
			//echo json_encode(class_exists('PACMEC\\'.$className));
			exit();
		}
	}

	foreach(glob(PACMEC_PATH."includes/models/*.php") as $file){
		require_once $file;
		$classNameFile = basename($file);
		$className = str_replace([".php"],'', $classNameFile);
		if(
       !class_exists('PACMEC\\'.$className) && !interface_exists('PACMEC\\'.$className)
    ){
			echo "Clase no encontrada {$className}";
			//echo json_encode(class_exists('PACMEC\\'.$className));
			exit();
		}
	}
}

function isAdmin()
{
	return isUser() && validate_permission('super_user') ? true : false;
}

function isUser()
{
	return !isGuest() ? true : false;
}

function isGuest()
{
	return !isset($_SESSION['user']) ? true : false;
}

function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

function siteinfo($option_name)
{
	if(!isset($GLOBALS['PACMEC']['options'][$option_name])){
		return "-NaN-";
	}
	return $GLOBALS['PACMEC']['options'][$option_name];
}

function pacmec_init_vars()
{
	global $PACMEC;
	$GLOBALS['PACMEC'] = [];
	$GLOBALS['PACMEC']['hooks'] = PACMEC\Hooks::getInstance();
	$GLOBALS['PACMEC']['DB'] = new PACMEC\DB();
	$GLOBALS['PACMEC']['method'] = isset($_SERVER['REQUEST_METHOD']) ? $method = $_SERVER['REQUEST_METHOD'] : $method = 'GET';
	$GLOBALS['PACMEC']['lang'] = NULL;
	$GLOBALS['PACMEC']['req_url'] = "";
	$GLOBALS['PACMEC']['route'] = null;
	$GLOBALS['PACMEC']['website'] = [
    "meta" => [],
    "scripts" => ["head"=>[],"foot"=>[],"list"=>[]],
    "styles" => ["head"=>[],"foot"=>[],"list"=>[]]
  ];
	$GLOBALS['PACMEC']['session'] = null;
	///$GLOBALS['PACMEC']['menus'] = [];
	$GLOBALS['PACMEC']['theme'] = [];
	$GLOBALS['PACMEC']['plugins'] = [];
  $GLOBALS['PACMEC']['detect'] = ["langs"=>[]];
  $GLOBALS['PACMEC']['options'] = [];
	$GLOBALS['PACMEC']['alerts'] = [];
	$GLOBALS['PACMEC']['total_records'] = [];
	$GLOBALS['PACMEC']['glossary'] = [];
}

function pacmec_init_session()
{
  session_set_save_handler(new PACMEC\SysSession(), true);
  if(is_session_started() === FALSE || session_id() === "") session_start();
	$GLOBALS['PACMEC']['session'] = new PACMEC\Session();
}

/**
 * @debug
 * foreach(Menus::allLoad() as $menu){ $GLOBALS['PACMEC']['menus'][$menu->slug] = $menu; }
 */
function pacmec_init_options()
{
	foreach($GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM {$GLOBALS['PACMEC']['DB']->getPrefix()}options", []) as $option){
		$GLOBALS['PACMEC']['options'][$option->option_name] = $option->option_value;
	};
	foreach($GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM {$GLOBALS['PACMEC']['DB']->getPrefix()}glossary ", []) as $option){
		$GLOBALS['PACMEC']['glossary'][$option->tag] = ["name" => $option->name] ;
	};
  $GLOBALS['PACMEC']['total_records'] = $GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT `table_name` AS `name`, `table_rows` AS `total` FROM {$GLOBALS['PACMEC']['DB']->getPrefix()}total_records WHERE `table_rows` IS NOT NULL", []);

	$GLOBALS['PACMEC']['plugins'] = pacmec_load_plugins(PACMEC_PATH."plugins");
  if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
      // romper la cuerda en pedazos (idiomas y factores q)
      preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
      if (count($lang_parse[1])) {
          // crea una lista como "es" => 0.8
          $GLOBALS['PACMEC']['detect']['langs'] = array_combine($lang_parse[1], $lang_parse[4]);
          // establecer por defecto en 1 para cualquiera sin factor q
          foreach ($GLOBALS['PACMEC']['detect']['langs'] as $lang => $val) { if ($val === '') $langs[$lang] = 1; }
          // ordenar lista según el valor
          arsort($GLOBALS['PACMEC']['detect']['langs'], SORT_NUMERIC);
      }
      // if($GLOBALS['PACMEC']['glossary'][$option->tag])
      $i = 0;
      foreach ($GLOBALS['PACMEC']['detect']['langs'] AS $lang => $score) {
        if($i == 0){
          if($GLOBALS['PACMEC']['glossary'][$lang]){
            $GLOBALS['PACMEC']['lang'] = $lang;
          }
          break;
        } else {
          break;
        }
      }
  }
  if($GLOBALS['PACMEC']['lang'] == null){ $GLOBALS['PACMEC']['lang'] = siteinfo('lang_default'); }
}

function php_file_tree_dir_JSON_exts($directory, $return_link, $extensions = array(), $first_call = true, $step=0, $limit=1)
{
	if( function_exists("scandir") ) $file = scandir($directory); else $file = php4_scandir($directory);
	natcasesort($file);
	$files = $dirs = array();
	foreach($file as $this_file) {
		if( is_dir("$directory/$this_file" ) ) $dirs[] = $this_file; else $files[] = $this_file;
	}
	$file = array_merge($dirs, $files);
	if( !empty($extensions) ) {
		foreach( array_keys($file) as $key ) {
			if( !is_dir("$directory/$file[$key]") ) {
				$ext = substr($file[$key], strrpos($file[$key], ".") + 1);
				if( in_array($ext, $extensions) ) unset($file[$key]);
			}
		}
	}

	$php_file_tree_array = [];
	if( count($file) > 2 ) {
		foreach( $file as $this_file ) {
			if( $this_file != "." && $this_file != ".." ) {
				$item = new stdClass();
				$item->isFile = is_dir("$directory/$this_file") ? false : true;
				$item->name = is_dir("$directory/$this_file") ? $this_file : str_replace([substr($this_file, strrpos($this_file, "."))], '', htmlspecialchars($this_file));
				#$item->ext = substr($this_file, strrpos($this_file, ".") + 1);
				$item->directory = $directory;
				$item->link = "{$directory}/{$this_file}";
				$item->child = [];

				if( is_dir("$directory/$this_file") && $step>$limit) {
					$php_file_tree = php_file_tree_dir_JSON("$directory/$this_file", $return_link ,$extensions, false);
					$item->child = php_file_tree_dir_JSON("$directory/$this_file", $return_link ,$extensions, false, $step+1, $limit);
				}

				$php_file_tree_array[] = $item;
				/*

				$item->link = str_replace("[link]", "$directory/" . urlencode($this_file), $return_link);
				# $item->more = [];

				if( is_dir("$directory/$this_file") ) {
					$item->isFolder = true;
					$item->more = php_file_tree_dir_JSON("$directory/$this_file", $return_link ,$extensions, false, $adapter);
				} else {
					$item->isFile = true;
				}*/

			}
		}
	}
	return $php_file_tree_array;
}

function pacmec_validate_file($file)
{
	if(is_dir($file) && $is_file($file))
  {
		return "directory";
	} else {
		if(is_file($file) && file_exists($file) && !is_dir($file)){
			$texto = @file_get_contents($file);
			$input_line = nl2br($texto);
			preg_match_all('/[*\s]+([a-zA-Z\s\i]+)[:]+[\s]+([a-zA-Z0-9]+[^<]+)/mi', $input_line, $detect_array);
			$detect = [];
			// validar si es plugin
			foreach($detect_array[1] as $i=>$lab){ $detect[str_replace(['  ', ' ', '+'], '_', strtolower($lab))] = $detect_array[2][$i]; }
			if(isset($detect['plugin_name']) && isset($detect['version'])){
				return "plugin";
			}
			// validar si es tema
			foreach($detect_array[1] as $i=>$lab){ $detect[str_replace(['  ', ' ', '+'], '_', strtolower($lab))] = $detect_array[2][$i]; }
			if(isset($detect['theme_name']) && isset($detect['version'])){
				return "theme";
			}
		}
	}
	return "undefined";
}

function pacmec_extract_info($file)
{
	if(is_dir($file))
  {
		return [];
	} else
  {
		if(is_file($file) && file_exists($file))
    {
			$texto = @file_get_contents($file);
			$input_line = nl2br($texto);
			preg_match_all('/[*\s]+([a-zA-Z\s\i]+)[:]+[\s]+([a-zA-Z0-9]+[^<]+)/mi', $input_line, $detect_array);
			$detect = [];
			// validar si es plugin
			foreach($detect_array[1] as $i=>$lab){ $detect[str_replace(['  ', ' ', '+'], '_', strtolower($lab))] = $detect_array[2][$i]; }

			$detect['dir'] = dirname($file);
			$detect['path'] = $file;
			if((isset($detect['plugin_name']) && isset($detect['version'])) || (isset($detect['theme_name']) && isset($detect['version']))){
				return $detect;
			}
		}
	}
	return [];
}

function checkFolder($path)
{
  if(!is_dir($path)) mkdir($path, 0755);
  if(!is_dir($path)) { echo "No se puede acceder o crear -> $path"; exit; }
}

function pacmec_load_plugins($path)
{
  checkFolder($path);
	$r = [];
	$folder_JSON = php_file_tree_dir_JSON_exts($path, true, [], true, 0, 1);
	foreach($folder_JSON as $file){
		if(is_dir($file->link)){
			$r = array_merge($r, pacmec_load_plugins($file->link));
		} else {
			$type = pacmec_validate_file($file->link);
			if($type == "plugin"){
				$plugins_activated = siteinfo("plugins_activated");
				$info = pacmec_extract_info($file->link);
				if(isset($info['plugin_name'])){
					$info['active'] = false;
					$info['text_domain'] = strtolower(isset($info['text_domain']) ? $info['text_domain'] : str_replace(['  ',' '], ['-','-'], $info['plugin_name']));
					$r[$info['text_domain']] = $info;
				}
			}
		}
	}
	return $r;
}

function pacmec_option_update_for_label($label, $value)
{
	try {
		return $GLOBALS['PACMEC']['DB']->FetchObject("UPDATE IGNORE `{$GLOBALS['PACMEC']['DB']->getPrefix()}options` SET `option_value`=? WHERE `option_name`= ?", [$value,$label]);
	}
	catch(Exception $e){
		#echo $e->getMessage();
		return false;
	}
}

function pacmec_init_plugins_actives()
{
	$plugs = [];
	foreach(explode(',', siteinfo('plugins_activated')) as $plug){
		// echo json_encode($plug);
		if(isset($GLOBALS['PACMEC']['plugins'][$plug])){
			// echo "\t\t\t\tExiste \n";
			$GLOBALS['PACMEC']['plugins'][$plug]['active'] = true;
			$plugs[] = $plug;
			require_once ($GLOBALS['PACMEC']['plugins'][$plug]['path']);
		}
	}
	#if(implode(',', $plugs) !== siteinfo('plugins_activated')){ pacmec_option_update_for_label('plugins_activated', implode(',', $plugs)); }
  if(implode(',', $plugs) !== siteinfo('plugins_activated')){
    #pacmec_option_update_for_label('plugins_activated', implode(',', $plugs));
    PACMEC\Alert::addAlert([
      "type"     => "error",
      "plugin"     => "system",
      "message"  => "Hay problemas cargando algunos plugins, quiere desactivarlos?\n",
      "actions"  => [
        [
          "name" => "plugins-autosync",
          "slug" => "/?c=admin&a=plugins&e=autosync",
          "text" => "¿Quiere desactivarlos?"
        ]
      ],
    ]);
    /*
    $GLOBALS['PACMEC']['alerts'][] = ;*/
    // exit;
  }
	// echo "\t--- plugins validados ---\n";
}

function pacmec_init_route()
{
	$site_url = siteinfo('siteurl');
	$enable_ssl = boolval(siteinfo('enable_ssl'));
	$currentUrl = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_SERVER['REQUEST_URI'];
	$currentUrl = (strtok($currentUrl, '?'));
	$reqUrl = str_replace([$site_url], '', $currentUrl);
	$detectAPI = explode('/', $reqUrl);
	$GLOBALS['PACMEC']['req_url'] = $reqUrl;
  $model_route = new PACMEC\ROUTE([
    'page_slug'=>$reqUrl
  ]);
  // Comprobar que exista y que esté activo.
  if($model_route->id>0&&$model_route->is_actived==true){
    //echo "route: ";
  }
  $GLOBALS['PACMEC']['route'] = $model_route;
}

function pacmec_validate_route()
{
  if($GLOBALS['PACMEC']['route']->theme == null) $GLOBALS['PACMEC']['route']->theme = siteinfo('theme_default');
}

function pacmec_load_theme($path)
{
  checkFolder($path);
	$r = [];
	$folder_JSON = php_file_tree_dir_JSON_exts($path, true, [], true, 0, 0);
	foreach($folder_JSON as $file){
		if(is_dir($file->link)){
			//$r = array_merge($r, pacmec_load_theme($file->link));
		} else {
			$type = pacmec_validate_file($file->link);
			if($type == "theme"){
				$info = pacmec_extract_info($file->link);
				if(isset($info['theme_name'])){
					$info['text_domain'] = strtolower(isset($info['text_domain']) ? $info['text_domain'] : str_replace(['  ',' '], ['-','-'], $info['theme_name']));
					$r[] = $info;
				}
			}
		}
	}
	return isset($r[0]) ? $r[0] : [];
}

function pacmec_theme_check()
{
  if($GLOBALS['PACMEC']['route']->theme !== null && !empty($GLOBALS['PACMEC']['route']->theme) && $GLOBALS['PACMEC']['route']->theme !== 'system')
  {
    $GLOBALS['PACMEC']['theme'] = pacmec_load_theme(PACMEC_PATH . "themes/" . $GLOBALS['PACMEC']['route']->theme);
  }
  else if($GLOBALS['PACMEC']['route']->theme == null)
  {
    $GLOBALS['PACMEC']['theme'] = pacmec_load_theme(PACMEC_PATH . "system/themes/system");
  }

  if(!isset($GLOBALS['PACMEC']['theme']['dir'])){
    $GLOBALS['PACMEC']['theme'] = pacmec_load_theme(PACMEC_PATH . "system/themes/system");
    PACMEC\Alert::addAlert([
      "type"     => "error",
      "plugin"     => "system",
      "message"  => "No existe el tema: {$GLOBALS['PACMEC']['route']->theme}\n",
      "actions"  => [
        [
          "name" => "themes",
          "slug" => "/?c=admin&a=themes",
          "text" => "¿Quiere revisar los temas?"
        ]
      ],
    ]);
  }
  if(is_file($GLOBALS['PACMEC']['theme']['path']) && file_exists($GLOBALS['PACMEC']['theme']['path']))
  {
    require_once ($GLOBALS['PACMEC']['theme']['path']);
  } else {

    exit("El tema no existe.");
  }
}

function add_style_head($src, $attrs = [], $ordering = 0.35, $add_in_list = false)
{
  if(!isset($attrs) || $attrs==null || !is_array($attrs)) $attrs = [];
  if(!isset($ordering) || $ordering==null) $ordering = 0.35;
  if(!isset($add_in_list) || $add_in_list==null) $add_in_list = false;
  if ($src) {
    if($add_in_list == true) $GLOBALS['PACMEC']['website']['styles']['list'][] = $src;
		$GLOBALS['PACMEC']['website']['styles']['head'][] = [
      "tag" => "link",
      "attrs" => array_merge($attrs, [
        "href" => $src,
        "ordering" => $ordering,
      ]),
      "ordering" => $ordering,
    ];
		return true;
	}
	return false;
}

function add_style_foot($src, $attrs = [], $ordering = 0.35, $add_in_list = false)
{
  if(!isset($attrs) || $attrs==null || !is_array($attrs)) $attrs = [];
  if(!isset($ordering) || $ordering==null) $ordering = 0.35;
  if(!isset($add_in_list) || $add_in_list==null) $add_in_list = false;
  if ($src) {
    if($add_in_list == true) $GLOBALS['PACMEC']['website']['styles']['list'][] = $src;
		$GLOBALS['PACMEC']['website']['styles']['foot'][] = [
      "tag" => "link",
      "attrs" => array_merge($attrs, [
        "href" => $src,
        "ordering" => $ordering,
      ]),
      "ordering" => $ordering,
    ];
		return true;
	}
	return false;
}

function add_scripts_head($src, $attrs = [], $ordering = 0.35, $add_in_list = false)
{
  if(!isset($attrs) || $attrs==null || !is_array($attrs)) $attrs = [];
  if(!isset($ordering) || $ordering==null) $ordering = 0.35;
  if(!isset($add_in_list) || $add_in_list==null) $add_in_list = false;
  if ($src) {
    if($add_in_list == true) $GLOBALS['PACMEC']['website']['scripts']['list'][] = $src;
		$GLOBALS['PACMEC']['website']['scripts']['head'][] = [
      "tag" => "script",
      "attrs" => array_merge($attrs, [
        "src" => $src,
        "ordering" => $ordering,
      ]),
      "ordering" => $ordering,
    ];
		return true;
	}
	return false;
}

function add_scripts_foot($src, $attrs = [], $ordering = 0.35, $add_in_list = false)
{
  if(!isset($attrs) || $attrs==null || !is_array($attrs)) $attrs = [];
  if(!isset($ordering) || $ordering==null) $ordering = 0.35;
  if(!isset($add_in_list) || $add_in_list==null) $add_in_list = false;
  if ($src) {
    if($add_in_list == true) $GLOBALS['PACMEC']['website']['scripts']['list'][] = $src;
		$GLOBALS['PACMEC']['website']['scripts']['foot'][] = [
      "tag" => "script",
      "attrs" => array_merge($attrs, [
        "src" => $src,
        "ordering" => $ordering,
      ]),
      "ordering" => $ordering,
    ];
		return true;
	}
	return false;
}

function pacmec_assets_globals()
{
  add_style_head(siteinfo('siteurl')   . "/.pacmec/system/assets/css/pacmec.css",  ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 1, false);
  add_style_head(siteinfo('siteurl')   . "/.pacmec/system/assets/css/plugins.css", ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], 0.99, false);
  add_scripts_head(siteinfo('siteurl') . "/.pacmec/system/assets/js/plugins.js",   ["type"=>"text/javascript", "charset"=>"UTF-8"], 1, false);
  add_scripts_foot(siteinfo('siteurl') . "/.pacmec/system/assets/js/sdk.js",   ["type"=>"text/javascript", "charset"=>"UTF-8"], 0, false);

  if(siteinfo('enable_pwa') == true) add_scripts_foot(siteinfo('siteurl') . "/.pacmec/system/assets/js/main.js",   ["type"=>"text/javascript", "charset"=>"UTF-8"], 0, false);
}

function pacmec_run_ui()
{
  if(
    isset($GLOBALS['PACMEC']['theme']['dir'])
    && is_file($GLOBALS['PACMEC']['theme']['path'])
    && file_exists($GLOBALS['PACMEC']['theme']['path'])
    && is_file($GLOBALS['PACMEC']['theme']['dir'] . '/index.php')
    && file_exists($GLOBALS['PACMEC']['theme']['dir'] . '/index.php')
  )
  {
    require_once $GLOBALS['PACMEC']['theme']['dir'] . '/index.php';
  } else {
    echo "Hubo un problema al ejecutar la Interfas de Usuario. {$GLOBALS['PACMEC']['theme']['text_domain']} -> index.php]";
    exit;
  }
}

function get_header()
{
  return get_template_part("header");
}

function route_active()
{
	if(isset($GLOBALS['PACMEC']['route']->is_actived) && isset($GLOBALS['PACMEC']['route']->request_uri)){
		return true;
	} else {
		return false;
	}
}

function get_template_part($file)
{
	if(!is_file("{$GLOBALS['PACMEC']['theme']['dir']}/{$file}.php") || !file_exists("{$GLOBALS['PACMEC']['theme']['dir']}/{$file}.php")){
		exit("Error critico en tema, no existe archivo. {$GLOBALS['PACMEC']['theme']['text_domain']} -> {$file}. {$GLOBALS['PACMEC']['theme']['dir']}/{$file}.php");
	}
	require_once "{$GLOBALS['PACMEC']['theme']['dir']}/{$file}.php";
}

function language_attributes()
{
	return "class=\"".siteinfo('html_type')."\" lang=\"{$GLOBALS['PACMEC']['lang']}\"";
}

function pageinfo($key)
{
	return isset($GLOBALS['PACMEC']['route']->{$key}) ? "{$GLOBALS['PACMEC']['route']->{$key}}" : siteinfo($key);
}

function pacmec_ordering_by_object_asc($a, $b)
{
  if(is_object($a)) $a = array($a);
  if(is_object($b)) $b = array($b);
  if ($a['ordering'] == $b['ordering']) {
      return 0;
  }
  return ($a['ordering'] > $b['ordering']) ? -1 : 1;
}

function pacmec_ordering_by_object_desc($a, $b)
{
  if(is_object($a)) $a = array($a);
  if(is_object($b)) $b = array($b);
  if ($a['ordering'] == $b['ordering']) {
      return 0;
  }
  return ($a['ordering'] < $b['ordering']) ? -1 : 1;
}

function pacmec_ordering_by_object($array = [], $order_by="asc")
{
  switch ($order_by) {
    case 'asc':
      return stable_usort($array, "pacmec_ordering_by_object_asc");
      break;
    default:
      return stable_usort($array, "pacmec_ordering_by_object_desc");
      break;
  }
}

function stable_usort(&$array, $cmp)
{
    $i = 0;
    $array = array_map(function($elt)use(&$i)
    {
        return [$i++, $elt];
    }, $array);
    usort($array, function($a, $b)use($cmp)
    {
        return $cmp($a[1], $b[1]) ?: ($a[0] - $b[0]);
    });
    $array = array_column($array, 1);
}

function pacmec_head()
{
  stable_usort($GLOBALS['PACMEC']['website']['styles']['head'], 'pacmec_ordering_by_object_asc');
  stable_usort($GLOBALS['PACMEC']['website']['scripts']['head'], 'pacmec_ordering_by_object_asc');
  $a = "";
	foreach($GLOBALS['PACMEC']['website']['styles']['head'] as $file){ $a .= \PHPStrap\Util\Html::tag($file['tag'], "", [], $file['attrs'], true)."\t"; }
  $a .= \PHPStrap\Util\Html::tag('style', do_action( "head-styles" ), [], ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], false) . "\t";
	foreach($GLOBALS['PACMEC']['website']['scripts']['head'] as $file){ $a .= \PHPStrap\Util\Html::tag($file['tag'], "", [], $file['attrs'], false)."\t"; }
  $a .= \PHPStrap\Util\Html::tag('script', do_action( "head-scripts" ), [], ["type"=>"text/javascript", "charset"=>"UTF-8"], false);
  echo "{$a}";
  do_action( "head" );
  echo "\n";
	return true;
}

function do_action(string $tag, $arg = '') : bool
{
	return $GLOBALS['PACMEC']['hooks']->do_action( $tag, $arg );
}

function pacmec_foot()
{
  stable_usort($GLOBALS['PACMEC']['website']['styles']['foot'], 'pacmec_ordering_by_object_asc');
  stable_usort($GLOBALS['PACMEC']['website']['scripts']['foot'], 'pacmec_ordering_by_object_asc');
  $a = "";
	foreach($GLOBALS['PACMEC']['website']['styles']['foot'] as $file){ $a .= \PHPStrap\Util\Html::tag($file['tag'], "", [], $file['attrs'], true)."\t"; }
  $a .= \PHPStrap\Util\Html::tag('style', do_action( "footer-styles" ), [], ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], false) . "\t";
	foreach($GLOBALS['PACMEC']['website']['scripts']['foot'] as $file){ $a .= \PHPStrap\Util\Html::tag($file['tag'], "", [], $file['attrs'], false)."\t"; }
  $a .= \PHPStrap\Util\Html::tag('script', do_action( "footer-scripts" ), [], ["type"=>"text/javascript", "charset"=>"UTF-8"], false);
  echo "{$a}";
  do_action( "footer" );
  echo "\n";
  if(MODE_DEBUG == true) require_once PACMEC_PATH . '.debug/footer.php';
	return true;
}

function get_footer()
{
  return get_template_part("footer");
}

function get_template_directory_uri()
{
	return siteinfo('siteurl') . "/.pacmec/themes/{$GLOBALS['PACMEC']['theme']['text_domain']}";
}
/*

function cargarControlador($controller){
 $controlador = ucwords($controller).'Controller';
 $strFileController = CORE_PATH . '/controller/'.$controlador.'.php';
 if(!is_file($strFileController)){ $strFileController = CORE_PATH . '/controller/'.ucwords(CONTROLADOR_DEFECTO).'Controller.php'; }
 require_once $strFileController;
 $controllerObj = new $controlador();
 return $controllerObj;
}

function cargarAccion($controllerObj,$action){
 $accion = $action;
 $controllerObj->$accion();
}

function lanzarAccion($controllerObj){
 #if (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET' && isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"])){
 if (isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"])){
   cargarAccion($controllerObj, $_GET["action"]);
 }
 else if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST["action"]) && method_exists($controllerObj, $_POST["action"])){
   cargarAccion($controllerObj, $_POST["action"]);
 }
	else {
   cargarAccion($controllerObj, ACCION_DEFECTO);
 }
}

*/
