<?php
require_once '../../common.php';

$act_button     = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';
$db_status = isset($_POST['db_status']) ? strip_tags(clean_xss_attributes($_POST['db_status'])) : '';

if ($act_button === "업로드") {

    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"] ?? $_SERVER['REMOTE_ADDR'];

    set_time_limit ( 0 );
    ini_set('memory_limit', '256M');

    $is_upload_file = (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name']) ? 1 : 0;
    
    if( ! $is_upload_file){
        alert("엑셀 파일을 업로드해 주세요.");
    }

    if($is_upload_file) {

        $file = $_FILES['file']['tmp_name'];

        include_once(G5_LIB_PATH.'/PHPExcel/IOFactory.php');

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $sheet = $objPHPExcel->getSheet(0);

        $num_rows = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        if($num_rows > 200) {
            alert("시스템 정책상 최대 200 행(row)까지 처리할수있습니다.");
        }
        

        // 두 번째 행 데이터를 가져와 휴대폰 번호가 포함된 열 찾기
        $secondRowData = $sheet->rangeToArray('A2:' . $highestColumn . '2', NULL, TRUE, FALSE);
        $phoneColumnIndex = null; // 휴대폰 번호가 있는 열의 인덱스 초기화

        // 정규 표현식을 사용하여 한국 휴대폰 번호 형식 확인
        $phonePattern = '/^010-\d{4}-\d{4}$/';
        foreach ($secondRowData[0] as $index => $cellValue) {
            if (preg_match($phonePattern, $cellValue)) {
                $phoneColumnIndex = $index;
                break; // 첫 번째로 매칭되는 열 인덱스를 찾으면 반복 종료
            }
        }

        if ($phoneColumnIndex === null) {
            alert("엑셀 파일에서 휴대폰 번호 형식에 맞는 열을 찾을 수 없습니다.");
            exit; // 휴대폰 번호가 포함된 열을 찾지 못하면 처리 중단
        }
        
        for ($i = 2; $i <= $num_rows; $i++) {
          
            $rowData = $sheet->rangeToArray('A' . $i . ':' . $highestColumn . $i, TRUE, FALSE);
            $tel = isset($rowData[0][$phoneColumnIndex]) ? $rowData[0][$phoneColumnIndex] : '';
            $status1 = isset($rowData[0][$phoneColumnIndex +1 ]) ? $rowData[0][$phoneColumnIndex +1] : '';

            if(strlen($tel) != 13) {
                alert($i ."행에 연락처 포맷을 확인해주세요.");
            }

            if($db_status == 0) {
                if($status1 == "부재") {
                    $status = "1";
                } else if($status1 == "결번") {
                    $status = "2";
                } else if($status1 == "거절") {
                    $status = "3";
                } else if($status1 == "승인") {
                    $status = "4";
                } else if($status1 == "리콜") {
                    $status = "5";
                } else if($status1 == "가망") {
                    $status = "6";
                } else {
                    alert($i ."행에 상태값을 확인해주세요.");
                }
            } else {
                $status = $db_status;
            }
            
            $sql = "
            UPDATE gnp_crm_landing 
            SET db_status = '{$status}' 
              , update_log = '고객사업로드'
            WHERE tel = trim('{$tel}')
            and land_ptn_idx = {$member['mb_ptnidx']}
            ";
            $result = sql_query($sql);
            // if ($result == 0) {
            //     alert(($i-1)."행 까지 저장되었고, " .$i . "행(". $tel .") 연락처가 존재하지않아 처리되지않고 중단 되었습니다. 확인 후 다시 시도해주세요.");
            //     exit();
            // } 
        }

        alert("처리 되었습니다","./db_list?". $qstr, false);
        //goto_url('./land_list?' . $qstr);
    }
} else if ($act_button == "양식다운") {

    $file = G5_DATA_PATH.'/file/excel/excelSample.xlsx'; // 파일의 전체 경로
    $file_name = 'excelSample.xls'; // 저장될 파일 이름

    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-length: ' . filesize($file));
    header('Expires: 0');
    header("Pragma: public");

    $fp = fopen($file, 'rb');
    fpassthru($fp);
    fclose($fp);

}





 

?>