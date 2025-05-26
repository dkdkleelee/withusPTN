<?php
require_once '../../common.php';

$g5['title'] = "DB조회";
include_once(G5_PATH . '/head.php');

$sql_columns    = "";
$sql_common     = "";
$sql_search     = "";
$sql_gruop      = "";
$sql_order      = "";
$total_count    = 0;

$dataTbl = "visible: false,";

$sql_search = "where 1=1 ";

$is_first = false;


$first_condition_added = false;


if($member['mb_gubun'] == "P") {
    //대표
    $sql_search .= "
    and a.use_yn = 'Y'
    and b.page_idx is not null
    and a.land_ptn_idx = {$member['mb_ptnidx']}
    ";
    
} else {
    //직원
    $sql_search .= "
    and a.use_yn = 'Y'
    and b.page_idx is not null
    and a.land_ptn_idx = {$member['mb_ptnidx']}
    and b.pg_mb_ptn = {$member['mb_no']}
    ";
}

//$sql_search .= " and a.insert_date <= now() ";



if ($stx_phone) {
    $sql_search .= " and tel = HEX(AES_ENCRYPT('{$stx_phone}', 'withus_secret_key')) ";
}

if ($stx_name) {
    $sql_search .= " and name like '%{$stx_name}%' ";
}

if ($stx_db_status) {

    if($stx_db_status == "wait") {
        $sql_search .= "and db_status is null";
    } else {
        $sql_search .= " and db_status = {$stx_db_status} ";
    }
    
}

if ($stx_pg_inflow) {
    $sql_search .= " and pg_inflow like '%{$stx_pg_inflow}%' ";
}

if ($stx_fromto) {

    $from = substr($stx_fromto,0,10);
    $to   = substr($stx_fromto,11,10);

    $today = date("Y-m-d");
    if($to == $today) {
        $current_time = date("H:i:s");
    } else if($to < $today) {
        $current_time = '23:59:59.999';
    } else if($to > $today) {
        $current_time = date("H:i:s");
    }

    $sql_search .= "and a.insert_date between '{$from} 00:00:00.000' and '{$to} {$current_time}' ";
} else {
    $sql_search .= " and a.insert_date <= now() ";
}


$sql_common = "
select a.land_idx 
     , a.land_pg_idx
     , a.name 
     , convert(aes_decrypt(unhex(a.tel), 'withus_secret_key') using utf8) as tel
     , a.option1
     , a.option2
     , a.option3
     , a.option4
     , a.option5
     , a.option6
     , a.option7
     , a.option8
     , a.option9
     , a.db_status
     , a.land_memo
     , a.insert_date 
     , a.client_ip
     , a.utm_source
     , b.pg_domain
     , b.pg_uri
     , b.pg_inflow
    from gnp_crm_landing a
    left join gnp_crm_page b on a.land_pg_idx = b.page_idx
    {$sql_search}
";


$cnt_sql = "
select count(*) as cnt
from {$g5['crm_landing']} a
left join {$g5['crm_page']} b on a.land_pg_idx = b.page_idx
{$sql_search}
";
$row = sql_fetch($cnt_sql);
$total_count = $row['cnt'];

//$rows = $config['cf_page_rows'];
$rows = 50;
$total_page  = ceil($total_count / $rows);
if ($page < 1) {
    $page = 1;
}
$from_record = ($page - 1) * $rows;

if (!$sst) {
    //$sql_order = "order by a.land_idx desc";
    $sql_order = "order by a.insert_date desc";
}else{
    $sql_order = " order by $sst $sod ";    
}

//$sql = " select {$sql_columns} {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$sql = " {$sql_columns} {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);


//temp hardcoding
$is_show_addopt = false;
$show_gubun = "";

$rownum = $total_count - $from_record;


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


// 각 input 값들을 변수에 저장합니다.
$stx_phone = $stx_phone;
$stx_name = $stx_name;
$stx_db_status = $stx_db_status;
$stx_fromto = $stx_fromto;

