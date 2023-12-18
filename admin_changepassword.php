<?php
$lang_file = 'admin';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

access_denied('password', $LNG);
clear_info("$('.help-block')");


if(isset($_POST['old_pass'])) {
	
	//old password
	$param = "id_acc&" . (int)$_SESSION['id_acc'] . "&INT";
	$info_account = $db->prep_exception($db->returnQuery('query_55'), $param);
	resultFalseArg(!empty($info_account), "$('.help-block').eq(0)", $LNG['pass_err']);
	resultFalseArg(password_verify($_POST['old_pass'],$info_account[0]['password']), "$('.help-block').eq(0)", $LNG['pass_err']);
	resultFalseArg(isset($_POST['old_pass']), "$('.help-block').eq(0)", $LNG['pass1_err']);
	
	//new password
	resultFalseArg(isset($_POST['new_pass']), "$('.help-block').eq(2)", $LNG['pass1_err']);
	resultFalseArg(strlen($_POST['new_pass']) >= 8 && strlen($_POST['new_pass']) <= 16, "$('.help-block').eq(1)", $LNG['pass1_err']);
	
	//new password repeat
	resultFalseArg(isset($_POST['new_pass2']), "$('.help-block').eq(3)", $LNG['pass1_err']);
	resultFalseArg($_POST['new_pass2'] == $_POST['new_pass'], "$('.help-block').eq(2)", $LNG['pass2_err']);

	try{
		$db->beginTransaction();
		
		$param = "id_acc&" . (int)$_SESSION['id_acc'] . "&INT;";
		$param .= 'pass&'. password_hash(($_POST['new_pass']),PASSWORD_DEFAULT) . '&STR';
		$db->prep_query($db->returnQuery('query_56'), $param);
		
		resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['pass2_err']);
	
		$transaction = 19;
		$param = 'uid_user&' . $_SESSION['id_acc'] . '&INT;';
		$param .= 'date&' . calldate() . '&STR;';
		$param .= 'type&' . $transaction . '&INT;';
		$param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
		$db->prep_query($db->returnQuery('query_84'), $param);
		
		resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['pass2_err']);
	
		showInfo("$('.help-block').eq(3)", $LNG['pass_success']);
		
	    $db->commit();    
	} catch (PDOexception $error) {
		$db->rollBack();
		echo $error->getMessage();
		exit;
	}
		
} else {
	require_once(ROOT_PATH . TEMPLATE_DIR . 'change_password.tpl');
}

?>