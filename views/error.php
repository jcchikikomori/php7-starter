<div class="wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo (isset($data['title']) ? $data['title'] : 'ERROR!'); ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p>
                            <?php echo (isset($data['message']) ? $data['message'] : "There's something wrong.."); ?>
                        </p>
                        <?php if (isset($data['debug'])) { ?>
                            <code>
                                <?php echo (isset($data['debug']) ? $data['debug'] : "Cannot find logs here."); ?>
                            </code>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>