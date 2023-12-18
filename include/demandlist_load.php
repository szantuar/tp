
<tr>
	<td>Set</td>
    <td><?= $LNG['pn']; ?></td>
    <td><?= $LNG['description']; ?></td>
    <td>OH</td>
    <td>SN</td>       
	<td><?= $LNG['date_send']; ?></td>
    <td><?= $LNG['action']; ?></td>
</tr>
	<tr>
		<td></td>
		<td><input type="text" id="tb_pn" name="tb_pn" placeholder="" class="input-xlarge"></td>
		<td id="tb_desc"></td>
		<td id="tb_oh"></td>
		<td><input type="text" id="tb_sn" name="tb_sn" placeholder="" class="input-xlarge"></td>
		<td></td>
		<td></td>
</tr>

<?php

$empty = (isset($_POST['search'])) ? is_empty($_POST['search']) : false;

if($empty == true) {
	$param = "search&" . htmlentities($_POST['search']) . "&STR";
	$list_demand = $db->prep_exception($db->returnQuery('query_73'), $param);
	$mess = $LNG['empty2'];

} else {
	$list_demand = $db->fetch_exception($db->returnQuery('query_46'));
	$mess = $LNG['list_empty'];
}

empty_data(array(empty($list_demand), $mess, 7));
    	
$db2 = new db_query('second');

foreach($list_demand AS $list){
	$param = 'id_pn&' . (int)$list['id_pn'] . '&INT';
	$result = $db2->prep_query($db->returnQuery('query_19'), $param);
	
	if($list['status'] == 2) {
		?>
		<tr class="is_damaged" id='tb_tr_<?= $list['id_history_parts']; ?>'>
		<?php
	} else {
		?>
		<tr id='tb_tr_<?= $list['id_history_parts']; ?>'>
		<?php
	}
	?>
		<td><?= $list['id_set']; ?></td>
		<td><?= $result[0]['part_number']; ?></td>
		<td><?= $result[0]['description']; ?></td>
		<td>---</td>
		<td id="tb_sn_<?= $list['id_history_parts']; ?>" onClick="test()"><?= $list['sn']; ?></td>
		<td><?= $list['date_create']; ?></td>
		<td>
			<span id="tb_span_<?= $list['id_history_parts']; ?>" class="badge bg-success"><?= $LNG['fullfille']; ?></span>
			<div class="mytooltip">
				<img class="noneOH" src="img/empty.gif" id="tb_img_<?= $list['id_history_parts']; ?>">
				<span class="mytooltiptext"><?= $LNG['tip2']; ?></span></div>
			</div>
			<div class="mytooltip">
				<img class="wr_img" src="img/back.gif" id="wr_img_<?= $list['id_history_parts']; ?>">
				<span class="mytooltiptext"><?= $LNG['tip3']; ?></span></div>
			</div>
		</td>
	</tr>       
	<?php
	}

?>

<script>
$('#tb_pn').change(function(){
    clear_info('.help-block');
	
    pn = $(this).val();
    if(pn !== '') {
	$('#tb_desc').html('');
	$('#tb_oh').html('');
		
	$.post("setparts_checkPN.php",{pn: pn})
            .done(function(data){
		$('#tb_set').append(data);
            })
            .fail(function(){
		$('.help-block').eq(0).html('<?= $LNG['add_error']; ?>');
            });
    } 
});

$(".bg-success").click(function(event){
    id_span = $(this).attr('id');
    id_hist = id_span.replace('tb_span_', '');
    sn = $('#tb_sn').val();
    info_er = '<?= $LNG['req_error'] ?>';
    
    $.post("setparts_fulfill.php", {id_hist: id_hist, sn: sn})
        .done(function(data){
            $("#tb_set").append(data);
        })
        .fail(function(){
            $(".help-block").eq(0).html(info_er);
        });
});

$(".noneOH").click(function(event){
	id_img = $(this).attr('id');
	id_hist = id_img.replace('tb_img_', '');
	
	info_er = '<?= $LNG['req_error3'] ?>';
	
	$.post("setparts_noneOH.php", {id_hist: id_hist})
        .done(function(data){
            $("#tb_set").append(data);
        })
        .fail(function(){
            $(".help-block").eq(0).html(info_er);
        });
});

$(".wr_img").click(function(event){
	id_img = $(this).attr('id');
	id_hist = id_img.replace('wr_img_', '');
	
	info_er = '<?= $LNG['req_error4'] ?>';
	
	$.post("setparts_backdamage.php", {id_hist: id_hist})
        .done(function(data){
            $("#tb_set").append(data);
        })
        .fail(function(){
            $(".help-block").eq(0).html(info_er);
        });
});


</script>