<div class="col-sm-10">
    <h1 class="page-header nomarginall"><?php echo $title ?></h1>

    <div role="alert" class="" id="info-msg"></div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Title</th>
                <th># of members</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="teams">

        </tbody>
    </table>

    <a href="<?php echo site_url('teams/add') ?>">Add new team</a>

</div>