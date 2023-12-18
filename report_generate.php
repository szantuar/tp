<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$lang_file = 'report';
require_once('common.php');

$lang->includeLang($lang_file);
is_session();

resultFalseArg(isset($_POST), "$('#rep_pancel')", $LNG['empty_data']);

$report_data['id'] = (isset($_POST['report'])) ? $_POST['report'] : "";
resultFalseArg($report_data['id'] > 0 && $report_data['id'] < 6, "$('#rep_pancel')", $LNG['report_wrong']);

$report_data['name'] = (isset($_POST['name'])) ? $_POST['name'] : "";
$report_data['sn'] = (isset($_POST['sn'])) ? $_POST['sn'] : "";
$report_data['startDate'] = (isset($_POST['startDate'])) ? $_POST['startDate'] : "";
$report_data['endDate'] = (isset($_POST['endDate'])) ? $_POST['endDate'] : "";

require('vendor/autoload.php');

switch($report_data['id']){
	case 1:	 	
		access_denied('setlist', $LNG);
	
		$query = "SELECT setlist.id_set, (client.name) AS client, model.name, setlist.description, setlist.date_create, (SELECT users.name FROM users WHERE users.id_user = setlist.id_user_make) AS user_make, setlist.date_finish, (SELECT users.name FROM users WHERE users.id_user = setlist.id_user_finish) AS user_finish, setlist.is_use, (stand.name) AS stand_name, setlist.status FROM (((setlist INNER JOIN model ON setlist.model = model.id_model) INNER JOIN client ON model.uid_client = client.id_client) INNER JOIN stand ON setlist.uid_stand = stand.id_stand)";	
		
		if($report_data['name'] == "" && $report_data['startDate'] == "" && $report_data['endDate'] == "") {
			$result = $db->fetch_all($query);
		} else {
			$query .= " WHERE";
			
			$param = "";
			$dot = false;
			if($report_data['name'] != ""){
				$query .= " setlist.description = :desc";
				$param = "desc&" . $report_data['name'] . "&STR";
				$dot = true;
			}
			
			if($report_data['startDate'] != ""){
				$date = explode("/", $report_data['startDate']);
				$date_format = $date[2] . '-' . $date[0] . "-" . $date[1] . ' 23:59:59';
				if($dot) {
					$query .= " AND setlist.date_create >= :date_create";
					$param .= ";date_create&" . $date_format . "&STR";
				} else {
					$query .= " setlist.date_create >= :date_create";
					$param = "date_create&" . $date_format . "&STR";
					$dot = true;
				}
			}
			
			if($report_data['endDate'] != ""){
				$date = explode("/", $report_data['endDate']);
				$date_format = $date[2] . '-' . $date[0] . "-" . $date[1] . ' 23:59:59';
				if($dot) {
					$query .= " AND setlist.date_create <= :date_finish";
					$param .= ";date_finish&" . $date_format . "&STR";
				} else {
					$query .= " setlist.date_create <= :date_finish";
					$param = "date_finish&" . $date_format . "&STR";
				}			
			
			}
			
		$result = $db->prep_query($query, $param);		
		}
		
		resultFalseArg(!empty($result), "$('#rep_pancel')", $LNG['report_empty']);

		$spreadsheet = new Spreadsheet();
		
		//column in file
		$spreadsheet->getActiveSheet()->setCellValue('A1', 'ID_set');	
		$spreadsheet->getActiveSheet()->setCellValue('B1' , 'Client');
		$spreadsheet->getActiveSheet()->setCellValue('C1' , 'Model');
		$spreadsheet->getActiveSheet()->setCellValue('D1' , $LNG['setlist_desc']);		
		$spreadsheet->getActiveSheet()->setCellValue('E1' , $LNG['setlist_date_create']);	
		$spreadsheet->getActiveSheet()->setCellValue('F1' , $LNG['setlist_user_make']);
		$spreadsheet->getActiveSheet()->setCellValue('G1' , $LNG['setlist_date_finish']);
		$spreadsheet->getActiveSheet()->setCellValue('H1' , $LNG['setlist_user_finish']);
		$spreadsheet->getActiveSheet()->setCellValue('I1' , $LNG['setlist_isusage']);
		$spreadsheet->getActiveSheet()->setCellValue('J1' , $LNG['setlist_stand']);
		$spreadsheet->getActiveSheet()->setCellValue('K1' , $LNG['setlist_status']);
	
		$i = 2;
		foreach($result AS $detail){
			$spreadsheet->getActiveSheet()->setCellValue('A' . $i , $detail['id_set']);	
			$spreadsheet->getActiveSheet()->setCellValue('B' . $i , $detail['client']);	
			$spreadsheet->getActiveSheet()->setCellValue('C' . $i , $detail['name']);	
			$spreadsheet->getActiveSheet()->setCellValue('D' . $i , $detail['description']);
			$spreadsheet->getActiveSheet()->setCellValue('E' . $i , $detail['date_create']);
			$spreadsheet->getActiveSheet()->setCellValue('F' . $i , $detail['user_make']);
			$spreadsheet->getActiveSheet()->setCellValue('G' . $i , $detail['date_finish']);
			$spreadsheet->getActiveSheet()->setCellValue('H' . $i , $detail['user_finish']);
			$spreadsheet->getActiveSheet()->setCellValue('I' . $i , ($detail['is_use'] == 0) ? $LNG['setlist_no'] : $LNG['setlist_yes']);
			$spreadsheet->getActiveSheet()->setCellValue('J' . $i , $detail['stand_name']);
			$spreadsheet->getActiveSheet()->setCellValue('K' . $i , ($detail['status'] == 0) ? $LNG['setlist_yes'] : $LNG['setlist_no'] );
			
		$i++;
		}

		$date_name = calldate();
        copy('files/setlist.xlsx', 'files/generate/setlist' . strtotime($date_name) . '.xlsx');

		$file = 'files/generate/setlist' . strtotime($date_name) . '.xlsx';
		$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save($file);

        ?>
        <script>
            window.location.href=' <?= 'files/generate/setlist' . strtotime($date_name) . '.xlsx'; ?>';
        </script>
        <?php
		
	break;
	
	case 2:
		access_denied('setlist', $LNG);
		
        $query = "SELECT set_use_history.id_use, setlist.description, set_use_history.date_transaction, set_use_history.type_transaction, (stand.name) AS stand, (users.name) AS user_name FROM (((set_use_history INNER JOIN setlist ON set_use_history.id_set = setlist.id_set) INNER JOIN stand ON set_use_history.uid_stand = stand.id_stand) INNER JOIN users ON set_use_history.uid_user = users.id_user)";

        if($report_data['name'] == "" && $report_data['startDate'] == "" && $report_data['endDate'] == "") {
            $result = $db->fetch_all($query);
        } else {
            $query .= " WHERE";

            $param = "";
            $dot = false;
            if($report_data['name'] != ""){
                $query .= " setlist.description = :desc";
                $param = "desc&" . $report_data['name'] . "&STR";
                $dot = true;
            }

            if($report_data['startDate'] != ""){
                $date = explode("/", $report_data['startDate']);
                $date_format = $date[2] . '-' . $date[0] . "-" . $date[1] . ' 00:00:00';
                if($dot) {
                    $query .= " AND set_use_history.date_transaction >= :date_create";
                    $param .= ";date_create&" . $date_format . "&STR";
                } else {
                    $query .= " set_use_history.date_transaction >= :date_create";
                    $param = "date_create&" . $date_format . "&STR";
                    $dot = true;
                }
            }

            if($report_data['endDate'] != ""){
                $date = explode("/", $report_data['endDate']);
                $date_format = $date[2] . '-' . $date[0] . "-" . $date[1] . ' 23:59:59';
                if($dot) {
                    $query .= " AND set_use_history.date_transaction <= :date_finish";
                    $param .= ";date_finish&" . $date_format . "&STR";
                } else {
                    $query .= " set_use_history.date_transaction <= :date_finish";
                    $param = "date_finish&" . $date_format . "&STR";
                }

            }

            $result = $db->prep_query($query, $param);
        }

        resultFalseArg(!empty($result), "$('#rep_pancel')", $LNG['report_empty']);

		$spreadsheet = new Spreadsheet();
		
		//column in file
		$spreadsheet->getActiveSheet()->setCellValue('A1', 'ID_Action');	
		$spreadsheet->getActiveSheet()->setCellValue('B1' , $LNG['setlist_desc']);		
		$spreadsheet->getActiveSheet()->setCellValue('C1' , $LNG['type_transaction']);		
		$spreadsheet->getActiveSheet()->setCellValue('D1' , $LNG['setlist_stand']);			
		$spreadsheet->getActiveSheet()->setCellValue('E1' , $LNG['user_update']);
		$spreadsheet->getActiveSheet()->setCellValue('F1' , $LNG['date_update']);
		
	
		$i = 2;
		foreach($result AS $detail){
			$spreadsheet->getActiveSheet()->setCellValue('A' . $i , $detail['id_use']);	
			$spreadsheet->getActiveSheet()->setCellValue('B' . $i , $detail['description']);									
			$spreadsheet->getActiveSheet()->setCellValue('C' . $i , $LNG['trans_' . $detail['type_transaction']]);			
			$spreadsheet->getActiveSheet()->setCellValue('D' . $i , $detail['stand']);	
			$spreadsheet->getActiveSheet()->setCellValue('E' . $i , $detail['user_name']);
			$spreadsheet->getActiveSheet()->setCellValue('F' . $i , $detail['date_transaction']);	
			
		$i++;
		}

		$date_name = calldate();
        copy('files/setstand.xlsx', 'files/generate/setstand' . strtotime($date_name) . '.xlsx');

		$file = 'files/generate/setstand' . strtotime($date_name) . '.xlsx';
		$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save($file);

        ?>
        <script>
            window.location.href=' <?= 'files/generate/setstand' . strtotime($date_name) . '.xlsx'; ?>';
        </script>
        <?php

	break;	
	
	case 3:
		access_denied('setlist', $LNG);
		
		$query = "SELECT parts_set.id_parts, setlist.description , parts_history.id_pn, parts_history.sn, parts_history.date_create , parts_set.is_damaged, parts_set.status FROM ((parts_set INNER JOIN setlist ON parts_set.id_set = setlist.id_set) INNER JOIN parts_history ON parts_set.id_history_parts = parts_history.id_history) WHERE parts_set.status = 1";
		
		$result = $db->fetch_all($query);
		
		$db2 = new db_query('second');
		
		$i = 0;
		foreach($result AS $detail){
			$param = 'id&' . $detail['id_pn'] . '&STR';
			$pn_info = $db2->prep_exception("SELECT part_master.id, part_master.part_number, part_master.description FROM part_master WHERE part_master.id = :id;", $param);
			
			if(empty($pn_info)){
				$result[$i]['pn'] = 'wrong data';
				$result[$i]['pn_desc'] = 'wrong data';
			} else {
				$result[$i]['pn'] =  $pn_info[0]['part_number'];
				$result[$i]['pn_desc'] = $pn_info[0]['description'];
			}
		
		$i++;
		}

		$spreadsheet = new Spreadsheet();
		
		//column in file
		$spreadsheet->getActiveSheet()->setCellValue('A1', $LNG['setlist_desc']);			
		$spreadsheet->getActiveSheet()->setCellValue('B1' , 'PN');				
		$spreadsheet->getActiveSheet()->setCellValue('C1' , $LNG['description']);		
		$spreadsheet->getActiveSheet()->setCellValue('D1' , 'SN');	
		$spreadsheet->getActiveSheet()->setCellValue('E1' , 'Status');		
		$spreadsheet->getActiveSheet()->setCellValue('F1' , $LNG['date_update']);
		
		
	
		$i = 2;
		foreach($result AS $detail){
			$spreadsheet->getActiveSheet()->setCellValue('A' . $i , $detail['description']);		
			$spreadsheet->getActiveSheet()->setCellValue('B' . $i , $detail['pn']);						
			$spreadsheet->getActiveSheet()->setCellValue('C' . $i , $detail['pn_desc']);				
			$spreadsheet->getActiveSheet()->setCellValue('D' . $i , $detail['sn']);					
			
			if($detail['is_damaged'] == 0){
				$info = $LNG['parts_status_0'];
			} elseif ($detail['is_damaged'] == 1){
				$info = $LNG['parts_status_1'];
			}
			else {
				$info = $LNG['parts_status_2'];
			}
			$spreadsheet->getActiveSheet()->setCellValue('E' . $i , $info);	
			$spreadsheet->getActiveSheet()->setCellValue('F' . $i , $detail['date_create']);
			
		$i++;
		}

		$date_name = calldate();
        copy('files/setpartsuse.xlsx', 'files/generate/setpartsuse' . strtotime($date_name) . '.xlsx');

		$file = 'files/generate/setpartsuse' . strtotime($date_name) . '.xlsx';
		$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save($file);

        ?>
        <script>
            window.location.href=' <?= 'files/generate/setpartsuse' . strtotime($date_name) . '.xlsx'; ?>';
        </script>
        <?php
		
		
	break;
	
	case 4:
		access_denied('addaccess', $LNG);
		
		$query = "SELECT access_history.id_hist, access_history.uid_access, users.name, (SELECT users.name FROM users WHERE users.id_user = access_history.uid_user) AS from_user, access_history.date_create, access_history.type_transaction FROM access_history INNER JOIN users ON users.id_user = access_history.gid_user";
		
		if($report_data['name'] == "" && $report_data['startDate'] == "" && $report_data['endDate'] == "") {
            $result = $db->fetch_all($query);
        } else {
            $query .= " WHERE";
			
			$param = "";
            $dot = false;
            if($report_data['name'] != ""){
                $query .= " users.name = :desc";
                $param = "desc&" . $report_data['name'] . "&STR";
                $dot = true;
            }

            if($report_data['startDate'] != ""){
                $date = explode("/", $report_data['startDate']);
                $date_format = $date[2] . '-' . $date[0] . "-" . $date[1] . ' 00:00:00';
                if($dot) {
                    $query .= " AND access_history.date_create >= :date_create";
                    $param .= ";date_create&" . $date_format . "&STR";
                } else {
                    $query .= " access_history.date_create >= :date_create";
                    $param = "date_create&" . $date_format . "&STR";
                    $dot = true;
                }
            }

            if($report_data['endDate'] != ""){
                $date = explode("/", $report_data['endDate']);
                $date_format = $date[2] . '-' . $date[0] . "-" . $date[1] . ' 23:59:59';
                if($dot) {
                    $query .= " AND access_history.date_create <= :date_finish";
                    $param .= ";date_finish&" . $date_format . "&STR";
                } else {
                    $query .= " access_history.date_create <= :date_finish";
                    $param = "date_finish&" . $date_format . "&STR";
                }

            }

            $result = $db->prep_query($query, $param);
        }
		
        resultFalseArg(!empty($result), "$('#rep_pancel')", $LNG['report_empty']);

		$spreadsheet = new Spreadsheet();
		
		//column in file
		$spreadsheet->getActiveSheet()->setCellValue('A1', 'User');			
		$spreadsheet->getActiveSheet()->setCellValue('B1' , $LNG['type_permission']);		
		$spreadsheet->getActiveSheet()->setCellValue('C1' , $LNG['type_transaction']);		
		$spreadsheet->getActiveSheet()->setCellValue('D1' , $LNG['who_give']);			
		$spreadsheet->getActiveSheet()->setCellValue('E1' , $LNG['date_update']);
		
		$i = 2;
		foreach($result AS $detail){
			$spreadsheet->getActiveSheet()->setCellValue('A' . $i , $detail['name']);				
			$spreadsheet->getActiveSheet()->setCellValue('B' . $i , $LNG['permission_' . $detail['uid_access']]);				
			$spreadsheet->getActiveSheet()->setCellValue('C' . $i , $LNG['trans_'. $detail['type_transaction']]);
			$spreadsheet->getActiveSheet()->setCellValue('D' . $i , $detail['from_user']);					
			$spreadsheet->getActiveSheet()->setCellValue('E' . $i , $detail['date_create']);	
			
		$i++;
		}

		$date_name = calldate();
        copy('files/permission.xlsx', 'files/generate/permission' . strtotime($date_name) . '.xlsx');

		$file = 'files/generate/permission' . strtotime($date_name) . '.xlsx';
		$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save($file);

        ?>
        <script>
            window.location.href=' <?= 'files/generate/permission' . strtotime($date_name) . '.xlsx'; ?>';
        </script>
        <?php
	
	break;
	
	case 5:
	 	
		$query = "SELECT parts_history.id_history, setlist.description, parts_history.id_pn, parts_history.sn, parts_history.type_transaction, parts_history.date_create, users.name FROM ((parts_history INNER JOIN setlist ON parts_history.id_set = setlist.id_set) INNER JOIN users ON parts_history.id_user = users.id_user)";
		
		if($report_data['name'] == "" && $report_data['startDate'] == "" && $report_data['endDate'] == "" && $report_data['sn'] == "") {
            $result = $db->fetch_all($query);
		} else {
			$query .= " WHERE";
			
			$db2 = new db_query('second');
			
			$param = "";
            $dot = false;
            if($report_data['name'] != ""){
								
				$param = 'pn&' . $report_data['name'] . '&STR';
				$pn_info = $db2->prep_exception("SELECT id, part_number, description FROM part_master WHERE part_number = :pn", $param);
				
				if(empty($pn_info)){
					echo $LNG['report_empty'];
					exit;				
				} else {
					$pn_data[0]['id'] =  $pn_info[0]['id'];
					$pn_data[0]['pn'] =  $pn_info[0]['part_number'];
					$pn_data[0]['pn_desc'] = $pn_info[0]['description'];
				}
				
				$query .= " parts_history.id_pn = :desc";
                $param = "desc&" . $pn_data[0]['id'] . "&STR";
                $dot = true;				
            }
			
			if($report_data['sn'] != ""){
				if($dot) {
                    $query .= " AND parts_history.sn = :sn";
                    $param .= ";sn&" . $report_data['sn'] . "&STR";
                } else {
                    $query .= " parts_history.sn = :sn";
                    $param = "sn&" . $report_data['sn'] . "&STR";
                    $dot = true;
                }
			}
			
			if($report_data['startDate'] != ""){
                $date = explode("/", $report_data['startDate']);
                $date_format = $date[2] . '-' . $date[0] . "-" . $date[1] . ' 00:00:00';
                if($dot) {
                    $query .= " AND parts_history.date_create >= :date_create";
                    $param .= ";date_create&" . $date_format . "&STR";
                } else {
                    $query .= " parts_history.date_create >= :date_create";
                    $param = "date_create&" . $date_format . "&STR";
                    $dot = true;
                }
            }

            if($report_data['endDate'] != ""){
                $date = explode("/", $report_data['endDate']);
                $date_format = $date[2] . '-' . $date[0] . "-" . $date[1] . ' 23:59:59';
                if($dot) {
                    $query .= " AND parts_history.date_create <= :date_finish";
                    $param .= ";date_finish&" . $date_format . "&STR";
                } else {
                    $query .= " parts_history.date_create <= :date_finish";
                    $param = "date_finish&" . $date_format . "&STR";
                }

            }
			
			$result = $db->prep_query($query, $param);
		}
		
		resultFalseArg(!empty($result), "$('#rep_pancel')", $LNG['report_empty']);
		
		$spreadsheet = new Spreadsheet();
		
		//column in file
		$spreadsheet->getActiveSheet()->setCellValue('A1', 'ID_hist');
		$spreadsheet->getActiveSheet()->setCellValue('B1' , $LNG['setlist_desc']);			
		$spreadsheet->getActiveSheet()->setCellValue('C1' , 'PN');
		$spreadsheet->getActiveSheet()->setCellValue('D1' , $LNG['description']);
		$spreadsheet->getActiveSheet()->setCellValue('E1' , 'SN');		
		$spreadsheet->getActiveSheet()->setCellValue('F1' , $LNG['type_transaction']);		
		$spreadsheet->getActiveSheet()->setCellValue('G1' , $LNG['user_update']);			
		$spreadsheet->getActiveSheet()->setCellValue('H1' , $LNG['date_update']);
				
		$db2 = new db_query('second');
		$i = 2;
		foreach($result AS $detail){
			$spreadsheet->getActiveSheet()->setCellValue('A' . $i , $detail['id_history']);
			$spreadsheet->getActiveSheet()->setCellValue('B' . $i , $detail['description']);
			
			if(empty($pn_data)){
				$param = 'id_pn&' . $detail['id_pn'] . '&STR';
				$pn_info = $db2->prep_exception($db2->returnQuery('query_19'), $param);

				if(empty($pn_info)){
					$spreadsheet->getActiveSheet()->setCellValue('C' . $i , $LNG['wrong_data']);
					$spreadsheet->getActiveSheet()->setCellValue('D' . $i , $LNG['wrong_data']);			
				} else {
					$spreadsheet->getActiveSheet()->setCellValue('C' . $i , $pn_info[0]['part_number']);
					$spreadsheet->getActiveSheet()->setCellValue('D' . $i , $pn_info[0]['description']);
				}
				
			} else {
				$spreadsheet->getActiveSheet()->setCellValue('C' . $i , $pn_data[0]['pn']);
				$spreadsheet->getActiveSheet()->setCellValue('D' . $i , $pn_data[0]['pn_desc']);
			}
			
			$spreadsheet->getActiveSheet()->setCellValue('E' . $i , $detail['sn']);
			$spreadsheet->getActiveSheet()->setCellValue('F' . $i , $LNG['trans_' . $detail['type_transaction']]);
			$spreadsheet->getActiveSheet()->setCellValue('G' . $i , $detail['name']);
			$spreadsheet->getActiveSheet()->setCellValue('H' . $i , $detail['date_create']);
			
		$i++;
		}
				
		$date_name = calldate();
        copy('files/histroryparts.xlsx', 'files/generate/histroryparts' . strtotime($date_name) . '.xlsx');

		$file = 'files/generate/histroryparts' . strtotime($date_name) . '.xlsx';
		$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save($file);

        ?>
        <script>
            window.location.href=' <?= 'files/generate/histroryparts' . strtotime($date_name) . '.xlsx'; ?>';
        </script>
        <?php
		
	break;
	
	default:
		echo $LNG['report_wrong'];
	break;
}
