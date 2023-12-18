<?php

$lang_file = 'request';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
access_denied('QA', $LNG);

if(isset($_POST['search'])) {
	require_once(ROOT_PATH . INCLUDE_DIR . 'underchecklist_load.php');
} else {
	
	headline($LNG['qa_list']);
	search_input($LNG['tip1']);

	?>
	
	<script src="js/js_addpn.js"></script>
	
	<table class="table">
		<tbody id="tb_set">
	
		<?php
	
		require_once(ROOT_PATH . INCLUDE_DIR . 'underchecklist_load.php');
		
		?>
		</tbody>
	</table>
	
	<script>
	add_listener(document.getElementById("searchset"), 'setparts_undercheck');
	</script>
	<?php 
}	

?>