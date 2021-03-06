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
                      FROM sessions, Users
                      WHERE SESS_USER_ID = USER_ID";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getSession_byID($ID){

          $strSQL = "SELECT SESS_ID, SESS_STRT_DATE, SESS_DESC, SESS_END_DATE, SESS_USER_ID
                     FROM sessions, Users
                     WHERE SESS_USER_ID = USER_ID AND SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0];

        }

        public function getSessions_limit($months){
          $strSQL = "SELECT SESS_ID, MOD(SESS_ID, 7) as color, SESS_STRT_DATE as start , CONCAT(SESS_DESC, '  Teams: ', GROUP_CONCAT(CLSS_NME SEPARATOR ', '), ' Time: ', DATE_FORMAT(SESS_STRT_DATE, '%d-%M-%Y %H:%i'), ' - ', DATE_FORMAT(SESS_END_DATE, '%H:%i')) as title, SESS_END_DATE as 'end'
                      FROM sessions, Classes, session_class
                      WHERE
                           SSCL_SESS_ID = SESS_ID
                      AND  SSCL_CLSS_ID = CLSS_ID
                      AND SESS_END_DATE < DATE_ADD(NOW(), INTERVAL ? MONTH )
                      AND SESS_END_DATE > DATE_ADD(NOW(), INTERVAL -? MONTH )
                      GROUP BY SESS_ID";
          $query = $this->db->query($strSQL, array($months, $months));
          return $query->result_array();
        }

        public function getSessionsForAttendance($classID){

          $threeMonthAgo = new DateTime("now");
          $threeMonthAgo->sub(date_interval_create_from_date_string("3 months"));

          $strSQL = "SELECT SESS_ID, DATE_FORMAT(SESS_STRT_DATE, '%d-%M-%Y') as Name

                      FROM session_class, classes, sessions, users
                      WHERE
                           SSCL_SESS_ID = SESS_ID
                      AND  SESS_USER_ID = USER_ID
                      AND  SSCL_CLSS_ID = CLSS_ID
                      AND  SSCL_CLSS_ID = ?
                      AND  sessions.SESS_STRT_DATE BETWEEN ? AND NOW()
                      ORDER BY sessions.SESS_ID DESC";
          $query = $this->db->query($strSQL, array($classID, $threeMonthAgo->format('Y-m-d')) );
          return $query->result_array();

        }

        public function getClassAttendance($classID){

          $threeMonthAgo = new DateTime("now");
          $threeMonthAgo->sub(date_interval_create_from_date_string("3 months"));

          $sessions = $this->getSessionsForAttendance($classID);

          $strSQL = "SELECT students.STUD_ID, STUD_NAME, ATTND, sessions.SESS_ID, DATE_FORMAT(SESS_STRT_DATE, '%d-%M-%Y') as Name FROM sessions, attendance, students
                      WHERE sessions.SESS_ID = attendance.SESS_ID
                      AND   students.STUD_ID = attendance.STUD_ID
                      AND   attendance.CLSS_ID = ?
                      AND   sessions.SESS_STRT_DATE BETWEEN ? AND NOW()
                      ORDER BY students.STUD_NAME ASC, sessions.SESS_ID DESC";
          $query = $this->db->query($strSQL, array($classID, $threeMonthAgo->format('Y-m-d')));
          $res = $query->result_array();



          $ret = [];
          foreach($res as $row){
            if(!array_key_exists($row['STUD_ID'], $ret)) {
              $ret[$row['STUD_ID']] = ['StudentName' => $row['STUD_NAME']];

              foreach($sessions as $sess) $ret[$row['STUD_ID']] += [$sess['Name'] => 'No'];

              $ret[$row['STUD_ID']][$row['Name']] = ($row['ATTND'])? 'Yes' : 'No';
            }

            else
              $ret[$row['STUD_ID']][$row['Name']] = ($row['ATTND'])? 'Yes' : 'No';
            //$ret[$row['STUD_ID']] += [ $row['SESS_ID'] => ($row['ATTND']) ? 'Yes' : 'No'];
              //array_push($ret[$row['STUD_ID']], ['Att' . $row['SESS_ID'] => ($row['ATTND'])? 'Yes' : 'No']);
          }

          $ret2 = [];
          foreach($ret as $student){
            $row2 = [];
            $i=1;
            foreach($student as $key => $value){
              if(strcmp($key, 'StudentName')==0)
                $row2['StudentName']=$value;
              else
                $row2['session'. $i++]=$value;
            }
            array_push($ret2 , $row2);
          }
          return $ret2;

        }


        public function insertSession($SDate, $Desc, $EDate, $User){
            //NN Text ArabicSDate SDate DistrictID
          $strSQL = "INSERT INTO sessions (SESS_STRT_DATE, SESS_DESC, SESS_END_DATE, SESS_USER_ID)
                     VALUES (?, ?, ?, ?)";

          $inputs = array($SDate, $Desc, $EDate, $User);
          $query = $this->db->query($strSQL, $inputs);
          $strSQL = "SELECT SESS_ID, SESS_STRT_DATE, SESS_DESC, SESS_END_DATE, SESS_USER_ID
                     FROM sessions, Users
                     WHERE SESS_USER_ID = USER_ID AND SESS_ID = LAST_INSERT_ID()";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0];
        }

        public function editSessions($ID, $SDate, $Desc, $EDate, $User){
            //NN Text ArabicSDate SDate DistrictID
          $strSQL = "UPDATE sessions
                    SET SESS_STRT_DATE   = ?,
                        SESS_DESC    = ?,
                        SESS_END_DATE   = ?,
                        SESS_USER_ID     = ?
                    WHERE
                        `SESS_ID`= ?";
          $inputs = array($SDate, $Desc, $EDate, $User);
          $query = $this->db->query($strSQL, $inputs);
          $strSQL = "SELECT SESS_ID, SESS_STRT_DATE, SESS_DESC, SESS_END_DATE, SESS_USER_ID
                     FROM sessions, Users
                     WHERE SESS_USER_ID = USER_ID AND SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0];
        }

        public function deleteSession($ID){
          $this->db->trans_start();
          $strSQL = "DELETE FROM session_class WHERE SSCL_SESS_ID = {$ID} ";
          $query = $this->db->query($strSQL);
          $strSQL = "DELETE FROM attendance WHERE SESS_ID = {$ID} ";
          $query = $this->db->query($strSQL);
          $strSQL = "DELETE FROM sessions WHERE SESS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $this->db->trans_complete();
        }

}
