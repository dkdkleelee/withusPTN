<?php
require_once '../../common.php';

// header('Content-type: application/json'); 
// header('Access-Control-Allow-Origin: *');

$act = isset($_POST['act']) ? strip_tags($_POST['act']) : '';
$comm_pcd = isset($_POST['comm_pcd']) ? strip_tags($_POST['comm_pcd']) : '';

if ($act === "commonCode") {

    //공통코드리스트
    $code_sql = "
    select comm_idx
        , comm_pcd 
        , comm_pnm 
        , comm_cd 
        , comm_nm 
        , comm_bigo
    from {$g5['crm_common']}
    where 1=1 
    and use_yn = 'Y' 
    and comm_pcd = {$comm_pcd}
    ";
    $code_list = sql_query($code_sql);
    $response = "";
    
    for ($i = 0; $code = sql_fetch_array($code_list); $i++) {
        $response .= '<option value="'.$code['comm_idx'].'">'.$code['comm_nm'].'</option>';
    }

    echo json_encode($response);

} else if ($act === "dup_partner") {

    $ptn_nm = isset($_POST['ptn_nm']) ? strip_tags($_POST['ptn_nm']) : '';
    
    $dup_result = 0; 

    $dup_sql = "
    select count(*) as partnerCnt
    from {$g5['crm_partner']} a 
    where a.ptn_nm = '{$ptn_nm}'
    ";
    $row = sql_fetch($dup_sql);
    $cnt = (int)$row['partnerCnt'];

    if($cnt > 0) {
        $dup_result = 1;  //partner명 중복
    } else {
        $dup_sql = "
        select count(*) as partnerCnt
        from {$g5['crm_signup']} a 
        where a.ptn_nm = '{$ptn_nm}'
        ";
        $row = sql_fetch($dup_sql);
        $cnt = (int)$row['partnerCnt'];
    
        if($cnt > 0) {
            $dup_result = 2;  //partner명 가입대기와 중복
        }
    }

    echo json_encode((int)$dup_result);

    //echo json_encode($dup_result);

} else if ($act === "dup_member") {

    $mb_id = isset($_POST['mb_id']) ? strip_tags($_POST['mb_id']) : '';

    $dup_sql = "
    select count(*) as partnerCnt
    from {$g5['member_table']}
    where mb_id = '{$mb_id}'
    ";
    $row = sql_fetch($dup_sql);
    
    echo json_encode((int)$row['partnerCnt']);

} else if ($act === "dup_member2") {

    $row1 =  0;
    $ptn_id = isset($_POST['ptn_id']) ? strip_tags($_POST['ptn_id']) : '';

    $dup_sql1 = "
    select count(*) as partnerCnt
    from {$g5['member_table']}
    where mb_id = '{$ptn_id}'
    ";
    $row1 = sql_fetch($dup_sql1);


    $dup_sql2 = "
    select count(*) as partnerCnt
    from {$g5['crm_signup']}
    where ptn_id = '{$ptn_id}'
    ";
    $row2 = sql_fetch($dup_sql2);


    $dup_sql3 = "
    select count(*) as partnerCnt
    from {$g5['crm_partner']}
    where ptn_id = '{$ptn_id}'
    ";
    $row3 = sql_fetch($dup_sql3);


    $count = $row1['partnerCnt'] + $row2['partnerCnt'] + $row3['partnerCnt'];

    echo json_encode((int)$count);

} 
else if ($act === "load_partner") {
    $ptn_nm = isset($_POST['ptn_nm']) ? strip_tags($_POST['ptn_nm']) : '';
    
    $load_ptn = "
    select sign_idx
        ,  ptn_id
        ,  ptn_nm
        ,  ptn_reprnm
        ,  ptn_phone
        ,  ptn_tel
        ,  ptn_email
        ,  insert_date
    from {$g5['crm_signup']}
    where ptn_nm = '{$ptn_nm}'
    ";
    $row = sql_fetch($load_ptn);
    echo json_encode($row);

}
else if ($act === "modalAddPtnEmp") {
    $deptno = isset($_POST['deptno']) ? strip_tags($_POST['deptno']) : '';
    
    //고객사코드
    $partner_sql = "
    select ptn_idx
         , ptn_nm
    from {$g5['crm_partner']} 
    where use_yn = 'Y'
      and ptn_status <= 3
    and ptn_deptno = {$deptno}
    order by ptn_idx desc
    ";
    $partner_list = sql_query($partner_sql);

    $response .= '<option value="">미선택</option>';
    for ($i = 0; $partner = sql_fetch_array($partner_list); $i++) {
        $response .= '<option value="'.$partner['ptn_idx'].'">'.$partner['ptn_nm'].'</option>';
    }
    
    echo json_encode($response);

}  
else if ($act === "modalListPtnEmp") {
    $ptn_idx = isset($_POST['ptn_idx']) ? strip_tags($_POST['ptn_idx']) : '';

    $ptnEmpSql = "
    select *
    from {$g5['member_table']} 
    where is_login = 'Y'
    and mb_ptnidx = {$ptn_idx}
    ";
    $ptnEmpList = sql_query($ptnEmpSql);

    for ($i = 0; $ptnemp = sql_fetch_array($ptnEmpList); $i++) {
        $mb_gubun = $ptnemp['mb_gubun'] == 'P' ? '대표' : '직원';
        $response .= '
        <tr>
            <td>'.($i+1).'</td>
            <td>'.$ptnemp['mb_id'].'</td>
            <td>'.$ptnemp['mb_name'].'</td>
            <td>'.$ptnemp['mb_open_date'].'</td>
            <td>'.$mb_gubun.'</td>
            <td>
            <button type="button" class="btn btn-primary btn-xs listbtn" onclick="initPw(\''.$ptnemp['mb_id'].'\');">초기화</button>
            <button type="button" class="btn btn-danger btn-xs listbtn" onclick="delPtnEmp('.$ptnemp['mb_no'].');">삭제</button>
            </td>
        </tr>
        ';
    }
    echo json_encode($response);
} else if ($act === "initPtnEmpPW") {
    
    $mb_id = isset($_POST['mb_id']) ? strip_tags($_POST['mb_id']) : '';
    $encode_pw = get_encrypt_string($mb_id); 

    $sql = "
    update {$g5['member_table']} set
        mb_password = '{$encode_pw}'
      , is_lock = 'Y'
    where mb_id = '$mb_id'
    ";
    isSqlError(sql_query($sql), $sql);

    echo json_encode("초기화처리하였습니다.");
} else if ($act === "delPtnEmp") {
    
    $mb_no = isset($_POST['mb_no']) ? strip_tags($_POST['mb_no']) : '';

    $sql = "
    delete from {$g5['member_table']}
    where mb_no = '$mb_no'
    ";
    isSqlError(sql_query($sql), $sql);
    echo json_encode("삭제하였습니다.");
    
} else if ($act === "dup_email") {
    
    $mb_email = isset($_POST['mb_email']) ? strip_tags($_POST['mb_email']) : '';

    $dup_sql = "
    select count(*) as emailCnt
    from {$g5['member_table']}
    where mb_email = '{$mb_email}'
    ";
    $row = sql_fetch($dup_sql);
    
    echo json_encode((int)$row['emailCnt']);
    
} 




