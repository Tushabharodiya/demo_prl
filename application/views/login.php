<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <meta name="robots" content="noindex, nofollow" />
    
    <link rel="shortcut icon" href="<?php echo base_url(); ?>source/images/favicon.png">
    
    <title>Login | <?php echo TITLE; ?></title>
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>source/assets/css/style.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>source/assets/css/theme.css?ver=3.1.3">
    
    <script src="<?php echo base_url(); ?>source/assets/js/bundle.js?ver=3.1.3"></script>
    <script src="<?php echo base_url(); ?>source/assets/js/scripts.js?ver=3.1.3"></script>
</head>

<?php
    $emailError = "";
    $passwordError = "";
    if($this->session->userdata('panelLog') == "TRUE"){
        if(!empty($this->session->userdata['user_role'])){ 
            if($this->session->userdata['user_role'] == "Super"){
                redirect('dashboard');
            } else {
                redirect('employee-dashboard');
            }
        } else {
            redirect('error');
        }
    } else if($this->session->userdata('panelLog') == "FALSE"){
        redirect('confirmOTP');
    }
    
    if(form_error('user_email') != "" & form_error('user_password') != ""){
        $emailError = "Please enter email address";
        $passwordError = "Please enter password";
    } else if(form_error('user_email') != ""){
        $emailError = "Please enter email";
    } else if(form_error('user_password') != ""){
        $passwordError = "Please enter password";
    }
?>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="<?php echo base_url(); ?>source/images/logo.png" srcset="<?php echo base_url(); ?>source/images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="<?php echo base_url(); ?>source/images/logo-dark.png" srcset="<?php echo base_url(); ?>source/images/logo-dark2x.png 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Sign-In</h4>
                                        <div class="nk-block-des">
                                            <p>Access the panel using your email and password.</p>
                                        </div>
                                    </div>
                                </div>
                                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="user_email">Email Address</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control form-control-lg" name="user_email" placeholder="Enter Email Address" required>
                                            <?php if($emailError != ""){ ?>
                                                <small class="form-text text-danger mt-2"><?php echo $emailError; ?></small>
                                            <?php } else { ?>
                                                <small class="form-text text-muted"> We'll never share your email with anyone else.</small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="user_password">Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input autocomplete="new-password" type="password" class="form-control form-control-lg" id="password" name="user_password" placeholder="Enter user password" required>
                                            <?php if($passwordError != ""){ ?>
                                                <small class="form-text text-danger mt-2"><?php echo $passwordError; ?></small>
                                            <?php } else { ?>
                                                <small class="form-text text-muted"> We'll never share your password with anyone else.</small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-lg btn-primary btn-block submitBtn" name="submit" value="Sign In">
                                    </div>
                                    <?php if($error != ""){ ?>
                                        <small class="form-text text-danger mt-2"><?php echo $error; ?></small>
                                    <?php } ?>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</html>