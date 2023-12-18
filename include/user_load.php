<?php

?>

<tr>
    <td><?= $LNG['name'] ?></td>
    <td><?= $LNG['model_status']; ?></td>
	<td><img src="img/click.gif" alt="<?= $LNG['action']; ?>"></td>
</tr>

<?php

$empty = (isset($_POST['search'])) ? is_empty($_POST['search']) : false;

if($empty == true) {
	$param = "search&" . htmlentities($_POST['search']) . "&STR";
	$listuser = $db->prep_exception($db->returnQuery('query_86'), $param);
	$mess = $LNG['user_err4'];

} else {
	$listuser = $db->fetch_exception($db->returnQuery('query_85'));
	$mess = $LNG['user_err3'];
}

empty_data(array(empty($listuser), $mess, 3));

foreach($listuser AS $list) {
		
	$str = "<tr>";
        $str .= "<td>" . $list['name'] . "</td>";
        if($list['status'] == 0) {
            $str .= "<td><span id='tb_span_" . $list['id_user'] ."' class='badge bg-danger'>" . $LNG['notactive'] . "</span></td>";  
        } else {
            $str .= "<td><span id='tb_span_" . $list['id_user'] ."' class='badge bg-success'>" . $LNG['active'] . "</span></td>";  
        }
		$str .= "<td><div class='mytooltip'><img src='img/reset_password.png' class='access_icon' id='tb_span_" . $list['id_user'] ."'><span class='mytooltiptext'>" . $LNG['tip13'] . "</span></div></td>";
        $str .= "</tr>";
	echo $str;	
}
?>

<script>
$('.bg-success, .bg-danger').click(function(event) {
	id_user = $(this).attr('id');
    info_er = '<?= $LNG['user_err5']; ?>';
	
	$.post("admin_users.php", {id_user: id_user})
		.done(function(data){
			$("#tb_set").append(data);
		})
		.fail(function(){
			$('.help-block').eq(3).html(info_er);
		});
});

$('.access_icon').click(function(event) {
	id_user = $(this).attr('id');
    info_er = '<?= $LNG['user_err6']; ?>';
	
	$.post("admin_users.php", {reset_user: id_user})
		.done(function(data){
			$("#tb_set").append(data);
		})
		.fail(function(){
			$('.help-block').eq(3).html(info_er);
		});
});

</script>