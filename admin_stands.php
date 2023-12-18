<?php
$lang_file = 'admin';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

access_denied('newstand', $LNG);

if(isset($_POST['search'])) {
       require_once(ROOT_PATH . INCLUDE_DIR . 'stand_load.php');
}

if(isset($_POST['name_stand'])) {
        require_once(ROOT_PATH . INCLUDE_DIR . 'stand_add.php');
}
if(isset($_POST['id_stand'])) {
        require_once(ROOT_PATH . INCLUDE_DIR . 'stand_status.php');
}

if(empty($_POST)){
        search_input($LNG['tip16']);
        require_once(ROOT_PATH . TEMPLATE_DIR . 'new_stand.tpl');
        
        ?>
		<div class="option_card">
			<div class="option_table">
				<table class="table">
					<tbody id="tb_set">
						
					<?php
					require_once(ROOT_PATH . INCLUDE_DIR . 'stand_load.php');	
					?>
						
					</tbody>
				</table>
			</div>
		</div>

        <script>
        add_listener(document.getElementById("searchset"), 'admin_stands');
        </script>
        <?php
}

?>