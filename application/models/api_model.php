<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2/20/2015
 * Time: 10:44 PM
 */

class Api_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function validate($email,$password) {
        $this->db->select("id,fname,lname,email,1 as isLogin",FALSE);
        $this->db->where("email",$email)
                 ->where(sprintf("(password = '%s' OR password = '%s' )",$password,md5($password.HASHKEY)));
        $query = $this->db->get("users");
        return $query->num_rows() > 0 ? $query->row_array() : array();
    }

    public function checkDupEmail($email) {
        $query = $this->db->get_where("users",array("email" => $email));

        return $query->num_rows() > 0 ? $query->row_array() : array();
    }

    public function createUser($fname,$lname,$email,$password) {
        $toInsert = array(
            "fname" => $fname,
            "lname" => $lname,
            "email" => $email,
            "password" => md5($password.HASHKEY)
        );
        $this->db->insert("users",$toInsert);

        return (int)$this->db->insert_id();
    }

    public function getUser($id) {
        return $this->db->get_where("users",array("id" => $id))->row_array();
    }

    public function getTeams() {

        $this->db->select("t.*, (SELECT COUNT(id) FROM users_teams WHERE team_id=t.id AND isConfirm=1) as numberOfMembers , ut.status",FALSE)
                 ->from("teams t")
                 ->join("users_teams ut","ut.team_id = t.id")
                 ->where("ut.user_id",$this->session->userdata('id'));
        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : array();
    }

    public function getTeam($id) {
        $query = $this->db->get_where("teams",array("id" => $id ));

        return $query->num_rows() > 0 ? $query->row_array() : array();
    }

    public function getUsersByTeam($id) {

        $this->db->select("status, isConfirm, CONCAT(fname,' ',lname) as full_name, email, ut.user_id, ut.created, ut.id as teamuserid, role",FALSE)
                 ->from("users_teams ut")
                 ->join("users u","u.id = ut.user_id")
                 ->where("user_id <>",$this->session->userdata('id'))
                 ->where("team_id",$id)
                 ->group_by("user_id");
        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : array();
    }


    public function getUserByEmail($email) {
        $query = $this->db->get_where("users",array("email" => $email));

        return $query->num_rows() > 0 ? $query->row_array() : array();
    }

    public function checkInvitedUser($email,$team_id) {
        $this->db->from("users u")
                 ->join("users_teams ut","ut.user_id = u.id")
                 ->where("ut.team_id",$team_id)
                 ->where("u.email",$email);
        $query = $this->db->get();

        return $query->num_rows() > 0 ? TRUE : FALSE;
    }

    public function getProjects() {
        // get the project that user participates in
        $this->db->distinct()
                 ->select("project_id");
        $query = $this->db->get_where("tasks",array("assignee" => $this->session->userdata("id")));


        $projects = array();

        if ( $query->num_rows() > 0 ) {
            $qryAssignee = $query->result_array();
            foreach ( $qryAssignee as $_project_id ) {
                $projects[$_project_id['project_id']] = 1;
            }
        }

        $sql = "SELECT * FROM projects WHERE createdBy = ".$this->session->userdata('id');

        if ( !empty($projects ) ) {
            $sql .= " OR id IN (".implode(",",$projects).")";
        }

        $query = $this->db->query($sql);


        return $query->num_rows() > 0 ? $query->result_array() : array();
    }

    public function checkProjectKey($createdby,$key) {
        $query = $this->db->get_where("projects",array("createdBy" => $createdby,"key" => $key));

        return $query->num_rows() > 0 ? TRUE : FALSE;
    }

    public function getProject($id) {
        $query = $this->db->get_where("projects",array("id" => $id, "createdBy" => $this->session->userdata('id')));

        return $query->num_rows() > 0 ? $query->row_array() : array();
    }

    public function getUniversalProject($id) {
        $query = $this->db->get_where("projects",array("id" => $id));

        return $query->num_rows() > 0 ? $query->row_array() : array();
    }

    public function getUnconditionalProject($id) {
        $query = $this->db->get_where("projects",array("id" => $id));

        return $query->num_rows() > 0 ? $query->row_array() : array();
    }

    public function getCreatedBy($id) {
        $query = $this->db->get_where("users",array("id" => $id));

        return $query->num_rows() > 0 ? $query->row()->fname.' '.$query->row()->lname : "NA";
    }

    public function getSummaryByPriority($project_id) {
        $priorityList = array('EMERGENCY','CRITICAL','MAJOR','MINOR');


        /**
         * Status
         * 0        Open
         * 1        In Progress
         * 2        QA
         * 3        Closed
         */

        $sql = array();
        foreach ( $priorityList as &$_priority ) {

            $sql[] = "SELECT '$_priority' as priority, COUNT(*) as issues FROM tasks WHERE priority='$_priority' AND status IN (0,1) AND project_id = ".$project_id;

        } unset($_priority);



        $sql = implode(" UNION ",$sql);


        $query = $this->db->query($sql);


        return $query->num_rows() > 0 ? $query->result_array() : array();
    }

    public function getSummaryByAssignee($project_id) {
        $sql = "SELECT assignee, COUNT(*) as issues FROM tasks WHERE status IN (0,1) AND project_id = '{$project_id}' GROUP BY assignee";

        $query = $this->db->query($sql);

        return $query->num_rows() > 0 ? $query->result_array() : array();


    }

    public function getSummaryByStatus($project_id) {
        $statusMapping = array("Open","In Progress","QA","Closed");

        $sql = array();

        foreach ( $statusMapping as $code => $name ) {
            $sql[] = "SELECT '$name' as status, COUNT(*) as issues FROM tasks WHERE status='$code' AND project_id=".$project_id;
        }

        $sql = implode(" UNION ",$sql);

        $query = $this->db->query($sql);
        return $query->num_rows() > 0 ? $query->result_array() : array();
    }

    public function getSummaryBySize($project_id) {
        $sizeList = array("SMALL","MEDIUM","LARGE");

        $sql = array();
        foreach ( $sizeList as &$_size ) {
            $sql[] = "SELECT '$_size' as size, COUNT(*) as issues FROM tasks WHERE size='$_size' AND  status IN (0,1) AND project_id=".$project_id;
        }

        $sql = implode(" UNION ",$sql);

        $query = $this->db->query($sql);


        return $query->num_rows() > 0 ? $query->result_array() : array();

    }

    public function getSummaryByType($project_id) {
        $typeList = array('STORY','IMPROVEMENT','BUG');

        $sql = array();
        foreach ( $typeList as &$_type ) {
            $sql[] = "SELECT '$_type' as type, COUNT(*) as issues FROM tasks WHERE status IN (0,1) AND type='{$_type}' AND project_id=".$project_id;
        }unset($_type);

        $sql = implode(" UNION ",$sql);

        $query = $this->db->query($sql);


        return $query->num_rows() > 0 ? $query->result_array() : array();


    }

    public function getTasksByProject($projectid,$criteria) {

        if ( count($criteria) > 0 ) {
            if ( isset($criteria['key']) && trim($criteria['key']) !== '' ) {
                list($key,$taskid) = explode('-',$criteria['key']);
                $this->db->where('id',$taskid);
            }

            if ( isset($criteria['assignee']) && trim($criteria['assignee']) !== '' && $criteria['assignee'] != -1 ) {
                $this->db->where('COALESCE(assignee,0)',$criteria['assignee']);
            }

            if ( isset($criteria['unresolved']) && trim($criteria['unresolved']) !== '' && !isset($criteria['status']) && trim($criteria['status']) !== "-1" ) {
                $this->db->where_in('status',array(0,1));
            }



//            foreach (  $criteria as $key => &$value ) {
//                if ( trim($value) === "" ) { continue;}
//
//                switch ( $key ) {
//                    case 'key':
//
//                        break;
//                    case 'assignee':
//                        if ( $value != -1 ) {
//                            $this->db->where('COALESCE(assignee,0)',$value);
//                        }
//                        break;
//                    case 'unresolved':
////                        if ( !isset($criteria['status']) ) {
//                            $this->db->where_in('status',array(0,1));
////                        }
//
//                        break;
//                    case 'status':
//                        if ( $value != -1 ) {
//                            $this->db->where('status',$value);
//                        }
//                        break;
//                    default:
//                        $this->db->where($key,$value);
//                }
//            } unset($value);
        }


        $this->db->where('project_id',$projectid);
        $query = $this->db->get("tasks"); echo $this->db->last_query();die();

        return $query->num_rows() > 0 ? $query->result_array() : array();
    }

    public function getTask($id) {
        $query = $this->db->get_where("tasks",array("id" => $id));

        return $query->num_rows() > 0 ? $query->row_array() : array();
    }

    public function getParticipatedTeam() {
        $this->db->select("t.*")
                 ->from("users_teams ut")
                 ->join("teams t","t.id = ut.team_id")
                 ->where("ut.user_id",$this->session->userdata('id'));

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : array();
    }

    public function getAssignee($team_id) {
        $this->db->select('u.*')
                 ->from("users_teams ut")
                 ->join("users u","u.id = ut.user_id")
                 ->where("ut.team_id",$team_id)
                 ->where('ut.isConfirm',1);
        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result_array() : array();
    }

    public function getComments($id,$type="task") {
        $this->db->order_by("created ASC");
        $query = $this->db->get_where("comments",array("second_id" => $id,"type" => $type));

        return $query->num_rows() > 0 ? $query->result_array() : array();
    }


}