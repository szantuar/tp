<?php

$lang_file = 'parts';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
access_denied('setremove', $LNG);

info_alert(isset($_POST['id_set']), $LNG['error_set1']);

$param = 'id_set&' . (int) $_POST['id_set'] . '&INT';
$set = $db->prep_exception($db->returnQuery('query_17'), $param);

info_alert(!empty($set), $LNG['error_set2']);

unset($_SESSION['pn_data']);
$_SESSION['load'] = (int) $_POST['id_set'];

headline($LNG['set_edit']);

require_once(ROOT_PATH . TEMPLATE_DIR . 'partsload.tpl');
?>
	
<script src="js/js_addpn.js"></script>

<p class="help-block"></p>
<table class="table">
	<tbody id="tb_set">
		<tr>
			<td><?= $LNG['pn']; ?></td>
			<td><?= $LNG['description']; ?></td>
			<td>OH</td>
			<td> SN </td>
			<td>action</td>
		</tr>	
		<tr>
			<td><input type="text" id="tb_pn" name="tb_pn" placeholder="" class="input-xlarge"></td>
			<td id="tb_desc"></td>
			<td id="tb_oh"></td>
			<td><input type="text" id="tb_sn" name="tb_sn" placeholder="" class="input-xlarge" disabled=""></td>
			<td>
				<div class="mytooltip">
					<img id="add_pn" onClick="add_PN('<?= $LNG['add_error']; ?>')" src="img/add.gif">
					<span class="mytooltiptext"><?= $LNG['tip1']; ?></span>
				</div>
			</td>
		</tr>
		<?php
		
		$param = 'id_set&' . (int)$_SESSION['load'] . '&INT';
		$parts_set = $db->prep_exception($db->returnQuery('query_18'), $param);
		
		$db2 = new db_query('second');
		if(!empty($parts_set)) {
				foreach($parts_set AS $list){
					$param = 'id_pn&' . (int)$list['id_pn'] . '&INT';
					$result = $db2->prep_exception($db->returnQuery('query_19'), $param);
					?>
					<tr id='tb_tr_<?= $list['id_history_parts']; ?>'>
						<td><?= $result[0]['part_number']; ?></td>
						<td><?= $result[0]['description']; ?></td>
						<td>---</td>
						<td><input type="text" id="tb_sn_<?= $list['id_history_parts']; ?>" name="tb_sn_<?= $list['id_history_parts']; ?>" placeholder="" class="input-xlarge" value='<?= $list['sn']; ?>' disabled=""></td>
						<td>
							<div class="mytooltip">
								<img class="pn_action_remove" onClick="pn_action_remove('<?= $LNG['pn_remove']; ?>')" src="img/remove.gif" id="pn_remove">
								<span class="mytooltiptext"><?= $LNG['tip3']; ?></span>
							</div>
						</td>
					</tr>       
					<?php
				}
		}
		
		?>
	</tbody>
</table>

<script>


$('#tb_pn').change(function(){
	checkPN();
});

function checkPN(){
	clear_info('.help-block');
	
	pn = $('#tb_pn').val();
	if(pn !== '') {
		$('#tb_desc').html('');
		$('#tb_oh').html('');
		
		$.post("editset_checkPN.php",{pn: pn})
			.done(function(data){
				$('#tb_set').append(data);
			})
			.fail(function(){
				$('.help-block').eq(0).html('<?= $LNG['add_error']; ?>');
			});
	} 	
}

</script>

