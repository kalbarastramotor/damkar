<html>
<head>

        <meta charset="utf-8" />
        <title><?=$title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?=base_url()?>/public/assets/images/favicon.ico">

        <!-- global css  -->
        <?php 
            foreach ($css as $key => $value) {
                if($value["id"]!=""){
                ?>
                    <link href="<?=base_url();?>/public/assets<?=$value["assets"]?>" id="<?=$value["id"]?>" rel="stylesheet" type="text/css" />
                <?php 
                }else{
                ?>
                    <link href="<?=base_url();?>/public/assets<?=$value["assets"]?>" rel="stylesheet" type="text/css" />
                <?php
                }

            }
        ?>
        <!-- global css  -->

        <!-- extends css  -->
         <?php 
            foreach ($extends_css as $key => $value) {
                if($value["id"]!=""){
                ?>
                    <link href="<?=base_url()?>/public/assets<?=$value["assets"]?>" id="<?=$value["id"]?>" rel="stylesheet" type="text/css" />
                <?php 
                }else{
                ?>
                    <link href="<?=base_url()?>/public/assets<?=$value["assets"]?>" rel="stylesheet" type="text/css" />
                <?php
                }

            }
        ?>
        <!-- extends css  -->
            <?php 
                if(isset($map)){
            foreach ($map as $key => $value) {

                    ?>
    <script src="<?=$value?>" async defer></script>

                    <?php
            }
                }
            ?>
            <style>

  .modal-backdrop {
    /* background-color:transparent !important; */
    /* border:1px solid ; */
    zoom: 150% !important;
}
#spinner-div {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 1000000000 !important;
  padding-top:40rem!important
}

   
</style>
    </head>

    
    <body style="zoom:67%">
    <div id="spinner-div">
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>

    <!-- <body style="zoom:67%"> -->


    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar" class="isvertical-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="<?=base_url()?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?=base_url()?>/public/assets/images/logo-kecil.png" alt="" height="26">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=base_url()?>/public/assets/images/damkar.png" alt="" height="26">
                                </span>
                            </a>

                            <a href="<?=base_url()?>" class="logo logo-light">
                                <span class="logo-lg">
                                    <img src="<?=base_url()?>/public/assets/images/logo-light.png" alt="" height="30">
                                </span>
                                <span class="logo-sm">
                                    <img src="<?=base_url()?>/public/assets/images/logo-light-sm.png" alt="" height="26">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
                            <i class="bx bx-menu align-middle"></i>
                        </button>

                        <!-- start page title -->
                        <div class="page-title-box align-self-center d-none d-md-block">
                            <h4 class="page-title mb-0">
                                
                            <?php 
                            
                            // print_r($this->session->get('userdata'));
                           echo $header['title'];
                            
                            ?></h4>
                        </div>
                        <!-- end page title -->

                    </div>

                    <div class="d-flex">
          

                        <!-- <div `class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown-v"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-bell icon-sm align-middle"></i>
                                <span class="noti-dot bg-danger rounded-pill">4</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown-v">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="m-0 font-size-15"> Notifications </h5>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small fw-semibold text-decoration-underline"> Mark all as read</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 250px;">
                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="<?=base_url()?>/public/assets/images/users/avatar-3.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted font-size-13 mb-0 float-end">1 hour ago</p>
                                                <h6 class="mb-1">James Lemire</h6>
                                                <div>
                                                    <p class="mb-0">It will seem like simplified English.</p>
                                                </div>
                                            </div>
                                
                                        </div>
                                    </a>
                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-sm me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-18">
                                                    <i class="bx bx-cart"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted font-size-13 mb-0 float-end">3 min ago</p>
                                                <h6 class="mb-1">Your order is placed</h6>
                                                <div>
                                                    <p class="mb-0">If several languages coalesce the grammar</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-sm me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-18">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted font-size-13 mb-0 float-end">8 min ago</p>
                                                <h6 class="mb-1">Your item is shipped</h6>
                                                <div>
                                                    <p class="mb-0">If several languages coalesce the grammar</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="<?=base_url()?>/public/assets/images/users/avatar-6.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted font-size-13 mb-0 float-end">1 hour ago</p>
                                                <h6 class="mb-1">Salena Layfield</h6>
                                                <div>
                                                    <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                        <i class="uil-arrow-circle-right me-1"></i> <span>View More..</span>
                                    </a>
                                </div>
                            </div>
                        </div> -->`
            
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown-v"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?=base_url()?>/public/assets/images/users/avatar-3.jpg"
                                alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">

                                <?=$header['name'];?>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <div class="p-3 border-bottom">
                                    <h6 class="mb-0"> <?=$header['name'];?></h6>
                                    <p class="mb-0 font-size-11 text-muted"> <?=$_SESSION['email'];?></p>
                                </div>
                                <a class="dropdown-item" href="contacts-profile.html"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Profile</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item logout" style="cursor: pointer;"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="<?=base_url()?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?=base_url()?>/public/assets/images/logo-kecil.png" alt="" height="26">
                        </span>
                        <span class="logo-lg">
                            <img src="<?=base_url()?>/public/assets/images/damkar.png" alt="" height="28">
                        </span>
                    </a>

                    <a href="<?=base_url()?>" class="logo logo-light">
                        <span class="logo-lg">
                            <img src="<?=base_url()?>/public/assets/images/logo-light.png" alt="" height="30">
                        </span>
                        <span class="logo-sm">
                            <img src="<?=base_url()?>/public/assets/images/logo-light-sm.png" alt="" height="26">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
                    <i class="bx bx-menu align-middle"></i>
                </button>

                <div data-simplebar class="sidebar-menu-scroll">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">

                            <?php 
                                if(isset($_SESSION['menu'])){
                                foreach ($_SESSION['menu'] as $key => $value) {
                                    ?>
                                    <li class="menu-title" data-key="t-menu"><?=$value['name'];?></li>
                                    
                                    <?php 
                                     foreach ($value['data'] as $keyDetail => $valueDetail) {
                                        ?>
                                         <li>
                                            <a href="<?=base_url().'/'.$valueDetail['url']?>" >
                                                <?php 
                                                    if($valueDetail['icon']==""){

                                                        ?>
                                                            <i class="bx bx-home-alt icon nav-icon"></i>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <i class="<?=$valueDetail['icon']?> icon nav-icon"></i>
                                                        <?php
                                                    }
                                                ?>


                                                <span class="menu-item" data-key="t-dashboard"><?=$valueDetail['name']?></span>
                                                <!-- <span class="badge rounded-pill bg-primary">2</span> -->
                                            </a>
                                        
                                            
                                        </li>
                                        <?php
                                     }
                                }
                            }
                            
                            ?>
                           
                           
                           


                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <header class="ishorizontal-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="<?=base_url()?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?=base_url()?>/public/assets/images/logo-kecil.png" alt="" height="26">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=base_url()?>/public/assets/images/logo.png" alt="" height="28">
                                </span>
                            </a>

                            <a href="<?=base_url()?>" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?=base_url()?>/public/assets/images/logo-light-sm.png" alt="" height="26">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=base_url()?>/public/assets/images/logo-light.png" alt="" height="30">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="bx bx-menu align-middle"></i>
                        </button>

                        <!-- start page title -->
                        <div class="page-title-box align-self-center d-none d-md-block">
                            <h4 class="page-title mb-0">Todo</h4>
                        </div>
                        <!-- end page title -->

                    </div>

                    <div class="d-flex">


                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-bell icon-sm align-middle"></i>
                                <span class="noti-dot bg-danger rounded-pill">4</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="m-0 font-size-15"> Notifications </h5>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small fw-semibold text-decoration-underline"> Mark all as read</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 250px;">
                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="<?=base_url()?>/public/assets/images/users/avatar-3.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">James Lemire</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">It will seem like simplified English.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>1 hour ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-sm me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="bx bx-cart"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your order is placed</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>3 min ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-sm me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your item is shipped</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>3 min ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="#!" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <img src="<?=base_url()?>/public/assets/images/users/avatar-6.jpg" class="rounded-circle avatar-sm" alt="user-pic">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Salena Layfield</h6>
                                                <div class="font-size-13 text-muted">
                                                    <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>1 hour ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                        <i class="uil-arrow-circle-right me-1"></i> <span>View More..</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?=base_url()?>/public/assets/images/users/avatar-3.jpg"
                                alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">Martin Gurley</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <div class="p-3 border-bottom">
                                    <h6 class="mb-0">Martin Gurley</h6>
                                    <p class="mb-0 font-size-11 text-muted">martin.gurley@email.com</p>
                                </div>
                                <a class="dropdown-item" href="contacts-profile.html"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Profile</span></a>
                                <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Messages</span></a>
                                <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Help</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="#"><i class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-2"></i> <span class="align-middle me-3">Settings</span><span class="badge badge-soft-success ms-auto">New</span></a>
                                <a class="dropdown-item" href="auth-lock-screen.html"><i class="mdi mdi-lock text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Lock screen</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="auth-logout.html"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i> <span class="align-middle">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="topnav">
                    <div class="container-fluid">
                        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
    
                            <div class="collapse navbar-collapse" id="topnav-menu-content">
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-home-alt icon nav-icon"></i>
                                            <span data-key="t-dashboards">Dashboards</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                                            <a href="<?=base_url()?>"  class="dropdown-item" data-key="t-ecommerce">Ecommerce</a>
                                            <a href="dashboard-sales.html"  class="dropdown-item" data-key="t-sales">Sales</a>
                                        </div>
                                    </li>
    
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </header>

            <?= $this->renderSection('content') ?>




            <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © webadmin.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Astra Motor <i class="mdi mdi-heart text-danger"></i> 
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
       


            <!-- end main content-->

            </div>
        <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <a href="#" class="right-bar-toggle layout-setting-btn" id="right-bar-toggle" style="display:none !important;">
            <i class="bx bx-cog icon-sm font-size-18"></i> <span>Settings</span>
        </a>

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center bg-dark p-3">

                    <h5 class="m-0 me-2 text-white">Theme Customizer</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle-close ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="m-0" />

                <div class="p-4">
                    <h6 class="mb-3">Layout</h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-vertical" value="vertical">
                        <label class="form-check-label" for="layout-vertical">Vertical</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout"
                            id="layout-horizontal" value="horizontal">
                        <label class="form-check-label" for="layout-horizontal">Horizontal</label>
                    </div>

                    <h6 class="mt-4 mb-3">Layout Mode</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-light" value="light">
                        <label class="form-check-label" for="layout-mode-light">Light</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-dark" value="dark">
                        <label class="form-check-label" for="layout-mode-dark">Dark</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode"
                            id="layout-mode-bordered" value="bordered">
                        <label class="form-check-label" for="layout-mode-bordered">Bordered</label>
                    </div>

                    <h6 class="mt-4 mb-3">Layout Width</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-fluid" value="fluid" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                        <label class="form-check-label" for="layout-width-fluid">Fluid</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width"
                            id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                        <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                    </div>

                    <h6 class="mt-4 mb-3">Layout Position</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-fixed" value="fixed" onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                        <label class="form-check-label" for="layout-position-fixed">Fixed</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position"
                            id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                        <label class="form-check-label" for="layout-position-scrollable">Scrollable</label>
                    </div>

                    <h6 class="mt-4 mb-3">Topbar Type</h6>

            
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                        <label class="form-check-label" for="topbar-color-light">Light</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                        <label class="form-check-label" for="topbar-color-dark">Dark</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color"
                            id="topbar-type-hidden" value="hidden" onchange="document.body.setAttribute('data-topbar', 'hidden')">
                        <label class="form-check-label" for="topbar-type-hidden">Hidden</label>
                    </div>
            

                    <div id="sidebar-setting">
                    <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Size</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                        <label class="form-check-label" for="sidebar-size-default">Default</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                        <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size"
                            id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                        <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                    </div>

                    <h6 class="mt-4 mb-3 sidebar-setting">Sidebar Color</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                        <label class="form-check-label" for="sidebar-color-light">Light</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                        <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color"
                            id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                        <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                    </div>
                </div>

                    <h6 class="mt-4 mb-3">Direction</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-ltr" value="ltr">
                        <label class="form-check-label" for="layout-direction-ltr">LTR</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction"
                            id="layout-direction-rtl" value="rtl">
                        <label class="form-check-label" for="layout-direction-rtl">RTL</label>
                    </div>

                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- chat offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasActivity" aria-labelledby="offcanvasActivityLabel">
            <div class="offcanvas-header border-bottom">
              <h5 id="offcanvasActivityLabel">Offcanvas right</h5>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              ...
            </div>
        </div>

        
        <!-- JAVASCRIPT GLOBAL -->
        <?php 
            foreach ($js as $key => $value) {
                ?>
                     <script src="<?=base_url()."/public/assets".$value?>"></script>
                <?php 
            }
        ?>
        <!-- EXTENDS JAVASCRIPT GLOBAL -->

  
    <script type="text/javascript">
        var base_url ='<?=base_url();?>';
        var userid ='<?=$header['id'];?>';

        var role = {};
        role['rolecode'] ='<?=$_SESSION['rolecode'];?>';

        var office = {};
        office['officeid'] ='<?=$_SESSION['officeid'];?>';
        office['office_name'] ='<?=$_SESSION['office_name'];?>';
       

        var token = localStorage.getItem("token");
        if(userid=="" || token==null){
            localStorage.removeItem("token");
            location.href = base_url;
        }
        $(document).ready(function() {
            $(".logout").click(function(e) {
                localStorage.removeItem("token");
                location.href = base_url;
            });
        });
        // set global position
        alertify.set('notifier', 'position', 'top-center');

    </script>

    <!-- <script src="http://localhost/ims/public/assets/js/dashboard.js"></script> -->

        <?php 
            foreach ($extends_js as $key => $value) {
                ?>
                     <script src="<?=base_url()."/public/assets".$value?>"></script>
                <?php 
            }
        ?>
        
    <!-- <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script> -->
       

   
    </body>

</html>