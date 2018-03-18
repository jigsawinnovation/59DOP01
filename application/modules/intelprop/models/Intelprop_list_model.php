<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intelprop_list_model extends CI_Model {

	var $table = 'wisd_info';
	var $column_order = array('B.pid','C.prename_th','name','B.date_of_birth','A.date_of_reg'); //set column field database for datatable orderable
	// var $column_search = array('B.pid','C.prename_th',"CONCAT(B.pers_firstname_th, ' ', B.pers_lastname_th)",'B.date_of_birth','A.date_of_reg'); //set column field database for datatable searchable
	var $order = array('A.insert_datetime' => 'DESC','A.update_datetime','DESC'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		//$this->db->select("A.*,B.*,C.*,D.*,E.*,F.*,G.*,CONCAT(B.pers_firstname_th, ' ', B.pers_lastname_th) as name");
		$this->db->select("A.knwl_id,A.date_of_reg,A.insert_user_id,A.insert_org_id,A.delete_user_id,A.delete_datetime,
						   B.pers_id,B.pid,B.pren_code,B.pers_firstname_th,B.pers_lastname_th,B.date_of_birth,B.gender_code,B.reg_addr_id,B.delete_user_id,B.delete_datetime,
						   C.prename_th,
						   D.gender_name,
						   E.area_name_th AS name_district,
						   F.area_name_th AS name_province,
						   CONCAT(B.pers_firstname_th, ' ', B.pers_lastname_th) as name");

		$this->db->from($this->table." as A");
		$this->db->join('pers_info as B', 'A.pers_id=B.pers_id', 'left');
		$this->db->join('std_prename as C', 'B.pren_code=C.pren_code', 'left');
		$this->db->join('std_gender as D', 'B.gender_code=D.gender_code', 'left');
		$this->db->join('pers_addr as H', 'B.reg_addr_id=H.addr_id', 'left');
		$this->db->join('std_area as E', 'H.addr_district = E.area_code', 'left');
		$this->db->join('std_area as F', 'H.addr_province = F.area_code', 'left');
		// $this->db->join('std_nationality as E', 'B.nation_code=E.nation_code', 'left');
		//$this->db->join('std_religion as F', 'B.relg_code=F.relg_code', 'left');
		// $this->db->join('std_edu_level as G', 'B.edu_code=G.edu_code', 'left');


    $user_id = get_session('user_id');
		$app_id = 44;
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id);

		 	if($usrpm['perm_view']=='All'){//เห็นข้อมูลทั้งหมด
					$this->db->where("(A.delete_user_id IS NULL AND A.delete_datetime IS NULL) AND
					(B.delete_user_id IS NULL AND B.delete_datetime IS NULL)");
    	}else if($usrpm['perm_view']=='Organization'){//เห็นข้อมูลเฉพาะองค์กรของตนเองเท่านั้น
         	$this->db->where("(A.delete_user_id IS NULL AND A.delete_datetime IS NULL) AND
         		(B.delete_user_id IS NULL AND B.delete_datetime IS NULL) AND A.insert_org_id=".get_session('org_id'));
      }else if($usrpm['perm_view']=='Person'){//เห็นข้อมูลเฉพาะของตนเองเท่านั้น
         	$this->db->where("(A.delete_user_id IS NULL AND A.delete_datetime IS NULL) AND
         		(B.delete_user_id IS NULL AND B.delete_datetime IS NULL) AND A.insert_user_id=".get_session('user_id'));
      }

		foreach ($_POST['columns'] as $colId => $col) {
			if($col['search']['value']!='') // if datatable send POST for search
			{

				$arr = @explode('_', $col['search']['value']);
				// if(count($arr)==3) {
				 // dieArray($arr);
				 // dieFont(count($arr));

				if(count($arr) >= 2){
					  	$this->db->where("(".$col['name']." BETWEEN '".dateChange($arr[0],0)."' AND '".dateChange($arr[1],0)."')");
				}else if($col['name'] == 'D.gender_name'){
						 	$this->db->where($col['name'],$col['search']['value']);
				}else if($col['name'] == 'start_age' ){
							$year_age   = $col['search']['value'];
							$this->db->where("(IF(TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) IS NULL,0,TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE())) >= ".$year_age.")");
				}else if($col['name'] == 'end_age' ){
							$year_age   = $col['search']['value'];
							$this->db->where("(IF(TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE()) IS NULL,0,TIMESTAMPDIFF(YEAR, B.date_of_birth, CURDATE())) <= ".$year_age.")");
				}else if($col['name'] == 'wisd_code' ){
							$wisd_code   = $col['search']['value'];
							$this->db->where("A.knwl_id IN(SELECT wisd_branch.knwl_id FROM `wisd_branch` WHERE wisd_branch.wisd_code IN(0".$wisd_code.")) ");

				}else{
							$this->db->like($col['name'], $col['search']['value']);
				}

			}
		}

		// dieArray($this->db);

/*		if($_POST['search']['value']){
			foreach ($allow as $key => $val) {
				if(stristr($val,$_POST['search']['value']) == true){
					//$this->db->or_where("D_Allow",$key);
				}
			}
		}
*/
		// dieArray($this->db);
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		// if($_POST['length'] != -1){
		// 	 $this->db->limit($_POST['length'], $_POST['start']);
		// }
		$this->db->limit(50, $_POST['start']);
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
		$this->db->from($this->table);
		//$this->db->where("log_type =",'Import');// เพิ่ม where log_type = Import
		return $this->db->count_all_results();
	}

}
