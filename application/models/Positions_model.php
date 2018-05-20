<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Positions_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getPositions(){

          $strSQL = "SELECT POST_ID, POST_NAME
                      FROM Positions";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getPosition_byID($ID){

          $strSQL = "SELECT POST_ID, POST_NAME
                    FROM Positions WHERE POST_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }


        public function insertPositions($Name){
            //NN Text ArabicName Name DistrictID
          $strSQL = "INSERT INTO Positions (POST_NAME)
                     VALUES (?)";

          $inputs = array($Name);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editPositions($ID, $Name){
            //NN Text ArabicName Name DistrictID
          $strSQL = "UPDATE Positions
                    SET POST_NAME   = ?
                    WHERE
                        `POST_ID`= ?";
          $inputs = array($Name);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function deletePositions($ID){
          $strSQL = "DELETE FROM Positions WHERE POST_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
