<!-- register form -->
<!-- <form method="post" action="register.php" name="registerform"> -->

    <!-- the user name input field uses a HTML5 pattern check -->
    <!-- <label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>
    <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required /> -->

    <!-- the email input field uses a HTML5 email type check -->
    <!-- <label for="login_input_email">User's email</label>
    <input id="login_input_email" class="login_input" type="email" name="user_email" required /> -->

    <!-- <label for="login_input_password_new">Password (min. 6 characters)</label>
    <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" /> -->

    <!-- <label for="login_input_password_repeat">Repeat password</label>
    <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
    <input type="submit"  name="register" value="Register" /> -->

<!-- </form> -->

<!-- backlink -->
<!-- <a href="index.php">Back to Login Page</a> -->

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Registration</h3>
                </div>
                <div class="panel-body">
                    <?php
                        // show potential errors / feedback
                        View::getFeedback($registration);
                    ?>
                    <form method="post" action="register.php" name="registerform">
                        <fieldset>
                            <div class="form-group">
                                <select class="form-control" name="user_type" title="User Type" autofocus required>
                                    <option selected disabled>Please Select User Type</option>
                                    <?php foreach($user_types as $type) {
                                        echo '<option value="' . $type['id'] . '">' . $type['type_desc'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username (only letters and numbers)" name="user_name" type="text" pattern="[a-zA-Z0-9]{2,64}" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="First Name" name="first_name" type="text" pattern="{3,64}" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Middle Name" name="middle_name" type="text" pattern="{3,64}" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Last Name" name="last_name" type="text" pattern="{3,64}" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="user_email" type="email" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password (min. 6 characters)" name="user_password_new" type="password" pattern=".{6,}" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Repeat Password" name="user_password_repeat" type="password" pattern=".{6,}" required>
                            </div>
                            <!-- <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div> -->
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg btn-success btn-block" name="register" value="Register" />
                            <a href="index.php" class="btn btn btn-primary btn-block">Go back to Login page</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
