<?php

require_once '../../common.php';

include_once(G5_BIZ_PATH . '/common/access_control.php');

//코드리스트


$g5['title'] = "DB 수정";
$title = "DB 수정";

$resultOneSql = "
select a.land_idx
        , a.land_pg_idx
        , a.land_ptn_idx
        , a.land_deptno
        , a.land_empno
        , a.land_used_data
        , a.name
        , convert(aes_decrypt(unhex(a.tel), 'gonpdk_secret_key') using utf8) as tel
        , a.hp
        , a.tel1
        , a.tel2
        , a.tel3
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
        , a.submit_pos
        , a.inflow_path
        , a.inflow_env
        , a.utm_source
        , a.utm_medium
        , a.user_agent
        , a.user_agent2
        , a.api_send_yn
        , a.sms_send_yn
        , a.use_yn
        , a.insert_date
        , a.insert_date2
        , a.update_date
        , a.insert_user
        , a.update_user
        , a.update_log
        , a.client_ip
        , a.ip
        , a.city
        , a.region
        , a.country
        , a.loc
        , a.org
        , a.postal
        , a.timezone
        ,b.page_idx 
        ,b.pg_uri 
        ,b.pg_deptno 
        ,d.deptnm 
        ,b.pg_mb_emp 
        -- ,NULLIF (b.pg_mb_emp , f_get_mb_name(b.pg_mb_emp)) as mb_emp_name
        , f_get_mb_name(b.pg_mb_emp) as mb_emp_name
        ,b.pg_ptn_idx 
        ,f.ptn_nm 
        ,b.pg_mb_ptn 
        -- ,NULLIF (b.pg_mb_ptn , f_get_mb_name(b.pg_mb_ptn)) as mb_ptn_name
        , f_get_mb_name(b.pg_mb_ptn) as mb_ptn_name
        ,c.design_name 
    from {$g5['crm_landing']} a
    left join {$g5['crm_page']}     b on a.land_pg_idx = b.page_idx
    left join {$g5['crm_design']}   c on b.pg_des_idx  = c.design_idx 
    left join {$g5['crm_depart']}   d on b.pg_deptno   = d.deptno 
    left join {$g5['member_table']} e on b.pg_mb_emp   = e.mb_no 
    left join {$g5['crm_partner']}  f on b.pg_ptn_idx  = f.ptn_idx 
    where 1=1
    and a.land_idx = {$land_idx}
";
$resultOne = sql_fetch($resultOneSql);

$initPgUri = $resultOne['pg_uri'];


$g5['title'] = $title;
include_once(G5_PATH . '/head.php');

?>


