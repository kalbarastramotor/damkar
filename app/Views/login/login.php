<html>
<head>

        <meta charset="utf-8" />
        <title>Login </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="<?=base_url()?>/public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>/public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>/public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>/public/assets/libs/alertifyjs/build/css/alertify.min.css" id="app-style" rel="stylesheet" type="text/css" />
        

    </head>

    
    <body  style="zoom:67%">

    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="mb-4 pb-2">
                            <a href="" class="d-block auth-logo">
                                <img src="<?=base_url()?>/public/assets/images/logo.png" alt="" height="55" class="auth-logo-dark">
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4"> 
                                <div class="text-center mt-2">
                                    <h5>Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to webadmin.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form>
        
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <div class="position-relative input-custom-icon">
                                                <input type="text" class="form-control" id="username"  placeholder="Enter username">
                                                 <span class="bx bx-user"></span>
                                            </div>
                                        </div>
                
                                        <div class="mb-3">
                                            <!-- <div class="float-end">
                                                <a href="auth-recoverpw.html" class="text-muted text-decoration-underline">Forgot password?</a>
                                            </div> -->
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                                <span class="bx bx-lock-alt"></span>
                                                <input type="password" class="form-control" id="password-input"  placeholder="Enter password">
                                                <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                </button>
                                            </div>
                                        </div>
                
                                        <div class="form-check py-1">
                                            <input type="checkbox" class="form-check-input" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light login" onclick="login()" type="button">Log In</button>
                                        </div>

                                       

                                        <div class="mt-4 text-center">
                                            <!-- <p class="mb-0">Don't have an account ? <a href="auth-register.html" class="fw-medium text-primary"> Contact Your admin </a> </p> -->
                                        </div>
                                    </form>
                                </div>
            
                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center p-4">
                            <p>© <script>document.write(new Date().getFullYear())</script> webadmin.  Astra Motor <i class="mdi mdi-heart text-danger"></i> </p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>
        <script src="<?=base_url()?>/public/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?=base_url()?>/public/assets/libs/metismenujs/metismenujs.min.js"></script>
        <script src="<?=base_url()?>/public/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?=base_url()?>/public/assets/libs/eva-icons/eva.min.js"></script>
        <script src="<?=base_url()?>/public/assets/js/jquery-3.6.0.min.js"></script>
        <script src="<?=base_url()?>/public/assets/libs/alertifyjs/build/alertify.min.js"></script>
       
   <script type="text/javascript">
        var base_url ='<?=base_url();?>';
        var userid ='<?=$header['id'];?>';
        var token = localStorage.getItem("token");
        if(userid!="" && token !=null){
            location.href = base_url+'/dashboard';
        }
        alertify.set('notifier', 'position', 'top-center');
        
    </script>
        <script src="<?=base_url()?>/public/assets/js/login.js"></script>
        <script src="<?=base_url()?>/public/assets/js/pages/pass-addon.init.js"></script>


    </body>
</html>