// key-value 형태의 배열 생성
$stx_array = array(
    'stx_phone' => $stx_phone,
    'stx_name' => $stx_name,
    'stx_db_status' => $stx_db_status,
    'stx_fromto' => $stx_fromto
);

// 배열을 JSON 형식으로 인코딩
// $stx_json = json_encode($stx_array);

$ptn_info = "
SELECT *
FROM {$g5['crm_partner']}
where ptn_idx = {$member['mb_ptnidx']}
";
$ptn = sql_fetch($ptn_info);

$ptn_is_upload = $ptn['ptn_is_upload'];
$ptn_is_tooltip = $ptn['ptn_is_tooltip'];
$ptn_status_custom = $ptn['ptn_status_custom'];

if($ptn_is_upload == "Y") {
    $ptn_html = '
    <button type="button" class="btn btn-info btn-xs border border-dark" data-toggle="modal" data-target="#modal-exc-upload">
        <i class="fas fa-file-upload"></i> 엑셀업로드
    </button>
    ';

}



// pg_inflow 있는지 확인
$sql_check_pg_inflow = "
SELECT COUNT(*) AS pg_inflow_count
FROM gnp_crm_landing a
LEFT JOIN gnp_crm_page b ON a.land_pg_idx = b.page_idx
{$sql_search} 
AND (b.pg_inflow IS NOT NULL AND b.pg_inflow != '')
";
$result_check_pg_inflow = sql_fetch($sql_check_pg_inflow);
$pg_inflow_count = $result_check_pg_inflow['pg_inflow_count'];


$is_pg_inflow = false;
if ($pg_inflow_count > 0) {
    $is_pg_inflow = true;
}


if($member['mb_ptnidx'] == 1215) {
    $sql_dup_ip = "
    SELECT client_ip
    FROM gnp_crm_landing a
    LEFT JOIN gnp_crm_page b ON a.land_pg_idx = b.page_idx
    WHERE a.use_yn = 'Y'
    AND b.page_idx IS NOT NULL
    AND a.land_ptn_idx = {$member['mb_ptnidx']}
    GROUP BY client_ip
    HAVING COUNT(*) > 1
    ";

    $dup_ip_result = sql_query($sql_dup_ip);
    $dup_ip_list = [];
    while ($row = sql_fetch_array($dup_ip_result)) {
        $dup_ip_list[$row['client_ip']] = true;
    }
}

?>
<link rel="stylesheet" href="<?php echo G5_THEME_URL?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo G5_THEME_URL?>/plugins/daterangepicker/daterangepicker.css">

<script src="<?php echo G5_THEME_URL?>/plugins/moment/moment.min.js"></script>
<script src="<?php echo G5_THEME_URL?>/plugins/daterangepicker/daterangepicker.js"></script>

<style>

td input[type="text"], td select {
    width: 100%;
    box-sizing: border-box;
}

#tbl_land td, #tbl_land th {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.tooltip.tooltip-custom .tooltip-inner {
    background-color: #333 !important;
    color: #fff !important;
    font-size: 16px;
    padding: 10px 15px;
    border-radius: 5px;
    max-width: 300px;
}
.tooltip.tooltip-custom .arrow::before {
    border-top-color: #333 !important;
    border-right-color: #333 !important;
    border-bottom-color: #333 !important;
    border-left-color: #333 !important;
}

