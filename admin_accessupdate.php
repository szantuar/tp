<?php
$lang_file = 'admin';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

access_denied('addaccess', $LNG);
resultFalseArg(isset($_POST['id']), "$('.help-block').eq(1)", $LNG['admin_err']);

$id = substr($_POST['id'],3,2);
$user = substr($_POST['id'],6,strlen($_POST['id'])-6);

//validation not admin
resultFalseArg((int)$user != 1, "$('.help-block').eq(1)", $LNG['admin_err1']);

//user validation
$param = 'id_user&' . (int)$user . '&INT';
$user_data = $db->prep_exception($db->returnQuery('query_67'), $param);
resultFalseArg(!empty($user_data), "$('.help-block').eq(1)", $LNG['admin_err2']);

//access validation
$param = 'access&' . (int)$id . '&INT';
$access = $db->prep_exception($db->returnQuery('query_68'), $param);
resultFalseArg(!empty($access), "$('.help-block').eq(1)", $LNG['admin_err3']);

//take data access;
$param = 'id_user&' . (int)$user . '&INT';
$full_access = $db->prep_exception($db->returnQuery('query_69'), $param);
resultFalseArg(!empty($full_access), "$('.help-block').eq(1)", $LNG['admin_err2']);

$image = '';
try {
	$db->beginTransaction();
	
	//add history acccess
	$status = ($full_access[0][$access[0]['name']] == 0) ? 14 : 15;
	$param = 'access&' . (int)$id . '&INT;';
	$param .= 'gid_user&' . (int)$user . '&INT;';
	$param .= 'uid_user&' . (int)$_SESSION['id_acc'] . '&INT;';
	$param .= 'date&' . calldate(). '&STR;';
	$param .= 'status&' . $status . '&INT';
	 	 
	$db->prep_query($db->returnQuery('query_70'), $param);
	
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(1)", $LNG['admin_err4']);
	
	//udpdate access
	$param = 'uid_user&' . (int)$user . '&INT';	
	$db->prep_query("UPDATE user_access SET " . $access[0]['name'] . " = 1 WHERE uid_user = :uid_user AND " . $access[0]['name'] . " = 0 LIMIT 1;", $param);
    $tip_number = 'tip' . (int)$id + 1 . '_1';
    $image = access(1, array($LNG['tip0_1'], $LNG['tip0_2']), $LNG[$tip_number]);

	if($db->CountRow() == 0){
		$db->prep_query("UPDATE user_access SET " . $access[0]['name'] . " = 0 WHERE uid_user = :uid_user AND " . $access[0]['name'] . " = 1 LIMIT 1;", $param);
        $image = access(0, array($LNG['tip0_1'], $LNG['tip0_2']), $LNG[$tip_number]);
	}
	
	resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(1)", $LNG['admin_err4']);
	
	$db->commit();
		
} catch(PDOexception $error) {
		$db->rollBack();
		echo $error->getMessage();
		exit;
	}

?>
<script>
$('#<?= $_POST['id']; ?>').html("<?= $image; ?>");
</script>