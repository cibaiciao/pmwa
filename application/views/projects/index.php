<div class="col-sm-10">
    <h1 class="page-header nomarginall"><?php echo $title ?></h1>

    <div role="alert" class="" id="info-msg"></div>


    <table class="table table-striped">
        <thead>
            <tr>
                <th>Project</th>
                <th>Key</th>
                <th>Created By</th>
                <th>Deadline</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody id="project"></tbody>

        <tfoot>
            <tr><td colspan="5"><a href="<?php echo site_url('projects/add') ?>">Add new project</a></td></tr>
        </tfoot>
    </table>


</div>