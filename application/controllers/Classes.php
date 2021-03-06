<?php


  class Classes extends MY_Controller {

    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      parent::__construct();
      $this->output->set_header('Cache-Control: no-transform');
    }

    public function getClasses($key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Classes_model->getClasses(), JSON_UNESCAPED_UNICODE);
      }

    }

    public function getClassChart($ClassID, $Month, $Year, $key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Classes_model->getAttendanceChart($ClassID, $Month, $Year), JSON_UNESCAPED_UNICODE);
      }
    }

    public function getSessionsForAttendance($classID){
      echo json_encode(array_values($this->Sessions_model->getSessionsForAttendance($classID)), JSON_UNESCAPED_UNICODE);
    }

    public function getAttendance($classID){
      echo json_encode($this->Sessions_model->getClassAttendance($classID), JSON_UNESCAPED_UNICODE);
    }

    public function getAttendanceforStudent($studentID){
      echo json_encode($this->Attendance_model->getAttendance_byStudent($studentID), JSON_UNESCAPED_UNICODE);
    }

    public function getClass_byID($classID, $key=''){
      if($this->permitApiCall($key)){
        echo json_encode($this->Classes_model->getClass_byID($classID)[0], JSON_UNESCAPED_UNICODE);
      }

    }

    public function getRoutes($key=''){
      if($this->permitApiCall($key)){
        $classes = $this->Classes_model->getClasses();
        $temp = array();
        foreach($classes as $class){
          array_push($temp, array(
            'state' => $class['CLSS_ID'],
            'name'  => 'Class: ' . $class['CLSS_NME']
          ));
        }
        echo json_encode($temp, JSON_UNESCAPED_UNICODE);
      }
    }

    public function addClass($key=''){
      if($this->permitApiCall($key)){
        $data = json_decode(file_get_contents('php://input'), true);

        $className = $data['CLSS_NME'];
        $classDesc = $data['CLSS_DESC'];
        $classYear = $data['CLSS_YEAR'];
      }
      if($className !== null && $classDesc !==null && $classYear!==null){

        echo json_encode($this->Classes_model->insertClass($className, $classDesc, $classYear), JSON_UNESCAPED_UNICODE);
      }
      else
      die("Invalid Arguments");

    }

    public function editClass($key=''){
      if($this->permitApiCall($key)){
        $data = json_decode(file_get_contents('php://input'), true);

        $classID = $data['CLSS_ID'];
        $className = $data['CLSS_NME'];
        $classDesc = $data['CLSS_DESC'];
        $classYear = $data['CLSS_YEAR'];

      }
      if($classID !==null && $className !== null && $classDesc !==null && $classYear!==null){
        echo json_encode($this->Classes_model->editClass($classID, $className, $classDesc, $classYear), JSON_UNESCAPED_UNICODE);


      }
      else
      die("Invalid Arguments");

    }

  }
?>
