<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Student extends REST_Controller
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
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_get($mode = 0, $itsid = 0, $rfid = 0, $moze=0, $dayid = 0, $id=0)
    {
        if (!empty($mode)) {
            switch ($mode) {
                case 'moze':
                     
                if (!empty($moze)) {
                    $sql ="SELECT   tblstudentmaster.studentid,   tblstudentmaster.contact,   tblstudentmaster.rfid,   tblstudentmaster.itsid,   tbltimetable.dayid,   tbltimetable.Fromtime,   tbltimetable.Uptotime,   tblstudentmaster.firstname FROM tblstudentmaster   INNER JOIN tbl_student_year_class     ON tblstudentmaster.studentid = tbl_student_year_class.studentid   INNER JOIN tbltimetable     ON tbl_student_year_class.yearclassid = tbltimetable.yearclassid   CROSS JOIN tblmozemaster   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid     AND tblmozemaster.mozeid = tblmadrasamaster.mozeid WHERE tblmadrasamaster.madrasaid = ?";
                    $data = $this->db->query($sql, $moze)->result();
                }
                
                    break;
                    case 'madrasa':
                     
                    if (!empty($moze)) {
                        $sql ="SELECT    tblstudentmaster.studentid,   tblstudentmaster.contact,   tblstudentmaster.rfid,   tblstudentmaster.itsid,   tblstudentmaster.firstname,   tbl_year_class.yearclassid,   CONCAT(tblclassmaster.classid, '-(', tbldivmaster.divdesc, ')') AS class FROM tblstudentmaster   INNER JOIN tbl_student_year_class     ON tblstudentmaster.studentid = tbl_student_year_class.studentid   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid   INNER JOIN tblclassmaster     ON tbl_year_class.classid = tblclassmaster.classid   INNER JOIN tbldivmaster     ON tbl_year_class.divid = tbldivmaster.divid   INNER JOIN tblmozemaster     ON tblmozemaster.mozeid = tblmadrasamaster.mozeid WHERE tblmadrasamaster.madrasaid = ?";
                        $data = $this->db->query($sql, $moze)->result();
                    }
                    
                        break;
                        case 'timetable ':
                     
                    if (!empty($moze)) {
                        $sql ="SELECT   tbl_year_class.yearclassid as classid,   CONCAT(tblclassmaster.classid, '-(', tbldivmaster.divdesc, ')') AS class,   tbltimetable.dayid,   tbltimetable.Fromtime,   tbltimetable.Uptotime,   CONCAT(tblclassmaster.classdesc,'-',tbldivmaster.divdesc) AS classname FROM tbl_year_class   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid   INNER JOIN tblclassmaster     ON tbl_year_class.classid = tblclassmaster.classid   INNER JOIN tbldivmaster     ON tbl_year_class.divid = tbldivmaster.divid   INNER JOIN tblmozemaster     ON tblmozemaster.mozeid = tblmadrasamaster.mozeid   INNER JOIN tbltimetable     ON tbl_year_class.yearclassid = tbltimetable.yearclassid WHERE tblmadrasamaster.madrasaid = ?";
                        $data = $this->db->query($sql, $moze)->result();
                    }
                    
                        break;

                        case 'calender':
                     
                        if (!empty($moze)) {
                            $sql ="SELECT   tbl_year_class.yearclassid as classid,   CONCAT(tblclassmaster.classid, '-(', tbldivmaster.divdesc, ')') AS class,   tbltimetable.dayid,   tbltimetable.Fromtime,   tbltimetable.Uptotime,   CONCAT(tblclassmaster.classdesc,'-',tbldivmaster.divdesc) AS classname FROM tbl_year_class   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid   INNER JOIN tblclassmaster     ON tbl_year_class.classid = tblclassmaster.classid   INNER JOIN tbldivmaster     ON tbl_year_class.divid = tbldivmaster.divid   INNER JOIN tblmozemaster     ON tblmozemaster.mozeid = tblmadrasamaster.mozeid   INNER JOIN tbltimetable     ON tbl_year_class.yearclassid = tbltimetable.yearclassid WHERE tblmadrasamaster.madrasaid = ?";
                            $data = $this->db->query($sql, $moze)->result();
                        }
                        
                            break;

                            case 'settings ':
                     
                            if (!empty($moze)) {
                                $sql ="SELECT   tbl_year_class.yearclassid as classid,   CONCAT(tblclassmaster.classid, '-(', tbldivmaster.divdesc, ')') AS class,   tbltimetable.dayid,   tbltimetable.Fromtime,   tbltimetable.Uptotime,   CONCAT(tblclassmaster.classdesc,'-',tbldivmaster.divdesc) AS classname FROM tbl_year_class   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid   INNER JOIN tblclassmaster     ON tbl_year_class.classid = tblclassmaster.classid   INNER JOIN tbldivmaster     ON tbl_year_class.divid = tbldivmaster.divid   INNER JOIN tblmozemaster     ON tblmozemaster.mozeid = tblmadrasamaster.mozeid   INNER JOIN tbltimetable     ON tbl_year_class.yearclassid = tbltimetable.yearclassid WHERE tblmadrasamaster.madrasaid = ?";
                                $data = $this->db->query($sql, $moze)->result();
                            }
                            
                            break;



                
                case 'perday':
                if (!empty($moze) && !empty($dayid)) {
                    $sql ="SELECT   tblstudentmaster.studentid,   tblstudentmaster.contact,   tblstudentmaster.rfid,   tblstudentmaster.itsid,   tbltimetable.dayid,   tbltimetable.Fromtime,   tbltimetable.Uptotime,   tblstudentmaster.firstname FROM tblstudentmaster   INNER JOIN tbl_student_year_class     ON tblstudentmaster.studentid = tbl_student_year_class.studentid   INNER JOIN tbltimetable     ON tbl_student_year_class.yearclassid = tbltimetable.yearclassid   CROSS JOIN tblmozemaster   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid     AND tblmozemaster.mozeid = tblmadrasamaster.mozeid WHERE tblmadrasamaster.madrasaid = ? AND tbltimetable.dayid = ?" ;
                    $data = $this->db->query($sql, array($moze,$dayid))->result();
                }
                    break;

                case 'itsid':
                    
                if (!empty($itsid)) {
                    $sql ="SELECT   tblstudentmaster.studentid,   tblstudentmaster.contact,   tblstudentmaster.rfid,   tblstudentmaster.itsid,   tbltimetable.dayid,   tbltimetable.Fromtime,   tbltimetable.Uptotime,   tblstudentmaster.firstname FROM tblstudentmaster   INNER JOIN tbl_student_year_class     ON tblstudentmaster.studentid = tbl_student_year_class.studentid   INNER JOIN tbltimetable     ON tbl_student_year_class.yearclassid = tbltimetable.yearclassid   CROSS JOIN tblmozemaster   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid     AND tblmozemaster.mozeid = tblmadrasamaster.mozeid WHERE tblstudentmaster.itsid = ?";
                    $data = $this->db->query($sql, $itsid)->result();
                }
                    break;
                    case 'rfid':
                    if (!empty($rfid)) {
                        $sql ="SELECT   tblstudentmaster.studentid,   tblstudentmaster.contact,   tblstudentmaster.rfid,   tblstudentmaster.itsid,   tbltimetable.dayid,   tbltimetable.Fromtime,   tbltimetable.Uptotime,   tblstudentmaster.firstname FROM tblstudentmaster   INNER JOIN tbl_student_year_class     ON tblstudentmaster.studentid = tbl_student_year_class.studentid   INNER JOIN tbltimetable     ON tbl_student_year_class.yearclassid = tbltimetable.yearclassid   CROSS JOIN tblmozemaster   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid     AND tblmozemaster.mozeid = tblmadrasamaster.mozeid WHERE  tblstudentmaster.rfid = ?";
                        $data = $this->db->query($sql, $rfid)->result();
                    }

                    break;
                    case 'id':
                    if (!empty($id)) {
                        $sql ="SELECT   tblstudentmaster.studentid,   tblstudentmaster.contact,   tblstudentmaster.rfid,   tblstudentmaster.itsid,   tbltimetable.dayid,   tbltimetable.Fromtime,   tbltimetable.Uptotime,   tblstudentmaster.firstname FROM tblstudentmaster   INNER JOIN tbl_student_year_class     ON tblstudentmaster.studentid = tbl_student_year_class.studentid   INNER JOIN tbltimetable     ON tbl_student_year_class.yearclassid = tbltimetable.yearclassid   CROSS JOIN tblmozemaster   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid     AND tblmozemaster.mozeid = tblmadrasamaster.mozeid WHERE  tblstudentmaster.studentid = ?";
                        $data = $this->db->query($sql, $id)->result();
                    }

                    break;
            }
        } else {
            $data =["A"]=""; 
            
        }
   

        $this->response($data, REST_Controller::HTTP_OK);
    }
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();
        $this->db->insert('tblstudentmaster', $input);
     
        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('tblstudentmaster', $input, array('id'=>$id));
     
        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('tblstudentmaster', array('id'=>$id));
       
        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }
}
