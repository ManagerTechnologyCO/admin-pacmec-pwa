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

class Menu extends ModeloBase {
	private $prefix = null;
	private $db = null;
	public $id;
	public $name;
	public $slug;
	public $items = [];

	public function __construct($args=[]){
		$args = (array) $args;
		parent::__construct("menus", true);
		if(isset($args['by_id'])) $this->getBy('id', $args['by_id']);
		if(isset($args['by_slug'])) $this->getBy('slug', $args['by_slug']);
	}

	public function getBy($column='id', $val=""){
		try {
			return $this->setThis($GLOBALS['PACMEC']['DB']->FetchObject("SELECT * FROM `{$this->getTable()}` WHERE `{$column}`=?", [$val]));
		}
		catch(Exception $e){
			return $this;
		}
	}

	private function setThis($arg=[]){
		$arg = (array) $arg;
		foreach($arg as $k=>$v){
			if(isset($this->{$k})){
				$this->{$k} = $v;
			}
		}
		if($this->isValid()){
			$this->items = $this->loadItemsMenu($this->id);
		}
		return $this;
	}

	private function loadItemsMenu($id=0, $parent = 0){
		$r = [];
		foreach($GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM {$GLOBALS['PACMEC']['DB']->getPrefix()}menus_elements WHERE `menu`=? AND `index_id`=?", [$id,$parent]) as $item){
			$childs = $this->loadItemsMenu($id, $item->id);
			$item->childs = [];
			if($childs !== false){
				$item->childs = $childs;
			}
			$r[] = $item;
		}
		return $r;
	}

	public static function allLoad() : array {
		$r = [];
		foreach($GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM `{$this->getTable()}` ", []) as $menu){
			$r[] = new Self($menu);
		}
		return $r;
	}
}
