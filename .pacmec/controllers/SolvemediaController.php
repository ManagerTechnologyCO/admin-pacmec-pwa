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
class SolvemediaController extends \PACMEC\ControladorBase {
	public $error         = true;
	public $message       = "";
	public $error_details = null;

  public function __construct()
  {
		parent::__construct();
		header('Content-Type: application/json');
  }

	public function setError($message){
		$this->error = true;
		$this->message = $message;
	}

	public function setSuccess($message){
		$this->error = false;
		$this->message = $message;
	}

  public function index()
  {

  }

  public function check_answer()
  {
    $data = array_merge($_GET, $_POST);
    if(isset($data['adcopy_challenge']) && !empty($data['adcopy_challenge']) && isset($data['adcopy_response']) && !empty($data['adcopy_response'])){
      $privkey="d6VKOKzFJwZCcUdD5AVKCAe71Pk3wZxX";
      $hashkey="7Th0LSusSK9vuGUX7NuB523TtUYzVU2j";
      $solvemedia_response = solvemedia_check_answer($privkey,
      					$_SERVER["REMOTE_ADDR"],
      					$data["adcopy_challenge"],
      					$data["adcopy_response"],
      					$hashkey);
      if (!$solvemedia_response->is_valid) {
      	$this->setError(_autoT("{$solvemedia_response->error}"));
      }
      else {
      	$this->setSuccess(_autoT('solvemedia_success'));
      }
    } else {
      $this->setError(_autoT('request_invalid'));
    }
		echo json_encode($this);
		return json_encode($this);
  }
}
