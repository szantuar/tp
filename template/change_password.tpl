<?php

?>

<div class="option_card">
    <div class="option_content">
		<div id="legend">
			<legend class=""><?php echo $LNG['option_password']; ?></legend>
		</div>
		<div class="control-group">
		<!-- Username -->
			<label for="old_pass"><?= $LNG['old_pass']; ?>:</label>
			<div class="controls">
				<input type="password" id="old_pass" name="old_pass" placeholder="" class="input-xlarge">
				<p class="help-block"></p>
			</div>
		</div>
	
		<div class="control-group">
		<!-- Password-->
			<label for="new_pass"><?= $LNG['new_pass']; ?>: </label>
			<div class="controls">
				<input type="password" id="new_pass" name="new_pass" placeholder="" class="input-xlarge">
				<p class="help-block"></p>
			</div>
		</div>
	
		<div class="control-group">
			<!-- Password-->
			<label for="new_pass2"><?php echo $LNG['new_pass1']; ?>: </label>
			<div class="controls">
				<input type="password" id="new_pass2" name="new_pass2" placeholder="" class="input-xlarge">
				<p class="help-block"></p>
			</div>
		</div>
	
		<div class="control-group">
			<!-- Button -->
			<div class="controls">
				<button class="btn btn-success" id="btnpass"><?php echo $LNG['new_password']; ?></button>
				<p class="help-block"></p>
			</div>
		</div>
    </div>
</div>

<script>
$('#btnpass').click(function(event)
	{

	old_pass = $('#old_pass').val();
	new_pass = $('#new_pass').val();
	new_pass2 = $('#new_pass2').val();
	info_er = '<?= $LNG['pass_load']; ?>';
	
	event.preventDefault();
	$.post("admin_changepassword.php",{old_pass: old_pass, new_pass: new_pass, new_pass2: new_pass2})
		.done(function(data){
			$("#main_panel").append(data);
		})
		.fail(function(){
			$(".help-block").eq(3).html(info_er);
		});
	});

</script>