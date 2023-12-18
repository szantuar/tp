<?php
$lang_file = 'admin';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

?>

<div class="control-group">
	<h2><?= $LNG['option']; ?></h2>	
	<span class="border border-secondary option_panel" id="admin_changepassword"><?= $LNG['new_password']; ?></span>
	<span class="border border-secondary option_panel" id="admin_users"><?= $LNG['admin_users']; ?></span>
	<span class="border border-secondary option_panel" id="admin_models"><?= $LNG['admin_models']; ?></span>
	<span class="border border-secondary option_panel" id="admin_stands"><?= $LNG['admin_stands']; ?></span>
	<span class="border border-secondary option_panel" id="admin_sn"><?= $LNG['sn_panel']; ?></span>
	<span class="border border-secondary option_panel" id="admin_access"><?= $LNG['access']; ?></span>
	<p class="help-block"></p>
</div>

<div id='option_pancel'>

</div>

<script>

$(".option_panel").click(function(event){
    id = $(this).attr('id');
    info_er = '<?= $LNG['admin_error'] ?>';
    
    $.post(id+".php")
        .done(function(data){
            $("#main_panel").html(data);
        })
        .fail(function(){
            $(".help-block").eq(0).html(info_er);
        });
});

</script>