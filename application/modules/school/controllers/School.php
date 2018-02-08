  <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School extends MX_Controller {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function school_list($process_action='View') { // ตารางข้อมูล
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 58;
		$process_path = 'school/school_list';
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

			$data['schl_info'] = $this->school_model->getAll_schlInfo();

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
			
			/*-- datepicker custom --*/
		      set_css_asset_head('../plugins/bootstrap-datepicker-custom/dist/css/bootstrap-datepicker.css');
		      set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/js/bootstrap-datepicker-custom.js');
		      set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/locales/bootstrap-datepicker.th.min.js');
		      /*-- End datepicker custom--*/
      
			set_js_asset_footer('school_list.js','school'); //Set JS Index.js

			set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/ion.rangeSlider.min.js'); //Set JS Index.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'school_list';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page',$data,'school');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}


	public function date_check($str) {

		$arr = explode('-', $str);

		if(count($arr)==3) {
			if(checkdate($arr[1],$arr[0],$arr[2])){
				return true;
			}
			else{
				return false;
			}
		}else return false;
	}

	private function clr_schlInfo_center() {
		return array(

					'qlc_name' => '',	
					'addr_sub_district'	=> '',
					'addr_district' => '',
					'addr_province' => '',
					'addr_gps' => '',
					'tel_no' => '',
					'fax_no' => '',
					'email_addr' => '',
					'agency_org' => ''	
		);
	}

		private function clr_schlInfo_school1() {
		return array(
					'schl_name'         	 => '',
					'date_of_established'  	 => '',
					'month_of_established' 	 => '',
					'year_of_established'  	 => '',
					'addr_home_no'      	 => '',
					'addr_moo'          	 => '',
					'addr_alley'        	 => '',
					'addr_lane'         	 => '',
					'addr_road'         	 => '',
					'addr_sub_district' 	 => '',
					'addr_district'     	 => '',
					'addr_province'     	 => '',
					'addr_zipcode'      	 => '',
					'addr_gps'          	 => '',
					'tel_no'       	 		 => '',
					'fax_no'            	 => '',
					'email_addr'        	 => '',
					'agency_org'        	 => ''
									
		);
	}

	public function school1($process_action='Add',$schl_id=0) { //แบบขึ้นทะเบียน (โรงเรียน)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 59;
		$process_path = 'school/school1';
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500();
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			 /*-- datepicker --*/
            set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
            set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
            /*-- End datepicker --*/

            /*-- Toastr style --*/
            set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
            set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
            /*-- End Toastr style --*/

            set_css_asset_head('../plugins/Static_Full_Version/css/plugins/jasny/jasny-bootstrap.min.css');
            set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/jasny/jasny-bootstrap.min.js');

            /*-- select2 style --*/
            set_css_asset_head('../plugins/Static_Full_Version/css/plugins/select2/select2.min.css');
            set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/select2/select2.full.min.js');
            /*-- End select2 style --*/

            set_js_asset_footer('mapmarker.js','webconfig'); //Set JS mapmarker.js --
            
			
			set_js_asset_footer('school1.js','school'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'school1';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				$data['schl_info'] = $this->clr_schlInfo_school1();
                $data['std_model'] = $this->school_model->get_std_model();//แสดงคุณสมบัติต้นแบบ
				$this->template->load('index_page',$data,'school');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form

					//dieArray($_POST);

					$data_insert 					= array();
				    $data_insert 					= @get_inpost_arr('schl_info');

				    // dieArray($data_insert);
				    $data_insert['insert_user_id'] 	= getUser();
					$data_insert['insert_org_id'] 	= get_session('org_id');
					$data_insert['insert_datetime'] = getDatetime();

					$id = $this->common_model->insert('schl_info',$data_insert);

					$tmp_cnt_name   = @get_inpost_arr('schl_contacts[sch_cnt_name]');//ชื่อ-นามสกุลเจ้าหน้าที่
					$tmp_cnt_title  = @get_inpost_arr('schl_contacts[sch_cnt_title]');//ตำแหน่งงาน
					$tmp_mobile     = @get_inpost_arr('schl_contacts[tel_no_mobile]');//เบอร์ตืดต่อ
					$tmp_model      = @get_inpost_arr('std_model');//คุณสมบัติโรงเรียนต้นแบบ
					$tmp_mdl_remark = @get_inpost_arr('mdl_remark');//ความคิดเห็นเจ้าหน้าที่

					if(!empty($tmp_model)){
						 foreach ($tmp_model as $key_model => $val_model) {
						 	     
						 	     $insert_model = array('schl_id'     => $id,
                                                       'mdl_code'   => $val_model,
                                                       'mdl_remark' => $tmp_mdl_remark[$key_model] 
						 	     	                  );
						 	     $this->common_model->insert('schl_model',$insert_model);
						 }
					}

					if(!empty($tmp_cnt_name)){
						
                       foreach ($tmp_cnt_name as $key => $value) {
                            $insert_contacts = array('sch_id'        => $id,
                            	                     'sch_cnt_name'  => $value,
                             	                     'sch_cnt_title' => $tmp_cnt_title[$key],
                             	                     'tel_no_mobile' => $tmp_mobile[$key]
                             	                     );
                            $this->common_model->insert('schl_info_contacts',$insert_contacts);
                       }//close loop foreach ($tmp_cnt_name as $key => $value)
                       //dieArray($_POST);
					}



					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('school/photo2/Edit/'.$id,'refresh');

				
			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				 if($schl_id!=''){

						  $schl_info = $this->school_model->getOnce_schlInfo($schl_id);
		                    
		                 if(isset($schl_info['schl_id'])) {
		                    foreach ($schl_info as $key => $value) {
		                    	$data['schl_info'][$key] = $value;
		                    	$data['std_model'] = $this->school_model->get_std_model();//แสดงคุณสมบัติต้นแบบ
		                    }
		                  }



		                    $data['edit_model'] = $this->school_model->edit_std_model($schl_id);//แก้ไขคุณสมบัติโรงเรียนต้นแบบ
		                    $data['schl_contacts'] = $this->common_model->custom_query("SELECT * FROM schl_info_contacts WHERE sch_id = {$schl_id}");
						    // = ;
							// dieArray($data);
							$this->template->load('index_page',$data,'school');

				 }else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				 }

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
                    
				    $data_insert 					= array();
				    $data_insert 					= @get_inpost_arr('schl_info');
				    $data_insert['update_user_id'] 	= getUser();
					$data_insert['update_org_id'] 	= get_session('org_id');
					$data_insert['update_datetime'] = getDatetime();

					 $this->common_model->update('schl_info',$data_insert,array('schl_id'=>$schl_id));
                    
                    $update_contacts = @get_inpost_arr('update_contacts');//จำนวนเจ้าหน้าที่ที่มีการเพิ่มอยู่แล้ว
					$tmp_cnt_name    = @get_inpost_arr('schl_contacts[sch_cnt_name]');//ชื่อ-นามสกุลเจ้าหน้าที่
					$tmp_cnt_title   = @get_inpost_arr('schl_contacts[sch_cnt_title]');//ตำแหน่งงาน
					$tmp_mobile      = @get_inpost_arr('schl_contacts[tel_no_mobile]');//เบอร์ตืดต่อ
					$tmp_model       = @get_inpost_arr('std_model');//แสดงคุณสมบัติต้นแบบ
					$tmp_mdl_remark  = @get_inpost_arr('mdl_remark');//ความคิดเห็นเจ้าหน้าที่

					
						$this->common_model->delete_where("schl_model",'schl_id',$schl_id);
                    if(!empty($tmp_model)){
						foreach ($tmp_model as $key_model => $val_model) {

							    $insert_model = array('schl_id'     => $schl_id,
                                                       'mdl_code'   => $val_model,
                                                       'mdl_remark' => $tmp_mdl_remark[$key_model] 
						 	     	                  );
						 	     $this->common_model->insert('schl_model',$insert_model);
						}
					}

					if(!empty($tmp_cnt_name)){
						
                       foreach ($tmp_cnt_name as $key => $value) {
                       	     
                       	     if(!empty($update_contacts[$key])){
                       	     	  $data_contacts = array('sch_cnt_name'  => $value,
                             	                     	   'sch_cnt_title' => $tmp_cnt_title[$key],
                             	                     	   'tel_no' => $tmp_mobile[$key]
                             	                           );
                       	     	                
                       	     	  $this->common_model->update('schl_info_contacts',$data_contacts,array('sch_cnt_id'=>$update_contacts[$key]));
                       	     }else{
		                          $insert_contacts = array('sch_id'        => $schl_id,
		                            	                   'sch_cnt_name'  => $value,
		                             	                   'sch_cnt_title' => $tmp_cnt_title[$key],
		                             	                   'tel_no' => $tmp_mobile[$key]
		                             	                    );
		                          $this->common_model->insert('schl_info_contacts',$insert_contacts);
                            }
                       }//close loop foreach ($tmp_cnt_name as $key => $value)
                       //dieArray($_POST);
					}

				    $this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('school/school1/Edit/'.$schl_id,'refresh');
			

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				 //Delete process
                $data_update                    = array();
                $data_update['delete_user_id']  = getUser();
                $data_update['delete_org_id']   = get_session('org_id');
                $data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('schl_info',$data_update,array('schl_id'=>$schl_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('school/school_list','refresh');
			}else {
				page500();
				$this->template->load('index_page',$data,'difficult');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function photo2($process_action='Add',$schl_id=0) { //แบบขึ้นทะเบียน (ภาพถ่าย)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 60;
		$process_path = 'school/photo2';
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500();
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			/*-- datepicker --*/
			set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
			set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
			/*-- End datepicker --*/

    		/*-- Toastr style --*/
    		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
    		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
    		/*-- End Toastr style --*/

    		set_css_asset_head('../modules/school/css/gallery_img.css');
    	    set_js_asset_footer('photo2.js','school'); //Set JS sufferer_form1.js


			$data['process_action'] = $process_action;
			$data['content_view'] = 'photo2';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			// dieArray($usrpm);
			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
			    
				$this->template->load('index_page',$data,'school');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('diff_info[date_of_req]','วันที่แจ้งเรื่อง','required|callback_date_check');

				if(get_inpost('rd_pers_id')==1) {
					$frm->set_rules('diff_info[pers_id]','เลขประจำตัวประชาชน','required');
				}

				$frm->set_rules('diff_info[elder_firstname]','ชื่อตัว','required');
				$frm->set_rules('diff_info[elder_lastname]','ชื่อสกุล','required');

				if(get_inpost('rd_req_pers_id')==1) {
					$frm->set_rules('diff_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
				}

				$frm->set_rules('diff_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
				$frm->set_rules('diff_info[req_channel]','ช่องทางการรับแจ้ง','required');

				$frm->set_rules('diff_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				$frm->set_rules('diff_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_insert = $_POST['diff_info'];
					$data_insert['date_of_req'] = dateChange($data_insert['date_of_req'],4);
					$data_insert['insert_user_id'] = getUser();
					$data_insert['insert_datetime'] = getDatetime();

					$data_insert['date_of_visit'] = dateChange($data_insert['date_of_visit'],4);

					$this->common_model->insert('diff_info',$data_insert);
					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					if(get_inpost('state')==1) {
						$data['diff_info'] = $this->clr_diffInfo_form1();
						$data['rd_pers_id'] = '';
						$data['rd_req_pers_id'] = '';
					}else {
						redirect('difficult/assist_list','refresh');
					}

				}else {
					$data['diff_info'] = $_POST['diff_info'];
					$data['rd_pers_id'] = set_value('rd_pers_id');
					$data['rd_req_pers_id'] = set_value('rd_req_pers_id');
					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012
					$this->template->load('index_page',$data,'difficult');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				if($schl_id!=''){
				$data['schl_photo'] = $this->school_model->get_img($schl_id);
				$data['schl_id'] = $schl_id;
				// dieArray($row);
				
					$this->template->load('index_page',$data,'school');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				   
                 if($_FILES['img']['name'][0]!=""){

                 	  $photo = $this->files_model->getMultiImg("img",'assets/modules/school/images');

                 	
                 	 	      $i=0;      		
					        foreach ($photo as $key_photo => $value_photo) {

					        	if($_FILES['img']['name'][$i]!=""){
					        	  
		                           	$insert_photo = array('schl_id' 		      =>$schl_id,
			                           		        	  'schl_photo_file' 	  =>$value_photo['file'],
			                           		        	  'schl_photo_label' 	  =>$value_photo['name'],
			                           		        	  'schl_photo_size'       =>$_FILES['img']['size'][$i],
			                           		        	  'schl_photo_default'    =>"");

		                           	$this->common_model->insert('schl_info_photo',$insert_photo);
		                           
		                           }
	                         $i++;
                           }// close loop foreach ($id_photo as $key_photo => $value_photo)
                       
                 }
					
					/*$data['msg'] = setMsg('021'); //Set Message code 021
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
                    */
					

			
					
					
					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				    $this->template->load('index_page',$data,'school');
				    redirect('school/generation3/Edit/'.$schl_id,'refresh');
          
			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				$data_update = array();
				$data_update['delete_user_id'] = getUser();
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('difficult/assist_list','refresh');
			}else {
				page500();
				$this->template->load('index_page',$data,'difficult');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}


	public function generation3($process_action='Add',$schl_id=0,$gen_id=0) { //แบบขึ้นทะเบียน (รุ่น/หลักสูตร) หน้าแสดง
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 61;
		$process_path = 'school/generation3';
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500();
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			$data['generation_info'] = $this->school_model->getAll_generationInfo($schl_id);

			$this->load->library('template',
									array('name'=>'admin_template1',
										  'setting'=>array('data_output'=>''))
			); // Set Template

				/*-- datepicker --*/
			set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
			set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
				/*-- End datepicker --*/

			set_css_asset_head('../plugins/Static_Full_Version/css/plugins/dataTables/datatables.min.css');
			set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/dataTables/datatables.min.js');

    		/*-- Toastr style --*/
    		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
    		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
    		/*-- End Toastr style --*/
			set_js_asset_footer('generation3.js','school'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view']   = 'generation3';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title']      = $usrpm['app_name'];
			$data['schl_id']    = $schl_id;

			$data['csrf'] = array(
				                   'name' => $this->security->get_csrf_token_name(),
									'hash' => $this->security->get_csrf_hash()
			);

			// dieArray($usrpm);
			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
			    
			  page500();
			  $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
				page500();
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log

               				
			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				if($schl_id!=''){
				$data['schl_gen'] = $this->school_model->getAll_generationInfo($schl_id);
				$data['schl_id'] = $schl_id;
				// dieArray($row);
				
					$this->template->load('index_page',$data,'school');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				         						
					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				    $this->template->load('index_page',$data,'school');
				    redirect('school/photo2/Edit/'.$schl_id,'refresh');
          
			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				  
				$this->common_model->delete_where('schl_info_generation','gen_id',$gen_id);
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('school/generation3/Edit/'.$schl_id,'refresh');
			}else {
				page500();
				$this->template->load('index_page',$data,'school');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}



	public function generation_detail($process_action='Add',$schl_id=0,$gen_id=0) { //แบบขึ้นทะเบียน (รุ่น/หลักสูตร)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 61;
		$process_path = 'school/generation_detail';
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500();
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			//$data['diff_info'] = $this->school_model->getAll_diffInfo();

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			/*-- datepicker --*/
			set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
			set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
			/*-- End datepicker --*/

    		/*-- Toastr style --*/
    		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
    		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
         //swicth on-off

    		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/jasny/jasny-bootstrap.min.css');
            set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/jasny/jasny-bootstrap.min.js');


		    set_css_asset_head('../modules/school/css/swicthon.css');
    		/*-- End Toastr style --*/
    		set_js_asset_footer('webservice.js','personals'); //Set JS sufferer_form1.js 
    		set_js_asset_footer('generation_detail.js','school'); //Set JS sufferer_form1.js


			$data['process_action'] = $process_action;
			$data['content_view'] = 'generation_detail';

			
			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title']      = $usrpm['app_name'];
			$data['schl_id']    = $schl_id;

			$data['csrf'] = array(
				                   'name' => $this->security->get_csrf_token_name(),
									'hash' => $this->security->get_csrf_hash()
			);

			// dieArray($usrpm);
			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
			      if($schl_id!=""){

                     $data['schl_gen'] = array('schl_id'       =>$schl_id,
                     	                       'gen_code'      =>'',
                     	                       'year_of_study' =>'',
                                                'gen_status'   =>'เปิด');
                     $data['schl']   = $schl_id;
                     $data['gen_id'] = '';
                     $this->template->load('index_page',$data,'school');
                     $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success');

			      }else{
			      	 page500();
					 $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			      }
			       
			   
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
				
                if($schl_id!=""){

                     if(get_inpost('schl_gen[gen_status]')==''){
                        $status = "ปิด";
                    
                     }else{
                        $status = "เปิด";
                     }

                      $insert_gen = array('schl_id'      => $schl_id,
                     	                 'gen_code'      => get_inpost('schl_gen[gen_code]'),
                     	                 'date_of_start' => get_inpost('schl_gen[date_of_start]'),
                     	                 // 'gen_status'    => $status
                     	                 );

                     $id = $this->common_model->insert('schl_info_generation',$insert_gen);

                     // $tmp_edu      = get_inpost_arr('schl_info_edu[crse_code]');//จำนวนหลักสูตร
                     // $tem_identify = get_inpost_arr('schl_info_edu[crse_identify]');//ความคิดเห็นเจ้าหน้าที่
                     
                     // if(!empty($tmp_edu)){
                     // 	foreach ($tmp_edu as $key => $crse_id) {
                     // 	$data_edu = $this->school_model->get_std_schl_course($crse_id);
                        

                     // 	   if($tem_identify[$key]!=''){
                     // 	   	  $comment = $tem_identify[$key];
                     // 	   }else{
                     // 	   	  $comment = $data_edu['crse_title'];
                     // 	   }
                     	  
                     // 	   $insert_edu =array('gen_id'         => $id,
                     // 	   	                  'crse_code'      => $data_edu['crse_code'],
                     // 	   	                  'crse_identify'  => $comment,
                     // 	   	                  'crse_objective' => $data_edu['crse_objective'],
                     // 	   	                  'crse_contents'  => $data_edu['crse_contents'],
                     // 	   	                  'hours_per_week' => $data_edu['hours_per_week'],
                     // 	   	                  'att_file'       => $data_edu['att_file'],
                     // 	   	                  'att_label'      => $data_edu['att_label'],
                     // 	   	                  'att_size'       => $data_edu['att_size']
                     // 	   	                 );
                     // 	    $this->common_model->insert('schl_info_edu',$insert_edu);
                     // 	}
                     // }
                    redirect('school/generation3/Edit/'.$schl_id,'refresh');
			      }else{
			      	 page500();
					 $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			      }
               				
			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				if(($schl_id!='')&&($gen_id!='')){
				    
                  
				    $data['schl_gen'] = $this->school_model->edit_generationID($gen_id);
                    $data['schl']     = $schl_id;
                    $data['gen_id']   = $gen_id;
				    
					$this->template->load('index_page',$data,'school');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
                           
				    if(($schl_id!='')&&($gen_id!='')){
				      
				      //dieArray($_POST);
				    	if(get_inpost('schl_gen[gen_status]')==''){
                          $status = "ปิด";
                    
                        }else{
                          $status = "เปิด";
                        }

                      $update_gen = array('schl_id'      => $schl_id,
                     	                 'gen_code'      => get_inpost('schl_gen[gen_code]'),
                     	                 'year_of_study' => get_inpost('schl_gen[year_of_study]'),
                     	                 'gen_status'    => $status
                     	                 );
	   
                      $this->common_model->update('schl_info_generation',$update_gen,array('gen_id'=>$gen_id));
				      
				     // $tmp_edu     = get_inpost_arr('schl_info_edu[crse_code]');//จำนวนหลักสูตร
                     // $tem_identify = get_inpost_arr('schl_info_edu[crse_identify]');//ความคิดเห็นเจ้าหน้าที่
                     // $tem_update_edu = get_inpost_arr('edit_gduID');//จำนวนหลักสูตร ของการอัพเดท
                      
                     
				      // if(!empty($tmp_edu)){

          //            	foreach ($tmp_edu as $key => $crse_id) {
          //            	$data_edu = $this->school_model->get_std_schl_course($crse_id);
                        

          //            	   if($tem_identify[$key]!=''){
          //            	   	  $comment = $tem_identify[$key];
          //            	   }else{
          //            	   	  $comment = $data_edu['crse_title'];
          //            	   }

          //            	   if(isset($tem_update_edu[$key])){
                               
          //                      $update_edu =array('gen_id'         => $gen_id,
	         //             	   	                  'crse_code'      => $data_edu['crse_code'],
	         //             	   	                  'crse_identify'  => $comment,
	         //             	   	                  'crse_objective' => $data_edu['crse_objective'],
	         //             	   	                  'crse_contents'  => $data_edu['crse_contents'],
	         //             	   	                  'hours_per_week' => $data_edu['hours_per_week'],
	         //             	   	                  'att_file'       => $data_edu['att_file'],
	         //             	   	                  'att_label'      => $data_edu['att_label'],
	         //             	   	                  'att_size'       => $data_edu['att_size']
	         //             	   	                 );
	         //             	    $this->common_model->update('schl_info_edu',$update_edu,array('edu_id'=>$tem_update_edu[$key]));

          //            	   }else{
                     	  
	         //             	   $insert_edu =array('gen_id'         => $gen_id,
	         //             	   	                  'crse_code'      => $data_edu['crse_code'],
	         //             	   	                  'crse_identify'  => $comment,
	         //             	   	                  'crse_objective' => $data_edu['crse_objective'],
	         //             	   	                  'crse_contents'  => $data_edu['crse_contents'],
	         //             	   	                  'hours_per_week' => $data_edu['hours_per_week'],
	         //             	   	                  'att_file'       => $data_edu['att_file'],
	         //             	   	                  'att_label'      => $data_edu['att_label'],
	         //             	   	                  'att_size'       => $data_edu['att_size']
	         //             	   	                 );
	         //             	    $this->common_model->insert('schl_info_edu',$insert_edu);
	         //             	  }
          //            	   }

          //            }
				      
				      redirect('school/generation_detail/Edit/'.$schl_id.'/'.$gen_id);
					
				  }else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				  }

                 
									
					/*$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				    $this->template->load('index_page',$data,'school');
				    redirect('school/photo2/Edit/'.$schl_id,'refresh');*/
          
			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				/*$data_update = array();
				$data_update['delete_user_id'] = getUser();
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('difficult/assist_list','refresh');*/
			}else {
				page500();
				$this->template->load('index_page',$data,'school');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}
 }

 public function participant($process_action='Add',$schl_id=0,$gen_id=0,$stu_id=0) { // (ผู้สูงอายุที่เข้าร่วม)
	 $data = array(); //Set Initial Variable to Views
	 /*-- Initial Data for Check User Permission --*/
	 $user_id = get_session('user_id');
	 $app_id = 61;
	 $process_path = 'school/participant';
	 /*--END Inizial Data for Check User Permission--*/

	 $this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
	 $usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

	 if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
		 page500();
		 $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
	 }else {
		 $app_name = $usrpm['app_name'];
		 $data['usrpm'] = $usrpm;
		 $data['user_id'] = $user_id;
         
         $tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title']      = $usrpm['app_name'];
			$data['schl_id']    = $schl_id;
		 

		 $this->load->library('template',
			 array('name'=>'admin_template1',
					 'setting'=>array('data_output'=>''))
		 ); // Set Template

		 /*-- datepicker --*/
		 set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
		 set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
		 /*-- End datepicker --*/
		 /*-- Load Datatables for Theme --*/
		 set_css_asset_head('../plugins/Static_Full_Version/css/plugins/dataTables/datatables.min.css');
		 set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/dataTables/datatables.min.js');

		 /*-- Toastr style --*/
		 set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
		 set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
		 //swicth on-off


			 /*-- End Toastr style --*/
		 set_js_asset_footer('participant.js','school'); //Set JS sufferer_form1.js

		 $data['process_action'] = $process_action;
		 $data['content_view'] = 'participant';

		 $data['csrf'] = array(
				                'name' => $this->security->get_csrf_token_name(),
							    'hash' => $this->security->get_csrf_hash()
			);

			// dieArray($usrpm);
			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
			    
			    if(($schl_id!='')&&($gen_id!='')){

			    	$schl_stu = $this->school_model->get_student($schl_id,$gen_id);//แสดงข้อมูลนักเรียนที่ลงทะเบียน
                    $data['schl_stu']  = $schl_stu;
                    $data['schl_id']   = $schl_id;
                    $data['gen_id']    = $gen_id;
                    
				     
				    $this->template->load('index_page',$data,'school');
			    }else{
			      page500();
			      $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			    }
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
				  
				  if(($schl_id!='')&&($gen_id!='')){

				  	  if(get_inpost('tel_no_home')==''){
                        $tel_no_home = null;
				  	  }else{
                        $tel_no_home = get_inpost('tel_no_home');
				  	  }

				  	  if(get_inpost('healthy_congenital_disease')==''){
                        $healthy_congenital_disease = null;
				  	  }else{
                        $healthy_congenital_disease = get_inpost('healthy_congenital_disease');
				  	  }


                      $update_pers_info = array('tel_no_home'               => $tel_no_home,
                      	                        'healthy_congenital_disease' => $healthy_congenital_disease,
                      	                        );
                      $this->common_model->update('pers_info',$update_pers_info,array('pers_id'=>get_inpost('pers_id')));
			    	  
			    	  $insert_schl_info_student = array('schl_id'       => $schl_id,
			    	  	                                'gen_id'        => $gen_id,
			    	  	                                'pers_id'       => get_inpost('pers_id'),
			    	  	                                'date_of_regis' => date("Y-d-m"));
				      $this->common_model->insert('schl_info_student',$insert_schl_info_student);


                     $this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				     redirect('school/participant/Add/'.$schl_id.'/'.$gen_id,'refresh');
				    
			    }else{
			      page500();
			      $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			    }

               				
			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				if(($schl_id!='')&&($gen_id!='')){
				    
				     echo $schl_id."<br>".$gen_id;
				
				
					//$this->template->load('index_page',$data,'school');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				   if(($schl_id!='')&&($gen_id!='')){
				    
				       			    
				     if(get_inpost('tel_no_mobile')==''){
                        $tel_no_mobile = null;
				  	  }else{
                        $tel_no_mobile = get_inpost('tel_no_mobile');
				  	  }

				  	  if(get_inpost('healthy_congenital_disease')==''){
                        $healthy_congenital_disease = null;
				  	  }else{
                        $healthy_congenital_disease = get_inpost('healthy_congenital_disease');
				  	  }


                      $update_pers_info = array('tel_no'               => $tel_no_mobile,
                      	                        'healthy_congenital_disease' => $healthy_congenital_disease,
                      	                        );
                      $this->common_model->update('pers_info',$update_pers_info,array('pers_id'=>get_inpost('pers_id')));
				
				
					 $this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					 $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				     redirect('school/participant/Add/'.$schl_id.'/'.$gen_id,'refresh');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
          
			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				

				$this->common_model->delete_where('schl_info_student','stu_id',$stu_id);
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('school/participant/Add/'.$schl_id."/".$gen_id,'refresh');
			}else {
				page500();
				$this->template->load('index_page',$data,'school');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

	}
}

 public function del_schl_contacts(){
 	$contacts_id = get_inpost('contacts_id');
 	$this->common_model->delete_where('schl_info_contacts','sch_cnt_id',$contacts_id);
 	echo "remove";
  }

  public function del_schl_photo(){
  	$id_photo = get_inpost('id_photo');
  	$this->common_model->delete_where('schl_info_photo','schl_photo_id',$id_photo);
 	echo "remove";

  }

  public function del_schl_edu(){
  	$id_edu = get_inpost('id_edu');
  	$this->common_model->delete_where('schl_info_edu','edu_id',$id_edu);
 	echo "remove";

  }


	public function center_list($process_action='View') { // ตารางข้อมูล
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 163;
		$process_path = 'school/center_list';
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
			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			$data['center_info'] = $this->school_model->getAll_CenterInfo();

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
    		set_js_asset_footer('center_list_ajax.js','school'); //Set JS Index.js
    		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/ion.rangeSlider.min.js'); //Set JS Index.js


			$data['process_action'] = $process_action;
			$data['content_view'] = 'center_list_ajax';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];


			$this->template->load('index_page',$data,'school');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	public function center_list_ajax($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		//ini_set('max_execution_time', 300);
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 163;
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			echo json_encode(array());
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign In Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			//$data['diff_info'] = $this->difficult_model->getAll_diffInfo();

		//	$this->load->model('funeral_list_model','funeral');
			$this->load->model('school_model','school');
			$list = $this->school->get_datatables();
			$data = array();
			$no = $_POST['start'];
			// dieArray($list);
			foreach ($list as $i=>$center) {

				$no++;
				$row = array();

                $row[] = "<center>".$no."</center>";

			    $row[] = $center->qlc_name;

			    if($center->addr_province!=''){
                      $sub_district = $this->common_model->query("SELECT * FROM std_area WHERE area_code = {$center->addr_sub_district}")->row_array();
                      $district = $this->common_model->query("SELECT * FROM std_area WHERE area_code = {$center->addr_district}")->row_array();
                     $province = $this->common_model->query("SELECT * FROM std_area WHERE area_code = {$center->addr_province}")->row_array();
                            $row[] =  'ตำบล '.$sub_district['area_name_th'].' '.'อำเภอ '.$district['area_name_th'].' '.'จังหวัด '.$province['area_name_th'];
                     }else{
                      $row[] = "-";
                  }

                if($center->tel_no != '')
                {
                   $row[] = $center->tel_no; 
           		}else{
           		 	$row[] = " - ";
           		}

           		$qlc = $this->common_model->query("SELECT * FROM schl_qlc_kpi WHERE qlc_id = {$center->qlc_id}")->result_array();
           		$sum = 0;
           		if (!empty($qlc)){
           			foreach ($qlc as $key => $value) {
           				           
      					$sum_data  = $this->common_model->query("SELECT qlc_kpi_score FROM std_qlc_kpi WHERE qlc_kpi_code = {$value['qlc_kpi_code']}")->row_array();
      					$sum = $sum_data['qlc_kpi_score'] + $sum;
      					
           			}
           		}

                $progress = '';

			    // $row[] = $progress .' <div class="progress">
       //                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$sum.'"
       //                    aria-valuemin="0" aria-valuemax="100" style="width:'.$sum.'%">
       //                      สำเร็จ '.$sum.'% 
       //                    </div>
       //                  </div>';

            	$row[] = '<div class="progress" style="background-color: rgba(96, 125, 139, 0.34);margin-bottom: 0px !important;">
										<div class="progress-bar" role="progressbar" aria-valuenow="'.$sum.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$sum.'%; '.$sum.' ">
											'.$sum.'
										</div>
									</div>';

			   


			    $tmp = $this->admin_model->getOnce_Application(3);
                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                $btn = '';
                $btn =$btn.'<!-- Single button -->
                <div class="btn-group" style="cursor: pointer;">
                  <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>

                  <ul class="dropdown-menu" style="position: absolute;left: -190px;">';

                  $btn = $btn.' <li><a style="font-size:16px;" data-toggle="modal" data-target="#prt'.$center->qlc_id.'" title="พิมพ์แบบฟอร์ม" >
                       <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #000"></i> พิมพ์แบบฟอร์ม (.PDF)
                   </a></li>';


                  $btn =$btn.'<li><a  style="font-size:16px;"';

                  if(!isset($tmp1['perm_status'])){ $btn =$btn.'class="disabled"';}else{ $btn =$btn.'href="'.site_url("school/center_info/Edit/".$center->qlc_id); }
                  $btn =$btn.'"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>';




                    $tmp = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                    if(isset($tmp['perm_status'])) {
                        if($tmp['perm_status']=='Yes') {
                         $btn = $btn.'<li><a style="font-size:16px;" data-id='.$center->qlc_id.' onclick="opn(this)" title="ลบ" >
                             <i class="fa fa-trash" style="color: #000"></i> ลบรายการ
                          </a></li>';
                      }
                    }

                  $btn = $btn.'</ul>
                              </div>';

                $btn =$btn.'<!-- Print Modal -->
                   <div class="modal fade" id="prt'.$center->qlc_id.'" role="dialog">
                     <div class="modal-dialog">

                        <!-- Modal content-->
                       <div class="modal-content">
                         <div class="modal-header text-left">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" style="color: #333; font-size: 16px;">พิมพ์แบบฟอร์ม</h4>
                          </div>
                         <div class="modal-body">
                           <div class="row">';

                    $tmp = $this->admin_model->getOnce_Application(25);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(25,get_session('user_id')); //Check User Permission

                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;"';
                    if(!isset($tmp1['perm_status'])) {
                      $btn = $btn.' class="disabled "';
                    }else if($usrpm['app_id']==25) {
                      $btn = $btn.' class="active "';
                    }
                    $btn = $btn.'>
                                 <a style="color: #333; font-size: 16px;" target="_blank" href="'.site_url('report/C1/pdf?id='.$center->qlc_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                    if(isset($tmp1['perm_status'])) {
                     $btn = $btn.$tmp1['app_name'];
                    }
                    $btn = $btn.'  </a>
                             </div>';

                    $tmp = $this->admin_model->getOnce_Application(26);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(26,get_session('user_id')); //Check User Permission
                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                    if(!isset($tmp1['perm_status'])) {
                        $btn = $btn.' class="disabled" ';
                    }else if($usrpm['app_id']==26) {
                        $btn = $btn.' class="active" ';
                    }
                    $btn = $btn.'>';

                     $btn = $btn.'<a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/C2/pdf?id='.$center->qlc_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                     if(isset($tmp1['perm_status'])) {
                       $btn = $btn.$tmp1['app_name'];
                     }
                     $btn = $btn.'
                            </a>
                          </div>';

                    $tmp = $this->admin_model->getOnce_Application(27);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(27,get_session('user_id')); //Check User Permission

                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                    if(!isset($tmp1['perm_status'])) {
                        $btn = $btn.' class="disabled" ';
                      }else if($usrpm['app_id']==27) {
                        $btn = $btn.' class="active" ';
                      }
                    $btn = $btn.'>';
                    $btn = $btn.'<a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/C3/pdf?id='.$center->qlc_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                    if(isset($tmp1['perm_status'])) {
                     $btn = $btn.$tmp1['app_name'];
                    }
                    $btn = $btn.'</a>
                            </div>';


                    $btn = $btn.'

                           </div>
                           <br/>

                        </div>
                      </div>

                    </div>
                   </div>
                    <!-- End Print Modal -->';


                $row[] = "<center>".$btn."</center>";

                $data[] = $row;
            }


			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->school->count_all(),
							"recordsFiltered" => $this->school->count_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}


	public function center_info($process_action='Add',$schl_id=0) { //แบบขึ้นทะเบียน (โรงเรียน)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 163;
		$process_path = 'school/center_info';
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500();
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			 /*-- datepicker --*/
            set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
            set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
            /*-- End datepicker --*/

            /*-- Toastr style --*/
            set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
            set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
            /*-- End Toastr style --*/

            set_css_asset_head('../plugins/Static_Full_Version/css/plugins/jasny/jasny-bootstrap.min.css');
            set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/jasny/jasny-bootstrap.min.js');

            /*-- select2 style --*/
            set_css_asset_head('../plugins/Static_Full_Version/css/plugins/select2/select2.min.css');
            set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/select2/select2.full.min.js');
            /*-- End select2 style --*/

            set_js_asset_footer('mapmarker.js','webconfig'); //Set JS mapmarker.js --
            
			
			set_js_asset_footer('center_info.js','school'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'center_info';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				$data['center_info'] = $this->clr_schlInfo_center();
                $data['std_model'] = $this->school_model->get_std_model();//แสดงคุณสมบัติต้นแบบ
                $data['std_qlc'] = $this->school_model->getAll_Center_qlc();//show qlc
              
				$this->template->load('index_page',$data,'school');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form


					$data_insert 					= array();
				    $data_insert 					= @get_inpost_arr('center_info');
			
				     // dieArray($qlc_insert);
				    $data_insert['insert_user_id'] 	= getUser();
					$data_insert['insert_org_id'] 	= get_session('org_id');
					$data_insert['insert_datetime'] = getDatetime();

					$id = $this->common_model->insert('schl_qlc_info',$data_insert);

				//	dieArray($_POST);
					$qlc_insert = array();
					$qlc_insert = @get_inpost_arr('qlc');
					if(!empty($qlc_insert)){
						 foreach ($qlc_insert as $key_model => $val_model) {

					 	     $insert_model = array('qlc_id'     => $id,
                                                   'qlc_kpi_code'   => $key_model,
                                                   'qlc_kpi_result' => 'มี'
					 	     	                  );
					 	     $this->common_model->insert('schl_qlc_kpi',$insert_model);
						 }
					}


					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('school/center_list','refresh');

				
			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				 if($schl_id!=''){

						$data['center_info'] = $this->school_model->getAll_CenterInfo($schl_id);
		                $data['std_qlc'] = $this->school_model->getAll_Center_qlc();//show qlc
						$this->template->load('index_page',$data,'school');

				 }else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				 }

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				//dieArray($_POST);
				$process_action='Edited';
                    
				    $data_insert 					= array();
				    $data_insert 					= @get_inpost_arr('center_info');
				    $data_insert['update_user_id'] 	= getUser();
					$data_insert['update_org_id'] 	= get_session('org_id');
					$data_insert['update_datetime'] = getDatetime();

					 $this->common_model->update('schl_qlc_info',$data_insert,array('qlc_id'=>$schl_id));
                    
                    $update_qlc = @get_inpost_arr('qlc');//จำนวนเจ้าหน้าที่ที่มีการเพิ่มอยู่แล้ว
					
					$this->common_model->delete_where("schl_qlc_kpi",'qlc_id',$schl_id);
                    if(!empty($update_qlc)){
						 foreach ($update_qlc as $key_model => $val_model) {

					 	     $insert_model = array('qlc_id'     => $schl_id,
                                                   'qlc_kpi_code'   => $key_model,
                                                   'qlc_kpi_result' => 'มี'
					 	     	                  );
					 	     $this->common_model->insert('schl_qlc_kpi',$insert_model);
						 }
					}


				    $this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('school/center_info/Edit/'.$schl_id,'refresh');
			

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				 //Delete process
                $data_update                    = array();
                $data_update['delete_user_id']  = getUser();
                $data_update['delete_org_id']   = get_session('org_id');
                $data_update['delete_datetime'] = getDatetime();

                $this->common_model->update('schl_qlc_info',$data_update,array('qlc_id'=>$schl_id));
                $this->common_model->delete_where("schl_qlc_kpi",'qlc_id',$schl_id);
				

				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('school/center_list','refresh');
			}else {
				page500();
				$this->template->load('index_page',$data,'difficult');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}
	
}
