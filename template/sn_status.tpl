<?php

?>

<div class="option_card">
    <div class="option_content">
        <div id="legend">
            <legend class=""><?php echo $LNG['sn_info']; ?>:</legend>
        </div>       
        <div>
            <label for="sn">SN:</label>
            <input type="text" id="sn" name="sn" placeholder="">
            <p class="help-block"></p>
        </div>
        <div class="controls">
            <button class="btn btn-success" id="btnpass"><?php echo $LNG['sn_change']; ?></button>
			<p class="help-block"></p>
        </div>
    </div>
    <p class="help-block"></p>
</div>

<script>
$('#btnpass').click(function(event)	{

	sn = $('#sn').val();
	info_er = '<?= $LNG['sn_load']; ?>';

	$.post("admin_sn.php",{sn: sn})
		.done(function(data){
			$("#main_panel").append(data);
		})
		.fail(function(){
			$(".help-block").eq(1).html(info_er);
		});
		
});

</script>