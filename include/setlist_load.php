
<tr>
	<td>Set</td>
    <td><?= $LNG['stand']; ?></td>
    <td><?= $LNG['desc']; ?></td>
    <td><?= $LNG['client']; ?></td>
    <td><?= $LNG['model']; ?></td>
    <td><?= $LNG['who_create']; ?></td>
    <td><?= $LNG['date_create']; ?></td>
    <td><?= $LNG['usage']; ?></td>
    <td>
        <img src="img/click.gif" alt="<?= $LNG['action']; ?>">
    </td>
</tr>

<?php

$empty = (isset($_POST['search'])) ? is_empty($_POST['search']) : false;

if($empty == true) {
	$param = "search&" . htmlentities($_POST['search']) . "&STR";
	$listset = $db->prep_exception($db->returnQuery('query_71'), $param);
	$mess = $LNG['empty2'];

} else {
	$listset = $db->fetch_exception($db->returnQuery('query_4'));
	$mess = $LNG['empty4'];
}

empty_data(array(empty($listset), $mess, 8));
    	
$str = '';
foreach($listset AS $list) {
    if($list['damaged'] > 0) {
		$str = "<tr class='is_damaged' id='" . $list['id_set'] . "'>";
    } else {
		$str = "<tr id='" . $list['id_set'] . "'>"; 
    }
	$str .= "<td>" . $list['id_set'] . "</td>";
    $str .= "<td>";
			
    if($list['stand_name'] != 'empty') {
		$str .= $list['stand_name'];																
	} else {
		$str .= $LNG['stand_empty'];
	}
					
	$str .= "</td>";
	$str .= "<td id='" . $list['id_set'] . "_desc' class='desc01'>" . $list['description'] . "</td>";
	$str .= "<td id='" . $list['id_set'] . "_client'>" . $list['model_client'] . "</td>";
	$str .= "<td id='" . $list['id_set'] . "_model'>" . $list['model'] . "</td>";
	$str .= "<td>" . $list['user_name'] . "</td>";
	$str .= "<td>". substr($list['date_create'],0,10) . "</td>";
	$str .= "<td>";
				
	if($list['is_use'] == 0) {
		$str .= $LNG['no_use'];
	} else {
		$str .= $LNG['yes_use'];
	}			
					
	$str .= "</td>";
	$str .= "<td>";
	$str .= "<div class='mytooltip'><img class='stand_action' src='img/add.gif' alt='".$LNG['add']."' id='editset_standadd'><span class='mytooltiptext'>" . $LNG['tip1'] . "</span></div>";
	$str .= "<div class='mytooltip'><img class='stand_action' src='img/edit.gif' alt='".$LNG['edit']."' id='editset'><span class='mytooltiptext'>" . $LNG['tip2'] . "</span></div>";
	$str .= "<div class='mytooltip'><img class='stand_action' src='img/close.gif' alt='".$LNG['finish']."' id='editset_remove'><span class='mytooltiptext'>" . $LNG['tip3'] . "</span></div>";
				
				
	$str .= "</td></tr>";
	echo $str;
	}    

?>
<script>
$(".stand_action").click(function(){	
		
	id_set = $('tr:hover').attr('id');
	action = $(this).attr('id');
			
	desc = $('#'+id_set+'_desc').text();
	model = $('#'+id_set+'_model').text();
								
	info_er = '<?= $LNG['error_set']; ?>';

	$.post(action+".php", {action: action, id_set: id_set, model: model, desc: desc})
            .done(function(data){
		$("#main_panel").html(data);
            })
            .fail(function(){
		$("#main_panel").html(info_er);
            });
});
</script>