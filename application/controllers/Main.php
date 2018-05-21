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
        $this->load->view('redirect/home');
        return;
      }
      $header['ArrURL'] = $this->Master_model->getHeaderArr();

      $data["MSGErr"] = $MSGErr;

      $this->load->view('pages/login', $data);

    }

    function logout(){
      $this->session->sess_destroy();
        $this->load->view('redirect/login');
    }

    function home(){

      if(!isset($this->session->userdata['USRNAME'])){
        $this->login();
        return;
      }
      $header['ArrURL'] = $this->Master_model->getHeaderArr();

      $this->load->view('templates/header', $header);
      $this->load->view('pages/home');
      $this->load->view('templates/footer');
    }

    function checkLoginData(){
      $userName = $this->input->post('userName');
      if(isset($this->input->post('userPass')))
      $userPass = $this->input->post('userPass');
      else {
        $userPass = '';
      }
      $res = $this->Master_model->user_login($userName, $userPass);
      if($res){
        $this->load->view('redirect/home');
      }else {
        $this->login('Invalid User data');
      }
    }

  }
