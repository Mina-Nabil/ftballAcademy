<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getClasses(){

          $strSQL = "SELECT CLSS_ID, CLSS_NME, CLSS_DESC, CLSS_YEAR
                      FROM classes";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getClass_byID($ID){

          $strSQL = "SELECT CLSS_ID, CLSS_NME, CLSS_DESC, CLSS_YEAR
                    FROM classes WHERE CLSS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getStudentIDs($ClassIDs){
          $strSQL = "SELECT STUD_ID FROM students WHERE STUD_CLSS_ID = ?";
          $query = $this->db->query($strSQL, array($ClassIDs));
          return $query->result_array();
        }


        public function getAttendanceChart($ClassID, $Month, $Year){
          $return = array();
          $return['Duration_A'] = $this->getTotalAttendedHours($ClassID, $Month, $Year);
          $return['Duration_T'] = $this->getTotalAvailableHours($ClassID, $Month, $Year);
          $Week1_A = $this->getTotalAttendedHoursW1($ClassID, $Month, $Year);
          $Week1_T = $this->getTotalAvailableHoursW1($ClassID, $Month, $Year);
          $Week2_A = $this->getTotalAttendedHoursW2($ClassID, $Month, $Year);
          $Week2_T = $this->getTotalAvailableHoursW2($ClassID, $Month, $Year);
          $Week3_A = $this->getTotalAttendedHoursW3($ClassID, $Month, $Year);
          $Week3_T = $this->getTotalAvailableHoursW3($ClassID, $Month, $Year);
          $Week4_A = $this->getTotalAttendedHoursW4($ClassID, $Month, $Year);
          $Week4_T = $this->getTotalAvailableHoursW4($ClassID, $Month, $Year);

          $return['Attended'] = array ($Week1_A, $Week2_A, $Week3_A, $Week4_A);
          $return['Available'] = array ($Week1_T, $Week2_T, $Week3_T, $Week4_T);
          return $return;

        }

        private function getTotalAttendedHours($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-01");

          $NextMonth = $Month + 1;
          $EndDate = new DateTime("{$ThisYear}-{$NextMonth}-01");

          $strSQL = "SELECT TIME_FORMAT(AVG(ATTND_DUR), '%H:%i:%s') as totalDuration FROM attendance
                     WHERE CLSS_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?";
          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          $res = $query->result_array()[0]['totalDuration'];
          if(is_null($res)) $res = '00:00:00';
          return $res;
        }

        private function getTotalAvailableHours($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-01");

          $NextMonth = $Month + 1;
          $EndDate = new DateTime("{$ThisYear}-{$NextMonth}-01");

          //Return number of minutes
          $strSQL = "SELECT CLSS_ID,TIME_FORMAT(SUM(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE)), '%H:%i:%s') as totalDuration
                     FROM sessions, classes, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND CLSS_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";

          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          $res = $query->result_array()[0]['totalDuration'];
          if(is_null($res)) $res = '00:00:00';
          return $res;
        }

        private function getTotalAvailableHoursW1($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-01");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-07");

          $strSQL = "SELECT CLSS_ID,TIME_TO_SEC(TIME_FORMAT(SUM(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE)), '%H:%i:%s')) / 60 as totalDuration
                     FROM sessions, classes, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND CLSS_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";

          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAvailableHoursW2($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-08");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-14");

          $strSQL = "SELECT CLSS_ID,TIME_TO_SEC(TIME_FORMAT(SUM(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE)), '%H:%i:%s')) / 60 as totalDuration
                     FROM sessions, classes, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND CLSS_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";

          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAvailableHoursW3($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-15");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-21");

          $strSQL = "SELECT CLSS_ID,TIME_TO_SEC(TIME_FORMAT(SUM(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE)), '%H:%i:%s')) / 60 as totalDuration
                     FROM sessions, classes, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND CLSS_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";

          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAvailableHoursW4($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-22");

          $NextMonth = $Month+1;
          $EndDate = new DateTime("{$ThisYear}-{$NextMonth}-01");

          $strSQL = "SELECT CLSS_ID, TIME_TO_SEC(TIME_FORMAT(SUM(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE)), '%H:%i:%s')) / 60 as totalDuration
                     FROM sessions, classes, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND CLSS_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";

          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAttendedHoursW1($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-01");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-07");

          $strSQL = "SELECT TIME_TO_SEC(TIME_FORMAT(AVG(ATTND_DUR), '%H:%i:%s')) / 60 as totalDuration FROM attendance
                     WHERE CLSS_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?";
          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAttendedHoursW2($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-08");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-14");

          $strSQL = "SELECT TIME_TO_SEC(TIME_FORMAT(AVG(ATTND_DUR), '%H:%i:%s')) / 60 as totalDuration FROM attendance
                     WHERE STUD_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?";
          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAttendedHoursW3($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-15");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-21");

          $strSQL = "SELECT TIME_TO_SEC(TIME_FORMAT(AVG(ATTND_DUR), '%H:%i:%s')) / 60 as totalDuration FROM attendance
                     WHERE CLSS_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?";
          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAttendedHoursW4($ClassID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-22");

          $NextMonth = $Month + 1;
          $EndDate = new DateTime("{$ThisYear}-{$NextMonth}-01");

          $strSQL = "SELECT TIME_TO_SEC(TIME_FORMAT(AVG(ATTND_DUR), '%H:%i:%s')) / 60 as totalDuration FROM attendance
                     WHERE CLSS_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?";

          $query = $this->db->query($strSQL, array($ClassID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }


        public function insertClass($Name, $Desc, $Year){
            //NN Text ArabicName Name DistrictID
          $strSQL = "INSERT INTO classes (CLSS_NME, CLSS_DESC, CLSS_YEAR)
                     VALUES (?, ?, ?)";

          $inputs = array($Name, $Desc, $Year);
          $query = $this->db->query($strSQL, $inputs);
          $strSQL = "SELECT CLSS_ID, CLSS_NME, CLSS_DESC, CLSS_YEAR
                    FROM classes WHERE CLSS_ID = LAST_INSERT_ID() ";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0];
        }

        public function editClass($ID, $Name, $Desc, $Year){
            //NN Text ArabicName Name DistrictID
          $strSQL = "UPDATE classes
                    SET CLSS_NME    = ?,
                        CLSS_DESC    = ?,
                        CLSS_YEAR    = ?
                    WHERE
                        `CLSS_ID`    = ?";
          $inputs = array($Name, $Desc, $Year, $ID);
          $query = $this->db->query($strSQL, $inputs);
          $strSQL = "SELECT CLSS_ID, CLSS_NME, CLSS_DESC, CLSS_YEAR
                    FROM classes WHERE CLSS_ID = {$ID} ";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0];

        }

        public function deleteClasses($ID){
          $strSQL = "DELETE FROM Classes WHERE CLSS_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
