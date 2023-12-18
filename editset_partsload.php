<?php
$lang_file = 'parts';
require_once('common.php');

$lang->includeLang($lang_file);

require('vendor/autoload.php');

$file_send = '';
if(!isset($_FILES['send_file']['tmp_name'])) {
     showInfo("$('#result')", $LNG['err_file']);
     exit();
}
$file_send = $_FILES['send_file']['tmp_name'];

$file_type = $_FILES['send_file']['type'];
$inputFileType = '';
if($file_type == 'application/vnd.ms-excel') {
    $inputFileType = 'Xls';
} elseif ($file_type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
    $inputFileType = 'Xlsx';
} else {
    showInfo("$('#result')", $LNG['err_file2']);
    exit();
}

//  Create a new Reader of the type defined in $inputFileType  
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
//  Advise the Reader that we only want to load cell data  
$reader->setReadDataOnly(true);
//  Load $inputFileName to a Spreadsheet Object  
$spreadsheet = $reader->load($file_send);
$worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

$zm = [];
$i = 0;
$db2 = new db_query('second');
$_SESSION['error'] = false;
foreach($worksheet AS $datasheet) {
    if($i == 0) {
        if($datasheet['A'] != 'PN') {
            showInfo("$('#result')", $LNG['err_file3']);
            exit();
        }
    } else {
        $param = 'pn&' . htmlentities($datasheet['A']) . '&STR';
        $pn_info = $db2->prep_exception($db->returnQuery('query_54'), $param);
        
        $zm[$i]['pn'] = $datasheet['A'];
        $zm[$i]['sn'] = 'empty';
		
		if(!empty($pn_info) ){           
				$zm[$i]['pn_id'] = $pn_info[0]['id'];    
				$zm[$i]['pn_desc'] = $pn_info[0]['description'];  
				$zm[$i]['qty'] = (int)$pn_info[0]['qty'];    
				if((int)$pn_info[0]['qty'] <= 0) {
					$zm[$i]['error'] = $LNG['err_qty'];
					$_SESSION['error'] = true;             
				} else {           
					if($i > 1) {                   
						for($j = 1; $j <= count($zm); $j++) {
							if(!empty($zm[$j]['pn_id'])) {
								if($zm[$j]['pn_id'] == $pn_info[0]['id'] && $i != $j) {
									$zm[$i]['qty'] -= 1;
									if($zm[$i]['qty'] <= 0) {
										$zm[$i]['error'] = $LNG['err_qty'];
										$_SESSION['error'] = true;
									}
								}
							}
						}
					}
					
				}
			} else {
				$zm[$i]['pn_id'] = 'error';
				$zm[$i]['error'] = $LNG['err_file4'];
				$_SESSION['error'] = true;
			}
    }
    $i++;
}

    
if($_SESSION['error'] == true) {

	$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
	
	$spreadsheet->getActiveSheet()->setCellValue('A1', 'PN');	
	$spreadsheet->getActiveSheet()->setCellValue('B1' , 'info');		
	
	$i = 2;	
	foreach($zm AS $detail) {
		$spreadsheet->getActiveSheet()->setCellValue('A' . $i , $detail['pn']);	
		if(!isset($detail['error'])) {
			$spreadsheet->getActiveSheet()->setCellValue('B' . $i , '');	
		} else {
			$spreadsheet->getActiveSheet()->setCellValue('B' . $i , $detail['error']);	
		}
	$i++;
	}
	
	$file = "files/error/". $_SESSION['name_acc'] ."_partsload_error.xlsx";
	$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
	$writer->save($file);
	
	if(!file_exists($file)) {
		showInfo("$('#result')", $LNG['err_file5']);	
		exit;
	} else {
		?>
		
		<script>	
		$('#result').html("<a href='<?= $file; ?>' target='_blank'><img src='img/excel.jpg' style='width:30px'><?= $LNG['download']; ?></a>");		
		</script>
		
		<?php
	}		
        exit;
}

$str = '';

try {
	$db->beginTransaction();
	
	foreach($zm AS $detail) {
                
		$param = 'id_set&' . (int)$_SESSION['load'] . '&INT;';
		$param .= 'id_pn&' . (int)$detail['pn_id'] . '&INT;';
		$param .= 'sn&empty-' . $_SESSION['load'] . '&STR;';
		$param .= 'type&21&INT;';
		$param .= 'date&' . calldate() . '&STR;';
		$param .= 'id_acc&' . $_SESSION['id_acc'] . '&STR';
		$db->prep_query($db->returnQuery('query_102'), $param);
		
		$last_id = $db->last_id();
		
		//add new parts undercheck
		$param = 'id_hist&' . $last_id . '&INT;';
		$param .= 'date&' . calldate() . '&STR';
		
		$db->prep_query($db->returnQuery('query_99'), $param);
		
		if($db->CountRow() == 0){
			$db->prep_query($db->returnQuery('query_98'), $param);
		}		
		
		$param = 'id_set&' . (int)$_SESSION['load'] . '&INT;';
		$param .= 'id_history&' . $last_id . '&INT';
			
		$result = $db->prep_query($db->returnQuery('query_22'), $param);
			
		if($db->CountRow() == 0) {
			$db->prep_query($db->returnQuery('query_23'), $param);
		}
		
		$str .= "<tr id='tb_tr_" . $last_id . "'>";
		$str .= "<td>" . $detail['pn'] . "</td>";
		$str .= "<td>" . $detail['pn_desc'] . "</td>";
		$str .= "<td>---</td>";
        $str .= "<td><input type='text' id='tb_sn_" . $last_id  . "' name='tb_sn_" . $last_id . "' placeholder='' class='input-xlarge' value='empty-".$_SESSION['load']."' disabled=''></td>";
		$str .= "<td><div class='mytooltip'><img class='pn_action_remove' onClick=\"pn_action_remove('" . $LNG['pn_remove'] . "')\" src='img/remove.gif' id='pn_edit'><span class='mytooltiptext'>" . $LNG['tip3'] . "</span></div></td>";             
		
	}
	
	$db->commit();
} catch(PDOexception $error) {
		$db->rollBack();
		echo $error->getMessage();
		exit;
	}

echo $str;

?>