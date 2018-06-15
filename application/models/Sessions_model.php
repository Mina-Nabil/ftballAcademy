<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getSessions(){

          $strSQL = "SELECT SESS_ID, SESS_STRT_DATE, SESS_DESC, SESS_END_DATE, SESS_USER_ID, USER_UNAME
                      FROM Sessions, Users
                      WHERE SESS_USER_ID = USER_ID";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getSession_byID($ID){

          $strSQL = "SELECT SESS_ID, SESS_STRT_DATE, SESS_DESC, SESS_END_DATE, SESS_USER_ID
                     FROM Sessions, Users
                     WHERE SESS_USER_ID = USER_ID AND SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }


        public function insertSessions($SDate, $Desc, $EDate, $User){
            //NN Text ArabicSDate SDate DistrictID
          $strSQL = "INSERT INTO Sessions (SESS_STRT_DATE, SESS_DESC, SESS_END_DATE, SESS_USER_ID)
                     VALUES (?, ?, ?, ?)";

          $inputs = array($SDate, $Desc, $EDate, $User);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editSessions($ID, $SDate, $Desc, $EDate, $User){
            //NN Text ArabicSDate SDate DistrictID
          $strSQL = "UPDATE Sessions
                    SET SESS_STRT_DATE   = ?,
                        SESS_DESC    = ?,
                        SESS_END_DATE   = ?,
                        SESS_USER_ID     = ?
                    WHERE
                        `SESS_ID`= ?";
          $inputs = array($SDate, $Desc, $EDate, $User);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function deleteSessions($ID){
          $strSQL = "DELETE FROM Sessions WHERE SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
