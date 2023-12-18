<?php

$lang_file = 'testrig';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
	
access_denied('setlist', $LNG);

if(isset($_POST['search'])) {
       require_once(ROOT_PATH . INCLUDE_DIR . 'setlist_load.php');
} else {

    headline($LNG['set_headline']);
    search_input($LNG['tip4']);

    ?>
    <table class="table">
        <tbody id="tb_set">

        <?php

        require_once(ROOT_PATH . INCLUDE_DIR . 'setlist_load.php');

        ?>
         </tbody>
    </table>

    <script>
    add_listener(document.getElementById("searchset"), 'setlist');
    </script>

    <?php
};

?>