<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Main extends CI_Controller{

    public function __construct()
    {
      parent::__construct();
      //Codeigniter : Write Less Do More
    }

    function login($MSGErr = '')
    {
      if(isset($this->session->userdata['USRNAME'])){
        $this->home();
        return;
      }
      $header['ArrURL'] = $this->Master_model->getHeaderArr();

      $data["MSGErr"] = $MSGErr;

      $this->load->view('pages/login', $data);

    }

    function logout(){
      $this->session->sess_destroy();
        $this->load->view('login_redirect');
    }

    function home(){

      if(!isset($this->session->userdata['USRNAME'])){
        $this->login();
        return;
      }
      $header['ArrURL'] = $this->Master_model->getHeaderArr();
      $header['OrgArr'] = $this->Master_model->getPagesByType();

      $this->load->view('templates/header', $header);
      $this->load->view('pages/home');
      $this->load->view('templates/footer');
    }

    function checkLoginData(){
      $userName = $this->input->post('userName');
      $userPass = $this->input->post('userPass');
      $userType = $this->input->post('userType');

      $res = $this->Master_model->user_login($userName, $userPass, $userType);
      if($res){
        $this->load->view('redirect/home');
      }else {
        $this->login('Invalid User data');
      }
    }

  }
