<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Volunteer extends MX_Controller {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function getChart(){
    ini_set('max_execution_time', 300);
    $dataChart = array();
    $prov = $this->personal_model->getAll_Province();
    foreach ($prov as $key => $row) {
        $dataChart[] = array(
            'province' => $row['area_name_th'],
            'value' => rand(0,500),
            'older' => rand(0,100),
        );
    }
    echo json_encode($dataChart);

	}

	public function volunteer_list_ajax($process_action='View') { //อผส.
		//ini_set('max_execution_time', 300);
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 51;
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

			$this->load->model('volunteer_list_model','manage_transfer');
			$list = $this->manage_transfer->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $i=>$manage_transfer) {
				$no++;
				$row = array();

                $row[] = "<center>".$no."</center>";
                $row[] = $manage_transfer->pid;
                $row[] = $manage_transfer->prename_th.$manage_transfer->name;

                $age = '';
                if($manage_transfer->date_of_birth!='' && checkdate(iconv_substr($manage_transfer->date_of_birth,5,2,'utf-8'),iconv_substr($manage_transfer->date_of_birth,8,2,'utf-8'),iconv_substr($manage_transfer->date_of_birth,0,4,'utf-8'))) {
                  $date = new DateTime($manage_transfer->date_of_birth);
                  $now = new DateTime();
                  if($manage_transfer->date_of_death!='' && checkdate(iconv_substr($manage_transfer->date_of_death,5,2,'utf-8'),iconv_substr($manage_transfer->date_of_death,8,2,'utf-8'),iconv_substr($manage_transfer->date_of_death,0,4,'utf-8'))) {
                    $now = new DateTime($manage_transfer->date_of_death);
                    $interval = $now->diff($date);
                    $age = $interval->y;
                  }else if($manage_transfer->date_of_death!='') {
                    $age = '';
                  }else {
                    $interval = $now->diff($date);
                    $age = $interval->y;
                  }
                }
                $row[] = "<center>".$age."</center>";

                $date_of_req = '';
                if($manage_transfer->date_of_reg!='' && $manage_transfer->date_of_reg!='0000-00-00') {
                    $date_of_req = dateChange($manage_transfer->date_of_reg,5);
                }else {
                		$date_of_req = '-';
                }
								$row[] = "<center>".$date_of_req."</center>";
                $row[] = "<center></center>";
                $row[] = "";
				//$row[] = "<center>".$manage_transfer->gender_code."</center>";

                $tmp = $this->admin_model->getOnce_Application(147);
                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(147,$user_id); //Check User Permission
                $btn = '';
                $btn =$btn.'<!-- Single button -->
                <div class="btn-group" style="cursor: pointer;">
                  <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>

                  <ul class="dropdown-menu" style="position: absolute;left: -190px;">';

                  $btn = $btn.' <li><a style="font-size:16px;" data-toggle="modal" data-target="#prt'.$manage_transfer->volt_id.'" title="พิมพ์แบบฟอร์ม" >
                       <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #000"></i> พิมพ์แบบฟอร์ม (.PDF)
                   </a></li>';


                  $btn =$btn.'<li><a  style="font-size:16px;"';

                  if(!isset($tmp1['perm_status'])){ $btn =$btn.'class="disabled"';}else{ $btn =$btn.'href="'.site_url("volunteer/volunteer_info/Edit/".$manage_transfer->volt_id); }
                  $btn =$btn.'"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>';


                    $tmp = $this->admin_model->chkOnce_usrmPermiss(52,$user_id); //Check User Permission
                    if(isset($tmp['perm_status'])) {
                        if($tmp['perm_status']=='Yes') {
                         $btn = $btn.'<li><a style="font-size:16px;" data-id='.$manage_transfer->volt_id.' onclick="opn(this)" title="ลบ" >
                             <i class="fa fa-trash" style="color: #000"></i> ลบรายการ
                          </a></li>';
                      }
                    }

                  $btn = $btn.'</ul>
                              </div>';

                $btn =$btn.'<!-- Print Modal -->
                   <div class="modal fade" id="prt'.$manage_transfer->volt_id.'" role="dialog">
                     <div class="modal-dialog">

                        <!-- Modal content-->
                       <div class="modal-content">
                         <div class="modal-header text-left">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" style="color: #333; font-size: 16px;">พิมพ์แบบฟอร์ม</h4>
                          </div>
                         <div class="modal-body">
                           <div class="row">';

                    $tmp = $this->admin_model->getOnce_Application(147);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(147,get_session('user_id')); //Check User Permission
                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                            if(!isset($tmp1['perm_status'])) {
                                $btn = $btn.' class="disabled" ';
                            }else if($usrpm['app_id']==147) {
                                $btn = $btn.' class="active" ';
                            }
                    $btn = $btn.'>
                              <a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/F2/pdf?id='.$manage_transfer->volt_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                             if(isset($tmp1['perm_status'])) {
                               $btn = $btn.$tmp1['app_name'];
                             }
                    $btn = $btn.'
                              </a>
                            </div>

                           </div>
                           <br/>

                        </div>
                      </div>

                    </div>
                   </div>
                   <!-- End Print Modal -->';


                $row[] = "<center>".$btn."<center>";

                $data[] = $row;
            }

			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->manage_transfer->count_all(),
							"recordsFiltered" => $this->manage_transfer->count_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	public function volunteer_list($process_action='View') { // อผส
		//ini_set('max_execution_time', 300);
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 51;
		$process_path = 'volunteer/volunteer_list';
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

			// $data['volt_info'] = $this->common_model->custom_query("
			// 	SELECT A.*,B.vpos_code,B.vpos_identify FROM volt_info AS A
			// 	LEFT JOIN volt_info_village_position AS B ON A.volt_id = B.volt_id
			// ");
			//$data['volt_info'] = $this->common_model->custom_query("SELECT * FROM volt_info");

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

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

		    /*-- datepicker --*/
		    //set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
		    //set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
		    /*-- End datepicker --*/

		    /*-- datepicker custom --*/
		    set_css_asset_head('../plugins/bootstrap-datepicker-custom/dist/css/bootstrap-datepicker.css');
		    set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/js/bootstrap-datepicker-custom.js');
		    set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/locales/bootstrap-datepicker.th.min.js');
		    /*-- End datepicker custom--*/

			/*-- datepicker --*/
			// set_css_asset_head('../plugins/bootstrap-datepicker-thai/css/datepicker.css');
			// set_js_asset_head('../plugins/bootstrap-datepicker-thai/js/bootstrap-datepicker.js');
			// set_js_asset_head('../plugins/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js');
			// set_js_asset_head('../plugins/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js');
			/*-- End datepicker --*/

			set_js_asset_footer('volunteer_list_ajax.js','volunteer'); //Set JS volunteer_list_ajax.js

     		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/ion.rangeSlider.min.js'); //Set JS Index.js

			$data['process_action'] = $process_action;
			$data['content_view'] 	= 'volunteer_list_ajax';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page',$data,'volunteer');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	public function volunteer_info($process_action='Add',$volt_id=0) { //แบบขอรับบริการ (แจ้งเรื่อง)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 52;
		$process_path = 'volunteer/volunteer_info';
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

			// $data['volt_info'] = $this->volunteer_model->getAll_diffInfo();

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

      /*-- datepicker --*/
      //set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
      //set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
      /*-- End datepicker --*/

      /*-- datepicker custom --*/
      set_css_asset_head('../plugins/bootstrap-datepicker-custom/dist/css/bootstrap-datepicker.css');
      set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/js/bootstrap-datepicker-custom.js');
      set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/locales/bootstrap-datepicker.th.min.js');
      /*-- End datepicker custom--*/

	  		/*-- Toastr style --*/
	  		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
	  		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
	  		/*-- End Toastr style --*/

	  		/*-- select2 style --*/
	  		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/select2/select2.min.css');
	  		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/select2/select2.full.min.js');
	  		/*-- End select2 style --*/

	  		set_js_asset_footer('mapmarker.js','webconfig'); //Set JS mapmarker.js --

            set_js_asset_footer('webservice.js','personals'); //Set JS sufferer_form1.js
			set_js_asset_footer('volunteer_info.js','volunteer'); //Set JS volunteer_info.js

			$data['process_action'] = $process_action;
			$data['content_view'] 	= 'volunteer_info';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] 	= $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {

				$data['volt_info'] = array(
					'pers_id'						=> '',
					'date_of_reg'					=> date('d-m-Y'),
					'older_care_training'			=> 'ไม่เคยได้รับการอบรม',
					'older_care_training_identify'	=> '',
					'date_of_training'				=> '',
					'older_care_training_org'		=> '',
					'older_care_training_course'	=> '',
				);

				$data['reg_addr'] 	= array(
					'addr_home_no' 				 	=> '',
					'addr_moo' 						=> '',
					'addr_sub_district' 			=> '',
					'addr_district' 				=> '',
					'addr_province' 				=> '',
					'addr_zipcode' 					=> '',
					'addr_gps'                      => '',
				);

				$data['pers_info']  = array(
					'pid' 							=> '',
					'pers_id' 						=> '',
					'name' 							=> ' - ',
					'date_of_birth' 				=> ' - ',
					'gender_name'					=> ' - ',
					'nation_name_th'				=> ' - ',
					'relg_title' 					=> ' - ',
					'tel_no_home' 					=> '',
					'tel_no_mobile' 				=> '',
					'fax_no'						=> '',
					'email_addr' 					=> '',
					'reg_addr_id' 					=> '',
					'pre_addr_id' 					=> ''
				);


				$this->template->load('index_page',$data,'volunteer');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form

				 //dieArray($_POST);

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('volt_info[date_of_reg]','วันที่ขึ้นทะเบียน','required|callback_date_check');
				// $frm->set_rules('volt_info[req_pers_id]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
				$frm->set_rules('volt_info[pers_id]','เลขประจำตัวประชาชน','required');

				//if(get_inpost('rd_pers_id')==1) {
				//	$frm->set_rules('volt_info[pers_id]','เลขประจำตัวประชาชน','required');
				//}

				//$frm->set_rules('volt_info[elder_firstname]','ชื่อตัว','required');
				//$frm->set_rules('volt_info[elder_lastname]','ชื่อสกุล','required');

				//if(get_inpost('rd_req_pers_id')==1) {
				//	$frm->set_rules('volt_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
				//}

				//$frm->set_rules('volt_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
				//$frm->set_rules('volt_info[req_channel]','ช่องทางการรับแจ้ง','required');

				//$frm->set_rules('volt_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				//$frm->set_rules('volt_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data
                    //dieArray($_POST);

					$data_insert =  get_inpost_arr('volt_info');
					$data_insert['date_of_reg'] 			= dateChange($data_insert['date_of_reg']);
					//$data_insert['date_of_training'] 		= dateChange($data_insert['date_of_training']);
					$data_insert['insert_user_id'] 	= getUser();
					$data_insert['insert_datetime']	= getDatetime();
					$data_insert['insert_org_id'] 	= get_session("org_id");

					//dieArray($data_insert);
					$id = $this->common_model->insert('volt_info',$data_insert);


					if(get_inpost('elder_addr_chk')!='on') {
						//add new addr
						$addr_insert = get_inpost_arr('pers_addr');
						$addr_insert['insert_user_id'] 	= getUser();
						$addr_insert['insert_datetime']	= getDatetime();
						$addr_insert['insert_org_id'] 	= get_session("org_id");

						$addr_id = $this->common_model->insert('pers_addr',$addr_insert);

						$pers_update['pre_addr_id'] = $addr_id;
					}

					$pers_tmp = get_inpost_arr('pers_info');
					// if(!empty($pers_tmp)){
					// 	foreach ($pers_tmp as $key => $value) {
					// 		if($value != ''){
					// 			$pers_update[$key] = $value;
					// 		}
					// 	}
					// }
					unset($pers_update['pid']);
					$pers_update['update_user_id'] 	= getUser();
					$pers_update['update_org_id'] 	= get_session('org_id');
					$pers_update['update_datetime'] = getDatetime();
					$this->common_model->update('pers_info',$pers_update,array('pers_id'=>get_inpost('volt_info[pers_info]')));

					$tmp_position = @get_inpost_arr('volt_info_village_position[vpos_code]');
					if(!empty($tmp_position)){
						$this->common_model->delete_where('volt_info_village_position','volt_id',$id);
						foreach ($tmp_position as $row) {
							$vpos_insert = array(
								'volt_id'				=> $id,
								'vpos_code'				=> $row,
								'vpos_identify'			=> get_inpost("volt_info_village_position[vpos_identify][{$row}]"),
							);
							$this->common_model->insert('volt_info_village_position',$vpos_insert);
						}
					}

                     //////////////////////////////////////////////////////////////////
					 //ผู้สูงอายุในความดูแล
					 $tmp_elderly_care = @get_inpost_arr('volt_info_elderly_care[pers_id]');
					 $tmp_care_pers_info 			 = @get_inpost_arr('care_pers_info');
					 if(!empty($tmp_elderly_care)){

                         foreach ($tmp_elderly_care as $key =>$value ) {

	                         	$elderly_care_insert = array(
	                                  'volt_id'  	 	=> $id,
	                                  'pers_id'  		=> $value,
	                                  'care_freq' 		=> get_inpost('care_pers_info[care_freq]['.$key.']'),
	                                  'care_freq_per'   => get_inpost('care_pers_info[care_freq_per]['.$key.']'),
	                                  'care_health_problems'   => get_inpost('care_pers_info[care_health_problems]['.$key.']'),
	                                  'care_help_yourself'   => get_inpost('care_pers_info[care_help_yourself]['.$key.']'),
	                                  'care_cause_code'=>get_inpost('care_pers_info[care_cause_code]['.$key.']'),
	                                  'care_cause_identify'=>get_inpost('care_pers_info[care_cause_identify]['.$key.']')
	                         		);
                            $this->common_model->insert('volt_info_elderly_care',$elderly_care_insert);
                         }

					 }
					 /////////////////////////////////////////////////////////////////////

                     //////////////////////////////////////////////////////////////////
					 //ประวัติการอบรม
					 $tmp_training_info 			 = @get_inpost_arr('training[date_of_training]');
					 if(!empty($tmp_training_info) && get_inpost('volt_info[older_care_training]')=='เคยได้รับการอบรม'){
                         foreach ($tmp_training_info as $key =>$value ) {
	                         $tmp_training_insert = array(
	                          'volt_id'=>$id,
	                          'date_of_training'   => dateChange(get_inpost('training[date_of_training]['.$key.']')),
	                          'older_care_training_org'   => get_inpost('training[older_care_training_org]['.$key.']'),
	                          'older_care_training_course'   => get_inpost('training[older_care_training_course]['.$key.']'),
	                         );
                            $this->common_model->insert('volt_info_training',$tmp_training_insert);
                         }
					 }
					 /////////////////////////////////////////////////////////////////////

					// dieArray($_POST);
					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('volunteer/volunteer_info/Edit/'.$id,'refresh');
				}else {
					$data['volt_info'] 			= get_inpost_arr('volt_info');
					$data['elder_addr_chk'] = set_value('elder_addr_chk');

					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

					$this->template->load('index_page',$data,'volunteer');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = rowArray($this->common_model->custom_query("SELECT * FROM volt_info WHERE volt_id = {$volt_id}"));
				// dieArray($row);
				if(isset($row['volt_id'])) {
					$data['volt_info'] = $row;
					$data['pers_info'] = $this->personal_model->getOnce_PersonalInfo($row['pers_id']);
					if($data['pers_info']['pre_addr_id'] != ''){
						$data['reg_addr'] = $this->personal_model->getOnce_PersonalAddress($data['pers_info']['reg_addr_id']);
					}else{
						$data['pers_addr'] = array();
					}

					// if($data['pers_info']['pre_addr_id'] == $data['pers_info']['reg_addr_id']){
					// 	$data['elder_addr_chk'] = 'on';
					// }else{
						$data['pers_addr'] = $this->personal_model->getOnce_PersonalAddress($data['pers_info']['reg_addr_id']);
					// }

					if($row['date_of_reg']!='') {
						$tmp = explode('-',$row['date_of_reg']);
						$data['volt_info']['date_of_reg'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					if($row['date_of_training']!='') {
						$tmp = explode('-',$row['date_of_training']);
						$data['volt_info']['date_of_training'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}

					$tmp = $this->common_model->custom_query("SELECT * FROM volt_info_village_position WHERE volt_id = {$volt_id}");
					$data['volt_info_village_position'] = sort_array_with($tmp,'vpos_code');
					$data['volt_info_elderly_care'] = $this->common_model->custom_query("SELECT * FROM volt_info_elderly_care LEFT JOIN pers_info ON volt_info_elderly_care.pers_id = pers_info.pers_id WHERE volt_id = {$volt_id}");

					$data['volt_info_training'] = $this->common_model->custom_query("SELECT * FROM volt_info_training WHERE volt_id = {$volt_id}");
					foreach($data['volt_info_training'] as $key=>$value) {
						if($value['date_of_training']!='') {
							$tmp = explode('-',$value['date_of_training']);
							$data['volt_info_training'][$key]['date_of_training'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
						}
					}

					// dieArray($data);
					$this->template->load('index_page',$data,'volunteer');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
				//dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('volt_info[date_of_reg]','วันที่ขึ้นทะเบียน','required|callback_date_check');
				// $frm->set_rules('volt_info[req_pers_id]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
				$frm->set_rules('volt_info[pers_id]','เลขประจำตัวประชาชน','required');

				//if(get_inpost('rd_pers_id')==1) {
				//	$frm->set_rules('volt_info[pers_id]','เลขประจำตัวประชาชน','required');
				//}

				//$frm->set_rules('volt_info[elder_firstname]','ชื่อตัว','required');
				//$frm->set_rules('volt_info[elder_lastname]','ชื่อสกุล','required');

				//if(get_inpost('rd_req_pers_id')==1) {
				//	$frm->set_rules('volt_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
				//}

				//$frm->set_rules('volt_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
				//$frm->set_rules('volt_info[req_channel]','ช่องทางการรับแจ้ง','required');

				//$frm->set_rules('volt_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				//$frm->set_rules('volt_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update =  get_inpost_arr('volt_info');
					unset($data_update['pid']);
					$data_update['date_of_reg'] 		= dateChange($data_update['date_of_reg']);
					//$data_update['date_of_training'] 	= dateChange(@$data_update['date_of_training']);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_datetime']	= getDatetime();
					$data_update['update_org_id'] 	= get_session("org_id");
					$this->common_model->update('volt_info',$data_update,array('volt_id'=>$volt_id));

					if(get_inpost('elder_addr_chk')!='on') {
						//add new addr
					}

					$tmp_position = get_inpost_arr('volt_info_village_position[vpos_code]');
					if(!empty($tmp_position)){
						$this->common_model->delete_where('volt_info_village_position','volt_id',$volt_id);
						foreach ($tmp_position as $row) {
							$vpos_insert = array(
								'volt_id'			=> $volt_id,
								'vpos_code'			=> $row,
								'vpos_identify'	=> get_inpost("volt_info_village_position[vpos_identify][{$row}]"),
							);
							$this->common_model->insert('volt_info_village_position',$vpos_insert);
						}
					}


					 //////////////////////////////////////////////////////////////////
					 //update ผู้สูงอายุในความดูแล
					 $tmp_elderly_care 				 = @get_inpost_arr('volt_info_elderly_care[pers_id]');
					 $tmp_care_pers_info 			 = @get_inpost_arr('care_pers_info');

					 					 //dieArray($_POST);

					 if(!empty($tmp_elderly_care)){

                         foreach ($tmp_elderly_care as $key =>$value ) {

                         	    $elderly_care_update = array(
	                                  'volt_id'  	 	=> $volt_id,
	                                  'pers_id'  		=> $value,
	                                  'care_freq' 		=> get_inpost('care_pers_info[care_freq]['.$key.']'),
	                                  'care_freq_per'   => get_inpost('care_pers_info[care_freq_per]['.$key.']'),
	                                  'care_health_problems'   => get_inpost('care_pers_info[care_health_problems]['.$key.']'),
	                                  'care_help_yourself'   => get_inpost('care_pers_info[care_help_yourself]['.$key.']'),
	                                  'care_cause_code'=>get_inpost('care_pers_info[care_cause_code]['.$key.']'),
	                                  'care_cause_identify'=>get_inpost('care_pers_info[care_cause_identify]['.$key.']')
	                         		);

                         	    if(get_inpost('volt_info_elderly_care[care_id]['.$key.']')!=''){

                         	    	 $this->common_model->update('volt_info_elderly_care',$elderly_care_update,array('care_id'=>get_inpost('volt_info_elderly_care[care_id]['.$key.']')));
                         	     }else{
                         	       $this->common_model->insert('volt_info_elderly_care',$elderly_care_update);
                         	     }

                         }

					 }
					 /////////////////////////////////////////////////////////////////////

					 //////////////////////////////////////////////////////////////////
					 //update ประวัติการอบรม
					 $tmp_training_info 			 = @get_inpost_arr('training[date_of_training]');
					 if(!empty($tmp_training_info) && get_inpost('volt_info[older_care_training]')=='เคยได้รับการอบรม'){

                         foreach ($tmp_training_info as $key =>$value ) {

                         	    $training_update = array(
	                               	'volt_id' => $volt_id,
	                          		'date_of_training' => dateChange(get_inpost('training[date_of_training]['.$key.']')),
	                          		'older_care_training_org' => get_inpost('training[older_care_training_org]['.$key.']'),
	                          		'older_care_training_course' => get_inpost('training[older_care_training_course]['.$key.']'),
	                         	);

                         	    if(get_inpost('training[train_id]['.$key.']')!=''){
                         	    	 $this->common_model->update('volt_info_training',$training_update,array('train_id'=>get_inpost('training[train_id]['.$key.']')));
                         	     }else{
                         	       $this->common_model->insert('volt_info_training',$training_update);
                         	     }

                         }

					 }
					 /////////////////////////////////////////////////////////////////////

					//$data_update['date_of_visit'] = dateChange($data_update['date_of_visit'],4);


					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('volunteer/volunteer_info/Edit/'.$volt_id,'refresh');
				}else {

					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'volunteer');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process

				$this->common_model->delete_where('volt_info','volt_id',$volt_id);
				$this->common_model->delete_where('volt_info_elderly_care','volt_id',$volt_id);
				$this->common_model->delete_where('volt_info_village_position','volt_id',$volt_id);
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('volunteer/volunteer_list','refresh');
			}else {
				page500();
				$this->template->load('index_page',$data,'volunteer');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function date_check($str) {
    //$str = str_replace("-","",$str);
		if(strlen($str)==10) {
      $year = iconv_substr($str,6,4,'utf-8');
      //settype("integer",$year);
      $year = $year-543;
			if(checkdate(iconv_substr($str,3,2,'utf-8'),iconv_substr($str,0,2,'utf-8'),$year)){
				return true;
			}
			else{
				return false;
			}
		}else return false;
	}

	public function del_elderly_care()
    {
        $care_id = get_inpost('care_id');
        $this->common_model->delete_where('volt_info_elderly_care','care_id',$care_id);
        echo "remove";

    }

    public function del_train() {
        $train_id = get_inpost('train_id');
        $this->common_model->delete_where('volt_info_training','train_id',$train_id);
        echo "remove";
    }

}
