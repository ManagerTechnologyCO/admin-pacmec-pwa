<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    PACMEC
 * @category   Controllers
 * @copyright  2020-2021 Manager Technology CO
 * @license    license.txt
 * @version    Release: @package_version@
 * @link       http://github.com/ManagerTechnologyCO/PACMEC
 * @version    1.0.1
 */
Class PacmecController extends \PACMEC\ControladorBase
{
	public function __construct() {
		parent::__construct();
		header('Content-Type: application/json');
	}

  public function index(){
		echo json_encode($this);
		return json_encode($this);
  }
}
