<style>
    .tab-content {display:none;}
    .active { display: block;}
</style>
<div class="col-sm-10">
    <h1 class="page-header nomarginall" style="border-bottom: none;"><?php echo $project['name'] ?><br/><small>Key: <?php echo $project['key'] ?> | Created By: <?php echo $project['createdByName'] ?> | Deadline: <?php echo date("m/d/Y",strtotime($project['deadline'])) ?></small></h1>

    <div role="alert" class="" id="info-msg"></div>
    <ul class="nav nav-tabs">
        <li role="presentation" class="<?php echo $projectNav[0] ?>"><a href="<?php echo site_url('projects/detail/'.$project['id']."/summary") ?>">Summary</a></li>
        <li role="presentation" class="<?php echo $projectNav[1] ?>"><a href="<?php echo site_url('projects/detail/'.$project['id']."/tasks") ?>">Tasks</a></li>
    </ul>

    <?php echo $$tab ?>

</div>
<script>
    var project_id = <?php echo $project['id'] ?>;
</script>