<div class="wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel card">
                    <div class="card-header">
                        <h3 class="card-title">Reset Password</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // show potential errors / feedback (from session)
                        libraries\Helper::getFeedback();
                        ?>
                        <form method="post" action="forgotpassword.php?resetpasswordwithcode"
                            name="reset_password_with_code_form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="Email Address" name="email" type="email" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="Enter your password reset code."
                                        name="reset_code" type="password" required>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit"
                                    class="btn btn-lg btn-success btn-block"
                                    name="reset_password_with_code" value="Reset My Password" />
                                <a href="/" class="btn btn btn-primary btn-block">Go back to home</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>