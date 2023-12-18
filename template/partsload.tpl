<?php
?>
<div>
	<a href="files/setedit_sample.xlsx" target="_blank">
		<img src="img/excel.jpg" style="width:30px">
		<?= $LNG['sample']; ?>
	</a>
</div>

<div class="container">
	<p id="info"></p>
	<div class="row">
		<form method="POST" enctype="multipart/form-data" id="partsload">
				<!--<input type="hidden" name="MAX_FILE_SIZE" value="300000" /> -->
				<div class="btn btn-secondary" onclick="document.getElementById('send_file').click()"><?= $LNG['load_file']; ?></div>
				<input type="file" name="send_file" id="send_file" style="display:none"/>
				<input class="btn btn-secondary" type="submit" value="<?= $LNG['load_parts']; ?>" id="btnSubmit"/>
		</form>
            <p id="result"></p>
	</div>

</div>

<script language="JavaScript">

$("#btnSubmit").click(function(event){
	event.preventDefault();
	clear_info('.help-block');
        
	data = new FormData($('#partsload')[0]);
	id = "partsload";
	
	    $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "editset_partsload.php",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
			
            success: function (data){
                $("#tb_set").append(data);	
            },
			
            error: function (e){
                $("#tb_set").append(e.responseText);
                console.log("ERROR : ", e);
            }
        });
});

</script>