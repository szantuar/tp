<?php

?>

<div class="row d-flex justify-content-center align-items-center h-100">
	<div class="col-12 col-md-8 col-lg-6 col-xl-5" id="stand_panel">
		<div class="card bg-dark text-white" style="border-radius: 1rem;">
			<div class="card-body p-5 text-center" id="stand_card">

				<div class="mb-md-5 mt-md-4 pb-5">

					<h2 class="fw-bold mb-2 text-uppercase"><?= $LNG['setadd']; ?></h2>
					<p class="text-white-50 mb-5"><?= $LNG['stand_info']; ?></p>
		
	
					<div class="form-outline form-white mb-4">
						<label class="form-label" for="username"><?= $LNG['desc'];; ?></label>
						<input type="text" id="desc" class="form-control form-control-lg" />							
						<p class="help-block"></p>
					</div>
	
					<div class="form-outline form-white mb-4">
						<label class="form-label" for="model_list"><?= $LNG['model']; ?></label>
							<?php
							if(!empty($model_list)) {
								?>
								<select class="form-select" aria-label="Default select example" id="model_list">
									<option><?= $LNG['choose']; ?></option>
										<?php
										foreach($model_list AS $list) {
											echo "<option value='" . $list['id_model'] . "'>" . $list['name'] . "</option>";
										}
										?>
								</select>
								<?php
							} else {
								?>
								<div class="alert alert-info">
									<strong><?= $LNG['err_choose3']; ?></strong> 
								</div>
								<?php
							}
							?>						
						<p class="help-block"></p>
					</div>
				
					<div class="form-outline form-white mb-4">
						<label class="form-label" for="stand_list"><?= $LNG['stand_list']; ?></label>
							<?php
							if(!empty($stand_list)) {
								?>
								<select class="form-select" aria-label="Default select example" id="stand_list">
									<option><?= $LNG['choose']; ?></option>
										<?php
										foreach($stand_list AS $list) {
											if($list['id_stand'] == 1){
												$list['name'] = $LNG['clear'];
											}
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
					<button class="btn btn-outline-light btn-lg px-5" id="btnstand_create"><?= $LNG['stand_create']; ?></button>
					<p class="help-block"></p>
	
				</div>

			</div>
		</div>
	</div>
</div>


<script>
$('#btnstand_create').click(function(event) {
	model_list = $('select option:selected').eq(0).val();
	stand_list = $('select option:selected').eq(1).val();
	desc = $('#desc').val();
	
	$.post("newset.php", {model_list: model_list, stand_list: stand_list, desc: desc})
		.done(function(data){
			$("#main_panel").append(data);
		})
		.fail(function(){
			$('.help-block').eq(3).html('<?= $LNG['err_save'] ?>');
		});
	
});

</script>