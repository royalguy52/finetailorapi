<?php

require APPPATH . 'libraries/REST_Controller.php';

class Firebasemessaging extends REST_Controller
{
    private $late = "";
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

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_get($mode = 0, $madrasaid = 0, $classid = 0, $studentid = 0, $fromdateid = 0, $uptodateid = 0, $dateid = 0, $morethan = 0, $itsids = 0, $sms = 0)
    {
     




        
        $this->response([], REST_Controller::HTTP_NO_CONTENT);
        
    }



    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_post()
    {
        $studentid = $this->input->post('studentid');
        $dateid = $this->input->post('dateid');
        $intime = $this->input->post('intime');
        $input = $this->input->post();

        if ($this->checkrecord($studentid, $dateid)) {

            $sql = "SELECT  intime FROM tblattendance WHERE dateid=? AND  studentid=?";
            $query = $this->db->query($sql, array($dateid, $studentid));
            $row = $query->row();


            if (strtotime($row->intime) > strtotime($input["intime"])) {

                $input["updateby"] = $input["addedby"];
                unset($input["addedby"]);
                unset($input["Sendsms"]);
                $smstext = $this->prepare_sms($intime, $studentid, $dateid, "10");
                $input["late"] = $this->late;
                $this->db->update('tblattendance', $input, array('studentid' => $studentid, 'dateid' => $dateid));
                $data["studentid"] = $studentid;
                $data["dateid"] = $dateid;
                $data["attendanceUpdateSuccess"] = $input["intime"];

                $this->response($data, REST_Controller::HTTP_OK);
            } else {

                $data["studentid"] = $studentid;
                $data["dateid"] = $dateid;
                $data["updatefailreason"] = "This student has already scanned before on early time.";
                $data["alreadyScannedTime"] = $row->intime;
                $this->response($data, REST_Controller::HTTP_OK);
            };
        } else {
            $input = $this->input->post();

            // write sms code here.
            $smstext = $this->prepare_sms($intime, $studentid, $dateid, "10");
            if ($input["Sendsms"] == "y") {

                $data["smsrequestid"] =  $this->send_sms($smstext, $studentid);
                $input["smsrequestid"] = $data["smsrequestid"];
                $input["smsmsg"] = $smstext;
            }

            unset($input["Sendsms"]);
            $input["late"] = $this->late;
            $this->db->insert('tblattendance', $input);
            $data["attendanceid"] = $this->db->insert_id();
            $data["studentid"] = $studentid;
            $data["dateid"] = $dateid;
            $this->response($data, REST_Controller::HTTP_OK);

            // }
        }
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('tblattendance', $input, array('id' => $id));

        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_delete($id)
    {
        $this->db->delete('tblattendance', array('id' => $id));

        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }

    private function checkrecord($studentid, $dateid)
    {
        $data = $this->db->get_where("tblattendance", array('studentid' => $studentid, 'dateid' => $dateid))->row_array();

        return $data;
    }

    private function checkmadrasa($madrasaid)
    {
        $sql = "Select     * From     tblmozemaster Inner Join     tblmadrasamaster On tblmadrasamaster.mozeid = tblmozemaster.mozeid     Where tblmadrasamaster.madrasaid=?   ";
        $data = $this->db->query($sql, $madrasaid)->result();

        return $data;
    }


    private function send_sms($sms, $studentid)
    {
        $authKey = "";
        $mobileNumber = "";
        $senderId = "";

        $query = $this->db->query("Select     settingmaster.settingname,     tblstudentmaster.studentid,     settings.value,     tblstudentmaster.contact,     settingmaster.settingid From     settingmaster Inner Join     settings On settings.settingid = settingmaster.settingid Inner Join     tbl_year_class On settings.madrasaid = tbl_year_class.madrasaid Inner Join     tbl_student_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner Join     tblstudentmaster On tblstudentmaster.studentid = tbl_student_year_class.studentid Where     tblstudentmaster.studentid ={$studentid} and settings.settingid =6    ");

        $row = $query->row();
        if (isset($row)) {
            $authKey =  $row->value;
            $mobileNumber = "91{$row->contact}";
        }

        $query = $this->db->query("Select     settingmaster.settingname,     tblstudentmaster.studentid,     settings.value,     tblstudentmaster.contact,     settingmaster.settingid From     settingmaster Inner Join     settings On settings.settingid = settingmaster.settingid Inner Join     tbl_year_class On settings.madrasaid = tbl_year_class.madrasaid Inner Join     tbl_student_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner Join     tblstudentmaster On tblstudentmaster.studentid = tbl_student_year_class.studentid Where     tblstudentmaster.studentid ={$studentid} and settings.settingid =7    ");

        $row = $query->row();
        if (isset($row)) {
            $senderId =  $row->value;
        }
        //Sender ID,While using route4 sender id should be 6 characters long.


        //Your message to send, Add URL encoding here.
        $message = urlencode($sms);

        //Define route
        $route = "4";
        //Prepare you post parameters
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobileNumber,
            'message' => $message,
            'sender' => $senderId,
            'route' => $route
        );

        //API URL
        $url = "http://sms1.almasaarr.com/api/sendhttp.php";

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));


        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if (curl_errno($ch)) {
            return 'error:' . curl_error($ch);
        }

        curl_close($ch);


        return $output;
    }

    private function latetext($intime, $studentid, $dateid, $latethreshold)
    {
        $this->late = "";
        $q = "Select      date_format(tbltimetable.Fromtime,get_format(TIME,'JIS'))as Fromtime      From     tblstudentmaster Inner Join     tbl_student_year_class On tblstudentmaster.studentid = tbl_student_year_class.studentid Inner Join     tbltimetable On tbltimetable.yearclassid = tbl_student_year_class.yearclassid Where     tbltimetable.dayid = substr(DayName(?), 1, 3) And     tblstudentmaster.studentid = ?";
        $data = $this->db->query($q, array($dateid, $studentid))->row();
        if (isset($data)) {

            if (strtotime($data->Fromtime) < strtotime($intime)) {
                $to_time = strtotime($data->Fromtime);
                $from_time = strtotime($intime);

                if (round(abs($to_time - $from_time) / 60, 2) > $latethreshold) {
                    $this->late = "y";
                    return "(" . round(abs($to_time - $from_time) / 60) . " minutes late)";
                   
                }
            } else return "";
        } else return "";
    }

    private function prepare_sms($intime, $studentid, $dateid, $latethreshold)
    {
        $q = "Select firstname from tblstudentmaster where studentid=?";
        $studentname = $this->db->query($q, $studentid)->row('firstname');
        $latetext = $this->latetext($intime, $studentid, $dateid, $latethreshold);
        $dateid = $date = date_create($dateid);
        $smstext = $studentname . " aaje " . date_format($dateid, 'd-M-y') . " madrasa ma " . $intime . " " . $latetext . " hazir thaya che";
        return $smstext;
    }

    function sendFCM($mess,$id) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
                'to' => $id,
                'notification' => array (
                        "body" => $mess,
                        "title" => "Title",
                        "icon" => "myicon"
                )
        );
        $fields = json_encode ( $fields );
        $headers = array (
                'Authorization: key=' . "AIzaSyDEszt6PnSYJmYoOaD2J-97qy3CkLNqAu0",
                'Content-Type: application/json'
        );
        
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        }




}
