<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
include_once(G5_LIB_PATH.'/register.lib.php');
include_once('./_head.sub.php');

run_event('register_form_before');

// 불법접근을 막도록 토큰생성
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);
set_session("ss_cert_no",   "");
set_session("ss_cert_hash", "");
set_session("ss_cert_type", "");

$is_social_login_modify = false;

$signup = "";
if($_GET['signup'] == "") {
    $signup = $_POST['signup'];
} else {
    $signup = $_GET['signup'];
}

$required = ($w=='') ? 'required' : '';
$readonly = ($w=='u') ? 'readonly' : '';

if ($w == 'u') {

    if ($is_admin == 'super')
            alert('관리자의 회원정보는 관리자 화면에서 수정해 주십시오.', G5_URL);

    if (!$is_member)
        alert('로그인 후 이용하여 주십시오.', G5_URL);

    if ($member['mb_id'] != $_POST['mb_id'])
        alert('로그인된 회원과 넘어온 정보가 서로 다릅니다.');

    if($_POST['mb_id'] && ! (isset($_POST['mb_password']) && $_POST['mb_password'])){
        if( ! $is_social_login_modify ){
            alert('비밀번호를 입력해 주세요.');
        }
    }

    if (isset($_POST['mb_password'])) {
        // 수정된 정보를 업데이트후 되돌아 온것이라면 비밀번호가 암호화 된채로 넘어온것임
        if (isset($_POST['is_update']) && $_POST['is_update']) {
            $tmp_password = $_POST['mb_password'];
            $pass_check = ($member['mb_password'] === $tmp_password);
        } else {
            $pass_check = check_password($_POST['mb_password'], $member['mb_password']);
        }

        if (!$pass_check)
            alert('비밀번호가 틀립니다.');
    }
    
}

if($signup == "emp") {
    if ($w == "") {

        if ($is_member) {
            goto_url(G5_URL);
        }

        // 리퍼러 체크
        referer_check();

        $agree  = preg_replace('#[^0-9]#', '', $_POST['agree']);
        $agree2 = preg_replace('#[^0-9]#', '', $_POST['agree2']);

        $member['mb_birth'] = '';
        $member['mb_sex']   = '';
        $member['mb_name']  = '';
        if (isset($_POST['birth'])) {
            $member['mb_birth'] = $_POST['birth'];
        }
        if (isset($_POST['sex'])) {
            $member['mb_sex']   = $_POST['sex'];
        }
        if (isset($_POST['mb_name'])) {
            $member['mb_name']  = $_POST['mb_name'];
        }

        $g5['title'] = '회원 가입';

    } else if ($w == 'u') {

        $g5['title'] = '회원 정보 수정';

        set_session("ss_reg_mb_name", $member['mb_name']);
        set_session("ss_reg_mb_hp", $member['mb_hp']);

        $member['mb_email']       = get_text($member['mb_email']);
        $member['mb_homepage']    = get_text($member['mb_homepage']);
        $member['mb_birth']       = get_text($member['mb_birth']);
        $member['mb_tel']         = get_text($member['mb_tel']);
        $member['mb_hp']          = get_text($member['mb_hp']);
        $member['mb_addr1']       = get_text($member['mb_addr1']);
        $member['mb_addr2']       = get_text($member['mb_addr2']);
        $member['mb_signature']   = get_text($member['mb_signature']);
        $member['mb_recommend']   = get_text($member['mb_recommend']);
        $member['mb_profile']     = get_text($member['mb_profile']);
        $member['mb_1']           = get_text($member['mb_1']);
        $member['mb_2']           = get_text($member['mb_2']);
        $member['mb_3']           = get_text($member['mb_3']);
        $member['mb_4']           = get_text($member['mb_4']);
        $member['mb_5']           = get_text($member['mb_5']);
        $member['mb_6']           = get_text($member['mb_6']);
        $member['mb_7']           = get_text($member['mb_7']);
        $member['mb_8']           = get_text($member['mb_8']);
        $member['mb_9']           = get_text($member['mb_9']);
        $member['mb_10']          = get_text($member['mb_10']);
    } else {
        alert('w 값이 제대로 넘어오지 않았습니다.');
    }

    //include_once('./_head.php');
    include_once('./_head.sub.php');

    // 회원아이콘 경로
    $mb_icon_path = G5_DATA_PATH.'/member/'.substr($member['mb_id'],0,2).'/'.get_mb_icon_name($member['mb_id']).'.gif';
    $mb_icon_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME && file_exists($mb_icon_path)) ? '?'.filemtime($mb_icon_path) : '';
    $mb_icon_url  = G5_DATA_URL.'/member/'.substr($member['mb_id'],0,2).'/'.get_mb_icon_name($member['mb_id']).'.gif'.$mb_icon_filemtile;

    // 회원이미지 경로
    $mb_img_path = G5_DATA_PATH.'/member_image/'.substr($member['mb_id'],0,2).'/'.get_mb_icon_name($member['mb_id']).'.gif';
    $mb_img_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME && file_exists($mb_img_path)) ? '?'.filemtime($mb_img_path) : '';
    $mb_img_url  = G5_DATA_URL.'/member_image/'.substr($member['mb_id'],0,2).'/'.get_mb_icon_name($member['mb_id']).'.gif'.$mb_img_filemtile;

    $req_nick = !isset($member['mb_nick_date']) || (isset($member['mb_nick_date']) && $member['mb_nick_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400)));
    $required = ($w=='') ? 'required' : '';
    $readonly = ($w=='u') ? 'readonly' : '';
    $name_readonly = ($w=='u' || ($config['cf_cert_use'] && $config['cf_cert_req']))? 'readonly' : '';
    $hp_required = ($config['cf_req_hp'] || (($config['cf_cert_use'] && $config['cf_cert_req']) && ($config['cf_cert_hp'] || $config['cf_cert_simple']) && $member['mb_certify'] != "ipin")) ? 'required':'';
    $hp_readonly = (($config['cf_cert_use'] && $config['cf_cert_req']) && ($config['cf_cert_hp'] || $config['cf_cert_simple']) && $member['mb_certify'] != "ipin") ? 'readonly':'';

    $agree  = isset($_REQUEST['agree']) ? preg_replace('#[^0-9]#', '', $_REQUEST['agree']) : '';
    $agree2 = isset($_REQUEST['agree2']) ? preg_replace('#[^0-9]#', '', $_REQUEST['agree2']) : '';

    // add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    if ($config['cf_use_addr'])
        add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

    $register_action_url = G5_HTTPS_BBS_URL.'/register_form_update_emp.php';
    include_once($member_skin_path.'/register_form.skin_emp.php');
}
   
else if($signup == "ptn") {

    

    if ($w == 'u') {
        //기존정보조회

        $resultOneSql = "
        select *
            from {$g5['crm_partner']} a
        where 1=1
        and a.mb_id = '{$_POST['mb_id']}'
        ";
        $resultOne = sql_fetch($resultOneSql);
    }

    $register_action_url = G5_HTTPS_BBS_URL.'/partner_signup.php';
    include_once($member_skin_path.'/register_form.skin_ptn.php');
}

run_event('register_form_after', $w, $agree, $agree2);

//include_once('./_tail.php');
include_once('./_tail.sub.php');