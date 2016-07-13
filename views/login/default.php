<form method="post" action="index.php" name="login">
    <fieldset>
        <div class="form-group">
            <input class="form-control" pattern=".{5,20}" placeholder="Username" name="user_name" type="text" title="requires 5-20 characters only" autofocus required>
        </div>
        <div class="form-group">
            <input class="form-control" pattern=".{5,20}" placeholder="Password" name="user_password" type="password" title="requires 5-20 characters only" required>
        </div>
        <!-- <div class="checkbox">
            <label>
                <input name="remember" type="checkbox" value="Remember Me">Remember Me
            </label>
        </div> -->
        <!-- Change this to a button or input when using this as a form -->
        <input type="submit" class="btn btn-lg btn-default btn-block" name="login" value="Login" />
        <!-- <a href="register.php" class="btn btn btn-primary btn-block">I would like to Register</a> -->
    </fieldset>
</form>