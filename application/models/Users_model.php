<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getUsers(){

          $strSQL = "SELECT USER_ID, USER_UNAME, USER_PASS, USER_FNAME, USER_TEL
                      FROM users";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function login($Name, $Pass){
          $strSQL = "SELECT USER_ID FROM users
                     WHERE USER_UNAME = ?
                     AND   USER_PASS  = ?";
          $query = $this->db->query($strSQL, array($Name, $Pass));
          $res = $query->result_array();
          if(sizeof($res) == 0 || (sizeof($res) > 1)) return false;
          else return $res[0]['USER_ID'];
        }

        public function getUser_byID($ID){

          $strSQL = "SELECT USER_ID, USER_UNAME, USER_PASS, USER_FNAME, USER_TEL
                    FROM users WHERE USER_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }


        public function insertUsers($UName, $Pass, $FName, $Tel){
            //NN Text ArabicUName UName DistrictID
          $strSQL = "INSERT INTO users (USER_UNAME, USER_PASS, USER_FNAME, USER_TEL)
                     VALUES (?, ?, ?, ?)";

          $inputs = array($UName, $Pass, $FName, $Tel);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editUsers($ID, $UName, $Pass, $FName, $Tel){
            //NN Text ArabicUName UName DistrictID
          $strSQL = "UPDATE users
                    SET USER_UNAME   = ?,
                        USER_PASS    = ?,
                        USER_FNAME   = ?,
                        USER_TEL     = ?
                    WHERE
                        `USER_ID`= ?";
          $inputs = array($UName, $Pass, $FName, $Tel);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function deleteUsers($ID){
          $strSQL = "DELETE FROM users WHERE USER_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
