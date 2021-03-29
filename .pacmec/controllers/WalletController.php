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
class WalletController extends \PACMEC\ControladorBase
{

	public $error = true;
	public $message= "";
	public $wallet_puid = null;
	public $wallet = null;
	private $model_wallet = null;

    public function __construct() {
        parent::__construct();
				header('Content-Type: application/json');
				$this->model_wallet = new \PACMEC\Wallet();
				if(isset($_REQUEST['puid']) && !empty($_REQUEST['puid']) && isset($_REQUEST['pin']) && !empty($_REQUEST['pin'])){
					$this->wallet = $this->model_wallet->get_by_puid_and_pin_and_user($_REQUEST['puid'], $_REQUEST['pin']);
				} else if(isset($_REQUEST['uid']) && !empty($_REQUEST['uid']) && isset($_REQUEST['pin']) && !empty($_REQUEST['pin'])){
					$this->wallet = $this->model_wallet->get_by_uid_and_pin_and_user($_REQUEST['uid'], $_REQUEST['pin']);
				}

				if (isset($this->wallet->id) && $this->wallet->id>0) {
					$this->setSuccess("Monedero encontrado.");
					$this->wallet_puid = $this->wallet->puid;
				} else {
					$this->setError("Monedero no encontrado, verifica que el pin sea correcto.");
					echo json_encode($this);
					exit;
				}
    }

	public function setError($message){
		$this->error = true;
		$this->message = $message;
	}

	public function setSuccess($message){
		$this->error = false;
		$this->message = $message;
	}

  public function index(){
	echo json_encode($this);
	return json_encode($this);
  }

  public function exchangeMw2Mw()
	{
		if(!isset($_REQUEST['amount']) || empty($_REQUEST['amount'])) {
			$this->setError(_autoT("required_amount"));
			echo json_encode($this);
			return json_encode($this);
		}
		if(!isset($_REQUEST['to']) || empty($_REQUEST['to'])) {
			$this->setError(_autoT("required_wallet_to"));
			echo json_encode($this);
			return json_encode($this);
		}
		$wallet_to = new \PACMEC\Wallet();
		$wallet_to->exist_wallet_by_puid($_REQUEST['to']);
		if($wallet_to->id>0){
			$r_from = $this->model_wallet->subtract_balance((float) $_REQUEST['amount'], 'transfer_out');
			$r_to = $wallet_to->add_balance((float) $_REQUEST['amount'], 'transfer_in');
			if($r_from == true && $r_to == true){
				$this->setSuccess(_autoT("exchange_success"));
			} else {
				$this->setError(_autoT("exchange_fail"));
			}
		} else {
			$this->setError(_autoT("wallet_to_no_exist"));
		}
		echo json_encode($this);
		return json_encode($this);
  }

  public function changeStatus()
	{
		$status = ['actived','losted','locked'];
		if(!isset($_REQUEST['status']) || empty($_REQUEST['status'])) {
			$this->setError(_autoT("required_status"));
			echo json_encode($this);
			return json_encode($this);
		}
		switch($_REQUEST['status']){
			case 'actived':
				if ($this->model_wallet->status == 'active') {
					$this->message = _autoT("wallet_not_active");
				}
				else {
					$actived = $this->model_wallet->actived();
					$this->error = !$actived;
					$this->message = $actived==true?_autoT("wallet_actived"):_autoT("wallet_actived_faild");
				}
			break;
			case 'locked':
				if ($this->model_wallet->status == 'active') {
					$locked = $this->model_wallet->locked();
					$this->error = !$locked;
					$this->message = $locked==true?_autoT("wallet_locked"):_autoT("wallet_locked_faild");
				}
				else if ($this->model_wallet->status == 'locked') {
					$this->message = _autoT("wallet_is_locked");
				}
				else {
					$this->message = _autoT("wallet_no_is_locked");
				}
			break;
			case 'losted':
				if ($this->model_wallet->status == 'lost') {
					$this->message = _autoT("wallet_is_losted");
				}
				else {
					$actived = $this->model_wallet->losted();
					$this->error = !$actived;
					$this->message = $actived==true?_autoT("wallet_losted"):_autoT("wallet_losted_fail");
				}
			break;
			default:
				$this->setError(_autoT("status_undefinded"));
			break;
		}
		echo json_encode($this);
		return json_encode($this);
  }
}
