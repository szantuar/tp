<?php
$lang_file = 'request';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
//do zrobienia sprawdzanie dla 5 roznych poziomow uprawien

if($_SESSION['access']['newuser'] == 0 && $_SESSION['access']['newmodel'] == 0 && $_SESSION['access']['newstand'] == 0 && $_SESSION['access']['resetpassword'] == 0 && $_SESSION['access']['addaccess'] == 0) {
	resultFalseArg(false, "$('.help-block').eq(0)", $LNG['no_access']);
}

resultFalseArg(isset($_POST['id_hist']), "$('.help-block').eq(0)", $LNG['his_error']);

$id_old = (int)$_POST['id_hist'];

$param = "id_his&" . $id_old . '&INT';
$his_data = $db->prep_exception($db->returnQuery('query_24'), $param);
resultFalseArg(!empty($his_data), "$('.help-block').eq(0)", $LNG['his_error']);

resultFalseArg((substr($his_data[0]['sn'],0,5) != 'empty'), "$('.help-block').eq(0)", $LNG['his_error2']);

try {
	$db->beginTransaction();
	
	//add record for history
	$param = 'id_set&' . $his_data[0]['id_set'] . '&INT;';
	$param .= 'id_pn&' . $his_data[0]['id_pn'] . '&INT;';
	$param .= 'sn&' . $his_data[0]['sn'] . '&STR;';
	$param .= 'type&29&INT;';
	$param .= 'date&' . calldate() . '&STR;';
	$param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
	
	$db->prep_query($db->returnQuery('query_102'), $param);	
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['req_error4']);
	$last_id = $db->last_id();
	
	//cancel demand
	$param = "id_hist&" . $id_old . '&INT';
	$db->prep_query($db->returnQuery('query_53'), $param);
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['req_error4']);
	
	//set no damaged
	$param = "id_hist&" . $last_id . '&INT;';
	$param .= "old_hist&" . $id_old . '&INT';
	$db->prep_query($db->returnQuery('query_48'), $param);
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['req_error4']);
	
	$db->commit();
	
} catch(PDOexception $error) {
		$db->rollBack();
		echo $error->getMessage();
		exit;
	}
	

?>
<script>
$('#tb_tr_<?= $id_old; ?>').remove();
</script>