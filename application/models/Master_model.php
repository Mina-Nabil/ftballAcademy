<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getHeaderArr(){

    $tmp = array();
    if(isset($this->session->userdata['USRNAME'])) {
      $tmp[0] = true;
      $tmp['Students'] = array(
        'Url' => 'students',
        'Type' => 'Datatable',
        'Name' => 'Show Students',
        'Access' => 'USER'
      );
      $tmp['AddStudent'] = array(
        'Url' => 'addstudent',
        'Type' => 'Datatable',
        'Name' => 'Add Student',
        'Access' => 'USER'
      );
      $tmp['StudentProfile'] = array(
        'Url' => 'studentprofile',
        'Type' => 'Datatable',
        'Name' => 'Show Students',
        'Access' => 'USER'
      );
      $tmp['Classes'] = array(
        'Url' => 'classes',
        'Type' => 'Datatable',
        'Name' => 'Show Classes',
        'Access' => 'USER'
      );
      $tmp['AddClass'] = array(
        'Url' => 'addclass',
        'Type' => 'Datatable',
        'Name' => 'Add Class',
        'Access' => 'USER'
      );
      $tmp['Positions'] = array(
        'Url' => 'positions',
        'Type' => 'Configuration',
        'Name' => 'Positions',
        'Access' => 'USER'
      );
      $tmp['AddPositions'] = array(
        'Url' => 'addposition',
        'Type' => 'Configuration',
        'Name' => 'Add Position',
        'Access' => 'USER'
      );
      $tmp['AddUser'] = array(
        'Url' => 'adduser',
        'Type' => 'Datatable',
        'Name' => 'Add User',
        'Access' => 'USER'
      );
      $tmp['Users'] = array(
        'Url' => 'users',
        'Type' => 'Datatable',
        'Name' => 'Show Users',
        'Access' => 'USER'
      );

      return $tmp;
    } else {
      $tmp[0] = false;
      $tmp[1] = array(
        'Link' => 'login',
        'Name' => 'Login'
      );
      return $tmp;
    }
  }

  public function checkPageByUrl($Pageurl){
    if(isset($this->session->userdata['USRPAGES'])){
    return in_array($Pageurl, $this->session->userdata['USRPAGES']);
    }
    else {
      return false;
    }
  }



    public function user_login($userName, $passWord = ''){

      if(strcmp($passWord, '') != 0){
        $strSQL = "SELECT COUNT(*) AS EXP, USER_ID FROM users
                  WHERE USER_UNAME = ?
                  AND USER_PASS = ?";

        $query = $this->db->query($strSQL, array($userName, $passWord));
        $result = $query->result_array();
        if($result[0]['EXP'] == 1){
          $SESSArr = array (
            'USRNAME'  => $userName,
            'USRTYPE'  => 'Mentor',
            'USRID'    => $result[0]['USR_ID']
          );
          $this->session->set_userdata($SESSArr);
          return true;
        }else {
          return false;
        }
      }
      else {
        //Student Profile Login
      }


    }





  }
