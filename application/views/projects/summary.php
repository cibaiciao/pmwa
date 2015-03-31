<div id="nav-content">
    <h3>Welcome to your project</h3>
    <?php if ( $project['description'] ): ?>
        <?php echo $project['description'] ?>
    <?php else: ?>
        <p>Everything you need to know about how your project is running is tracked on this page. As your project evolves, the information will be updated. Use the tabs to navigate within your project.</p>

        <p>Change the <?php if ( $this->session->userdata('id') == $project['createdBy'] ): ?><a href="<?php echo site_url('projects/edit/'.$project['id']) ?>">project description</a><?php else: ?>project description<?php endif ?> details about your project.</p>
    <?php endif; ?>

    <hr/>

    <div class="row" id="summary">
        <div class="col-md-6">
            <table class="table table-condensed">
                <caption>Unresolved: By Priority</caption>
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Tasks</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody id="priority"></tbody>
            </table>

            <table class="table table-condensed">
                <caption>Unresolved: By Assignee</caption>
                <thead>
                    <tr>
                        <th>Assignee</th>
                        <th>Tasks</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody id="assignee"></tbody>
            </table>


        </div>
        <div class="col-md-6">
            <table class="table table-condensed">
                <caption>Status Summary</caption>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Tasks</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody id="status"></tbody>
            </table>

            <table class="table table-condensed">
                <caption>Unresolved: By Size</caption>
                <thead>
                <tr>
                    <th>Size</th>
                    <th>Tasks</th>
                    <th>Percentage</th>
                </tr>
                </thead>
                <tbody id="size"></tbody>
            </table>

            <table class="table table-condensed">
                <caption>Unresolved: By Type</caption>
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Tasks</th>
                    <th>Percentage</th>
                </tr>
                </thead>
                <tbody id="type"></tbody>
            </table>
        </div>
    </div>

</div>