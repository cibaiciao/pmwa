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

}