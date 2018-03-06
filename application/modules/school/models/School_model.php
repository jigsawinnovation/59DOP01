<?php
	class School_model extends CI_Model {
            var $column_search = array(); //set column field database for datatable searchable

    var $order = array('insert_datetime' => 'DESC','update_datetime','DESC'); // default order
        function __construct() {
            parent::__construct();
        }

        public function getAll_schlInfo() {
            $array_data = $this->common_model->custom_query("SELECT * FROM schl_info WHERE delete_user_id IS NULL AND (delete_datetime IS NULL || delete_datetime = '0000-00-00 00:00:00')");
						//$query = $this->db->get();
		        set_session('last_sql_filtered',$this->db->last_query());
						return $array_data;
        }

        public function getAll_generationInfo($schl_id=0) {
            return $this->common_model->custom_query("SELECT * FROM schl_info_generation WHERE schl_id = {$schl_id}");
        }

        public function edit_generationID($gen_id=0){
             return $this->common_model->query("SELECT * FROM schl_info_generation WHERE gen_id = {$gen_id}")->row_array();
        }

        public function edit_gduID($gen_id=0){
             return $this->common_model->custom_query("SELECT * FROM schl_info_edu WHERE gen_id = {$gen_id}");
        }

        public function get_student($schl_id=0,$gen_id=0){
             return $this->common_model->custom_query("SELECT * FROM schl_info_student LEFT JOIN pers_info ON schl_info_student.pers_id = pers_info.pers_id WHERE schl_info_student.schl_id = {$schl_id} AND schl_info_student.gen_id = {$gen_id}");
        }


        public function getOnce_schlInfo($schl_id=0) {
            return rowArray($this->common_model->custom_query("SELECT * FROM schl_info WHERE schl_id = {$schl_id}"));
        }


        public function get_img($schl_id=0){
            return $this->common_model->custom_query("SELECT * FROM schl_info_photo WHERE schl_id = {$schl_id}");

        }

        public function get_std_model(){
            return $this->common_model->custom_query("SELECT * FROM std_model_school");
        }

        public function edit_std_model($schl_id){
            return $this->common_model->custom_query("SELECT * FROM schl_model WHERE schl_id= {$schl_id}");
        }

        public function get_diffTrouble($diff_id='') {
            $tmp = array();
            $tmp = $this->common_model->get_where_custom('diff_trouble', 'diff_id', $diff_id);
            $tmp = sort_array_with($tmp,'trb_code');
            return $tmp;
        }
        public function get_diffHelp($diff_id='') {
            $tmp = array();
            $tmp = $this->common_model->get_where_custom('diff_help', 'diff_id', $diff_id);
            $tmp = sort_array_with($tmp,'help_code');
            return $tmp;
        }
        public function get_diffHelpGuide($diff_id='') {
            $tmp = array();
            $tmp = $this->common_model->get_where_custom('diff_help_guide', 'diff_id', $diff_id);
            $tmp = sort_array_with($tmp,'help_guide_code');
            return $tmp;
        }

/*        public function getOnce_diffInfo($diff_id=0) {
            return rowArray($this->common_model->get_where_custom('diff_info', 'diff_id', $diff_id));
        }
*/

        public function getAll_reqChanel() {
            return $this->common_model->getTableOrder('std_req_channel', 'chn_id', 'ASC');
        }

        public function getOnce_reqChanel($chn_code='') {
            return rowArray($this->common_model->get_where_custom('std_edu_level', 'chn_code', $chn_code));
        }

        public function get_std_schl_course($crse_id=''){
            return $this->common_model->query("SELECT * FROM std_schl_course WHERE crse_id ={$crse_id}")->row_array();

        }

        public function getAll_CenterInfo($id = '') {
            if ($id != ''){
                $query = $this->common_model->query("SELECT * FROM schl_qlc_info WHERE qlc_id ={$id} AND delete_user_id IS NULL AND (delete_datetime IS NULL || delete_datetime = '0000-00-00 00:00:00')");

                $data = $query->row_array();
                return $data;
            }else{
                return $this->common_model->custom_query("SELECT * FROM schl_qlc_info WHERE delete_user_id IS NULL AND (delete_datetime IS NULL || delete_datetime = '0000-00-00 00:00:00')");
            }

        }


    private function _get_datatables_query()
    {
        $this->db->select("*");
        $this->db->from('schl_qlc_info');

        // $this->db->join('pers_info as C', 'A.req_pers_id=C.pers_id', 'left');


        $user_id = get_session('user_id');
        $app_id = 59;
        $usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id);

         if($usrpm['perm_view']=='All'){//เห็นข้อมูลทั้งหมด
            $this->db->where("(delete_user_id IS NULL AND delete_datetime IS NULL)");
         }else if($usrpm['perm_view']=='Organization'){//เห็นข้อมูลเฉพาะองค์กรของตนเองเท่านั้น
            $this->db->where("(delete_user_id IS NULL AND delete_datetime IS NULL) AND insert_org_id=".get_session('org_id'));

         }else if($usrpm['perm_view']=='Person'){//เห็นข้อมูลเฉพาะของตนเองเท่านั้น
            $this->db->where("(delete_user_id IS NULL AND delete_datetime IS NULL)  AND insert_user_id=".get_session('user_id'));
         }

        foreach ($_POST['columns'] as $colId => $col) {
            if($col['search']['value']) // if datatable send POST for search
            {
                $arr = @explode('/', $col['search']['value']);
                if(count($arr) > 2){
                    $this->db->like($col['name'], dateChange($col['search']['value'],0));
                    // $this->db->like($col['name'], $col['search']['value']);
                    // dieFont(dateChange($col['search']['value'],1));
                }else{
                    $this->db->like($col['name'], $col['search']['value']);
                }
            }
        }

        // dieArray($this->db);

/*      if($_POST['search']['value']){
            foreach ($allow as $key => $val) {
                if(stristr($val,$_POST['search']['value']) == true){
                    //$this->db->or_where("D_Allow",$key);
                }
            }
        }
*/
        // dieArray($this->db);
/*      if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }*/
        if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        //$this->db->where("log_type =",'Import');// เพิ่ม where log_type = Import
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        //$this->db->where("log_type =",'Import');// เพิ่ม where log_type = Import

        $query = $this->db->get();

        set_session('last_sql_filtered',$this->db->last_query()); //

        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('schl_qlc_info');
        //$this->db->where("log_type =",'Import');// เพิ่ม where log_type = Import
        return $this->db->count_all_results();
    }
  //องค์ประกอบ
        public function getAll_Center_qlc() {
            $data = array();
            $group = $this->common_model->custom_query("SELECT * FROM std_qlc_kpi GROUP BY qlc_kpi_grp");
            foreach ($group as $key => $value) {
                $data[$value['qlc_kpi_id']]['title'] = $value;
            //    $data[$value['qlc_kpi_id']]['title'] = $value['qlc_kpi_grp'];
                $list = $this->common_model->custom_query("SELECT * FROM std_qlc_kpi WHERE qlc_kpi_grp = '{$value['qlc_kpi_grp']}'");
                $data[$value['qlc_kpi_id']]['data'] = $list;
            }

             return  $data;
        }



    }
?>
