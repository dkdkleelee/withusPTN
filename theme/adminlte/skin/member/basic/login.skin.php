<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>




<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b><?php echo $config['cf_title'] ?></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><?php echo $config['cf_title'] ?> 고객사 PAGE</p>

      <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
        <input type="hidden" name="url" value="<?php echo $login_url; ?>">

        <div class="input-group mb-3">
          <input type="text" name="mb_id" id="login_id" required  class="form-control required" placeholder="아이디">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-id-card"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="mb_password" id="login_pw" required class="form-control required" placeholder="패스워드">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="social-auth-links text-center mt-2 mb-3">
          <button type="submit" class="btn btn-block btn-primary">
            <i class="fas fa-unlock"></i> 로그인
          </a>
        </div>

        <div class="social-auth-links text-center mt-2 mb-3">
          <a href="./register?signup=ptn" class="btn btn-warning btn-block"><i class="fas fa-user-plus"></i> 고객 회원가입</a>
        </div>
      </form>
      
    </div>
  </div>
</div>




<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 끝 -->
