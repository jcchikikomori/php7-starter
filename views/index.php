<style type="text/css">
    html, body {
        background-color: #DD5D17;
    }
</style>

<div class="container">
    <div class="row centered-row login-row-fix">
        <div class="col-sm-8 visible-sm visible-md visible-lg">
            <!--<img src="<?php //echo URL . 'img/realpage-bar.png'; ?>" style="width: 100%; margin-top: 12px;" />-->
            <img src="<?php echo ASSETS . 'img/realpage-pc-registration.png'; ?>" style="width: 100%; margin-top: 25px;" />
        </div>
        <div class="col-sm-4">
            <div class="panel panel-transparent no-shadow">
                <div class="panel-heading">
                    <div class="sys_logo">
                        <img src="<?php echo ASSETS . 'img/logo-inversed.png'; ?>" style="width: 100%;" />
                    </div>
                </div>
                <div class="panel-body nod-white login-panel-fix" id="login-body">
                    <?php $view::getFeedback($auth); ?>
                    <p>
                        <b>REAL PAGE PeMS</b>
                    </p>
                    <?php $view::loginDetectUser(); ?>
                    <br />
                </div>
                <div class="panel-footer">
                    <span class="pull-right">(C) REAL PAGE INC.</span><br /><br />
                    <span class="pull-right">Powered by <a style="color: lime;" href="https://github.com/jccultima123/MyPHP" target="_blank">MyPHP</a>, powerful PHP-based web template</span>
                </div>
            </div>
        </div>
    </div>
</div>
