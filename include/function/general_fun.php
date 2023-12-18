<?php
//require_once(ROOT_PATH . CLASS_DIR .'class.db_query.php');

//get date
function calldate()
	{
	date_default_timezone_set('Poland');
	$date = date('Y-m-d H:i:s');
	return $date;
	}

//generete new password
function passwordGenerator($length)
	{
    $uppercase = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'W', 'Y', 'Z');
    $lowercase = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'w', 'y', 'z');
    $number = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

    $password = NULL;

    for ($i = 0; $i < $length; $i++) {
        $password .= $uppercase[rand(0, count($uppercase) - 1)];
        $password .= $lowercase[rand(0, count($lowercase) - 1)];
        $password .= $number[rand(0, count($number) - 1)];
    }

    return substr($password, 0, $length);
	}

//clear element	
function clear_info($class)
	{
	echo"<script>
	".$class.".html('');
	</script>";
	}

//show info	in element
function showInfo($class, $info)
	{
	echo"<script>
	".$class.".html('".$info."');
	</script>";
	}

//check result where false with additional argument
function resultFalseArg($result, $class, $message)
	{
	if($result === FALSE)
		{
		showInfo($class, $message);
		exit;
		}
	}

function access_denied($value, $LNG) {
	if(!isset($_SESSION['access'][$value])){
		require(ROOT_PATH . TEMPLATE_DIR . 'access_alert.tpl');		
		exit;
	}
	
	if($_SESSION['access'][$value] == 0) {
		require(ROOT_PATH . TEMPLATE_DIR . 'access_alert.tpl');		
		exit;
	}
}

function info_alert($check, $info) {
	if($check == false) {
		require(ROOT_PATH . TEMPLATE_DIR . 'info_alert.tpl');		
		exit;
	}
}

function is_session() {
	if(!isset($_SESSION['id_acc'])) {
		exit;
	}
}

function access($access, $tip1, $tip2){
    if($access == 0){
        $str = "<div class='mytooltip'>";
        $str .= "<img src='img/no_access.gif' class='access_icon'>";
        $str .= "<span class='mytooltiptext'>" . $tip1[1] . $tip2 . "</span></div>";
        return $str;
    } else {
        $str = "<div class='mytooltip'>";
        $str .= "<img src='img/access.gif' class='access_icon'>";
        $str .= "<span class='mytooltiptext'>" . $tip1[0] . $tip2 . "</span></div>";
        return $str;
    }
}

function is_empty($variable){
	return ($variable == '') ? false : true;
}

function search_input($tip){
        ?>
        <div class="control-group">   
            <div class="controls">
                <div class="mytooltip">
                    <input type="text" id="searchset" name="searchset" placeholder="search" class="input-xlarge search_input"><button id="search-button" type="button" class="btn btn-primary">
						<img class="search-image" src="img/search2.gif">
					</button>

                    <span class="mytooltiptext_botom"><?= $tip; ?></span>
                </div>
                <p class="help-block"></p>
            </div>
        </div>
        <?php
}

function empty_data($data){
        if($data[0] == true){
            ?>
            <tr>
                <td colspan="<?= $data[2]; ?>">
                    <center>
                    <?= $data[1]; ?>
                    </center>
                </td>
            </tr>
            <?php  
            exit;
        }
}

function tooltip($image, $tip){
    ?>
    <td>
		<div class="mytooltip">
			<img src="img/<?= $image; ?>" class="access_icon">
			<span class="mytooltiptext"><?= $tip; ?></span>
		</div>
	</td>          
    <?php
}

function headline($name){
	?>
	<div class="headline"> <?= $name; ?>
	</div>
	<?php
}
?>