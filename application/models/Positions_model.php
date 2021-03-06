<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Positions_model extends CI_Model{

        public function __construct()
        {
          parent::__construct();
          //Codeigniter : Write Less Do More
        }

        public function getPositions(){

          $strSQL = "SELECT POST_ID, POST_NAME, POST_ABB
                      FROM positions";
          $query = $this->db->query($strSQL);
          return $query->result_array();

        }

        public function getPosition_byID($ID){

          $strSQL = "SELECT POST_ID, POST_NAME, POST_ABB
                    FROM positions WHERE POST_ID = {$ID}";
          $query = $this->db->query($strSQL);
          return $query->result_array()[0];

        }


        public function insertPositions($Name, $Abb){
            //NN Text ArabicName Name DistrictID
          $strSQL = "INSERT INTO positions (POST_NAME, POST_ABB)
                     VALUES (?,?)";

          $inputs = array($Name, $Abb);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function editPositions($ID, $Name, $Abb){
            //NN Text ArabicName Name DistrictID
          $strSQL = "UPDATE positions
                    SET POST_NAME   = ?, POST_ABB = ?
                    WHERE
                        `POST_ID`= ?";
          $inputs = array($Name, $Abb);
          $query = $this->db->query($strSQL, $inputs);

        }

        public function deletePositions($ID){
          $strSQL = "DELETE FROM positions WHERE POST_ID = {$ID}";
          $query = $this->db->query($strSQL);
        }

}
