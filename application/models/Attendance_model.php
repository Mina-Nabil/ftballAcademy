<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }


        public function getAttendance_bySession($ID){

          $strSQL = "SELECT sessions.SESS_ID, students.STUD_ID, classes.CLSS_ID, ATTND, SESS_DESC, CLSS_NME, CLSS_YEAR, STUD_NAME, ATTND_TIME, ATTND_DUR
                    FROM attendance, students, classes, sessions
                    WHERE
                        attendance.CLSS_ID = classes.CLSS_ID
                    AND attendance.SESS_ID = sessions.SESS_ID
                    AND attendance.STUD_ID = students.STUD_ID
                    AND attendance.SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function takeattendance($StudentBarcode){
          $Date = new DateTime("now", new DateTimeZone('Africa/Cairo'));
          $Session = $this->getCurrentSession($StudentBarcode);
          if ($Session['res'] == 0) return array('result' => 0);
          else if($Session['res'] == 0) return 0;
          else {
            $Start = DateTime::createFromFormat('Y-m-d H:i:s', $Session['class']['SESS_STRT_DATE'], new DateTimeZone('Africa/Cairo'));
            $End = DateTime::createFromFormat('Y-m-d H:i:s', $Session['class']['SESS_END_DATE'], new DateTimeZone('Africa/Cairo'));

            $Dur1 = $Start->diff($End);

            $this->editAttendance($Session['class']['SESS_ID'], $Session['class']['STUD_ID'],1, $Date->format('Y-m-d H:i:s'), $Dur1->format('%H:%i:%s'));

            return array('result' => 1);
          }


        }

        private function getSessionDuration($SessID){
          $strSQL     = "SELECT sessions.SESS_ID, SESS_STRT_DATE, SESS_END_DATE
                        FROM sessions WHERE SESS_ID = ?";
          $query      = $this->db->query($strSQL, array($SessID));
          $Session    = $query->result_array()[0];
          $Start      = DateTime::createFromFormat('Y-m-d H:i:s', $Session['class']['SESS_STRT_DATE'], new DateTimeZone('Africa/Cairo'));
          $End        = DateTime::createFromFormat('Y-m-d H:i:s', $Session['class']['SESS_END_DATE'], new DateTimeZone('Africa/Cairo'));

          return $Start->diff($End)->format('%H:%i:%s');
        }

        private function getCurrentSession($StudentBarcode){
          //NOW(), INTERVAL 2 hour Cairo Timing
          $strSQL = "SELECT sessions.SESS_ID, SESS_STRT_DATE, SESS_END_DATE, students.STUD_ID
                     FROM sessions, classes, session_class, students, attendance
                     WHERE sessions.SESS_ID = SSCL_SESS_ID
                     AND SSCL_CLSS_ID = classes.CLSS_ID
                     AND STUD_CLSS_ID = classes.CLSS_ID
                     AND students.STUD_ID = attendance.STUD_ID
                     AND sessions.SESS_ID = attendance.SESS_ID
                     AND STUD_BARCODE = ?
                     AND DATE_ADD(NOW(), INTERVAL 2 hour) <  DATE_ADD(SESS_END_DATE, INTERVAL 10 hour)
                     AND DATE_ADD(NOW(), INTERVAL 2 hour) > DATE_SUB(SESS_STRT_DATE, INTERVAL 5 hour)
                     AND ATTND = 0";

          $inputs = array($StudentBarcode);
          $query = $this->db->query($strSQL, $inputs);
          $res = $query->result_array();
          if(count($res) > 1) return array('res' => 2); //More than one session
          else if(count($res) == 1)return array('res' => 1, 'class' => $res[0]); // no sessions
          else return array('res' => 0);

        }

        public function createAttendanceList($SessionID, $ClassID){
          $studentsIDs = $this->Classes_model->getStudentIDsforAttendance($ClassID);
          foreach($studentsIDs as $ID){
            $this->insertAttendance($SessionID, $ID['STUD_ID'], $ClassID, $this->getSessionDuration($SessionID));
          }
        }

        public function getAttendanceChart($StudentID, $Month, $Year){
          $return = array();
          $return['Duration_A'] = $this->getTotalAttendedHours($StudentID, $Month, $Year);
          $return['Duration_T'] = $this->getTotalAvailableHours($StudentID, $Month, $Year);
          $Week1_A = $this->getTotalAttendedHoursW1($StudentID, $Month, $Year);
          $Week1_T = $this->getTotalAvailableHoursW1($StudentID, $Month, $Year);
          $Week2_A = $this->getTotalAttendedHoursW2($StudentID, $Month, $Year);
          $Week2_T = $this->getTotalAvailableHoursW2($StudentID, $Month, $Year);
          $Week3_A = $this->getTotalAttendedHoursW3($StudentID, $Month, $Year);
          $Week3_T = $this->getTotalAvailableHoursW3($StudentID, $Month, $Year);
          $Week4_A = $this->getTotalAttendedHoursW4($StudentID, $Month, $Year);
          $Week4_T = $this->getTotalAvailableHoursW4($StudentID, $Month, $Year);

          $return['Attended'] = array ($Week1_A, $Week2_A, $Week3_A, $Week4_A);
          $return['Available'] = array ($Week1_T, $Week2_T, $Week3_T, $Week4_T);
          return $return;

        }

        private function getTotalAttendedHours($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-01");

          $NextMonth = $Month + 1;
          $EndDate = new DateTime("{$ThisYear}-{$NextMonth}-01");

          $strSQL = "SELECT TIME_FORMAT(SUM(ATTND_DUR), '%H:%i:%s') as totalDuration FROM attendance
                     WHERE STUD_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?
                     AND ATTND = 1";
          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAvailableHours($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-01");

          $NextMonth = $Month + 1;
          $EndDate = new DateTime("{$ThisYear}-{$NextMonth}-01");

          //Return number of minutes
          $strSQL = "SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE)))), '%H:%i:%s') as totalDuration
                     FROM sessions, classes, students, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND STUD_CLSS_ID = CLSS_ID
                     AND STUD_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";
          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAvailableHoursW1($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-01");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-07");

          $strSQL = "SELECT TRUNCATE(SUM(TIME_TO_SEC(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE))) / 3600, 1) as totalDuration
                     FROM sessions, classes, students, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND STUD_CLSS_ID = CLSS_ID
                     AND STUD_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";
          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAvailableHoursW2($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-08");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-14");

          $strSQL = "SELECT TRUNCATE(SUM(TIME_TO_SEC(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE))) / 3600, 1) as totalDuration
                     FROM sessions, classes, students, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND STUD_CLSS_ID = CLSS_ID
                     AND STUD_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";
          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAvailableHoursW3($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-15");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-21");

          $strSQL = "SELECT TRUNCATE(SUM(TIME_TO_SEC(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE))) / 3600, 1) as totalDuration
                     FROM sessions, classes, students, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND STUD_CLSS_ID = CLSS_ID
                     AND STUD_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";
          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAvailableHoursW4($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-22");

          $NextMonth = $Month+1;
          $EndDate = new DateTime("{$ThisYear}-{$NextMonth}-01");

          $strSQL = "SELECT TRUNCATE(SUM(TIME_TO_SEC(TIMEDIFF(SESS_END_DATE, SESS_STRT_DATE))) / 3600, 1) as totalDuration
                     FROM sessions, classes, students, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND CLSS_ID = SSCL_CLSS_ID
                     AND STUD_CLSS_ID = CLSS_ID
                     AND STUD_ID = ?
                     AND SESS_STRT_DATE < ?
                     AND SESS_STRT_DATE > ?";
          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAttendedHoursW1($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-01");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-07");

          $strSQL = "SELECT TRUNCATE(SUM(TIME_TO_SEC(ATTND_DUR)) / 3600, 1 ) as totalDuration  FROM attendance
                     WHERE STUD_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?
                     AND ATTND = 1";
          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAttendedHoursW2($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-08");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-14");

          $strSQL = "SELECT TRUNCATE(SUM(TIME_TO_SEC(ATTND_DUR)) / 3600, 1 ) as totalDuration  FROM attendance
                     WHERE STUD_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?
                     AND ATTND = 1";
          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAttendedHoursW3($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-15");

          $EndDate = new DateTime("{$ThisYear}-{$Month}-21");

          $strSQL = "SELECT TRUNCATE(SUM(TIME_TO_SEC(ATTND_DUR)) / 3600, 1 ) as totalDuration  FROM attendance
                     WHERE STUD_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?
                     AND ATTND = 1";
          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        private function getTotalAttendedHoursW4($StudentID, $Month, $Year){
          $ThisYear = $Year;
          $StartDate = new DateTime("{$ThisYear}-{$Month}-22");

          $NextMonth = $Month + 1;
          $EndDate = new DateTime("{$ThisYear}-{$NextMonth}-01");

          $strSQL = "SELECT TRUNCATE(SUM(TIME_TO_SEC(ATTND_DUR)) / 3600, 1 ) as totalDuration  FROM attendance
                     WHERE STUD_ID = ?
                     AND ATTND_TIME < ?
                     AND ATTND_TIME > ?
                     AND ATTND = 1";

          $query = $this->db->query($strSQL, array($StudentID, $EndDate->format('Y-m-d H:i:s'), $StartDate->format('Y-m-d H:i:s')));
          return $query->result_array()[0]['totalDuration'];
        }

        public function insertAttendance($SessionID, $StudentID, $ClassID, $Duration){
            //NN Text ArabicSDate SDate DistrictID
          $strSQL = "INSERT INTO attendance (SESS_ID, STUD_ID, CLSS_ID, ATTND_DUR)
                     VALUES (?, ?, ?, ?)";

          $inputs = array($SessionID, $StudentID, $ClassID, $Duration);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editAttendance($SessionID, $StudentID, $Attended, $Time, $Duration){
            //NN Text ArabicSDate SDate DistrictID
          $strSQL = "UPDATE attendance
                    SET ATTND        = ?,
                        ATTND_DUR    = ?,
                        ATTND_TIME   = ?
                    WHERE
                        SESS_ID    = ?
                    AND STUD_ID   =  ?";
          $inputs = array($Attended, $Duration, $Time, $SessionID, $StudentID);
          $query = $this->db->query($strSQL, $inputs);

        }
        public function editAttendance_CheckOnly($SessionID, $StudentID, $Attended){
            //NN Text ArabicSDate SDate DistrictID
          $strSQL = "UPDATE attendance
                    SET ATTND        = ?
                    WHERE
                        SESS_ID    = ?
                    AND STUD_ID   =  ?";
          $inputs = array($Attended, $SessionID, $StudentID);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function deleteAttendance($ID){
          $strSQL = "DELETE FROM attendance WHERE SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
