<?php


  class Payments extends MY_Controller {

    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Cache-Control: no-transform");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      parent::__construct();

    }

    public function getPaymentsByClass($classID){
        echo json_encode($this->Payments_model->getPendingPayments($classID), JSON_UNESCAPED_UNICODE);

    }

    public function getStudentPaymentHistory($studentID){
      echo json_encode($this->Payments_model->getStudentPayments($studentID), JSON_UNESCAPED_UNICODE);
    }

    public function payPayment($paymentID){
      echo json_encode($this->Payments_model->payPayments($paymentID), JSON_UNESCAPED_UNICODE);
    }

    public function getSettings(){
      echo json_encode($this->Payments_model->getSettings(), JSON_UNESCAPED_UNICODE);
    }

    public function setSettings(){
      $data = json_decode(file_get_contents('php://input'), true);

      $Amount = $data['STTNG_SUB_AMNT'];

      if(isset($Amount) && is_numeric($Amount)){
        $this->Payments_model->editSubAmount($Amount);
        echo json_encode(array("result"=>1), JSON_UNESCAPED_UNICODE);
      }
      else
        die("Invalid Arguments");
    }

    public function insertPayment(){
      $data = json_decode(file_get_contents('php://input'), true);

      $Name = $data['PYMT_NAME'];
      $Amount  = $data['PYMT_AMNT'];
      $Date  = date("Y-m-d");

      $Student = $data['PYMT_STUD'];
      $Class = $data['PYMT_CLSS'];

      if($Student == 0 && $Class == 0) die("Invalid Request");

      else if ($Student == 0) //Generate Payment for a class
      {
        $students = $this->Students_model->getStudent_byClass($Class);
        foreach($students as $taleb){
          $this->Payments_model->insertPayments($taleb['STUD_ID'], $Name, $Amount);
        }
        echo json_encode(array("result"=>1), JSON_UNESCAPED_UNICODE);
      }

      else if ($Class==0) //Generate Payment for one student
      {
        $this->Payments_model->insertPayments($Student, $Name, $Amount);
        echo json_encode(array("result"=>1), JSON_UNESCAPED_UNICODE);
      }
      else
      die("Invalid Arguments");
    }

  }
?>
