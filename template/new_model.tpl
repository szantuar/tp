<?php

?>

<div class="option_card">
    <div class="option_content">
        <div id="legend">
            <legend class=""><?php echo $LNG['option_model']; ?>:</legend>
        </div>       
        <div>
            <label for="name"><?= $LNG['name']; ?>:</label>
            <input type="text" id="name" name="name" placeholder="">
            <p class="help-block"></p>
        </div>
		<div>
			<label for="model_list"><?= $LNG['client_list']; ?></label>
				<?php
				if(!empty($client_list)) {
					?>
					<select class="form-select" aria-label="Default select example" id="model_list">
						<option><?= $LNG['choose']; ?></option>
							<?php
							foreach($client_list AS $list) {
								echo "<option value='" . $list['id_client'] . "'>" . $list['name'] . "</option>";
							}
							?>
					</select>
					<?php
				} else {
					?>
					<div class="alert alert-info">
						<strong><?= $LNG['err_choose']; ?></strong> 
					</div>
					<?php
				}
				?>						
			<p class="help-block"></p>
		</div>
        <div class="controls">
            <button class="btn btn-success" id="btnpass"><?php echo $LNG['model_add']; ?></button>
			<p class="help-block"></p>
        </div>
    </div>
    <p class="help-block"></p>
</div>

<script>
$('#btnpass').click(function(event)	{

	name = $('#name').val();
	choose = $('select option:selected').val();
	info_er = '<?= $LNG['model_load']; ?>';
	
	event.preventDefault();
	$.post("admin_models.php",{name_model: name, choose: choose})
		.done(function(data){
			$("#tb_set").append(data);
		})
		.fail(function(){
			$(".help-block").eq(3).html(info_er);
		});
		
});

</script>