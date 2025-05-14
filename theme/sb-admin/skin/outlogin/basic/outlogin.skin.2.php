<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

				<a class="dropdown-item" href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL;?>/register_form.php">
				  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
				  Profile
				</a>
				<!-- <a class="dropdown-item" href="<?php echo G5_BBS_URL; ?>/point.php">
				  <i class="fas fa-coins fa-sm fa-fw mr-2 text-gray-400"></i>
				  Point
				</a>
				<a class="dropdown-item" href="<?php echo G5_BBS_URL; ?>/scrap.php">
					<i class="fas fa-scroll fa-sm fa-fw mr-2 text-gray-400"></i>
				  Scrap
				</a> -->

<?php /*
<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
        location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- } 로그인 후 아웃로그인 끝 -->
*/ ?>
