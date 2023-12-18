<?php

$lang_file = 'parts';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();
access_denied('setedit', $LNG);

resultFalseArg(isset($_POST['pn']), "$('.help-block').eq(0)", $LNG['empty']);
resultFalseArg(isset($_SESSION['load']), "$('.help-block').eq(0)", $LNG['empty2']);

$db2 = new db_query('second');

$param = 'pn&' . $_POST['pn'] . '&STR';

$pn_info = $db2->prep_exception($db->returnQuery('query_20'), $param);

if(!empty($pn_info)) {
	$qty = 0;
	foreach($pn_info AS $data){
		if($data['qty'] > 0) {
			$qty += (int)$data['qty'];
		}
	}

	?>
	<script>
		editset_pn("<?= $pn_info[0]['description']; ?>","<?= $qty; ?>");
	</script>
	<?php
	$_SESSION['pn_data'] = $pn_info[0];
	$_SESSION['pn_data']['qty'] = $qty;
} else {
	showInfo("$('.help-block').eq(0)",$LNG['incorrect_PN']);
}

?>