
<tr>
	<td>Set</td>
	<td><?= $LNG['pn']; ?></td>
    <td><?= $LNG['description']; ?></td>
    <td>SN</td>
    <td><?= $LNG['date_send']; ?></td>
    <td><?= $LNG['missing_point']; ?></td>
    <td><?= $LNG['action']; ?></td>
</tr>

<?php

$empty = (isset($_POST['search'])) ? is_empty($_POST['search']) : false;

if($empty == true) {
    $param = "search&" . htmlentities($_POST['search']) . "&STR";
    $missing_list = $db->prep_exception($db->returnQuery('query_97'), $param);
    $mess = $LNG['empty2'];

} else {
    $missing_list = $db->fetch_exception($db->returnQuery('query_52'));
    $mess = $LNG['list_empty2'];
}

empty_data(array(empty($missing_list), $mess, 7));

$db2 = new db_query('second');

foreach($missing_list AS $list){
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
            <?php

            if($list['type_transaction'] == 25){
                echo 'QA';
            }

            if($list['type_transaction'] == 26){
                 echo 'WH';
            }

            ?>
        </td>
        <td>
            <span id="tb_span_<?= $list['id_history_parts']; ?>" class="badge bg-success"><?= $LNG['parts_receive']; ?></span>
            <span id="tb_span_<?= $list['id_history_parts']; ?>" class="badge bg-primary"><?= $LNG['parts_close']; ?></span>
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

        $.post("setparts_notreceivefill.php", {id_hist: id_hist, status: status})
            .done(function(data){
                $("#tb_set").append(data);
            })
            .fail(function(){
                $(".help-block").eq(0).html(info_er);
            });

    });
</script>
