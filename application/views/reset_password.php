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
                    <?php if (!$resetpassword_status) { ?>
                        <?php echo form_open('login/getnewpassword/'.$person_id, array('class' => 'form-horizontal')) ?>
                        <div class="form-group-errors" align="center" style="color:red">
                            <div class="col-sm-12">
                                <?php echo validation_errors(); ?>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <div class="col-sm-6">
                                <input class="form-control input-sm" placeholder="<?php echo $this->lang->line('login_newpassword') ?>" name="newpassword" type="password" size=20></input>
                            </div>
                        </div>
                        
                        <div class="form-group form-group-sm">
                            <div class="col-sm-6">
                                <input class="form-control input-sm" placeholder="<?php echo $this->lang->line('login_retypepassword') ?>" name="retypepassword" type="password" size=20></input>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-6">
                                <button type="submit" class="btn loginBtn"><?php echo $this->lang->line('login_resetpassword');?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                <?php } else {
                    ?>
                    <div class="form-group-errors" align="center" style="color:red">
                        <div class="col-sm-12">
                            <?php echo '<div class="alert alert-danger">'.$this->lang->line('login_error_reset').'</div>'; ?>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </section>

        <!-- SCRIPTS HERE -->
        <script src="js/jQuery-2.1.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>
