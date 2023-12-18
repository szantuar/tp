<?php

?>


<link rel="stylesheet" href="css/datepicker.css">

<div class="option_card">
	<div class="option_content">
		<div id="legend">
			<legend class=""><?php echo $LNG['rep_list']; ?>:</legend>
		</div>

		<!-- name, PN-->
		<div>
			<label for="name"><?= $LNG['rep_field_1']; ?>:</label>
			<input type="text" id="name" name="name" placeholder="">
			<p class="help-block"></p>
		</div>

		<div>
			<label for="sn"><?= $LNG['rep_field_2']; ?>:</label>
			<input type="text" id="sn" name="sn" placeholder="">
			<p class="help-block"></p>
		</div>

		<div>
			<label for="date_start"><?= $LNG['rep_field_3']; ?>:</label>
			<input type="text" id="date_start" name="date_start" placeholder="">
			<p class="help-block"></p>
		</div>

		<div>
			<label for="date_end"><?= $LNG['rep_field_4']; ?>:</label>
			<input type="text" id="date_end" name="date_end" placeholder="">
			<p class="help-block"></p>
		</div>

	</div>
	<p class="help-block"></p>
</div>

<script src="js/datepicker.js"></script>

<div>
	<div>
		<img class='exc_img' src="img/excel.jpg" alt="" id="1"> <?= $LNG['set_list']; ?>
	</div>
	<div>
		<img class='exc_img' src="img/excel.jpg" alt="" id="2"> <?= $LNG['set_stand']; ?>
	</div>
	<div>
		<img class='exc_img' src="img/excel.jpg" alt="" id="3"> <?= $LNG['parts_usage']; ?>
	</div>
	<div>
		<img class='exc_img' src="img/excel.jpg" alt="" id="4"> <?= $LNG['permission']; ?>
	</div>
	<div>
		<img class='exc_img' src="img/excel.jpg" alt="" id="5"> <?= $LNG['parts_history']; ?>
	</div>
</div>

<script>
						
$(function() {
	let $startDate = $('#date_start');
	let $endDate = $('#date_end');

	$startDate.datepicker({
		autoHide: true,
	});
	$endDate.datepicker({
		autoHide: true,
		//startDate: $startDate.datepicker('getDate'),
	});

	$startDate.on('change', function () {
		$endDate.datepicker('setStartDate', $startDate.datepicker('getDate'));
	});
});


$('.exc_img').click(function(event)	{
	
	report = $(this).attr('id');
	name = $('#name').val();
	sn = $('#sn').val();
	startDate = $('#date_start').val();
	endDate = $('#date_end').val();
		
	info_er = '<?= $LNG['err_report']; ?>';
	
	event.preventDefault();
	$.post("report_generate.php",{report: report, name: name, sn: sn, startDate: startDate, endDate: endDate})
		.done(function(data){
			$("#rep_pancel").html(data);
		})
		.fail(function(){
			$("#rep_pancel").html(info_er);
		});	
});

</script>