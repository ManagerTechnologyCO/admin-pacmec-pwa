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
