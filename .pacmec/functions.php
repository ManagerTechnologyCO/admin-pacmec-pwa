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

function siteinfo($option_name)
{
	if(!isset($GLOBALS['PACMEC']['options'][$option_name])){
		return "NaN";
	}
	return $GLOBALS['PACMEC']['options'][$option_name];
}

function infosite($option_name)
{
  return siteinfo($option_name);
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
	$GLOBALS['PACMEC']['menus'] = [];
	$GLOBALS['PACMEC']['theme'] = [];
	$GLOBALS['PACMEC']['plugins'] = [];
  $GLOBALS['PACMEC']['detect'] = ["langs"=>[]];
  $GLOBALS['PACMEC']['options'] = [];
	$GLOBALS['PACMEC']['alerts'] = [];
	$GLOBALS['PACMEC']['total_records'] = [];
	$GLOBALS['PACMEC']['glossary'] = [];
  $GLOBALS['PACMEC']['glossary_txt'] = [];
	$GLOBALS['PACMEC']['memberships']['allow_signups'] = [];
}

function pacmec_init_session()
{
  session_set_save_handler(new PACMEC\SysSession(), true);
  if(is_session_started() === FALSE || session_id() === "") session_start();
	$GLOBALS['PACMEC']['session'] = new PACMEC\Session();
}

function pacmec_parse_value($option_value){
  switch ($option_value) {
    case 'true':
      return true;
      break;
    case 'false':
      return false;
      break;
    case 'null':
      return null;
      break;
    default:
      return $option_value;
      break;
  }
}

/**
 * @debug
 *
 */
function pacmec_init_options()
{
	foreach($GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM {$GLOBALS['PACMEC']['DB']->getPrefix()}options", []) as $option){
		$GLOBALS['PACMEC']['options'][$option->option_name] = pacmec_parse_value($option->option_value);
	};
	foreach($GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM {$GLOBALS['PACMEC']['DB']->getPrefix()}glossary ", []) as $option){
		$GLOBALS['PACMEC']['glossary'][$option->tag] = ["name" => $option->name, "id"=>$option->id];
	};
  $GLOBALS['PACMEC']['total_records'] = $GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT `table_name` AS `name`, `table_rows` AS `total` FROM {$GLOBALS['PACMEC']['DB']->getPrefix()}total_records WHERE `table_rows` IS NOT NULL", []);

  $memberships = new \PACMEC\Memberships();
	$GLOBALS['PACMEC']['memberships']['allow_signups'] = $memberships->load_signups_plans();
	//$GLOBALS['PACMEC']['memberships'] = $GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM {$GLOBALS['PACMEC']['DB']->getPrefix()}memberships WHERE `allow_signups` IN (?)", [1]);
  setlocale(LC_MONETARY, infosite('site_format_currency'));
	$GLOBALS['PACMEC']['plugins'] = pacmec_load_plugins(PACMEC_PATH."plugins");

  if(!empty($_GET['lang'])){
    $GLOBALS['PACMEC']['lang'] = in_array($_GET['lang'], array_keys($GLOBALS['PACMEC']['glossary'])) ? $_GET['lang'] : (!empty($_COOKIE['language']) ? $_COOKIE['language'] : siteinfo("lang_default"));
  } else if (isset($_COOKIE['language']) && !empty($_COOKIE['language']) && isset($GLOBALS['PACMEC']['glossary'][$_COOKIE['language']])){
    $GLOBALS['PACMEC']['lang'] = $_COOKIE['language'];
  } else if (siteinfo("enable_autotranslate") == true && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    // romper la cuerda en pedazos (idiomas y factores q)
    preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
    if (count($lang_parse[1])) {
        // crea una lista como "es" => 0.8
        $GLOBALS['PACMEC']['detect']['langs'] = array_combine($lang_parse[1], $lang_parse[4]);
        // establecer por defecto en 1 para cualquiera sin factor q
        foreach ($GLOBALS['PACMEC']['detect']['langs'] as $lang => $val) { if ($val === '') $langs[$lang] = 1; }
        // ordenar lista seg??n el valor
        arsort($GLOBALS['PACMEC']['detect']['langs'], SORT_NUMERIC);
    }

    $i = 0;
    foreach ($GLOBALS['PACMEC']['detect']['langs'] AS $lang => $score) {
      if($i == 0){
        if(isset($GLOBALS['PACMEC']['glossary'][$lang])){
          $GLOBALS['PACMEC']['lang'] = $lang;
          break;
        }
      }
    }
  } else {
    $GLOBALS['PACMEC']['lang'] = siteinfo("lang_default");
  }
  setcookie('language', $GLOBALS['PACMEC']['lang']);

	foreach($GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM {$GLOBALS['PACMEC']['DB']->getPrefix()}glossary_txt WHERE `glossary_id` IN (?) ", [$GLOBALS['PACMEC']['glossary'][$GLOBALS['PACMEC']['lang']]['id']]) as $option){
		$GLOBALS['PACMEC']['glossary_txt'][$option->slug] = $option->text;
	};

  if(infosite('socials_twitter_widget') == true){
    $user = infosite('socials_twitter_u');
    if(!empty($user) && $user !== 'NaN'){
      add_action('head-scripts', function() use ($user) {
        echo '
        window.addEventListener("load", function(){
          if (??("#footer-twiit").length > 0) {
              var config1 = {
                  "profile": {
                      "screenName": "'.$user.'"
                  },
                  "domId": "footer-twiit",
                  "maxTweets": 4,
                  "enableLinks": true,
                  "showImages": false
              };
              twitterFetcher.fetch(config1);
          }
        })
        ';
      });
    }
  }

  if(infosite('ajaxChimp_enabled')==true && infosite('ajaxChimp_element') !== "NaN"){
    add_action('footer-scripts', function() {
      echo '
      $("'.infosite('ajaxChimp_element').'").ajaxChimp({
          language: "'.$GLOBALS['PACMEC']['lang'].'",
          url: "'.infosite('ajaxChimp_url').'"
      });';
    });
  }

  if(infosite("wco_mode") !== "NaN"){
    define("WCO_MODE", infosite('wco_mode'));
    define("WCO_VERS", infosite('wco_version'));
    define("WCO_CURRENCY", infosite('site_currency'));
    define("WCO_KEY_PUB", WCO_MODE !== 'production' ? infosite('wco_pub_test') : infosite('wco_pub_production'));
    define("WCO_KEY_PRV", WCO_MODE !== 'production' ? infosite('wco_prv_test') : infosite('wco_prv_production'));
    define("WCO_KEY_EVENTS", WCO_MODE !== 'production' ? infosite('wco_events_test') : infosite('wco_events_production'));
  }


  /*
  $.ajaxChimp.translations.eng = {
      submit: "Submitting...",
      0: '<i class="fa fa-check"></i> We will be in touch soon!',
      1: '<i class="fa fa-warning"></i> You must enter a valid e-mail address.',
      2: '<i class="fa fa-warning"></i> E-mail address is not valid.',
      3: '<i class="fa fa-warning"></i> E-mail address is not valid.',
      4: '<i class="fa fa-warning"></i> E-mail address is not valid.',
      5: '<i class="fa fa-warning"></i> E-mail address is not valid.'
  };*/
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
		if(isset($GLOBALS['PACMEC']['plugins'][$plug])){
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
          "text" => "??Quiere desactivarlos?"
        ]
      ],
    ]);
  }
	do_action("init");
}

