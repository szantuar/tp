<?php
$lang_file = 'admin';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

access_denied('addaccess', $LNG);

headline($LNG['permission']);

if(isset($_POST['search'])) {
       require_once(ROOT_PATH . INCLUDE_DIR . 'admin_access_load.php');
}

if(empty($_POST)){
    search_input($LNG['tip17']);
    ?>
    <div class="control-group">
	<h2><?= $LNG['list_users']; ?></h2>	
	<p class="help-block"></p>
    </div>

    <table class="table">
	<tbody id="tb_set">
            <?php
                require_once(ROOT_PATH . INCLUDE_DIR . 'admin_access_load.php');
            ?>
        </tbody>
    </table>

    <script>
    add_listener(document.getElementById("searchset"), 'admin_access');
    </script>
<?php
}
?>
