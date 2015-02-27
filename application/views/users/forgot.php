<div class="col-sm-4 col-sm-offset-4" id="forgot">

    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Forgot password</div>
        <div class="panel-body">
            <form role="form" id="forgot-form">
                <p>Please type in your registered email address</p>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required="true" autocomplete="off">
                </div>
                <button type="button" class="btn btn-default" id="signInBtn">Retrieve</button>
            </form>
        </div>
    </div>
    <a href="<?php echo site_url('register') ?>">Create new account</a><br/>
    <a href="<?php echo site_url('login') ?>">Have an account? Login now</a>
</div>