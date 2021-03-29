<?php
/**
  * Afiliados
  *
  *
  * @package    PACMEC
  * @author     FelipheGomez <feliphegomez@gmail.com>
  *
  **/

namespace PACMEC;

class Affiliates extends ModeloBase {
  public function __construct($atts=[]) {
		parent::__construct('affiliates', true);
  }

	public function load_signup_plan($id, $user_id=null){
		try {
      if(!isset($user_id) && isset($_SESSION['user']['id'])) $user_id = $_SESSION['user']['id'];

			$sql = "Select * FROM `{$this->getPrefix()}memberships` WHERE `allow_signups` IN (1) AND `id` IN (?)";
			$result = $this->FetchObject($sql, [$id]);
      if($result!==false&&$result->id>0){
        $this->membership = $result->id;
        $this->user_id = $user_id !== null ? $user_id : 0;
        $this->code_id = \randString(11);
        $this->initial_payment = $result->initial_payment;
        $this->billing_amount = $result->billing_amount;
        $this->cycle_number = $result->cycle_number;
        $this->cycle_period = $result->cycle_period;
        $this->max_members = $result->max_members;
        $this->created_by = $user_id !== null ? $user_id : 0;
        $this->modified_by = $user_id !== null ? $user_id : 0;
        $this->status = 'pending';
        $f_d = infosite('memberships_format_cycle_date_calc') . " " . infosite('memberships_format_cycle_time_calc');
        $date = date($f_d);
        $date1 = str_replace('-', '/', $date);
  			switch($result->cycle_period){
  				case "Day":
  					$this->startdate = $date;
  					$this->enddate = date($f_d, strtotime($date1 . "+{$result->cycle_number} days"));
  					break;
  				case "Week":
  					$this->startdate = $date;
  					$this->enddate = date($f_d, strtotime($date1 . "+{$result->cycle_number} weeks"));
  					break;
  				case "Month":
  					$this->startdate = $date;
  					$this->enddate = date($f_d, strtotime($date1 . "+{$result->cycle_number} months"));
  					break;
  				case "Year":
  					$this->startdate = $date;
  					$this->enddate = date($f_d, strtotime($date1 . "+{$result->cycle_number} years"));
  					break;
  				default:
  					$this->startdate = $date;
  					$this->enddate = date($f_d, strtotime($date1 . "+1 days"));
  					break;
  			}
      }
      return $this;
		}
		catch(\Exception $e){
			return [];
		}
	}

	public function update(){
		$columns = $this->getColumns();
		$columns_a = [];
		$columns_f = [];
		$items_send = [];
		try {
  		foreach($columns as $i){
  			if(isset($this->{$i}) && $i!=='id'){
  				$columns_m[] = "`{$i}`=?";
  				$columns_f[] = $i;
  				$columns_a[] = "?";

  				if($i == 'data'){
  					$items_send[] = json_encode($this->{$i});
  				} else {
  					$items_send[] = $this->{$i};
  				}
  			}
  		}

      $sql = "UPDATE {$this->getTable()} SET ".implode(",", $columns_m)." WHERE `id`='{$this->id}'";
      return $this->FetchObject($sql, $items_send);
		}catch (Exception $e){
			return $e->getMessage();
		}
	}

	public function create(){
		$columns = $this->getColumns();
		$columns_a = [];
		$columns_f = [];
		$items_send = [];
		try {
  		foreach($columns as $i){
  			if(isset($this->{$i})){
  				$columns_f[] = $i;
  				$columns_a[] = "?";

  				if($i == 'data'){
  					$items_send[] = json_encode($this->{$i});
  				} else {
  					$items_send[] = $this->{$i};
  				}
  			}
  		}
      $sql = "INSERT INTO `{$this->getTable()}` (`".implode('`,`', $columns_f)."`) VALUES (".implode(",", $columns_a).")";
      $insert = $this->FetchObject($sql, $items_send);
      if($insert>0){
        $this->id = $insert;
        return $insert;
      }
      return 0;
		}catch (Exception $e){
			return 0;
		}
	}

  public function getByExpirePrevDay(){
    try {
        $sql = "SELECT * FROM `{$this->getTable()}` AF WHERE AF.`status` IN ('active') AND DATE(AF.`enddate`) <= (CURDATE())";
        return $this->getAdapter()->FetchAllObject($sql, []);
    }
    catch(Exception $e){
        return false;
    }
  }

  public function getByExpirePrevDayAutoPayment(){
    try {
        $sql = "SELECT AF.*, WT.source_id, WT.type, WT.holder_email
          FROM `{$this->getTable()}` AF
          INNER JOIN `wompi_tokens` WT
          ON WT.`user_id` = AF.`user_id`
          WHERE AF.`status` IN ('active') AND DATE(AF.`enddate`) <= (CURDATE()) AND WT.`token_status` IN ('CREATED','APPROVED')
          AND WT.`source_status` IN ('AVAILABLE')";
        return $this->getAdapter()->FetchAllObject($sql, []);
    }
    catch(Exception $e){
        return false;
    }
  }

  public function getMembershipById($membership_id){
    try {
        $sql = "SELECT * FROM `memberships` WHERE `id` = ?";
        return $this->getAdapter()->FetchObject($sql, [$membership_id]);
    }
    catch(Exception $e){
        return false;
    }
  }

  public function expireAffiliate($id){
      try {
        $m = new Self();
        $m->getById($id);
        if($m->id>0){
          $m->status = 'expired';
          return $m->update();
        } else {
          return false;
        }
      }
      catch(Exception $e){
          return false;
      }
  }

  public function MeHistory(){
    try {
        $sql = "SELECT A.*
        FROM `{$this->getTable()}` A
        WHERE `user_id` = ? ORDER BY `enddate` DESC";
        return $this->getAdapter()->FetchAllObject($sql, [$_SESSION['user']['id']]);
    }
    catch(Exception $e){
        return false;
    }
  }
}
