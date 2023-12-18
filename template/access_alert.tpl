<?php

?>
<!--
<div class="modal" tabindex="-1" role="dialog" id="access_alert">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_1">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><?= $LNG['no_access']; ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_2"><?= $LNG['close']; ?></button>
      </div>
    </div>
  </div>
</div>
-->

<div class="alert alert-danger" role="alert">
  <?= $LNG['no_access']; ?>
</div>

<script>
/*
$('#access_alert').show();
$('.modal-header').css("border-bottom", "0px");
$('.modal-footer').css("border-top", "0px");

$('#close_1').click(function(event){
	$('#access_alert').remove();
});

$('#close_2').click(function(event){
	$('#access_alert').remove();
});
*/
</script>