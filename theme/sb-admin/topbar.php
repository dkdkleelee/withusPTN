<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">            
			
			<?php if ($member['mb_id']) { ?>

            <div class="topbar-divider d-none d-sm-block"></div>
			
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $member['mb_nick']; ?></span>
                <img class="img-profile rounded-circle" src="<?php echo G5_IMG_URL; ?>/no_profile.gif">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <?php if ($is_admin) { ?>
				<a class="dropdown-item" href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
				<?php } else {
					echo outlogin('theme/basic');
				} ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
			<?php } else {
				echo outlogin('theme/basic');
			} ?>

          </ul>

        </nav>
        <!-- End of Topbar -->