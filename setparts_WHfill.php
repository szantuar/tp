<?php

$lang_file = 'request';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
access_denied('demand', $LNG);

resultFalseArg(isset($_POST['id_hist']), "$('.help-block').eq(0)", $LNG['his_error']);
resultFalseArg(isset($_POST['status']), "$('.help-block').eq(0)", $LNG['status']);

$type = '';
if($_POST['status'] == 'badge bg-success') {
	$type = 24;
} elseif ($_POST['status'] == 'badge bg-primary') {
	$type = 26;
} else {
	resultFalseArg(false, "$('.help-block').eq(0)", $LNG['status']);
}

//check record history
$param = 'id_his&' . (int)$_POST['id_hist'] . '&INT';
$hist_data = $db->prep_exception($db->returnQuery('query_24'), $param);

resultFalseArg(!empty($_POST['id_hist']), "$('.help-block').eq(0)", $LNG['his_error']);

try {
    $db->beginTransaction();
    
	//add record to history
	$param = 'id_set&' . $hist_data[0]['id_set'] . '&INT;';
    $param .= 'id_pn&' . $hist_data[0]['id_pn'] . '&INT;';
    $param .= 'sn&' . $hist_data[0]['sn'] . '&STR;';
    $param .= 'date&' . calldate() . '&STR;'; 
	$param .= 'type&' . $type . '&INT;';
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT'; 
    
    $db->prep_query($db->returnQuery('query_102'), $param);
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['err_record2']);
	
	$last_id = $db->last_id();
	
	//update undercheck
    $param = 'id_hist&' . $hist_data[0]['id_history'] . '&INT';
    
	if($type == 26) {
		$param .= ';type&' . $type . '&INT;';
		$param .= 'new_history&' . $last_id . '&INT';
		$db->prep_query($db->returnQuery('query_36'), $param);
		resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['err_record']);		
	} else{
		$db->prep_query($db->returnQuery('query_53'), $param);
		resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['err_record2']);
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

</script>
