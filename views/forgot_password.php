<div class="wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel card">
                    <div class="card-header">
                        <h3 class="card-title">Forgot Password?</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // show potential errors / feedback (from session)
                        libraries\Helper::getFeedback();
                        ?>
                        <form method="post" action="forgotpassword.php" name="reset_password_form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control"
                                        placeholder="Email Address"
                                        name="email" type="email" autofocus required>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit"
                                    class="btn btn-lg btn-success btn-block"
                                    name="reset_password" value="Reset My Password" />
                                <a href="forgotpassword.php?resetpasswordwithcode"
                                    class="btn btn btn-primary btn-block">Reset with my code</a>
                                <a href="/"
                                    class="btn btn btn-primary btn-block">Go back to home</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>