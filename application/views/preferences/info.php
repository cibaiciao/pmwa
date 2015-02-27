<div class="col-sm-10">
    <h1 class="page-header nomarginall"><?php echo $title ?></h1>

    <div role="alert" class="" id="info-msg"></div>

    <form id="info-form" role="form">
        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" class="form-control" id="fname" placeholder="Enter first name" name="fname" required="true" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" class="form-control" id="lname" placeholder="Enter last name" name="lname" required="true" autocomplete="off">
        </div>
        <button type="button" class="btn btn-default" id="changeBtn">Update</button>
        <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo site_url('preferences') ?>';">Back</button>

        <input type="hidden" name="id" value="<?php echo $this->session->userdata('id') ?>"/>
    </form>
</div>