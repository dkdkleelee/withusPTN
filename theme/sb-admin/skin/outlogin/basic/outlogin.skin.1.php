<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

				<li class="nav-item dropdown no-arrow">
					<a class="nav-link dropdown-toggle" href="<?php echo G5_BBS_URL; ?>/login.php" aria-haspopup="true" aria-expanded="false">
						<span class="mr-2 d-none d-lg-inline text-gray-600 small">로그인</span>
						<i class="fas fa-user-circle"></i>
					</a>
				</li>