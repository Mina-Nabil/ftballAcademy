<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SessionClass_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getSessionClass(){

          $strSQL = "SELECT SSCL_SESS_ID, SSCL_CLSS_ID, SSCL_CLSS_COUNT, CLSS_NAME, SESS_NAME, SESS_YEAR
                      FROM session_class, classes, sessions
                      WHERE
                           SSCL_SESS_ID = SESS_ID
                      AND  SSCL_CLSS_ID = CLSS_ID";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getSessionsByClass($ID){

          $strSQL = "SELECT SSCL_SESS_ID, SSCL_CLSS_ID, SSCL_CLSS_COUNT, CLSS_NAME, SESS_NAME, SESS_YEAR
                      FROM session_class, classes, sessions
                      WHERE
                           SSCL_SESS_ID = SESS_ID
                      AND  SSCL_CLSS_ID = CLSS_ID
                      AND  SSCL_CLSS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getClassesBySession($ID){

          $strSQL = "SELECT SSCL_SESS_ID, SSCL_CLSS_ID, SSCL_CLSS_COUNT, CLSS_NAME, SESS_NAME, SESS_YEAR
                      FROM session_class, classes, sessions
                      WHERE
                           SSCL_SESS_ID = SESS_ID
                      AND  SSCL_CLSS_ID = CLSS_ID
                      AND  SSCL_SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }


        public function insertSessionClass($SessionID, $ClassID){
            //NN Text ArabicName Name DistrictID
          $strSQL = "INSERT INTO SessionClass (SSCL_SESS_ID, SSCL_CLSS_ID, (SELECT COUNT(*) FROM students WHERE STUD_CLASS_ID = ?)))
                     VALUES (?, ?)";

          $inputs = array($ClassID, $SessionID, $ClassID);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editSessionClass($ID, $SessionID, $ClassID){
            //NN Text ArabicName Name DistrictID
          $strSQL = "UPDATE SessionClass
                    SET SSCL_SESS_ID   = ?,
                        SSCL_CLSS_ID    = ?
                    WHERE
                        `CLSS_ID`= ?";
          $inputs = array($SessionID, $ClassID, $ID);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function deleteSessionClass($SessID, $ClassID){
          $strSQL = "DELETE FROM SessionClass WHERE SSCL_SESS_ID = {$SessID} AND SSCL_CLSS_ID = {$ClassID}";
          $query = $this->db->query($strSQL);
        }

}
