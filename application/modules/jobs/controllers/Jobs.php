<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends MX_Controller {

	function __construct() {
		parent::__construct();
		
		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function getChart(){
    // ini_set('max_execution_time', 800);
    $dataChart = array();
    // $prov = $this->personal_model->getAll_Province();
    $wisdom = $this->common_model->custom_query("SELECT * FROM std_position_type ORDER BY posi_type_code ASC");
    foreach ($wisdom as $key => $row) {
        $dataChart[] = array(
            'jobs_type' => $row['posi_type_title'],
            'value' => $this->db->where('posi_cate_code',$row['posi_type_code'])->from('edoe_job_vacancy')->count_all_results(),
            // 'value' => 10,
        );
    }
    echo json_encode($dataChart);
  }

	public function jobs_list($process_action='View') {
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 151;
		$process_path = 'jobs/jobs_list';
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500(); 
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign In Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] 		= $usrpm;
			$data['user_id'] 	= $user_id;

			///// Search //////
			$search = "";
			if(get_inpost('bt_submit') != ''){
				if(get_inpost('posi_title')!=''){
					if($search == ''){
						$search = " WHERE ";
					}else{
						$search .= " OR ";
					}
					$posi_title = get_inpost('posi_title');
					$search .= "A.posi_title LIKE '%{$posi_title}%'";
				}
				if(get_inpost_arr('date_of_post')!=''){
					if($search == ''){
						$search = " WHERE ";
					}else{
						$search .= " OR ";
					}
					$date_of_post_st = dateChange(get_inpost('date_of_post[st]'),4);
					$date_of_post_ed = dateChange(get_inpost('date_of_post[ed]'),4);
					$search .= "A.date_of_post BETWEEN '{$date_of_post_st}' AND '{$date_of_post_ed}'";
				}
				if(get_inpost('org_title')!=''){
					if($search == ''){
						$search = " WHERE ";
					}else{
						$search .= " OR ";
					}
					$org_title = get_inpost('org_title');
					$search .= "A.org_title LIKE '%{$org_title}%'";
				}
				// dieFont($search);
			}
			///////////////////
			
			$data['jobsList'] =	$this->common_model->custom_query("
				SELECT A.*,B.* FROM edoe_job_vacancy AS A
				JOIN std_position_type AS B ON A.posi_cate_code = B.posi_type_code
				{$search}
				ORDER BY A.date_of_post DESC
			");

			$data['count_jobs'] 	= count($data['jobsList']);
			$data['count_regis'] 	= $this->useful_model->getNumRows('edoe_older_emp_reg');;

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

					/*-- datepicker custom --*/
		      set_css_asset_head('../plugins/bootstrap-datepicker-custom/dist/css/bootstrap-datepicker.css');
		      set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/js/bootstrap-datepicker-custom.js');
		      set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/locales/bootstrap-datepicker.th.min.js');
		      /*-- End datepicker custom--*/

			/*-- Load Datatables for Theme --*/
			set_css_asset_head('../plugins/Static_Full_Version/css/plugins/dataTables/datatables.min.css');
			set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/dataTables/datatables.min.js');
			/*-- End Load Datatables for Theme --*/



  		/*-- Toastr style --*/
  		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
  		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
  		/*-- End Toastr style --*/

  		set_js_asset_footer('jobs_list.js','jobs'); //Set JS 

  		      set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/ion.rangeSlider.min.js'); //Set JS Index.js


			$data['process_action'] = $process_action;	
			$data['content_view'] 	= 'jobs_list';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application 
			$data['head_title'] = $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];
			// dieArray($data);
			$this->template->load('index_page',$data,'jobs');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}	
	}
	public function registered_list($process_action='View') {
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 152;
		$process_path = 'jobs/registered_list';
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500(); 
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign In Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			// $data['diff_info'] = $this->difficult_model->getAll_diffInfo();
			$data['regList'] =	$this->common_model->custom_query("
				SELECT A.*,B.* FROM edoe_older_emp_reg AS A
				JOIN std_expert AS B ON A.exp_code = B.exp_code
			");

			$data['count_jobs'] = $this->useful_model->getNumRows('edoe_job_vacancy');
			$data['count_regis'] = count($data['regList']);
			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			/*-- Load Datatables for Theme --*/
			set_css_asset_head('../plugins/Static_Full_Version/css/plugins/dataTables/datatables.min.css');
			set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/dataTables/datatables.min.js');
			/*-- End Load Datatables for Theme --*/
			/*-- Toastr style --*/
			set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
			set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
			/*-- End Toastr style --*/

			set_js_asset_footer('registered_list.js','jobs'); //Set JS 

			$data['process_action'] = $process_action;	
			$data['content_view'] 	= 'registered_list';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application 
			$data['head_title'] = $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];
			// dieArray($data);
			$this->template->load('index_page',$data,'jobs');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}	
	}
}