<?php

$lang_file = 'login';
require_once('common.php');

$lang->includeLang($lang_file);

clear_info("$('.help-block')");



if(isset($_POST['username'])) {
	resultFalseArg(isset($_POST['password']), "$('.help-block').eq(1)", $LNG['err_pass']);
	
	$param = "name&" . htmlentities($_POST['username']) . "&STR";
	$info_account = $db->prep_exception($db->returnQuery('query_2'), $param);
	
	resultFalseArg(!empty($info_account), "$('.help-block').eq(0)", $LNG['err_name']);
	resultFalseArg(password_verify($_POST['password'],$info_account[0]['password']), "$('.help-block').eq(2)", $LNG['incorrect']);	
    resultFalseArg($info_account[0]['status'] == 1, "$('.help-block').eq(2)", $LNG['deactive']);

	$_SESSION['id_acc'] = $info_account[0]['id_user'];
	$_SESSION['name_acc'] = $info_account[0]['name'];
	$_SESSION['session_time'] = calldate();
	
	$param = "id_acc&" . (INT)($_SESSION['id_acc']) . "&INT";
	$list_access = $db->prep_exception($db->returnQuery('query_3'), $param);
	
	if(!empty($list_access)) {
                 $_SESSION['access'] = $list_access[0];
	}
	
	?>
	<script>
	location.reload();
	</script>
	<?php

	
	
} else {
	require_once(ROOT_PATH . TEMPLATE_DIR .'login.tpl');
}



?>