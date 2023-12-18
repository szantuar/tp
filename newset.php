<?php

$lang_file = 'testrig';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
	
clear_info("$('.help-block')");
access_denied('newset', $LNG);

if(!empty($_POST)) {
	
	//validation description
	resultFalseArg(isset($_POST['desc']), "$('.help-block').eq(0)", $LNG['err_val1']);
	if((strlen($_POST['desc']) <= 0) || (strlen($_POST['desc']) > 100)) {
		resultFalseArg(false, "$('.help-block').eq(0)", $LNG['err_val2']);
	}
	
	//validation model
	resultFalseArg(isset($_POST['model_list']), "$('.help-block').eq(1)", $LNG['err_val3']);
	$param = 'model&' . (int) $_POST['model_list'] . '&INT';
	$result = $db->prep_exception($db->returnQuery('query_10'), $param);	
	resultFalseArg(!empty($result), "$('.help-block').eq(1)", $LNG['err_val4']);
	
	//validation stand
	resultFalseArg(isset($_POST['stand_list']), "$('.help-block').eq(2)", $LNG['err_val5']);
	$param = 'stand&' . (int) $_POST['stand_list'] . '&INT';
	$result = $db->prep_exception($db->returnQuery('query_11'), $param);	
	resultFalseArg(!empty($result), "$('.help-block').eq(2)", $LNG['err_val6']);		
	
	
	try{
		$db->beginTransaction();
		
		$param = 'model&' . (int) $_POST['model_list'] . '&STR;';
		$param .= 'desc&' . htmlentities($_POST['desc']) . '&STR;';
		$param .= 'date&' . calldate() . '&STR;';
		$param .= 'id_user&' . $_SESSION['id_acc'] . '&INT;';
		$param .= 'stand&' . (int) $_POST['stand_list'] . '&INT';
		
		if((int) $_POST['stand_list'] != 1) {
			$result = $db->prep_query($db->returnQuery('query_12'), $param);
		} else {
			$result = $db->prep_query($db->returnQuery('query_13'), $param);
		}
		
		$last_id = $db->last_id();
		
		$param = 'set&' . $last_id . '&INT;';
		$param .= 'date&' . calldate() . '&STR;';
		$param .= 'stand&' . (int) $_POST['stand_list'] . '&INT;';
		$param .= 'id_user&' . $_SESSION['id_acc'] . '&INT';
		
		$result = $db->prep_query($db->returnQuery('query_14'), $param);
		
		$db->commit();
		
	} catch(PDOexception $error) {
		$db->rollBack();
		echo $error->getMessage();
		exit;
	}
	
	if($db->readCount() == 1){
		?>
		
		<script>
			id_set = '<?= $last_id; ?>';
			info_er = '<?= $LNG['err_load']; ?>';
			
			$.post("editset.php", {id_set: id_set})
				.done(function(data){
					$("#main_panel").html(data);
				})
				.fail(function(){
					$("#main_panel").html(info_er);
				});
				
		</script>
		
		<?php
	} else {
		showInfo("$('.help-block').eq(3)", $LNG['err_create']);	
	}
	
	
	
} else {
	
	$stand_list = $db->fetch_exception($db->returnQuery('query_9'));
	
	$model_list = $db->fetch_exception($db->returnQuery('query_16'));
	
	require_once(ROOT_PATH . TEMPLATE_DIR . 'newset.tpl');
}

?>