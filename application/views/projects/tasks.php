<div id="nav-content">
    <h3>Task List</h3>

    <div class="row" id="task-list">
        <div class="col-md-12">
            <div class="well well-sm">
                <table class="table table-condensed">
                    <caption>Search</caption>
                    <tbody>
                    <tr>
                        <td>
                            <label for="key">Key</label><br/>
                            <input type="text" value="" id="key" class="search"/>
                        </td>
                        <td>
                            <label for="assignee">Assignee</label><br/>
                            <?php echo form_dropdown("assignee",$assigneeOption,"",'id="assignee" class="search"') ?>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>

            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Key</th>
                    <th>Summary</th>
                    <th>Assignee</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Issue Type</th>
                    <th>Size</th>
                </tr>
                </thead>
                <tbody id="tasks"></tbody>
            </table>

        </div>
    </div>

</div>
<script>
    var assignee='<?php echo (string)$this->input->get('assignee') !== "" ? $this->input->get('assignee') : -1  ?>';
    var key='<?php echo $this->input->get('key') ? $this->input->get('key') : ''  ?>';
    var priority='<?php echo $this->input->get('priority') ? $this->input->get('priority') : ''  ?>';
    var status='<?php echo (string)$this->input->get('status') !== "" ? $this->input->get('status') : -1  ?>';
    var type='<?php echo $this->input->get('type') ? $this->input->get('type') : ''  ?>';
    var size='<?php echo $this->input->get('size') ? $this->input->get('size') : ''  ?>';
    var unresolved='<?php echo $this->input->get('unresolved') ? $this->input->get('unresolved') : 0  ?>';
</script>