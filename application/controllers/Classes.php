<?php


  class Classes extends MY_Controller {

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

    public function getClasses($key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Classes_model->getClasses(), JSON_UNESCAPED_UNICODE);
      }

    }

    public function getRoutes($key=''){
      if($this->permitApiCall($key)){
        $classes = $this->Classes_model->getClasses();
        $temp = array();
        foreach($classes as $class){
          array_push($temp, array(
            'state' => $class['CLSS_ID'],
            'name'  => $class['CLSS_NAME']
          ));
        }


        echo json_encode($temp, JSON_UNESCAPED_UNICODE);
      }

    }





  }
?>
