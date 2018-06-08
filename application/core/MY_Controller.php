<?php

  class MY_Controller extends CI_Controller{

    public function __construct()
    {



      parent::__construct();
      //Codeigniter : Write Less Do More
    }

    public function permitApiCall($key){
      return true;
    }

  }
  ?>
