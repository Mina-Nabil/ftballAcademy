<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getClasses(){

          $strSQL = "SELECT CLSS_ID, CLSS_NAME, CLSS_DESC, CLSS_YEAR
                      FROM Classes";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getClass_byID($ID){

          $strSQL = "SELECT CLSS_ID, CLSS_NAME, CLSS_DESC, CLSS_YEAR
                    FROM Classes WHERE CLSS_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }


        public function insertClasses($Name, $Desc, $Year){
            //NN Text ArabicName Name DistrictID
          $strSQL = "INSERT INTO Classes (CLSS_NAME, CLSS_DESC, CLSS_YEAR)
                     VALUES (?, ?, ?)";

          $inputs = array($Name, $Desc, $Year);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editClasses($ID, $Name, $Desc, $Year){
            //NN Text ArabicName Name DistrictID
          $strSQL = "UPDATE Classes
                    SET CLSS_NAME    = ?,
                        CLSS_DESC    = ?,
                        CLSS_YEAR    = ?
                    WHERE
                        `CLSS_ID`    = ?";
          $inputs = array($Name, $Desc, $Year, $ID);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function deleteClasses($ID){
          $strSQL = "DELETE FROM Classes WHERE CLSS_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
