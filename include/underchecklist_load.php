
 <tr>
	<td>Set</td>
	<td><?= $LNG['pn']; ?></td>
	<td><?= $LNG['description']; ?></td>
	<td>SN</td>         
	<td><?= $LNG['date_send']; ?></td>		
	<td><?= $LNG['action']; ?></td>
</tr>

<?php

$empty = (isset($_POST['search'])) ? is_empty($_POST['search']) : false;

if($empty == true) {
	$param = "search&" . htmlentities($_POST['search']) . "&STR";
	$list_demand = $db->prep_exception($db->returnQuery('query_74'), $param);
	$mess = $LNG['empty2'];

} else {
	$list_demand = $db->fetch_exception($db->returnQuery('query_51'));
	$mess = $LNG['list_empty2'];
}

empty_data(array(empty($list_demand), $mess, 6));
        
$db2 = new db_query('second');

foreach($list_demand AS $list){
	$param = 'id_pn&' . (int)$list['id_pn'] . '&INT';
	$result = $db2->prep_exception($db->returnQuery('query_19'), $param);
	?>
	<tr id='tb_tr_<?= $list['id_history_parts']; ?>'>
		<td><?= $list['id_set']; ?></td>
		<td><?= $result[0]['part_number']; ?></td>
		<td><?= $result[0]['description']; ?></td>
		<td id="tb_sn_<?= $list['id_history_parts']; ?>"><?= $list['sn']; ?></td>
		<td><?= $list['date_create']; ?></td>
		<td>
			<span id="tb_span_<?= $list['id_history_parts']; ?>" class="badge bg-success"><?= $LNG['parts_good']; ?></span>
			<span id="tb_span_<?= $list['id_history_parts']; ?>" class="badge bg-danger"><?= $LNG['parts_fail']; ?></span>
			<span id="tb_span_<?= $list['id_history_parts']; ?>" class="badge bg-primary"><?= $LNG['parts_missing']; ?></span>
		</td>
	</tr>       
	<?php

}

?>

<script>
$("tr td span").click(function(event){
    id_span = $(this).attr('id');
    id_hist = id_span.replace('tb_span_', '');    
    info_er = '<?= $LNG['req_error2'] ?>';
    
	status = $(this).attr('class');
	
    $.post("setparts_QAfill.php", {id_hist: id_hist, status: status})
        .done(function(data){
            $("#tb_set").append(data);
        })
        .fail(function(){
            $(".help-block").eq(0).html(info_er);
        });

});
</script>