<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2/21/2015
 * Time: 12:55 AM
 */

class Users extends MY_RestController {

    public function __construct() {
        parent::__construct();
    }

    public function register_post() {
        $fname = $this->post("fname",TRUE);
        $lname = $this->post('lname',TRUE);
        $email = $this->post('email',TRUE);
        $pass = $this->post('password',TRUE);
        $passconf = $this->post('passwordconf',TRUE);


        if ( trim($fname) === "" ) {
            $this->response(array("message" => "The first name field is required.", "type" => "danger"),UNAUTHORIZED);
        }
        if ( trim($lname) === "" ) {
            $this->response(array("message" => "The last name field is required.", "type" => "danger"),UNAUTHORIZED);
        }
        if ( trim($email) === "" ) {
            $this->response(array("message" => "The email field is required.", "type" => "danger"),UNAUTHORIZED);
        }
        if ( trim($pass) === "" ) {
            $this->response(array("message" => "The password field is required.", "type" => "danger"),UNAUTHORIZED);
        }


        if ( !valid_email($email) ) {
            $this->response(array("message" => "The email field is invalid.", "type" => "danger"),UNAUTHORIZED);
        }

        if ( (string)$pass !== (string)$passconf ) {
            $this->response(array("message" => "The password and password confirmation field do not match.", "type" => "danger"),UNAUTHORIZED);
        }

        $user = $this->Api_model->checkDupEmail($email);
        if ( count($user) > 0 ) {
            $this->response(array("message" => "The email is already existed.", "type" => "danger"),CONFLICT);
        }

        $user_id = $this->Api_model->createUser($fname,$lname,$email,$pass);

        if( $user_id ) {
            $this->session->set_userdata(array(
                "fname" => $fname,
                "lname" => $lname,
                "email" => $email,
                "id"    => $user_id,
                "isLogin" => 1
            ));
            $this->response(array("redirect" => site_url('dashboard')),SUCCESS);
        } else {
            $this->response(array("message" => "Internal Server Error. Please try again later.", "type" => "danger"),INTERNAL_SERVER_ERROR);
        }
    }

    public function forgot_put() {
        $email = $this->put("email");

        if ( trim($email) === "" ) {
            $this->response(array("message" => "The email field is required.", "type" => "danger"),UNAUTHORIZED);
        }

        if ( !valid_email($email) ) {
            $this->response(array("message" => "The email field is invalid.", "type" => "danger"),UNAUTHORIZED);
        }

        $user = $this->Api_model->checkDupEmail($email);

        if ( count($user) < 1 ) {
            $this->response(array("message" => "The email does not exist.", "type" => "danger"),UNAUTHORIZED);
        }

        $generatePassword = function ($length = 8)
        {
            // given a string length, returns a random password of that length
            $password = "";
            // define possible characters
            $possible = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $i = 0;
            // add random characters to $password until $length is reached
            while ($i < $length) {
                // pick a random character from the possible ones
                $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
                // we don't want this character if it's already in the password
                if (!strstr($password, $char)) {
                    $password .= $char;
                    $i++;
                }
            }
            return $password;
        };

        $toUpdate = array("password" => md5($generatePassword().HASHKEY));

        $this->db->where("id",$user['id']);
        $this->db->update("users",$toUpdate);

        $this->response(array("redirect" => site_url('login')),SUCCESS);
    }

    public function password_put() {
        $current_password = $this->put("current_password",TRUE);
        $new_password = $this->put("new_password",TRUE);
        $new_password_confirm = $this->put("new_password_confirm",TRUE);


        if ( trim($current_password) === "" ) {
            $this->response(array("message" => "The current password field is required.", "type" => "danger"),UNAUTHORIZED);
        }

        if ( trim($new_password) === "" ) {
            $this->response(array("message" => "The new password field is required.", "type" => "danger"),UNAUTHORIZED);
        }

        if ( trim($new_password_confirm) === "" ) {
            $this->response(array("message" => "The new password confirm field is required.", "type" => "danger"),UNAUTHORIZED);
        }

        if ( (string)$new_password !== (string)$new_password_confirm ) {
            $this->response(array("message" => "The new password and new password confirm field do not match.", "type" => "danger"),UNAUTHORIZED);
        }

        $user = $this->Api_model->getUser($this->session->userdata('id'));

        if ( (string)md5($current_password.HASHKEY) !== (string)$user['password'] )  {
            $this->response(array("message" => "The current password does not match in system.", "type" => "danger"),UNAUTHORIZED);
        }

        $toUpdate = array("password" => md5($new_password.HASHKEY));
        if ($this->db->where("id",$this->session->userdata('id'))->update("users",$toUpdate)) {
            $this->response(array("message" => "Changed password successful.","type" => "success"),SUCCESS);
        } else {
            $this->response(array("message" => "Internal Server Error", "type" => "success"),INTERNAL_SERVER_ERROR);
        }



    }

    public function login_post() {
        $email = $this->post("email",TRUE);
        $password = $this->post("password",TRUE);

        if ( !valid_email($email) ) {
            $this->response(array("message" => "The email field is invalid.", "type" => "danger"),UNAUTHORIZED);
        }

        if ( trim($password) === "" ) {
            $this->response(array("message" => "The password field is invalid.", "type" => "danger"),UNAUTHORIZED);
        }

        $user = $this->Api_model->validate($email,$password);

        if ( count($user) < 1 ) {
            $this->response(array("message" => "Incorrect email or password.", "type" => "danger"/*,"password" => md5("helloworld".HASHKEY)*/),UNAUTHORIZED);
        }


        $this->session->set_userdata($user);

        $this->response(array("redirect" => site_url('dashboard')),SUCCESS);
    }

    public function logout_post() {
        $this->session->unset_userdata("isLogin");

        $this->response(array("redirect" => site_url('login')),SUCCESS);
    }

    public function info_get() {
        $id = $this->get("id",TRUE);

        if ( !intval($id) ) {
            $this->response(array("message" => "Internal server error.","type" => "danger"),INTERNAL_SERVER_ERROR);
        }

        $user = $this->Api_model->getUser($id);

        $this->response(array("fname" => $user['fname'],"lname" => $user['lname']),SUCCESS);
    }

    public function info_put() {
        $fname = $this->put("fname",TRUE);
        $lname = $this->put("lname",TRUE);
        $id = $this->put("id",TRUE);

        if ( trim($fname) === "" ) {
            $this->response(array("message" => "The first name field is required.","type" => "danger"),UNAUTHORIZED);
        }

        if ( trim($lname) === "" ) {
            $this->response(array("message" => "The last name field is required.","type" => "danger"),UNAUTHORIZED);
        }

        if ( !intval($id) ) {
            $this->response(array("message" => "Internal server error.","type" => "danger"),INTERNAL_SERVER_ERROR);
        }

        if ( $this->db->where("id",$id)->update("users",array("fname" => $fname,"lname" => $lname)) ) {
            $this->response(array("message" => "Updated contact information successful","type" => "success"),SUCCESS);
            $this->session->set_userdata('fname',$fname);
            $this->session->set_userdata('lname',$lname);
        } else {
            $this->response(array("message" => "Internal server error.","type" => "danger"),INTERNAL_SERVER_ERROR);
        }


    }

}