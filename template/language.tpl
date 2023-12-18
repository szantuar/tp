 <?php
 
 ?>

<div class="position-relative">
	<div class="position-absolute top-0 end-0">
		<img class="lang_flag" src="<?php echo IMAGE_DIR;?>/language/pl.jpg" id="pl">
		<img class="lang_flag" src="<?php echo IMAGE_DIR;?>/language/en.jpg" id="en">
	</div>
</div>
 
<script>
	
$(".lang_flag").click(function(){
	
	lang = $('.lang_flag:hover').attr('id');
	info_er = '<?= $LNG['err_lang'] ?>';
	
	$.post("setLanguage.php",{lang : lang})
		.done(function(data){
		$("#main_panel").html(data);
		})
		.fail(function(){
			$("#main_panel").html(info_er);
		});

	setTimeout(change_info,10000);
});

</script>