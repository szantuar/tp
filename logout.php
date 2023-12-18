<?php

$lang_file = 'login';
require_once('common.php');

$lang->includeLang($lang_file);


$_SESSION = array();
//header("Refresh:0");
?>

<script>
location.reload();
</script>