function current_url()
{
  return $GLOBALS['PACMEC']['req_url'];
}

function pacmec_init_system()
{
	foreach(glob(PACMEC_PATH."system/init/*.php") as $file){
		require_once $file;
  }
}

function pacmec_init_route()
{
	$site_url = siteinfo('siteurl');
	$enable_ssl = boolval(siteinfo('enable_ssl'));
	$currentUrl = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_SERVER['REQUEST_URI'];
	$currentUrl = (strtok($currentUrl, '?'));
	$reqUrl = str_replace([$site_url], '', $currentUrl);
	$detectAPI = explode("/", $reqUrl);
  if(isset($detectAPI[1]) && $detectAPI[1] == 'pacmec-api'){
    require_once 'api.php';
    exit;

    // use \FG\ApiRest\Api;
    // use \FG\ApiRest\Config;
    // use \FG\ApiRest\RequestFactory;
    // use \FG\ApiRest\ResponseUtils;
  	$infoAPI = '{
  		"info":{
  			"title":"'.infosite("sitename").'",
  			"description":"'.infosite("sitedescr").'",
  			"version":"3.0.0"
  		}
  	}';

    exit;
  }
	$GLOBALS['PACMEC']['req_url'] = $reqUrl;
  $model_route = new PACMEC\ROUTE([
    'page_slug'=>$reqUrl
  ]);
  // Comprobar que exista y que est?? activo.
  if($model_route->id>0&&$model_route->is_actived==true){
    //echo "route: ";
  }
  $GLOBALS['PACMEC']['route'] = $model_route;
}

