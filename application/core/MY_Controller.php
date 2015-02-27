<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2/20/2015
 * Time: 11:03 PM
 */
require(APPPATH.'/libraries/REST_Controller.php');
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if ( !$this->session->userdata('isLogin') ) {
            redirect(site_url('login'));
        }

    }

    public function logout() {
        $this->session->unset_userdata("isLogin");
        redirect(site_url('login'));
    }

}

class MY_BasicController extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if ( $this->session->userdata('isLogin') ) {
            redirect(site_url("dashboard"));
        }
    }

}

class MY_RestController extends REST_Controller {

    public function __construct() {
        parent::__construct();

        if ( ( $key = $this->get('api_key',TRUE) ) ) {

        }

        elseif ( ( $key = $this->post('api_key',TRUE) ) ) {

        }

        elseif ( ( $key = $this->put('api_key',TRUE) ) ) {

        }

        elseif ( ( $key = $this->delete('api_key',TRUE) ) ) {

        }

        if ( $key != APIKEY ) {
            $this->response(array("message" => "Invalid key","type" => "danger"),UNAUTHORIZED);
        }


        $this->load->model("Api_model");
    }
}