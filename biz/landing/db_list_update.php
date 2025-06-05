<?php
require_once '../../common.php';

$act_button     = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

if($act_button == "엑셀다운") {

    $sql_item = "
    SELECT
        GROUP_CONCAT(DISTINCT pg_chk_data1 ORDER BY pg_chk_data1 SEPARATOR '') AS pg_chk_data1,
        GROUP_CONCAT(DISTINCT pg_chk_data2 ORDER BY pg_chk_data2 SEPARATOR '') AS pg_chk_data2,
        GROUP_CONCAT(DISTINCT pg_chk_data3 ORDER BY pg_chk_data3 SEPARATOR '') AS pg_chk_data3,
        GROUP_CONCAT(DISTINCT pg_chk_data4 ORDER BY pg_chk_data4 SEPARATOR '') AS pg_chk_data4,
        GROUP_CONCAT(DISTINCT pg_chk_data5 ORDER BY pg_chk_data5 SEPARATOR '') AS pg_chk_data5,
        GROUP_CONCAT(DISTINCT pg_chk_data6 ORDER BY pg_chk_data6 SEPARATOR '') AS pg_chk_data6,
        GROUP_CONCAT(DISTINCT pg_chk_data7 ORDER BY pg_chk_data7 SEPARATOR '') AS pg_chk_data7,
        GROUP_CONCAT(DISTINCT pg_chk_data8 ORDER BY pg_chk_data8 SEPARATOR '') AS pg_chk_data8,
        GROUP_CONCAT(DISTINCT pg_chk_data9 ORDER BY pg_chk_data9 SEPARATOR '') AS pg_chk_data9,
        GROUP_CONCAT(DISTINCT pg_chk_code  ORDER BY pg_chk_code  SEPARATOR '') AS pg_chk_code,
        GROUP_CONCAT(DISTINCT pg_chk_utm   ORDER BY pg_chk_utm   SEPARATOR '') AS pg_chk_utm,
        GROUP_CONCAT(DISTINCT pg_chk_ip    ORDER BY pg_chk_ip    SEPARATOR '') AS pg_chk_ip
    FROM {$g5['crm_page']}
    where pg_ptn_idx = {$member['mb_ptnidx']}
    ";
    $items = sql_fetch($sql_item);

    $pg_chk_data1 = $items['pg_chk_data1'];
    $pg_chk_data2 = $items['pg_chk_data2'];
    $pg_chk_data3 = $items['pg_chk_data3'];
    $pg_chk_data4 = $items['pg_chk_data4'];
    $pg_chk_data5 = $items['pg_chk_data5'];
    $pg_chk_data6 = $items['pg_chk_data6'];
    $pg_chk_data7 = $items['pg_chk_data7'];
    $pg_chk_data8 = $items['pg_chk_data8'];
    $pg_chk_data9 = $items['pg_chk_data9'];

    $dynamicColumnCount = 0;
    $dynamicHeaders = [
        $pg_chk_data1, $pg_chk_data2, $pg_chk_data3, $pg_chk_data4,
        $pg_chk_data5, $pg_chk_data6, $pg_chk_data7, $pg_chk_data8, $pg_chk_data9
    ];

    // 각 컬럼에 대해 값이 존재하는지 확인
    foreach ($items as $key => $value) {
        if (!empty($value)) {
            if($key == "pg_chk_code" || $key == "pg_chk_utm" || $key == "pg_chk_ip") {
                continue;
            }
            $dynamicColumnCount++;
        }
    }

    if($member['mb_gubun'] == "P") {
        //대표
        $sql_search .= "
        where a.use_yn = 'Y'
        and a.land_ptn_idx = {$member['mb_ptnidx']}
        ";
        
    } else {
        //직원
        $sql_search .= "
        where a.use_yn = 'Y'
        and a.land_ptn_idx = {$member['mb_ptnidx']}
        and b.pg_mb_ptn = {$member['mb_no']}
        ";
    }
    
    // if($stx != "") {
    //     switch ($sfl) {
    
    //         case "insert_date":
    //             $split = explode("  ",$stx); 

    //             $from = substr($stx,0,10);
    //             $to   = substr($stx,10,10);

    //             $today = date("Y-m-d");
    //             if($to == $today) {
    //                 $current_time = date("H:i:s");
    //             } else if($to < $today) {
    //                 $current_time = '23:59:59.999';
    //             } else if($to > $today) {
    //                 $current_time = date("H:i:s");
    //             }
                
    //             $sql_search .= " and a.$sfl between '{$from} 00:00:00.000' and '{$to} {$current_time}'";
    
    //             break;
    //         case "tel":
    //             $sql_search .= "and tel = '$stx' ";
    //             break;
    //     }
    // } 

    $hist_memo = "";

    if($stx_phone == "" && $stx_name == "" && $stx_db_status == "" && $stx_fromto == "") {

        $timestamp = strtotime("-1 months");
        $from = date("Y-m-d", $timestamp);
    
        $timestamp = strtotime("Now");
        $to = date("Y-m-d", $timestamp);
    
        $sql_search .= " and a.insert_date between '{$from} 00:00:00.000' and now()";

        $hist_memo .= "일자:{$from}~{$to} || ";

    } else {
        if($stx_phone) {

            $hist_memo .= "연락처:{$stx_phone} || ";
            $sql_search .= "and tel = '$stx_phone' ";
        } 
        if($stx_name) {
            $hist_memo .= "이름:{$stx_name} || ";
            $sql_search .= "and name = '$stx_name' ";
        } 
        if($stx_db_status) {
            $hist_memo .= "상태:{$stx_db_status} || ";
            $sql_search .= "and db_status = '$stx_db_status' ";
        } 
        if($stx_fromto) {
            $split = explode("  ",$stx_fromto); 
            $from = substr($stx_fromto,0,10);
            $to   = substr($stx_fromto,13,10);
            $hist_memo .= "일자:{$from}~{$to} || ";
            
            $today = date("Y-m-d");
            if($to == $today) {
                $current_time = date("H:i:s");
            } else if($to < $today) {
                $current_time = '23:59:59.999';
            } else if($to > $today) {
                $current_time = date("H:i:s");
            }
            $sql_search .= " and a.insert_date between '{$from} 00:00:00.000' and '{$to} {$current_time}'";
        }
    }


    $sql = "
    select 
      a.land_idx 
    , a.land_pg_idx
    , a.name 
    , convert(aes_decrypt(unhex(a.tel), 'gonpdk_secret_key') using utf8) as tel";
    // dynamicColumnCount에 따라 option 컬럼 추가
    for ($i = 1; $i <= count($dynamicHeaders); $i++) {
    if (!empty($dynamicHeaders[$i - 1])) {
        $sql .= ", a.option" . $i;
    }
}
    $sql .= "
    , b.pg_chk_code
    , a.utm_source
    , b.pg_chk_ip
    , case a.db_status
      when '1' then '부재'
      when '2' then '결번'
      when '3' then '거절'
      when '4' then '승인'
      when '5' then '리콜'
      when '6' then '가망'
      else ''
      end as db_status
    , a.land_memo
    , a.insert_date 
    , a.client_ip
    , b.pg_domain
    , b.pg_uri
    , b.pg_inflow
    from {$g5['crm_landing']} a
    left join {$g5['crm_page']} b on a.land_pg_idx = b.page_idx
    {$sql_search}
    order by a.insert_date desc";
    
    
    $result = sql_query($sql);
    $result_cnt = mysqli_num_rows($result);
    if($result_cnt == 0) {
        alert("다운로드 할 엑셀 데이터가 존재하지않습니다.");
    }
    
    
    $table_header = "
    <table border='1'>
    <thead>
    </thead>
    <tbody>
    ";

    $EXCEL_STR = "
        <table border='1'>
        <tr>
        <td>NO</td>
        <td>이름</td>
        <td>연락처</td>";
        foreach ($dynamicHeaders as $header) {
            if (!empty($header)) {
                $EXCEL_STR .= "<td>{$header}</td>";
            }
        }
        $EXCEL_STR .= "
        <td>기타</td>
        <td>등록일시</td>
        <td>상태</td>
        <td>메모</td>";
        if($items['pg_chk_code'] == "1") {
            $EXCEL_STR .= "
            <td>경로</td>";
        }
        if($items['pg_chk_utm'] == "1") {
            $EXCEL_STR .= "
            <td>UTM</td>";
        }
        if($items['pg_chk_ip'] == "1") {
            $EXCEL_STR .= "
            <td>아이피</td>";
        }
        

        $EXCEL_STR .= "
        </tr>";

        $i = 1;
        while ($res = sql_fetch_array( $result )) {
            $EXCEL_STR .= "  
            <tr>  
                <td>".$i."</td>  
                <td>".$res['name']."</td>
                <td>".$res['tel']."</td>";
                foreach ($dynamicHeaders as $index => $header) {
                    if (!empty($header)) {
                        $userDataKey = 'option' . ($index + 1);
                        $EXCEL_STR .= "<td>" . (isset($res[$userDataKey]) ? $res[$userDataKey] : '') . "</td>";
                    }
                }
                $EXCEL_STR .= "
                <td>".$res['pg_inflow']."</td>
                <td>".$res['insert_date']."</td>
                <td>".$res['db_status']."</td>
                <td>".$res['land_memo']."</td>";
                if($items['pg_chk_code'] == "1") {
                    $EXCEL_STR .= "
                    <td>".$res['pg_uri']."</td>";
                }
                if($items['pg_chk_utm'] == "1") {
                    $EXCEL_STR .= "
                    <td>".$res['utm_source']."</td>";
                }
                if($items['pg_chk_ip'] == "1") {
                    $EXCEL_STR .= "
                    <td>".$res['client_ip']."</td>";
                }
            $EXCEL_STR .= "
            </tr>";  
        
            $i = $i + 1;
        }
        
        $EXCEL_STR .= "</table>";


        

        $hist_memo = rtrim($hist_memo, "|| ");
        $ip = $_SERVER["HTTP_CF_CONNECTING_IP"] ?? $_SERVER['REMOTE_ADDR'];
        $record_hist_sql = "
        insert into gnp_record_hist (hist_join_gubun, hist_function, hist_mb_no, hist_mb_name, hist_detail, client_ip) values
        ('고객사', 'exceldown', '{$member['mb_no']}','{$member['mb_name']}','{$hist_memo}','{$ip}');
        ";
        isSqlError(sql_query($record_hist_sql), $record_hist_sql);
    
    
    
        
    
    
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=엑셀다운로드_".date("Ymd_Hms").".xls" );
    header("Content-Description: PHP4 Generated Data");
    header("Pragma: no-cache");
    header("Expires: 0");
    print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");
    
    echo $EXCEL_STR;



} else if($act_button == "선택수정") {

    $post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
    $chk            = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
    
    if (!$post_count_chk) {
        alert($act_button . '체크 한개이상 선택해주세요.');
    }

    for ($i = 0; $i < $post_count_chk; $i++) {

        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
        $land_idx     = isset($_POST['land_idx'][$k]) ? strip_tags(clean_xss_attributes($_POST['land_idx'][$k])) : '';
        $db_status    = isset($_POST['db_status'][$k]) ? strip_tags(clean_xss_attributes($_POST['db_status'][$k])) : '';
        $land_memo    = isset($_POST['land_memo'][$k]) ? strip_tags(clean_xss_attributes($_POST['land_memo'][$k])) : '';
    
        $upd_sql = "
        update {$g5['crm_landing']} set
              db_status = '{$db_status}'
            , land_memo = '{$land_memo}'
            , update_date = now()
        where land_idx = {$land_idx}
        ";
        isSqlError(sql_query($upd_sql), $upd_sql);
    }

    $params = [
        'stx_phone' => $stx_phone,
        'stx_name' => $stx_name,
        'stx_db_status' => $stx_db_status,
        'stx_fromto' => $stx_fromto
    ];
    
    $qstr = http_build_query($params);
    
    goto_url('./db_list?' . $qstr);
}

