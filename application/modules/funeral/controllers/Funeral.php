<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funeral extends MX_Controller {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function funeral_list_ajax($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		//ini_set('max_execution_time', 300);
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 21;
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

			$this->load->model('funeral_list_model','funeral');
			$list = $this->funeral->get_datatables();
			$data = array();
			$no = $_POST['start'];
			// dieArray($list);
			$sql = "sql:".$this->db->last_query();
			foreach ($list as $i=>$funeral) {

				$no++;
				$row = array();

			    $pers_info = $this->personal_model->getOnce_PersonalInfo($funeral->pers_id);
			    $req_pers_info = $this->personal_model->getOnce_PersonalInfo($funeral->req_pers_id);

          $row[] = "<center>".$no."</center>";

			    $row[] = $pers_info['pid'];
			    $row[] = $pers_info['prename_th'].$pers_info['name'];
					//$row[] = "<center>".$pers_info['gender_name']."</center>";
			    $age = '';
                if($pers_info['date_of_birth']!='' && checkdate(iconv_substr($pers_info['date_of_birth'],5,2,'utf-8'),iconv_substr($pers_info['date_of_birth'],8,2,'utf-8'),iconv_substr($pers_info['date_of_birth'],0,4,'utf-8'))) {
                  $date = new DateTime($pers_info['date_of_birth']);
                  $now = new DateTime();
                  if($pers_info['date_of_death']!='' && checkdate(iconv_substr($pers_info['date_of_death'],5,2,'utf-8'),iconv_substr($pers_info['date_of_death'],8,2,'utf-8'),iconv_substr($pers_info['date_of_death'],0,4,'utf-8'))) {
                    $now = new DateTime($pers_info['date_of_death']);
                    $interval = $now->diff($date);
                    $age = $interval->y;
                  }else if($pers_info['date_of_death']!='') {
                    $age = '';
                  }else {
                    $interval = $now->diff($date);
                    $age = $interval->y;
                  }
                }
					$row[] = "<center>".$age."</center>";
         	//$row[] = "<center>".$pers_info['gender_name']."</center>";

			    // $row[] = $req_pers_info['prename_th'].$req_pers_info['name'];

			    // $row[] = $funeral->req_relation;

			    $date_of_req = '-';
			    if($funeral->date_of_req!='') {
			        $date_of_req = '<font class="text-sucsess" color="#18bd15">'.dateChange($funeral->date_of_req,5).'</font>';
			    }
			    $row[] = "<center>".$date_of_req."</center>";

			    $date_of_pay = '-';
			    if($funeral->date_of_pay!='') {
			        $date_of_pay = '<font class="text-sucsess" color="#18bd15">'.dateChange($funeral->date_of_pay,5).'</font>';
			    }
			    $row[] = "<center>".$date_of_pay."</center>";
			    //$row[] ="<div style='width:100%;text-align:right;'>".number_format($funeral->pay_amount,2)."</div>";



			    $tmp = $this->admin_model->getOnce_Application(3);
                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                $btn = '';
                $btn =$btn.'<!-- Single button -->
                <div class="btn-group" style="cursor: pointer;">
                  <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>

                  <ul class="dropdown-menu" style="position: absolute;left: -190px;">';

                  $btn = $btn.' <li><a style="font-size:16px;" data-toggle="modal" data-target="#prt'.$funeral->fnrl_id.'" title="พิมพ์แบบฟอร์ม" >
                       <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #000"></i> พิมพ์แบบฟอร์ม (.PDF)
                   </a></li>';


                  $btn =$btn.'<li><a  style="font-size:16px;"';

                  if(!isset($tmp1['perm_status'])){ $btn =$btn.'class="disabled"';}else{ $btn =$btn.'href="'.site_url("funeral/inform1/Edit/".$funeral->fnrl_id); }
                  $btn =$btn.'"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>';

                    $tmp = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                    if(isset($tmp['perm_status'])) {
                        if($tmp['perm_status']=='Yes') {
                         $btn = $btn.'<li><a style="font-size:16px;" data-id='.$funeral->fnrl_id.' onclick="opn(this)" title="ลบ" >
                             <i class="fa fa-trash" style="color: #000"></i> ลบรายการ
                          </a></li>';
                      }
                    }

                  $btn = $btn.'</ul>
                              </div>';

                $btn =$btn.'<!-- Print Modal -->
                   <div class="modal fade" id="prt'.$funeral->fnrl_id.'" role="dialog">
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
                                 <a style="color: #333; font-size: 16px;" target="_blank" href="'.site_url('report/C1/pdf?id='.$funeral->fnrl_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
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

                     $btn = $btn.'<a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/C2/pdf?id='.$funeral->fnrl_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
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
                    $btn = $btn.'<a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/C3/pdf?id='.$funeral->fnrl_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
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
								//$row[] = "";
                $data[] = $row;
            }


			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->funeral->count_all(),
							"recordsFiltered" => $this->funeral->count_filtered(),
							"data" => $data,
					);
			//output to json format
			echo json_encode($output);
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	public function funeral_list($process_action='View') { // ตารางข้อมูล
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 21;
		$process_path = 'funeral/funeral_list';
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

			//set_js_asset_footer('funeral_list.js','funeral'); //Set JS Index.js
    		set_js_asset_footer('funeral_list_ajax.js','funeral'); //Set JS Index.js

    		//set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/ion.rangeSlider.min.js'); //Set JS Index.js

/*			$data['fnrl_info'] = $this->common_model->custom_query("
				SELECT * FROM fnrl_info
				WHERE delete_user_id IS NULL
				AND (delete_datetime IS NULL || delete_datetime = '0000-00-00 00:00:00')
        ORDER BY update_datetime DESC,insert_datetime DESC
        LIMIT 0,100
			");*/

			$data['process_action'] = $process_action;
			$data['content_view'] = 'funeral_list_ajax';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page',$data,'funeral');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
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

	private function clr_fnrlInfo_form1() {
		return array(
					'date_of_req' => date('d-m-Y'),
					'req_pid' => '',
					'req_pers_id' => '',
					'req_name' => ' - ',
					'req_date_of_birth' => ' - ',
					'req_gender_name' => ' - ',
					'req_nation_name_th' => ' - ',
					'req_relg_title' => ' - ',
					'req_position' => '',
					'req_org' => '',
					'req_relation' => '',
					// 'req_tel_no_home' => '',
					'req_tel_no_mobile' => '',
					// 'req_fax_no' => '',
					// 'req_email_addr' => '',

					'pid' => '',
					'pers_id' => '',
					'name' => ' - ',
					'date_of_birth' => ' - ',
					'gender_name' => ' - ',
					'nation_name_th' => ' - ',
					'relg_title' => ' - ',
					// 'tel_no_home' => '',
					'tel_no_mobile' => '',
					// 'fax_no' => '',
					// 'email_addr' => '',

					'reg_addr_id' => '',
					'pre_addr_id' => '',

					'date_of_req_pers_aprv' => '',
					'req_pers_aprv_pid' => '',
					'req_pers_aprv_pers_id' => '',
					'req_pers_aprv_name' => ' - ',
					'req_pers_aprv_date_of_birth' => ' - ',
					'req_pers_aprv_gender_name' => ' - ',
					'req_pers_aprv_nation_name_th' => ' - ',
					'req_pers_aprv_relg_title' => ' - ',
					'req_pers_aprv_position' => '',
					'req_pers_aprv_org' => '',
					'req_pers_aprv_relation' => '',
					// 'req_pers_aprv_tel_no_home' => '',
					'req_pers_aprv_tel_no_mobile' => '',
					// 'req_pers_aprv_fax_no' => '',
					// 'req_pers_aprv_email_addr' => '',

					'date_of_not_survey_aprv' => '',
					'not_survey_aprv_pid' => '',
					'not_survey_aprv_pers_id' => '',
					'not_survey_aprv_name' => ' - ',
					'not_survey_aprv_date_of_birth' => ' - ',
					'not_survey_aprv_gender_name' => ' - ',
					'not_survey_aprv_nation_name_th' => ' - ',
					'not_survey_aprv_relg_title' => ' - ',
					'not_survey_aprv_position' => '',
					'not_survey_aprv_org' => '',
					'not_survey_aprv_relation' => '',
					// 'not_survey_aprv_tel_no_home' => '',
					'not_survey_aprv_tel_no_mobile' => '',
					// 'not_survey_aprv_fax_no' => '',
					// 'not_survey_aprv_email_addr' => '',
		);
	}

	public function inform1($process_action='Add',$fnrl_id=0) { //แบบขอรับบริการ (แจ้งเรื่อง)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 22;
		$process_path = 'funeral/inform1';
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

  		set_js_asset_footer('webservice.js','personals'); //Set JS webservice.js
  		set_js_asset_footer('inform1.js','funeral'); //Set JS inform1.js

  		set_js_asset_footer('mapmarker.js','webconfig'); //Set JS mapmarker.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'inform1';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$data['fnrl_info'] = $this->clr_fnrlInfo_form1();

				// dieArray($data['fnrl_info']);
				$this->template->load('index_page',$data,'funeral');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('fnrl_info[date_of_req]','วันที่แจ้งเรื่อง','required|callback_date_check');
				$frm->set_rules('fnrl_info[req_pers_id]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
				$frm->set_rules('fnrl_info[pers_id]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_insert = array(
						'date_of_req'				=> dateChange(get_inpost('fnrl_info[date_of_req]')),
						'req_pers_id'				=> get_inpost('fnrl_info[req_pers_id]'),
						'req_position'				=> get_inpost('fnrl_info[req_position]'),
						'req_org'					=> get_inpost('fnrl_info[req_org]'),
						'req_relation'				=> get_inpost('fnrl_info[req_relation]'),

						'pers_id'					=> get_inpost('fnrl_info[pers_id]'),
						'death_cause'				=> get_inpost('fnrl_info[death_cause]'),
						'death_certificate_no'		=> get_inpost('fnrl_info[death_certificate_no]'),
						'death_certificate_org'		=> get_inpost('fnrl_info[death_certificate_org]'),
						'date_of_death_certificate'	=> dateChange(get_inpost('fnrl_info[date_of_death_certificate]')),

						'date_of_req_pers_aprv'		=> dateChange(get_inpost('fnrl_info[date_of_req_pers_aprv]')),
						'req_pers_aprv_pers_id'		=> get_inpost('fnrl_info[req_pers_aprv_pers_id]'),
						'req_pers_aprv_position'	=> get_inpost('fnrl_info[req_pers_aprv_position]'),
						'req_pers_aprv_org'			=> get_inpost('fnrl_info[req_pers_aprv_org]'),

						'date_of_not_survey_aprv'	=> dateChange(get_inpost('fnrl_info[date_of_not_survey_aprv]')),
						'not_survey_aprv_pers_id'	=> get_inpost('fnrl_info[not_survey_aprv_pers_id]'),
						'not_survey_aprv_position'	=> get_inpost('fnrl_info[not_survey_aprv_position]'),
						'not_survey_aprv_org'		=> get_inpost('fnrl_info[not_survey_aprv_org]'),

						'insert_user_id'			=> getUser(),
						'insert_org_id'				=> get_session('org_id'),
						'insert_datetime'			=> getDatetime(),
						);

					// dieArray($data_insert);
					$id = $this->common_model->insert('fnrl_info',$data_insert);

					// update data pers_info //////////////////
					$req_pers_info = array(
						// 'tel_no_home' => get_inpost('fnrl_info[req_tel_no_home]'),
						'tel_no' => get_inpost('fnrl_info[req_tel_no_mobile]'),
						// 'fax_no' => get_inpost('fnrl_info[req_fax_no]'),
						// 'email_addr' => get_inpost('fnrl_info[req_email_addr]'),
						'update_user_id' => getUser(),
						'update_org_id' => get_session('org_id'),
						'update_datetime' => getDatetime(),

					);
					$this->common_model->update('pers_info',$req_pers_info,array('pers_id'=>get_inpost('fnrl_info[req_pers_id]')));

					$data_update_pers = get_inpost_arr('pers_info');

					$data_update_pers['tel_no'] 			= $data_update_pers['tel_no_mobile'];

					unset($data_update_pers['tel_no_mobile']);
					unset($data_update_pers['tel_no_home']);
					unset($data_update_pers['fax_no']);
					unset($data_update_pers['email_addr']);

					$data_update_pers['date_of_death'] 		= dateChange($data_update_pers['date_of_death']);
					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

					if(get_inpost('elder_addr_chk')!='on') {
						//add new addr
						$data_insert_addr = get_inpost_arr('pers_addr');
						$data_insert_addr['insert_user_id']		= getUser();
						$data_insert_addr['insert_datetime']	= getDatetime();

						$new_addr_id = $this->common_model->insert('pers_addr',$data_insert_addr);
						$data_update_pers['pre_addr_id'] = $new_addr_id;
					}else{
						$data_update_pers['pre_addr_id'] = $data_update_pers['reg_addr_id'];
					}

					$this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('fnrl_info[pers_id]')));

					$req_pers_aprv_pers_info = array(
													// 'tel_no_home' => get_inpost('fnrl_info[req_pers_aprv_tel_no_home]'),
													'tel_no' 			=> get_inpost('fnrl_info[req_pers_aprv_tel_no_mobile]'),
													// 'fax_no' => get_inpost('fnrl_info[req_pers_aprv_fax_no]'),
													// 'email_addr' => get_inpost('fnrl_info[req_pers_aprv_email_addr]'),
													'update_user_id' 	=> getUser(),
													'update_org_id' 	=> get_session('org_id'),
													'update_datetime' 	=> getDatetime(),
													);
					$this->common_model->update('pers_info',$req_pers_aprv_pers_info,array('pers_id'=>get_inpost('fnrl_info[req_pers_aprv_pers_id]')));

					if(get_inpost('fnrl_info[not_survey_aprv_pid]') != ''){
						$not_survey_aprv_pers_info = array(
														// 'tel_no_home' => get_inpost('fnrl_info[not_survey_aprv_tel_no_home]'),
														'tel_no' 			=> get_inpost('fnrl_info[not_survey_aprv_tel_no_mobile]'),
														// 'fax_no' => get_inpost('fnrl_info[not_survey_aprv_fax_no]'),
														// 'email_addr' => get_inpost('fnrl_info[not_survey_aprv_email_addr]'),
														'update_user_id' 	=> getUser(),
														'update_org_id' 	=> get_session('org_id'),
														'update_datetime'	=> getDatetime(),
														 );
						$this->common_model->update('pers_info',$not_survey_aprv_pers_info,array('pers_id'=>get_inpost('fnrl_info[not_survey_aprv_pers_id]')));
					}
					///////////////////////////////////////////

					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('funeral/assist2/Edit/'.$id,'refresh');

				}else {
					$data['fnrl_info'] = get_inpost_arr('fnrl_info');

					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

					$this->template->load('index_page',$data,'funeral');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {

				$row = rowArray($this->common_model->custom_query("
					SELECT * FROM fnrl_info
					WHERE delete_user_id IS NULL
					AND (delete_datetime IS NULL || delete_datetime = '0000-00-00 00:00:00')
					AND fnrl_id = {$fnrl_id}
	        		ORDER BY update_datetime DESC,insert_datetime DESC
				"));
				// dieArray($row);
				if(isset($row['fnrl_id'])) {
					// $data['fnrl_info'] = array_merge($this->clr_fnrlInfo_form1(),$row);
					// $data['fnrl_info'] = array_merge($this->clr_fnrlInfo_form1(),$row);
					$data['fnrl_info'] = $row;

					$pers_info = $this->personal_model->getOnce_PersonalInfo($row['pers_id']);
					$data['addr_info'] 					= $this->personal_model->getOnce_PersonalAddress($pers_info['pre_addr_id']);
					$data['pers_info'] 					= $pers_info;
                    $data['pers_info']['tel_no_mobile'] = $pers_info['tel_no'];

					$data['fnrl_info']['pid'] 			= $pers_info['pid'];
					$data['fnrl_info']['reg_addr_id'] 	= $pers_info['reg_addr_id'];
					$data['fnrl_info']['pre_addr_id'] 	= $pers_info['pre_addr_id'];
					$data['fnrl_info']['pers_id'] 		= $pers_info['pers_id'];
					$data['fnrl_info']['name'] 			= $pers_info['name'];

          if($pers_info['date_of_birth']!='') {
            $date = new DateTime($pers_info['date_of_birth']);
            $now = new DateTime($pers_info['date_of_death']);
            $interval = $now->diff($date);
            $age = $interval->y;
            $data['fnrl_info']['date_of_birth'] = formatDateThai($pers_info['date_of_birth'])." ( เสียชีวิต ". formatDateThai($pers_info['date_of_death'])." ) (อายุ ".$age." ปี)";
          }else {
          	$data['fnrl_info']['date_of_birth'] = ' - ';
          }
					$data['fnrl_info']['gender_name'] = $pers_info['gender_name']==''?' - ':$pers_info['gender_name'];
					$data['fnrl_info']['nation_name_th'] = $pers_info['nation_name_th']==''?' - ':$pers_info['nation_name_th'];
					$data['fnrl_info']['relg_title'] = $pers_info['relg_title']==''?' - ':$pers_info['relg_title'];

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['fnrl_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					if($pers_info['date_of_death']!='') {
						$tmp = explode('-',$pers_info['date_of_death']);
						$data['pers_info']['date_of_death'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					if($row['date_of_death_certificate']!='') {
						$tmp = explode('-',$row['date_of_death_certificate']);
						$data['fnrl_info']['date_of_death_certificate'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}

					if($row['date_of_req_pers_aprv']!='') {
						$tmp = explode('-',$row['date_of_req_pers_aprv']);
						$data['fnrl_info']['date_of_req_pers_aprv'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}

					if($row['date_of_not_survey_aprv']!='') {
						$tmp = explode('-',$row['date_of_not_survey_aprv']);
						$data['fnrl_info']['date_of_not_survey_aprv'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}

					// $row['req_pers_id'] = $row['req_pers_id']==''?0:$row['req_pers_id'];
					$tmp2 = $this->personal_model->getOnce_PersonalInfo($row['req_pers_id']);
					if(isset($tmp2['pid'])) {
						$data['fnrl_info']['req_pid'] = $tmp2['pid'];
						$data['fnrl_info']['req_name'] = $tmp2['name'];
			            if($tmp2['date_of_birth']!='') {
			              $date = new DateTime($tmp2['date_of_birth']);
			              $now = new DateTime();
			              $interval = $now->diff($date);
			              $age = $interval->y;
			              $data['fnrl_info']['req_date_of_birth'] = formatDateThai($tmp2['date_of_birth']).' (อายุ '.$age.' ปี)';
			            }else {
			            	$data['fnrl_info']['req_date_of_birth'] = ' - ';
			            }
						$data['fnrl_info']['req_gender_name'] 		= $tmp2['gender_name']==''?' - ':$tmp2['gender_name'];
						$data['fnrl_info']['req_nation_name_th'] 	= $tmp2['nation_name_th']==''?' - ':$tmp2['nation_name_th'];
						$data['fnrl_info']['req_relg_title'] 		= $tmp2['relg_title']==''?' - ':$tmp2['relg_title'];
						$data['fnrl_info']['req_pers_id'] 			= $tmp2['pers_id'];
						// $data['fnrl_info']['req_tel_no_home'] 		= $tmp2['tel_no_home'];
						$data['fnrl_info']['req_tel_no_mobile'] 	= $tmp2['tel_no'];
						// $data['fnrl_info']['req_fax_no'] 			= $tmp2['fax_no'];
						// $data['fnrl_info']['req_email_addr'] 		= $tmp2['email_addr'];
					}

					$tmp3 = $this->personal_model->getOnce_PersonalInfo($row['req_pers_aprv_pers_id']);
					// dieArray($tmp3);
					if(isset($tmp3['pid'])) {
							$data['fnrl_info']['req_pers_aprv_pid']  = $tmp3['pid'];
							$data['fnrl_info']['req_pers_aprv_name'] = $tmp3['name'];
			            if($tmp3['date_of_birth']!='') {
			              $date = new DateTime($tmp3['date_of_birth']);
			              $now  = new DateTime();
			              $interval = $now->diff($date);
			              $age = $interval->y;
			              $data['fnrl_info']['req_pers_aprv_date_of_birth'] = formatDateThai($tmp3['date_of_birth']).' (อายุ '.$age.' ปี)';
			            }else {
			            	$data['fnrl_info']['req_pers_aprv_date_of_birth'] = ' - ';
			            }
						$data['fnrl_info']['req_pers_aprv_gender_name'] 		= $tmp3['gender_name']==''?' - ':$tmp3['gender_name'];
						$data['fnrl_info']['req_pers_aprv_nation_name_th'] 		= $tmp3['nation_name_th']==''?' - ':$tmp3['nation_name_th'];
						$data['fnrl_info']['req_pers_aprv_relg_title'] 			= $tmp3['relg_title']==''?' - ':$tmp3['relg_title'];
						$data['fnrl_info']['req_pers_aprv_pers_id'] 			= $tmp3['pers_id'];
						// $data['fnrl_info']['req_pers_aprv_tel_no_home'] 		= $tmp3['tel_no_home'];
						$data['fnrl_info']['req_pers_aprv_tel_no_mobile'] 		= $tmp3['tel_no'];
						// $data['fnrl_info']['req_pers_aprv_fax_no'] 				= $tmp3['fax_no'];
						// $data['fnrl_info']['req_pers_aprv_email_addr'] 			= $tmp3['email_addr'];
					}

					$tmp4 = $this->personal_model->getOnce_PersonalInfo($row['not_survey_aprv_pers_id']);
					if(isset($tmp4['pid'])) {
						$data['fnrl_info']['not_survey_aprv_pid']  = $tmp4['pid'];
						$data['fnrl_info']['not_survey_aprv_name'] = $tmp4['name'];
			            if($tmp4['date_of_birth']!='') {
			              $date = new DateTime($tmp4['date_of_birth']);
			              $now = new DateTime();
			              $interval = $now->diff($date);
			              $age = $interval->y;
			              $data['fnrl_info']['not_survey_aprv_date_of_birth'] = formatDateThai($tmp4['date_of_birth']).' (อายุ '.$age.' ปี)';
			            }else {
			            	$data['fnrl_info']['not_survey_aprv_date_of_birth'] = ' - ';
			            }
						$data['fnrl_info']['not_survey_aprv_gender_name'] 		= $tmp4['gender_name']==''?' - ':$tmp4['gender_name'];
						$data['fnrl_info']['not_survey_aprv_nation_name_th'] 	= $tmp4['nation_name_th']==''?' - ':$tmp4['nation_name_th'];
						$data['fnrl_info']['not_survey_aprv_relg_title'] 		= $tmp4['relg_title']==''?' - ':$tmp4['relg_title'];
						$data['fnrl_info']['not_survey_aprv_pers_id'] 			= $tmp4['pers_id'];
						// $data['fnrl_info']['not_survey_aprv_tel_no_home'] 		= $tmp4['tel_no_home'];
						$data['fnrl_info']['not_survey_aprv_tel_no_mobile'] 	= $tmp4['tel_no'];
						// $data['fnrl_info']['not_survey_aprv_fax_no'] 			= $tmp4['fax_no'];
						// $data['fnrl_info']['not_survey_aprv_email_addr'] 		= $tmp4['email_addr'];
					}
					// dieArray($data);
					$this->template->load('index_page',$data,'funeral');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('fnrl_info[date_of_req]','วันที่แจ้งเรื่อง','callback_date_check');
				$frm->set_rules('fnrl_info[req_pid]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
				$frm->set_rules('fnrl_info[pid]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = array(
						'date_of_req'				=> dateChange(get_inpost('fnrl_info[date_of_req]')),
						'req_pers_id'				=> get_inpost('fnrl_info[req_pers_id]'),
						'req_position'				=> get_inpost('fnrl_info[req_position]'),
						'req_org'					=> get_inpost('fnrl_info[req_org]'),
						'req_relation'				=> get_inpost('fnrl_info[req_relation]'),

						'pers_id'					=> get_inpost('fnrl_info[pers_id]'),
						'death_cause'				=> get_inpost('fnrl_info[death_cause]'),
						'death_certificate_no'		=> get_inpost('fnrl_info[death_certificate_no]'),
						'death_certificate_org'		=> get_inpost('fnrl_info[death_certificate_org]'),
						'date_of_death_certificate'	=> dateChange(get_inpost('fnrl_info[date_of_death_certificate]')),

						'date_of_req_pers_aprv'		=> dateChange(get_inpost('fnrl_info[date_of_req_pers_aprv]')),
						'req_pers_aprv_pers_id'		=> get_inpost('fnrl_info[req_pers_aprv_pers_id]'),
						'req_pers_aprv_position'	=> get_inpost('fnrl_info[req_pers_aprv_position]'),
						'req_pers_aprv_org'			=> get_inpost('fnrl_info[req_pers_aprv_org]'),

						'date_of_not_survey_aprv'	=> dateChange(get_inpost('fnrl_info[date_of_not_survey_aprv]')),
						'not_survey_aprv_pers_id'	=> get_inpost('fnrl_info[not_survey_aprv_pers_id]'),
						'not_survey_aprv_position'	=> get_inpost('fnrl_info[not_survey_aprv_position]'),
						'not_survey_aprv_org'		=> get_inpost('fnrl_info[not_survey_aprv_org]'),

						'update_user_id'			=> getUser(),
						'update_org_id'				=> get_session('org_id'),
						'update_datetime'			=> getDatetime(),
					);

					// dieArray($data_update);
					$this->common_model->update('fnrl_info',$data_update,array('fnrl_id'=>$fnrl_id));

					// update data pers_info //////////////////
					$req_pers_info = array(

										// 'tel_no_home' => get_inpost('fnrl_info[req_tel_no_home]'),
										'tel_no' 			=> get_inpost('fnrl_info[req_tel_no_mobile]'),
										// 'fax_no' => get_inpost('fnrl_info[req_fax_no]'),
										// 'email_addr' => get_inpost('fnrl_info[req_email_addr]'),
										'update_user_id' 	=> getUser(),
										'update_org_id' 	=> get_session('org_id'),
										'update_datetime' 	=> getDatetime(),

										);
					$this->common_model->update('pers_info',$req_pers_info,array('pers_id'=>get_inpost('fnrl_info[req_pers_id]')));

					$data_update_pers = get_inpost_arr('pers_info');
					$data_update_pers['date_of_death'] 		= dateChange($data_update_pers['date_of_death']);

					$data_update_pers['tel_no']             = $data_update_pers['tel_no_mobile'];
					unset($data_update_pers['tel_no_mobile']);

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

					if(get_inpost('elder_addr_chk')!='on') {
						//add new addr
						$data_insert_addr = get_inpost_arr('pers_addr');
						$data_insert_addr['insert_user_id']		= getUser();
						$data_insert_addr['insert_datetime']	= getDatetime();

						$this->common_model->update('pers_addr',$data_update_addr,array('addr_id'=>get_inpost('pre_addr_id')));

						// $new_addr_id = $this->common_model->insert('pers_addr',$data_insert_addr);
						// $data_update_pers['pre_addr_id'] = $new_addr_id;
					}else{
						$data_update_pers['pre_addr_id'] = $data_update_pers['reg_addr_id'];
					}

					$this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('fnrl_info[pers_id]')));

					$req_pers_aprv_pers_info = array(
													// 'tel_no_home' => get_inpost('fnrl_info[req_pers_aprv_tel_no_home]'),
													'tel_no' 			=> get_inpost('fnrl_info[req_pers_aprv_tel_no_mobile]'),
													// 'fax_no' => get_inpost('fnrl_info[req_pers_aprv_fax_no]'),
													// 'email_addr' => get_inpost('fnrl_info[req_pers_aprv_email_addr]'),
													'update_user_id' 	=> getUser(),
													'update_org_id' 	=> get_session('org_id'),
													'update_datetime' 	=> getDatetime(),
												);
					$this->common_model->update('pers_info',$req_pers_aprv_pers_info,array('pers_id'=>get_inpost('fnrl_info[req_pers_aprv_pers_id]')));

					if(get_inpost('fnrl_info[not_survey_aprv_pid]') != ''){
						$not_survey_aprv_pers_info = array(
														// 'tel_no_home' => get_inpost('fnrl_info[not_survey_aprv_tel_no_home]'),
														'tel_no' 			=> get_inpost('fnrl_info[not_survey_aprv_tel_no_mobile]'),
														// 'fax_no' => get_inpost('fnrl_info[not_survey_aprv_fax_no]'),
														// 'email_addr' => get_inpost('fnrl_info[not_survey_aprv_email_addr]'),
														'update_user_id' 	=> getUser(),
														'update_org_id' 	=> get_session('org_id'),
														'update_datetime' 	=> getDatetime(),
													);
						$this->common_model->update('pers_info',$not_survey_aprv_pers_info,array('pers_id'=>get_inpost('fnrl_info[not_survey_aprv_pers_id]')));
					}
					///////////////////////////////////////////

					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					// dieArray($data_update);
					redirect('funeral/inform1/Edit/'.$fnrl_id,'refresh');
				}else {


					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'funeral');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['delete_org_id']		= get_session('org_id');
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('fnrl_info',$data_update,array('fnrl_id'=>$fnrl_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('funeral/assist_list','refresh');
			}else {
				page500();
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function assist2($process_action='Add',$fnrl_id=0) { //ข้อมูลการสงเคราห์
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 23;
		$process_path = 'funeral/assist2';
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if($usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500();
			echo $user_id;
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		}else {
			$app_name 					= $usrpm['app_name'];
			$data['usrpm'] 			= $usrpm;
			$data['user_id'] 		= $user_id;

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

			set_js_asset_footer('assist2.js','funeral'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] 	= 'assist2';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			// dieArray($usrpm);
			if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = rowArray($this->common_model->custom_query("
					select A.*,B.*,C.*,D.*,E.*,G.*,CONCAT(B.pers_firstname_th, ' ', B.pers_lastname_th) as name
					from fnrl_info as A
					left join pers_info as B       on A.pers_id=B.pers_id
					left join std_prename as C     on B.pren_code=C.pren_code
					left join std_gender as D      on B.gender_code=D.gender_code
					left join std_nationality as E on B.nation_code=E.nation_code
					left join std_edu_level as G    on B.edu_code=G.edu_code
					where (A.delete_user_id IS NULL && A.delete_datetime IS NULL) and
					(B.delete_user_id IS NULL && B.delete_datetime IS NULL)
					and fnrl_id='{$fnrl_id}'
				"));
				// dieArray($row);
				if(isset($row['fnrl_id'])) {

					$data['fnrl_info'] 				= $row;
					if($row['date_of_pay']!='') {
						$tmp = explode('-',$row['date_of_pay']);
						$data['fnrl_info']['date_of_pay'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['fnrl_info']['date_of_pay'] = date("d-m-Y");
					}

					if($row['date_of_receipt']!='') {
						$tmp = explode('-',$row['date_of_receipt']);
						$data['fnrl_info']['date_of_receipt'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['fnrl_info']['date_of_receipt'] = date("d-m-Y");
					}

					$this->template->load('index_page',$data,'funeral');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('fnrl_info[date_of_pay]','วันที่รับเงิน','required|callback_date_check');
				// $frm->set_rules('fnrl_info[date_of_receipt]','วันที่ออกใบสำคัญรับเงิน','required|callback_date_check');
				$frm->set_rules('fnrl_info[pay_amount]','จำนวนเงินที่สงเคราะห์','required');
				$frm->set_rules('fnrl_info[payee_type]','ผู้รับเงิน','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				// dieArray($_POST);
				if($frm->run($this)){//Valid Data

					// fnrl_info
					$data_update = get_inpost_arr('fnrl_info');
					$data_update['date_of_pay'] 		= dateChange($data_update['date_of_pay']);
					// $data_update['date_of_receipt'] = dateChange($data_update['date_of_receipt'],4);

					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();

					$this->common_model->update('fnrl_info',$data_update,array('fnrl_id'=>$fnrl_id));

					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('funeral/assist2/Edit/'.$fnrl_id,'refresh');

				}else {
					$data['fnrl_info'] = get_inpost_arr('fnrl_info');
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'funeral');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else {
				page500();
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}
		}
	}
}
