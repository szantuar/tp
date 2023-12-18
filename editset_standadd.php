<?php
$lang_file = 'testrig';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
access_denied('standchange', $LNG);

info_alert(isset($_POST['id_set']), $LNG['error_set3']);

clear_info("$('.help-block')");

if(isset($_POST['option_choose'])){
	
	//validation stand
	$param = 'stand&' . (int)$_POST['option_choose'] . '&INT';
	$result = $db->prep_exception($db->returnQuery('query_5'), $param);
	resultFalseArg(!empty($result), "$('.help-block').eq(2)", $LNG['err_choose2']);
	
	try {
		$db->beginTransaction();
		
		$param = 'id_set&' . (int) $_POST['id_set'] . '&INT;';
		$param .= 'id_stand&' . $_POST['option_choose'] . '&INT';
		
		if((int)$_POST['option_choose'] == 1) {
			$query = $db->returnQuery('query_6');
		} else {
			$query = $db->returnQuery('query_7');
		}
		
		$result = $db->prep_query($query, $param);
		
		$param = 'id_set&' . (int)$_POST['id_set'] . '&INT;';
		$param .= 'actual_date&' . calldate() . '&STR;';
		$param .= 'id_stand&' . $_POST['option_choose'] . '&INT;';
		$param .= 'id_user&' . $_SESSION['id_acc'] . '&INT';
		$result = $db->prep_query($db->returnQuery('query_8'), $param);
		
		$db->commit();
		
	} catch(PDOexception $error) {
		$db->rollBack();
		echo $error->getMessage();
		exit;
	}
	
	if($db->readCount() == 1){
		showInfo("$('.help-block').eq(3)", $LNG['succes_change']);	
	} else {
		showInfo("$('.help-block').eq(3)", $LNG['fail_change']);	
	}
	
	
} else {
	
	$stand_list = $db->fetch_exception($db->returnQuery('query_9'));
	
	require_once(ROOT_PATH . TEMPLATE_DIR . 'editset_standadd.tpl');
}
	
?>