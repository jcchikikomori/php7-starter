<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo (isset($error_title) ? $error_title : 'ERROR!'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <p>
                        <?php echo (isset($error_message) ? $error_message : "There's something wrong.."); ?>
                    </p>
                    <?php if (isset($debug)) { ?>
                        <code>
                            <?php echo (isset($debug) ? $debug : "Cannot find logs here."); ?>
                        </code>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
