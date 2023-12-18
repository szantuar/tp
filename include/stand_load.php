<?php

?>

<tr>
    <td><?= $LNG['name'] ?></td>
    <td><?= $LNG['model_status']; ?></td>
</tr>

<?php

$empty = (isset($_POST['search'])) ? is_empty($_POST['search']) : false;

if($empty == true) {
	$param = "search&" . htmlentities($_POST['search']) . "&STR";
	$listmodel = $db->prep_exception($db->returnQuery('query_80'), $param);
	$mess = $LNG['stand_err3'];

} else {
	$listmodel = $db->fetch_exception($db->returnQuery('query_15'));
	$mess = $LNG['stand_err4'];
}

empty_data(array(empty($listmodel), $mess, 2));

foreach($listmodel AS $list) {
		
	$str = "<tr>";
        $str .= "<td>" . $list['name'] . "</td>";
        if($list['status'] == 0) {
            $str .= "<td><span id='tb_span_" . $list['id_stand'] ."' class='badge bg-danger'>" . $LNG['notactive'] . "</span></td>";  
        } else {
            $str .= "<td><span id='tb_span_" . $list['id_stand'] ."' class='badge bg-success'>" . $LNG['active'] . "</span></td>";  
        }    
        $str .= "</tr>";
	echo $str;	
}  

?>

<script>
$('.bg-success, .bg-danger').click(function(event) {
	id_stand = $(this).attr('id');
        info_er = '<?= $LNG['model_err4']; ?>';
	
	$.post("admin_stands.php", {id_stand: id_stand})
		.done(function(data){
			$("#tb_set").append(data);
		})
		.fail(function(){
			$('.help-block').eq(0).html(info_er);
		});
});
   
</script>