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
            <div class="loginContainer">
                <div class="container">
                    <div class="loginBox">
                        <h1>HQ USER LOGIN </h1>

                        <div class="linner">
                            <!--<form class="form-horizontal">-->
                            <?php echo form_open('login', array('class' => 'form-horizontal')) ?>
                            <div class="form-group-errors" align="center" style="color:red">
                                <div class="col-sm-12">
                                    <?php echo validation_errors(); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('login_username') ?>" name="username" type="username" size=20 autofocus></input>
                                </div>
                                <div  class="col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember me
                                        </label>
                                    </div>
                                </div>


                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input class="form-control" placeholder="<?php echo $this->lang->line('login_password') ?>" name="password" type="password" size=20></input>
                                </div>

                                <div  class="col-sm-6">
                                    <button type="submit" class="btn loginBtn">LOGIN</button>

                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-11">
                                    <a href="<?php echo base_url().'login/';?>recovery_details" class="fpwd">Forgot Password</a>
                                </div>
                            </div>

                            </form>


                        </div>
                    </div>
                </div>

                <div class="footer-login">

                    <div class="container">
                        <div class="col-md-6">
                            <p class="pull-left"><strong class="footer-srms">SRMS</strong></p>
                        </div>

                        <div class="col-md-6">
                            <p class="pull-right copy">&copy;Powered By Sokxay IT Solution, Laos</p>
                        </div>

                    </div>
                </div>
            </div>
        </section>



        <div class="mobile-login">
            <div class="loginmodal-container">
                <h1>HQ USER LOGIN</h1><br>
                <!--<form>-->
                <?php echo form_open('login') ?>
                <div class="form-group" align="center" style="color:red"><?php echo validation_errors(); ?></div>
                <input class="form-control" placeholder="<?php echo $this->lang->line('login_username') ?>" name="username" type="username" size=20 autofocus></input>
                <input class="form-control" placeholder="<?php echo $this->lang->line('login_password') ?>" name="password" type="password" size=20></input>
                <input type="submit" name="login" class="login loginmodal-submit" value="Login">
                </form>

                <div class="login-help">
                    <a href="#">Forgot Password</a>
                </div>
            </div>
        </div>

        <!-- SCRIPTS HERE -->
        <script src="js/jQuery-2.1.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>
