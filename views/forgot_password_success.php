<div class="wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel card">
                    <div class="card-header">
                        <h3 class="card-title">Password Reset</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // show potential errors / feedback (from session)
                        Helper::getFeedback();
                        ?>
                        <form method="post" action="forgotpassword.php?resetnewpassword" name="reset_new_password_form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Password" name="new_password" type="password" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Repeat Password" name="repeat_password" type="password" autofocus required>
                                </div>

                                <!-- Hidden fields -->
                                <input name="email" type="hidden" value="<?php echo $email_address; ?>">
                                <input name="reset_code" type="hidden" value="<?php echo $reset_code; ?>">

                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" name="reset_new_password" value="Reset My Password" />
                                <a href="/" class="btn btn btn-primary btn-block">Go back to home</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>