function pacmec_validate_route()
{
  if($GLOBALS['PACMEC']['route']->theme == null) $GLOBALS['PACMEC']['route']->theme = siteinfo('theme_default');

  add_action('page_title', function(){ if(isset($GLOBALS['PACMEC']['route']->id)){ echo (pageinfo('page_title') !== 'NaN') ? _autoT(pageinfo('page_title')) : _autoT(pageinfo('title')); } });
  add_action('page_titpage_descriptionle', function(){ if(isset($GLOBALS['PACMEC']['route']->id)){ echo (pageinfo('page_description') !== 'NaN') ? pageinfo('page_description') : _autoT(pageinfo('description')); } });
  add_action('page_body', function(){
  	if(isset($GLOBALS['PACMEC']['route']->request_uri) && $GLOBALS['PACMEC']['route']->request_uri !== ""){
  		# $GLOBALS['PACMEC']['route']->content
  		echo do_shortcode($GLOBALS['PACMEC']['route']->content);

      /* javascript
      foreach ($GLOBALS['PACMEC']['route']->components as $component) {
        $attrs = [];
        foreach ($component->data as $key => $value) {
          if(is_object($value) || is_array($value)) $value = base64_encode(json_encode($value));
          $attrs[$key] = $value;
        }
        echo do_shortcode(\PHPStrap\Util\Shortcode::tag($component->component, "", [], $attrs, false) . "\n");
      }*/
  	}
  	else {
  		echo do_shortcode(
  			errorHtml("Lo sentimos, no se encontro el archivo o p??gina.", "Ruta no encontrada")
  		);
  	}
  });
  /*
  add_action('head', function(){
    $r = "\t<script type=\"text/javascript\" charset=\"UTF-8\">";
    $r .= "
      window.mtAsyncInit = function() {
        PACMEC.init({
      		api_server : 'https://pacmec.managertechnology.com.co',
      		appId      : 'managertechnology',
      		token      : 'pacmec',
      		Wmode      : '".infosite('wco_mode')."',
      		Wversion      : 'v1',
      	});
      };";
    $r .= "
    </script>";
    echo $r;
    //Wmode      : '<?= WCO_MODE; ?',
  });*/
}

function pacmec_decode_64_sys($label)
{
  return json_decode(base64_decode(infosite($label)));
}

function errorHtml(string $error_message="Ocurrio un problema.", $error_title="Error"){
	// '<a href="/pacmec/hola-mundo">CONT??CTENOS <i class="fa fa-angle-right" aria-hidden="true"></i></a>'
	return sprintf("<h1>%s</h1><p>%s</p>", $error_title, $error_message);
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
          "text" => "??Quiere revisar los temas?"
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

  add_scripts_head(siteinfo('siteurl') . "/.pacmec/system/dist/bootbox/bootbox.all.min.js",    ["type"=>"text/javascript", "charset"=>"UTF-8"], 0, false);
  add_scripts_head(siteinfo('siteurl') . "/.pacmec/system/dist/bootbox/bootbox.locales.min.js",    ["type"=>"text/javascript", "charset"=>"UTF-8"], 0, false);
  add_scripts_head(siteinfo('siteurl') . "/.pacmec/system/dist/sweetalert2/sweetalert2.all.min.js",    ["type"=>"text/javascript", "charset"=>"UTF-8"], 0, false);
  add_scripts_head(siteinfo('siteurl') . "/.pacmec/system/dist/vue/vue.min.js",    ["type"=>"text/javascript", "charset"=>"UTF-8"], 0, false);
  add_scripts_head(siteinfo('siteurl') . "/.pacmec/system/dist/vue/vue-router.js",    ["type"=>"text/javascript", "charset"=>"UTF-8"], 0, false);

  add_scripts_head(siteinfo('siteurl') . "/.pacmec/system/assets/js/sdk.js"."?&cache=".rand(),   ["type"=>"text/javascript", "charset"=>"UTF-8"], 0, false);

  if(siteinfo('enable_pwa') == true) add_scripts_foot(siteinfo('siteurl') . "/.pacmec/system/assets/js/main.js",   ["type"=>"text/javascript", "charset"=>"UTF-8"], 0, false);
}

// FUNCIONES PARA EL CONTROLADOR FRONTAL
function cargarControlador($controller){
  $controlador = ucwords($controller).'Controller';
  $strFileController = PACMEC_PATH . 'controllers/'.$controlador.'.php';
  if(!is_file($strFileController)){ $strFileController = PACMEC_PATH . 'controllers/PacmecController.php'; }
  require_once $strFileController;
  $controllerObj = new $controlador();
  return $controllerObj;
}

function cargarAccion($controllerObj,$action){
  $accion = $action;
  $controllerObj->$accion();
}

