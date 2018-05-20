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
                      FROM Users";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getUser_byID($ID){

          $strSQL = "SELECT USER_ID, USER_UNAME, USER_PASS, USER_FNAME, USER_TEL
                    FROM Users WHERE USER_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }


        public function insertUsers($UName, $Pass, $FName, $Tel){
            //NN Text ArabicUName UName DistrictID
          $strSQL = "INSERT INTO Users (USER_UNAME, USER_PASS, USER_FNAME, USER_TEL)
                     VALUES (?, ?, ?, ?)";

          $inputs = array($UName, $Pass, $FName, $Tel);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editUsers($ID, $UName, $Pass, $FName, $Tel){
            //NN Text ArabicUName UName DistrictID
          $strSQL = "UPDATE Users
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
          $strSQL = "DELETE FROM Users WHERE USER_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
