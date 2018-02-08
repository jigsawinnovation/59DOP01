<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_list_model extends CI_Model {

	var $table = 'impv_place_info as A';
	var $column_order = array('A.ptype_code_remark','A.date_of_svy','A.consi_result','A.date_of_finish','A.case_budget'); //set column field database for datatable orderable
	
	var $column_search = array('A.ptype_code_remark','A.date_of_svy','A.consi_result','A.date_of_finish','A.case_budget'); //set column field database for datatable searchable

	var $order = array('A.insert_datetime' => 'DESC','A.update_datetime','DESC'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->select("A.*");
		$this->db->from($this->table);

		// $this->db->join('pers_info as B', 'A.pers_id=B.pers_id', 'left');
		// $this->db->join('pers_info as C', 'A.req_pers_id=C.pers_id', 'left');

		$user_id = get_session('user_id');
		$app_id = 36;
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id);
		
		 if($usrpm['perm_view']=='All'){//เห็นข้อมูลทั้งหมด
			$this->db->where("(A.delete_user_id IS NULL AND A.delete_datetime IS NULL) ");
         }else if($usrpm['perm_view']=='Organization'){//เห็นข้อมูลเฉพาะองค์กรของตนเองเท่านั้น
         	$this->db->where("(A.delete_user_id IS NULL AND A.delete_datetime IS NULL) AND A.insert_org_id=".get_session('org_id'));

         }else if($usrpm['perm_view']=='Person'){//เห็นข้อมูลเฉพาะของตนเองเท่านั้น
         	$this->db->where("(A.delete_user_id IS NULL AND A.delete_datetime IS NULL) AND A.insert_user_id=".get_session('user_id'));
         }

		//$this->column_search = array_diff($this->column_search, array('D_DateTimeAdd', 'D_DateTimeUpdate'));

		// $i = 0;
		// foreach ($this->column_search as $item) // loop column 
		// {
		// 	if($_POST['search']['value']) // if datatable send POST for search
		// 	{			
		// 		if($i===0) // first loop
		// 		{
		// 			$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
		// 			$this->db->like($item, $_POST['search']['value']);
		// 		}
		// 		else
		// 		{
		// 			$this->db->or_like($item, $_POST['search']['value']);
		// 		}
		// 		if(count($this->column_search) - 1 == $i) //last loop
		// 			$this->db->group_end(); //close bracket		
		// 	}
		// 	$i++;
		// }

		// dieArray($_POST);
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

/*		if($_POST['search']['value']){
			foreach ($allow as $key => $val) {
				if(stristr($val,$_POST['search']['value']) == true){
					//$this->db->or_where("D_Allow",$key);
				}
			}
		}
*/
		// dieArray($this->db);
/*		if(isset($_POST['order'])) // here order processing
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
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		//$this->db->where("log_type =",'Import');// เพิ่ม where log_type = Import
		return $this->db->count_all_results(); 
	}

}