function lanzarAccion($controllerObj){
  $data = array_merge($_GET, $_POST);
  if (isset($data["action"]) && method_exists($controllerObj, $data["action"])){
    cargarAccion($controllerObj, $data["action"]);
  }
	else {
    cargarAccion($controllerObj, "index");
  }
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
    $raw_json = retrieveJsonPostData();
    $raw = [];
    if(is_object($raw_json)){
      foreach ($raw_json as $key => $value) {
        $_POST[$key] = $value;
      }
    }
    $data = array_merge($_GET, $_POST);
    if(isset($data['controller']))
    {
      $controllerObj = cargarControlador($data["controller"]);
      lanzarAccion($controllerObj);
    }
    else
    {
      require_once $GLOBALS['PACMEC']['theme']['dir'] . '/index.php';
    }
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

/**
 * @param string $file <p>File</p>
 * @param array|object $attrs <p>attr</p>
**/
function get_template_part($file, $atts=null)
{
  try {
  	if(!is_file("{$GLOBALS['PACMEC']['theme']['dir']}/{$file}.php") || !file_exists("{$GLOBALS['PACMEC']['theme']['dir']}/{$file}.php")){
      throw new \Exception("No existe archivo. {$GLOBALS['PACMEC']['theme']['text_domain']} -> {$file}. {$GLOBALS['PACMEC']['theme']['dir']}/{$file}.php", 1);
  	}
    if(isset($atts) && (is_array($atts) || is_object($atts))){
      foreach ($atts as $id_assoc => $valor) {
        if(!isset(${$id_assoc}) || ${$id_assoc} !== $valor){
          ${$id_assoc} = $valor;
        }
      }
    }
  	require_once "{$GLOBALS['PACMEC']['theme']['dir']}/{$file}.php";
  } catch(\Exception $e) {
    echo("Error critico en tema: {$e->getMessage()}");
  }
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
  do_action( "head" );
  $a = "";
  foreach($GLOBALS['PACMEC']['website']['styles']['head'] as $file){ $a .= \PHPStrap\Util\Html::tag($file['tag'], "", [], $file['attrs'], true)."\t"; }
  $a .= \PHPStrap\Util\Html::tag('style', do_action( "head-styles" ), [], ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], false) . "\t";
  foreach($GLOBALS['PACMEC']['website']['scripts']['head'] as $file){ $a .= \PHPStrap\Util\Html::tag($file['tag'], "", [], $file['attrs'], false)."\t"; }
  echo "<script type=\"text/javascript\">";
  echo '
    var WCO = {
			pub: "' . (infosite('wco_mode') == 'production' ? infosite('wco_pub_prod') : infosite('wco_pub_test') ) .  '",
		};
    window.mtAsyncInit = function(){
      PACMEC.init({
        api_server : location.protocol + "//" + location.host,
        appId      : "clubcampestreparaisosol",
        token      : "pacmec",
        Wmode      : "'.infosite('wco_mode').'",
        Wversion   : "v1",
      });
    }
  ';
  echo "</script>";
  echo "{$a}";
  echo "<script type=\"text/javascript\">";
  do_action( "head-scripts" );
  echo "</script>";
  echo "\n";
	return true;
}

