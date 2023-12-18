<?php

?>

<tr>
    <td><?= $LNG['model_name']; ?></td>
    <td><?= $LNG['model_client']; ?></td>
    <td><?= $LNG['model_status']; ?></td>
</tr>

<?php

$empty = (isset($_POST['search'])) ? is_empty($_POST['search']) : false;

if($empty == true) {
	$param = "search&" . htmlentities($_POST['search']) . "&STR";
	$listmodel = $db->prep_exception($db->returnQuery('query_76'), $param);
	$mess = $LNG['model_err2'];

} else {
	$listmodel = $db->fetch_exception($db->returnQuery('query_75'));
	$mess = $LNG['model_err3'];
}

empty_data(array(empty($listmodel), $mess, 3));

foreach($listmodel AS $list) {
		
	$str = "<tr>";
        $str .= "<td>" . $list['name'] . "</td>";
	$str .= "<td>" . $list['client'] . "</td>";
        if($list['status'] == 0) {
            $str .= "<td><span id='tb_span_" . $list['id_model'] ."' class='badge bg-danger'>" . $LNG['notactive'] . "</span></td>";  
        } else {
            $str .= "<td><span id='tb_span_" . $list['id_model'] ."' class='badge bg-success'>" . $LNG['active'] . "</span></td>";  
        }    
        $str .= "</tr>";
	echo $str;	
}  

?>

<script>
$('.bg-success, .bg-danger').click(function(event) {
	id_model = $(this).attr('id');
        info_er = '<?= $LNG['model_err4']; ?>';
	
	$.post("admin_models.php", {id_model: id_model})
		.done(function(data){
			$("#tb_set").append(data);
		})
		.fail(function(){
			$('.help-block').eq(0).html(info_er);
		});
});
   
</script>