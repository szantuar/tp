<?php
$lang_file = 'request';
require_once('common.php');

$lang->includeLang($lang_file);

clear_info("$('.help-block')");

is_session();
access_denied('demand', $LNG);

//validation data
resultFalseArg(isset($_SESSION['pn_data']), "$('.help-block').eq(0)", $LNG['empty']);
resultFalseArg(isset($_POST['sn']), "$('.help-block').eq(0)", $LNG['sn_error']);
resultFalseArg(isset($_POST['id_hist']), "$('.help-block').eq(0)", $LNG['his_error']);
resultFalseArg(((strlen($_POST['sn']) > 5) && (substr($_POST['sn'], 0, 5) != 'empty')), "$('.help-block').eq(0)", $LNG['sn_error']);
resultFalseArg($_SESSION['pn_data']['qty'] > 0, "$('.help-block').eq(0)", $LNG['qty_error']);


$param = 'id_his&' . (int)$_POST['id_hist'] . '&INT';
$hist_data = $db->prep_query($db->returnQuery('query_24'), $param);
resultFalseArg(!empty($_POST['id_hist']), "$('.help-block').eq(0)", $LNG['his_error']);

$param = 'sn&' . htmlentities($_POST['sn']) . '&STR';
$sn_use = $db->prep_exception($db->returnQuery('query_92'), $param);
resultFalseArg(empty($sn_use), "$('.help-block').eq(0)", $LNG['sn_error2']);

$sn_use = $db->prep_exception($db->returnQuery('query_93'), $param);
resultFalseArg(empty($sn_use), "$('.help-block').eq(0)", $LNG['sn_error3']);

$sn_use = $db->prep_exception($db->returnQuery('query_94'), $param);
if(!empty($sn_use)) {
	resultFalseArg($sn_use[0]['type_transaction'] != 13,  "$('.help-block').eq(0)", $LNG['sn_error4']);
}

try {
    $db->beginTransaction();
    
    //add record for new PN to history
    $param = 'id_set&' . $hist_data[0]['id_set'] . '&INT;';
    $param .= 'id_pn&' . (INT)$_SESSION['pn_data']['id'] . '&INT;';
    $param .= 'sn&' . htmlentities($_POST['sn']) . '&STR;';
	$param .= 'type&5&INT;';
    $param .= 'date&' . calldate() . '&STR;'; 
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT'; 
    
    $db->prep_query($db->returnQuery('query_102'), $param);
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['err_record']);
    
    $last_id = $db->last_id();
    
    //add PN to set
    $param = 'id_hist&' . (INT)$last_id . '&INT;';
    $param .= 'old_hist&' . (INT)$hist_data[0]['id_history'] . '&INT';
    
    $db->prep_query($db->returnQuery('query_48'), $param);
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['err_record']);
    
	if(substr($hist_data[0]['sn'], 0, 5) == 'empty') {
		//update undercheck
		$param = 'old_hist&' . (INT)$hist_data[0]['id_history'] . '&INT';
		
		$db->prep_query($db->returnQuery('query_21'), $param);
		resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['err_record']);
	} else {		
		//add record for transfer on QA
		$param = 'id_set&' . $hist_data[0]['id_set'] . '&INT;';
		$param .= 'id_pn&' . $hist_data[0]['id_pn'] . '&INT;';
		$param .= 'sn&' . $hist_data[0]['sn'] . '&STR;';
		$param .= 'type&11&INT;';
		$param .= 'date&' . calldate() . '&STR;'; 
		$param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT'; 
		
		$db->prep_query($db->returnQuery('query_102'), $param);
		resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['err_record']);
		
		$last_id = $db->last_id();
		
		//update undercheck
		$param = 'id_hist&' . $last_id . '&INT;';
		$param .= 'old_hist&' . (INT)$hist_data[0]['id_history'] . '&INT';
		
		$db->prep_query($db->returnQuery('query_50'), $param);
		resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['err_record']);
    }
	
    $db->commit();
	
} catch(PDOexception $error) {
    $db->rollBack();
    echo $error->getMessage();
    exit;
}

?>

<script>
$('#tb_tr_<?= $hist_data[0]['id_history']; ?>').remove();
$('#tb_pn').val('');
$('#tb_desc').html('');
$('#tb_oh').html('');
$('#tb_sn').val('');
</script>