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
class PaymentEventsController extends \PACMEC\ControladorBase {
	public $error         = true;
	public $message       = "";
	public $error_details = null;

	public function __construct() {
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

  public function index(){
		echo json_encode($this);
		return json_encode($this);
  }

	public function WompiCreateAffiliate(){
    $data = array_merge($_GET, $_POST);
		if(!isset($data['user_id']) && isset($_SESSION['user']['id'])) $data['user_id'] = $_SESSION['user']['id'];
		if(isset($data['membership']) && $data['user_id'] > 0){
			if(meMembership()){
				$this->setError(_autoT('request_invalid'));
			} else {
				$model_affiliates = new \PACMEC\Affiliates();
				$model_memberships = $model_affiliates->load_signup_plan($data['membership']);
				if($model_affiliates->membership > 0){
					$insert = $model_affiliates->create();
					if($model_affiliates->id > 0){
						$this->setSuccess(
							base64_encode(
								base64_encode('affiliates') . "." . base64_encode($model_affiliates->code_id)
							)
						);
					} else {
						$this->setError(_autoT('membership_faild_create'));
					}
				} else {
					$this->setError(_autoT('membership_invalid'));
				}
			}
		} else {
			$this->setError(_autoT('request_invalid'));
		}
		echo json_encode($this);
		return json_encode($this);
	}

	public function WompiCreateRecharge(){
    $data = array_merge($_GET, $_POST);
		if(!isset($data['user_id']) && isset($_SESSION['user']['id'])) $data['user_id'] = $_SESSION['user']['id'];
		$model_Wallet = new \PACMEC\Wallet();
		if(isset($data['puid']) && isset($data['amount']) && isset($data['user_id'])){
				$model_Wallet->get_by_puid_and_user($data['puid'], $data['user_id']);
				if($model_Wallet->id > 0){
					$model_recharge = new \PACMEC\Recharge();
					$model_recharge->purse_id = $model_Wallet->id;
					$model_recharge->user_id = $data['user_id'];
					$model_recharge->amount = (float) $data['amount'];
					$model_recharge->status = "CREATED";
					$model_recharge->create_ref();
					$model_recharge->create();
					if($model_recharge->id > 0){
						$this->error = false;
						$this->message = "create_recharge_success";
						$this->message = $model_recharge->ref;
					} else {
						$this->message = "create_recharge_fail";
						$this->error_details = $model_recharge;
					}
				} else {
					$this->message = "create_recharge_fail";
				}
		}
		echo json_encode($this);
		return json_encode($this);
	}

	public function cancelTokenWompi(){
    $data = array_merge($_GET, $_POST);
		$this->message = "wco_cancel_token_error";
		if(isset($data['token'])){
			$model_WToken = new \PACMEC\WompiTokens();
			$model_WToken->getById($data['token']);

			if($model_WToken->id > 0 && $model_WToken->user_id == $_SESSION['user']['id']){
				$model_WToken->token_status = 'CANCELED-USER';
				$save = $model_WToken->update();
				$this->error = !($save);
				$this->message = ($save == true) ? _autoT('wco_cancel_token_success') : _autoT('wco_cancel_token_failed');
			}
		}
		echo json_encode($this);
		return json_encode($this);
	}

	public function WompiEvents(){
    $data = array_merge($_GET, $_POST);
		sleep(5);
		$environment = isset($data['environment']) ? $data['environment'] : null;
		$checksum = isset($data['signature']->checksum) ? $data['signature']->checksum : null;
		$properties = isset($data['signature']->properties) ? $data['signature']->properties : null;
		$event = isset($data['event']) ? $data['event'] : null;
		$datas = isset($data['data']) ? $data['data'] : null;
		$timestamp = isset($data['timestamp']) ? $data['timestamp'] : null;

		if($event !== null && $environment !== null && !empty($data)){
			$model = new \PACMEC\WompiSyncHistory();
			$model->environment = $environment;
			$model->event = $event;
			$model->data = $datas;
			$model->sent_at = !isset($data['sent_at']) ? 'no_sent_at' : $data['sent_at'];
			$model->ip = \getIpRemote();
			$model->checksum = $checksum;

			$valid = "";
			foreach ($properties as $i=>$key) {
				$abc = explode('.', $key);
				$valid .= $datas->{$abc[0]}->{$abc[1]};
			}
			$valid = hash("sha256", $valid.$timestamp.WCO_KEY_EVENTS);

			if($valid == $checksum){

				switch ($model->event) {
					case 'nequi_token.updated':
						$model->payment_method_type = "NEQUI";
						$model->status = $datas->nequi_token->status;
						#$model->token_id = $datas->nequi_token->id;
						$model->reference = $datas->nequi_token->phone_number;
						$model->token_id = $datas->nequi_token->id;
						$model_WToken = new \PACMEC\WompiTokens();
						$model_WToken->getBy('token_id', $datas->nequi_token->id);
						$model->token_hash = $datas->nequi_token->id;
						$model->token_id = $model_WToken->id;

						if($model_WToken->id>0){
							$model_WToken->token_status = $datas->nequi_token->status;
							$result_update = $model_WToken->update();
							if($result_update == true) {
								$this->message = "updated.success";
							} else {
								$this->message = "updated.fail";
							};
						}
						break;
					case 'transaction.updated':
						if(isset($datas->transaction->status)){

							$model->transaction_id = $datas->transaction->id;
							$model->amount_in_cents = $datas->transaction->amount_in_cents;
							$model->reference = $datas->transaction->reference;
							$model->currency = $datas->transaction->currency;
							$model->status = $datas->transaction->status;
							$model->payment_method_type = $datas->transaction->payment_method_type;
							// decode reference
							$ref = base64_decode($datas->transaction->reference);
							$ref = explode('.', $ref);
							foreach ($ref as $i => $value) {
								$ref[$i] = base64_decode($value);
							}

							if(isset($ref[0])){
								switch ($ref[0]) {
									case 'recharges':
										// Validar si la ref existe y actualizar estado
										$model_recharge = new \PACMEC\Recharge();
										$model_recharge->getBy('ref', $datas->transaction->reference);
										if(
											$model_recharge->user_id == $ref[1]
												&& $model_recharge->purse_id == $ref[2]
												&& $model_recharge->amount == $ref[3]
										){
											$model_recharge->status = $datas->transaction->status;
											$model_recharge->transaction_id = $model->transaction_id;
											$model_recharge->payment_method_type = $datas->transaction->payment_method_type;
											$model_recharge->amount = ($datas->transaction->amount_in_cents/100);
											if($model_recharge->status == 'APPROVED'){
												// SUMAR SALDO
												$model_Wallet = new \PACMEC\Wallet();
												$model_Wallet->get_by_purseid_and_userid($model_recharge->purse_id, $model_recharge->user_id);
												if($model_Wallet->id>0){
													$model_Wallet->add_balance_recharge($model_recharge->amount);
												}
											}
											$result_upd = $model_recharge->update();
											$this->error = !($result_upd);
											if($result_upd == true){
												$this->message = "recharge_success";
											} else {
												$this->message = "recharge_fail";
											}
										}
										break;
									case 'affiliates':
										$model_affiliate = new \PACMEC\Affiliates();
										$model_affiliate->getBy('code_id', $ref[1]);

										if($model_affiliate->id > 0){
											switch ($datas->transaction->status) {
												case 'PENDING':
												case 'DECLINED':
												case 'VOIDED':
												case 'ERROR':
													$model_affiliate->status = strtolower($datas->transaction->status);
													break;
												case 'APPROVED':
													$model_affiliate->status = "active";
													break;
												default:
													break;
											}
											$result_s = $model_affiliate->update();
											$this->error = !($result_s);
											$this->message = 'successful_renovation';
										} else {
											$this->message = 'affiliate_no_found';
										}
										break;
									default:
										break;
								}
							}
						}
						break;
					default:
						// code...
						break;
				}
			} else {
				$this->setError("Intenta nuevamente y seras reportado por tu conducta.");
			}
			$model->create();
			if($model->id > 0){
				//$this->setSuccess("OK");
			} else {
				$this->setError("wompi_fail");
			}
		}

		echo json_encode($this);
		return json_encode($this);
	}

  public function createTokenWompi(){
		$response = (object) [];
    $data = array_merge($_GET, $_POST);
		$holder_email = isset($data['holder_email']) ? $data['holder_email'] : null;
		$holder_name = isset($data['holder_name']) ? $data['holder_name'] : null;
		$acceptance_token = isset($data['acceptance_token']) ? $data['acceptance_token'] : null;
		$pay_method = isset($data['type']) ? $data['type'] : null;
		$pay_data = isset($data['data']) ? $data['data'] : null;
		$postRequestTokenURI = "https://".WCO_MODE.".wompi.co/".WCO_VERS."/tokens";
		$postRequestPaymentURI = "https://".WCO_MODE.".wompi.co/".WCO_VERS."/payment_sources";
		$postRequestToken = [];
		$model_WToken_f = new \PACMEC\WompiTokens();
		$model_WToken_f->token_status = "CREATING";
		$model_WToken_f->user_id = isset($_SESSION['user']) && isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;
		$model_WToken_f->type = $pay_method;
		$model_WToken_f->holder_name = $holder_name;
		$model_WToken_f->holder_email = $holder_email;
		$model_WToken_f->acceptance_token = $acceptance_token;
		$create_token = false;
		$create_payment_sources = false;
		$create_payment = false;
		if($holder_email !== null && $holder_name !== null && $acceptance_token !== null && $pay_method !== null && $acceptance_token !== null){
			switch ($pay_method) {
				case 'CARD':
					if(
						isset($holder_email)
						&& isset($pay_data->number)
						&& isset($pay_data->exp_month)
						&& isset($pay_data->exp_year)
						&& isset($pay_data->cvc)
					){
						$create_token = true;
						$postRequestTokenURI = $postRequestTokenURI . "/cards";
						$postRequestToken = [
						    'number'                   => $pay_data->number,
						    'exp_month'                   => $pay_data->exp_month,
						    'exp_year'                   => substr($pay_data->exp_year, -2),
						    'cvc'                   => $pay_data->cvc,
						    'card_holder'                   => $holder_name,
						];
					} else {
						$this->message = "data_incomplete";
					}
					break;
				case 'NEQUI':
					if(isset($pay_data->phone_number)){
						$create_token = true;
						$postRequestTokenURI = $postRequestTokenURI . "/nequi";
						$postRequestToken = [
						    'phone_number'                   => $pay_data->phone_number,
						];
					} else {
						$this->message = "data_incomplete";
					}
					break;
				default:
					$this->message = "pay_method_invalid";
					break;
			}
		}
		else {
			$this->message = "data_incomplete";
		}

		if($create_token == true){
			$postRequestTokenResponse = null;
			$ch = curl_init($postRequestTokenURI); // Create a new cURL resource
			$data = $postRequestToken; // Setup request to send json via POST
			$payload = json_encode($data);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Attach encoded JSON string to the POST fields
			// Set the content type to application/json
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'accept: */*',
				'Authorization: Bearer '.WCO_KEY_PUB,
				#'Content-Type: application/json',
				'Content-Type:application/json',
			]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting
			$result = curl_exec($ch); // Execute the POST request
			curl_close($ch); // Close cURL resource
			$result_token = json_decode($result);
			if(isset($result_token->data)){
				$model_WToken_f->data = $result_token->data;
				switch ($pay_method) {
					case 'CARD':
						if(isset($result_token->status)){
							$model_WToken_f->token_status = $result_token->status;
							$model_WToken_f->token_id = $result_token->data->id;
							switch ($result_token->status) {
								case 'CREATED':
									if(isset($result_token->data->id)){
										$create_payment_sources = true;
									}
									break;
								default:
									break;
							}
						}
						break;
					case 'NEQUI':
						if(isset($result_token->data->status)){
							$model_WToken_f->token_status = $result_token->data->status;
							$model_WToken_f->token_id = $result_token->data->id;
							switch ($result_token->data->status) {
								case 'APPROVED':
								case 'PENDING':
									if(isset($result_token->data->id)){
										$create_payment_sources = true;
									}
									break;
								default:
									break;
							}
						}
						break;
					default:
						break;
				}
			}
		}
		else {
			$this->$error_details = $create_token;
		}
		$result_create_token = $model_WToken_f->create();
		if($result_create_token > 0){
				$postRequestPaymentResponse = null;
				$ch = curl_init($postRequestPaymentURI); // Create a new cURL resource
				$postRequestPayment = [
						'type'                  => $model_WToken_f->type,
						'token'                 => $model_WToken_f->token_id,
						'acceptance_token'      => $model_WToken_f->acceptance_token,
						'customer_email'        => $model_WToken_f->holder_email,
				];
				$data = $postRequestPayment; // Setup request to send json via POST
				$payload = json_encode($data);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Attach encoded JSON string to the POST fields
				// Set the content type to application/json
				curl_setopt($ch, CURLOPT_HTTPHEADER, [
					'accept: application/json',
					'Authorization: Bearer '.WCO_KEY_PRV,
					'Content-Type:application/json',
				]);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting
				$result = curl_exec($ch); // Execute the POST request
				curl_close($ch); // Close cURL resource
				$result_payment = json_decode($result);
				if(isset($result_payment->data->status)){
					$model_WToken_f->source_id = $result_payment->data->id;
					$model_WToken_f->source_status = $result_payment->data->status;
				}
				else {
					if(isset($result_payment->message)){
						$model_WToken_f->source_status = $result_payment->message;
						$this->message = $result_payment->message;
						$this->error_details = $result_payment->message;
					} else {
						$this->error_details = $result_payment->error->messages;
						if(isset($result_payment->error->messages)){
							$error1 = '';
							$i = 0;
							foreach ($result_payment->error->messages as $key => $value) {
								if($i==0) {
									$error1 .= $key;
								} else {
									break;
									return;
								}
							}
							$this->message = $error1;
							$model_WToken_f->source_status = $error1;
						} else {
							$this->message = ($result_payment);
						}
					}
				}
				$model_WToken_f->update();
		}
		if($model_WToken_f->source_id > 0 && $model_WToken_f->id > 0){
			$this->error = false;
			$this->message = "wco_add_payment_success";
		}
		else {
			if(empty($this->message)) $this->message = "wco_add_payment_fail";
		}
		echo json_encode($this);
		return json_encode($this);
  }

