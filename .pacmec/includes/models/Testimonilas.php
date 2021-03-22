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

class Testimonilas extends ModeloBase
{
	public $user = null;

	public function __construct($args=[])
  {
		$args = (array) $args;
		parent::__construct("testimonilas", true);
	}

	public static function allLoad($limit=7) : array
  {
		try {
			return ($GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM `testimonilas` LIMIT ?", [$limit]));
		}
		catch(\Exception $e){
			return [];
		}
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
}
