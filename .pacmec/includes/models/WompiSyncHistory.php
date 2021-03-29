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

class WompiSyncHistory extends ModeloBase {
  public function __construct($atts=[]) {
		parent::__construct('wompi_sync_history', true);
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
      $sql = "INSERT INTO {$this->getTable()} (".implode(',', $columns_f).") VALUES (".implode(",", $columns_a).")";
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

}
