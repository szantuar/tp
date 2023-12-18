<?php

clear_info("$('.help-block')");

$span = $_POST['id_stand'];
$id = (int)substr($_POST['id_stand'], 8);

resultFalseArg(isset($_POST['id_stand']), "$('.help-block').eq(3)", $LNG['stand_err6']);
$param = 'id&' . $id . '&INT';
$stand_info = $db->prep_exception($db->returnQuery('query_81'), $param);
resultFalseArg(!empty($stand_info), "$('.help-block').eq(3)", $LNG['stand_err6']);
resultFalseArg(!($stand_info[0]['name'] == 'empty'), "$('.help-block').eq(3)", $LNG['stand_err8']);

$param = 'id_stand&' . $id . '&INT';
$active_set = $db->prep_exception($db->returnQuery('query_91'), $param);
resultFalseArg(empty($active_set), "$('.help-block').eq(3)", $LNG['stand_err9']);

try{
    $db->beginTransaction();
    
    $status = ($stand_info[0]['status'] == 0) ? 1 : 0;
    $param = 'status&' . $status . '&INT;';
    $param .= 'id_stand&' . $id . '&INT';
    $db->prep_query($db->returnQuery('query_82'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['stand_err7']);
    
    $transaction = ($stand_info[0]['status'] == 0) ? 16 : 17;
    $param = 'id_stand&' . $id . '&INT;';
    $param .= 'date&' . calldate() . '&STR;';
    $param .= 'type&' . $transaction . '&INT;';
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
    $db->prep_query($db->returnQuery('query_83'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['stand_err7']);
    
    $db->commit();    
} catch (PDOexception $error) {
     $db->rollBack();
     echo $error->getMessage();
    exit;
}

?>

<script>
    $("#<?= $span; ?>").addClass("<?= ($stand_info[0]['status'] == 0) ? 'bg-success' : 'bg-danger'; ?>");
    $("#<?= $span; ?>").removeClass("<?= ($stand_info[0]['status'] == 0) ? 'bg-danger' : 'bg-success'; ?>");
    $("#<?= $span; ?>").html("<?= ($stand_info[0]['status'] == 0) ? $LNG['active'] : $LNG['notactive']; ?>");
</script>