<?php
$lang_file = 'admin';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

access_denied('newmodel', $LNG);

if(isset($_POST['search'])) {
       require_once(ROOT_PATH . INCLUDE_DIR . 'model_load.php');
}

if(isset($_POST['name_model'])) {
        require_once(ROOT_PATH . INCLUDE_DIR . 'model_add.php');
}

if(isset($_POST['id_model'])) {
        require_once(ROOT_PATH . INCLUDE_DIR . 'model_status.php');
}

if(empty($_POST)){
    search_input($LNG['tip15']);
	$client_list = $db->fetch_exception("SELECT * FROM client;");	
	require_once(ROOT_PATH . TEMPLATE_DIR . 'new_model.tpl');
        
        ?>
		<div class="option_card">
			<div class="option_table">
				<table class="table">
					<tbody id="tb_set">
						
					<?php
					require_once(ROOT_PATH . INCLUDE_DIR . 'model_load.php');	
					?>
						
					</tbody>
				</table>
			</div>
		</div>

        <script>
        add_listener(document.getElementById("searchset"), 'admin_models');
        </script>
        <?php
}

?>