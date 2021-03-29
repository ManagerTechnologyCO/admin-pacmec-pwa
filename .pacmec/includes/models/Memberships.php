<?php
/**
  * Usuario
  *
  *
  * @package    PACMEC
  * @author     FelipheGomez <feliphegomez@gmail.com>
  *
  **/
namespace PACMEC;

class Memberships extends ModeloBase
{
	private $labels_slugs   = ['access','comfort','benefit','discount'];
	private $cycles_periods = ['Day','Week','Month','Year'];
	private $days_labels    = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
	public $beneficiaries = [];
	public $benefits = [];
	public $balance_total = 0;

  public function __construct($atts=[])
	{
		parent::__construct('memberships', true);
  }

	public static function list_days(){
		return ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
	}

	public function load_signup_plan($id){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}memberships` WHERE `allow_signups` IN (1) AND `id` IN (?)";
			$result = $this->FetchObject($sql, [$id]);
			if($result !== false){
				$this->setAll($result);
			}
			return $this;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function load_signups_plans(){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}memberships` WHERE `allow_signups` IN (1)";
			$result = $this->FetchAllObject($sql, []);
			$result = $result !== false ? $result : [];
			$r = [];

			foreach($result as $a){
        $a->benefits = $this->load_benefits_by('membership', $a->id);
        $a->benefits_in = [];
        $a->discounts_in = [];
        $a->locations = [];
        foreach ($a->benefits as $ben) {
          if($ben->type == 'discount') $a->discounts_in[] = $ben;
          if($ben->type == 'benefit') $a->benefits_in[] = $ben;
        }

				$a->day_schedule = [];
				foreach($this->days_labels as $day){
					$a->day_schedule[$day] = [];
				}
				foreach($a->benefits as $include){
					if($include->days !== null){
						foreach(explode(',', $include->days) as $day_a){
							if(isset($a->day_schedule[$day])){
							}
							if(isset($a->day_schedule[$day_a])){
								if(!in_array($include,$a->day_schedule[$day_a])){
									$a->day_schedule[$day_a][] = $include;
								}
							}
						}
					} else if($include->months !== null){
						echo "Solo para mes"."\n";
						exit;
					}
					else {
						foreach($this->days_labels as $day){
							$a->day_schedule[$day][] = $include;
						}
					}
				}

				$r[] = $a;
			}


