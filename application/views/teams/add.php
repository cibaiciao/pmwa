<div class="col-sm-10">
    <h1 class="page-header nomarginall"><?php echo $title ?></h1>

    <div role="alert" class="" id="info-msg"></div>

    <form id="form" name="form" role="form">
        <div class="form-group">
            <label for="name">Team name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter team name" name="name" required="true" autocomplete="off">
        </div>
        <button type="button" class="btn btn-default" id="btn">Add</button>
    </form>

    <a href="<?php echo site_url('teams/index') ?>">Back to teams</a>
</div>