<?php

$lang_file = 'request';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

resultFalseArg(isset($_POST['pn']), "$('.help-block').eq(0)", $LNG['empty']);

$db2 = new db_query('second');

$param = 'pn&' . $_POST['pn'] . '&STR';
$pn_info = $db2->prep_exception($db->returnQuery('query_20'), $param);

if(!empty($pn_info)) {	
	$_SESSION['pn_data']['id'] = $pn_info[0]['id'];
	$_SESSION['pn_data']['pn'] = $pn_info[0]['part_number'];
	$_SESSION['pn_data']['desc'] = $pn_info[0]['description'];
	
	$qty = 0;
	$str = '';
	foreach($pn_info AS $data){
		if($data['qty'] > 0) {
			$str .= $data['name'] . ' - ' . (int)$data['qty'] . '<br>';
			$qty += (int)$data['qty'];			
		}
	}	
	$_SESSION['pn_data']['qty'] = $qty;
	$str = ($str == '') ? 0 : $str;

	?>
	<script>
            editset_pn("<?= $pn_info[0]['description']; ?>","<?= $str; ?>");
	</script>
	<?php
} else {
	showInfo("$('.help-block').eq(0)",$LNG['empty']);
}

?>