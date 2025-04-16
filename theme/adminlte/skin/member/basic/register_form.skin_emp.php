<?php
if (!defined('_GNUBOARD_')) exit;

add_stylesheet('<link rel="stylesheet" href="' . $member_skin_url . '/style.css">', 0);

//parent 부서
$dpet_parent_sql = "
select *
from {$g5['crm_depart']}
where parent_deptno != 1
order by deptno 
";
$dpet_parent_result = sql_query($dpet_parent_sql);
?>


<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<?php if ($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
  <script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>


<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b><?php echo $config['cf_title'] ?></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><code>임직원</code> 회원가입 PAGE</p>

      <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" value="<?php echo $w ?>">
        <input type="hidden" name="url" value="<?php echo $urlencode ?>">
        <input type="hidden" name="agree" value="<?php echo $agree ?>">
        <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
        <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
        <input type="hidden" name="cert_no" value="">
        <?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
        <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  
        ?>
          <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
          <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
        <?php }  ?>

        <!-- 아이디 -->
        <div class="input-group mb-3">
          <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" class="form-control" minlength="3" maxlength="20" placeholder="아이디" oninput="this.value = this.value.replace(/[^0-9a-z.]/g, '').replace(/(\..*)\./g, '$1');" <?php echo $required ?> <?php echo $readonly; ?>>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <!-- 패스워드 -->
        <div class="input-group mb-3">
          <input type="password" name="mb_password" id="reg_mb_password" class="form-control" minlength="3" maxlength="20" placeholder="비밀번호" <?php echo $required ?>>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="mb_password_re" id="reg_mb_password_re" class="form-control" minlength="3" maxlength="20" placeholder="비밀번호 확인" <?php echo $required ?>>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <!-- 이름 -->
        <div class="input-group mb-3">
          <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" class="form-control" size="10" placeholder="이름" <?php echo $required ?> <?php echo $readonly; ?>>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <!-- 부서 -->
        <?php if ($w == "") {  ?>
        <div class="input-group mb-3">
        <select name=mb_deptno id="mb_deptno" class="form-control custom-select" <?php echo $readonly; ?>>
            <option value="">부서없음</option>
            <?php for ($i = 0; $dept = sql_fetch_array($dpet_parent_result); $i++) { ?>
              <option value="<?php echo $dept['deptno'] ?>" <?php echo get_selected($member['mb_deptno'], $dept['deptno']); ?>><?php echo $dept['deptnm'] ?></option>
            <?php } ?>
        </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <?php }  ?>

        <!-- 이메일 -->
        <div class="input-group mb-3">
          <input type="text" name="mb_email" value="<?php echo get_text($member['mb_email']) ?>" id="reg_mb_email" class="form-control" size="70" maxlength="100" placeholder="E-mail" <?php echo $required ?>>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <!-- 휴대전화 -->
        <div class="input-group mb-3">
          <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" class="form-control" minlength="13" maxlength="13" placeholder="휴대폰번호" oninput="telHyphen(this);" <?php echo $required ?>>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone-alt"></span>
            </div>
          </div>
        </div>

        <!-- 닉네임 -->
        <div class="input-group mb-3">
          <input type="text" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>" id="reg_mb_nick" class="form-control" size="10" maxlength="20" placeholder="닉네임" <?php echo $required ?>>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <?php if ($w == "u") {  ?>
        <div class="input-group mb-3">
          <span class="frm_info">
              [프로필 IMAGE]
          </span>
          <input type="file" name="mb_img" id="reg_mb_img" >


          <?php if (file_exists($mb_img_path)) {  ?>
            <img src="<?php echo $mb_img_url ?>" alt="회원이미지">
            <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">
            <label for="del_mb_img">삭제</label>
          <?php }  ?>
                
        </div>
        <div class="input-group mb-3">
          <span class="frm_info">
              [명함 IMAGE]
          </span>
          <input type="file" name="mb_icon" id="reg_mb_icon" >

          <?php if (file_exists($mb_icon_path)) {  ?>
            <img src="<?php echo $mb_icon_url ?>" alt="회원아이콘">
            <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
            <label for="del_mb_icon">삭제</label>
          <?php }  ?>
          
        </div>
        <?php } ?>


        <div class="input-group mb-3">
          <?php echo captcha_html(); ?>
        </div>

        <?php if ($w == "") {  ?>

        <p>※관리자 승인 후 사용할 수 있습니다※</p>
        <div class="social-auth-links text-center">
            <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-user-plus"></i> 회원가입
            <button onclick="history.back()" class="btn btn-block btn-danger"> 가입취소
        </div>

        <?php } else { ?>
          <div class="social-auth-links text-center">
            <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-user-plus"></i> 회원수정
            <button onclick="history.back()" class="btn btn-block btn-danger"> 뒤로가기
          </div>
        <?php } ?>

        

      </form>

      </div>
  </div>
</div>


<script>
  $(function() {
    
  });

  
  // submit 최종 폼체크
  function fregisterform_submit(f) {
    // 회원아이디 검사
    if (f.w.value == "") {
      var msg = reg_mb_id_check();
      if (msg) {
        alert(msg);
        f.mb_id.select();
        return false;
      }
    }

    if (f.w.value == "") {
      if (f.mb_password.value.length < 3) {
        alert("비밀번호를 3글자 이상 입력하십시오.");
        f.mb_password.focus();
        return false;
      }
    }

    if (f.mb_password.value != f.mb_password_re.value) {
      alert("비밀번호가 같지 않습니다.");
      f.mb_password_re.focus();
      return false;
    }

    if (f.mb_password.value.length > 0) {
      if (f.mb_password_re.value.length < 3) {
        alert("비밀번호를 3글자 이상 입력하십시오.");
        f.mb_password_re.focus();
        return false;
      }
    }

    // 이름 검사
    if (f.w.value == "") {
      if (f.mb_name.value.length < 1) {
        alert("이름을 입력하십시오.");
        f.mb_name.focus();
        return false;
      }
    }

    // 닉네임 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
      var msg = reg_mb_nick_check();
      if (msg) {
        alert(msg);
        f.reg_mb_nick.select();
        return false;
      }
    }

    // E-mail 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
      var msg = reg_mb_email_check();
      if (msg) {
        alert(msg);
        f.reg_mb_email.select();
        return false;
      }
    }

    <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
      // 휴대폰번호 체크
      var msg = reg_mb_hp_check();
      if (msg) {
        alert(msg);
        f.reg_mb_hp.select();
        return false;
      }
    <?php } ?>

    if (typeof f.mb_icon != "undefined") {
      if (f.mb_icon.value) {
        if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
          alert("회원아이콘이 이미지 파일이 아닙니다.");
          f.mb_icon.focus();
          return false;
        }
      }
    }

    if (typeof f.mb_img != "undefined") {
      if (f.mb_img.value) {
        if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
          alert("회원이미지가 이미지 파일이 아닙니다.");
          f.mb_img.focus();
          return false;
        }
      }
    }

    <?php echo chk_captcha_js();  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
  }
</script>
