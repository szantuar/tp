<?php

clear_info("$('.help-block')");
//stand validation
resultFalseArg(isset($_POST['name_stand']), "$('.help-block').eq(1)", $LNG['stand_err']);
resultFalseArg(strlen($_POST['name_stand']) >= 3 && strlen($_POST['name_stand']) <= 40, "$('.help-block').eq(1)", $LNG['stand_err']);
	
$param = "name&" . htmlentities($_POST['name_stand']) . "&STR";
$info_account = $db->prep_exception($db->returnQuery('query_63'), $param);
resultFalseArg(empty($info_account), "$('.help-block').eq(1)", $LNG['stand_err1']);

try{
    $db->beginTransaction();
    	
	$param = "name&" . htmlentities($_POST['name_stand']) . "&STR";
	$db->prep_exception($db->returnQuery('query_64'), $param);
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(2)", $LNG['stand_err2']);
	
	$last_id = $db->last_id();
	
	$transaction = 18;
    $param = 'id_stand&' . $last_id . '&INT;';
    $param .= 'date&' . calldate() . '&STR;';
    $param .= 'type&' . $transaction . '&INT;';
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
    $db->prep_query($db->returnQuery('query_83'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['stand_err2']);
	
	showInfo("$('.help-block').eq(2)", $LNG['stand_success']);
	
    $db->commit();    
} catch (PDOexception $error) {
     $db->rollBack();
     echo $error->getMessage();
    exit;
}

?>
<script>
    search_set('admin_stands');
</script>