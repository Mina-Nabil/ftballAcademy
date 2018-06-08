<?php


  class Classes extends MY_Controller {

    public function __construct()
    {

      parent::__construct();
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
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
            'name'  => 'Class: ' . $class['CLSS_NAME']
          ));
        }
        echo json_encode($temp, JSON_UNESCAPED_UNICODE);
      }
    }

    public function addClass($key=''){
      if($this->permitApiCall($key)){
        $className = $this->input->post('CLSS_NAME');
        $classDesc = $this->input->post('CLSS_DESC');
        $classYear = $this->input->post('CLSS_YEAR');
      }

      echo json_encode($this->Classes_model->insertClass($className, $classDesc, $classYear), JSON_UNESCAPED_UNICODE);
    }

  }
?>
