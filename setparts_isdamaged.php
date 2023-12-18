<?php
$lang_file = 'request';
require_once('common.php');

$lang->includeLang($lang_file);

clear_info("$('.help-block')");

resultFalseArg(isset($_POST['user']), "$('.help-block').eq(2)", $LNG['user_empty']);
resultFalseArg(isset($_POST['id_hist']), "$('.help-block').eq(1)", $LNG['hist_empty']);

$param = '';
if(isset($_SESSION['id_acc'])) {
	$param = 'user&none&STR;';
	$param .= 'id_acc&' . (int)$_SESSION['id_acc'] . '&INT';
} else {
	$param = 'user&' . htmlentities($_POST['user']) . '&STR;';
	$param .= 'id_acc&0&INT';
}

//validation user
$user_data = $db->prep_exception($db->returnQuery('query_39'), $param);
resultFalseArg(!empty($user_data), "$('.help-block').eq(2)", $LNG['user_wrong']);
resultFalseArg($user_data[0]['status'] == 1, "$('.help-block').eq(2)", $LNG['user_wrong']);

//validation record in history
$param = 'id_hist&' . (int) $_POST['id_hist'] . '&INT';

$his_data = $db->prep_exception($db->returnQuery('query_40'), $param);
resultFalseArg(!empty($his_data), "$('.help-block').eq(1)", $LNG['hist_empty']);

//validation record parts_fail
$parts = $db->prep_exception($db->returnQuery('query_41'), $param);
resultFalseArg(!empty($parts), "$('.help-block').eq(1)", $LNG['err_pn']);


try {
	$db->beginTransaction();
	
    //add record for history
	$param = 'id_set&' . $his_data[0]['id_set'] . '&INT;';
	$param .= 'id_pn&' . $his_data[0]['id_pn'] . '&INT;';
	$param .= 'sn&' . $his_data[0]['sn'] . '&STR;';
	$param .= 'type&10&INT;';
	$param .= 'date&' . calldate() . '&STR;';
	$param .= 'id_acc&' . $user_data[0]['id_user'] . '&INT';
	
	$db->prep_query($db->returnQuery('query_102'), $param);
	
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(1)", $LNG['err_create']);
	
	$last_id = $db->last_id();
	
    //add new parts undercheck
	$param = 'id_hist&' . $last_id . '&INT;';
	$param .= 'type&10&INT;';
	$param .= 'date&' . calldate() . '&STR';
	
    $db->prep_query($db->returnQuery('query_43'), $param);
    
    if($db->CountRow() == 0){
		$db->prep_query($db->returnQuery('query_44'), $param);
    }
	 
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(1)", $LNG['err_create']);
	
   //update stauts for parts set
	$param = 'id_hist&' . $last_id . '&INT;';
	$param .= 'old_history&' . $his_data[0]['id_history'] . '&INT';
	
	$db->prep_query($db->returnQuery('query_45'), $param);
	
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(1)", $LNG['err_create']);
	
	$db->commit();
	
} catch(PDOexception $error) {
		$db->rollBack();
		echo $error->getMessage();
		exit;
	}


$id_old = (int)$_POST['id_hist'];
$id_new = $last_id;

?>

<script>

$('#tb_span_<?= $id_old; ?>').removeClass('bg-success');
$('#tb_span_<?= $id_old; ?>').addClass('bg-danger');
$('#tb_span_<?= $id_old; ?>').html('<?= $LNG['parts_fail']; ?>');

$('#tb_sn_<?= $id_old; ?>').attr('id', 'tb_sn_<?= $id_new; ?>');
$('#tb_tr_<?= $id_old; ?>').attr('id', 'tb_tr_<?= $id_new; ?>');
$('#tb_span_<?= $id_old; ?>').attr('id', 'tb_span_<?= $id_new; ?>');

</script>	
