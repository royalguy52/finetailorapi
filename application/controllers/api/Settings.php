<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Settings extends REST_Controller
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
    public function index_get($mode = 0, $settingid = 0, $madrasaid=0)
    {
        if (!empty($mode)) {
            switch ($mode) {
                case 'getallsettings':
                     
                if (!empty($madrasaid)) {
                    $sql =" ?";
                    $data = $this->db->query($sql, $madrasaid)->result();
                }
                break;


                case 'getone':
                     
                if (!empty($madrasaid) && !empty($settingid)) {
                    $sql ="  ??";
                    $data = $this->db->query($sql, array($madrasaid,$settingid))->result();
                }
                break;


                
            }
        } else {
            $data =['No data found']; //$this->db->get("tblstudentmaster")->result();
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
        $settingid=$this->input->post('settingid');
        $madrasaid=$this->input->post('madrasaid');
       
        if ($this->checkrecord($settingid, $madrasaid)) {
            $input = $this->input->post();
            $this->db->update('settings', $input, array('setting'=>$settingid, 'madrasaid'=>$madrasaid));
            $this->response([$settingid,$madrasaid], REST_Controller::HTTP_OK);
        } else {
            $input = $this->input->post();
            $this->db->insert('settings', $input);
            $this->response([$settingid,$madrasaid], REST_Controller::HTTP_OK);
        }
    }

    private function checkrecord($settingid, $madrasaid)
    {
        $data = $this->db->get_where("settings", array('settingid' => $settingid,'madrasaid'=> $madrasaid))->row_array();

        return $data;
    }
}
