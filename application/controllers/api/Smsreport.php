<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Smsreport extends REST_Controller
{
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
       

    public function index_get()
    {
        $request = $_REQUEST["data"];
        $jsonData = json_decode($request, true);





       // $this->response($data, REST_Controller::HTTP_OK);

       



        foreach ($jsonData as $key => $value) {
           
            $requestID = $value['requestId'];


            foreach ($value['numbers'] as $key1 => $value1) {
              
                $desc = $value1['desc'];
                $status = $value1['status'];
                $date = $value1['date'];
                $date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));


                 $query="INSERT INTO tblsmsdelivery (smsid,status,reportdate) VALUES ('$requestID','$desc','$date');";
                //$data["query"]=$query;
                $this->db->query($query);
                //$this->response($data, REST_Controller::HTTP_OK);
            }
        }
    }
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
 
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $request = $_REQUEST["data"];
        $jsonData = json_decode($request, true);





       // $this->response($data, REST_Controller::HTTP_OK);

       



        foreach ($jsonData as $key => $value) {
           
            $requestID = $value['requestId'];


            foreach ($value['numbers'] as $key1 => $value1) {
              
                $desc = $value1['desc'];
                $status = $value1['status'];
                $date = $value1['date'];
                $date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));


                 $query="INSERT INTO tblsmsdelivery (smsid,status,reportdate) VALUES ('$requestID','$desc','$date');";
                //$data["query"]=$query;
                $this->db->query($query);
                //$this->response($data, REST_Controller::HTTP_OK);
            }
        }
    }
}