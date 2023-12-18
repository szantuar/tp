<?php

clear_info("$('.help-block')");
resultFalseArg(isset($_SESSION['access']['resetpassword']), "$('.help-block').eq(3)", $LNG['no_access']);
resultFalseArg($_SESSION['access']['resetpassword'] == 1, "$('.help-block').eq(3)", $LNG['no_access']);

resultFalseArg(isset($_POST['reset_user']), "$('.help-block').eq(3)", $LNG['user_err4']);
//validation 
$span = $_POST['reset_user'];
$id = (int)substr($_POST['reset_user'], 8);

$param = 'id_user&' . $id . '&INT';
$user_info = $db->prep_exception($db->returnQuery('query_87'), $param);
resultFalseArg(!empty($user_info), "$('.help-block').eq(3)", $LNG['user_err4']);
resultFalseArg(!($user_info[0]['name'] == 'admin'), "$('.help-block').eq(3)", $LNG['res_err2']);
		
//user validation
resultFalseArg(!(($user_info[0]['id_user'] == $_SESSION['id_acc']) || ($user_info[0]['name'] == 'admin')), "$('.help-block').eq(3)", $LNG['res_err2']);

try{
    $db->beginTransaction();
    
	//reset password
	$param = "id_user&" . $user_info[0]['id_user']  . "&INT;";
	$password = passwordGenerator(8);
	$param .= 'pass&'. password_hash($password,PASSWORD_DEFAULT) . '&STR';
	
	$db->prep_exception($db->returnQuery('query_65'), $param);
	
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['res_err1']);
	
	$transaction = 20;
    $param = 'uid_user&' . $user_info[0]['id_user'] . '&INT;';
    $param .= 'date&' . calldate() . '&STR;';
    $param .= 'type&' . $transaction . '&INT;';
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
    $db->prep_query($db->returnQuery('query_84'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['stand_err2']);
	
	$info = $LNG['res_success'] . ', ' . $LNG['res_success1'] . ': ' . $password;
	showInfo("$('.help-block').eq(3)", $info);
	
    $db->commit();    
} catch (PDOexception $error) {
     $db->rollBack();
     echo $error->getMessage();
    exit;
}


?>