<?php

clear_info("$('.help-block')");

resultFalseArg(isset($_POST['id_user']), "$('.help-block').eq(3)", $LNG['user_err4']);

$span = $_POST['id_user'];
$id = (int)substr($_POST['id_user'], 8);

$param = 'id_user&' . $id . '&INT';
$user_info = $db->prep_exception($db->returnQuery('query_87'), $param);
resultFalseArg(!empty($user_info), "$('.help-block').eq(3)", $LNG['user_err4']);
resultFalseArg(!($user_info[0]['name'] == 'admin'), "$('.help-block').eq(3)", $LNG['user_err7']);


try{
    $db->beginTransaction();
    
    $status = ($user_info[0]['status'] == 0) ? 1 : 0;
    $param = 'status&' . $status . '&INT;';
    $param .= 'id_user&' . $id . '&INT';
    $db->prep_query($db->returnQuery('query_88'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['user_err8']);
    
    $transaction = ($user_info[0]['status'] == 0) ? 16 : 17;
    $param = 'uid_user&' . $id . '&INT;';
    $param .= 'date&' . calldate() . '&STR;';
    $param .= 'type&' . $transaction . '&INT;';
    $param .= 'id_acc&' . $_SESSION['id_acc'] . '&INT';
    $db->prep_query($db->returnQuery('query_84'), $param);
    
    resultFalseArg($db->CountRow() > 0, "$('.help-block').eq(3)", $LNG['user_err8']);
    
    $db->commit();    
} catch (PDOexception $error) {
     $db->rollBack();
     echo $error->getMessage();
    exit;
}

?>

<script>
    $("#<?= $span; ?>").addClass("<?= ($user_info[0]['status'] == 0) ? 'bg-success' : 'bg-danger'; ?>");
    $("#<?= $span; ?>").removeClass("<?= ($user_info[0]['status'] == 0) ? 'bg-danger' : 'bg-success'; ?>");
    $("#<?= $span; ?>").html("<?= ($user_info[0]['status'] == 0) ? $LNG['active'] : $LNG['notactive']; ?>");
</script>