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

class Membership extends ModeloBase {
	private $labels_slugs = ['access','comfort','benefit','discount'];
	private $parents_slugs = ['hotel','club','club_friends','restaurant'];
	private $cycles_periods = ['Day','Week','Month','Year'];
	private $days_labels = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

    public function __construct($atts=[]) {
		parent::__construct('memberships', true);
    }

}
