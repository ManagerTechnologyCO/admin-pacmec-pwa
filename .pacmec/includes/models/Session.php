<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    PACMEC
 * @category   Session
 * @copyright  2020-2021 Manager Technology CO
 * @license    license.txt
 * @version    Release: @package_version@
 * @link       http://github.com/ManagerTechnologyCO/PACMEC
 * @version    1.0.1
 */

namespace PACMEC;

Class Session
{
	#public  $isGuest          = true;
	public  $user               = null;
	public  $payment            = null;
	public  $payments           = [];
	public  $permission_group   = null;
	public  $permissions_items  = [];
	public  $permissions        = [];
	public  $notifications      = [];
	public  $purses_to_send      = [];

	/**
	* Inicializa la sesión
	*/
	public function __construct()
	{
		if ( $this->is_session_started() === FALSE ) @session_start();
		$this->user             = new \stdClass();
		$this->permission_group = new \stdClass();
		$this->refreshSession();
	}

	public function add_alert(string $message, string $title=null, string $url=null, int $time=null, string $uniqid=null, string $icon=null)
	{
		$time = $time==null ? time() : $time;
		$uniqid = $uniqid==null ? uniqid() : $uniqid;
		$icon = $icon==null ? "fas fa-bell" : $icon;
		$url = $url==null ? "#" : $url;
		$title = $title==null ? "Nueva notificacion" : $title;
		$date = date('Y-m-d H:i:s', $time);

		$alert = [
			"title"=>$title,
			"message"=>$message,
			"time"=>$time,
			"uniqid"=>$uniqid,
			"date"=>$date,
			"url"=>$url,
			"icon"=>$icon,
		];

		if(!isset($this->notifications[$uniqid])){
			$this->set($uniqid, $alert, 'notifications');
			// $this->notifications[$uniqid] = $_SESSION['notifications'][$uniqid] = $alert;
		};
	}

	public function add_permission(string $tag, $obj=null):bool
	{
		$tag = strtolower($tag);
		if($obj !== null){
			$obj = (object) $obj;
		} else {
			$obj = (object) [
				"id"=>999999999999999999999999,
				"tag"=>$tag,
				"name"=>$tag,
				"description"=>$tag,
			];
		}
		if(!isset($this->permissions_items[$tag])){
			$this->permissions_items[$tag] = $_SESSION['permissions_items'][$tag] = $obj;
		}
		if(isset($_SESSION['permissions'])&&!in_array($tag, $_SESSION['permissions'])) $this->permissions[] = $_SESSION['permissions'][] = $tag;
		return true;
	}

	public function set($k, $v, $l=null)
	{
		if($l == null){
			$this->{$k} = $_SESSION[$k] = $v;
		} else {
			if(is_array($this->{$l})){
				$this->{$l}[$k] = $_SESSION[$l][$k] = $v;
			} else {
				$this->{$l}->{$k} = $_SESSION[$l][$k] = $v;
			}
		}
	}

	public function is_session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) { return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE; }
			else { return session_id() === '' ? FALSE : TRUE; }
		}
		return FALSE;
	}

	public function refreshSession()
	{
		if(isUser()){
			try {
				if(isset($_SESSION['user'])){
					$this->setAll($_SESSION);
				}
			}
			catch(Exception $e){
				echo $e->getMessage();
				exit();
			}
		}
	}

	public function setAll($session = [])
	{
		$session = (array) $session;
		foreach($session as $item => $valor){
			switch($item){
				case "user":
				case "permission_group":
					$valor = (object) $valor;
					break;
				case "permissions_items" || "permissions" || "notifications":
					$valor = (array) $valor;
					break;
				default:
					$valor = (is_object($valor)) ? (object) $valor : $valor;
					break;
			}
			$this->{$item} = (($valor));
		}

		$payment = $GLOBALS['PACMEC']['DB']->FetchObject("SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}wompi_tokens` WHERE `token_status` IN ('CREATED', 'PENDING', 'APPROVED') AND `source_status` IN ('AVAILABLE') AND `user_id` IN (?) ORDER BY `created` DESC", [$this->user->id]);
		$this->payment = $payment!==false ? $payment : null;

		$payments = $GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}wompi_tokens` WHERE `user_id` IN (?)", [$this->user->id]);
		$this->payments = $payments!==false ? $payments : [];

		$purses_to_send = $GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}purses_to_send` WHERE `user_id` IN (?) AND `status` IN ('review','on_way')", [$this->user->id]);
		$this->purses_to_send = $purses_to_send!==false ? $purses_to_send : [];

		if(isset($this->user->permissions) && $this->user->permissions !== null && $this->user->permissions > 0 && count($this->permissions)==0){
			try {
				$sql = "SELECT E.*
					FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}permissions` D
					JOIN `{$GLOBALS['PACMEC']['DB']->getPrefix()}permissions_items` E
					ON E.`id` = D.`permission`
					WHERE D.`group` IN (?)";
				$result = $GLOBALS['PACMEC']['DB']->FetchAllObject($sql, [$this->user->permissions]);

				if($result !== false && count($result) > 0){
					foreach($result as $perm){
						$this->add_permission($perm->tag, $perm);
						#$this->permissions_items[$perm->tag] = $perm;
						#$this->permissions[] = strtolower($perm->tag);
					}
				}

				$sql = "SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}permissions_group` WHERE `id` IN (?)";
				$result = $GLOBALS['PACMEC']['DB']->FetchObject($sql, [$this->user->permissions]);
				if($result !== false){
					$this->permission_group = $result;
				}
			}
			catch(Exception $e){
				#echo $e->getMessage();
			}
		}

	}

	public function isGuest()
	{
		return isset($_SESSION['user']) && is_array($_SESSION['user']) ? false : true;
	}

	public function userId()
	{
		return isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;
	}

	public function getBy($key)
	{
		return isset($_SESSION['user']) ? $this->{$key} : null;
	}

	public function getUserBy($key)
	{
		#$this->refreshSession();
		return isset($_SESSION['user']) ? $this->user->{$key} : null;
	}

	/**
	* Retorna todos los valores del array de sesión
	* @return el array de sesión completo
	*/
	public function getAll()
	{
		#$this->refreshSession();
		return isset($_SESSION['user']) ? $this : [];
	}

	/**
	* Cierra la sesión eliminando los valores
	*/
	public function close()
	{
		session_unset();
		session_destroy();
	}

	/**
	* Retorna el estatus de la sesión
	* @return string el estatus de la sesión
	*/
	public function getStatus()
	{
		switch(session_status())
		{
			case 0:
				return "DISABLED";
				break;
			case 1:
				return "NONE";
				break;
			case 2:
				return "ACTIVE";
				break;
		}
	}

	/**
	* Retorna string default
	* @return string
	*/
	public function __toString()
	{
		return json_encode($this->getAll());
	}

	/**
	* Retorna array default
	* @return string
	*/
	public function __sleep()
	{
		return array_keys($this->getAll());
	}

	public function getUserId()
	{
		return !isset($_SESSION['user']['id']) ? 0 : $_SESSION['user']['id'];
	}

	public function login($args = [])
	{
		$args = (object) $args;
		if(isset($args->nick) && isset($args->hash)){
			$result = $this->validateUserDB($args->nick);
			switch($result){
				case "error":
				case "no_exist":
				case "inactive":
					return $result;
					break;
				case $result->id > 0:
					if (password_verify($args->hash, $result->password) == true) {
						$this->setAll($result);
						return "success";
					} else {
						return "invalid_credentials";
					}
					break;
				default:
					return "error";
					break;
			}
		}
	}

	public function validateUserDB($nick_or_email='')
	{
		try {
			$sql = "SELECT * FROM `{$this->pacmecDB->prefix}users` WHERE `username`=? AND `status` IN (1) ";
			$sql = "SELECT * FROM `{$this->pacmecDB->prefix}users` WHERE `username`=? ";
			$query = $this->pacmecDB->adapter->prepare($sql);
			$query->execute([$nick_or_email]);
			$result = $query->fetch(\PDO::FETCH_OBJ);
			if($result == false){
				$sql = "SELECT * FROM `{$this->pacmecDB->prefix}users` WHERE `email`=? AND `status` IN (1) ";
				$sql = "SELECT * FROM `{$this->pacmecDB->prefix}users` WHERE `email`=? ";
				$query = $this->pacmecDB->adapter->prepare($sql);
				$query->execute([$nick_or_email]);
				$result = $query->fetch(\PDO::FETCH_OBJ);
			}
			if(isset($result->id)){
				if($result->status == 0){
					return "inactive";
				}
				return $result;
			}
			return "no_exist";
		}
		catch(Exception $e){
			#echo $e->getMessage();
			return "error";
		}
	}

	public function save($info_save)
	{
		try {
			$user_id = $this->getUserId();
			$labels = [];
			$values = [];
			foreach ($info_save as $key => $value) {
				$labels[] = "{$key}=?";
				$values[] = $value;
			}
			$result = $GLOBALS['PACMEC']['DB']->FetchObject("UPDATE IGNORE `users` SET ".implode(',', $labels)." WHERE `id`={$user_id}", $values);
			if($result==true) {
				foreach ($info_save as $key => $value) {
					$_SESSION['user'][$key] = $value;
				}
			};
			return $result;
		}
		catch(Exception $e){
			#echo $e->getMessage();
			return false;
		}
	}
}
