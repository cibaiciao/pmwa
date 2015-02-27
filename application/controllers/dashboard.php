<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2/21/2015
 * Time: 12:50 AM
 */

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->vars(array("nav" => array("active","","","","")));
    }

    public  function  index() {
        $data['title'] = "Dashboard";
        $data["css"][] = "assets/css/dashboard/index.css";
        $data["js"][] = "assets/js/dashboard/index.js";


        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("dashboard/index",$data,TRUE);

        $this->load->view("layout",$data);
    }




}