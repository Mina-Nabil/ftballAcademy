<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Students extends MY_Main {

    public function __construct()
    {
      parent::__construct();
      //Codeigniter : Write Less Do More
    }

    public function getAllStudents($key=''){
      if($this->permitApiCall($key)){
        return json_encode($this->Students_model->getStudents(), JSON_UNESCAPED_UNICODE);
      }
    }

    public function getStudents($ClassID, $key=''){
      if($this->permitApiCall($key)){
        return json_encode($this->Students_model->getStudent_byClass($ClassID), JSON_UNESCAPED_UNICODE);
      }
    }



  }
