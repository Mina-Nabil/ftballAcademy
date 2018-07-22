<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }


        public function getAttendance_bySession($ID){

          $strSQL = "SELECT SESS_ID, STUD_ID, CLSS_ID, ATTND, SESS_NAME, CLSS_NAME, CLSS_YEAR, STUD_NAME, ATTND_TIME, ATTND_DUR
                    FROM Attendance, students, classes, sessions
                    WHERE
                        Attendance.CLSS_ID = classes.CLSS_ID
                    AND Attendance.SESS_ID = sessions.SESS_ID
                    AND Attendance.STUD_ID = students.STUD_ID
                    AND Attendance.SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function takeattendance($StudentBarcode){
          $Date = date("Y-m-d H:i:s");
          $Session = $this->getCurrentSession($StudentBarcode, $Date);
          if (strcmp($Session['class'], 'Unavailable') == 0) return 'Unavailable';
          else if($Session['class'] == 0) return 0;
          else {
            $Start = strtotime($Session['class']['SESS_STRT_DATE']);
            $End = strtotime($Session['class']['SESS_END_DATE']);
            $Dur = strtotime(($End - $Start) / 3600);
            if($Date <= $Start) {
              $this->editAttendance($Session['class']['SESS_ID'], $Session['class']['STUD_ID'],1, $Date, $Dur);
            }else {
              $this->editAttendance($Session['class']['SESS_ID'], $Session['class']['STUD_ID'],1, $Date, strtotime($End - $Date));
            }
          }


        }

        private function getCurrentSession($StudentBarcode, $Date){

          $strSQL = "SELECT SESS_ID, SESS_STRT_DATE, SESS_END_DATE, STUD_ID
                     FROM sessions, classes, session_class
                     WHERE SESS_ID = SSCL_SESS_ID
                     AND SSCL_CLSS_ID = CLSS_ID
                     AND STUD_CLSS_ID = CLSS_ID
                     AND STUD_BARCODE = ?
                     AND SESS_END_DATE > ?
                     AND SESS_STRT_DATE < DATE_ADD(?, 1 hour)";

          $inputs = array($StudentBarcode, $Date, $Date);
          $query = $this->db->query($strSQL, $inputs);
          $res = $query->result_array();
          if(count($res) > 1) return array('class' => 'Unavailable');
          else if(count($res) == 1)return array('class' => $res[0]);
          else return array('class' => 0);

        }

        public function createAttendanceList($SessionID, $ClassID){
          $studentsIDs = $this->Classes_model->getStudentIDs($ClassID);
          foreach($studentsIDs as $ID){
            $this->insertAttendance($SessionID, $ID['STUD_ID'], $ClassID);
          }
        }

        public function insertAttendance($SessionID, $StudentID, $ClassID){
            //NN Text ArabicSDate SDate DistrictID
          $strSQL = "INSERT INTO Attendance (SESS_ID, STUD_ID, CLSS_ID)
                     VALUES (?, ?, ?)";

          $inputs = array($SessionID, $StudentID, $ClassID);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editAttendance($SessionID, $StudentID, $Attended, $Time, $Duration){
            //NN Text ArabicSDate SDate DistrictID
          $strSQL = "UPDATE Attendance
                    SET ATTND        = ?,
                        ATTND_DUR    = ?,
                        ATTND_TIME   = ?
                    WHERE
                        SESS_ID    = ?
                    AND STUD_ID   =  ?";
          $inputs = array($Attended, $Duration, $Time, $SessionID, $StudentID);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function deleteAttendance($ID){
          $strSQL = "DELETE FROM Attendance WHERE SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
