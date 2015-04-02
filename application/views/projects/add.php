<div class="col-sm-10">
    <h1 class="page-header nomarginall"><?php echo $title ?></h1>

    <div role="alert" class="" id="info-msg"></div>

    <form id="form" name="form" role="form">
        <div class="form-group">
            <label for="name">Project name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter project name" name="name" required="true" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="key">Key</label>
            <input type="text" class="form-control" id="key" placeholder="Enter unique key" name="key" required="true" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="team_id">Team</label>
            <?php echo form_dropdown('team_id',$teamOption,"",'class="form-control" id="team_id"') ?>
        </div>
        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="text" class="form-control date" id="deadline" name="deadline" required="true" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <button type="button" class="btn btn-default" id="btn">Add</button>
    </form>

    <a href="<?php echo site_url('projects/index') ?>">Back to projects</a>
</div>