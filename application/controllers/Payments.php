<?php


  class Payments extends MY_Controller {

    public function __construct()
    {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
      parent::__construct();

    }

    public function getPaymentsByClass($classID){
        echo json_encode($this->Payments_model->getPendingPayments($classID), JSON_UNESCAPED_UNICODE);

    }

    public function getStudentPaymentHistory($studentID){
      echo json_encode($this->Payments_model->getPendingPayments($classID), JSON_UNESCAPED_UNICODE);
    }

    public function insertPayment(){
      $data = json_decode(file_get_contents('php://input'), true);

      $Name = $data['PYMT_NAME'];
      $Amount  = $data['PYMT_AMNT'];
      $Date  = date("Y-m-d");

      $paymentTO = $data['PYMT_STUD'];

      if($Name !== null && $BirthD !==null && $ParentTel!==null)
      echo json_encode($this->Students_model->insertPayments($studentID, $Name, $Amount), JSON_UNESCAPED_UNICODE);
      else
      die("Invalid Arguments");
    }

  }
?>
