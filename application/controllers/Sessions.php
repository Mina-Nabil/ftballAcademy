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
        echo json_encode($this->SessionClass_model->getSessionsByClass($ClassID), JSON_UNESCAPED_UNICODE);
      }
    }

    public function getSession($SessID, $key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Sessions_model->getSession_byID($SessID), JSON_UNESCAPED_UNICODE);
      }
    }

    public function getSession_CalendarEvent($Month, $key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Sessions_model->getSessions_limit($Month), JSON_UNESCAPED_UNICODE);
      }
    }

    public function takeAttendance($StudentID, $key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Attendance_model->$StudentID($Month), JSON_UNESCAPED_UNICODE);
      }
    }

    public function addSession($key=''){
      if($this->permitApiCall($key)){
        $data = json_decode(file_get_contents('php://input'), true);

        $Desc = $data[0]['SESS_DESC'];
        $StartDate = $data[0]['SESS_STRT_DATE'];
        $EndDate = $data[0]['SESS_END_DATE'];
        $UserID = $data[0]['SESS_USER_ID'];
        $classesID = $data[1]['classes'];
      }
      if($Desc !== null && $StartDate !==null && $EndDate!==null && $UserID!==null)
      {
        $NewSession = $this->Sessions_model->insertSession($StartDate, $Desc, $EndDate, $UserID);
        foreach($classesID as $class){
          $this->SessionClass_model->insertSessionClass($NewSession['SESS_ID'], $class);
        }
        echo json_encode($NewSession, JSON_UNESCAPED_UNICODE);
      }
      else
      die("Invalid Arguments");

     }

     public function editSession($SessID, $key=''){
       if($this->permitApiCall($key)){
         $data = json_decode(file_get_contents('php://input'), true);

         $Desc = $data['SESS_DESC'];
         $StartDate = $data['SESS_STRT_DATE'];
         $EndDate = $data['SESS_END_DATE'];
         $UserID = $data['SESS_USER_ID'];
       }
       if($Desc !== null && $StartDate !==null && $EndDate!==null && $UserID!==null)
       echo json_encode($this->Sessions_model->editSession($SessID, $StartDate, $Desc, $BirthD, $UserID), JSON_UNESCAPED_UNICODE);
       else
       die("Invalid Arguments");

      }



  }
?>
