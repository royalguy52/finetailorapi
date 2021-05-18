<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Attendance extends REST_Controller
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
    public function index_get($mode=0, $madrasaid=0, $classid=0, $studentid=0, $fromdateid=0, $uptodateid=0, $dateid=0, $morethan=0, $itsids=0, $sms=0)
    {
        if (!empty($mode)) {
            switch ($mode) {

            case 'class':


            if (!empty($classid)) {
                if (!empty($fromdateid) && !empty($uptodateid)) {
                } elseif (!empty($dateid)) {
                } else {
                }
            }
              break;
              
              case 'madrasa':



              if (!empty($madrasaid)) {
                  if (!empty($fromdateid) && !empty($uptodateid)) {
                  } elseif (!empty($morethan)) {
                      $sql="SELECT   tblstudentmaster.studentid,   CONCAT(tblclassmaster.classdesc, '-', tbldivmaster.divdesc) AS class,   tblstudentmaster.itsid,   tblstudentmaster.firstname,   DATE_FORMAT(tblattendance.dateid, '%d-%m-%Y') AS dateid,   tblattendance.attended, tblattendance.late,  tblattendance.id FROM tblstudentmaster   INNER JOIN tbl_student_year_class     ON tblstudentmaster.studentid = tbl_student_year_class.studentid   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid   INNER JOIN tblattendance     ON tblstudentmaster.studentid = tblattendance.studentid   INNER JOIN tblmozemaster     ON tblmozemaster.mozeid = tblmadrasamaster.mozeid   INNER JOIN tblclassmaster      ON tbl_year_class.classid = tblclassmaster.classid   INNER JOIN tbldivmaster     ON tbl_year_class.divid = tbldivmaster.divid WHERE tblmadrasamaster.madrasaid = ? and tblattendance.id>=?;";
                      $data = $this->db->query($sql, array($madrasaid,$morethan))->result();
                  } else {
                  }
              }

                break;


                case 'update':



              if (!empty($madrasaid)) {
                  if (!empty($fromdateid) && !empty($uptodateid)) {
                  } elseif (!empty($morethan)) {
                      $sql="SELECT   tblstudentmaster.studentid,   CONCAT(tblclassmaster.classdesc, '-', tbldivmaster.divdesc) AS class,   tblstudentmaster.itsid,   tblstudentmaster.firstname,   DATE_FORMAT(tblattendance.dateid, '%d-%m-%Y') AS dateid,   tblattendance.attended, tblattendance.late,  tblattendance.id FROM tblstudentmaster   INNER JOIN tbl_student_year_class     ON tblstudentmaster.studentid = tbl_student_year_class.studentid   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid   INNER JOIN tblattendance     ON tblstudentmaster.studentid = tblattendance.studentid   INNER JOIN tblmozemaster     ON tblmozemaster.mozeid = tblmadrasamaster.mozeid   INNER JOIN tblclassmaster      ON tbl_year_class.classid = tblclassmaster.classid   INNER JOIN tbldivmaster     ON tbl_year_class.divid = tbldivmaster.divid WHERE tblmadrasamaster.madrasaid = ? and tblattendance.updated >=?;";
                      $data = $this->db->query($sql, array($madrasaid,$morethan))->result();
                  } else {
                  }
              }

                break;

                case 'checkmadrasa':



              if (!empty($madrasaid)) {
                  $data=$this->checkmadrasa($madrasaid);


                  if (!empty($fromdateid) && !empty($uptodateid)) {
                  } elseif (!empty($morethan)) {
                  } else {
                  }
              }

                break;



                case 'single':

                if (!empty($studentid)) {
                    if (!empty($fromdateid) && !empty($uptodateid)) {
                    } elseif (!empty($dateid)) {
                    } else {
                    }
                }
                break;

                case 'maxupdate':

                $sql="SELECT  MAX(updated) as lastupdated FROM tblattendance"   ;
                $data = $this->db->query($sql, $madrasaid)->result();
                break;


                case 'lastentry':

                $sql="SELECT MAX(id) Lastentry FROM tblattendance"   ;
                $data = $this->db->query($sql, $madrasaid)->result();
                break;

                case 'summary':
                if (!empty($madrasaid)) {
                    //$sql="Select studentid,firstname,class,itsid,   max(case when attended = 'n' then NoOfDays ELSE 0 END) as absent,   max(case when attended = 'y' then NoOfDays ELSE 0 end)AS  present,   SUM(NoOfDays) AS workingdays    from (SELECT   COUNT(tblattendance.attended) AS NoOfDays,   tblattendance.studentid,  tblstudentmaster.itsid, tblattendance.attended,   tblstudentmaster.firstname,   CONCAT(tblclassmaster.classdesc, '-', tbldivmaster.divdesc) AS class FROM tblstudentmaster   INNER JOIN tblattendance     ON tblstudentmaster.studentid = tblattendance.studentid   INNER JOIN tbl_student_year_class     ON tblattendance.studentid = tbl_student_year_class.studentid   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblclassmaster     ON tblclassmaster.classid = tbl_year_class.classid   INNER JOIN tbldivmaster     ON tbldivmaster.divid = tbl_year_class.divid   Where tbl_year_class.madrasaid= ? GROUP BY tblattendance.studentid,          tblattendance.attended,          tblstudentmaster.firstname,          tbldivmaster.divdesc,          tblclassmaster.classdesc      ) AS TABLE1 group by studentid ; "
                    $sql=" SELECT     TABLE1.studentid,     TABLE1.firstname,    TABLE1.class,     TABLE1.itsid,     TABLE1.ClassID,     TABLE2.TotalDays,     Max(Case         When TABLE1.attended = 'n'         Then TABLE1.NoOfDays         ELSE 0     End) As absent,     Max(Case         When TABLE1.attended = 'y'         Then TABLE1.NoOfDays         ELSE 0     End) As present FROM     (SELECT          Count(tblattendance.attended) As NoOfDays,          tblattendance.studentid,          tblstudentmaster.itsid,          tblattendance.attended,          tblstudentmaster.firstname,          tbl_year_class.yearclassid As ClassID,          Concat(tblclassmaster.classdesc, '-', tbldivmaster.divdesc) As class      FROM          tblstudentmaster Inner JOIN          tblattendance On tblstudentmaster.studentid = tblattendance.studentid Inner JOIN          tbl_student_year_class On tblattendance.studentid = tbl_student_year_class.studentid Inner JOIN          tbl_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner JOIN          tblclassmaster On tblclassmaster.classid = tbl_year_class.classid Inner JOIN          tbldivmaster On tbldivmaster.divid = tbl_year_class.divid      WHERE          tbl_year_class.madrasaid = ?      Group BY          tblattendance.studentid,          tblattendance.attended,          tblstudentmaster.firstname,          tbldivmaster.divdesc,          tblclassmaster.classdesc) As TABLE1 Inner JOIN     (SELECT          Max(tblcomplete.NoOfDays) As TotalDays,          tblcomplete.classid As ClassID      FROM          (SELECT               Count(tblattendance.attended) As NoOfDays,               tblstudentmaster.itsid,               tbl_year_class.yearclassid As classid           FROM               tblstudentmaster Inner JOIN               tblattendance On tblstudentmaster.studentid = tblattendance.studentid Inner JOIN               tbl_student_year_class On tblattendance.studentid = tbl_student_year_class.studentid Inner JOIN               tbl_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner JOIN               tblclassmaster On tblclassmaster.classid = tbl_year_class.classid Inner JOIN               tbldivmaster On tbldivmaster.divid = tbl_year_class.divid           WHERE               tbl_year_class.madrasaid = ?           Group BY               tbl_year_class.yearclassid,               tblattendance.studentid) As tblcomplete      Group BY          tblcomplete.classid      Order BY          ClassID) As TABLE2 On TABLE1.ClassID = TABLE2.ClassID Group BY     TABLE1.studentid Order BY     TABLE1.ClassID  ; ";
                    $data = $this->db->query($sql, array($madrasaid,$madrasaid))->result();
                } break;

                case 'summarywithdate':
                  if (!empty($madrasaid)) {
                      if (!empty($fromdateid) && !empty($uptodateid)) {
                          $sql=" SELECT     TABLE1.studentid,     TABLE1.firstname,     TABLE1.class,     TABLE1.itsid,     TABLE1.Classes,     TABLE2.TotalDays,     Max(Case         When TABLE1.attended = 'n'         Then TABLE1.NoOfDays         ELSE 0     End) As absent,     Max(Case         When TABLE1.attended = 'y'         Then TABLE1.NoOfDays         ELSE 0     End) As present FROM     (SELECT          Count(tblattendance.attended) As NoOfDays,          tblattendance.studentid,          tblstudentmaster.itsid,          tblattendance.attended,          tblstudentmaster.firstname,          tbl_year_class.yearclassid As Classes,          Concat(tblclassmaster.classdesc, '-', tbldivmaster.divdesc) As class      FROM          tblstudentmaster Inner JOIN          tblattendance On tblstudentmaster.studentid = tblattendance.studentid Inner JOIN          tbl_student_year_class On tblattendance.studentid = tbl_student_year_class.studentid Inner JOIN          tbl_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner JOIN          tblclassmaster On tblclassmaster.classid = tbl_year_class.classid Inner JOIN          tbldivmaster On tbldivmaster.divid = tbl_year_class.divid      WHERE                tbl_year_class.madrasaid = ? AND               tblattendance.dateid Between ? And ?       Group BY          tblattendance.studentid,          tblattendance.attended,          tblstudentmaster.firstname,          tbldivmaster.divdesc,          tblclassmaster.classdesc) As TABLE1 Inner JOIN     (SELECT          Max(tblcomplete.NoOfDays) As TotalDays,          tblcomplete.classid As ClassID      FROM          (SELECT               Count(tblattendance.attended) As NoOfDays,               tblstudentmaster.itsid,               tbl_year_class.yearclassid As classid           FROM               tblstudentmaster Inner JOIN               tblattendance On tblstudentmaster.studentid = tblattendance.studentid Inner JOIN               tbl_student_year_class On tblattendance.studentid = tbl_student_year_class.studentid Inner JOIN               tbl_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner JOIN               tblclassmaster On tblclassmaster.classid = tbl_year_class.classid Inner JOIN               tbldivmaster On tbldivmaster.divid = tbl_year_class.divid           WHERE                tbl_year_class.madrasaid = ? AND               tblattendance.dateid Between ? And ?           Group BY               tbl_year_class.yearclassid,               tblattendance.studentid) As tblcomplete      Group BY          tblcomplete.classid      Order BY          ClassID) As TABLE2 On TABLE1.Classes = TABLE2.ClassID Group BY     TABLE1.studentid  Order BY     TABLE1.Classes    ;";
                          $data = $this->db->query($sql, array($madrasaid,$fromdateid,$uptodateid,$madrasaid,$fromdateid,$uptodateid))->result();
                      }
                  } break;


                  case 'classlist':
                    if (!empty($madrasaid)) {
                        $sql="Select       tbl_year_class.yearclassid As YearclassID,     Concat(tblclassmaster.classdesc, '-', tbldivmaster.divdesc) As classname,  tblclassmaster.classID as darajah,   tblmadrasamaster.madrasaname,     tblmozemaster.mozename,     tblmadrasamaster.madrasaid From     tbl_year_class Inner Join     tblclassmaster On tblclassmaster.classid = tbl_year_class.classid Inner Join     tbldivmaster On tbldivmaster.divid = tbl_year_class.divid Inner Join     tblmadrasamaster On tblmadrasamaster.madrasaid = tbl_year_class.madrasaid Inner Join     tblmozemaster On tblmozemaster.mozeid = tblmadrasamaster.mozeid Where     tbl_year_class.madrasaid = ? ;";
                        $data = $this->db->query($sql, ($madrasaid))->result();
                    } break;


                    case 'studentattendance':
                      if (!empty($studentid)) {
                          $sql=" Select     tblstudentmaster.firstname,     tblstudentmaster.itsid,     tblattendance.dateid,   tblattendance.intime,     tblattendance.late,     tblattendance.attended From     tblattendance Inner Join     tblstudentmaster On tblstudentmaster.studentid = tblattendance.studentid Where     tblstudentmaster.studentid = ? And  tblattendance.attended='y'    ;";
                          $data = $this->db->query($sql, ($studentid))->result();
                      } break;



                      case 'studentattendancewithdate':
                        if (!empty($studentid)) {
                            if (!empty($fromdateid) && !empty($uptodateid)) {
                                $sql=" Select     tblstudentmaster.firstname,     tblstudentmaster.itsid,     tblattendance.dateid,  tblattendance.intime,    tblattendance.late,     tblattendance.attended From     tblattendance Inner Join     tblstudentmaster On tblstudentmaster.studentid = tblattendance.studentid Where     tblstudentmaster.studentid = ? And     tblattendance.dateid Between ? And ?  And tblattendance.attended='y'    ;";
                                $data = $this->db->query($sql, array($studentid,$fromdateid,$uptodateid))->result();
                            }
                        } break;

                        case 'sms':
                          if (!empty($studentid)) {
                            $data=  $this->send_sms($sms, $studentid);

                              



                          } break;



                  





                case 'classsummary':
                  if (!empty($classid)) {
                      $sql=" SELECT     TABLE1.studentid,     TABLE1.firstname,    TABLE1.class,     TABLE1.itsid,     TABLE1.ClassID,     TABLE2.TotalDays,     Max(Case         When TABLE1.attended = 'n'         Then TABLE1.NoOfDays         ELSE 0     End) As absent,     Max(Case         When TABLE1.attended = 'y'         Then TABLE1.NoOfDays         ELSE 0     End) As present FROM     (SELECT          Count(tblattendance.attended) As NoOfDays,          tblattendance.studentid,          tblstudentmaster.itsid,          tblattendance.attended,          tblstudentmaster.firstname,          tbl_year_class.yearclassid As ClassID,          Concat(tblclassmaster.classdesc, '-', tbldivmaster.divdesc) As class      FROM          tblstudentmaster Inner JOIN          tblattendance On tblstudentmaster.studentid = tblattendance.studentid Inner JOIN          tbl_student_year_class On tblattendance.studentid = tbl_student_year_class.studentid Inner JOIN          tbl_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner JOIN          tblclassmaster On tblclassmaster.classid = tbl_year_class.classid Inner JOIN          tbldivmaster On tbldivmaster.divid = tbl_year_class.divid      WHERE          tbl_year_class.yearclassid = ?      Group BY          tblattendance.studentid,          tblattendance.attended,          tblstudentmaster.firstname,          tbldivmaster.divdesc,          tblclassmaster.classdesc) As TABLE1 Inner JOIN     (SELECT          Max(tblcomplete.NoOfDays) As TotalDays,          tblcomplete.classid As ClassID      FROM          (SELECT               Count(tblattendance.attended) As NoOfDays,               tblstudentmaster.itsid,               tbl_year_class.yearclassid As classid           FROM               tblstudentmaster Inner JOIN               tblattendance On tblstudentmaster.studentid = tblattendance.studentid Inner JOIN               tbl_student_year_class On tblattendance.studentid = tbl_student_year_class.studentid Inner JOIN               tbl_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner JOIN               tblclassmaster On tblclassmaster.classid = tbl_year_class.classid Inner JOIN               tbldivmaster On tbldivmaster.divid = tbl_year_class.divid           WHERE               tbl_year_class.yearclassid = ?           Group BY               tbl_year_class.yearclassid,               tblattendance.studentid) As tblcomplete      Group BY          tblcomplete.classid      Order BY          ClassID) As TABLE2 On TABLE1.ClassID = TABLE2.ClassID Group BY     TABLE1.studentid Order BY     TABLE1.ClassID  ; ";
                      $data = $this->db->query($sql, array($classid,$classid))->result();
                  } break;


                  case 'classsummarywithdate':
                    if (!empty($classid)) {
                        if (!empty($fromdateid) && !empty($uptodateid)) {
                            $sql=" SELECT     TABLE1.studentid,     TABLE1.firstname,     TABLE1.class,     TABLE1.itsid,     TABLE1.Classes,     TABLE2.TotalDays,     Max(Case         When TABLE1.attended = 'n'         Then TABLE1.NoOfDays         ELSE 0     End) As absent,     Max(Case         When TABLE1.attended = 'y'         Then TABLE1.NoOfDays         ELSE 0     End) As present FROM     (SELECT          Count(tblattendance.attended) As NoOfDays,          tblattendance.studentid,          tblstudentmaster.itsid,          tblattendance.attended,          tblstudentmaster.firstname,          tbl_year_class.yearclassid As Classes,          Concat(tblclassmaster.classdesc, '-', tbldivmaster.divdesc) As class      FROM          tblstudentmaster Inner JOIN          tblattendance On tblstudentmaster.studentid = tblattendance.studentid Inner JOIN          tbl_student_year_class On tblattendance.studentid = tbl_student_year_class.studentid Inner JOIN          tbl_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner JOIN          tblclassmaster On tblclassmaster.classid = tbl_year_class.classid Inner JOIN          tbldivmaster On tbldivmaster.divid = tbl_year_class.divid      WHERE               tbl_year_class.yearclassid = ? AND               tblattendance.dateid Between ? And ?       Group BY          tblattendance.studentid,          tblattendance.attended,          tblstudentmaster.firstname,          tbldivmaster.divdesc,          tblclassmaster.classdesc) As TABLE1 Inner JOIN     (SELECT          Max(tblcomplete.NoOfDays) As TotalDays,          tblcomplete.classid As ClassID      FROM          (SELECT               Count(tblattendance.attended) As NoOfDays,               tblstudentmaster.itsid,               tbl_year_class.yearclassid As classid           FROM               tblstudentmaster Inner JOIN               tblattendance On tblstudentmaster.studentid = tblattendance.studentid Inner JOIN               tbl_student_year_class On tblattendance.studentid = tbl_student_year_class.studentid Inner JOIN               tbl_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner JOIN               tblclassmaster On tblclassmaster.classid = tbl_year_class.classid Inner JOIN               tbldivmaster On tbldivmaster.divid = tbl_year_class.divid           WHERE               tbl_year_class.yearclassid = ? AND               tblattendance.dateid Between ? And ?           Group BY               tbl_year_class.yearclassid,               tblattendance.studentid) As tblcomplete      Group BY          tblcomplete.classid      Order BY          ClassID) As TABLE2 On TABLE1.Classes = TABLE2.ClassID Group BY     TABLE1.studentid  Order BY     TABLE1.Classes    ;";
                            $data = $this->db->query($sql, array($classid,$fromdateid,$uptodateid,$classid,$fromdateid,$uptodateid))->result();
                        }
                    } break;
  


                case 'today':
                if (!empty($madrasaid) && !empty($dateid)) {
                    $sql="SELECT   tblstudentmaster.studentid,   CONCAT(tblclassmaster.classdesc, '-', tbldivmaster.divdesc) AS class,   tblstudentmaster.itsid,   tblstudentmaster.firstname,   DATE_FORMAT(tblattendance.dateid, '%d-%m-%Y') AS dateid,   tblattendance.attended, tblattendance.late,  tblattendance.id FROM tblstudentmaster   INNER JOIN tbl_student_year_class     ON tblstudentmaster.studentid = tbl_student_year_class.studentid   INNER JOIN tbl_year_class     ON tbl_student_year_class.yearclassid = tbl_year_class.yearclassid   INNER JOIN tblmadrasamaster     ON tblmadrasamaster.madrasaid = tbl_year_class.madrasaid   INNER JOIN tblattendance     ON tblstudentmaster.studentid = tblattendance.studentid   INNER JOIN tblmozemaster     ON tblmozemaster.mozeid = tblmadrasamaster.mozeid   INNER JOIN tblclassmaster      ON tbl_year_class.classid = tblclassmaster.classid   INNER JOIN tbldivmaster     ON tbl_year_class.divid = tbldivmaster.divid WHERE tblmadrasamaster.madrasaid =? and tblattendance.dateid=?;";
                    $data = $this->db->query($sql, array($madrasaid,$dateid))->result();
                }
               
                break;


              }

           
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([], REST_Controller::HTTP_NO_CONTENT);
        }
    }



    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $studentid=$this->input->post('studentid');
        $dateid = $this->input->post('dateid');
       
        if ($this->checkrecord($studentid, $dateid)) {
            $input = $this->input->post();
            $this->db->update('tblattendance', $input, array('studentid'=>$studentid, 'dateid'=>$dateid));
            $this->response([$studentid,$dateid], REST_Controller::HTTP_OK);
        } else {
            $input = $this->input->post();
            $this->db->insert('tblattendance', $input);
        
            // write sms code here.




            $this->response([$studentid,$dateid], REST_Controller::HTTP_OK);
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
        $this->db->update('tblattendance', $input, array('id'=>$id));
     
        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('tblattendance', array('id'=>$id));
       
        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }
        
    private function checkrecord($studentid, $dateid)
    {
        $data = $this->db->get_where("tblattendance", array('studentid' => $studentid,'dateid'=> $dateid))->row_array();

        return $data;
    }

    private function checkmadrasa($madrasaid)
    {
        $data = $this->db->get_where("tblmadrasamaster", array('madrasaid' => $madrasaid))->result();

        return $data;
    }


    private function send_sms($sms, $studentid)
    {
        $authKey="";
        $mobileNumber ="";
        $senderId ="" ;

        $query = $this->db->query("Select     settingmaster.settingname,     tblstudentmaster.studentid,     settings.value,     tblstudentmaster.contact,     settingmaster.settingid From     settingmaster Inner Join     settings On settings.settingid = settingmaster.settingid Inner Join     tbl_year_class On settings.madrasaid = tbl_year_class.madrasaid Inner Join     tbl_student_year_class On tbl_student_year_class.yearclassid = tbl_year_class.yearclassid Inner Join     tblstudentmaster On tblstudentmaster.studentid = tbl_student_year_class.studentid Where     tblstudentmaster.studentid ={$studentid} and settings.settingid =6    ");

        $row = $query->row();
        if (isset($row)) {
            $authKey =  $row->value;
            $mobileNumber="91{$row->contact}";
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
        $url="http://sms1.almasaarr.com/api/sendhttp.php";
  
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
             return'error:' . curl_error($ch);
        }
  
        curl_close($ch);

  $data["resultabcd"]=$postData;
  $data['output']=$output;
        //return $output;
        return $data; 
    }
}