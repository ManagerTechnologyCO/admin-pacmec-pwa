<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    PACMEC
 * @category   Helper
 * @copyright  2020-2021 Manager Technology CO
 * @license    license.txt
 * @version    Release: @package_version@
 * @link       http://github.com/ManagerTechnologyCO/PACMEC
 * @version    1.0.1
 */

namespace PACMEC;

Class Wallet extends ModeloBase
{

	/*
    public function __construct($adapter) {
        $table="productos";
        parent::__construct($table,$adapter);
    }*/

  public function __construct($atts=[]) {
		parent::__construct('wallets', true);
  }

	public function get_by_purseid_and_userid($purse_id=0,$user_id=null){
		try {
			if($user_id==null) isset($_SESSION['user']['id']) ? $user_id = $_SESSION['user']['id'] : 0;
			$sql = "SELECT P.*, W.* FROM `{$this->getTable()}` W INNER JOIN `{$this->getPrefix()}purses` P ON P.wallet = W.id WHERE P.user_id IN (?) AND P.id IN (?) LIMIT 1";
			$result = $this->FetchObject($sql, [$user_id, $purse_id]);
			$result = $result !== false ? $result : (object) [];
			$this->setAll($result);
			return $result;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function get_by_uid_and_pin_and_user($uid=0,$pin=0,$user_id=null){
		try {
			if($user_id==null) isset($_SESSION['user']['id']) ? $user_id = $_SESSION['user']['id'] : 0;
			$sql = "SELECT P.*,W.* FROM `{$this->getTable()}` W INNER JOIN `{$this->getPrefix()}purses` P ON P.wallet = W.id WHERE W.`uid` IN (?) AND W.`pin` IN (?) AND P.user_id IN (?) LIMIT 1";
			$result = $this->FetchObject($sql, [$uid, $pin, $user_id]);
			$result = $result !== false ? $result : (object) [];
			$this->setAll($result);
			return $result;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function get_by_puid_and_pin_and_user($puid=0,$pin=0,$user_id=null){
		try {
			if($user_id==null) isset($_SESSION['user']['id']) ? $user_id = $_SESSION['user']['id'] : 0;
			$sql = "SELECT P.*,W.* FROM `{$this->getTable()}` W INNER JOIN `{$this->getPrefix()}purses` P ON P.wallet = W.id WHERE W.`puid` IN (?) AND W.`pin` IN (?) AND P.user_id IN (?) LIMIT 1";
			$result = $this->FetchObject($sql, [$puid, $pin, $user_id]);
			$result = $result !== false ? $result : (object) [];
			$this->setAll($result);
			return $result;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function get_by_puid_and_user($puid=0,$user_id=null){
		try {
			if($user_id==null) isset($_SESSION['user']['id']) ? $user_id = $_SESSION['user']['id'] : 0;
			$sql = "SELECT W.*, P.* FROM `{$this->getTable()}` W INNER JOIN `{$this->getPrefix()}purses` P ON P.wallet = W.id WHERE W.`puid` IN (?) AND P.user_id IN (?) LIMIT 1";
			$result = $this->FetchObject($sql, [$puid, $user_id]);
			$result = $result !== false ? $result : (object) [];
			$this->setAll($result);
			return $result;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function get_by_puid_and_pin($puid=0,$pin=0){
		try {
			$sql = "Select * FROM `{$this->getTable()}` WHERE `puid` IN (?) AND `pin` IN (?)";
			$result = $this->FetchObject($sql, [$puid, $pin]);
			$result = $result !== false ? $result : (object) [];
			$this->setAll($result);
			return $result;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function get_by_uid_and_pin($uid=0,$pin=0){
		try {
			$sql = "Select * FROM `{$this->getTable()}` WHERE `uid` IN (?) AND `pin` IN (?)";
			$result = $this->FetchObject($sql, [$uid, $pin]);
			$result = $result !== false ? $result : (object) [];
			$this->setAll($result);
			return $result;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function add_in_user_by_uid_and_pin($wallet_uid=0,$wallet_pin=0,$user_id=0){
		try {
			$return_obj = (object) [
				"error"=>true,
				"message"=>"Ocurrio un error consultado la informacion.",
			];
			$sql = "Select * FROM `{$this->getTable()}` WHERE `uid` IN (?) AND `pin` IN (?)";
			$result = $this->FetchObject($sql, [$wallet_uid, $wallet_pin]);
			$result = $result !== false ? $result : (object) [];
			$this->setAll($result);

			if($this->id == 0){
				$return_obj->message = "El monedero no fue encontrado, verifica los datos e intenta nuevamente.";
			} else {
				$exist = $this->FetchObject("Select * FROM `{$this->getPrefix()}purses` WHERE `user_id` IN (?) AND `wallet` IN (?)", [$user_id, $this->id]);
				if($exist == null){
          $sql_ins = "INSERT INTO
            `{$GLOBALS['PACMEC']['DB']->getPrefix()}purses` (`user_id`, `wallet`, `alias`, `created_by`, `modified_by`)
            SELECT * FROM (SELECT {$user_id},'0000000{$this->id}','{$wallet_uid}','00{$_SESSION['user']['id']}','000{$_SESSION['user']['id']}') AS tmp
            WHERE NOT EXISTS
              (SELECT `wallet` FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}purses` WHERE `user_id` = '{$user_id}' AND `wallet` = '{$this->id}')
            LIMIT 1";
					$insert = $GLOBALS['PACMEC']['DB']->FetchObject($sql_ins, []);
					if($insert>0){
						$return_obj->error = false;
						$return_obj->message = "Monedero agregado con éxito.";
					} else {
						$return_obj->message = "Ocurrio un error agregando el monedero, intente nuevamente. ";
					}
				} else {
					$return_obj->message = "El monedero ya existe.";
				}
			}
			return $return_obj;
		}
		catch(Exception $e){
			return (object) [
				"error"=>true,
				"message"=>$e->getMessage(),
			];
		}
	}

	public function clear_users_by_uid_and_pin($wallet_uid=0,$wallet_pin=0,$user_id=0){
		try {
			$return_obj = (object) [
				"error"=>true,
				"message"=>"Ocurrio un error consultado la informacion.",
			];
			$sql = "Select * FROM `{$this->getTable()}` WHERE `uid` IN (?) AND `pin` IN (?)";
			$result = $this->FetchObject($sql, [$wallet_uid, $wallet_pin]);
			$result = $result !== false ? $result : (object) [];

			if(!isset($result->id) || $result->id == 0){
				$return_obj->message = "El monedero no fue encontrado, verifica los datos e intenta nuevamente.";
			} else {
				$exists = $this->FetchAllObject("DELETE FROM `{$this->getPrefix()}purses` WHERE `wallet` IN (?) AND `user_id` IN (?)", [$result->id, $user_id]);

				if($exists == true){
					$return_obj->error = false;
					$return_obj->message = "Limpieza realizada con éxito.";
				} else {
					$return_obj->message = "Se detectaron errores, valide manualmente para evitar malos entendidos.";
				}
			}

			return $return_obj;
		}
		catch(Exception $e){
			return (object) [
				"error"=>true,
				"message"=>$e->getMessage(),
			];
		}
	}

	public function exist_wallet_by_puid($puid=0){
		try {
			$sql = "Select * FROM `{$this->getTable()}` WHERE `puid` IN (?) ";
			$result = $this->FetchObject($sql, [$puid]);
			$this->setAll($result);
			return $result !== false && $result->id>0 ? true : false;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	/// aqui
	public function add_history($action,$amount=0){
		try {
			$sql = "INSERT INTO `{$this->getPrefix()}wallets_history`
				(`wallet`, `action`, `amount`, `balance`, `created_by`, `modified_by`)
				VALUES (?, ?, ?, ?, ?, ?)";
      $data_sending = [
				$this->id,
				$action,
				$amount,
				$this->balance,
				(isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null),
				(isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null),
        // ($action == 'add' || $action == 'recharge' || $action == 'transfer__in' || $action == 'gift') ? $this->balance+$amount : (($action == 'subtract' || $action == 'transfer__out') ? $this->balance-$amount : 0)
			];
			$r = $this->FetchObject($sql, $data_sending);
			return $r;
		}
		catch(Exception $e){
			return false;
		}
	}

	public function add_history_system($action,$amount=0){
		try {
			$sql = "INSERT INTO `{$this->getPrefix()}wallets_history`
				(`wallet`, `action`, `amount`, `balance`)
				VALUES (?, ?, ?, ?)";
      $data_sending = [
				$this->id,
				$action,
				$amount,
				$this->balance,
        // ($action == 'add' || $action == 'recharge' || $action == 'transfer__in' || $action == 'gift') ? $this->balance+$amount : (($action == 'subtract' || $action == 'transfer__out') ? $this->balance-$amount : 0)
			];
			$r = $this->FetchObject($sql, $data_sending);
			return $r;
		}
		catch(Exception $e){
			return false;
		}
	}

	public function add_balance($amount=0,$history='add'){
		try {
			if(($this->balance + $amount)>0){
				$sql = "UPDATE `{$this->getTable()}` SET `balance`=?, `modified_by`=? WHERE `puid`=?";
				$r = $this->FetchObject($sql, [($this->balance + $amount), (isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null), $this->puid]);
				if($r!==false){
					$this->add_history($history, $amount);
				}
				return $r;
			}
			return false;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function add_balance_recharge($amount=0,$history='recharge'){
		try {
			if(($this->balance + $amount)>0){
				$sql = "UPDATE `{$this->getTable()}` SET `balance`=?, `modified_by`=? WHERE `puid`=?";
				$r = $this->FetchObject($sql, [($this->balance + $amount), (isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null), $this->puid]);
				if($r!==false){
					$this->add_history_system($history, $amount);
				}
				return $r;
			}
			return false;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function subtract_balance($amount=0,$history='subtract'){
		try {
			if(($this->balance - $amount)>0){
				$sql = "UPDATE `{$this->getTable()}` SET `balance`=? WHERE `puid`=?";
				$r = $this->FetchObject($sql, [($this->balance - $amount), $this->puid]);
				if($r!==false){
					$this->add_history($history, $amount);
				}
				return $r;
			}
			return false;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function clear_balance(){
		try {
			if($this->balance>0){
				$sql = "UPDATE `{$this->getTable()}` SET `balance`=? WHERE `puid`=?";
				$r = $this->FetchObject($sql, [0, $this->puid]);
				if($r!==false){
					$this->add_history('clearing');
				}
				return $r;
			}
			return false;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function locked(){
		try {
			$sql = "UPDATE `{$this->getTable()}` SET `status`=? WHERE `puid`=?";
			return $this->FetchObject($sql, ['locked', $this->puid]);
			return false;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function actived(){
		try {
			$sql = "UPDATE `{$this->getTable()}` SET `status`=? WHERE `puid`=?";
			return $this->FetchObject($sql, ['active', $this->puid]);
			return false;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function losted(){
		try {
			$sql = "UPDATE `{$this->getTable()}` SET `status`=? WHERE `puid`=?";
			return $this->FetchObject($sql, ['lost', $this->puid]);
			return false;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function renameWallet($userid, $alias){
		try {
			$sql = "UPDATE `{$this->getPrefix()}purses` SET `alias`=? WHERE `wallet`=? AND `user_id`=?";
			return $this->FetchObject($sql, [$alias, $this->id, $userid]);
			return false;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function search_by_uid($uid=0){
		try {
			$sql = "SELECT W.*, UW.*
				FROM `{$this->getTable()}` W
				INNER JOIN `{$this->getPrefix()}purses` UW
				ON UW.wallet = W.id
				WHERE `uid` IN (?)";
			$result = $this->FetchObject($sql, [$uid]);
			$result = $result !== false ? $result : (object) [];
			if(isset($result->id)){
				$memberships = new Memberships();
				$result->membership = $memberships->load_last_plan_user_by_id($result->user);
			}
			// $this->setAll($result);
			// $this->load_membership();
			return $result;
		}
		catch(Exception $e){
			return "Ocurrio un error consultado la informacion.";
		}
	}

	public function load_membership(){
		//$model->get_wallets_by_user
	}
}
