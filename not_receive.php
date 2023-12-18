<?php

$lang_file = 'request';
require_once('common.php');

$lang->includeLang($lang_file);

is_session();
access_denied('demand', $LNG);

if(isset($_POST['search'])) {
    require_once(ROOT_PATH . INCLUDE_DIR . 'not_receive_load.php');
} else {

    headline($LNG['not_receive']);
    search_input($LNG['tip1']);

    ?>

    <script src="js/js_addpn.js"></script>

    <table class="table">
        <tbody id="tb_set">

        <?php

        require_once(ROOT_PATH . INCLUDE_DIR . 'not_receive_load.php');

        ?>
        </tbody>
    </table>

    <script>
        add_listener(document.getElementById("searchset"), 'not_receive');
    </script>
    <?php
}


?>