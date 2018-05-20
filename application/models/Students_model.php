<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getStudents(){

          $strSQL = "SELECT STUD_ID, STUD_NAME, STUD_TEL, STUD_BD, STUD_PRNT_TEL, STUD_CLSS_ID, STUD_PRNT_TELL, STUD_PRNT_NAME, STUD_MNTR_NAME, STUD_PREV_CLUB, STUD_FAV_POS,
                            CLSS_NAME, CLSS_YEAR, POST_NAME
                      FROM Students, classes, Positions
                      WHERE STUD_CLSS_ID = CLSS_ID
                      AND   STUD_FAV_POS = POST_ID ";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getStudent_byID($ID){

          $strSQL = "SELECT STUD_ID, STUD_NAME, STUD_TEL, STUD_BD, STUD_PRNT_TEL, STUD_CLASS_ID, STUD_PRNT_TELL, STUD_PRNT_NAME, STUD_MNTR_NAME, STUD_PREV_CLUB, STUD_FAV_POS,
                            CLSS_NAME, CLSS_YEAR, POST_NAME
                      FROM Students, classes, Positions
                      WHERE STUD_CLSS_ID = CLSS_ID
                      AND   STUD_FAV_POS = POST_ID  STUD_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }


        public function insertStudents($Name, $Tel, $BirthDate, $ParentTel){
            //NN Text ArabicName Name DistrictID
          $strSQL = "INSERT INTO Students (STUD_NAME, STUD_TEL, STUD_BD, STUD_PRNT_TEL, STUD_CLASS_ID, STUD_PRNT_TELL, STUD_PRNT_NAME, STUD_MNTR_NAME, STUD_PREV_CLUB, STUD_FAV_POS)
                     VALUES               (?        , ?       , ?      , ?            , ?            , ?             , ?             , ?             , ?             , ?           )";

          $inputs = array($Name, $Tel, $BirthDate, $ParentTel, $ClassID, $ParentTel2, $ParentName, $MentorName, $PrevClub, $FavPos);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editStudents($ID, $Name, $Tel, $BirthDate, $ParentTel, $ClassID, $ParentTel2, $ParentName, $MentorName, $PrevClub, $FavPos){
            //NN Text ArabicName Name DistrictID
          $strSQL = "UPDATE Students
                    SET STUD_NAME   = ?,
                        STUD_TEL   = ?,
                        STUD_BD   = ?,
                        STUD_PRNT_TEL    = ?,
                        STUD_CLASS_ID   = ?,
                        STUD_PRNT_TELL   = ?,
                        STUD_PRNT_NAME   = ?,
                        STUD_MNTR_NAME   = ?,
                        STUD_PREV_CLUB   = ?,
                        STUD_FAV_POS   = ?
                    WHERE
                        `STUD_ID`= ?";
          $inputs = array($Name, $Tel, $BirthDate, $ParentTel, $ClassID, $ParentTel2, $ParentName, $MentorName, $PrevClub, $FavPos, $ID);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function deleteStudents($ID){
          $strSQL = "DELETE FROM Students WHERE STUD_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