.memo-field {
    min-width: 200px;
}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">데이터 (<?php echo number_format($total_count) ?>건)</h3>
                    </div>
                    <div class="card-body">
                        <div class="dataTables_wrapper dt-bootstrap4">
                        <div class="card shadow mb-4">
  <div class="card-body">
    <div class="row align-items-end">

      <!-- 왼쪽: 엑셀/수정 버튼 -->
      <div class="col-md-4 mb-3">
        <div class="btn-group">
          <button type="submit" form="listForm" class="btn btn-success btn-sm border border-dark" name="act_button" value="엑셀다운">
            <i class="fas fa-file-download"></i> 다운
          </button>
          <?php echo $ptn_html ?>
          <button type="submit" form="listForm" class="btn btn-primary btn-sm border border-dark" name="act_button" value="선택수정">
            <i class="fas fa-eraser"></i> 수정
          </button>
        </div>
      </div>

      <!-- 오른쪽: 검색 필터 -->
      <div class="col-md-8">
        <form class="row g-2" method="get" action="">
          <div class="col-md-3">
            <label for="search_phone" class="form-label">연락처</label>
            <input type="text" id="search_phone" name="stx_phone" value="<?php echo $stx_phone ?>" class="form-control" placeholder="연락처" oninput="telHyphen(this);" minlength="13" maxlength="13">
          </div>
          <div class="col-md-2">
            <label for="search_name" class="form-label">이름</label>
            <input type="text" id="search_name" name="stx_name" value="<?php echo $stx_name ?>" class="form-control" placeholder="이름">
          </div>
          <div class="col-md-2">
            <div class="form-group">
                <label for="search_db_status">진행</label>
                <select id="search_db_status" name="stx_db_status" class="form-control">
                <option value="">전체</option>
                <?php
                if ($ptn_status_custom == "basic") {
                    echo '<option value="wait"  '.get_selected($stx_db_status, 'wait').'>대기</option>';
                    echo '<option value="1" '.get_selected($stx_db_status, '1').'>부재</option>';
                    echo '<option value="2" '.get_selected($stx_db_status, '2').'>불량</option>';
                    echo '<option value="3" '.get_selected($stx_db_status, '3').'>거절</option>';
                    echo '<option value="4" '.get_selected($stx_db_status, '4').'>리콜</option>';
                    echo '<option value="5" '.get_selected($stx_db_status, '5').'>중복</option>';
                    echo '<option value="6" '.get_selected($stx_db_status, '6').'>유망</option>';
                    echo '<option value="7" '.get_selected($stx_db_status, '7').'>승인</option>';
                } else {
                    if (!empty($ptn_status_custom)) {
                    $customOptions = explode('||', $ptn_status_custom);
                    foreach ($customOptions as $option) {
                        $parts = explode(':', $option, 2);
                        if (count($parts) == 2) {
                        $value = htmlspecialchars(trim($parts[0]));
                        $label = htmlspecialchars(trim($parts[1]));
                        echo '<option value="'.$value.'" '.get_selected($stx_db_status, $value).'>'.$label.'</option>';
                        }
                    }
                    }
                }
                ?>
                </select>
            </div>
            </div>

          <?php if($is_pg_inflow == true) { ?>
          <div class="col-md-2">
            <label for="stx_pg_inflow" class="form-label">유입</label>
            <input type="text" id="stx_pg_inflow" name="stx_pg_inflow" value="<?php echo $stx_pg_inflow ?>" class="form-control" placeholder="유입">
          </div>
          <?php } ?>

          <div class="col-md-2">
            <label for="search_fromto" class="form-label">일자</label>
            <input type="text" id="search_fromto" name="stx_fromto" value="<?php echo $stx_fromto ?>" class="form-control" placeholder="YYYY-MM-DD~YYYY-MM-DD">
          </div>

          <div class="col-md-1">
            <label class="form-label d-block">&nbsp;</label>
            <button type="submit" class="btn btn-outline-success w-100">검색</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>


                        
                            <form name="listForm" id="listForm" action="./db_list_update" onsubmit="return listForm_submit(this);" method="post">

                                <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                                <input type="hidden" name="stx" value="<?php echo $stx ?>">

                                <input type="hidden" name="stx_phone" value="<?php echo $stx_phone ?>">
                                <input type="hidden" name="stx_name" value="<?php echo $stx_name ?>">
                                <input type="hidden" name="stx_db_status" value="<?php echo $stx_db_status ?>">
                                <input type="hidden" name="stx_fromto" value="<?php echo $stx_fromto ?>">

                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="table-responsive" id="scrollableTable" style="position: relative;">                                       
                                        <table id="tbl_land" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="text-center" name="chkall" value="1" id="chkall" onclick="check_all(this.form)"></th>
                                                    <th class="text-center">NUM</th>
                                                    <th class="text-center">이름</th>
                                                    <th class="text-center">연락처</th>
                                                    <th class="text-center">등록일</th>
                                                    <th class="text-center">진행</th>
                                                    <th>메모</th>
                                                    
                                                    <?php 
                                                    foreach ($dynamicHeaders as $header) {
                                                        if (!empty($header)) {
                                                            echo "<th>{$header}</th>";
                                                        }
                                                    }
                                                    ?>
                                                    <th>기타</th>
                                                    
                                                    <?php 
                                                    if($items['pg_chk_code'] == "1") {
                                                        echo "<th>경로</th>";
                                                    }
                                                    if($items['pg_chk_utm'] == "1") {
                                                        echo "<th>UTM</th>";
                                                    }
                                                    if($items['pg_chk_ip'] == "1") {
                                                        echo "<th>아이피</th>";
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php for ($i = 0; $row = sql_fetch_array($result); $i++) { ?>
                                            <tr style="<?php echo $row['db_status'] == '2' || $row['db_status'] == '3' ? 'text-decoration: line-through; text-decoration-color: red;' : '' ?>">
                                                <td>
                                                    <input type="hidden" name="land_idx[<?php echo $i ?>]" value="<?php echo $row['land_idx'] ?>">
                                                    <input type="checkbox" id="chk_<?php echo $i ?>" name="chk[]" value="<?php echo $i ?>">
                                                </td>
                                                
                                                <td class="text-center">
                                                    <a href="db_form?w=u&land_idx=<?php echo $row['land_idx'] . '&' . ltrim($qstr, '?'); ?>">
                                                        <?php echo $rownum; $rownum = $rownum - 1 ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="db_form?w=u&land_idx=<?php echo $row['land_idx'] . '&' . ltrim($qstr, '?'); ?>">
                                                        <?php echo $row['name'] == "" ? 'N/A': $row['name'] ?>
                                                    </a>
                                                    
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $row['tel'] ?>
                                                </td>

                                                <td>
                                                    <?php echo view_dateformat2($row['insert_date']); ?>
                                                </td>

                                                <td>
                                                    <select name="db_status[]" id="db_status" class="form-control" style="color:<?php echo $color; ?>">
                                                    <?php
                                                    if ($ptn_status_custom == "basic") {
                                                        echo '<option value=""'.get_selected($row['db_status'], '').'>대기</option>';
                                                        echo '<option value="1"'.get_selected($row['db_status'], '1').'>부재</option>';
                                                        echo '<option value="2"'.get_selected($row['db_status'], '2').'>불량</option>';
                                                        echo '<option value="3"'.get_selected($row['db_status'], '3').'>거절</option>';
                                                        echo '<option value="4"'.get_selected($row['db_status'], '4').'>리콜</option>';
                                                        echo '<option value="5"'.get_selected($row['db_status'], '5').'>중복</option>';
                                                        echo '<option value="6"'.get_selected($row['db_status'], '6').'>유망</option>';
                                                        echo '<option value="7"'.get_selected($row['db_status'], '7').'>승인</option>';
                                                    } else {
                                                        if (!empty($ptn_status_custom)) {
                                                            $customOptions = explode('||', $ptn_status_custom);
                                                            foreach ($customOptions as $option) {
                                                                // 각 옵션을 "값:라벨"로 분리
                                                                $parts = explode(':', $option, 2);
                                                                if (count($parts) == 2) {
                                                                    $value = htmlspecialchars(trim($parts[0]));
                                                                    $label = htmlspecialchars(trim($parts[1]));
                                                                    echo '<option value="'.$value.'" style="color:black" '.get_selected($row['db_status'], $value).'>'.$label.'</option>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" id="land_memo" name="land_memo[]" 
                                                        class="custom_select border border-light memo-field" 
                                                        value="<?php echo htmlspecialchars($row['land_memo']); ?>" 
                                                        data-toggle="tooltip" 
                                                        title="<?php echo htmlspecialchars($row['land_memo']); ?>">
                                                </td>


                                                <?php
                                                // 설정된 $dynamicColumnCount에 따라 userData1부터 userDataN까지 td 출력
                                                for ($n = 1; $n <= 9; $n++) {
                                                    $pg_chk_data_var = 'pg_chk_data' . $n;
                                                    $userDataKey = 'option' . $n;
                                                    if (!empty($items[$pg_chk_data_var])) {
                                                        echo "<td>";
                                                        echo isset($row[$userDataKey]) ? $row[$userDataKey] : '';
                                                        echo "</td>";
                                                    }
                                                }
                                                ?>

                                                <td>
                                                    <?php echo $row['pg_inflow'] ?>
                                                </td>

                                                <?php 
                                                    if($items['pg_chk_code'] == "1") {
                                                        echo "<td><a href='https://".$row['pg_domain'] . '/' . $row['pg_uri']."' target='_blank'>{$row['pg_uri']}</a></td>";
                                                    }
                                                    if($items['pg_chk_utm'] == "1") {
                                                        echo "<td>{$row['utm_source']}</td>";
                                                    }
                                                    if ($items['pg_chk_ip'] == "1") {
                                                        $ip = $row['client_ip'];
                                                    }
                                                    ?>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center justify-content-sm-end">
                                    <?php echo get_paging_advanced(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page=', $stx_array); ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="modal-exc-upload" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title">엑셀 업로드 <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="엑셀업로드시 빈셀에 커서있을시 에러가 날수있습니다."></i></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modal_form" name="modal_form" action="./db_excel" method="post" onSubmit="return validateForm2()" enctype="multipart/form-data">
                <input type="hidden" name="sst" value="<?php echo $sst ?>">
                <input type="hidden" name="sod" value="<?php echo $sod ?>">
                <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                <input type="hidden" name="stx" value="<?php echo $stx ?>">
                <input type="hidden" name="page" value="<?php echo $page ?>">

                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">진행값</span>
                        </div>
                        <select id="db_status" name="db_status" class="form-control" data-style="border border-secondary">
                            <option value="0">엑셀 지정 </option>
                            <option value="1">일괄 부재 </option>
                            <option value="2">일괄 불량 </option>
                            <option value="3">일괄 거절 </option>                      
                            <option value="4">일괄 리콜 </option>
                            <option value="5">일괄 중복 </option>
                            <option value="6">일괄 유망 </option>
                            <option value="7">일괄 승인 </option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" id="fileInput" name="file" class="custom-file-input" aria-describedby="fileInput">
                                <label class="custom-file-label" for="fileInput">파일선택</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
                    <button type="submit" class="btn btn-default" name="act_button" value="양식다운"><i class="fas fa-download"></i> 양식다운</button>
                    <button type="submit" class="btn btn-primary" name="act_button" value="업로드">업로드</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]',
            template: '<div class="tooltip tooltip-custom" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });

        document.querySelector('.custom-file-input').addEventListener('change',function(e){
            var fileName = document.getElementById("fileInput").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        })

        $('#search_fromto').on('input', function() {
            var value = $(this).val();
            var dateRegex = /^\d{4}-\d{2}-\d{2}~\d{4}-\d{2}-\d{2}$/;

            if (!dateRegex.test(value)) {
                // 날짜 형식이 아니면 daterangepicker 인스턴스 제거
                if ($(this).data('daterangepicker')) {
                    $(this).data('daterangepicker').remove();
                    $(this).val(''); // 입력값 초기화
                }
            }
        });

        $('#search_fromto').on('click', function() {
            var value = $(this).val();
            var dateRegex = /^\d{4}-\d{2}-\d{2}~\d{4}-\d{2}-\d{2}$/;

            if (dateRegex.test(value)) {
                // 필드 값이 유효한 날짜 형식일 때
                if ($(this).data('daterangepicker')) {
                    // 이미 daterangepicker 인스턴스가 있으면 열기
                    $(this).data('daterangepicker').show();
                } else {
                    // daterangepicker 인스턴스가 없으면 새로 만들기
                    make_datepicker("1");
                }
            } else if (!value) {
                // 필드가 비어있으면 make_datepicker() 호출
                make_datepicker("2");
            }
        });

        var dynamicColumnCount = <?php echo $dynamicColumnCount; ?>;

        var columnDefs = [
            {targets: 0, width: '1%', className: 'col-checkbox'},
            {targets: 1, width: '1%'},
            {targets: 2, width: '1%'},
            {targets: 3, width: '1%'},
            {targets: 4, width: '1%'},
            {targets: 5, width: '4%'},
            {targets: 6, width: '10%'},
        ];

        var ptnIsTooltip = '<?php echo $ptn_is_tooltip; ?>';

        for (var i = 0; i < dynamicColumnCount; i++) {
            columnDefs.push({
                targets: 7 + i,
                width: '1%',
                render: function(data, type, row) {
                    if (type === 'display' && data) {
                        // ptn_is_tooltip 값이 'Y'인 경우에만 20자 초과 시 툴팁 처리
                        if (ptnIsTooltip === 'Y') {
                            var fullData = data.toString();
                            if (fullData.length > 20) {
                                var truncated = fullData.substring(0, 20) + '...';
                                return '<span class="memo-field" data-toggle="tooltip" title="' + fullData + '">' + truncated + '</span>';
                            } else {
                                return fullData;
                            }
                        } else {
                            // Y가 아닐 경우 원래 데이터 그대로 반환
                            return data;
                        }
                    }
                    return data;
                }
            });
        }

        columnDefs.push({targets: columnDefs.length, width: '1%'});

        var is_show_cd = '<?php echo $items['pg_chk_code'] ?>';
        var is_show_utm = '<?php echo $items['pg_chk_utm'] ?>';
        var is_show_ip = '<?php echo $items['pg_chk_ip'] ?>';

        if(is_show_cd == "1") {
            columnDefs.push({targets: columnDefs.length, width: '1%'});
        }  
        if(is_show_utm == "1") {
            columnDefs.push({targets: columnDefs.length, width: '1%'});
        }  
        if(is_show_ip == "1") {
            columnDefs.push({targets: columnDefs.length, width: '1%'});
        }

        var table = $('#tbl_land').DataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            columnDefs: columnDefs
        });

        var columnIndex = 7;
        var newWidth = '200px';
        table.column(columnIndex).nodes().to$().find('td').css('width', newWidth);
        

        // 특정 이벤트에서 변경 여부 플래그 설정 (예: 변경될 때)
        $('#tbl_land tbody').on('change', 'input, select', function() {
            var row = table.row($(this).closest('tr'));
            // 첫 번째 열의 checkbox 선택
            $('td:eq(0) input[type="checkbox"]', row.node()).prop('checked', true);
        });
    });

    function make_datepicker(value){

        var stx = '<?php echo $stx_fromto ?>';
        var maxDay = moment().format("YYYY-MM-DD");

        if(stx == "") { 
            startDay = moment().add(-1, 'month');
            endDay = moment().format("YYYY-MM-DD");
        } else {
            var db_date = stx.split("~");
            var startDay = db_date[0];
            var endDay = db_date[1];
        }
            
        $('#search_fromto').daterangepicker({
            locale: {
                "format": "YYYY-MM-DD",
                "separator": "~",
                "applyLabel": "확인",
                "cancelLabel": "취소",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": ["일", "월", "화", "수", "목", "금", "토"],
                "monthNames": ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
            },
            //minDate: minDay,
            maxDate: maxDay,
            showDropdowns: true,
            startDate: startDay,
            endDate: endDay

        }, function(start, end, label) {
            $('#search_fromto').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD'));
        });

        var asis = $("#search_fromto").val();
        var tobe = asis.replace(' ~ ', '~');
        $("#search_fromto").val(tobe);

        $('#search_fromto').keypress(function(e){
            if (e.keyCode == 10 || e.keyCode == 13)
                e.preventDefault();
        });
    }


    function validateForm2() {
        $('#modal-exc-upload').modal('hide');
        return true;
    }

    
</script>

<?php
include_once(G5_PATH . '/tail.php');