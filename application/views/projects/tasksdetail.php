<div class="col-sm-10">
    <div class="row">
        <div class="col-sm-6">
            <h3 class="page-header"><a href="/projects/detail/<?php echo $project['id'] ?>/tasks"><?php echo $project['name'] ?></a> / <a href="<?php echo current_url() ?>"><?php echo $project['key'] ?>-<?php echo sprintf('%03d',$task['id']); ?></a></h3>

            <div role="alert" class="" id="info-msg"></div>

            <form id="form" name="form" role="form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo $task['name'] ?>"/>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <?php echo form_dropdown("type",array('STORY' => 'Story','IMPROVEMENT' => 'Improvement','BUG' => 'Bug'),$task['type'],'class="form-control" id="type"') ?>
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <?php echo form_dropdown("priority",array('EMERGENCY' => 'Emergency','CRITICAL' => 'Critical','MAJOR' => 'Major','MINOR' => 'Minor'),$task['priority'],'class="form-control"  id="priority"') ?>
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <?php echo form_dropdown("size",array('SMALL' => 'Small','MEDIUM' => 'Medium','LARGE' => 'Large'),$task['size'],'class="form-control"  id="size"') ?>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <?php echo form_dropdown("status",array(0 => 'Open',1 => 'In Progress',2 => 'QA',3 => 'Closed'),$task['status'],'class="form-control"  id="size"') ?>
                </div>
                <div class="form-group">
                    <label for="assignee">Assignee</label>
                    <?php echo form_dropdown("assignee",$assigneeOption,$task['assignee'],'class="form-control"  id="size"') ?>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control"><?php echo $task['description'] ?></textarea>
                </div>
                <button type="button" class="btn btn-default" id="btn">Edit</button>

            </form>
        </div>
        <div class="col-sm-6">
            <h3 class="page-header">Comment(s)</h3>
            <div id="comment-list">

            </div>
            <div style="height:1px;background:#DDD;"></div>
            <form id="commentForm" name="commentForm" role="form">
                <div class="form-group">
                    <label for="comment">Write your comment:</label>
                    <textarea name="comment" id="comment" class="form-control"></textarea>
                </div>
                <button type="button" class="btn btn-default" id="btn">Add</button>
                <input type="hidden" name="type" value="task"/>
            </form>
        </div>
    </div>







</div>