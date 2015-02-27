<div class="col-sm-10">
    <h1 class="page-header nomarginall"><?php echo $title ?></h1>

    <div role="alert" class="" id="password-msg"></div>

    <form id="info-form" role="form">
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" placeholder="Enter current password" name="current_password" required="true" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" placeholder="Enter new password" name="new_password" required="true" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="new_password_confirm">New Password Confirm</label>
            <input type="password" class="form-control" id="new_password_confirm" placeholder="Enter new password confirm" name="new_password_confirm" required="true" autocomplete="off">
        </div>
        <button type="button" class="btn btn-default" id="changeBtn">Update</button>
        <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo site_url('preferences') ?>';">Back</button>

        <input type="hidden" name="id" value="<?php echo $this->session->userdata('id') ?>"/>
    </form>
</div>