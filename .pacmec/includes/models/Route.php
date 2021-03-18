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

namespace PACMEC;

class Route extends ModeloBase
{
	public $id = -1;
	public $is_actived = 1;
	public $parent = null;
	public $permission_access = null;
	public $title = 'no_found';
	public $theme = null;
	public $description = 'No Found';
	public $request_uri = '/404';
	public $component = 'pages-error';
	public $components = [];
	public $meta = [];

	public function __construct($args=[])
  {
		$args = (array) $args;
		parent::__construct("routes", false);
		if(isset($args['id'])){ $this->getBy('id', $args['id']); }
		if(isset($args['page_name'])){ $this->getBy('page_name', $args['page_name']); }
		if(isset($args['page_slug'])){ $this->getBy('request_uri', $args['page_slug']); }
		if(isset($args['request_uri'])){ $this->getBy('request_uri', $args['request_uri']); }
	}

	public static function allLoad() : array
  {
		$r = [];
		if(!isset($GLOBALS['PACMEC']['DB']) || !isset($GLOBALS['PACMEC']['DB']['prefix'])){ return $r; }
		foreach($GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM {$GLOBALS['PACMEC']['DB']['prefix']}{$this->getTable()} ", []) as $menu){
			$r[] = new Self($menu);
		}
		return $r;
	}

	public function getBy($column='id', $val="")
  {
		try {
			$this->setThis($GLOBALS['PACMEC']['DB']->FetchObject("SELECT * FROM {$this->getTable()} WHERE `{$column}`=?", [$val]));
			return $this;
		}
		catch(\Exception $e){
			return $this;
		}
	}

	private function setThis($arg)
	{
		if($arg !== null){
			if(is_object($arg) || is_array($arg)){
				$arg = (array) $arg;
				foreach($arg as $k=>$v){
					$this->{$k} = $v;
				}
        $this->getMeta();
        $this->getComponents();
			}
		}
	}

	public function isValid()
	{
		return $this->id > 0 ? true : false;
	}

  public function getComponents()
  {
    try {
      if($this->id>0){
        $result = $GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM `{$this->getTable()}_components` WHERE `route_id`=? ORDER BY `ordering` DESC", [$this->id]);
        if(is_array($result)) {
          $this->components = [];
          foreach ($result as $component) {
            $component->data = json_decode($component->data);
            $this->components[] = $component;
          }
        }
        return [];
      }
    }
    catch(\Exception $e){
      return [];
    }
  }

  public function getMeta()
  {
    try {
      if($this->id>0){
        $result = $GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM `{$this->getTable()}_meta` WHERE `route_id`=? ORDER BY `ordering` DESC", [$this->id]);
        if(is_array($result)) {
          $this->meta = [];
          foreach ($result as $meta) {
            $meta->attrs = json_decode($meta->attrs);
            $this->meta[] = $meta;
          }
        }
        return [];
      }
    }
    catch(\Exception $e){
      return [];
    }
  }
}
