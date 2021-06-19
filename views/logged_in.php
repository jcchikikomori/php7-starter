<div class="wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel card">
                    <div class="card-header">
                        <h3 class="card-title">Hello!</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // show potential errors / feedback (from session)
                        libraries\Helper::getFeedback();
                        ?>
                        <!-- Using Session library -->
                        <!-- if you need user information, just put them in Session::set_user() output them here -->
                        <?php
                        echo "<p>You are " . libraries\Session::get_user_details('full_name') . " from " . libraries\Session::get_user_details('user_logged_in_as') . " Department</p>"
                        ?>
                        Try to close this browser tab and open it again. Still logged in! ;)
                        <hr />
                        <?php if ($this->multi_user_status) { ?>
                            <!-- Add another user -->
                            <a href="multi_user.php?add_existing_user"
                                class="btn btn btn-primary btn-block">Add another user</a>
                            <a href="multi_user.php?switch_user"
                                class="btn btn btn-primary btn-block">Switch user</a>
                        <?php } ?>

                        <!-- because people were asking: "index.php?logout" is
                        just my simplified form of "index.php?logout=true" -->
                        <a href="index.php?logout"
                            class="btn btn btn-danger btn-block">Logout</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>