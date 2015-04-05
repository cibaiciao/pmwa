<?php
/**
 * Created by PhpStorm.
 * User: TriNguyen
 * Date: 3/5/15
 * Time: 9:29 PM
 */

class Projects extends MY_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->vars(array("nav" => array("","active","","","")));
    }

    public function index() {
        $data['title'] = "Projects";
//        $data["css"][] = "assets/css/teams/index.css";
        $data["js"][] = "assets/js/projects/index.js";

        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("projects/index",$data,TRUE);

        $this->load->view("layout",$data);
    }

    public function add() {
        $data['title'] = "Projects - Add new";
        $data["js"][] = "assets/js/projects/add.js";

        $teams = $this->Api_model->getParticipatedTeam();

        $teamOption = array();
        foreach ( $teams as &$_team ) {
            $teamOption[$_team['id']] = $_team['name'];
        }

        $data['teamOption'] = $teamOption;
        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("projects/add",$data,TRUE);

        $this->load->view("layout",$data);

    }

    public function edit($id) {

        $project = $this->Api_model->getProject($id);

        if ( count($project) < 1 ) {
            redirect(site_url("projects/index"));
        }

        $data["id"] = $id;
        $data['title'] = "Projects - Edit #{$id}";
        $data["js"][] = "assets/js/projects/edit.js";

        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("projects/edit",$data,TRUE);

        $this->load->view("layout",$data);

    }

    public function detail($id,$tab="summary") {
        $project = $this->Api_model->getUnconditionalProject($id);

        if ( count($project) < 1 ) {
            redirect(site_url("projects/index"));
        }

        $project['createdByName'] = $this->Api_model->getCreatedBy($project['createdBy']);

        $data["project"] = $project;
        $data['title'] = "Projects - Detail #{$id}";
        $data["js"][] = "assets/js/projects/detail.js";


        switch ( $tab ) {
            case "summary":
                $nav = array("active","");
                break;
            case "tasks":
                $data["assigneeOption"] = $this->getAssigneeOption($project['team_id']);
                $nav = array("","active");
                break;
        }
        $this->load->vars(array("projectNav" => $nav));

        $data["tab"] = $tab;
        $data[$tab] = $this->load->view("projects/$tab",$data,TRUE);

        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("projects/detail",$data,TRUE);

        $this->load->view("layout",$data);
    }

    protected function getAssigneeOption($team_id) {
        $assignees = $this->Api_model->getAssignee($team_id);
        $assigneeOption = array('' => '-Select-');
        if ( count($assignees) > 0 ) {
            foreach ( $assignees as &$_assignee ) {
                $assigneeOption[$_assignee['id']] = $_assignee['fname'].' '.$_assignee['lname'];
            }
        }

        return $assigneeOption;
    }

    public function addNewTask($projectid) {
        $nav = array("","active");
        $this->load->vars(array("projectNav" => $nav));
        $data["tab"] =$tab = "tasks";

        $data['title'] = "Task - Add New";
        $data["js"][] = "assets/js/projects/tasksdetail.js";

        $project = $this->Api_model->getUniversalProject($projectid);
        $project['createdByName'] = $this->Api_model->getCreatedBy($project['createdBy']);

        $data['project'] = $project;

        $data['assigneeOption'] = $this->getAssigneeOption($project['team_id']);


        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data[$tab] = $this->load->view("projects/addNewTask",$data,TRUE);
        $data["body"] = $this->load->view("projects/detail",$data,TRUE);

        $this->load->view("layout",$data);


    }

    public function tasks($taskid) {
        if ( !$taskid ) {
            redirect('/projects');
        }


        $nav = array("","active");
        $this->load->vars(array("projectNav" => $nav));
        $data["tab"] =$tab = "tasks";


        $data["id"] = $taskid;
        $data['title'] = "Task - Detail #{$taskid}";
        $data["js"][] = "assets/js/projects/tasksdetail.js";

        $task = $this->Api_model->getTask($taskid);
        $project = $this->Api_model->getUniversalProject($task['project_id']);
        $project['createdByName'] = $this->Api_model->getCreatedBy($project['createdBy']);

        $data['task'] = $task;
        $data['project'] = $project;

        $assignees = $this->Api_model->getAssignee($project['team_id']);

        $assigneeOption = array('' => '-Select-');
        if ( count($assignees) > 0 ) {
            foreach ( $assignees as &$_assignee ) {
                $assigneeOption[$_assignee['id']] = $_assignee['fname'].' '.$_assignee['lname'];
            }
        }
        $data['assigneeOption'] = $assigneeOption;


        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data[$tab] = $this->load->view("projects/tasksdetail",$data,TRUE);
        $data["body"] = $this->load->view("projects/detail",$data,TRUE);

        $this->load->view("layout",$data);

    }

    public function exportTaskCSV() {
        if ( !$this->input->get() ) {
            show_404("Page not found");
        }
        foreach ( $this->input->get() as $k => $value) {
            $$k = $value;
        }
        $project = $this->Api_model->getUniversalProject($projectid);
        $projectKey = $project['key'];

        if ( !isset($unresolved) ) {
            $unresolved = 0;
        }

        $tasks = $this->Api_model->getTasksByProject($projectid,array(
            "key" => $key,
            "assignee" => $assignee,
            "priority" => $priority,
            "status" => $status,
            "type" => $type,
            "size" => $size,
            'unresolved' => $unresolved
        ));
        $statusMapping = array("Open","In Progress","QA","Closed");


        $name = "tasks.csv";

        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename={$name}");
        header("Pragma: no-cache");

        $output = fopen("php://output", "w");

        $csv = array(
            "Key",
            "Name",
            "Summary",
            "Assignee",
            "Priority",
            "Status",
            "Issue Type",
            "Size"
        );
        fputcsv($output,$csv);

        if ( count($tasks) > 0 ) {
            foreach ( $tasks as &$_task ) {
                $user = $this->Api_model->getCreatedBy($_task['assignee']);

                $row = array(
                    sprintf('%s-%03d',$projectKey,$_task['id']),
                    $_task['name'],
                    $_task['description'],
                    $user,
                    ucwords(strtolower($_task['priority'])),
                    $statusMapping[$_task['status']],
                    ucwords(strtolower($_task['type'])),
                    ucwords(strtolower($_task['size']))
                );

                fputcsv($output,$row);

            } unset($_value);
        }

        fclose($output);

    }

}