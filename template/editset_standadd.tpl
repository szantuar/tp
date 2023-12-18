<?php

?>

<div class="option_card">
    <div class="option_content">
        <div id="legend">
            <legend class=""><?php echo $LNG['stand_edit']; ?>:</legend>
        </div>
		<div class="control-group">
			<label><?= $LNG['model']; ?>:</label>
			<div class="controls">
				<?= $_POST['model']; ?>
				<p class="help-block"></p>
			</div>
		</div>
		
		<div class="control-group">
			<label><?= $LNG['desc']; ?>:</label>
			<div class="controls">
				<?= $_POST['desc']; ?>
				<p class="help-block"></p>
			</div>
		</div> 
		
		<div class="control-group">
			<label for="stand_list"><?= $LNG['stand_list']; ?>:</label>
			<div class="controls">
				<?php
				if(!empty($stand_list)) {
					?>
					<select class="form-select" aria-label="Default select example" id="stand_list">
						<option><?= $LNG['choose']; ?></option>
							<?php
							foreach($stand_list AS $list) {
								echo "<option value='" . $list['id_stand'] . "'>" . $list['name'] . "</option>";
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
		</div> 
		
        <div class="controls">
            <button class="btn btn-success" id="btnstand_save"><?php echo $LNG['stand_save']; ?></button>
			<p class="help-block"></p>
        </div>
    </div>
</div>

<script>
$('#btnstand_save').click(function(event) {
	choose = $('select option:selected').val();
	id_set = '<?= $_POST['id_set']; ?>';

	$.post("editset_standadd.php", {id_set: id_set, option_choose: choose})
		.done(function(data){
			$("#main_panel").append(data);
		})
		.fail(function(){
			$('.help-block').eq(3).html('<?= $LNG['err_save'] ?>');
		});
	
});

</script>