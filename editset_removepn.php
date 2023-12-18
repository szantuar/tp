<?php

$lang_file = 'parts';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();
access_denied('setedit', $LNG);

resultFalseArg(isset($_POST['id_his']), "$('.help-block').eq(0)", $LNG['err_his']);

$id = str_replace('tb_tr_', '', $_POST['id_his']);
$param = 'id_his&' . (int)$id . '&INT';
$his_data = $db->prep_exception($db->returnQuery('query_27'), $param);
resultFalseArg(!empty($his_data), "$('.help-block').eq(0)", $LNG['err_his']);

try{

	$db->beginTransaction();
	
	$param = 'id_set&' . $his_data[0]['id_set'] . '&INT;';
	$param .= 'id_his&' . (int)$id . '&INT';
	$damaged = $db->prep_query($db->returnQuery('query_28'), $param);
	
	resultFalseArg(empty($damaged), "$('.help-block').eq(0)", $LNG['pn_remove_err']);
	
    $param = 'id_set&' . $his_data[0]['id_set'] . '&INT;';
    $param .= 'id_pn&' . $his_data[0]['id_pn'] . '&INT;';
    $param .= 'sn&' . $his_data[0]['sn'] . '&STR;';
	$param .= 'type&7&INT;';
    $param .= 'date&' . calldate() . '&STR;';
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
    	
    $result = $db->prep_query($db->returnQuery('query_102'), $param);
    
    if($db->CountRow() == 0) {
		throw new Exception('error with remove');
	}
	
	$param = 'old_history&' . $his_data[0]['id_history'] . '&INT';
    $result = $db->prep_query($db->returnQuery('query_100'), $param);
	
    $param = 'old_history&' . $his_data[0]['id_history'] . '&INT';
    $result = $db->prep_query($db->returnQuery('query_30'), $param);
    
    if($db->readCount() != 0){
        ?>
        <script>
            $('#<?= $_POST['id_his']; ?>').remove();
			$('.help-block').eq(0).html('<?= $LNG['pn_success']; ?>');
        </script>
        <?php
    } else {
        showInfo("$('.help-block').eq(0)",$LNG['pn_fail']);
    } 
    
    $db->commit();
	
}catch (PDOexception $error) {
	$db->rollBack();
	echo $error->getMessage();
	exit;
}

?>