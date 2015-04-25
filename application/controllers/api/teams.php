<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2/21/2015
 * Time: 7:09 PM
 */
class Teams extends MY_RestController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index_get() {

        $teams = $this->Api_model->getTeams();

        $html = array();
        if ( count($teams) > 0 ) {
            foreach ( $teams as &$_team ) {
                $html[] = "<tr>";
                $html[] = "<td>".($_team['createdBy'] == $this->session->userdata('id') ? sprintf("<a href='%s'>%s</a>",site_url('teams/edit/'.$_team['id']),$_team['name']) : $_team['name'])."</td>";
                $html[] = sprintf("<td>%s</td>",$_team['status'] ? "Active" : "Inactive");
                $html[] = sprintf("<td>%s</td>",$_team['createdBy'] == $this->session->userdata('id') ? "Owner" : "Member");
                $html[] = sprintf("<td>%s</td>",$_team['numberOfMembers']);
                $html[] = sprintf("<td>%s</td>",$_team['status'] ? "Active" : "Inactive" );
                $html[] = "</tr>";
            } unset($_team);
        } else {
            $html[] = "<tr><td colspan='4'>No team available.</td>";
        }


        $this->response(array("data" => implode("",$html)),SUCCESS);


    }

    public function get_get() {
        $id = $this->get("id",TRUE);

        $team_data = $this->Api_model->getTeam($id);

        if ( count($team_data) > 0 ) {
            $this->response($team_data,SUCCESS);
        } else {
            $this->response(array("redirect" => site_url('teams/index')),200);
        }
    }

    public function add_post() {

        $name = $this->post("name",TRUE);

        if ( trim($name) === "" ) {
            $this->response(array("message" => "The name field is required.","type" => "danger"),UNAUTHORIZED);
        }

        $toInsert = array("name" => $name, "createdBy" => $this->session->userdata('id'));

        $this->db->insert("teams",$toInsert);

        $team_id = $this->db->insert_id();

        $toInsertTeamUser = array("team_id" => $team_id, "user_id" => $this->session->userdata('id'), "isConfirm" => 1, "created" => date("Y-m-d H:i:s"));
        $this->db->insert("users_teams",$toInsertTeamUser);

        $this->response(array("redirect" => site_url('teams/index')),SUCCESS);

    }

    public function edit_put() {
        $id = $this->put("id",TRUE);
        $name = $this->put("name",TRUE);
        $status = $this->put("status",TRUE);


        if ( trim($name) === "" ) {
            $this->response(array("message" => "The name field is required.","type" => "danger"),UNAUTHORIZED);
        }


        $toUpdate = array(
            "name" => $name,
            "status" => $status
        );
        $this->db->where("id",$id);
        $this->db->update("teams",$toUpdate);

        $this->response(array("message" => "Updated successful","type" => "success"),SUCCESS);

    }

    public function users_get($team_id) {
        if ( !$team_id ) {
            $this->response(array("message" => "Internal Server Problem","type" => "danger"),INTERNAL_SERVER_ERROR);
        }

        $teamdata = $teamdata = $this->Api_model->getTeam($team_id);

        if ( count($teamdata) < 1 ) {
            $this->response(array("redirect" => site_url("teams")),SUCCESS);
        }

        $users = $this->Api_model->getUsersByTeam($team_id);


        $renderDropdown = function($team_user_id,$status) {
            $html[] = "<select data-userteamid='{$team_user_id}' onchange='changeUserStatus(this);'>";
            $html[] = sprintf("<option %s value='1'>Active</option>",(string)$status==="1" ? "selected" : "");
            $html[] = sprintf("<option %s value='0'>Inactive</option>",(string)$status==="0" ? "selected" : "");
            $html[] = "</select>";

            return implode("",$html);
        };

        $renderRole = function($team_user_id,$role) {
            $html[] = "<select data-userteamid='{$team_user_id}' onchange='changeUserRole(this);'>";
            $html[] = sprintf("<option %s value='Developer'>Developer</option>",(string)strtoupper($role)==="DEVELOPER" ? "selected" : "");
            $html[] = sprintf("<option %s value='Project Manager'>Project Manager</option>",(string)strtoupper($role)==="PROJECT MANAGER" ? "selected" : "");
            $html[] = sprintf("<option %s value='QA'>QA</option>",(string)strtoupper($role)==="QA" ? "selected" : "");
            $html[] = "</select>";

            return implode("",$html);
        };

        $html = array();
        if ( count($users) > 0 ) {
            foreach ( $users as &$_user ) {
                if ( !$_user['isConfirm'] ) {
                    $html[] = "<tr>";
                    $html[] = sprintf("<td>%s</td>",$_user['full_name']);
                    $html[] = "<td>NA</td>";
                    $html[] = sprintf("<td>%s</td>",$_user['email']);
                    $html[] = sprintf("<td colspan='2' align='center'>Wait for user to confirm -- <a href='javascript:;' onclick='cancelInvitation(this);' data-userid='%d'>cancel</a></td>",$_user['user_id']);
                    $html[] = "</tr>";
                } else {
                    $html[] = "<tr>";
                    $html[] = sprintf("<td>%s</td>",$_user['full_name']);
                    $html[] = "<td>".$renderRole($_user['teamuserid'],$_user['role'])."</td>";
                    $html[] = sprintf("<td>%s</td>",$_user['email']);
                    $html[] = sprintf("<td>%s</td>",date("m/d/Y g:i A",strtotime($_user['created'])));
                    $html[] = "<td>".$renderDropdown($_user['teamuserid'],$_user['status'])."</td>";
                    $html[] = "</tr>";
                }

            } unset($_user);
        } else {
            $html[] = "<tr><td colspan='5'>No user found.</td></tr>";
        }

        $this->response(array("data" => implode("",$html)),SUCCESS);
    }

    public function users_post($team_id) {
        $team_id = $this->security->xss_clean($team_id);
        $email = $this->post("email",TRUE);

        if ( !$team_id ) {
            $this->response(array("message" => "Internal Server Problem","type" => "danger"),INTERNAL_SERVER_ERROR);
        }

        $teamdata = $teamdata = $this->Api_model->getTeam($team_id);

        if ( count($teamdata) < 1 ) {
            $this->response(array("redirect" => site_url("teams")),SUCCESS);
        }

        if ( !valid_email($email) ) {
            $this->response(array("message" => "Invalid email address", "type" => "danger"),UNAUTHORIZED);
        }

        $user = $this->Api_model->getUserByEmail($email);

        if ( count($user) < 1 ) {
            $this->response(array("message" => "There is no user associated with the email address.","type" => "warning"),UNAUTHORIZED);
        }

        $checkInvitedUser = $this->Api_model->checkInvitedUser($email,$team_id);

        if ( $checkInvitedUser ) {
            $this->response(array("message" => "The e-mail address already existed.", "type" => "warning"),UNAUTHORIZED);
        }

        $toInsert = array(
            "user_id" => $user['id'],
            "team_id" => $team_id,
            "created" => date("Y-m-d H:i:s")
        );
        $this->db->insert("users_teams",$toInsert);

        $insertid = $this->db->insert_id();
        // send email out to the user
        $confirmLink = site_url('teams/confirm/'.$insertid);
        $message =<<<"OEF"
            Hi,<br/>
            <br/>
            You have pending invitation from your friend.<br/>
            Please click to the link below to accept it.<br/>
            <br/>
            <a href='$confirmLink'>Click here to confirm</a>
OEF;


        $this->email->clear();
        $this->email->from('noreply@pmwa.com')
                    ->to($email)
                    ->subject('Response to accept to join the team')
                    ->message($message)
                    ->send();

        $this->response(array("status" => 1, "message" => "The invitation has been sent. Please wait for the user to confirm.", "type" => "success"),SUCCESS);
    }

    public function users_delete($team_id) {
        $team_id = $this->security->xss_clean($team_id);
        $user_id = $this->delete("user_id",TRUE);

        if ( !$team_id ) {
            $this->response(array("message" => "Internal Server Problem","type" => "danger"),INTERNAL_SERVER_ERROR);
        }

        $teamdata = $teamdata = $this->Api_model->getTeam($team_id);

        if ( count($teamdata) < 1 ) {
            $this->response(array("redirect" => site_url("teams")),SUCCESS);
        }


        $this->db->where("team_id",$team_id)->where("user_id",$user_id)->delete("users_teams");

        $this->response(array("status" => 1, "message" => "The invitation has been cancelled.", "type" => "success"),SUCCESS);


    }

    public function users_put($team_id)
    {
        $team_id = $this->security->xss_clean($team_id);
        $userteamid = $this->put("userteamid", TRUE);

        if (!$team_id) {
            $this->response(array("message" => "Internal Server Problem", "type" => "danger"), INTERNAL_SERVER_ERROR);
        }

        $teamdata = $teamdata = $this->Api_model->getTeam($team_id);

        if ( count($teamdata) < 1 ) {
            $this->response(array("redirect" => site_url("teams")),SUCCESS);
        }


        $type = $this->put("type",TRUE);

        switch ( $type ) {
            case "status":
                $sql = "UPDATE users_teams SET status= NOT status WHERE id={$userteamid}";
                break;
            case "role":
                $value = $this->put("value",TRUE);
                if ( !in_array($value,array("Project Manager","QA","Developer")) ) {
                    $this->response(array("message" => "Failed to modify user role","type" => "danger"),UNAUTHORIZED);
                }
                $sql = "UPDATE users_teams SET role = '{$value}' WHERE id='$userteamid'";
                break;
        }
        $this->db->query($sql);


        $this->response(array("status" => 1, "message" => "You have updated the status an user account.", "type" => "success"),SUCCESS);
    }

}