function pacmec_foot()
{
  stable_usort($GLOBALS['PACMEC']['website']['styles']['foot'], 'pacmec_ordering_by_object_asc');
  stable_usort($GLOBALS['PACMEC']['website']['scripts']['foot'], 'pacmec_ordering_by_object_asc');
  $a = "";
	foreach($GLOBALS['PACMEC']['website']['styles']['foot'] as $file){ $a .= \PHPStrap\Util\Html::tag($file['tag'], "", [], $file['attrs'], true)."\t"; }
  $a .= \PHPStrap\Util\Html::tag('style', do_action( "footer-styles" ), [], ["rel"=>"stylesheet", "type"=>"text/css", "charset"=>"UTF-8"], false) . "\t";
	foreach($GLOBALS['PACMEC']['website']['scripts']['foot'] as $file){ $a .= \PHPStrap\Util\Html::tag($file['tag'], "", [], $file['attrs'], false)."\t"; }
  // $a .= \PHPStrap\Util\Html::tag('script', do_action( "footer-scripts" ), [], ["type"=>"text/javascript", "charset"=>"UTF-8"], false);
  echo "{$a}";
  echo "<script type=\"text/javascript\">";
  do_action( "footer-scripts" );
  echo "</script>";
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

function the_content()
{
  do_action('page_body');
  //echo do_shortcode($GLOBALS['PACMEC']['route']->content);
  #foreach ($GLOBALS['PACMEC']['route']->components as $component) { echo do_shortcode(\PHPStrap\Util\Shortcode::tag($component->component, "", [], $component->data, false) . "\n"); }
}

/**
 * Hooks a function on to a specific action.
 *
 * @param    string       $tag              <p>
 *                                          The name of the action to which the
 *                                          <tt>$function_to_add</tt> is hooked.
 *                                          </p>
 * @param    string|array $function_to_add  <p>The name of the function you wish to be called.</p>
 * @param    int          $priority         <p>
 *                                          [optional] Used to specify the order in which
 *                                          the functions associated with a particular
 *                                          action are executed (default: 50).
 *                                          Lower numbers correspond with earlier execution,
 *                                          and functions with the same priority are executed
 *                                          in the order in which they were added to the action.
 *                                          </p>
 * @param     string      $include_path     <p>[optional] File to include before executing the callback.</p>
 *
 * @return bool
 */
function add_action(string $tag, $function_to_add, int $priority = 50, string $include_path = null) : bool {
	return $GLOBALS['PACMEC']['hooks']->add_action($tag, $function_to_add, $priority, $include_path);
}

/**
 * Execute functions hooked on a specific action hook.
 *
 * @param    string $tag     <p>The name of the action to be executed.</p>
 * @param    mixed  $arg     <p>
 *                           [optional] Additional arguments which are passed on
 *                           to the functions hooked to the action.
 *                           </p>
 *
 * @return   bool            <p>Will return false if $tag does not exist in $filter array.</p>
 */
function do_action(string $tag, $arg = ''): bool {
	return $GLOBALS['PACMEC']['hooks']->do_action($tag, $arg);
}

/**
 * Search content for shortcodes and filter shortcodes through their hooks.
 *
 * <p>
 * <br />
 * If there are no shortcode tags defined, then the content will be returned
 * without any filtering. This might cause issues when plugins are disabled but
 * the shortcode will still show up in the post or content.
 * </p>
 *
 * @param string $content <p>Content to search for shortcodes.</p>
 *
 * @return string <p>Content with shortcodes filtered out.</p>
 */
function do_shortcode(string $content) : string {
	return $GLOBALS['PACMEC']['hooks']->do_shortcode($content);
}

function shortcode_atts_global($atts, $shortcode = '') : array {
  $pairs = [
    "definition" => null,
    "userStatus" => null,
    "glossary" => null,
    "lang_labels" => null,
    "me" => null,
    "wallets" => null,
    "wallets_balance" => null,
    "beneficiaries" => null,
    "payment" => null,
    "notifications" => null,
    "page" => null,
    "name" => null,
    "title" => "title_front",
    "subtitle" => "title_back",
    "description" => "content",
    "content" => "description",
    "picture" => null,
    "pictureBG" => "bg",
    "videoProvider" => "video_provider",
    "videoID" => "vid",
    "recordThumb" => null,
    "link" => null,
    "icon" => null,
    "enable_search" => "form_search",
    "icons" => "icons_menu",
    "steps" => null,
    "counters" => null,
  ];
  $pairs_condictions = [
    "videoActive" => ["videoID","videoProvider"],
    //"enable_search" => ["enable_search"],
  ];
  $args = [];
  foreach ($pairs as $key => $value) {
    $args[$key] = null;
    if($value !== null && isset($atts[$value])) $args[$key] = $atts[$value];
    else if($value !== null && isset($atts["data-{$value}"])) $args[$key] = $atts["data-{$value}"];
    else if(isset($atts[$key])) $args[$key] = $atts[$key];
  }
  foreach ($pairs_condictions as $key => $values) {
    $i = 0;
    foreach ($values as $a) {
      if(isset($args[$a]) !== null && isset($args[$a]) !== null) $i++;
    }
    if(count($values) === $i) $args[$key] = true;
    else $args[$key] = false;
  }
  $repair = shortcode_atts($args, $atts, $shortcode);
  $repair = array_merge($repair, [
    "request_uri" => current_url(),
    "lang" => $GLOBALS['PACMEC']['lang'],
    "membership" => meMembership(),
  ]);
  return $repair;
}

/**
 * Add hook for shortcode tag.
 *
 * <p>
 * <br />
 * There can only be one hook for each shortcode. Which means that if another
 * plugin has a similar shortcode, it will override yours or yours will override
 * theirs depending on which order the plugins are included and/or ran.
 * <br />
 * <br />
 * </p>
 *
 * Simplest example of a shortcode tag using the API:
 *
 * <code>
 * // [footag foo="bar"]
 * function footag_func($atts) {
 *  return "foo = {$atts[foo]}";
 * }
 * add_shortcode('footag', 'footag_func');
 * </code>
 *
 * Example with nice attribute defaults:
 *
 * <code>
 * // [bartag foo="bar"]
 * function bartag_func($atts) {
 *  $args = shortcode_atts(array(
 *    'foo' => 'no foo',
 *    'baz' => 'default baz',
 *  ), $atts);
 *
 *  return "foo = {$args['foo']}";
 * }
 * add_shortcode('bartag', 'bartag_func');
 * </code>
 *
 * Example with enclosed content:
 *
 * <code>
 * // [baztag]content[/baztag]
 * function baztag_func($atts, $content='') {
 *  return "content = $content";
 * }
 * add_shortcode('baztag', 'baztag_func');
 * </code>
 *
 * @param string   $tag  <p>Shortcode tag to be searched in post content.</p>
 * @param callable $callback <p>Hook to run when shortcode is found.</p>
 *
 * @return bool
 */
function add_shortcode($tag, $callback) : bool {
	if($GLOBALS['PACMEC']['hooks']->shortcode_exists($tag) == false){
		/*
		if(!isset($_GET['editor_front'])){
		} else {
			return $GLOBALS['PACMEC']['hooks']->add_shortcode( $tag, function() use ($tag) { echo "[{$tag}]"; } );
			return true;
		};*/
		return $GLOBALS['PACMEC']['hooks']->add_shortcode( $tag, $callback );
	} else {
		return false;
	}
}

/**
*
* Add
*
* @param array   $pairs       *
* @param array   $atts        *
* @param string  $shortcode   (Optional)
*
* @return array
*/
function shortcode_atts($pairs, $atts, $shortcode = ''): array {
	return $GLOBALS['PACMEC']['hooks']->shortcode_atts($pairs, $atts, $shortcode);
}

/**
 * Adds Hooks to a function or method to a specific filter action.
 *
 * @param    string              $tag             <p>
 *                                                The name of the filter to hook the
 *                                                {@link $function_to_add} to.
 *                                                </p>
 * @param    string|array|object $function_to_add <p>
 *                                                The name of the function to be called
 *                                                when the filter is applied.
 *                                                </p>
 * @param    int                 $priority        <p>
 *                                                [optional] Used to specify the order in
 *                                                which the functions associated with a
 *                                                particular action are executed (default: 50).
 *                                                Lower numbers correspond with earlier execution,
 *                                                and functions with the same priority are executed
 *                                                in the order in which they were added to the action.
 *                                                </p>
 * @param string                 $include_path    <p>
 *                                                [optional] File to include before executing the callback.
 *                                                </p>
 *
 * @return bool
 */
function add_filter(string $tag, $function_to_add, int $priority = 50, string $include_path = null): bool
{
  return $GLOBALS['PACMEC']['hooks']->add_filter($tag, $function_to_add, $priority, $include_path);
}

/**
*
* Traduccion automatica
*
* @param string   $label       *
* @param string   $lang        (Optional)
*
* @return string
*/
function pacmec_translate_label($label, $lang=null) : string
{
  if(isset($GLOBALS['PACMEC']['glossary_txt'][$label])) return $GLOBALS['PACMEC']['glossary_txt'][$label];
  $glossary_id = $GLOBALS['PACMEC']['glossary'][$GLOBALS['PACMEC']["lang"]]['id'];
  $slug = $label;
  $text = "??{{$label}}";
  try {
    $sql_ins = "INSERT INTO `{$GLOBALS['PACMEC']['DB']->getPrefix()}glossary_txt` (`glossary_id`, `slug`, `text`) SELECT * FROM (SELECT {$glossary_id},'{$slug}','{$text}') AS tmp WHERE NOT EXISTS (SELECT `id` FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}glossary_txt` WHERE `glossary_id` = '{$glossary_id}' AND `slug` = '{$slug}') LIMIT 1";
    $insert = $GLOBALS['PACMEC']['DB']->FetchObject($sql_ins, []);
    if($insert>0){
      return "??{ $label }";
    }
    return "??E{ $label }";
  } catch (\Exception $e) {
    return "??{ $label }";
  }
  return "??{ $label }";
}

function pacmec_load_menu($menu_slug="")
{
  try {
    $m_s = $menu_slug;
    if(isset($GLOBALS['PACMEC']['meus'][$m_s])){
      throw new \Exception("El menu ya fue cargado.");
      return $GLOBALS['PACMEC']['meus'][$m_s];
    } else {
      #$model_menu = new \PACMEC\Menu(["by_slug"=>$m_s]);
      $model_menu = new \PACMEC\Menu();
      $model_menu->getBy('slug', $m_s);
      if($model_menu->id>0){
        return $model_menu;
      } else {
        throw new \Exception("??ERROR:(Menu no encontrado)");
      }
    }
    if($menu == null){
      throw new \Exception("??ERROR:(Menu no invalido)");
    } else {
      return "repair: ".json_encode($meu);
    }
  } catch (\Exception $e) {
    echo $e->getMessage();
    return false;
  }
}

/**
*
* Alias r??pido para Traduccion
*
* @param string $label Label a traduccir
*
* @return string
*/
function _autoT($label) : string
{
  return pacmec_translate_label($label);
}

/**
* Session
*/
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

function userinfo($option_name){
	return isset($GLOBALS['PACMEC']['session']->{$option_name}) ? $GLOBALS['PACMEC']['session']->{$option_name} : "";
}

function meinfo(){
	return isset($GLOBALS['PACMEC']['session']) ? $GLOBALS['PACMEC']['session'] : [];
}

function validate_permission($permission_label){
	$permission_label = $permission_label == null ? 'guest' : $permission_label;
	if($permission_label == "guest"){ return true; }
	if(!isset(userinfo('user')->id) || userinfo('user')->id == "" || userinfo('user')->id <= 0){ return false; }
	$permissions = userinfo('permissions_items');
	// $permissions = userinfo('permissions');
	if(isset($permissions[$permission_label])){ return true; }
	return false;
}

function isAdmin(){
	return ((isUser() && validate_permission('super_user')) || (isset($_SESSION['user']['is_admin'])&&$_SESSION['user']['is_admin']===1)) ? true : false;
}

function isUser(){
	return !(isGuest());
}

function isGuest(){
	return !isset($_SESSION['user']) ? true : false;
}

function me($key)
{
  return isset($_SESSION['user'][$key]) ? $_SESSION['user'][$key] : null;
}

/*
 * filtering an array
 */
function filter_by_value ($array, $index, $value){
	if(is_array($array) && count($array)>0)
	{
		foreach(array_keys($array) as $key){
			$temp[$key] = $array[$key][$index];

			if ($temp[$key] == $value){
				$newarray[$key] = $array[$key];
			}
		}
	  }
  return $newarray;
}

/*
 * filtering and count an array
 */
function filter_by_value_counter($array, $index){
	$array = is_array($array) ? $array : (array) $array;
	if(is_array($array) && count($array)>0)
	{
		foreach($array as $key=>$temp){
			// $temp[$key] = $array[$key][$index];
			// $newarray[$key] = count($array[$key][$index]);
			$newarray[$key] = count($temp->{$index});
		}
	  }
  return $newarray;
}

function randString($length) {
  $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  $char = @str_shuffle($char);
  for($i = 0, $rand = '', $l = @strlen($char) - 1; $i < $length; $i ++) {
      $rand .= $char[@mt_rand(0, $l)];
  }
  return $rand;
}



/*** Solvemedia ***/
/*
 * Copyright (c) 2009 by Jeff Weisberg
 * Author: Jeff Weisberg
 * Created: 2009-Jun-22 16:44 (EDT)
 * Function: SolveMedia API php code
 *
 * $Id$
 *
 * This is a PHP library that handles calling SolveMedia.
 *    - Documentation and latest version
 *          http://www.solvemedia.com/
 *    - Get a SolveMedia API Keys
 *          http://api.solvemedia.com/public/signup
 */

/* This code is based on code from,
 * and copied, modified and distributed with permission in accordance with its terms:
 *
 *   Copyright (c) 2007 reCAPTCHA
 *   AUTHORS:
 *     Mike Crawford
 *     Ben Maurer
 *
 *   Permission is hereby granted, free of charge, to any person obtaining a copy
 *   of this software and associated documentation files (the "Software"), to deal
 *   in the Software without restriction, including without limitation the rights
 *   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *   copies of the Software, and to permit persons to whom the Software is
 *   furnished to do so, subject to the following conditions:
 *
 *   The above copyright notice and this permission notice shall be included in
 *   all copies or substantial portions of the Software.
 *
 *   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *   THE SOFTWARE.
 */

/**
 * The solvemedia server URL's
 */
define("ADCOPY_API_SERVER",        "http://api.solvemedia.com");
define("ADCOPY_API_SECURE_SERVER", "https://api-secure.solvemedia.com");
define("ADCOPY_VERIFY_SERVER",     "verify.solvemedia.com");
define("ADCOPY_SIGNUP",            "http://api.solvemedia.com/public/signup");

/**
 * Encodes the given data into a query string format
 * @param $data - array of string elements to be encoded
 * @return string - encoded request
 */
function _adcopy_qsencode ($data) {
        $req = "";
        foreach ( $data as $key => $value )
                $req .= $key . '=' . urlencode( stripslashes($value) ) . '&';
        // Cut the last '&'
        $req=substr($req,0,strlen($req)-1);
        return $req;
}

/**
 * Submits an HTTP POST to a solvemedia server
 * @param string $host
 * @param string $path
 * @param array $data
 * @param int port
 * @return array response
 */
function _adcopy_http_post($host, $path, $data, $port = 80) {
        $req = _adcopy_qsencode ($data);
        $http_request  = "POST $path HTTP/1.0\r\n";
        $http_request .= "Host: $host\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
        $http_request .= "Content-Length: " . strlen($req) . "\r\n";
        $http_request .= "User-Agent: solvemedia/PHP\r\n";
        $http_request .= "\r\n";
        $http_request .= $req;
        $response = '';
        if( false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) ) {
                die ('Could not open socket');
        }
        fwrite($fs, $http_request);
        while ( !feof($fs) )
                $response .= fgets($fs, 1024); // One TCP-IP packet [sic]
        fclose($fs);
        $response = explode("\r\n\r\n", $response, 2);
        return $response;
}

