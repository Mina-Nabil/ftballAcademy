<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getPendingPayments($classID){

          $strSQL = "SELECT PYMT_ID, PYMT_NAME, PYMT_STUD, PYMT_DATE, PYMT_PAID, PYMT_AMNT, STUD_NAME
                      FROM  Payments, students
                      WHERE PYMT_STUD = STUD_ID AND STUD_CLSS_ID = ? AND PYMT_PAID = 0 ";
          $query = $this->db->query($strSQL, array($classID));
          return $query->result_array();

        }

        public function getPaymentCountThisMonth($studentID){
          $strSQL = "SELECT COUNT(*) as kam
                      FROM Payments
                      WHERE PYMT_STUD = ? AND MONTH(PYMT_DATE) = MONTH(NOW()) AND YEAR(PYMT_DATE) = YEAR(NOW()) ";

          $query = $this->db->query($strSQL, array($studentID));
          return $query->result_array()[0]['kam'];
        }

        public function getStudentPayments($studentID){

          $strSQL = "SELECT PYMT_ID, PYMT_NAME, PYMT_STUD, PYMT_DATE, PYMT_PAID, PYMT_AMNT, STUD_NAME
                      FROM  Payments, students
                      WHERE PYMT_STUD=STUD_ID AND PYMT_STUD = ?
                      ORDER BY PYMT_ID DESC 
                      LIMIT 100 ";
          $query = $this->db->query($strSQL, array($studentID));
          return $query->result_array();

        }


        public function insertPayments($studentID, $paymentName, $Amount){
            //NN Text ArabicName Name DistrictID
          $strSQL = "INSERT INTO Payments (PYMT_STUD, PYMT_NAME, PYMT_AMNT, PYMT_DATE)
                     VALUES (?, ?, ?, NOW())";
          $query = $this->db->query($strSQL, array($studentID, $paymentName, $Amount));

        }

        public function payPayments($ID){
          $strSQL = "UPDATE Payments
                    SET PYMT_PAID = 1
                    WHERE
                        `PYMT_ID`= ?";
          return $this->db->query($strSQL, array($ID));

        }


        public function getSubscriptionAmount(){
          $strSQL = "SELECT STTNG_SUB_AMNT FROM settings";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0]['STTNG_SUB_AMNT'];
        }

        public function getSettings(){
          $strSQL = "SELECT STTNG_SUB_AMNT FROM settings";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0];
        }

        public function editSubAmount($newAmount){
          if(is_numeric($newAmount)){
            $strSQL = "UPDATE Settings SET STTNG_SUB_AMNT = ? ";
            $query = $this->db->query($strSQL, array($newAmount));
          }
        }

}
