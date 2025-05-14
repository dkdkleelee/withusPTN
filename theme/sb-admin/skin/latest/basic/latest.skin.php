<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

			<div class="lat">
					<div class="card shadow mb-4">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary"><?php echo $bo_subject; ?></h6>
							<div class="dropdown no-arrow">
								<a class="dropdown-toggle" href="<?php echo get_pretty_url($bo_table); ?>" role="button" id="dropdownMenuLink" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i></a>
							</div>
						</div>
						<!--- card-header py-3 d-flex flex-row align-items-center justify-content-between --->
						
						<div class="card-body">
							<ul>
							<?php for ($i=0; $i<$list_count; $i++) {  ?>
							<li class="basic_li">
								<?php
								if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";

								echo "<a href=\"".$list[$i]['href']."\"> ";
								if ($list[$i]['is_notice'])
									echo "<strong>".$list[$i]['subject']."</strong>";
								else
									echo $list[$i]['subject'];

								echo "</a>";
								
								if ($list[$i]['icon_hot']) echo "<span class=\"hot_icon\"><i class=\"fa fa-heart\" aria-hidden=\"true\"></i><span class=\"sound_only\">인기글</span></span>";
								if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span>";
								// if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
								// if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

								echo $list[$i]['icon_reply']." ";
								if ($list[$i]['icon_file']) echo " <i class=\"fa fa-download\" aria-hidden=\"true\"></i>" ;
								if ($list[$i]['icon_link']) echo " <i class=\"fa fa-link\" aria-hidden=\"true\"></i>" ;

								if ($list[$i]['comment_cnt'])  echo "
								<span class=\"lt_cmt\"><span class=\"sound_only\">댓글</span>".$list[$i]['comment_cnt']."</span>";

								?>
								<div class="text-right text-xs">
									<span class="lt_nick font-weight-bold"><?php echo $list[$i]['name']; ?>&nbsp;&nbsp;</span>
									<span class="lt_date"><?php echo $list[$i]['datetime2']; ?></span>
								</div>
							</li>
							<?php }  ?>
							<?php if ($list_count == 0) { //게시물이 없을 때  ?>
							<li class="empty_li">등록된 게시물이 없습니다.</li>
							<?php }  ?>
							</ul>
						</div>
						<!--- ./card-body --->
					</div>
					<!--- ./card shadow mb-4 --->				
			</div>
			<!--- ./row --->