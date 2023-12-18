<?php

?>

<tr>
    <td><?= $LNG['stand']; ?></td>
    <td><?= $LNG['desc']; ?></td>
    <td><?= $LNG['model']; ?></td>
</tr>

<?php

$empty = (isset($_POST['search'])) ? is_empty($_POST['search']) : false;

if($empty == true) {
	$param = "search&" . htmlentities($_POST['search']) . "&STR";
	$listset = $db->prep_exception($db->returnQuery('query_72'), $param);
	$mess = $LNG['empty3'];

} else {
	$listset = $db->fetch_exception($db->returnQuery('query_1'));
	$mess = $LNG['empty'];
}

empty_data(array(empty($listset), $mess, 4));

foreach($listset AS $list) {

	$str = "<tr id='" . $list['id_stand'] . "'>";
    $str .= "<td>" . $list['stand']	 . "</td>";
	$str .= "<td>" . $list['description'] . "</td>";
	$str .= "<td>" . $list['name'] . "</td>";	
	$str .= "</tr>";
	echo $str;
	} 

?>

<script>
$("tr").click(function(){	

	stand = $(this).attr('id');			
	info_er = '<?= $LNG['err_stand_2']; ?>';

	$.post("set.php", {stand: stand})
		.done(function(data){
			$("#main_panel").html(data);
		})
		.fail(function(){
			$("#main_panel").html(info_er);
		});

	
});
</script>