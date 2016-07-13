<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Hello!</h3>
                </div>
                <div class="panel-body">
                    <?php
                        // show potential errors / feedback (from login object)
                        View::getFeedback($auth);
                    ?>
                    <!-- if you need user information, just put them into the $_SESSION variable and output them here -->
                    <p>Hey, <?php echo $_SESSION['user_name']; ?>. You are logged in.</p>
                    <p>You are from <?php echo $_SESSION['user_logged_in_as'] . ' Department'; ?></p>
                    Try to close this browser tab and open it again. Still logged in! ;)

                    <!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
                    <a href="index.php?logout">Logout</a>

                </div>
            </div>
        </div>
    </div>
</div>
