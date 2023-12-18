<?php

?>

<div class="row d-flex justify-content-center align-items-center h-100">
	<div class="col-12 col-md-8 col-lg-6 col-xl-5">
		<div class="card bg-dark text-white" style="border-radius: 1rem;">
			<div class="card-body p-5 text-center">

				<div class="mb-md-5 mt-md-4 pb-5">

				<h2 class="fw-bold mb-2 text-uppercase"><?= $LNG['login']; ?></h2>
				<p class="text-white-50 mb-5"><?= $LNG['login_info']; ?></p>
	  

				<div class="form-outline form-white mb-4">
					<label class="form-label" for="username"><?= $LNG['username']; ?></label>
					<input type="username" id="username" class="form-control form-control-lg" />							
					<p class="help-block"></p>
				</div>

				<div class="form-outline form-white mb-4">
					<label class="form-label" for="password"><?= $LNG['password']; ?></label>
					<input type="password" id="password" class="form-control form-control-lg" />							
					<p class="help-block"></p>
				</div>

				<button class="btn btn-outline-light btn-lg px-5" id="btnlog"><?= $LNG['login_ac']; ?></button>
				<p class="help-block"></p>

				</div>

			</div>
		</div>
	</div>
</div>

<script>

$('#btnlog').click(function(event) {
	login();
});

element = document.getElementById("password");
element.addEventListener("keydown",	function(){
	if(event.keyCode == 13){
		login();
	}
}, false);

function login(){
	name = $('#username').val();
	pass = $('#password').val();
	
	event.preventDefault();
	$.post("login.php",{username: name, password: pass})
		.done(function(data){
			$("#main_panel").append(data);
		})
		.fail(function(){
			$('.help-block').eq(2).html('<?= $LNG['err_log0'] ?>');
		});
}

</script>