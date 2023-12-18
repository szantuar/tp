<?php
$lang_file = 'admin';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();
access_denied('demand', $LNG);

clear_info("$('.help-block')");

if(!empty($_POST)){
	
	$param = 'sn&' . htmlentities($_POST['sn']) . '&STR';
	$sn_use = $db->prep_exception($db->returnQuery('query_101'), $param);
	resultFalseArg(!empty($sn_use),  "$('.help-block').eq(1)", $LNG['sn_error']);	
	resultFalseArg($sn_use[0]['type_transaction'] == 13,  "$('.help-block').eq(1)", $LNG['sn_error']);
	
	$param = 'id_set&' . $sn_use[0]['id_set'] . '&INT;';
    $param .= 'id_pn&' . $sn_use[0]['id_pn'] . '&INT;';
    $param .= 'sn&' . $sn_use[0]['sn']  . '&STR;';
	$param .= 'type&6&INT;';
    $param .= 'date&' . calldate() . '&STR;'; 
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT'; 
	
	$result = $db->prep_query($db->returnQuery('query_102'), $param);
	
	if($db->CountRow() > 0) {
		showInfo("$('.help-block').eq(1)", $LNG['sn_success']);
	} else {
		showInfo("$('.help-block').eq(1)", $LNG['sn_error1']);
	}

} else {
	require(ROOT_PATH . TEMPLATE_DIR . 'sn_status.tpl');
}


?>