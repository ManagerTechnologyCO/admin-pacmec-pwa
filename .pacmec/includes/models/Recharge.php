<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    PACMEC
 * @category   Recharge
 * @copyright  2020-2021 Manager Technology CO
 * @license    license.txt
 * @version    Release: @package_version@
 * @link       http://github.com/ManagerTechnologyCO/PACMEC
 * @version    1.0.1
 */

namespace PACMEC;

Class Recharge extends ModeloBase
{
  public function __construct($atts=[]) {
		parent::__construct('recharges', true);
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
      $sql = "INSERT INTO {$this->getTable()} (`".implode('`,`', $columns_f)."`) VALUES (".implode(",", $columns_a).")";
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

  public function create_ref(){
    $this->ref = base64_encode(base64_encode("recharges") . "." . base64_encode($this->user_id) . "." . base64_encode($this->purse_id) . "." . base64_encode($this->amount) . "." . base64_encode(time()));
    /*
    $decode = explode('.', base64_decode($this->ref));
    $this->user_id = base64_decode($decode[0]);
    $this->wallet_id = base64_decode($decode[1]);
    $this->amount = base64_decode($decode[2]);
    */
  }
}
