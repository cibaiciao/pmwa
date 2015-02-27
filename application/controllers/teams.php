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
        $this->load->vars(array("nav" => array("","","","","","active")));
    }

    public function index() {

    }

}