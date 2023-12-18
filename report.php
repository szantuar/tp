<?php

$lang_file = 'report';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

include_once(ROOT_PATH . TEMPLATE_DIR . 'report.tpl');

?>

<div id='rep_pancel'>

</div>