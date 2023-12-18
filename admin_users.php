<?php
$lang_file = 'admin';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

access_denied('newuser', $LNG);


if(isset($_POST['search'])) {
	require_once(ROOT_PATH . INCLUDE_DIR . 'user_load.php');
}


if(isset($_POST['name_user'])) {
	require_once(ROOT_PATH . INCLUDE_DIR . 'user_add.php');
}

if(isset($_POST['id_user'])) {
	require_once(ROOT_PATH . INCLUDE_DIR . 'user_status.php');
}

if(isset($_POST['reset_user'])) {
	require_once(ROOT_PATH . INCLUDE_DIR . 'user_reset.php');	
}


if(empty($_POST)){
	search_input($LNG['tip17']);
	
	require_once(ROOT_PATH . TEMPLATE_DIR . 'new_user.tpl');
        
        ?>
		<div class="option_card">
			<div class="option_table">
				<table class="table">
					<tbody id="tb_set">
						
					<?php
					require_once(ROOT_PATH . INCLUDE_DIR . 'user_load.php');	
					?>
						
					</tbody>
				</table>
			</div>
		</div>

        <script>
        add_listener(document.getElementById("searchset"), 'admin_users');
        </script>
        <?php
}


?>