<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>


        <!-- Begin Page Content -->
        <div class="container-fluid">
			<form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">				
				<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
				<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
				<input type="hidden" name="stx" value="<?php echo $stx; ?>">
				<input type="hidden" name="spt" value="<?php echo $spt; ?>">
				<input type="hidden" name="sca" value="<?php echo $sca; ?>">
				<input type="hidden" name="sst" value="<?php echo $sst; ?>">
				<input type="hidden" name="sod" value="<?php echo $sod; ?>">
				<input type="hidden" name="page" value="<?php echo $page; ?>">
				<input type="hidden" name="sw" value="">
				
			<div class="card shadow mb-4">
				<!-- Card Header - Dropdown -->
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary"><?php echo $board['bo_subject']; ?></h6>				
					<div class="dropdown no-arrow">					
						<?php if ($list_href || $is_checkbox || $write_href) { ?>
						<?php if ($admin_href) { ?><a href="<?php echo $admin_href; ?>" class="btn_admin btn" title="관리자"><i class="fas fa-cogs"></i></a><?php } ?>
						<?php if ($rss_href) { ?><a href="<?php echo $rss_href; ?>" class="btn_b01 btn" title="RSS"><i class="fas fa-rss-square"></i></a><?php } ?>
						<?php } ?>
						
						<button type="button" class="btn_bo_sch btn_b01 btn" title="게시판 검색"><i class="fas fa-search"></i></button>
						
						<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i></a>
						<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
							<?php if ($is_admin == 'super' || $is_auth) {  ?>
							<?php if ($is_checkbox) { ?>
							<!--- div class="dropdown-header">관리자용</div --->								
								<button type="submit" name="btn_submit" class="dropdown-item" value="선택삭제" onclick="document.pressed=this.value"><i class="fas fa-trash-alt"></i> 선택삭제</button>
								<button type="submit" name="btn_submit" class="dropdown-item" value="선택복사" onclick="document.pressed=this.value"><i class="fas fa-copy"></i> 선택복사</button>
								<li><button type="submit" name="btn_submit" class="dropdown-item" value="선택이동" onclick="document.pressed=this.value"><i class="fas fa-arrows-alt"></i> 선택이동</button>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
					<!--- ./dropdown no-arrow --->
				</div>
				<!--- ./card-header py-3 d-flex flex-row align-items-center justify-content-between --->
				
				<!-- Card Body -->
				<div class="card-body">
					<!-- 게시판 카테고리 시작 { -->
					<?php if ($is_category) { ?>
					<nav id="bo_cate">
						<h2><?php echo $board['bo_subject']; ?> 카테고리</h2>
						<ul id="bo_cate_ul">
							<?php echo $category_option; ?>
						</ul>
					</nav>
					<?php } ?>
					<!-- } 게시판 카테고리 끝 -->
					
					<div class="table-responsive">
						<table class="table table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
								<?php if ($is_checkbox) { ?>								
								<th class="all_chk chk_box">
									<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk">
									<label for="chkall">
										<span></span>
									</label>
								</th>
								<?php } ?>
								
								<th><a href="#">번호</a></th>
								<th><a href="#">제목</a></th>
								<th><a href="#">글쓴이</a></th>
								<th><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회</a></th>
								<?php if ($is_good) { ?><th><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a></th><?php } ?>
								<?php if ($is_nogood) { ?><th><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천</a></th><?php } ?>
								<th><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</a></th>
								</tr>
							</thead>
							<tbody>
								<?php
								for ($i=0; $i<count($list); $i++) {
									if ($i%2==0) { $lt_class = "even"; } else { $lt_class = ""; }
								?>
								
								<tr class="<?php if ($list[$i]['is_notice']) { echo "bo_notice"; } ?> <?php echo $lt_class; ?>">
									<?php if ($is_checkbox) { ?>
									
									<td class="td_chk chk_box">
										<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
										<label for="chk_wr_id_<?php echo $i ?>">
											<span></span>
										</label>
									</td>
									<?php } ?>
									
									<td class="td_numbig">
										<?php
										if ($list[$i]['is_notice']) { // 공지사항
											echo '<strong class="notice_icon">공지</strong>';
										} else if ($wr_id == $list[$i]['wr_id']) {
											echo "<span class=\"bo_current\">열람중</span>";
										} else {
											echo $list[$i]['num'];
										} ?>
									
									</td>
									
									<td class="td_subject" style="padding-left:<?php echo $list[$i]['reply'] ? (strlen($list[$i]['wr_reply'])*10) : '2'; ?>px">
										<?php
										if ($is_category && $list[$i]['ca_name']) {
										?>
										<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
										<?php } ?>
										<div class="bo_tit">
											<a href="<?php echo $list[$i]['href']; ?>" class="text-lg">
												<?php echo $list[$i]['icon_reply'] ?>
												<?php
													if (isset($list[$i]['icon_secret'])) echo rtrim($list[$i]['icon_secret']);
												 ?>
												<?php echo $list[$i]['subject'] ?>
											</a>
											<span class="text-xs">&nbsp;<sup>
											<?php
											if ($list[$i]['icon_new']) echo "<span class=\"btn btn-info btn-circle btn-sm text-xs\">New</span>";
											// if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
											if (isset($list[$i]['icon_file'])) echo '&nbsp;'.rtrim($list[$i]['icon_file']);
											if (isset($list[$i]['icon_link'])) echo '&nbsp;'.rtrim($list[$i]['icon_link']);
											if (isset($list[$i]['icon_hot'])) echo '&nbsp;'.rtrim($list[$i]['icon_hot']);
											?>
											<?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><span class="cnt_cmt"><?php echo $list[$i]['wr_comment']; ?></span><span class="sound_only">개</span><?php } ?>
											</sup>
											</span>
										</div>
									</td>
									
									<td class="td_name sv_use"><?php echo $list[$i]['name']; ?></td>
									
									<td class="td_numbig"><?php echo $list[$i]['wr_hit']; ?></td>
									
									<?php if ($is_good) { ?><td class="td_numbig"><?php echo $list[$i]['wr_good']; ?></td><?php } ?>
									
									<?php if ($is_nogood) { ?><td class="td_numbig"><?php echo $list[$i]['wr_nogood']; ?></td><?php } ?>
									
									<td class="td_datetime"><?php echo $list[$i]['datetime2']; ?></td>
									
								</tr>
								<?php } ?>
								<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">등록된 게시물이 없습니다.</td></tr>'; } ?>
							</tbody>
						</table>
						
						<nav class="navbar navbar-expand navbar-light bg-light mb-4">
							<span>Total <?php echo number_format($total_count) ?>건</span>
							<?php echo $page ?> 페이지
							
							<!-- 페이지 -->
							&nbsp;&nbsp;<?php echo $write_pages; ?>
							<!-- 페이지 -->
							
							<?php if ($write_href) { ?>
							<ul class="navbar-nav ml-auto">
								<a href="<?php echo $write_href; ?>" class="btn_b01 btn" title="글쓰기"><i class="fas fa-edit"></i></a>
							</ul>
							<?php } ?>							
						</nav>
					</div>
					<!--- ./table-responsive --->
				</div>
				<!--- ./card-body --->
			</div>
			<!--- ./card shadow mb-4 --->
			</form>

			<!-- 게시판 검색 시작 { -->
			<div class="bo_sch_wrap">
				<fieldset class="bo_sch">
					<h3>검색</h3>
					<form name="fsearch" method="get">
					<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
					<input type="hidden" name="sca" value="<?php echo $sca; ?>">
					<input type="hidden" name="sop" value="and">
					<label for="sfl" class="sound_only">검색대상</label>
					<select name="sfl" id="sfl">
						<?php echo get_board_sfl_select_options($sfl); ?>
					</select>
					<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					<div class="sch_bar">
						<input type="text" name="stx" value="<?php echo stripslashes($stx); ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder=" 검색어를 입력해주세요">
						<button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
					</div>
					<button type="button" class="bo_sch_cls" title="닫기"><i class="fa fa-times" aria-hidden="true"></i><span class="sound_only">닫기</span></button>
					</form>
				</fieldset>
				<div class="bo_sch_bg"></div>
			</div>
			<!-- } 게시판 검색 끝 --> 

        </div>
        <!-- /.container-fluid -->
		
<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<script>
jQuery(function($){
	// 게시판 검색
	$(".btn_bo_sch").on("click", function() {
		$(".bo_sch_wrap").toggle();
	})
	$('.bo_sch_bg, .bo_sch_cls').click(function(){
		$('.bo_sch_wrap').hide();
	});
});
</script>
			
<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}

// 게시판 리스트 관리자 옵션
jQuery(function($){
    $(".btn_more_opt.is_list_btn").on("click", function(e) {
        e.stopPropagation();
        $(".more_opt.is_list_btn").toggle();
    });
    $(document).on("click", function (e) {
        if(!$(e.target).closest('.is_list_btn').length) {
            $(".more_opt.is_list_btn").hide();
        }
    });
});
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->