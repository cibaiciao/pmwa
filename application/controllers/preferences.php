<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2/21/2015
 * Time: 8:31 PM
 */

class Preferences extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->vars(array("nav" => array("","","","","","active")));
    }

    public function index() {
        $data['title'] = "Preferences";
        $data["css"][] = "assets/css/preferences/index.css";
        $data["js"][] = "assets/js/preferences/index.js";


        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("preferences/index",$data,TRUE);

        $this->load->view("layout",$data);
    }


    public function info() {
        $data['title'] = "Contact Information";
        $data["css"][] = "assets/css/preferences/info.css";
        $data["js"][] = "assets/js/preferences/info.js";


        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("preferences/info",$data,TRUE);

        $this->load->view("layout",$data);
    }

    public function password() {
        $data['title'] = "Password";
        $data["css"][] = "assets/css/preferences/password.css";
        $data["js"][] = "assets/js/preferences/password.js";


        $data['leftPanel'] = $this->load->view("leftPanel",$data,TRUE);
        $data["body"] = $this->load->view("preferences/password",$data,TRUE);

        $this->load->view("layout",$data);
    }

}