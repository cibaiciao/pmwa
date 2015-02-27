<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2/21/2015
 * Time: 1:35 AM
 */

class Users extends MY_BasicController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect(site_url("users/login"));
    }

    public function register() {
        $data['title'] = "Register";
        $data["css"][] = "assets/css/users/register.css";
        $data["js"][] = "assets/js/users/register.js";
        $data["body"] = $this->load->view("users/register",$data,TRUE);

        $this->load->view("layout",$data);
    }

    public function login() {

        $data['title'] = "Login";
        $data["css"][] = "assets/css/users/login.css";
        $data["js"][] = "assets/js/users/login.js";
        $data["body"] = $this->load->view("users/login",$data,TRUE);

        $this->load->view("layout",$data);
    }

    public function forgot() {

        $data['title'] = "Forgot password";
        $data["css"][] = "assets/css/users/forgot.css";
        $data["js"][] = "assets/js/users/forgot.js";
        $data["body"] = $this->load->view("users/forgot",$data,TRUE);

        $this->load->view("layout",$data);
    }

}