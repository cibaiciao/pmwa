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

    public function tasks($taskid) {
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

        $assigneeOption = array();
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

}