<?php


  class Sessions extends MY_Controller {

    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      parent::__construct();

    }

    public function getAllSessions($key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Sessions_model->getSessions(), JSON_UNESCAPED_UNICODE);
      }

    }

    public function getSessions($ClassID, $key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Sessions_model->getSession_byClass($ClassID), JSON_UNESCAPED_UNICODE);
      }
    }

    // public function addSession($key=''){
    //   if($this->permitApiCall($key)){
    //     $data = json_decode(file_get_contents('php://input'), true);
    //
    //     $Name = $data['SESS_NAME'];
    //     $BirthD = $data['SESS_BD'];
    //     $Tel = $data['SESS_TEL'];
    //     $Weight = $data['SESS_WGHT'];
    //     $Height = $data['SESS_LGTH'];
    //     $FavPos = $data['SESS_FAV_POS'];
    //     $ClassID = $data['SESS_CLSS_ID'];
    //     $ParentTel = $data['SESS_PRNT_TEL'];
    //     $ParentTel2 = $data['SESS_PRNT_TELL'];
    //     $ParentName = $data['SESS_PRNT_NAME'];
    //     $MentorName = $data['SESS_MNTR_NAME'];
    //     $PrevClub  = $data['SESS_PREV_CLUB'];
    //   }
    //   if($Name !== null && $BirthD !==null && $ParentName!==null && $MentorName!==null && $ParentTel!==null)
    //   echo json_encode($this->Sessions_model->insertSession($Name, $Tel, $BirthD, $ParentTel, $ClassID, $ParentTel2, $ParentName, $MentorName, $PrevClub, $FavPos, $Weight, $Height), JSON_UNESCAPED_UNICODE);
    //   else
    //   die("Invalid Arguments");

    //  }



  }
?>