  public function trackingWompi(){
			$json = file_get_contents('php://input');
			$request = json_decode($json);
			$returner = new stdClass();
			$returner->error = true;
			$returner->message = "";

			$convTransactionTxt = [
				"APPROVED" => "Aprobada",
				"DECLINED" => "Rechadaza",
				"VOIDED" => "Anulada",
				"ERROR" => "Error",
			];

			$convTransactionCod = [
				"APPROVED" => 1,
				"DECLINED" => 5,
				"VOIDED" => 2,
				"ERROR" => 5,
			];

			try {
				if(!isset($request->event)){ throw new Exception('Falta event.'); }
				if(!isset($request->data)){ throw new Exception('Falta data.'); }
				$transaction = (object) $request->data->transaction;

				$model = new WompiConfirmation();
				$model->signature = json_encode($transaction);
				$model->data = json_encode($transaction);
				$model->id_invoice = (int) $transaction->reference;
				$model->ref_payco = $transaction->id;
				$model->amount = (float) $transaction->amount_in_cents / 100;
				$model->currency_code = $transaction->currency;
				$model->transaction_id = $transaction->id;
				$order_status = null;

				switch ($convTransactionCod[$transaction->status]) {
					case 1:
						# code transacción aceptada
						//echo "transacción aceptada";
						$order_status = 2;
						break;
					case 2:
						# code transacción rechazada
						//echo "transacción rechazada";
						$order_status = 3;
						break;
					case 3:
						# code transacción pendiente
						//echo "transacción pendiente";
						$order_status = 4;
						break;
					case 4:
						# code transacción fallida
						//echo "transacción fallida";
						$order_status = 5;
						break;
				}
				$model->cod_response = $order_status;
				$model->cod_respuesta = $order_status;
				$model->response_reason_text = $convTransactionTxt[$transaction->status];
				$model->response = $transaction->status;
				$model->tax = 0;
				$model->business = $transaction->customer_data->full_name;
				$model->amount_ok = (float) $transaction->amount_in_cents / 100;
				$model->bank_name = $transaction->payment_method->type;
				$model->errorcode = 0;
				$model->respuesta = $convTransactionTxt[$transaction->status];
				# $model->cardnumber = ;
				$model->id_factura = $transaction->reference;
				# $model->amount_base = ;
				$model->customer_ip = getUserIpAddr();
				$model->description = $transaction->payment_method_type;
				$model->test_request = TRUE;
				# $model->customer_city = ;
				# $model->customer_name = ;
				# $model->amount_country = ;
				$model->customer_email = $transaction->customer_email;
				$model->customer_movil = $transaction->customer_data->phone_number;
				# $model->customer_phone = ;
				# $model->cust_id_cliente = ;
				$model->customer_address = $transaction->shipping_address;
				# $model->customer_country = ;
				# $model->customer_doctype = ;
				# $model->transaction_date = ;
				# $model->customer_document = ;
				# $model->customer_ind_pais = ;
				# $model->customer_lastname = ;
				$model->fecha_transaccion = $transaction->created_at;
				$model->transaction_state = $transaction->status_message;
				if($order_status !== null){
					$model_order = new Orders($this->adapter);
					$model_order->getById($model->id_invoice);
					if($model_order->id > 0){
						$id = $model->create();
						if($id > 0){
							$model_order->changeStatusPayment($order_status);
							$returner->error = false;
						}
					}
				}
				header('Content-Type: application/json');
				echo json_encode($returner);
			} catch (Exception $e){
				//echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
			echo json_encode($this);
			return json_encode($this);
    }
}