/**
 * Gets the challenge HTML (javascript and non-javascript version).
 * This is called from the browser, and the resulting solvemedia HTML widget
 * is embedded within the HTML form it was called from.
 * @param string $pubkey A public key for solvemedia
 * @param string $error The error given by solvemedia (optional, default is null)
 * @param boolean $use_ssl Should the request be made over ssl? (optional, default is false)

 * @return string - The HTML to be embedded in the user's form.
 */
function solvemedia_get_html ($pubkey, $error = null, $use_ssl = true)
{
	if ($pubkey == null || $pubkey == '') {
		die ("To use solvemedia you must get an API key from <a href='" . ADCOPY_SIGNUP . "'>" . ADCOPY_SIGNUP . "</a>");
	}
	if ($use_ssl) {
                $server = ADCOPY_API_SECURE_SERVER;
        } else {
                $server = ADCOPY_API_SERVER;
        }
        $errorpart = "";
        if ($error) {
           $errorpart = ";error=1";
        }
        return '<script type="text/javascript" src="'. $server . '/papi/challenge.script?k=' . $pubkey . $errorpart . '"></script>
	<noscript>
  		<iframe src="'. $server . '/papi/challenge.noscript?k=' . $pubkey . $errorpart . '" height="300" width="500" frameborder="0"></iframe><br/>
  		<textarea name="adcopy_challenge" rows="3" cols="40"></textarea>
  		<input type="hidden" name="adcopy_response" value="manual_challenge"/>
	</noscript>';
}

