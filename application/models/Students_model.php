<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getStudents(){

          $strSQL = "SELECT STUD_ID, STUD_NAME, STUD_TEL, STUD_BD, STUD_PRNT_TEL, STUD_CLSS_ID, STUD_PRNT_TELL, STUD_CSID, STUD_ACTV, STUD_PAID,
                            STUD_PRNT_NAME, STUD_MNTR_NAME, STUD_PREV_CLUB, STUD_FAV_POS,STUD_WGHT, STUD_LGTH, POST_NAME, POST_ABB, STUD_BARCODE, STUD_SINCE, STUD_ACCS_CODE, CLSS_NME as STUD_CLSS_NME
                      FROM students,  positions, classes
                      WHERE   STUD_FAV_POS = POST_ID
                      AND     STUD_CLSS_ID = CLSS_ID";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getStudent_byID($ID){

          $strSQL = "SELECT STUD_ID, STUD_NAME, STUD_TEL, STUD_BD, STUD_PRNT_TEL, STUD_CLSS_ID, STUD_PRNT_TELL, STUD_ACTV, STUD_PAID,
                            STUD_PRNT_NAME, STUD_MNTR_NAME, STUD_PREV_CLUB, STUD_FAV_POS, STUD_WGHT, STUD_LGTH, STUD_CSID,
                            CLSS_NME as STUD_CLSS_NME, CLSS_YEAR, POST_NAME, STUD_ACCS_CODE, POST_ABB, STUD_BARCODE, STUD_SINCE
                      FROM students, classes, positions
                      WHERE STUD_CLSS_ID = CLSS_ID
                      AND   STUD_FAV_POS = POST_ID
                      AND   STUD_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0];

        }

        public function getStudent_byClass($ID){

          $strSQL = "SELECT STUD_ID, STUD_NAME, STUD_TEL, STUD_BD, STUD_PRNT_TEL, STUD_CLSS_ID, STUD_PRNT_TELL, STUD_ACTV, STUD_PAID,
                            STUD_PRNT_NAME, STUD_MNTR_NAME, STUD_PREV_CLUB, STUD_FAV_POS, STUD_WGHT, STUD_LGTH, STUD_CSID,
                            CLSS_NME as STUD_CLSS_NME, CLSS_YEAR, POST_NAME, STUD_ACCS_CODE, POST_ABB, STUD_BARCODE, STUD_SINCE
                      FROM students, classes, positions
                      WHERE STUD_CLSS_ID = CLSS_ID
                      AND   STUD_FAV_POS = POST_ID
                      AND   STUD_CLSS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }


        public function insertStudent($Name, $Tel, $BirthDate, $ParentTel, $ClassID, $ParentTel2, $ParentName, $MentorName, $PrevClub, $FavPos, $Weight, $Length, $AccessCode, $Barcode, $Since, $CSID){
            //NN Text ArabicName Name DistrictID
          $strSQL = "INSERT INTO students (STUD_NAME, STUD_TEL, STUD_BD, STUD_PRNT_TEL, STUD_CLSS_ID, STUD_PRNT_TELL, STUD_PRNT_NAME,
                                           STUD_MNTR_NAME, STUD_PREV_CLUB, STUD_FAV_POS, STUD_WGHT, STUD_LGTH, STUD_ACCS_CODE, STUD_BARCODE, STUD_SINCE, STUD_CSID)
                     VALUES               (?, ?, ?, ?, ?, ?, ?, ?, ? , ?, ?, ?, ?, ?, ?, ?)";

          $inputs = array($Name, $Tel, $BirthDate, $ParentTel, $ClassID, $ParentTel2, $ParentName, $MentorName, $PrevClub, $FavPos, $Weight, $Length, $AccessCode, $Barcode, $Since, $CSID);
          $query = $this->db->query($strSQL, $inputs);
          $strSQL = "SELECT STUD_ID, STUD_NAME, STUD_TEL, STUD_BD, STUD_PRNT_TEL, STUD_CLSS_ID, STUD_PRNT_TELL,
                            STUD_PRNT_NAME, STUD_MNTR_NAME, STUD_PREV_CLUB, STUD_FAV_POS, STUD_WGHT, STUD_LGTH,
                            CLSS_NME, CLSS_YEAR, POST_NAME, STUD_ACCS_CODE,  POST_ABB, STUD_BARCODE, STUD_SINCE
                      FROM students, classes, positions
                      WHERE STUD_CLSS_ID = CLSS_ID
                      AND   STUD_FAV_POS = POST_ID
                      AND   STUD_ID = LAST_INSERT_ID()";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0];
        }

        public function editStudent($ID, $Name, $Tel, $BirthDate, $ParentTel, $ClassID, $ParentTel2, $ParentName, $MentorName, $PrevClub, $FavPos, $AccessCode, $Barcode, $Weight, $Length, $CSID){
            //NN Text ArabicName Name DistrictID
          $strSQL = "UPDATE students
                    SET STUD_NAME   = ?,
                        STUD_TEL   = ?,
                        STUD_BD   = ?,
                        STUD_PRNT_TEL    = ?,
                        STUD_CLSS_ID   = ?,
                        STUD_PRNT_TELL   = ?,
                        STUD_PRNT_NAME   = ?,
                        STUD_MNTR_NAME   = ?,
                        STUD_PREV_CLUB   = ?,
                        STUD_FAV_POS   = ?,
                        STUD_ACCS_CODE     =  ?,
                        STUD_BARCODE     =  ?,
                        STUD_WGHT     = ?,
                        STUD_LGTH     =  ?,
                        STUD_CSID     =  ?
                    WHERE
                        `STUD_ID`= ?";

          $inputs = array($Name, $Tel, $BirthDate, $ParentTel, $ClassID, $ParentTel2, $ParentName, $MentorName, $PrevClub, $FavPos, $AccessCode, $Barcode, $Weight, $Length, $CSID, $ID);
          $query = $this->db->query($strSQL, $inputs);
          $strSQL = "SELECT STUD_ID, STUD_NAME, STUD_TEL, STUD_BD, STUD_PRNT_TEL, STUD_CLSS_ID, STUD_PRNT_TELL,
                            STUD_PRNT_NAME, STUD_MNTR_NAME, STUD_PREV_CLUB, STUD_FAV_POS, STUD_WGHT, STUD_LGTH,
                            CLSS_NME as STUD_CLSS_NME, CLSS_YEAR, POST_NAME, STUD_ACCS_CODE,  POST_ABB, STUD_BARCODE, STUD_SINCE
                      FROM students, classes, positions
                      WHERE STUD_CLSS_ID = CLSS_ID
                      AND   STUD_FAV_POS = POST_ID
                      AND   STUD_ID = ?";
          $inputs = array ($ID);
          $query = $this->db->query($strSQL, $inputs);
          return $query->result_array()[0];
        }

        public function getUnsubscribers(){
          $strSQL   =  "SELECT period_diff(date_format(now(), '%Y%m'), date_format(STUD_SINCE, '%Y%m')) as Months , STUD_NAME, STUD_CSID, STUD_ID 
                        FROM students
                        WHERE period_diff(date_format(now(), '%Y%m'), date_format(STUD_SINCE, '%Y%m')) > STUD_PAID
                        AND STUD_ACTV = 1";
          $query = $this->db->query($strSQL);
          return $query->result_array();
        }

        public function deactivateStudent($StudentID){
          $strSQL = "UPDATE students SET STUD_ACTV = 0 WHERE STUD_ID = ?";
          $query = $this->db->query($strSQL, array($StudentID));
          return $this->getStudent_byID($StudentID);
        }

        public function activateStudent($StudentID){
          $strSQL = "UPDATE students SET STUD_ACTV = 1 WHERE STUD_ID = ?";
          $query = $this->db->query($strSQL, array($StudentID));
          return $this->getStudent_byID($StudentID);
        }

        public function paySubsctiption($StudentID){
          $strSQL = "UPDATE students SET STUD_PAID = STUD_PAID + 1 WHERE STUD_ID = ?";
          $query = $this->db->query($strSQL, array($StudentID));
          return $this->getUnsubscribers();

        }

        public function deleteStudents($ID){
          $strSQL = "DELETE FROM students WHERE STUD_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
