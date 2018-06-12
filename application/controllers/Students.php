<?php


  class Students extends MY_Controller {

    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      parent::__construct();

    }

    public function getAllStudents($key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Students_model->getStudents(), JSON_UNESCAPED_UNICODE);
      }

    }

    public function getStudents($ClassID, $key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Students_model->getStudent_byClass($ClassID), JSON_UNESCAPED_UNICODE);
      }
    }

    public function addStudent($key=''){
      if($this->permitApiCall($key)){
        $data = json_decode(file_get_contents('php://input'), true);

        $Name = $data['STUD_NAME'];
        $BirthD = $data['STUD_BD'];
        $Tel = $data['STUD_TEL'];
        $Weight = $data['STUD_WGHT'];
        $Height = $data['STUD_LGTH'];
        $FavPos = $data['STUD_FAV_POS'];
        $ClassID = $data['STUD_CLASS_ID'];
        $ParentTel = $data['STUD_PRNT_TEL'];
        $ParentTel2 = $data['STUD_PRNT_TELL'];
        $ParentName = $data['STUD_PRNT_NAME'];
        $MentorName = $data['STUD_MNTR_NAME'];
        $PrevClub  = $data['STUD_PREV_CLUB'];
      }
      if($Name !== null && $BirthD !==null && $ParentName!==null && $MentorName!==null && $ParentTel!==null)
      echo json_encode($this->Students_model->insertStudent($Name, $Tel, $BirthD, $ParentTel, $ClassID, $ParentTel2, $ParentName, $MentorName, $PrevClub, $FavPos, $Weight, $Height), JSON_UNESCAPED_UNICODE);
      else
      die("Invalid Arguments");

    }



  }
?>
