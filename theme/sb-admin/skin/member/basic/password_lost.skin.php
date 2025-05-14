<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div class="container">

	<!-- Outer Row -->
	<div class="row justify-content-center">

		<div class="col-xl-10 col-lg-12 col-md-9">

			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
					
						<div class="col-lg-6">
							<div class="p-5">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-2">회원 정보 찾기</h1>
									<p class="mb-4">
										회원가입 시 등록하신 이메일 주소를 입력해 주세요.<br>
										해당 이메일로 아이디와 비밀번호 정보를 보내드립니다.
									</p>
								</div>
								
								<form class="user">
									<div class="form-group">
										<input type="text" name="mb_email" id="mb_email" required class="form-control form-control-user frm_input full_input email required" aria-describedby="emailHelp" placeholder="E-mail 주소">
									</div>
									<?php echo captcha_html();  ?>
									<button type="submit" class="btn btn-primary btn-user btn-block">확인</button>
									<button type="button" onclick="window.close();" class="btn btn-primary btn-user btn-block">창닫기</button>
								</form>
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
function fpasswordlost_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});
</script>
<!-- } 회원정보 찾기 끝 -->