<?php
/**
 * Plugin Name: Club
 * Plugin URI: https://managertechnology.com.co/
 * Description: -*-*-*-*-*--*-*-*-*
 * Version: 0.1
 * Author: FelipheGomez
 * Author URI: https://github.com/FelipheGomez/PACMEC-Hello
 * Text Domain: club
 * Copyright 2020-2021	Manager Technology Colombia
 */
function cmrfid_init(){
	$session = meinfo();
	$memberships = new \PACMEC\Memberships();
	if(isset($session->user->id) && $session->user->id > 0){
		$membership = $memberships->load_last_plan_user_by_id($session->user->id);
		$session->set('membership', $membership);
		$session->set('beneficiaries', $membership->beneficiaries);
		$session->set('balance_total', $membership->balance_total);
		$wallets = $memberships->get_wallets_by_user($session->user->id);
		$session->set('wallets', $wallets);
		if($membership->id > 0){
			$session->add_permission('membership_plan_active');
		}
	}
	add_action('head-scripts', function(){
		echo '

		';
	});
}
add_action('init', 'cmrfid_init');

function isMember(){
  return (isset($_SESSION['membership']->id) && $_SESSION['membership']->id>0) ? true : false;
}

function meMembership(){
  return (isset($_SESSION['membership']->id) && $_SESSION['membership']->id>0) ? $_SESSION['membership'] : null;
}

