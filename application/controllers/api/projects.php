<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2/21/2015
 * Time: 7:09 PM
 */
class Projects extends MY_RestController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index_get() {

        $projects = $this->Api_model->getProjects();


        if ( count($projects) > 0 ) {
            foreach ( $projects as &$_project ) {

                $createdByName = $this->Api_model->getCreatedBy($_project['createdBy']);

                $html[] = "<tr>";
                $html[] = "<td><a href='/projects/detail/".$_project['id']."'>".$_project['name']."</a></td>";
                $html[] = "<td>".$_project['key']."</td>";
                $html[] = "<td>".$createdByName."</td>";
                $html[] = "<td>".date("m/d/Y",strtotime($_project['deadline']))."</td>";
                $html[] = $this->session->userdata('id') == $_project['createdBy'] ? "<td><a href='/projects/edit/".$_project['id']."'>Edit</a></td>" : "<td>&nbsp;</td>";
                $html[] = "</tr>";
            } unset($_project);
        } else {
            $html[] = "<tr><td colspan='5'>No project found.</td></tr>";
        }

        $this->response(array("data" => implode("",$html)),SUCCESS);

    }

    public function add_post() {
        $name = $this->post("name",TRUE);
        $key = $this->post("key",TRUE);
        $deadline = $this->post("deadline",TRUE);
        $description = $this->post("description",TRUE);
        $team_id = $this->post('team_id',TRUE);


        if ( trim($name) === "" ) {
            $this->response(array("message" => "The name field is required.","type" => "danger"),UNAUTHORIZED);
        }

        if ( trim($key) === "" ) {
            $this->response(array("message" => "The key field is required.","type" => "danger"),UNAUTHORIZED);
        }

        if ( trim($deadline) === "" ) {
            $this->response(array("message" => "The deadline field is required.","type" => "danger"),UNAUTHORIZED);
        }

        $isExist = $this->Api_model->checkProjectKey($this->session->userdata('id'),$key);
        if ( $isExist ) {
            $this->response(array("message" => "The key field is already existed.","type" => "danger"),UNAUTHORIZED);
        }

        $toInsert = array(
            "name" => $name,
            "key" => $key,
            "createdBy" => $this->session->userdata('id'),
            "createdDate" => date("Y-m-d H:i:s"),
            "deadline" => $deadline,
            "description" => $description,
            'team_id' => $team_id
        );
        $this->db->insert("projects",$toInsert);

        $this->response(array("redirect" => site_url('projects/index')),SUCCESS);

    }



    public function get_get() {
        $id = $this->get("id",TRUE);

        $project_data = $this->Api_model->getProject($id);

        if ( count($project_data) > 0 ) {
            $this->response($project_data,SUCCESS);
        } else {
            $this->response(array("redirect" => site_url('projects/index')),SUCCESS);
        }
    }

    public function edit_put() {
        $id = $this->put("id",TRUE);
        $name = $this->put("name",TRUE);
        $deadline = $this->put("deadline",TRUE);
        $description = $this->put("description",TRUE);


        if ( trim($name) === "" ) {
            $this->response(array("message" => "The name field is required.","type" => "danger"),UNAUTHORIZED);
        }

        if ( trim($deadline) === "" ) {
            $this->response(array("message" => "The deadline field is required.","type" => "danger"),UNAUTHORIZED);
        }

        $toUpdate = array(
            "name" => $name,
            "deadline" => $deadline,
            "description" => $description
        );

        $this->db->where("id",$id);
        $this->db->update("projects",$toUpdate);

        $this->response(array("message" => "Updated successful","type" => "success"),SUCCESS);

    }

    public function tasks_put() {
        $taskid = $this->put('taskid',TRUE);

        $this->db->where('id',$taskid);
        $result =$this->db->update("tasks",array(
            'name' => $this->put('name',TRUE),
            'type' => $this->put('type',TRUE),
            'priority' => $this->put('priority',TRUE),
            'size' => $this->put('size',TRUE),
            'status' => $this->put('status',TRUE),
            'assignee' => $this->put('assignee',TRUE),
            'description' => $this->put('description',TRUE)
        ));

        if ( $result ) {
            $this->response(array('message' => 'Task has been updated successfully','type' => 'success'),SUCCESS);
        } else {
            $this->response(array('message' => 'Task cannot be updated','type' => 'danger'),SUCCESS);
        }

    }

    public function tasks_get() {
        $id = $this->get("id",TRUE);

        $key = $this->get('key',TRUE);
        $assignee = $this->get('assignee',TRUE);
        $priority = $this->get('priority',TRUE);
        $status = $this->get('status',TRUE);
        $type = $this->get('type',TRUE);
        $size = $this->get('size',TRUE);



        $tasks = $this->Api_model->getTasksByProject($id,array(
            "key" => $key,
            "assignee" => $assignee,
            "priority" => $priority,
            "status" => $status,
            "type" => $type,
            "size" => $size
        ));

        if ( count($tasks) < 1 ) {
            $this->response(array("data" => '<tr><td colspan="7">No task found.</td></tr>'),SUCCESS);
        }

        $html = array();
        $statusMapping = array("Open","In Progress","QA","Closed");


        $project = $this->Api_model->getUniversalProject($id);
        $key = $project['key'];

        foreach ( $tasks as &$_task ) {
            if ( !intval($_task['assignee']) ) {
                $_task['assignee'] = -1;
                $assigneeName = "NA";
            } else {
                $userArr =  $this->Api_model->getUser($_task['assignee']);
                $assigneeName = $userArr['fname'].' '.$userArr['lname'];
            }

            $ticket = sprintf('%s-%03d',$key,$_task['id']);

            $html[] = '<tr data-projectkey="'.$key.'" data-taskid="'.$_task['id'].'" data-assigneeid="'.$_task['assignee'].'" data-priority="'.$_task['priority'].'" data-status="'.$_task['status'].'" data-type="'.$_task['type'].'" data-size="'.$_task['size'].'"  >';
            $html[] = '<td><a href="/projects/tasks/'.$_task['id'].'">'.$ticket.'</a></td>';
            $html[] = '<td>'.'<a href="/projects/tasks/'.$_task['id'].'">'.$_task['name'].'</a></td>';
            $html[] = '<td>'.$assigneeName.'</td>';
            $html[] = '<td>'.ucwords(strtolower($_task['priority'])).'</td>';
            $html[] = '<td>'.ucwords(strtolower($statusMapping[$_task['status']])).'</td>';
            $html[] = '<td>'.ucwords(strtolower($_task['type'])).'</td>';
            $html[] = '<td>'.ucwords(strtolower($_task['size'])).'</td>';
            $html[] = "</tr>";
        }

        $this->response(array("data" => implode("",$html)),SUCCESS);

    }

    public function summary_get() {
        $id = $this->get("id",TRUE);
        $type = $this->get("type",TRUE);

        switch ( strtolower($type) ) {
            case "priority":
                $data = $this->Api_model->getSummaryByPriority($id);

                $totalUnResolved = 0;
                foreach ( $data as &$_data ) {
                    $totalUnResolved += $_data['issues'];
                } unset($_data);


                $html = array();
                foreach ( $data as &$_data ) {
                    $percent = $totalUnResolved > 0 && $_data['issues'] > 0 ? number_format($_data['issues'] / $totalUnResolved * 100) : 0;
                    $html[] = "<tr>";
                    $html[] = "<td><a href='#'>".ucwords(strtolower($_data['priority']))."</a></td>";
                    $html[] = "<td>".$_data['issues']."</td>";
                    $html[] = "<td><div class='progress'><div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"{$percent}\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: {$percent}%;\">".$percent."%</div></div></td>";
                    $html[] = "</tr>";
                }

                $this->response(array("data" => implode("",$html)),SUCCESS);

                break;
            case "assignee":
                $data = $this->Api_model->getSummaryByAssignee($id);

                if ( count($data) > 0 ) {
                    $totalUnResolved = 0;
                    foreach ( $data as &$_data ) {
                        $totalUnResolved += $_data['issues'];
                    } unset($_data);

                    $html = array();
                    foreach ( $data as &$_data ) {
                        $percent = $totalUnResolved > 0 && $_data['issues'] > 0 ? number_format($_data['issues'] / $totalUnResolved * 100) : 0;
                        $html[] = "<tr>";
                        $html[] = "<td><a href='#'>".$this->Api_model->getCreatedBy($_data['assignee'])."</a></td>";
                        $html[] = "<td>".$_data['issues']."</td>";
                        $html[] = "<td><div class='progress'><div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"{$percent}\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: {$percent}%;\">".$percent."%</div></div></td>";
                        $html[] = "</tr>";
                    }

                    $this->response(array("data" => implode("",$html)),SUCCESS);

                } else {
                    $this->response(array("data" => "<tr><td colspan=\"3\">No assignee found</td></tr>"),SUCCESS);
                }
                break;
            case "status":
                $data = $this->Api_model->getSummaryByStatus($id);

                $totalUnResolved = 0;
                foreach ( $data as &$_data ) {
                    $totalUnResolved += $_data['issues'];
                } unset($_data);

                $html = array();
                foreach ( $data as &$_data ) {
                    $percent = $totalUnResolved > 0 && $_data['issues'] > 0 ? number_format($_data['issues'] / $totalUnResolved * 100) : 0;
                    $html[] = "<tr>";
                    $html[] = "<td><a href='#'>".ucwords(strtolower($_data['status']))."</a></td>";
                    $html[] = "<td>".$_data['issues']."</td>";
                    $html[] = "<td><div class='progress'><div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"{$percent}\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: {$percent}%;\">".$percent."%</div></div></td>";
                    $html[] = "</tr>";
                }

                $this->response(array("data" => implode("",$html)),SUCCESS);

                break;
            case "size":
                $data = $this->Api_model->getSummaryBySize($id);

                $totalUnResolved = 0;
                foreach ( $data as &$_data ) {
                    $totalUnResolved += $_data['issues'];
                } unset($_data);

                $html = array();
                foreach ( $data as &$_data ) {
                    $percent = $totalUnResolved > 0 && $_data['issues'] > 0 ? number_format($_data['issues'] / $totalUnResolved * 100) : 0;
                    $html[] = "<tr>";
                    $html[] = "<td><a href='#'>".ucwords(strtolower($_data['size']))."</a></td>";
                    $html[] = "<td>".$_data['issues']."</td>";
                    $html[] = "<td><div class='progress'><div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"{$percent}\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: {$percent}%;\">".$percent."%</div></div></td>";
                    $html[] = "</tr>";
                }

                $this->response(array("data" => implode("",$html)),SUCCESS);
                break;
            case "type":
                $data = $this->Api_model->getSummaryByType($id);

                $totalUnResolved = 0;
                foreach ( $data as &$_data ) {
                    $totalUnResolved += $_data['issues'];
                } unset($_data);

                $html = array();
                foreach ( $data as &$_data ) {
                    $percent = $totalUnResolved > 0 && $_data['issues'] > 0 ? number_format($_data['issues'] / $totalUnResolved * 100) : 0;
                    $html[] = "<tr>";
                    $html[] = "<td><a href='#'>".ucwords(strtolower($_data['type']))."</a></td>";
                    $html[] = "<td>".$_data['issues']."</td>";
                    $html[] = "<td><div class='progress'><div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"{$percent}\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: {$percent}%;\">".$percent."%</div></div></td>";
                    $html[] = "</tr>";
                }

                $this->response(array("data" => implode("",$html)),SUCCESS);
                break;
        }


    }

    public function comments_get() {
        $id = $this->get("id",TRUE);

        // task id
        $taskid=$this->get('taskid',TRUE);


        $comments = $this->Api_model->getComments($taskid,"task");


        if ( count($comments) > 0 ) {
            $html = '';
            foreach ( $comments as &$_comment ) {
                $user = $this->Api_model->getUser($_comment['user_id']);
                $fullName = $user['fname'].' '.$user['lname'];
                $created = date("m/d/Y g:i A",strtotime($_comment['created']));
                $comment = $_comment['comment'];
                $html .= <<<OEF
                    <div class='comment'>
                        <p><strong>{$fullName}</strong> <small>{$created}</small></p>
                        <div class="well well-sm">
                            {$comment}
                        </div>
                    </div>

OEF;
            } unset($_comment);
        } else {
            $html = <<<"OEF"
                    <div class='comment'>
                        <p>Be the first one to write comment.</p>
                    </div>
OEF;
        }

        $this->response(array("data" => $html),SUCCESS);
    }

    public function comments_post() {
        // task id
        $taskid=$this->post('taskid',TRUE);
        $comment = $this->post('comment',TRUE);
        $type=$this->post('type');


        $toInsert = array(
            "second_id" => $taskid,
            "user_id" => $this->session->userdata('id'),
            "comment" => htmlspecialchars($comment),
            'created' => date("Y-m-d H:i:s"),
            'type' => $type
        );
        $this->db->insert('comments',$toInsert);

        $this->response(array("message" => "Success",'type' =>'success'),SUCCESS);
    }
}