			return $r;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function load_signups_plans_periods(){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}memberships` WHERE `allow_signups` IN (1)";
			$result = $this->FetchAllObject($sql, []);
			$result = $result !== false ? $result : [];


			foreach($result as $a){
				$day_schedule = [];
				foreach($this->days_labels as $day){
					$day_schedule[$day] = [];
				}

				$benefits = $this->load_benefits_by('membership', $a->id);
				//if(!isset($a->locations)) $a->locations = $this->get_list_locations_tree(null, true);
				foreach($benefits as $include){
					if($include->days !== null){
						foreach(explode(',', $include->days) as $day_a){
							if(isset($day_schedule[$day])){
								// $day_schedule[$day]
								// echo json_encode($day_schedule[$day])."\n";
								// echo json_encode($include)."\n";

								if(isset($day_schedule[$day_a])){

									if(!in_array($include,$day_schedule[$day_a])){
										$day_schedule[$day_a][] = $include;
									}
								}


							}

						}
					} else if($include->months !== null){
						echo "Solo para mes"."\n";
						exit;
					}
					else if($include->days !== null && $include->months !== null){
						foreach(explode(',', $include->days) as $day_a){
							if(!in_array($include,$day_schedule[$day_a])){
								$day_schedule[$day_a][] = $include;
							}
						}
					}
					// if($include->limit_cycle !== null){ echo "Dias concretos"; }

					// foreach(explode(',', $include->days) as $day){
						// if(!isset($r[$cycle])) $r[$cycle] = [];
						//if(!in_array($include, $r['days'][$day])) $r['days'][$day][] = $include;
					// }
				}
			}
			return $day_schedule;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function load_benefits_by($lkey, $search=0){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}benefits` WHERE `{$lkey}` IN (?) ";
			$result = $this->FetchAllObject($sql, [$search]);
			$result = $result !== false ? $result : [];
			$r = [];
			foreach($result as $a){
				$a->feature = $this->load_feature_by('id', $a->feature);
				$r[] = $a;
			}
			return $r;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function get_list_locations_tree($parent=null, $load_childs=false, $load_childs_features=true){
		try {
			if($parent==null){ $sql = "Select * FROM `{$this->getPrefix()}locations` WHERE `area_parent` IS NULL"; $result = $this->FetchAllObject($sql, []); }
			else { $sql = "Select * FROM `{$this->getPrefix()}locations` WHERE `area_parent` IN (?)"; $result = $this->FetchAllObject($sql, [$parent]); }
			$result = $result !== false ? $result : [];
			$r = [];
			foreach($result as $a){
				if(!isset($a->features)) $a->features = $this->get_list_locations_features_tree($a->id, null, $load_childs_features);
				if(!isset($a->childs)) $a->childs = [];
				if($load_childs==true) $a->childs = $this->get_list_locations_tree($a->id, $load_childs, $load_childs_features);
				$r[] = $a;
			}
			return $r;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function load_feature_by($lkey, $search=0){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}locations_features` WHERE `{$lkey}` IN (?) ";
			$result = $this->FetchObject($sql, [$search]);
			$result = $result !== false ? $result :(object) [];
			if(isset($result->id)) $result->location = $this->load_location_by('id', $result->location);
			if(isset($result->feature_parent)) $result->feature_parent = $this->load_feature_by('id', $result->feature_parent);
			return $result;
		}
		catch(\Exception $e){
			return (object) [];
		}
	}

	public function load_location_by($lkey, $search=0){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}locations` WHERE `{$lkey}` IN (?) ";
			$result = $this->FetchObject($sql, [$search]);
			$result = $result !== false ? $result :(object) [];
			if(isset($result->area_parent)) $result->area_parent = $this->load_location_by('id', $result->area_parent);
			return $result;
		}
		catch(\Exception $e){
			return (object) [];
		}
	}

