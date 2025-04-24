<div id="topbar" class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php print_link(HOME_PAGE) ?>">
            <img class="img-responsive" src="<?php print_link(SITE_LOGO); ?>" /> <?php echo SITE_NAME ?>
            </a>
            <?php 
            if(user_login_status() == true ){ 
                // Inisialisasi variabel notifikasi jika belum ada
                $controller = new BaseController();
                $newOrderNotifications = $controller->getNewOrderNotifications();
                $notificationCount = count($newOrderNotifications);
            ?>
            <button type="button" id="sidebarCollapse" class="btn btn-dark">
                <span class="navbar-toggler-icon"></span>
            </button>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
           
            
                           
                <!-- Notification Dropdown -->
                <ul class="navbar-nav ml-auto">
                    <?php if(ACL::is_allowed("pesanan/view")): ?>
                    <li class="nav-item dropdown notification-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if($notificationCount > 0): ?>
                                <i class="fa fa-bell fa-lg"></i>
                                <span class="badge badge-danger badge-counter position-absolute"><?php echo $notificationCount; ?></span>
                            <?php else: ?>
                                <i class="fa fa-bell fa-lg"></i>
                            <?php endif; ?>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right notification-dropdown-menu" aria-labelledby="notificationDropdown">
                            <h6 class="dropdown-header">
                                Notifikasi Request Aktivasi
                            </h6>
                            
                            <?php if($notificationCount > 0): ?>
                                <div class="notification-items">
                                    <?php foreach($newOrderNotifications as $notification): ?>
                                    <a class="dropdown-item d-flex align-items-center" href="<?php echo SITE_ADDR; ?>pesanan/view/<?php echo $notification['id']; ?>">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fa fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500"><?php echo date('d M Y', strtotime($notification['tanggal_pesanan'])); ?></div>
                                            <span class="font-weight-bold">Pesanan #<?php echo $notification['kode_pesanan']; ?></span>
                                            <div class="text-truncate"><?php echo $notification['nama_pelanggan']; ?></div>
                                            <div class="small text-gray-500">
                                                <span class="badge badge-warning">Request Aktivasi</span>
                                                Rp <?php echo number_format($notification['total_harga_akhir'], 0, ',', '.'); ?>
                                            </div>
                                        </div>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                                <a class="dropdown-item text-center small text-gray-500" href="<?php echo SITE_ADDR; ?>pesanan?status=Request_Aktivasi">
                                    Lihat Semua Request Aktivasi
                                </a>
                            <?php else: ?>
                                <div class="dropdown-item text-center">
                                    <span class="text-gray-500">Tidak ada request aktivasi</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endif; ?>
                    <!-- profile dropdown -->
            <div class="dropdown menu-dropdown">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?php print_link('account') ?>"><i class="fa fa-user"></i> My Account</a>
                        <a class="dropdown-item" href="<?php print_link('index/logout?csrf_token=' . Csrf::$token) ?>"><i class="fa fa-sign-out"></i> Logout</a>
                    </ul>
                </div>
                </ul>
            </div>
            <?php 
            } 
            ?>
        </div>
    </div>
    <?php 
    if(user_login_status() == true ){ 
    ?>
    <nav id="sidebar" class="navbar-dark bg-dark">
        <ul class="nav navbar-nav w-100 flex-column align-self-start">
            <li class="menu-profile text-center nav-item">                
                <h5 class="user-name">Hi 
                    <?php echo ucwords(USER_NAME); ?>
                    <small class="text-muted"><?php echo ACL::$user_role; ?> </small>
                </h5>
                
            </li>
        </ul>
        <?php Html :: render_menu(Menu :: $navbarsideleft  , "nav navbar-nav w-100 flex-column align-self-start"  , "accordion"); ?>
    </nav>
    <?php 
    } 
    ?>
