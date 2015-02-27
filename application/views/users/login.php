<div class="col-sm-4 col-sm-offset-4" id="login">

    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Sign in</div>
        <div class="panel-body">
            <form role="form" id="login-form">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required="true" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" required="true">
                </div>
                <button type="button" class="btn btn-default" id="signInBtn">Sign In</button>
            </form>
        </div>
    </div>

    <a href="<?php echo site_url('register') ?>">Create new account</a><br/>
    <a href="<?php echo site_url('forgot') ?>">Forgot password</a>
</div>