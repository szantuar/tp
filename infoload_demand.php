<?php

//$lang_file = 'global';
require_once('common.php');

$list_demand = $db->fetch_exception($db->returnQuery('query_95'));

if(!empty($list_demand)){
	if($list_demand[0]['qty'] > 0){
		echo $list_demand[0]['qty'];
	} else {
		echo '';
	}
}

