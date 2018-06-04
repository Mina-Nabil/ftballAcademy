<?php


  class Students extends MY_Controller {

    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      $method = $_SERVER['REQUEST_METHOD'];
      if($method == "OPTIONS") {
          die();
      }
      parent::__construct();
      //Codeigniter : Write Less Do More
    }

    public function getAllStudents($key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Students_model->getStudents(), JSON_UNESCAPED_UNICODE);
      }

    }

    public function getStudents($ClassID, $key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Students_model->getStudent_byClass($ClassID), JSON_UNESCAPED_UNICODE);
      }
    }



  }
?>
