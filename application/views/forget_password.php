<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo base_url(); ?>" />
        <title><?php echo $this->config->item('company') . ' | ' . $this->lang->line('login_login'); ?></title>
<!--        <title>SOKXAY Retail group</title>-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <!-- STYLESHEETS HERE -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/login.css" rel="stylesheet" type="text/css"/>

    </head>
    <body>
        <header>
            <div class="loginHeader">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="logo pull-left">
                                <img src="images/sokxay_logo.png" alt="sokxay_logo"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="language pull-right">
                                <p><a href="#"><img src="images/laos-flag.jpg" alt="laos-flag"/></a></p>
                                <p><a href="#"><img src="images/usa-flag.jpg" alt="usa-flag"/></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="desktop-login">
            <div class="container">
                <div class="linner">
                    <?php
                    if (isset($forgetpassword_status) && $forgetpassword_status) {
                        echo '<div class="alert alert-info">'.$this->lang->line('login_mailsent_fpwd').'</div>';
                    } else {
                        ?>
                                <?php echo form_open('login/resetpassword', array('class' => 'form-horizontal', 'id' => 'resetpassword')) ?>
                        <div class="form-group-errors" align="center" style="color:red">
                            <div class="col-sm-12" id="error-handle">
    <?php echo validation_errors(); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input class="form-control" placeholder="<?php echo $this->lang->line('login_username') ?>" name="username" type="text" id="username" size=20 autofocus/>
                            </div>
                        </div>

                        <div class="form-group"> 
                            <div class="col-sm-6">
                                <button type="submit" class="btn loginBtn"><?php echo $this->lang->line('login_getlink') ?></button>
                            </div>
                        </div>
    <?php echo form_close();
} ?>
                </div>
            </div>
        </section>
        <!-- SCRIPTS HERE -->
        <script src="js/jQuery-2.1.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script>
                    $(document).ready(function(){
<?php if (isset($forgetpassword_status) && $forgetpassword_status) { ?>
                setTimeout(function () {
                    window.location.href ='<?php echo base_url().'login';?>';
                }, 3000);
<?php } ?>
            })
        </script>
    </body>
</html>
