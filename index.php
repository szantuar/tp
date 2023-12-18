<html>

<?php

$lang_file = 'global';
require_once('common.php');

$lang->includeLang($lang_file);

?>

<head>
<meta name="description" content="....">
<meta name="author" content="Unknown">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<link rel="shortcut icon" href="favicon.ico">

<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/style.css">

<script src="js/jquery-3.7.0.js"></script> 
<script src="js/js_function.js"></script> 

<title id="title">
	<?= $LNG['topic_common']; ?>
</title>
</head>

<body>

<?php 
require_once(ROOT_PATH . TEMPLATE_DIR. 'language.tpl'); 
?>

<div class="container" id="home_panel">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<?php if(isset($_SESSION['id_acc'])) {
			?>
			<a class="navbar-brand menu" href="#" id='standlist'> <?= $LNG['sets']; ?></a>
			<a class="navbar-brand menu" href="#" id="setlist"><?= $LNG['list_set']; ?></a>
			<a class="navbar-brand menu" href="#" id="newset"><?= $LNG['new_set']; ?></a>
			<a class="navbar-brand menu" href="#" id="set"><?= $LNG['set']; ?></a>
			<a class="navbar-brand menu" href="#" id="setparts_demand">
				<?= $LNG['demand']; ?>&nbsp;
				<span id="demand_qty" class="badge bg-danger float-end"></span>
			</a>	
			<a class="navbar-brand menu" href="#" id="setparts_undercheck">
				<?= $LNG['undercheck']; ?>&nbsp;
				<span id="qa_qty" class="badge bg-danger float-end"></span>
			</a>
			<a class="navbar-brand menu" href="#" id="setparts_receive">
				<?= $LNG['receive']; ?>
				<span id="receive_qty" class="badge bg-danger float-end"></span>
			</a>
			<a class="navbar-brand menu" href="#" id="not_receive">
                <?= $LNG['not_receive']; ?>
                <span id="not_receive_qty" class="badge bg-danger float-end"></span>
            </a>
			<a class="navbar-brand menu" href="#" id="report"><?= $LNG['report']; ?></a>
			<a class="navbar-brand menu" href="#" id="admin"><?= $LNG['admin']; ?></a>
			<a class="navbar-brand menu" href="#" id="logout"><?= $LNG['logout']; ?></a>
			<script src="js/timer.js"></script> 
			<?php
		} else {
			?>
			<a class="navbar-brand menu" href="#" id='standlist'> <?= $LNG['sets']; ?></a>
			<a class="navbar-brand menu" href="#" id='login'> <?= $LNG['login']; ?></a>
			<a class="navbar-brand menu" href="#" id="set"><?= $LNG['set']; ?></a>
			<?php
		}
		?>
		
	</nav>
	
	<script>
		$(".menu").click(function(){	
			trace = $('.menu:hover').attr('id');
			info_er = '<?= $LNG['menu_err']; ?>';

			$.post(trace+".php")
				.done(function(data){
					$("#main_panel").html(data);
				})
				.fail(function(){
					$("#main_panel").html(info_er);
				});
		});
	</script>
	
</div>

<div class="jumbotron-01 text-center">

	<div class="container">
		<div class="row">
			<div class="col-sm-1">
			</div>
			  <div class="col-sm-10" id="main_panel">
				<div class="show_info" id="site_info">
				<?php
					require_once('standlist.php');
				?>
				</div>
			</div>
			<div class="col-sm-1">


</div>

</body>

</html>