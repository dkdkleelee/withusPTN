<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
  include_once(G5_THEME_MOBILE_PATH . '/head.php');
  return;
}


//로그인안되어있을시 login
if (strpos($_SERVER['PHP_SELF'], 'register') !== false) {
  $user_chk = '1';
}
if (strpos($_SERVER['PHP_SELF'], 'register_form') !== false) {
  $user_chk = '1';
}
if (strpos($_SERVER['PHP_SELF'], 'password_lost') !== false) {
  $user_chk = '1';
}
if (!$is_member && !$user_chk) {
  header("Location:" . G5_BBS_URL . "/login");
  exit;
}


include_once(G5_THEME_PATH . '/head.sub.php');

?>




<div class="wrapper">

  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo G5_THEME_URL; ?>/dist/img/withUs1.png" alt="gonPlanLogo" height="60" width="60">
  </div>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
      
      <!-- loop 최근 메뉴 3개 까지 보여줌 4개부터는 쿠키 삭제 처리 TODO -->
    </ul>

    <ul class="navbar-nav ml-auto">
      <?php if ($is_admin) {  ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" role="button" data-toggle="tooltip" title="관리자">
            <i class="fas fa-wrench"></i>
          </a>
        </li>
      <?php }  ?>
      

      <li class="nav-item">
        <a class="nav-link" href="<?php echo G5_BBS_URL ?>/logout.php" role="button" data-toggle="tooltip" title="로그아웃">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button" data-toggle="tooltip" title="전체화면">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>


  <?php include_once(G5_THEME_PATH . "/aside.php"); ?>



  <!-- 콘텐츠 시작 { -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php if (!defined("_INDEX_")) { ?>
      <!-- Content Header (Page header) -->
      <!-- 
      <section class="content-header">
        <h1>
          <?php echo get_head_title($g5['title']); ?>
          <small>&nbsp;</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo G5_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <?php
          if ($bo_table) { ?>
            <li class="active"><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table; ?><?php echo $qstr; ?>"><?php echo get_head_title($g5['title']); ?></a></li>
          <?php } else { ?>
            <li class="active"><a href="#"><?php echo get_head_title($g5['title']); ?></a></li>
          <?php } ?>
        </ol>
      </section> 
      -->
    <?php } ?>