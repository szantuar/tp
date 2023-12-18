<?php
$lang_file = 'request';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
access_denied('demand', $LNG);

resultFalseArg(isset($_POST['id_hist']), "$('.help-block').eq(0)", $LNG['his_error']);

$id_old = (int)$_POST['id_hist'];

$param = "id_his&" . $id_old . '&INT';
$his_data = $db->prep_exception($db->returnQuery('query_24'), $param);

try {
	$db->beginTransaction();
	
	//add record for history
	$param = 'id_set&' . $his_data[0]['id_set'] . '&INT;';
	$param .= 'id_pn&' . $his_data[0]['id_pn'] . '&INT;';
	$param .= 'sn&' . $his_data[0]['sn'] . '&STR;';
	$param .= 'type&22&INT;';
	$param .= 'date&' . calldate() . '&STR;';
	$param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
	
	$db->prep_query($db->returnQuery('query_102'), $param);
	
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['req_error3']);
	
	$param = "id_hist&" . $id_old . '&INT';
	$db->prep_query($db->returnQuery('query_29'), $param);
	
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['req_error3']);
	
	$db->commit();
	
} catch(PDOexception $error) {
		$db->rollBack();
		echo $error->getMessage();
		exit;
	}
	

?>
<script>
$('#tb_tr_<?= $id_old; ?>').addClass('is_damaged');
</script>