	public function get_list_locations_features_tree($location, $parent=null, $load_childs=false){
		try {
			if($parent==null){ $sql = "Select * FROM `{$this->getPrefix()}locations_features` WHERE `feature_parent` IS NULL AND `location` IN (?)"; $result = $this->FetchAllObject($sql, [$location]); }
			else { $sql = "Select * FROM `{$this->getPrefix()}locations_features` WHERE `feature_parent` IN (?) AND `location` IN (?)"; $result = $this->FetchAllObject($sql, [$parent, $location]); }
			$result = $result !== false ? $result : [];
			$r = [];
			foreach($result as $a){
				if(!isset($a->childs)) $a->childs = [];
				if(!isset($a->benefits)) $a->benefits = $this->load_benefits_by('feature', $a->id);
				if($load_childs==true) $a->childs = $this->get_list_locations_features_tree($a->location, $a->id, $load_childs);
				$r[] = $a;
			}
			return $r;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function load_last_plan_user_by_id($user_id=0){
		try {
			$sql = "SELECT U.*
				FROM `{$this->getPrefix()}affiliates` U
				INNER JOIN `{$this->getPrefix()}memberships` L
				ON L.`id`=U.`membership`
				WHERE U.`user_id` IN (?)
					AND (U.`enddate` IS NULL OR U.`enddate`>=CURTIME())
					AND U.`startdate`<=CURTIME()
					AND U.`status` IN ('active')
				ORDER BY `enddate` DESC LIMIT 1";

			$result = $this->getAdapter()->FetchObject($sql, [$user_id]);
			if($result == false) $result = new Self;
			//
			if($result !== false){
				$result->balance_total = 0;
				$wallets = $this->get_wallets_by_user($user_id);
				$result->beneficiaries = $this->get_beneficiaries_by_user($user_id);

				if(isset($result->membership)){
					$result->benefits = $this->load_benefits_and_expenses($result->membership, $result->id);
					$result->membership = $this->get_membership_by($result->membership);
				}

				foreach($wallets as $wallet){ $result->balance_total += (float) $wallet->wallet->balance; }


				$result->day_schedule = [];
				foreach($this->days_labels as $day){
					$result->day_schedule[$day] = [];
				}
				foreach($result->benefits as $include){
					if($include->days !== null){
						foreach(explode(',', $include->days) as $day_a){
							if(isset($result->day_schedule[$day])){
							}
							if(isset($result->day_schedule[$day_a])){
								if(!in_array($include,$result->day_schedule[$day_a])){
									$result->day_schedule[$day_a][] = $include;
								}
							}
						}
					} else if($include->months !== null){
						echo "Solo para mes"."\n";
						exit;
					}
					else {
						foreach($this->days_labels as $day){
							$result->day_schedule[$day][] = $include;
						}
					}
				}

				//$this->setAll($result);
				return $result;
			} else {
				$result->membership = null;
			}
			return new Self;
		}
		catch(\Exception $e){
			// echo "<b>Error:</b> ".($e->getMessage() . " [SQL-FRONT]: $sql");
			return new Self;
		}
	}

	public function get_membership_by($membership_id){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}memberships` WHERE `id` IN (?)";
			$result = $this->FetchObject($sql, [$membership_id]);
			$result = $result !== false ? $result : new Self;
			return $result;
		}
		catch(Exception $e){
			return [];
		}
	}

	public function get_wallets_by_user($user_id){
		try {
			/*
			$sql = "SELECT W.*, MUW.`alias`
				FROM `{$this->getPrefix()}purses` MUW
				INNER JOIN `wallets` W
				ON W.`id` = MUW.`wallet`
				WHERE `user_id` IN (?)";
			$result = $GLOBALS['PACMEC']['DB']->FetchAllObject($sql, [$user_id]);
			$result = $result !== false ? $result : [];
			foreach($result as $a){
				$a->expenses = $this->load_expenses_w($a->id);
			}*/

			$sql = "SELECT MUW.`id`, MUW.`user_id`, MUW.`wallet` as `wallet_id`, MUW.`alias`, MUW.`created_by`, MUW.`modified_by` FROM `{$this->getPrefix()}purses` MUW WHERE `user_id` IN (?)";
			$result = $GLOBALS['PACMEC']['DB']->FetchAllObject($sql, [$user_id]);
			if(is_array($result)){
				foreach ($result as $item) {
					$item->wallet = $GLOBALS['PACMEC']['DB']->FetchObject("SELECT * FROM `{$this->getPrefix()}wallets` WHERE `id` IN (?)", [$item->wallet_id]);
				}
			}
			return $result;
		}
		catch(\Exception $e){
			#echo "<b>Error:</b> ".($e->getMessage() . " [SQL-FRONT]: $sql");
			return [];
		}
	}

	public function load_expenses_w($wallet_id){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}expenses` WHERE `wallet` IN (?) AND MONTH(`created`) = MONTH(CURRENT_DATE()) AND YEAR(`created`) = YEAR(CURRENT_DATE()) ";
			$result = $this->FetchAllObject($sql, [$wallet_id]);
			$result = $result !== false ? $result : [];
			foreach($result as $a){
				// if(!isset($a->features)) $a->features = $this->get_list_locations_features_tree($a->id, null, $load_childs_features);
				//if(!isset($a->childs)) $a->childs = [];
				// if($load_childs==true) $a->childs = $this->load_benefits_expenses($a->id, $load_childs, $load_childs_features);
			}
			return $result;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function get_beneficiaries_by_user($user_id){
		try {
			$sql = "SELECT * FROM `{$this->getPrefix()}beneficiaries` WHERE `user_id` IN (?) ";
			$result = $GLOBALS['PACMEC']['DB']->FetchAllObject($sql, [$user_id]);
			$result = $result !== false ? $result : [];
			foreach($result as $a){
			}
			return $result;
		}
		catch(\Exception $e){
			#echo "<b>Error:</b> ".($e->getMessage() . " [SQL-FRONT]: $sql");
			return [];
		}
	}

	public function load_benefits_and_expenses($search=0, $me_membership=null){
		try {
			$result = $this->FetchAllObject("Select * FROM `{$this->getPrefix()}benefits` WHERE `membership` IN (?) ", [$search]);
			$result = $result !== false ? $result : [];
			$r = [];
			foreach($result as $a){
				$feature_id = $a->feature;
				$a->feature = $this->load_feature_by('id', $a->feature);
				// $a->expenses = $this->load_expenses_m_and_f($a, $a->feature->id);
				//$a->available = [];
				$a->available_day = $a->limit_day;
				$a->available_week = $a->limit_week;
				$a->available_month = $a->limit_month;
				$a->available_year = $a->limit_year;
				$a->expenses_sql = "";
				$a->expenses = [];

				if($a->limit_cycle !== null){
					$sql_parts = [];
					$slug_add_sql = "`membership` IN ('{$me_membership}') AND `benefit` IN ('{$a->id}') "; // AND `type` IN ('spend')
					foreach(explode(',', $a->limit_cycle) as $cycle){
						$a->expenses[$cycle] = [];
						switch($cycle){
							case "Day":
								$sql_parts[] = "({$slug_add_sql} AND DATE(`created`) = CURDATE())";
								break;
							case "Week":
								$sql_parts[] = "({$slug_add_sql} AND `created`  >= FROM_DAYS(TO_DAYS(CURDATE())-MOD(TO_DAYS(CURDATE())-2,7)) "
									."AND `created` < FROM_DAYS(TO_DAYS(CURDATE())-MOD(TO_DAYS(CURDATE())-2,7)) + INTERVAL 7 DAY)";
								break;
							case "Month":
								$sql_parts[] = "({$slug_add_sql} AND MONTH(`created`) = MONTH(CURRENT_DATE()) AND YEAR(`created`) = YEAR(CURRENT_DATE())) ";
								break;
							case "Year":
								$sql_parts[] = "({$slug_add_sql} AND YEAR(`created`) = YEAR(CURRENT_DATE()) AND YEAR(`created`) = YEAR(CURRENT_DATE())) ";
								break;
							default:
								break;
						}
					}

					if(count($sql_parts) > 0){
						$sql_t = "SELECT * FROM `expenses` ";
						for($i=0;$i<count($sql_parts);$i++){ if($i==0){ $sql_t .= " WHERE {$sql_parts[$i]}"; } else { $sql_t .= " OR {$sql_parts[$i]}"; } }
						$result_expenses = $this->FetchAllObject($sql_t, []);
						$a->expenses_sql = $sql_t;
						$r[] = $sql_t;
						$result_expenses = $result_expenses !== false ? $result_expenses : [];
						foreach($result_expenses as $expense){
							foreach(explode(',', $a->limit_cycle) as $cycle){
								$date_time = strtotime($expense->created);
								switch($cycle){
									case "Day":
										if(date('z', $date_time) == date('z')){ $a->expenses[$cycle][] = $expense; }
										break;
									case "Week":
										if(date('W', $date_time) == date('W')){ $a->expenses[$cycle][] = $expense; }
										break;
									case "Month":
										if(date('n', $date_time) == date('n')){ $a->expenses[$cycle][] = $expense; }
										break;
									case "Year":
										if(date('o', $date_time) == date('o')){ $a->expenses[$cycle][] = $expense; }
										break;
									default:
										break;
								}
							}
						}
					}

					// echo json_encode($a);
					// exit;

					foreach(explode(',', $a->limit_cycle) as $cycle){
						// $total = $limit_total = $a->{"limit_".strtolower($cycle)};
						foreach($a->expenses[$cycle] as $expense){
							if($expense->type=='spend'){
								$a->{"available_".strtolower($cycle)} -= $expense->quantity;
							} else if($expense->type=='saveup'){
								$a->{"available_".strtolower($cycle)} += $expense->quantity;
							}
						}
					}
				}
			}
			// echo json_encode($r);
			return $result;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function load_expenses_m_and_f($membership_id, $feature_id){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}expenses` WHERE `membership` IN (?) AND `feature` IN (?)"; //  AND `type` IN ('spend')
			$result = $this->FetchAllObject($sql, [$membership_id, $feature_id]);
			$result = $result !== false ? $result : [];
			foreach($result as $a){
				#if(!isset($a->features)) $a->features = $this->get_list_locations_features_tree($a->id, null, $load_childs_features);
				#if(!isset($a->childs)) $a->childs = [];
				#if($load_childs==true) $a->childs = $this->load_benefits_expenses($a->id, $load_childs, $load_childs_features);
			}
			return $result;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function load_feature_and_expenses($search=0){
		try {
			$sql = "Select * FROM `{$this->getPrefix()}locations_features` WHERE `id` IN (?) ";
			$result = $this->FetchObject($sql, [$search]);
			$result = $result !== false ? $result :(object) [];
			//if(isset($result->id)) $result->location = $this->load_location_by('id', $result->location);
			//if(isset($result->feature_parent)) $result->feature_parent = $this->load_feature_by('id', $result->feature_parent);
			return $result;
		}
		catch(\Exception $e){
			return (object) [];
		}
	}

	public function add_membership($user_id=0,$membership_id=0){
		try {
			$sql = "Select * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}users` WHERE `id` IN (?) ";
			$result_user = $this->FetchObject($sql, [$user_id]);
			if($result_user == false){
				return false;
			} else {
				$exist_membership = $this->load_last_plan_user_by_id($user_id);
				if($exist_membership->id == null){
					$membership = new Membership();
					$membership->getBy('id', $membership_id);
					// $ = parent::FetchObject("SELECT * FROM `{$GLOBALS['PACMEC']['DB']->getPrefix()}cmrfid_memberships` WHERE id=? LIMIT 1", []);
					if($membership !== false && $membership->id > 0){
						$model_new_membership = new Affiliates();
						foreach($membership as $k=>$v){
							//if(isset($model_new_membership->{$k})) $model_new_membership->{$k} = $v;
						}
						$f_d = "Y-m-d H:i:s";
						$date = date($f_d);
						$date1 = str_replace('-', '/', $date);
						$model_new_membership->user_id = $user_id;
						$model_new_membership->membership = $membership_id;
						$model_new_membership->code_id = \randString(50);
						$model_new_membership->initial_payment = $membership->initial_payment;
						$model_new_membership->billing_amount = $membership->billing_amount;
						$model_new_membership->cycle_number = $membership->cycle_number;
						$model_new_membership->cycle_period = $membership->cycle_period;
						$model_new_membership->max_members = $membership->max_members;
						$model_new_membership->status = 'active';
						$model_new_membership->created_by = $_SESSION['user']['id'];
						$model_new_membership->modified_by = $_SESSION['user']['id'];

						switch($membership->cycle_period){
							case "Day":
								$model_new_membership->startdate = $date;
								$model_new_membership->enddate = date($f_d, strtotime($date1 . "+{$membership->cycle_number} days"));
								break;
							case "Week":
								$model_new_membership->startdate = $date;
								$model_new_membership->enddate = date($f_d, strtotime($date1 . "+{$membership->cycle_number} weeks"));
								break;
							case "Month":
								$model_new_membership->startdate = $date;
								$model_new_membership->enddate = date($f_d, strtotime($date1 . "+{$membership->cycle_number} months"));
								break;
							case "Year":
								$model_new_membership->startdate = $date;
								$model_new_membership->enddate = date($f_d, strtotime($date1 . "+{$membership->cycle_number} years"));
								break;
							default:
								$model_new_membership->startdate = $date;
								$model_new_membership->enddate = date($f_d, strtotime($date1 . "+1 days"));
								break;
						}
						$insert = $model_new_membership->create();
						return $insert;
					}
					/*

					if($insert>0){
						$return_obj->error = false;
						$return_obj->message = "Monedero agregado con éxito.";
					} else {
						$return_obj->message = "Ocurrio un error agregando el monedero, intente nuevamente. ";
					}*/
				} else {
					return false;
				}
			}
			return false;
		}
		catch(Exception $e){
			return false;
		}
		return false;
	}

	public function expired_membership($expired_id=0)
	{
		try {
			if($expired_id > 0){
				$sql = "UPDATE `affiliates` SET `status`=?, `modified_by`=? WHERE `id`={$expired_id}";
				$r = $this->FetchObject($sql, ['expired', $_SESSION['user']['id']]);
				if($r!==false){
					return true;
				}
				return $r;
			}
			return false;
		}
		catch(Exception $e){
			return false;
		}
	}

}
