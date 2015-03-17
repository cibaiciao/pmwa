<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2/21/2015
 * Time: 10:14 PM
 */

class Teams extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->vars(array("nav" => array("","","","active","")));
    }

    public function index() {
        $data['title'] = "Teams";
//        $data["css"][] = "assets/css/teams/index.css";
        $data["js"][] = "assets/js/teams/index.js";

        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("teams/index",$data,TRUE);

        $this->load->view("layout",$data);
    }

    public function add() {
        $data['title'] = "Teams - Add new";
//        $data["css"][] = "assets/css/teams/add.css";
        $data["js"][] = "assets/js/teams/add.js";

        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("teams/add",$data,TRUE);

        $this->load->view("layout",$data);

    }

    public function edit($id) {

        $teamdata = $this->Api_model->getTeam($id);

        if ( count($teamdata) < 1 ) {
            redirect(site_url("teams/index"));
        }


        $data['isOwner'] = $teamdata['createdBy'] == $this->session->userdata('id') ? 1 : 0;
        $data["id"] = $id;
        $data['title'] = "Teams - Edit #{$id}";
//        $data["css"][] = "assets/css/teams/edit.css";
        $data["js"][] = "assets/js/teams/edit.js";

        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("teams/edit",$data,TRUE);

        $this->load->view("layout",$data);

    }

}