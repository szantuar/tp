<?php

$lang_file = 'parts';
require_once('common.php');

$lang->includeLang($lang_file);

clear_info("$('.help-block')");

info_alert(isset($_SESSION['stand']), $LNG['set_error1']);
info_alert(isset($_POST['set_id']), $LNG['empty2']);

info_alert(is_numeric($_POST['set_id']), $LNG['set_error2']);

$param = 'id_set&' . (int)$_POST['set_id'] . '&INT';
$parts_set = $db->prep_exception($db->returnQuery('query_38'), $param);

info_alert(!empty($parts_set), $LNG['set_error3']);

?>

<p class="help-block"></p>
<table class="table">
    <tbody id="tb_set">
        <tr>
            <td><?= $LNG['pn']; ?></td>
            <td><?= $LNG['description']; ?></td>
            <td>SN</td>
            <td><?= $LNG['status']; ?></td>
	</tr>	
	<?php
		
	$db2 = new db_query('second');

	foreach($parts_set AS $list){
            $param = 'id_pn&' . (int)$list['id_pn'] . '&INT';
            $result = $db2->prep_exception($db->returnQuery('query_19'), $param);
            ?>
            <tr id='tb_tr_<?= $list['id_history_parts']; ?>'>
                <td><?= $result[0]['part_number']; ?></td>
				<td><?= $result[0]['description']; ?></td>
				<td id="tb_sn_<?= $list['id_history_parts']; ?>"><?= $list['sn']; ?></td>
				<td>
                    <?php
                        if($list['is_damaged'] == 0) {
                            echo "<span id='tb_span_" .$list['id_history_parts'] . "' class='badge bg-success'>" . $LNG['parts_good'] . "</span>";
                        } else {
                            echo "<span id='tb_span_" .$list['id_history_parts'] . "' class='badge bg-danger'>" . $LNG['parts_fail'] . "</span>";
                        }
                    ?>

				</td>
            </tr>       
            <?php
	}
        ?>
	</tbody>
</table>

 <div class="control-group">
      <!-- Username -->
    <label class="control-label"  for="user"><?= $LNG['username']; ?>:</label>
    <div class="controls">
        <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
        <p class="help-block"></p>
    </div>
</div>

<script>

$(".bg-success").click(function(event){
	id_span = $(this).attr('id');
    id_hist = id_span.replace('tb_span_', '');
    user = $('#username').val();
	info_er = '<?= $LNG['set_error4'] ?>';
      
	$.post("setparts_isdamaged.php", {id_hist: id_hist, user: user})
            .done(function(data){
		$("#second_panel").append(data);
            })
            .fail(function(){
		$(".help-block").eq(1).html(info_er);
            });
});
</script>