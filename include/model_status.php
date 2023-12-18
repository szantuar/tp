<?php

clear_info("$('.help-block')");
$span = $_POST['id_model'];
$id = (int)substr($_POST['id_model'], 8);

resultFalseArg(isset($_POST['id_model']), "$('.help-block').eq(4)", $LNG['model_err6']);
$param = 'id&' . $id . '&INT';
$model_info = $db->prep_exception($db->returnQuery('query_77'), $param);
resultFalseArg(!empty($model_info), "$('.help-block').eq(4)", $LNG['model_err6']);

$param = 'id_model&' . $id . '&INT';
$active_set = $db->prep_exception($db->returnQuery('query_90'), $param);
resultFalseArg(empty($active_set), "$('.help-block').eq(4)", $LNG['model_err8']);


try{
    $db->beginTransaction();
    
    $status = ($model_info[0]['status'] == 0) ? 1 : 0;
    $param = 'status&' . $status . '&INT;';
    $param .= 'id_model&' . $id . '&INT';
    $db->prep_query($db->returnQuery('query_78'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(4)", $LNG['model_err7']);
    
    $transaction = ($model_info[0]['status'] == 0) ? 16 : 17;
    $param = 'id_model&' . $id . '&INT;';
    $param .= 'date&' . calldate() . '&STR;';
    $param .= 'type&' . $transaction . '&INT;';
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
    $db->prep_query($db->returnQuery('query_79'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(4)", $LNG['model_err7']);
    
    $db->commit();    
} catch (PDOexception $error) {
     $db->rollBack();
     echo $error->getMessage();
    exit;
}

?>

<script>
    $("#<?= $span; ?>").addClass("<?= ($model_info[0]['status'] == 0) ? 'bg-success' : 'bg-danger'; ?>");
    $("#<?= $span; ?>").removeClass("<?= ($model_info[0]['status'] == 0) ? 'bg-danger' : 'bg-success'; ?>");
    $("#<?= $span; ?>").html("<?= ($model_info[0]['status'] == 0) ? $LNG['active'] : $LNG['notactive']; ?>");
</script>