<section class="content">
    <div class="container-fluid">
        <form name="landForm" id="landForm" action="./db_form_update" method="post" onsubmit="return validateForm()">

            <div class="card card-danger">

                <div class="card-header">
                    <h3 class="card-title">고객정보</h3>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary btn-xs" id="btn_small">등록</button>
                        <button type="button" class="btn btn-default btn-xs" id="btn_list" onclick="location.href='<?php echo G5_BIZ_URL; ?>/landing/db_list?<?php echo $qstr;?>'">목록</button>
                    </div>

                </div>

                <div class="card-body">
                    <input type="hidden" name="w" value="<?php echo $w ?>">
                    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                    <input type="hidden" name="stx" value="<?php echo $stx ?>">
                    <input type="hidden" name="sst" value="<?php echo $sst ?>">
                    <input type="hidden" name="sod" value="<?php echo $sod ?>">
                    <input type="hidden" name="page" value="<?php echo $page ?>">
                    <input type="hidden" name="token" value="">
                    <input type="hidden" name="land_idx" value="<?php echo $resultOne['land_idx'] ?>">
                    <input type="hidden" name="land_pg_idx" value="<?php echo $resultOne['land_pg_idx'] ?>">
                    <input type="hidden" name="land_ptn_idx" value="<?php echo $resultOne['land_ptn_idx'] ?>">

                    <input type="hidden" name="advanced_ptn_idx" value="<?php echo $advanced_ptn_idx ?>">
                    <input type="hidden" name="advanced_pg_uri" value="<?php echo $advanced_pg_uri ?>">
                    <input type="hidden" name="advanced_from" value="<?php echo $advanced_from ?>">
                    <input type="hidden" name="advanced_to" value="<?php echo $advanced_to ?>">
                    <input type="hidden" name="advanced_db_status" value="<?php echo $advanced_db_status ?>">

                    <input type="hidden" name="pg_api_yn" value="">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>이름</label>
                                <input type="text" id="name" name="name" class="form-control border-info" value="<?php echo $resultOne['name'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><code>연락처*</code></label>
                                <input type="text" id="tel" name="tel" class="form-control border-info" value="<?php echo $resultOne['tel'] ?>" oninput="telHyphen(this);" minlength="13" maxlength="13" pattern=".{13,13}" required  disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>항목1</label>
                                <input type="text" id="option1" name="option1" class="form-control" value="<?php echo $resultOne['option1'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>항목2</label>
                                <input type="text" id="option2" name="option2" class="form-control" value="<?php echo $resultOne['option2'] ?>" disabled>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>항목3</label>
                                <input type="text" id="option3" name="option3" class="form-control" value="<?php echo $resultOne['option3'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>항목4</label>
                                <input type="text" id="option4" name="option4" class="form-control" value="<?php echo $resultOne['option4'] ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>항목5</label>
                                <input type="text" id="option5" name="option5" class="form-control" value="<?php echo $resultOne['option5'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>항목6</label>
                                <input type="text" id="option6" name="option6" class="form-control" value="<?php echo $resultOne['option6'] ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>항목7</label>
                                <input type="text" id="option7" name="option7" class="form-control" value="<?php echo $resultOne['option7'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>항목8</label>
                                <input type="text" id="option8" name="option8" class="form-control" value="<?php echo $resultOne['option8'] ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>항목9</label>
                                <input type="text" id="option9" name="option9" class="form-control" value="<?php echo $resultOne['option9'] ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>메모</label>
                                <textarea name="land_memo" class="form-control" rows="4" placeholder="메모"><?php echo $resultOne['land_memo'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</section>

<script>
$(document).ready(function() {

    $('#pg_uri').selectpicker();

    $("#pg_uri").change(function() {
        //alert($("#pg_uri").val());
        getCodeByData($("#pg_uri").val());
    });

    <?php if($w == "") { ?>
        getCodeByData('<?php echo $initPgUri ?>');
    <?php } ?>
});
function getCodeByData(param) {

    var code = param;
    var act = "codeByData";

    var $pg_deptno = $("#pg_deptno");
    $pg_deptno.empty();

    var $pg_mb_emp = $("#pg_mb_emp");
    $pg_mb_emp.empty();

    var $pg_ptn_idx = $("#pg_ptn_idx");
    $pg_ptn_idx.empty();

    var $pg_mb_ptn = $("#pg_mb_ptn");
    $pg_mb_ptn.empty();

    var $design_name = $("#design_name");
    $design_name.empty();

    $.ajax({
        type: "post",
        data: {
            code:code,
            act: act
        },
        url: "land_ajax",
        dataType: "json",
        success:function(result) {
            $pg_deptno.val(result.pg_deptno);
            $pg_deptno.append("<option>"+result.deptnm+"</option>");

            $pg_mb_emp.val(result.pg_mb_emp);
            $pg_mb_emp.append("<option>"+result.mb_emp_name+"</option>");

            $pg_ptn_idx.val(result.pg_ptn_idx);
            $pg_ptn_idx.append("<option>"+result.ptn_nm+"</option>");

            $pg_mb_ptn.val(result.pg_mb_ptn);
            $pg_mb_ptn.append("<option>"+result.mb_ptn_name+"</option>");

            $design_name.val(result.design_name);

            $("#pg_api_yn").val(result.pg_api_yn);
            
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            alert("지금은 시스템 사정으로 요청하신 작업을 처리할 수 없습니다.\n잠시 후 다시 이용해주세요.");
            return;
        }
    });
    
}

function validateForm() {

    document.getElementById("btn_small").disabled = "disabled";
    document.getElementById("btn_normal").disabled = "disabled";

    return true;
}

</script>

<?php
include_once(G5_PATH . '/tail.php');
