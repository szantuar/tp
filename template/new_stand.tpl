<?php

?>

<div class="option_card">
    <div class="option_content">
        <div id="legend">
            <legend class=""><?php echo $LNG['option_stand']; ?>:</legend>
        </div>       
        <div>
            <label for="name"><?= $LNG['name']; ?>:</label>
            <input type="text" id="name" name="name" placeholder="">
            <p class="help-block"></p>
        </div>
        <div class="controls">
            <button class="btn btn-success" id="btnpass"><?php echo $LNG['stand_add']; ?></button>
	<p class="help-block"></p>
        </div>
    </div>
    <p class="help-block"></p>
</div>

<script>
$('#btnpass').click(function(event)	{
	name = $('#name').val();
	info_er = '<?= $LNG['user_load']; ?>';
	
	$.post("admin_stands.php",{name_stand: name})
		.done(function(data){
			$("#tb_set").append(data);
		})
		.fail(function(){
			$(".help-block").eq(3).html(info_er);
		});
});

</script>