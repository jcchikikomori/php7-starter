<div class="wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel card">
                    <div class="card-header">
                        <?php
                        if (($this->multi_user_status) && Session::user_logged_in()) {
                            echo '<h3 class="card-title">Add existing user to login</h3>';
                        } else {
                            echo '<h3 class="card-title">Login</h3>';
                        }
                        ?>
                    </div>
                    <div class="card-body">
                        <?php
                        // show potential errors / feedback (from session)
                        Helper::getFeedback();
                        ?>
                        <form method="post" action="index.php" name="loginform">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="user_name" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="user_password" type="password" required>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" name="login" value="Login" />
                                <?php
                                if (($this->multi_user_status) && !Session::user_logged_in()) {
                                    $logged_users = Session::get('users');
                                    if (!empty($logged_users)) {
                                        echo "<hr /><p>Other active users..</p>";
                                        echo "<ul>";
                                        foreach ($logged_users as $user => $value) {
                                            echo "<li>" .
                                                "<a href='index.php?login&u=" . $user . "&n=" . $value['user_name'] . "'>" . $value['full_name'] . "</a>";
                                            if (!isset($switch_user_requested)) {
                                                echo "<a href='index.php?logout&u=" . $user . "&n=" . $value['user_name'] . "' class='pull-right'>logout</a>";
                                            }
                                            echo "</li>";
                                        }
                                        echo "</ul>";
                                        echo "<hr />";
                                    }
                                    // echo '<a href="register.php" class="btn btn btn-primary btn-block">Register</a>';
                                    // echo '<a href="forgotpassword.php" class="btn btn btn-primary btn-block">Forgot Password?</a>';
                                }
                                if (isset($multi_user_requested) || isset($switch_user_requested)) {
                                    echo '<a href="/" class="btn btn btn-primary btn-block">Go back to home</a>';
                                }
                                echo '<a href="forgotpassword.php" class="btn btn btn-primary btn-block">Forgot Password?</a>';
                                echo '<a href="register.php" class="btn btn btn-primary btn-block">Register</a>';
                                ?>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php // var_dump($this); 
    ?>
</div>