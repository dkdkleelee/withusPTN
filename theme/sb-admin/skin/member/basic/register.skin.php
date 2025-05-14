<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<!-- 회원가입약관 동의 시작 { -->
<div class="container">

	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
			<div class="row">
				<form  name="fregister" id="fregister" action="<?php echo $register_action_url; ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off" class="user">

				<div class="form-group row">
					<div class="p-5">
						<div class="text-center">
							<h1 class="h4 text-gray-900 mb-4">회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</h1>
						</div>

					
					<?php // 소셜로그인 사용시 소셜로그인 버튼
					@include_once(get_social_skin_path().'/social_register.skin.php');
					?>

						<section id="fregister_term">
							<h2>회원가입약관</h2>
							<textarea readonly><?php echo get_text($config['cf_stipulation']); ?></textarea>
							<fieldset class="fregister_agree">
								<input type="checkbox" name="agree" value="1" id="agree11" class="selec_chk">
								<label for="agree11"><span></span><b class="sound_only">회원가입약관의 내용에 동의합니다.</b></label>
							</fieldset>
						</section>

						<section id="fregister_private">
							<h2>개인정보처리방침안내</h2>
							<textarea readonly><?php echo get_text($config['cf_privacy']); ?></textarea>
							<fieldset class="fregister_agree">
								<input type="checkbox" name="agree2" value="1" id="agree21" class="selec_chk">
								<label for="agree21"><span></span><b class="sound_only">개인정보처리방침안내의 내용에 동의합니다.</b></label>
						   </fieldset>
						</section>

						<div id="fregister_chkall" class="chk_all fregister_agree btn-user">
							<input type="checkbox" name="chk_all" id="chk_all" class="selec_chk">
							<label for="chk_all"><span></span>회원가입 약관에 모두 동의합니다</label>
						</div>

						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-user btn-block">회원가입</button>
						</div>
			
						<hr>						
						<div class="text-center">
							<a class="small" href="<?php echo G5_BBS_URL; ?>/login.php">Already have an account? Login!</a>
						</div>
					</div>
					
				</div>
				<!--- ./form-group --->
				</form>
			</div>
			<!--- ./row --->
		</div>
		<!--- ./card-body p-0 --->
	</div>
	<!--- ./card o-hidden border-0 shadow-lg my-5 --->

</div>
<!--- ./container --->

<script>
function fregister_submit(f)
{
	if (!f.agree.checked) {
		alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree.focus();
		return false;
	}

	if (!f.agree2.checked) {
		alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree2.focus();
		return false;
	}

	return true;
}

jQuery(function($){
	// 모두선택
	$("input[name=chk_all]").click(function() {
		if ($(this).prop('checked')) {
			$("input[name^=agree]").prop('checked', true);
		} else {
			$("input[name^=agree]").prop("checked", false);
		}
	});
});

</script>
<!-- } 회원가입 약관 동의 끝 -->