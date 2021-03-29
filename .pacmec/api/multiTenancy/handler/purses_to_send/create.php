<?php 
return [
	'status' => 'review',
	'user_id' => $_SESSION['user']['id'],
	'affiliate_id' => $_SESSION['membership']->id
];
