<?php

clear_info("$('.help-block')");
//model validation
resultFalseArg(isset($_POST['name_model']), "$('.help-block').eq(1)", $LNG['model_err']);
resultFalseArg(strlen($_POST['name_model']) >= 5 && strlen($_POST['name_model']) <= 10, "$('.help-block').eq(1)", $LNG['model_err']);
	
$param = "name&" . htmlentities(strtoupper($_POST['name_model'])) . "&STR";
$info_account = $db->prep_exception($db->returnQuery('query_60'), $param);
resultFalseArg(empty($info_account), "$('.help-block').eq(1)", $LNG['model_err1']);
	
//validation client
resultFalseArg(isset($_POST['choose']), "$('.help-block').eq(2)", $LNG['client_err']);
$param = "id_client&" . (INT)$_POST['choose'] . "&INT";
$info_client = $db->prep_exception($db->returnQuery('query_61'), $param);
resultFalseArg(!empty($info_client), "$('.help-block').eq(2)", $LNG['client_err']);
	
try{
	$db->beginTransaction();
	
	$param = "name&" . htmlentities(strtoupper($_POST['name_model'])) . "&STR;";
	$param .= "client&" . (INT)$_POST['choose'] . "&INT";
		
	$db->prep_query($db->returnQuery('query_62'), $param);		
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['model_err5']);
	
	$last_id = $db->last_id();
	
	$transaction = 18;
    $param = 'id_model&' . $last_id . '&INT;';
    $param .= 'date&' . calldate() . '&STR;';
    $param .= 'type&' . $transaction . '&INT;';
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
    $db->prep_query($db->returnQuery('query_79'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(0)", $LNG['model_err5']);	
	showInfo("$('.help-block').eq(3)", $LNG['model_success']);
    
    $db->commit();    
} catch (PDOexception $error) {
	$db->rollBack();
	echo $error->getMessage();
    exit;
}

?>
<script>
    search_set('admin_models');
</script>
