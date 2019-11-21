<?php


  class Positions extends MY_Controller {

    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Cache-Control: no-transform");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      parent::__construct();

    }

    public function getPositions($key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Positions_model->getPositions(), JSON_UNESCAPED_UNICODE);
      }

    }

    public function getPosition($PositionID, $key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Positions_model->getPosition_byID($PositionID), JSON_UNESCAPED_UNICODE);
      }

    }

  }
?>
