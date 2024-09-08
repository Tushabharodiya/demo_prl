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
</head>

<?php
    if($this->session->userdata('panelLog') == ""){
        redirect('login');
    } else if($this->session->userdata('panelLog') == "TRUE"){
        if(!empty($this->session->userdata['user_role'])){ 
            if($this->session->userdata['user_role'] == "Super"){
                redirect('dashboard');
            } else {
                redirect('employee-dashboard');
            }
        } else {
            redirect('error');
        }
    }
?>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="<?php echo base_url(); ?>confirmOTP" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="<?php echo base_url(); ?>source/images/logo.png" srcset="<?php echo base_url(); ?>source/images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="<?php echo base_url(); ?>source/images/logo-dark.png" srcset="<?php echo base_url(); ?>source/images/logo-dark2x.png 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="text-center nk-block-title">Plaese Verify Your OTP Number</h5>
                                        <div class="nk-block-des mt-3">
                                            <p>Thanks for giving your login details. An OTP has been sent to your register Mobile Number. Please enter the 8 digit OTP below for Successful Login.</p>
                                        </div>
                                    </div>
                                </div>
                                <form action="<?php echo base_url(); ?>login/confirmOTP" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg" name="confirm_otp" placeholder="Enter Your OTP Here" required>
                                            <small class="form-text text-muted"> Your OTP will be continue for 15 minutes. </small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-lg btn-primary btn-block submitBtn" name="submit" value="Confirm OTP">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</html>