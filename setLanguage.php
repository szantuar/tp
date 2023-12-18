<?php
$lang_file = 'global';
require_once('common.php');

$lang->includeLang($lang_file);

if(isset($_POST['lang']))
	{	
	$lang->SetLang($_POST['lang']);
	
	echo "<script>
	window.location.reload();
	</script>";
	}
?>