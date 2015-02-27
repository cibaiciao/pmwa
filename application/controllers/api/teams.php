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
                $html[] = sprintf("<td><a href='%s'>%s</a></td>",site_url('teams/edit/'.$_team['id']),$_team['name']);
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

}