<?php
require_once '../../common.php';

// header('Content-type: application/json'); 
// header('Access-Control-Allow-Origin: *');

$act = isset($_POST['act']) ? strip_tags($_POST['act']) : '';


if ($act === "open_memo_modal") {

    $land_idx = isset($_POST['land_idx']) ? strip_tags($_POST['land_idx']) : '';

    $partner_sql = "
    select *
    from {$g5['crm_landing']} 
    where land_idx = {$land_idx}
    ";
    $resultOne = sql_fetch($partner_sql);

    if ($resultOne) {
        $result_memo = htmlspecialchars($resultOne['land_memo'], ENT_QUOTES, 'UTF-8');
        // 결과를 객체로 만들어 반환
        $response = ['memoText' => $result_memo];
    } else {
        $response = ['memoText' => ''];
    }

    echo json_encode($response);
} else if ($act === 'save_memo_modal') {
    $land_idx = isset($_POST['land_idx']) ? strip_tags($_POST['land_idx']) : '';
    $mstMemo = isset($_POST['mstMemo']) ? strip_tags($_POST['mstMemo']) : '';

    $query = "UPDATE {$g5['crm_landing']}  SET land_memo = '{$mstMemo}' WHERE land_idx = {$land_idx}";
    isSqlError(sql_query($query), $query);

    echo json_encode(['status' => 'success', 'message' => '메모가 저장되었습니다.']);

}


?>