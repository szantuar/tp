<?php
$lang_file = 'parts';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
access_denied('setedit', $LNG);

resultFalseArg(isset($_POST['pn']), "$('.help-block').eq(0)", $LNG['empty']);
resultFalseArg(isset($_SESSION['load']), "$('.help-block').eq(0)", $LNG['empty2']);
resultFalseArg(isset($_SESSION['pn_data']), "$('.help-block').eq(0)", $LNG['incorrect_PN']);

//validation PN
resultFalseArg($_POST['pn'] == $_SESSION['pn_data']['part_number'], "$('.help-block').eq(0)", $LNG['incorrect_PN']);

//validation qty
resultFalseArg($_SESSION['pn_data']['qty'] > 0 , "$('.help-block').eq(0)", $LNG['incorrect_qty']);

try {
	$db->beginTransaction();
	
	$param = 'id_set&' . (int)$_SESSION['load'] . '&INT;';
	$param .= 'id_pn&' . (int)$_SESSION['pn_data']['id'] . '&INT;';
	$param .= 'sn&empty-' . $_SESSION['load'] . '&STR;';
	$param .= 'type&21&INT;';
	$param .= 'date&' . calldate() . '&STR;';
	$param .= 'id_acc&' . $_SESSION['id_acc'] . '&STR';
	$result = $db->prep_query($db->returnQuery('query_102'), $param);
	
	$last_id = $db->last_id();
	
	//add new parts undercheck
	$param = 'id_hist&' . $last_id . '&INT;';
	$param .= 'date&' . calldate() . '&STR';
	
    $db->prep_query($db->returnQuery('query_99'), $param);
    
    if($db->CountRow() == 0){
		$db->prep_query($db->returnQuery('query_98'), $param);
    }	
	
	$param = 'id_set&' . $_SESSION['load'] . '&INT;';
	$param .= 'id_history&' . $last_id . '&INT';
        
    $result = $db->prep_query($db->returnQuery('query_22'), $param);
        
    if($db->CountRow() == 0) {
        $db->prep_query($db->returnQuery('query_23'), $param);
    }  
	
	$db->commit();
	
}catch (PDOexception $error) {
	$db->rollBack();
	echo $error->getMessage();
	exit;
}
//87115400045
?>

<tr id='tb_tr_<?= $last_id ; ?>'>
    <td><?= $_SESSION['pn_data']['part_number'] ?></td>
    <td><?= $_SESSION['pn_data']['description'] ?></td>
    <td>---</td>
	<td><input type="text" id="tb_sn_<?= $last_id; ?>" name="tb_sn_<?= $last_id; ?>" placeholder="" class="input-xlarge" value="empty-<?= $_SESSION['load']; ?>" disabled=""></td>
    <td>
		<div class="mytooltip">
			<img class="pn_action_remove" onClick="pn_action_remove('<?= $LNG['pn_remove']; ?>')" src="img/remove.gif" id="pn_remove">
			<span class="mytooltiptext"><?= $LNG['tip3']; ?></span>
		</div>
    </td>
</tr>

<script>
    $('#tb_pn').val('');
    $('#tb_desc').html('');
    $('#tb_oh').html('');
    $('#tb_sn').val('');
</script>
