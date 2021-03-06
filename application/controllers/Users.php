<?php


  class Users extends MY_Controller {

    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      parent::__construct();
      $this->output->set_header('Cache-Control: no-transform');
    }

    public function getUsers($key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Users_model->getUsers(), JSON_UNESCAPED_UNICODE);
      }

    }

    public function authenticate(){

      $data = json_decode(file_get_contents('php://input'), true);

      $Name = $data['uname'];
      $Pass = $data['password'];

      $res = $this->Users_model->login($Name, $Pass);
      if($res){
        echo json_encode($this->generateToken($res), JSON_UNESCAPED_UNICODE);
      } else {
        echo json_encode(array('token' => false), JSON_UNESCAPED_UNICODE);
      }
    }

    private function generateToken($ID){
      $tokenData = array();
      $tokenData['sub'] = $ID; //TODO: Replace with data for token
      $tokenData['exp'] = time() + (30 * 60);
                   // 7 days; 24 hours; 60 mins; 60 secs
      $output['token'] = AUTHORIZATION::generateToken($tokenData);
      return $output;
    }

  }
?>
