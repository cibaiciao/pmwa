<div class="col-sm-4 col-sm-offset-4" id="register">

    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Join us</div>
        <div class="panel-body">
            <form role="form" id="register-form">
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" id="fname" placeholder="Enter first name" name="fname" required="true" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" id="lname" placeholder="Enter last name" name="lname" required="true" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required="true" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" required="true">
                </div>
                <div class="form-group">
                    <label for="passwordconf">Password Confirm</label>
                    <input type="password" class="form-control" id="passwordconf" placeholder="Password Confirm" name="passwordconf" required="true">
                </div>
                <button type="button" class="btn btn-default" id="registerBtn">Register</button>
            </form>
        </div>
    </div>

    <a href="<?php echo site_url('login') ?>">Have an account? Login now</a><br/>
    <a href="<?php echo site_url('forgot') ?>">Forgot password</a>
</div>