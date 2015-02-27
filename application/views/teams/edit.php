<div class="col-sm-10">
    <h1 class="page-header nomarginall"><?php echo $title ?></h1>

    <div role="alert" class="" id="info-msg"></div>

    <form id="form" name="form" role="form">
        <div class="form-group">
            <label for="name">Team name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter team name" name="name" required="true" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <button type="button" class="btn btn-default" id="btn">Edit</button>
        <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo site_url('teams/index') ?>'">Back</button>

        <input type="hidden" id="id"  name="id"  value="<?php echo $id; ?>"/>
    </form>


</div>