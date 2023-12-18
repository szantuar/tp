
<tr>
    <?php
    
    tooltip('person.gif', $LNG['tip1']);
    tooltip('setlist.gif', $LNG['tip2']);
    tooltip('setlist_edit.gif', $LNG['tip3']);
    tooltip('add.gif', $LNG['tip4']);
    tooltip('edit.gif', $LNG['tip5']);
    tooltip('close.gif', $LNG['tip6']);
    tooltip('demand.gif', $LNG['tip7']);
    tooltip('QA.gif', $LNG['tip8']);
    tooltip('password.gif', $LNG['tip9']);
    tooltip('addperson.gif', $LNG['tip10']);
    tooltip('model.gif', $LNG['tip11']);
    tooltip('newstand.gif', $LNG['tip12']);
    tooltip('reset_password.png', $LNG['tip13']);
    tooltip('add_access.gif', $LNG['tip14']); 
    
    ?>
</tr>
<?php

$empty = (isset($_POST['search'])) ? is_empty($_POST['search']) : false;

if($empty == true) {
	$param = "search&" . htmlentities($_POST['search']) . "&STR";
	$full_access = $db->prep_exception($db->returnQuery('query_89'), $param);
	$mess = $LNG['user_err4'];

} else {
	$full_access = $db->fetch_exception($db->returnQuery('query_66'));
	$mess = $LNG['user_empty'];
}

empty_data(array(empty($full_access), $mess, 14));

foreach($full_access AS $list){
    $str = "<tr>";
    $str .= "<td>" . $list['name'] . "</td>";
    $str .= "<td class='td_icon' id='td_01_" . $list['id_user'] . "'>" . access($list['setlist'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip2_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_02_" .$list['id_user'] . "'>" . access($list['newset'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip3_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_03_" .$list['id_user'] . "'>" . access($list['standchange'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip4_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_04_" .$list['id_user'] . "'>" . access($list['setedit'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip5_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_05_" .$list['id_user'] . "'>" . access($list['setremove'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip6_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_06_" .$list['id_user'] . "'>" . access($list['demand'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip7_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_07_" .$list['id_user'] . "'>" . access($list['QA'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip8_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_08_" .$list['id_user'] . "'>" . access($list['password'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip9_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_09_" .$list['id_user'] . "'>" . access($list['newuser'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip10_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_10_" .$list['id_user'] . "'>" . access($list['newmodel'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip11_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_11_" .$list['id_user'] . "'>" . access($list['newstand'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip12_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_12_" .$list['id_user'] . "'>" . access($list['resetpassword'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip13_1']) . "</td>";
    $str .= "<td class='td_icon' id='td_13_" .$list['id_user'] . "'>" . access($list['addaccess'], array($LNG['tip0_1'], $LNG['tip0_2']), $LNG['tip14_1']) . "</td>";
    $str .= "</tr>";
                    
    echo $str;                  
}
?>
<script>
$('.td_icon').click(function(){
    $('.help-block').html('');
    id = $(this).attr('id');   
    er_info = '<?= $LNG['admin_load']; ?>';
  
    $.post("admin_accessupdate.php",{id: id})
        .done(function(data){
            $('#tb_set').append(data);
        })
        .fail(function(){
            $('.help-block').eq(1).html(er_info);
        });
});
</script>