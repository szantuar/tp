<?php

clear_info("$('.help-block')");
//user validation
resultFalseArg(isset($_POST['name_user']), "$('.help-block').eq(1)", $LNG['user_err']);
resultFalseArg(strlen($_POST['name_user']) >= 5 && strlen($_POST['name_user']) <= 100, "$('.help-block').eq(1)", $LNG['user_err']);
	

$param = "name&" . htmlentities($_POST['name_user']) . "&STR";
$info_account = $db->prep_exception($db->returnQuery('query_2'), $param);
resultFalseArg(empty($info_account), "$('.help-block').eq(1)", $LNG['user_err1']);

try{
    $db->beginTransaction();
    
	$param = "name&" . htmlentities($_POST['name_user']) . "&STR;";
	$password = passwordGenerator(8);
    $param .= 'pass&'. password_hash($password,PASSWORD_DEFAULT) . '&STR;';
	$param .= "date&" . calldate() . "&STR";
	$db->prep_exception($db->returnQuery('query_58'), $param);
	
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['user_err2']);
	
	$last_id = $db->last_id();
	
	$param = 'id_acc&' . $last_id . '&INT';
	$db->prep_query($db->returnQuery('query_59'), $param);
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['user_err2']);
	
	$transaction = 18;
    $param = 'uid_user&' . $last_id . '&INT;';
    $param .= 'date&' . calldate() . '&STR;';
    $param .= 'type&' . $transaction . '&INT;';
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
    $db->prep_query($db->returnQuery('query_84'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['user_err2']);
	
	$info = $LNG['user_success'] . ', ' . $LNG['res_success1'] . ': ' . $password;
	showInfo("$('.help-block').eq(3)", $info);

    $db->commit();    
} catch (PDOexception $error) {
     $db->rollBack();
     echo $error->getMessage();
    exit;
}

?>
<script>
    search_set('admin_users');
</script>