/**
 * A SolveMediaResponse is returned from solvemedia_check_answer()
 */
class SolveMediaResponse {
        var $is_valid;
        var $error;
}

/**
  * Calls an HTTP POST function to verify if the user's guess was correct
  * @param string $privkey
  * @param string $remoteip
  * @param string $challenge
  * @param string $response
  * @param string $hashkey
  * @return SolveMediaResponse
  */
function solvemedia_check_answer ($privkey, $remoteip, $challenge, $response, $hashkey = '' )
{
	if ($privkey == null || $privkey == '') {
		die ("To use solvemedia you must get an API key from <a href='" . ADCOPY_SIGNUP . "'>" . ADCOPY_SIGNUP . "</a>");
	}
	if ($remoteip == null || $remoteip == '') {
		die ("For security reasons, you must pass the remote ip to solvemedia");
	}
        if ($challenge == null || strlen($challenge) == 0 || $response == null || strlen($response) == 0) {
                $adcopy_response = new SolveMediaResponse();
                $adcopy_response->is_valid = false;
                $adcopy_response->error = 'incorrect-solution';
                return $adcopy_response;
        }
        $response = _adcopy_http_post (ADCOPY_VERIFY_SERVER, "/papi/verify",
                                          array (
                                                 'privatekey' => $privkey,
                                                 'remoteip'   => $remoteip,
                                                 'challenge'  => $challenge,
                                                 'response'   => $response
                                                 )
                                          );
        $answers = explode ("\n", $response [1]);
        $adcopy_response = new SolveMediaResponse();
        if( strlen($hashkey) ){
                # validate message authenticator
                $hash = sha1( $answers[0] . $challenge . $hashkey );

                if( $hash != $answers[2] ){
                        $adcopy_response->is_valid = false;
                        $adcopy_response->error = 'hash-fail';
                        return $adcopy_response;
                }
        }
        if (trim ($answers [0]) == 'true') {
                $adcopy_response->is_valid = true;
        }
        else {
                $adcopy_response->is_valid = false;
                $adcopy_response->error = $answers [1];
        }
        return $adcopy_response;
}

