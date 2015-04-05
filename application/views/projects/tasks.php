<div id="nav-content">
    <h3>Task List</h3>

    <div class="row" id="task-list">
        <div class="col-md-12">
            <div class="well well-sm">
                <form id="form">
                    <table class="table table-condensed">
                        <caption>Search</caption>
                        <tbody>
                        <tr>
                            <td>
                                <label for="key">Key</label><br/>
                                <input type="text" value="" id="key" class="search" name="key"/>
                            </td>
                            <td>
                                <label for="assignee">Assignee</label><br/>
                                <?php
                                    $assigneeSelected  = (string)$this->input->get('assignee') !== "" ? $this->input->get('assignee') : -1;
                                ?>
                                <?php echo form_dropdown("assignee",
                                                            $assigneeOption,
                                                            $assigneeSelected,
                                                            'id="assignee" class="search"') ?>
                            </td>
                            <td>
                                <label for="priority">Priority</label><br/>
                                <?php
                                    $prioritySelected = $this->input->get('priority') ? $this->input->get('priority') : '';
                                ?>
                                <?php echo form_dropdown("priority",
                                                        array('' => '-Select-','Major' => 'Major','Minor' => 'Minor','Emergency' => 'Emergency','Critical' => 'Critical' ),
                                                        $prioritySelected,
                                                        'id="priority" class="search"');
                                ?>
                            </td>
                            <td>
                                <label for="status">Status</label><br/>
                                <?php echo form_dropdown("status",
                                                                array(-1 => "-Select-","Open","In Progress","QA","Closed"),
                                                                (string)$this->input->get('status') !== "" ? $this->input->get('status') : -1,
                                                                'id="status" class="search"') ?>
                            </td>
                            <td>
                                <label for="type">Issue Type</label><br/>
                                <?php echo form_dropdown("type",
                                                                array("" => "-Select-","Story" => "Story","Improvement" => "Improvement","Bug" => "Bug"),
                                                                $this->input->get('type') ? $this->input->get('type') : '',
                                                                'id="type" class="search"') ?>
                            </td>
                            <td>
                                <label for="size">Size</label><br/>
                                <?php echo form_dropdown("size",
                                                                array("" => "-Select-","Small" => "Small","Medium" => "Medium","Large" => "Large"),
                                                                $this->input->get('size') ? $this->input->get('size') : '',
                                                                'id="size" class="search"') ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <button type="button" class="btn btn-primary" onclick="filter();">Submit</button>
                                <button type="button" class="btn btn-default" onclick="exportCSV();">Export CSV</button>
                            </td>
                        </tr>
                        </tbody>

                    </table>

                    <input type="hidden" name="projectid" value="<?php echo $project['id'] ?>" id="projectid"/>
                </form>
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