<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Reset Password</h3>
                </div>
                <div class="panel-body">
                    <?php
                        // show potential errors / feedback (from session)
                        Helper::getFeedback();
                    ?>
                    <form method="post" action="forgotpassword.php?resetpasswordwithcode" name="reset_password_with_code_form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email Address" name="email" type="email" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Enter your password reset code." name="reset_code" type="password" required>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg btn-success btn-block" name="reset_password_with_code" value="Reset My Password" />
                            <a href="/" class="btn btn btn-primary btn-block">Go back to home</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