/**
 * gets a URL where the user can sign up for solvemedia. If your application
 * has a configuration page where you enter a key, you should provide a link
 * using this function.
 * @param string $domain The domain where the page is hosted
 * @param string $appname The name of your application
 */
function solvemedia_get_signup_url ($domain = null, $appname = null) {
	return ADCOPY_SIGNUP . "?" .  _adcopy_qsencode (array ('domain' => $domain, 'app' => $appname));
}

/**
  * Calls an HTTP POST function to verify if the user's response was correct
  * @param string $privkey
  * @param string $$verifycode
  * @return SolveMediaResponse
  */
function solvemedia_precheck_response ($privkey, $verifycode)
{
    if ($verifycode == null || strlen($verifycode) == 0 ) {
            $adcopy_response = new SolveMediaResponse();
            $adcopy_response->is_valid = false;
            $adcopy_response->error = 'incorrect-solution';
            return $adcopy_response;
    }
    $response = _adcopy_http_post (ADCOPY_VERIFY_SERVER, "/papi/verify.precheck.server",
                                      array (
                                             'privatekey' => $privkey,
                                             'verify_code' => $verifycode
                                             )
                                      );
    $answers = explode ("\n", $response [1]);
    $adcopy_response = new SolveMediaResponse();
    if (trim ($answers [0]) == 'true') {
            $adcopy_response->is_valid = true;
    }
    else {
            $adcopy_response->is_valid = false;
            $adcopy_response->error = $answers [1];
    }
    return $adcopy_response;
}

function getIpRemote(){
  $ip = "0.0.0.0";
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
      $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

function PowBy(){
   return "&#169; ".infosite('sitename')." . All rights reserved." . base64_decode("IHwg") . base64_decode("UHJvdWRseSBwb3dlcmVkIGJ5IE1hbmFnZXIgVGVjaG5vbG9neQ==");
}

/* Mailhide related code */
/* [ deleted ] */










/** END **/
