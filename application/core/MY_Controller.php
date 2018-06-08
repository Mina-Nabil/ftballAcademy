<?php

  class MY_Controller extends CI_Controller{

    public function __construct()
    {

      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

      parent::__construct();
      //Codeigniter : Write Less Do More
    }

    public function permitApiCall($key){
      return true;
    }

  }
  ?>
