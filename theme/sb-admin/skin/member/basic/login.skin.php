<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 로그인 시작 { -->
<div class="container">

	<!-- Outer Row -->
	<div class="row justify-content-center">

		<div class="col-xl-10 col-lg-12 col-md-9">

			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
						<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
						<div class="col-lg-6">
							<div class="p-5">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-4"><a href="<?php echo G5_URL; ?>"><?php echo $g5['title']; ?></a></h1>
								</div>
								
								<form name="flogin" action="<?php echo $login_action_url; ?>" onsubmit="return flogin_submit(this);" method="post" class="user">
									<input type="hidden" name="url" value="<?php echo $login_url; ?>">
									
									<div class="form-group">
										<input type="text" name="mb_id" id="login_id" required class="form-control form-control-user required" aria-describedby="emailHelp" placeholder="아이디">
									</div>
									<div class="form-group">
										<input type="password" name="mb_password" id="login_pw" required class="form-control form-control-user required" placeholder="비밀번호">
									</div>
									<div class="form-group">
										<div class="custom-control custom-checkbox small">
											<input type="checkbox" name="auto_login" class="custom-control-input" id="customCheck">
											<label class="custom-control-label" for="customCheck">자동로그인</label>
										</div>
									</div>
									<button type="submit" class="btn btn-primary btn-user btn-block">로그인</button>
									
									<hr>
									<?php @include_once(get_social_skin_path().'/social_login.skin.php'); // 소셜로그인 사용시 소셜로그인 버튼 ?>
								
								</form>
								
								<br>
								<div class="text-center">
									<a class="small" href="<?php echo G5_BBS_URL; ?>/password_lost.php" id="login_password_lost">정보 찾기</a>
								</div>
								<hr>
								<div class="text-center">
									<a class="small" href="<?php echo G5_BBS_URL; ?>/register.php">회원 가입</a>
								</div>
							</div>
							<!--- ./p-5 --->
						</div>
						<!--- ./col-lg-6 --->
					</div>
					<!--- ./row --->
				</div>
				<!--- ./card-body p-0 --->
				
			</div>
			<!--- ./card o-hidden border-0 shadow-lg my-5 --->

		</div>
		<!--- ./col-xl-10 col-lg-12 col-md-9 --->
		
	</div>
	<!--- ./row justify-content-center --->

</div>


<script>
jQuery(function($){
    $("#customCheck").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    if( $( document.body ).triggerHandler( 'login_sumit', [f, 'flogin'] ) !== false ){
        return true;
    }
    return false;
}
</script>
<!-- } 로그인 끝 -->