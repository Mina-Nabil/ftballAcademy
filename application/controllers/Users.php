<?php


  class Users extends MY_Controller {

    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      parent::__construct();

    }

    public function getUsers($key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Users_model->getUsers(), JSON_UNESCAPED_UNICODE);
      }

    }

    public function authenticate(){
      $tokenData = array();
      $tokenData['id'] = 1; //TODO: Replace with data for token
      $output['token'] = AUTHORIZATION::generateToken($tokenData);
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }

  }
?>