if(isset($_REQUEST['cmrfid']) && $_REQUEST['cmrfid'] == 'functions' && isset($_REQUEST['action'])){
	$session = meinfo();
	header('Content-Type: application/json');
	if(isset($session->user->id) && $session->user->id > 0){
		$wallets = [];
		foreach($session->wallets as $wallet){
			$wallets[] = $wallet;
		}
		if($_REQUEST['action'] == 'add-wallet'){
			if(!isset($_REQUEST['user'])) $_REQUEST['user'] = $session->user->id;
			if(isset($_REQUEST['wallet_uid']) && isset($_REQUEST['wallet_pin'])){
				$modal_wallet = new \PACMEC\Wallet();
				$result = $modal_wallet->add_in_user_by_uid_and_pin($_REQUEST['wallet_uid'], $_REQUEST['wallet_pin'], $_REQUEST['user']);

				exit(json_encode($result));
			}
		}
		else if($_REQUEST['action'] == 'my-wallets'){
			exit(json_encode($session->membership->wallets));
		}
		else if($_REQUEST['action'] == 'exchange-wallet-to-wallet'){
			// exit(json_encode($session->membership->wallets));
			$result = (object) [
				"error" => true,
				"message" => "Ocurrio un error.",
			];

			if(isset($_REQUEST['wallet_from']) && isset($_REQUEST['wallet_pin']) && isset($_REQUEST['wallet_to']) && isset($_REQUEST['amount'])){
				if($_REQUEST['wallet_from'] !== $_REQUEST['wallet_to']){
					$wallet_from = new \PACMEC\Wallet();
					$wallet_from->get_by_puid_and_pin($_REQUEST['wallet_from'], $_REQUEST['wallet_pin']);
					if($wallet_from->id > 0){
						if((float) $wallet_from->balance >= (float) $_REQUEST['amount']){
							$wallet_to = new \PACMEC\Wallet();
							$wallet_to->exist_wallet_by_puid($_REQUEST['wallet_to']);
							if($wallet_to->id>0){
								$r_from = $wallet_from->subtract_balance((float) $_REQUEST['amount']);
								$r_to = $wallet_to->add_balance((float) $_REQUEST['amount']);
								if($r_from == true && $r_to == true){
									$result->message = "Transaccion éxitosa!.";
									$result->error = false;
								} else {
									$result->message = "Ocurrio un problema en la transaccion confirma tu saldo antes de intentar nuevamente.";
								}
							} else {
								$result->message = "El monedero de destino no existe. " . json_encode($wallet_to);
							}
						} else {
							$result->message = "Saldo insuficiente para realizar la transaccion.";
						}
					} else {
						$result->message = "Monedero de origen no encontrado.";
					}
				} else {
					$result->message = "No puedes transferir al mismo monedero, intenta nuevamente.";
				}
			} else {
				$result->message = "Datos incompletos.";
			}
			exit(json_encode($result));
		}
		else if($_REQUEST['action'] == 'locked-wallet'){
			$result = (object) [
				"error" => true,
				"message" => ".",
			];
			if(isset($_REQUEST['wallet']) && isset($_REQUEST['pin'])){
				$wallet_from = new \PACMEC\Wallet();
				$wallet_from->get_by_puid_and_pin($_REQUEST['wallet'], $_REQUEST['pin']);
				if($wallet_from->id > 0){
					if ($wallet_from->status == 'active') {
						$locked = $wallet_from->locked();
						$result->error = !$locked;
						$result->message = $locked==true?"Monedero bloqueado":"Error al tratar de bloquear el monedero.";
					}
					else if ($wallet_from->status == 'locked') {
						$result->message = "El monedero ya se encuentra bloqueado.";
					}
					else {
						$result->message = "El monedero no se puede bloquear.";
					}
				} else {
					$result->message = ("waller_not_found");
				}
			}
			else {
				$result->message = "Datos incompletos.";
			}
			exit(json_encode($result));
		}
		else if($_REQUEST['action'] == 'actived-wallet'){
			$result = (object) [
				"error" => true,
				"message" => ".",
			];
			if(isset($_REQUEST['wallet']) && isset($_REQUEST['pin'])){
				$wallet_from = new \PACMEC\Wallet();
				$wallet_from->get_by_puid_and_pin($_REQUEST['wallet'], $_REQUEST['pin']);
				if($wallet_from->id > 0){
					if ($wallet_from->status == 'active') {
						$result->message = "El monedero ya se encuentra activo.";
					}
					else {
						$actived = $wallet_from->actived();
						$result->error = !$actived;
						$result->message = $actived==true?"Monedero activado":"Error al tratar de activar el monedero.";
					}
				} else {
					$result->message = "Acceso denegado.";
				}
			}
			else {
				$result->message = "Datos incompletos.";
			}
			exit(json_encode($result));
		}
		else if($_REQUEST['action'] == 'losted-wallet'){
			$result = (object) [
				"error" => true,
				"message" => ".",
			];
			if(isset($_REQUEST['wallet']) && isset($_REQUEST['pin'])){
				$wallet_from = new \PACMEC\Wallet();
				$wallet_from->get_by_puid_and_pin($_REQUEST['wallet'], $_REQUEST['pin']);
				if($wallet_from->id > 0){
					if ($wallet_from->status == 'lost') {
						$result->message = "El monedero ya se encuentra reportado.";
					}
					else {
						$actived = $wallet_from->losted();
						$result->error = !$actived;
						$result->message = $actived==true?"Monedero reportado":"Error al tratar de reportar el monedero.";
					}
				} else {
					$result->message = "Acceso denegado.";
				}
			}
			else {
				$result->message = "Datos incompletos.";
			}
			exit(json_encode($result));
		}
		else if($_REQUEST['action'] == 'rename-wallet'){
			$result = (object) [
				"error" => true,
				"message" => ".",
			];
			if(isset($_REQUEST['wallet']) && isset($_REQUEST['pin']) && isset($_REQUEST['name'])){
				$wallet_from = new \PACMEC\Wallet();
				$wallet_from->get_by_puid_and_pin($_REQUEST['wallet'], $_REQUEST['pin']);
				if($wallet_from->id > 0){
					$updated = $wallet_from->renameWallet($session->user->id, $_REQUEST['name']);
					$result->error = !$updated;
					$result->message = $updated==true?"Modificado con éxito.":"Error al tratar de modificar.";
				} else {
					$result->message = "Acceso denegado.";
				}
			}
			else {
				$result->message = "Datos incompletos.";
			}
			exit(json_encode($result));
		}
		else if($_REQUEST['action'] == 'options-identifications_types'){
			$model = new CMRFID_IdentificationsTypes();
			$result = $model->get_all();

			exit(json_encode($result, JSON_PRETTY_PRINT));
		}
		else if($_REQUEST['action'] == 'options-emergency_entities'){
			$model = new CMRFID_EmergencyEntities();
			$result = $model->get_all();

			exit(json_encode($result, JSON_PRETTY_PRINT));
		}
		else if($_REQUEST['action'] == 'create-beneficiarys'){
			exit(json_encode("OK", JSON_PRETTY_PRINT));
		}
		else if($_REQUEST['action'] == 'check-wallet'){
			// exit(json_encode("OK", JSON_PRETTY_PRINT));
			$result = (object) [
				"error" => true,
				"message" => ".",
				"wallet" => null,
			];
			if(!isset($_REQUEST['tag_id']) || empty($_REQUEST['tag_id'])){
				$result->message = "Monedero invalido.";
			} else {
				$modal_wallet2 = new \PACMEC\Wallet();
				$result->wallet = $modal_wallet2->search_by_uid($_REQUEST['tag_id']);
				if(isset($result->wallet->id)&& $result->wallet->id>0){
					$result->message = "Cargado con éxito.";
				} else {
					$result->message = ("waller_not_found");
				}
			}

			exit(json_encode($result, JSON_PRETTY_PRINT));
		}
		else if($_REQUEST['action'] == 'add-balance-wallet'){
			$result = (object) [
				"error" => true,
				"message" => ".",
			];

			if(
				!isset($_REQUEST['amount']) || empty($_REQUEST['amount'])
				&& !isset($_REQUEST['uid']) || empty($_REQUEST['uid'])
				&& !isset($_REQUEST['pin']) || empty($_REQUEST['pin'])
			){
				$result->message = "Datos invalidos.";
			} else {
				$modal_wallet2 = new \PACMEC\Wallet();
				$result->wallet = $modal_wallet2->get_by_uid_and_pin($_REQUEST['uid'], $_REQUEST['pin']);
				if(isset($result->wallet->id)&& $result->wallet->id>0){
					$result_add = $modal_wallet2->add_balance($_REQUEST['amount']);
					$result->error = $result_add!==false?false:true;
					$result->message = $result_add!==false?"Agregado con éxito ({$_REQUEST['amount']}) .":"Ocurrio un error intente nuevamente.";
				} else {
					$result->message = ("waller_not_found");
				}
			}
			exit(json_encode($result, JSON_PRETTY_PRINT));
		}
		else if($_REQUEST['action'] == 'check-membership-wallet'){
			// exit(json_encode("OK", JSON_PRETTY_PRINT));
			$result = (object) [
				"error" => true,
				"message" => "",
				"wallet" => null,
				"membership" => null,
				"user" => null,
			];
			if(!isset($_REQUEST['tag_id']) || empty($_REQUEST['tag_id'])){
				$result->message = "Monedero invalido.";
			} else {
				try {
					$wallet = $GLOBALS['PACMEC']['DB']->FetchObject("SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}wallets` WHERE `uid` IN (?)", [$_REQUEST['tag_id']]);

					if(isset($wallet->id)){
						$result->wallet = $wallet;

						$wallet_user = $GLOBALS['PACMEC']['DB']->FetchObject("SELECT *
							FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}purses`
							WHERE `wallet` IN (?)", [$wallet->id]);

						if(isset($wallet_user->user_id)){
							$user = $GLOBALS['PACMEC']['DB']->FetchObject("SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}users` WHERE `id` IN (?)", [$wallet_user->user_id]);
							if($user !== false){
								$result->user = $user;
								$memberships = new CMRFID_Memberships();
								$result->membership = $memberships->load_last_plan_user_by_id($user->id);
							}
						}
					}

					$result->error = false;
					$result->message = "Informacion cargada con exito.";
				}
				catch(Exception $e){
					$result->message = "Ocurrio un error consultado la informacion.";
				}
			}

			exit(json_encode($result, JSON_PRETTY_PRINT));
		}


		/* ---- FINAL ---- */
		else if($_REQUEST['action'] == 'tag-info'){
			if(!isset($_REQUEST['includes'])) $_REQUEST['includes'] = 'wallet';
			$includes_array = explode(',', $_REQUEST['includes']);
			if(!isset($_REQUEST['tag_id']) || empty($_REQUEST['tag_id'])) $_REQUEST['tag_id'] = '';
			$result = (object) [
				"error" => true,
				"message" => "",
				"includes" => $includes_array,
				"tag_id" => $_REQUEST['tag_id'],
			];
			foreach($includes_array as $a){ $result->{$a} = null; }
			if(empty($result->tag_id)){
				$result->message = "Monedero invalido.";
			} else {
				try {
					$wallet = $GLOBALS['PACMEC']['DB']->FetchObject("SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}wallets` WHERE `uid` IN (?)", [$result->tag_id]);
					if(isset($wallet->id)){
						$wallet->user_id = null;
						$wallet_user = $GLOBALS['PACMEC']['DB']->FetchObject("SELECT *
							FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}purses`
							WHERE `wallet` IN (?)", [$wallet->id]);
						// if(in_array('wallet', $result->includes)) $result->wallet = $wallet_user;  // Agregar info de la wallet al resultado
						if(isset($wallet_user->user_id)){
							$wallet->user_id = $wallet_user->user_id;
							$user = $GLOBALS['PACMEC']['DB']->FetchObject("SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}users` WHERE `id` IN (?)", [$wallet_user->user_id]);
							if($user !== false){
								if(in_array('user', $result->includes)) $result->user = $user;

								$memberships = new \PACMEC\Memberships();
								$membership = $memberships->load_last_plan_user_by_id($user->id);
								if(in_array('membership', $result->includes)) $result->membership = $membership;
							}
						}
						if(in_array('wallet_history', $result->includes)) $result->wallet_history = $GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}wallets_history` WHERE `wallet` IN (?)", [$wallet->id]);

						if(in_array('wallets', $result->includes) && isset($wallet_user->user_id) && !empty($wallet_user->user_id)) $result->wallets = $GLOBALS['PACMEC']['DB']->FetchAllObject("SELECT W.*, P.`alias`, P.`user_id`
							FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}purses` P
							INNER JOIN `{$GLOBALS['PACMEC']['DB']->getPrefix()}wallets` W
							ON W.`id` = P.`wallet`
							WHERE P.`user_id` IN (?)", [$wallet_user->user_id]);
						$result->error = false;
						$result->message = "Informacion cargada con exito.";
					} else {
						$result->message = ("waller_not_found");
					}
					if(in_array('wallet', $result->includes)) $result->wallet = $wallet;  // Agregar info de la wallet al resultado
				}
				catch(Exception $e){
					$result->message = "Ocurrio un error consultado la informacion.";
				}
			}
			exit(json_encode($result, JSON_PRETTY_PRINT));
		}
		else if($_REQUEST['action'] == 'wallet-actions'){
			if(!isset($_REQUEST['action_wallet'])) $_REQUEST['action_wallet'] = '';
			$result = (object) [
				"error" => true,
				"message" => "",
			];

			if(
				!isset($_REQUEST['action_wallet']) || empty($_REQUEST['action_wallet'])
				&& !isset($_REQUEST['amount']) || empty($_REQUEST['amount'])
				&& !isset($_REQUEST['uid']) || empty($_REQUEST['uid'])
				&& !isset($_REQUEST['pin']) || empty($_REQUEST['pin'])
			){
				$result->message = "Datos invalidos.";
			} else {
				$modal_wallet2 = new \PACMEC\Wallet();
				$result->wallet = $modal_wallet2->get_by_uid_and_pin($_REQUEST['uid'], $_REQUEST['pin']);
				if(isset($result->wallet->id)&& $result->wallet->id>0){

					if($_REQUEST['action_wallet'] == 'add'){
						$result_r = $modal_wallet2->add_balance((float) $_REQUEST['amount']);
					} else if($_REQUEST['action_wallet'] == 'subtract'){
						$result_r = $modal_wallet2->subtract_balance((float) $_REQUEST['amount']);
					} else if($_REQUEST['action_wallet'] == 'clearing'){
						$result_r = $modal_wallet2->clear_balance();
					}

					if(isset($result_r)){
						$result->error = $result_r!==false?false:true;
						$result->message = $result_r!==false?"Agregado con éxito ({$_REQUEST['amount']}) .":"Ocurrio un error intente nuevamente.";
					} else {
						$result->message = "Ups, Ocurrio un error intente nuevamente.";
					}
				} else {
					$result->message = ("waller_not_found");
				}
			}
			exit(json_encode($result, JSON_PRETTY_PRINT));
		}
		else if($_REQUEST['action'] == 'add-membership'){
			if(!isset($_REQUEST['membership'])) $_REQUEST['membership'] = 0;
			if(!isset($_REQUEST['user'])) $_REQUEST['user'] = 0;
			$result = (object) [
				"error" => true,
				"message" => "",
				"membership" => $_REQUEST['membership'],
				"user" => $_REQUEST['user'],
			];

			if($result->user > 0 && $result->membership > 0) {
				$modal_membership = new \PACMEC\Memberships();
				$membership = $modal_membership->load_last_plan_user_by_id($result->user);
				if($membership->id == null){
					$r = $modal_membership->add_membership($result->user, $result->membership);
					if(is_numeric($r) && $r > 0) {
						$result->error = false;
						$result->message = "Membresía agreganda con exito";
					} else {
						$result->message = "Ocurrio un error agregando la membresía, valida que se encuentre activa al igual que: el monedero y el usuario.";
					};
				} else {
					$result->message = "El usuario ya cuenta con una membresía.";
				}
				#$result->membership = $membership;
				// $result = $modal_membership->add_membership($_REQUEST['user'], );
			} else {
				$result->message = "Datos invalidos.";
			}

			exit(json_encode($result));
		}
		else if($_REQUEST['action'] == 'expired-membership'){
			if(!isset($_REQUEST['user'])) $_REQUEST['user'] = 0;
			$result = (object) [
				"error" => true,
				"message" => "",
				"user" => $_REQUEST['user'],
			];

			if($result->user > 0) {
				$modal_membership = new \PACMEC\Memberships();
				$membership = $modal_membership->load_last_plan_user_by_id($result->user);
				if($membership->id == null){
					$result->message = "El usuario no cuenta con una membresía activa.";
				} else {

					$r = $modal_membership->expired_membership($membership->id);

					if($r!==false){
						$result->message = "La membresía cerrada con éxito.";
					} else {
						$result->message = "Ocurrio un error al cerrar la membresía.";
					}
					/*
					$r = $modal_membership->add_membership($result->user, $result->membership);
					if(is_numeric($r) && $r > 0) {
						$result->error = false;
						$result->message = "Membresía agreganda con exito";
					} else {
						$result->message = "Ocurrio un error agregando la membresía, valida que se encuentre activa al igual que: el monedero y el usuario.";
					};*/
				}
				#$result->membership = $membership;
				// $result = $modal_membership->add_membership($_REQUEST['user'], );
			} else {
				$result->message = "Datos invalidos.";
			}

			exit(json_encode($result));
		}
		else if($_REQUEST['action'] == 'clearing-user'){
			if(isset($_REQUEST['wallet_uid']) && isset($_REQUEST['wallet_pin']) && isset($_REQUEST['user'])){
				$modal_wallet = new \PACMEC\Wallet();
				$result = $modal_wallet->clear_users_by_uid_and_pin($_REQUEST['wallet_uid'], $_REQUEST['wallet_pin'], $_REQUEST['user']);
				exit(json_encode($result));
			}
		}
		else {
			echo json_encode((object) [
				"error" => true,
				"message" => ".",
			]);
		}
	} else {
		echo "Sesion no encontrada.";
		echo json_encode($session);
	}
	exit;
}
