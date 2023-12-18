<?php
$lang_file = 'parts';
require_once('common.php');

$lang->includeLang($lang_file);

if(isset($_POST['stand'])){
	$_SESSION['stand'] = $_POST['stand'];
}

info_alert(isset($_SESSION['stand']), $LNG['empty2']);

$param = 'stand&' . (int)$_SESSION['stand'] . '&INT';
$sets = $db->prep_exception($db->returnQuery('query_37'), $param);

info_alert(!empty($sets), $LNG['empty3']);
?>
<div class="control-group">
	<h2><?= $LNG['setlist']; ?></h2>
	<p class="help-block"></p>
</div>

<?php


$str = '';
foreach($sets AS $list_set) {
	$str .= "<span class='border border-secondary stand_panel' id='" . $list_set['id_set'] . "'>" . $list_set['description'] . "</span>";
}

echo $str;

?>

</div>
<script>

$(".stand_panel").click(function(event){
	set_id = $(this).attr('id');
	info_er = '<?= $LNG['set_error'] ?>';
	
	$.post("setparts.php", {set_id: set_id})
		.done(function(data){
			$("#second_panel").html(data);
		})
		.fail(function(){
			$("#second_panel").html(info_er);
		});
		

});
</script>

<div id="second_panel">
</div>