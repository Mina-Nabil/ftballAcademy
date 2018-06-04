<?php


  class Classes extends MY_Controller {

    public function __construct()
    {
      parent::__construct();
      //Codeigniter : Write Less Do More
    }

    public function getClasses($key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Classes_model->getClasses(), JSON_UNESCAPED_UNICODE);
      }

    }





  }
?>
