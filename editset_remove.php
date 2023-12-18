<?php

$lang_file = 'testrig';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
access_denied('setedit', $LNG);

info_alert(isset($_POST['id_set']), $LNG['error_set1']);

$param = 'id_set&' . (int)$_POST['id_set'] . '&INT';
$damaged = $db->prep_exception($db->returnQuery('query_31'), $param);

info_alert(empty($damaged), $LNG['error_set2']);

//take list all positon from set
$param = 'id_set&' . (int)$_POST['id_set'] . '&INT';	
$set_details = $db->prep_exception($db->returnQuery('query_32'), $param);

try {
	$db->beginTransaction();

	//close set
	$param = 'id_set&' . (int)$_POST['id_set'] . '&INT;';
	$param .= 'user&' . (int)$_SESSION['id_acc'] . '&INT;';
	$param .= 'finish_time&' . calldate() . '&STR';	
	$db->prep_query($db->returnQuery('query_33'), $param);
	
	info_alert($db->CountRow() > 0, $LNG['error_set3']);
	
	//record in history
	$param = 'id_set&' . (int)$_POST['id_set'] . '&INT;';
	$param .= 'user&' . (int)$_SESSION['id_acc'] . '&INT;';
	$param .= 'date&' . calldate() . '&STR';	
	$db->prep_query($db->returnQuery('query_34'), $param);
	
	if(!empty($set_details)) {
		foreach($set_details AS $list) {
			//remove parts from set
			$param = 'id_parts&' . $list['id_parts'] . '&INT';
			$db->prep_query($db->returnQuery('query_35'), $param);
			
			//remove parts from demand
			$param = 'old_history&' . $list['id_history_parts'] . '&INT';
			$result = $db->prep_query($db->returnQuery('query_100'), $param);
						
			$type_transaction = (substr($list['sn'],0,5) == 'empty') ? 23 : 9;
			//add record in history
			$param = 'id_set&' . $list['id_set'] . '&INT;';
			$param .= 'id_pn&' . $list['id_pn'] . '&INT;';
			$param .= 'sn&' . $list['sn'] . '&STR;';
			$param .= 'type&' . $type_transaction . '&INT;';
			$param .= 'date&' . calldate() . '&STR;';	
			$param .= 'id_acc&' . (int)$_SESSION['id_acc'] . '&INT';
			
			$db->prep_query($db->returnQuery('query_102'), $param);
			
			$last_id = $db->last_id();
			
			if($type_transaction == 9) {
				//add new parts undercheck
				$param = 'id_hist&' . $last_id . '&INT;';
				$param .= 'type&11&INT;';
				$param .= 'date&' . calldate() . '&STR';
				
				$db->prep_query($db->returnQuery('query_43'), $param);
				
				if($db->CountRow() == 0){
					$db->prep_query($db->returnQuery('query_44'), $param);
				}
			}
		}
	}

	$db->commit();
	
	info_alert(false, $LNG['finish_set']);
	
} catch(PDOexception $error) {
		$db->rollBack();
		echo $error->getMessage();
		exit;
	}
	
?>