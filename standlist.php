<?php

$lang_file = 'testrig';
require_once('common.php');

$lang->includeLang($lang_file);



if(isset($_POST['search'])) {
       require_once(ROOT_PATH . INCLUDE_DIR . 'standlist_load.php');
} else {

    headline($LNG['stand_headline']);
    search_input($LNG['tip5']);

    ?>
    <table class="table">
        <tbody id="tb_set">

        <?php

        require_once(ROOT_PATH . INCLUDE_DIR . 'standlist_load.php');

        ?>
         </tbody>
    </table>

    <script>
    add_listener(document.getElementById("searchset"), 'standlist');
    </script>

    <?php
}

?>