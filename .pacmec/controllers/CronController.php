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

class CronController extends \PACMEC\ControladorBase {
	public $error   = true;
	public $message = null;
	public $time    = null;

	public function __construct() {
      parent::__construct();
			header('Content-Type: application/json');
			$time = time();
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

  public function checkAffiliates(){
		$model_affiliates = new \PACMEC\Affiliates();
		$listAutoPays = $model_affiliates->getByExpirePrevDayAutoPayment();
		$listForExpire = $model_affiliates->getByExpirePrevDay();
		foreach ($listForExpire as $item) { $model_affiliates->expireAffiliate($item->id); }
		$paysArray = [];
		foreach ($listAutoPays as $item) {
			$membership = $model_affiliates->getMembershipById($item->membership);
			$model_affiliates_item = new \PACMEC\Affiliates();
			$model_affiliates_item->user_id = $item->user_id;
			$model_affiliates_item->membership = $membership->id;
			$model_affiliates_item->max_members = $membership->max_members;
			$model_affiliates_item->cycle_period = $membership->cycle_period;
			$model_affiliates_item->cycle_number = $membership->cycle_number;
			$model_affiliates_item->initial_payment = (double) $membership->initial_payment;
			$model_affiliates_item->billing_amount = (double) $membership->billing_amount;
			$model_affiliates_item->startdate = $item->enddate;
			$model_affiliates_item->status = "renewing";
			switch ($membership->cycle_period) {
				case 'Day':
					$model_affiliates_item->enddate = date('Y-m-d H:i:s', strtotime($model_affiliates_item->startdate . ' +'.$membership->cycle_number.' day'));
					break;
				case 'Week':
					$model_affiliates_item->enddate = date('Y-m-d H:i:s', strtotime($model_affiliates_item->startdate . ' +'.$membership->cycle_number.' week'));
					break;
				case 'Month':
					$model_affiliates_item->enddate = date('Y-m-d H:i:s', strtotime($model_affiliates_item->startdate . ' +'.$membership->cycle_number.' month'));
					break;
				case 'Year':
					$model_affiliates_item->enddate = date('Y-m-d H:i:s', strtotime($model_affiliates_item->startdate . ' +'.$membership->cycle_number.' year'));
					break;
				default:
					break;
			}
			$model_affiliates_item->code_id = \randString(11);
			$model_affiliates_item->create();
			if($model_affiliates_item->id>0){
				$pay = (object) [
					"amount_in_cents" => ($model_affiliates_item->billing_amount*100),
					"currency" => WCO_CURRENCY,
					"customer_email" => $item->holder_email,
					"reference" => base64_encode(base64_encode("affiliates") . "." . base64_encode($model_affiliates_item->code_id)),
					"payment_source_id" => $item->source_id,
				];
				if($item->type == 'CARD') $pay->payment_method = (object) ["installments" => 1];
				// Enviar transaction
				$ch = curl_init("https://".WCO_MODE.".wompi.co/".WCO_VERS."/transactions");
				$payload = json_encode($pay);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
				curl_setopt($ch, CURLOPT_HTTPHEADER, [
					'accept: */*',
					'Authorization: Bearer '.WCO_KEY_PRV,
					'Content-Type:application/json',
				]);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);
				$result_transaction = json_decode($result);
				if(isset($result_transaction->data)){
					$model_affiliates_item->status = strtolower($result_transaction->data->status);
					$model_affiliates_item->update();
				}
			}
		}
		$this->error = false;
		echo json_encode($this);
		return json_encode($this);
  }

  public function automaticPayments(){
		$payments_end_today = new Affiliates();
		//enddate
		$this->error = $payments_end_today;

		echo json_encode($this);
		return json_encode($this);
  }

}
