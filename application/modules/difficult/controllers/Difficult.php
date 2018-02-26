<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Difficult extends MX_Controller {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function assist_list_ajax($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		ini_set('max_execution_time', 300);

		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 2;
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

			$this->load->model('assist_list_model','manage_transfer');
			$list = $this->manage_transfer->get_datatables();
      // echo count($list);

			$data = array();
			$no = $_POST['start'];
			foreach ($list as $i=>$manage_transfer) {
				$no++;
				$row = array();

                $row[] = "<center>".$no."</center>";
                $row[] = $manage_transfer->pid;
                $row[] = $manage_transfer->prename_th." ".$manage_transfer->name;

                $row[] = $manage_transfer->gender_name;

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
                if($manage_transfer->date_of_req!='' && $manage_transfer->date_of_req!='0000-00-00') {
                    $date_of_req = '<font class="text-sucsess" color="#18bd15">'.dateChange($manage_transfer->date_of_req,5).'</font>';
                }else {
                	$date_of_req = '<font class="text-sucsess" color="#B9B9B9">ยังไม่ได้แจ้งเรื่อง</font>';
                }
                $row[] = "<center>".$date_of_req."</center>";

                $date_of_visit = '';
                if($manage_transfer->date_of_visit!='' && $manage_transfer->date_of_visit!='0000-00-00') {
                    $date_of_visit = '<font class="text-sucsess" color="#18bd15">'.dateChange($manage_transfer->date_of_visit,5).'</font>';
                }else{
                    $date_of_visit = '<font class="text-sucsess" color="#B9B9B9">รอตรวจเยี่ยม</font>';
                }
                $row[] = "<center>".$date_of_visit."</center>";

                $date_of_pay = '';
                if($manage_transfer->date_of_pay!='' && $manage_transfer->date_of_pay!='0000-00-00') {
                    $date_of_pay = '<font class="text-sucsess" color="#18bd15">'.dateChange($manage_transfer->date_of_pay,5).'</font>';
                }else{
                    $date_of_pay = '<font class="text-sucsess" color="#B9B9B9">รอช่วยเหลือ</font>';
                }
                $row[] = "<center>".$date_of_pay."</center>";
								//$row[] = "<center>".$manage_transfer->gender_code."</center>";
                $row[] = "<div style='width:100%;text-align:right;'>".number_format($manage_transfer->pay_amount,2)."</div>";


                $tmp = $this->admin_model->getOnce_Application(3);
                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                $btn = '';
                $btn =$btn.'<!-- Single button -->
                <div class="btn-group" style="cursor: pointer;">
                  <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>

                  <ul class="dropdown-menu" style="position: absolute;left: -190px;">';

                  $btn = $btn.' <li><a style="font-size:16px;" data-toggle="modal" data-target="#prt'.$manage_transfer->diff_id.'" title="พิมพ์แบบฟอร์ม" >
                       <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #000"></i> พิมพ์แบบฟอร์ม (.PDF)
                   </a></li>';


                  $btn =$btn.'<li><a  style="font-size:16px;"';

                  if(!isset($tmp1['perm_status'])){ $btn =$btn.'class="disabled"';}else{ $btn =$btn.'href="'.site_url("difficult/sufferer_form1/Edit/".$manage_transfer->diff_id); }
                  $btn =$btn.'"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>';




                    $tmp = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                    if(isset($tmp['perm_status'])) {
                        if($tmp['perm_status']=='Yes') {
                         $btn = $btn.'<li><a style="font-size:16px;" data-id='.$manage_transfer->diff_id.' onclick="opn(this)" title="ลบ" >
                             <i class="fa fa-trash" style="color: #000"></i> ลบรายการ
                          </a></li>';
                      }
                    }

                  $btn = $btn.'</ul>
                              </div>';

                $btn =$btn.'<!-- Print Modal -->
                   <div class="modal fade" id="prt'.$manage_transfer->diff_id.'" role="dialog">
                     <div class="modal-dialog">

                        <!-- Modal content-->
                       <div class="modal-content">
                         <div class="modal-header text-left">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" style="color: #333; font-size: 16px;">พิมพ์แบบฟอร์ม</h4>
                          </div>
                         <div class="modal-body">
                           <div class="row">';

                    $tmp = $this->admin_model->getOnce_Application(7);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(7,get_session('user_id')); //Check User Permission

                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;"';
                    if(!isset($tmp1['perm_status'])) {
                      $btn = $btn.' class="disabled "';
                    }else if($usrpm['app_id']==7) {
                      $btn = $btn.' class="active "';
                    }
                    $btn = $btn.'>
                                 <a style="color: #333; font-size: 16px;" target="_blank" href="'.site_url('report/A1/pdf?id='.$manage_transfer->diff_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                    if(isset($tmp1['perm_status'])) {
                     $btn = $btn.$tmp1['app_name'];
                    }
                    $btn = $btn.'  </a>
                             </div>';

                    $tmp = $this->admin_model->getOnce_Application(8);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(8,get_session('user_id')); //Check User Permission
                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                    if(!isset($tmp1['perm_status'])) {
                        $btn = $btn.' class="disabled" ';
                    }else if($usrpm['app_id']==8) {
                        $btn = $btn.' class="active" ';
                    }
                    $btn = $btn.'>';

                     $btn = $btn.'<a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/A2/pdf?id='.$manage_transfer->diff_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                     if(isset($tmp1['perm_status'])) {
                       $btn = $btn.$tmp1['app_name'];
                     }
                     $btn = $btn.'
                            </a>
                          </div>';

                    $tmp = $this->admin_model->getOnce_Application(9);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(9,get_session('user_id')); //Check User Permission

                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                    if(!isset($tmp1['perm_status'])) {
                        $btn = $btn.' class="disabled" ';
                      }else if($usrpm['app_id']==9) {
                        $btn = $btn.' class="active" ';
                      }
                    $btn = $btn.'>';
                    $btn = $btn.'<a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/A3/pdf?id='.$manage_transfer->diff_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                    if(isset($tmp1['perm_status'])) {
                     $btn = $btn.$tmp1['app_name'];
                    }
                    $btn = $btn.'</a>
                            </div>';

                    $tmp = $this->admin_model->getOnce_Application(10);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(10,get_session('user_id')); //Check User Permission
                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                            if(!isset($tmp1['perm_status'])) {
                                $btn = $btn.' class="disabled" ';
                            }else if($usrpm['app_id']==10) {
                                $btn = $btn.' class="active" ';
                            }
                    $btn = $btn.'>
                              <a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/A4/pdf?id='.$manage_transfer->diff_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
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

                $row[] = "";

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

	public function assist_list($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		ini_set('max_execution_time', 300);
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 2;
		$process_path = 'difficult/assist_list';
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

			//$data['diff_info'] = $this->difficult_model->getAll_diffInfo();

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

			//set_js_asset_footer('assist_list.js','difficult'); //Set JS Index.js
			set_js_asset_footer('assist_list_ajax.js','difficult'); //Set JS Index.js
			//set_js_asset_head('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/jquery-git.js');
      //set_js_asset_head('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/ion.rangeSlider.min.js'); //Set JS Index.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'assist_list_ajax';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page',$data,'difficult');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}
/*
	private function clr_diffInfo() {
		return array(
					'date_of_req' => date('d-m-Y'),
				 	'pers_id' => '',
					'elder_none_inasmuch' => '',
					'elder_prename' => '',
					'elder_firstname' => '',
					'elder_lastname' => '',
					'elder_tel_no' => '',

					'req_pers_id' => '',
					'req_none_inasmuch' => '',
					'req_prename' => '',
			    	'req_firstname' => '',
			    	'req_lastname' => '',
					'req_home_tel_no' => '',
					'req_tel_no' => '',
					'req_position' => '',
					'req_depart' => '',
					'req_channel' => ''
		);
	}
*/
/*
	public function sufferer_preform1($process_action='Add',$diff_id=0) { //บันทึกแจ้งขอรับบริการสงเคราะห์
		$data = array(); //Set Initial Variable to Views
*/
		/*-- Initial Data for Check User Permission --*/
/*
		$user_id = get_session('user_id');
		$app_id = 20;
		$process_path = 'difficult/sufferer_preform1';
*/
		/*--END Inizial Data for Check User Permission--*/
/*
		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission
		if(count($usrpm)<1){
			page500();
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			$data['process_action'] = $process_action;
			$data['content_view'] = 'sufferer_preform1';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $app_name;

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_can_edit']=='Yes') {
				$data['diff_info'] = $this->clr_diffInfo();
				$data['rd_pers_id'] = '';
				$data['rd_req_pers_id'] = '';

			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_can_edit']=='Yes'){ //Add && Submit Form

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				if(get_inpost('diff_info[date_of_req]')!='') {
					$frm->set_rules('diff_info[date_of_req]','วันที่แจ้งเรื่อง','required|callback_date_check');
					$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");
				}

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

				$frm->set_message("required","กรุณากรอกข้อมูล %s");

				if($frm->run($this)){//Valid Data

					$data_insert = $_POST['diff_info'];
					$data_insert['date_of_req'] = dateChange($data_insert['date_of_req'],4);
					$data_insert['insert_user_id'] = getUser();
					$data_insert['insert_datetime'] = getDatetime();

					$this->common_model->insert('diff_info',$data_insert);
					$data['msg'] = setMsg('011'); //Set Message code 011

					if(get_inpost('state')==1) {
						$data['diff_info'] = $this->clr_diffInfo();
						$data['rd_pers_id'] = '';
						$data['rd_req_pers_id'] = '';
					}else {
						$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
						redirect('difficult/assist_list','refresh');
					}

				}else {
					$data['diff_info'] = $_POST['diff_info'];
					$data['rd_pers_id'] = set_value('rd_pers_id');
					$data['rd_req_pers_id'] = set_value('rd_req_pers_id');
					$data['msg'] = setMsg('012'); //Set Message code 012
				}

			}else if($process_action=='View' && get_inpost('bt_submit')=='' && $usrpm['perm_can_view']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);

				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['diff_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}

					if($row['pers_id']!=0)$data['rd_pers_id'] = 1;
					else $data['rd_pers_id'] = 2;

					if($row['req_pers_id']!=0)$data['rd_req_pers_id'] = 1;
					else $data['rd_req_pers_id'] = 2;
				}else {
					page500();
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_can_edit']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);
				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['diff_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}

					if($row['pers_id']!=0)$data['rd_pers_id'] = 1;
					else $data['rd_pers_id'] = 2;

					if($row['req_pers_id']!=0)$data['rd_req_pers_id'] = 1;
					else $data['rd_req_pers_id'] = 2;
				}else {
					page500();
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_can_edit']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				if(get_inpost('diff_info[date_of_req]')!='') {
					$frm->set_rules('diff_info[date_of_req]','วันที่แจ้งเรื่อง','callback_date_check');
					$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");
				}

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

				$frm->set_message("required","กรุณากรอกข้อมูล %s");

				if($frm->run($this)){//Valid Data

					$data_update = $_POST['diff_info'];
					$data_update['date_of_req'] = dateChange($data_update['date_of_req'],4);
					$data_update['update_user_id'] = getUser();
					$data_update['update_datetime'] = getDatetime();

					$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
					$data['msg'] = setMsg('021'); //Set Message code 021

					if(get_inpost('state')==1) {
						redirect('difficult/sufferer_preform1/Edit/'.$diff_id,'refresh');
					}else {
						$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
						redirect('difficult/assist_list','refresh');
					}

				}else {
					$data['diff_info'] = $_POST['diff_info'];
					$data['rd_pers_id'] = set_value('rd_pers_id');
					$data['rd_req_pers_id'] = set_value('rd_req_pers_id');
					$data['msg'] = setMsg('022'); //Set Message code 022
				}

			}else if($process_action=='Delete' && $usrpm['perm_can_edit']=='Yes') { //Delete process
				$data_update = array();
				$data_update['delete_user_id'] = getUser();
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
				$data['msg'] = setMsg('031'); //Set Message code 031
				redirect('difficult/assist_list','refresh');
			}else {
				page500();
			}


			$this->template->load('index_page',$data,'difficult');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out',$user_id,'Success'); //Save Sign Out Log
		}
		//$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
	}
*/

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

	private function clr_diffInfo_form1() {
		return array(
					'date_of_req' => date('d-m-Y'),
					'req_pers_id' => '',
					'req_pid' => '',
					'req_name' => ' - ',
					'req_date_of_birth' => ' - ',
					'req_gender_name' => ' - ',
					'req_nation_name_th' => ' - ',
					'req_relg_title' => ' - ',
					'req_position' => '',
					'req_org' => '',
					'req_relation' => '',
					'req_tel_no' => '',
					'chn_code' => '',
					'addr_gps' => '',

					'pid' => '',
					'pers_id' => '',
					'name' => ' - ',
					'date_of_birth' => ' - ',
					'gender_name' => ' - ',
					'nation_name_th' => ' - ',
					'relg_title' => ' - ',
					'tel_no' => '',

					'reg_addr_id' => '',
					'pre_addr_id' => ''
		);
	}

  public function getHistory($process_action='View') {
    $data = array(); //Set Initial Variable to Views
    /*-- Initial Data for Check User Permission --*/
    $user_id = get_session('user_id');
    $app_id = 3;
    $process_path = 'difficult/getHistory';
    /*--END Inizial Data for Check User Permission--*/

    $pers_id = get_inpost('pers_id');

    $this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
    $usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

    if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
      echo json_encode(array('code'=>'-1','message'=>'Permission Invalid!'));
      $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
    }else {
        $rows = $this->common_model->custom_query("select * from `diff_info` as A inner join pers_info as B on A.pers_id=B.pers_id where A.pers_id={$pers_id} AND A.date_of_pay!='' AND (A.delete_datetime IS NULL AND B.delete_datetime IS NULL)");
        $rs = array();
        if(count($rows)>0) {
          $rs['history'] = 'มีประวัติ';
        }else {
          $rs['history'] = 'ไม่มีประวัติ';
        }

        $rows = $this->common_model->custom_query("select * from `diff_info` as A inner join pers_info as B on A.pers_id=B.pers_id where A.pers_id={$pers_id} AND YEAR(A.date_of_pay)=YEAR(CURRENT_TIMESTAMP) AND (A.delete_datetime IS NULL AND B.delete_datetime IS NULL)");
        if(count($rows)>0) {
          $rs['year_now_history'] = count($rows);
        }else {
          $rs['year_now_history'] = '-';
        }
        $rs['code'] = '0';
        $rs['message'] = '';
        echo json_encode($rs);

      $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
    }
  }

	public function sufferer_form1($process_action='Add',$diff_id=0) { //แบบขอรับบริการ (แจ้งเรื่อง)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 3;
		$process_path = 'difficult/sufferer_form1';
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

			//$data['diff_info'] = $this->difficult_model->getAll_diffInfo();

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

  		/*-- Toastr style --*/
			set_css_asset_head('../plugins/Static_Full_Version/css/plugins/cropper/cropper.min.css');
			set_js_asset_head('../plugins/Static_Full_Version/js/plugins/cropper/cropper.min.js');
			/*-- End Toastr style --*/

  		/*-- select2 style --*/
  		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/select2/select2.min.css');
  		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/select2/select2.full.min.js');
  		/*-- End select2 style --*/


  		set_js_asset_footer('mapmarker.js','webconfig'); //Set JS mapmarker.js --

			set_js_asset_footer('webservice.js','personals'); //Set JS webservice.js

			set_js_asset_footer('sufferer_form1.js','difficult'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'sufferer_form1';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$data['diff_info'] = $this->clr_diffInfo_form1();

				$data['pers_addr'] = array();
				$data['pers_info'] = array();

				$this->template->load('index_page',$data,'difficult');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('diff_info[date_of_req]','วันที่แจ้งเรื่อง','required|callback_date_check');
				$frm->set_rules('diff_info[req_pers_id]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
        //$frm->set_rules('diff_info[pers_id]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

				//if(get_inpost('rd_pers_id')==1) {
				//	$frm->set_rules('diff_info[pers_id]','เลขประจำตัวประชาชน','required');
				//}

				//$frm->set_rules('diff_info[elder_firstname]','ชื่อตัว','required');
				//$frm->set_rules('diff_info[elder_lastname]','ชื่อสกุล','required');

				//if(get_inpost('rd_req_pers_id')==1) {
				//	$frm->set_rules('diff_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
				//}

				//$frm->set_rules('diff_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
				//$frm->set_rules('diff_info[req_channel]','ช่องทางการรับแจ้ง','required');

				//$frm->set_rules('diff_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				//$frm->set_rules('diff_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data
					// dieArray(get_inpost_arr("pers_family[pers_id]"));
					$data_insert = array();
					$data_insert = get_inpost_arr('diff_info');
					$data_update_pers = get_inpost_arr('pers_info');

					$data_insert['date_of_req'] 		= dateChange($data_insert['date_of_req']);
					$data_insert['insert_user_id'] 	= getUser();
					$data_insert['insert_org_id'] 	= get_session('org_id');
					$data_insert['insert_datetime'] = getDatetime();

					// $update_req_pers['tel_no_home'] 	= $data_insert['req_tel_no_home'];
					$update_req_pers['tel_no'] = $data_insert['req_tel_no'];
					// $update_req_pers['fax_no'] 				= $data_insert['req_fax_no'];
					// $update_req_pers['email_addr'] 		= $data_insert['req_email_addr'];
					$update_req_pers['update_user_id'] 	= getUser();
					$update_req_pers['update_org_id'] 	= get_session('org_id');
					$update_req_pers['update_datetime'] = getDatetime();

					if($_FILES['img']['name']!=''){
					 $namephoto = $this->files_model->getOnceImg("img",'assets/uploads/images/personal/');
					 $data_update['img_file'] = $namephoto;
					 $data_update['img_size'] = $_FILES['img']['size'];
					}

					$this->common_model->update("pers_info",$update_req_pers,array('pers_id'=>$data_insert['req_pers_id']));

					unset($data_insert['req_pid']);
          unset($data_insert['tel_no']);
					unset($data_insert['req_tel_no_home']);
					unset($data_insert['req_tel_no_mobile']);
					unset($data_insert['req_fax_no']);
					unset($data_insert['req_email_addr']);

					unset($data_insert['pid']);

        //$id = $this->common_model->insert('diff_info',$data_insert);

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
          unset($data_update_pers['tel_no_home']);
          unset($data_update_pers['tel_no_mobile']);
          unset($data_update_pers['fax_no']);
          unset($data_update_pers['email_addr']);

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

          if(get_inpost('diff_info[pers_id]')=='') {
            $data_update_pers['insert_user_id']   = getUser();
            $data_update_pers['insert_org_id']    = get_session('org_id');
            $data_update_pers['insert_datetime']  = getDatetime();

					  $_POST['diff_info[pers_id]'] = $this->common_model->insert('pers_info',$data_update_pers);
          }else {
            $this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('diff_info[pers_id]')));
          }

          $data_insert['pers_id'] = get_inpost('diff_info[pers_id]');
          $id = $this->common_model->insert('diff_info',$data_insert);

					// insert pers_family ///////////////////////////////////////////
					//$tmp_family = @get_inpost_arr("pers_family");
          $tmp_family = get_inpost_arr("pers_family[fml_pid]");
					// dieFont(get_inpost("pers_family[fml_relation][0]"));
					// dieArray($_POST['pers_family']);
					if(!empty($tmp_family)){
						if(current($tmp_family) != ''){
							foreach ($tmp_family as $key => $rFml) {
								// dieFont($rFml);

								$fml_insert = array(
									'pers_id' 			=> get_inpost('diff_info[pers_id]'),
									'fml_pid' 	=> str_replace("-","",get_inpost("pers_family[fml_pid][{$key}]")),
                  'pren_code' => get_inpost("pers_family[pren_code][{$key}]"),
                  'pers_firstname_th' => get_inpost("pers_family[pers_firstname_th][{$key}]"),
                  'pers_lastname_th' => get_inpost("pers_family[pers_lastname_th][{$key}]"),
                  'fml_age' => get_inpost("pers_family[fml_age][{$key}]"),
                  'fml_relation' => get_inpost("pers_family[fml_relation][{$key}]"),
                  'occupation' => get_inpost("pers_family[occupation][{$key}]"),
                  'mth_avg_income'  => get_inpost("pers_family[mth_avg_income][{$key}]"),
                  'healthy'         => get_inpost("pers_family[healthy][{$key}]"),
                  'healthy_self_help' => get_inpost("pers_family[healthy_self_help][{$key}]")
								);

                //dieArray($fml_insert);

								$this->common_model->insert('pers_family',$fml_insert);
							}
							// dieArray($fml_pers_update);
						}
					}
					/////////////////////////////////////////////////////////////////

					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('difficult/sufferer_form2/Edit/'.$id,'refresh');

				}else {
					$data['diff_info']		= get_inpost_arr('diff_info');
					$data['diff_info']['diff_id'] = $diff_id;
					$data['elder_addr_chk'] = set_value('elder_addr_chk');

					$data['pers_addr']		= get_inpost_arr('pers_addr');
					$data['pers_info']		= get_inpost_arr('pers_info');

					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

					$this->template->load('index_page',$data,'difficult');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);
				 // dieArray($row);
					if($_FILES['img']['name']!=''){
						//print_r(get_inpost('img'));
						var_dump($_FILES);
						exit();
					}
				 if($_FILES['img']['name']!=''){
	 				 	$namephoto = $this->files_model->getOnceImg("img",'assets/uploads/images/personal/');
	 				 	$update_req_pers['img_file'] = $namephoto;
	 				 	$update_req_pers['img_size'] = $_FILES['img']['size'];
						//$this->common_model->update("pers_info",$update_req_pers,array('pers_id'=>$data['diff_info']['req_pers_id']));
 					}

				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					$data['addr_info'] = $this->personal_model->getOnce_PersonalAddress($row['pre_addr_id']);
					// dieArray($data['addr_info']);
					$data['diff_info']['name'] = $row['name'];
          if($row['date_of_birth']!='') {
            $date = new DateTime($row['date_of_birth']);
            $now = new DateTime();
            $interval = $now->diff($date);
            $age = $interval->y;
            $data['diff_info']['date_of_birth'] = formatDateThai($row['date_of_birth']).' (อายุ '.$age.' ปี)';
          }else {
          	$data['diff_info']['date_of_birth'] = ' - ';
          }
					$data['diff_info']['gender_name'] = $row['gender_name']==''?' - ':$row['gender_name'];
					$data['diff_info']['nation_name_th'] = $row['nation_name_th']==''?' - ':$row['nation_name_th'];
					$data['diff_info']['relg_title'] = $row['relg_title']==''?' - ':$row['relg_title'];
					$tmp2 = $this->personal_model->getOnce_PersonalAddress($row['reg_addr_id']);
					$data['diff_info']['reg_add_info'] = $tmp2['addr_home_no'];
					$data['diff_info']['reg_add_info'] .= ($tmp2['addr_moo']!='')?' หมู่'.$tmp2['addr_moo']:'';
					$data['diff_info']['reg_add_info'] .= ($tmp2['addr_moo']!='')?' ต.'.$tmp2['addr_sub_district']:'';
					$data['diff_info']['reg_add_info'] .= ($tmp2['addr_moo']!='')?' อ.'.$tmp2['addr_district']:'';
					$data['diff_info']['reg_add_info'] .= ($tmp2['addr_moo']!='')?' จ.'.$tmp2['addr_province'].' '.$tmp2['addr_zipcode']:'';
					$data['diff_info']['reg_add_info'] = ($data['diff_info']['reg_add_info']!='')?$data['diff_info']['reg_add_info']:'-';

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['diff_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					// dieArray($data['diff_info']);

						$data['diff_info']['req_pid'] = '';
						$data['diff_info']['req_name'] = ' - ';
						$data['diff_info']['req_date_of_birth'] = ' - ';
						$data['diff_info']['req_gender_name'] = ' - ';
						$data['diff_info']['req_nation_name_th'] = ' - ';
						$data['diff_info']['req_relg_title'] = ' - ';
						$data['diff_info']['req_pers_id'] = '';
						$data['diff_info']['req_tel_no'] = $row['tel_no'];
						// $data['diff_info']['req_tel_no_mobile'] = '';
						// $data['diff_info']['req_fax_no'] = '';
						// $data['diff_info']['req_email_addr'] = '';


					$row['req_pers_id'] = $row['req_pers_id']==''?0:$row['req_pers_id'];
					$tmp = $this->personal_model->getOnce_PersonalInfo($row['req_pers_id']);
					// dieArray($tmp);
					if(isset($tmp['pid'])) {
						$data['diff_info']['req_pid'] = $tmp['pid'];
						$data['diff_info']['req_name'] = $tmp['name'];
            if($tmp['date_of_birth']!='') {
              $date = new DateTime($tmp['date_of_birth']);
              $now = new DateTime();
              $interval = $now->diff($date);
              $age = $interval->y;
              $data['diff_info']['req_date_of_birth'] = formatDateThai($tmp['date_of_birth']).' (อายุ '.$age.' ปี)';
            }else {
            	$data['diff_info']['req_date_of_birth'] = ' - ';
            }
						$data['diff_info']['req_gender_name'] = $tmp['gender_name']==''?' - ':$tmp['gender_name'];
						$data['diff_info']['req_nation_name_th'] = $tmp['nation_name_th']==''?' - ':$tmp['nation_name_th'];
						$data['diff_info']['relg_title'] = $tmp['relg_title']==''?' - ':$tmp['relg_title'];
						$data['diff_info']['req_pers_id'] = $tmp['pers_id'];
            $data['diff_info']['tel_no'] = $tmp['tel_no'];
						// $data['diff_info']['req_tel_no_home'] = $tmp['tel_no_home'];
						// $data['diff_info']['req_tel_no_mobile'] = $tmp['tel_no_mobile'];
						// $data['diff_info']['req_fax_no'] = $tmp['fax_no'];
						// $data['diff_info']['req_email_addr'] = $tmp['email_addr'];
						$tmp1 = $this->personal_model->getOnce_PersonalAddress($tmp['reg_addr_id']);
						$data['diff_info']['req_reg_add_info'] = $tmp1['addr_home_no'];
						$data['diff_info']['req_reg_add_info'] .= ($tmp1['addr_moo'] != '')?' หมู่'.$tmp1['addr_moo']:'';
						$data['diff_info']['req_reg_add_info'] .= ($tmp1['addr_sub_district'] != '')?' ต.'.$tmp1['addr_sub_district']:'';
						$data['diff_info']['req_reg_add_info'] .= ($tmp1['addr_district'] != '')?' อ.'.$tmp1['addr_district']:'';
						$data['diff_info']['req_reg_add_info'] .= ($tmp1['addr_province'] != '')?' จ.'.$tmp1['addr_province'].' '.$tmp1['addr_zipcode']:'';

						$data['diff_info']['req_reg_add_info'] = ($data['diff_info']['req_reg_add_info']!='')?$data['diff_info']['req_reg_add_info']:'-';

					}

					$tmp_family = $this->common_model->custom_query("SELECT * FROM pers_family WHERE pers_id = {$row['pers_id']}");
					// dieArray($tmp_family);
					foreach ($tmp_family as $key => $value) {
						$data['pers_family'][] = array_merge($value,$this->personal_model->getPersonalInfo($value['ref_pers_id']));
					}

					 // dieArray($data);
					$this->template->load('index_page',$data,'difficult');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('diff_info[date_of_req]','วันที่แจ้งเรื่อง','callback_date_check');
				$frm->set_rules('diff_info[req_pid]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
				//$frm->set_rules('diff_info[pid]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

				//if(get_inpost('rd_pers_id')==1) {
				//	$frm->set_rules('diff_info[pers_id]','เลขประจำตัวประชาชน','required');
				//}

				//$frm->set_rules('diff_info[elder_firstname]','ชื่อตัว','required');
				//$frm->set_rules('diff_info[elder_lastname]','ชื่อสกุล','required');

				//if(get_inpost('rd_req_pers_id')==1) {
				//	$frm->set_rules('diff_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
				//}

				//$frm->set_rules('diff_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
				//$frm->set_rules('diff_info[req_channel]','ช่องทางการรับแจ้ง','required');

				//$frm->set_rules('diff_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				//$frm->set_rules('diff_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = array();
					$data_update = get_inpost_arr('diff_info');


					$data_update['date_of_req']		= dateChange($data_update['date_of_req']);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();


					$update_req_pers['tel_no'] 	= $data_update['req_tel_no'];
					// $update_req_pers['tel_no_mobile'] = $data_update['req_tel_no_mobile'];
					// $update_req_pers['fax_no'] 				= $data_update['req_fax_no'];
					// $update_req_pers['email_addr'] 		= $data_update['req_email_addr'];
					$update_req_pers['update_user_id'] 	= getUser();
					$update_req_pers['update_org_id'] 	= get_session('org_id');
					$update_req_pers['update_datetime'] = getDatetime();

					// dieArray($data_update);
					$this->common_model->update("pers_info",$update_req_pers,array('pers_id'=>$data_update['req_pers_id']));

					// dieArray($this->db);

					unset($data_update['req_pid']);
					unset($data_update['tel_no']);
					unset($data_update['req_tel_no_mobile']);
					unset($data_update['req_fax_no']);
					unset($data_update['req_email_addr']);

					unset($data_update['pid']);
					unset($data_update['pre_addr_status']);

					//$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));

					$data_update_pers = get_inpost_arr('pers_info');
					if(get_inpost('elder_addr_chk')!='on') {
						//add new addr
						$data_update_addr = get_inpost_arr('pers_addr');
						$data_update_addr['update_user_id']		= getUser();
						$data_update_addr['update_datetime']	= getDatetime();

						$this->common_model->update('pers_addr',$data_update_addr,array('addr_id'=>get_inpost('pre_addr_id')));
						// $new_addr_id = $this->common_model->insert('pers_addr',$data_insert_addr);
						// $data_update_pers['pre_addr_id'] = $new_addr_id;
					}else{
						$data_update_pers['pre_addr_id'] = $data_update_pers['reg_addr_id'];
					}
          unset($data_update_pers['tel_no_home']);

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

          if(get_inpost('diff_info[pers_id]')=='') {
            $data_update_pers['insert_user_id']   = getUser();
            $data_update_pers['insert_org_id']    = get_session('org_id');
            $data_update_pers['insert_datetime']  = getDatetime();

            $_POST['diff_info[pers_id]'] = $this->common_model->insert('pers_info',$data_update_pers);
          }else {
					 $this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('diff_info[pers_id]')));
          }

          $data_update['pers_id'] = get_inpost('diff_info[pers_id]');
          $this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));

					// insert pers_family ///////////////////////////////////////////
					//$tmp_family = @get_inpost_arr("pers_family");
          $tmp_family = get_inpost_arr("pers_family[fml_pid]");

					if(!empty($tmp_family)){
						if(current($tmp_family) != ''){
							$this->common_model->delete_where('pers_family','pers_id',get_inpost('diff_info[pers_id]'));
							foreach ($tmp_family as $key => $rFml) {
								$fml_insert = array(
                  'pers_id'       => get_inpost('diff_info[pers_id]'),
                  'fml_pid'   => str_replace("-","",get_inpost("pers_family[fml_pid][{$key}]")),
                  'pren_code' => get_inpost("pers_family[pren_code][{$key}]"),
                  'pers_firstname_th' => get_inpost("pers_family[pers_firstname_th][{$key}]"),
                  'pers_lastname_th' => get_inpost("pers_family[pers_lastname_th][{$key}]"),
                  'fml_age' => get_inpost("pers_family[fml_age][{$key}]"),
                  'fml_relation' => get_inpost("pers_family[fml_relation][{$key}]"),
                  'occupation' => get_inpost("pers_family[occupation][{$key}]"),
                  'mth_avg_income'  => get_inpost("pers_family[mth_avg_income][{$key}]"),
                  'healthy'         => get_inpost("pers_family[healthy][{$key}]"),
                  'healthy_self_help' => get_inpost("pers_family[healthy_self_help][{$key}]")
								);
								$this->common_model->insert('pers_family',$fml_insert);
							}
							// dieArray($fml_pers_update);
						}
					}
					/////////////////////////////////////////////////////////////////


					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('difficult/sufferer_form2/Edit/'.$diff_id,'refresh');
				}else {
					$data['diff_info'] 			= get_inpost_arr('diff_info');
					$data['diff_info']['diff_id'] = $diff_id;

					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'difficult');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['delete_org_id'] 	= get_session('org_id');
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('difficult/assist_list','refresh');
			}else {
				page500();
				// $this->template->load('index_page',$data,'difficult');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function sufferer_form2($process_action='Add',$diff_id=0) { //แบบขอรับบริการ (ตรวจเยี่ยม)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 4;
		$process_path = 'difficult/sufferer_form2';
		/*--END Inizial Data for Check User Permission--*/

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500();
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		}else {
			$app_name 					= $usrpm['app_name'];
			$data['usrpm'] 			= $usrpm;
			$data['user_id'] 		= $user_id;

			//$data['diff_info'] 	= $this->difficult_model->getAll_diffInfo();

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

			set_js_asset_footer('sufferer_form2.js','difficult'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] 	= 'sufferer_form2';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			// dieArray($usrpm);
			if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);
				// dieArray($row);

				if(isset($row['diff_id'])) {

					$data['diff_info'] 				= $row;
					$data['diff_info']['pin'] = $row['diff_id'];
					$data['diff_trouble'] 		= $this->difficult_model->get_diffTrouble($diff_id);
					$data['diff_help'] 				= $this->difficult_model->get_diffHelp($diff_id);
					$data['diff_help_guide'] 	= $this->difficult_model->get_diffHelpGuide($diff_id);

					if($row['date_of_visit']!='') {
						$tmp = explode('-',$row['date_of_visit']);
						$data['diff_info']['date_of_visit'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['diff_info']['date_of_visit'] = date("d-m-Y");
					}

					$this->template->load('index_page',$data,'difficult');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('diff_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				$frm->set_rules('diff_info[visit_place]','สถานที่ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				// dieArray($_POST);
				if($frm->run($this)){//Valid Data
				// if(0){//Valid Data

					// diff_info
					$data_update = @get_inpost_arr('diff_info');
					$data_update['date_of_visit'] 	= dateChange($data_update['date_of_visit']);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();
					$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));

					// diff_trouble
					$tmp_troble = @get_inpost_arr('diff_trouble[trb_code]');
					if(!empty($tmp_troble)){
						$this->common_model->delete_where('diff_trouble','diff_id',$diff_id);
						foreach ($tmp_troble as $row) {
							$trb_insert = array(
								'diff_id'			=> $diff_id,
								'trb_code'		=> $row,
								'trb_remark'	=> get_inpost("diff_trouble[trb_remark][{$row}]"),
							);
							$this->common_model->insert('diff_trouble',$trb_insert);
						}
					}

					// diff_help
					$tmp_help = @get_inpost_arr('diff_help[help_code]');
					if(!empty($tmp_help)){
						$this->common_model->delete_where('diff_help','diff_id',$diff_id);
						foreach ($tmp_help as $row) {
							$help_insert = array(
								'diff_id'			=> $diff_id,
								'help_code'		=> $row,
								'help_remark'	=> get_inpost("diff_help[help_remark][{$row}]"),
							);
							$this->common_model->insert('diff_help',$help_insert);
						}
					}

					// diff_help_guide
					$tmp_help_guide = get_inpost_arr('diff_help_guide[help_guide_code]');
					if(!empty($tmp_help_guide)){
						$this->common_model->delete_where('diff_help_guide','diff_id',$diff_id);
						foreach ($tmp_help_guide as $row) {
							$help_guide_insert = array(
								'diff_id'						=> $diff_id,
								'help_guide_code'		=> $row,
								'help_guide_remark'	=> get_inpost("diff_help_guide[help_guide_remark][{$row}]"),
							);
							$this->common_model->insert('diff_help_guide',$help_guide_insert);
						}
					}

					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('difficult/sufferer_form3/Edit/'.$diff_id,'refresh');

				}else {

					$data['diff_info'] = get_inpost_arr('diff_info');
					$data['diff_info']['diff_id'] = $diff_id;
					$data['diff_info']['visit_place_identify'] = set_value('diff_info[visit_place_identify]');

					$tmp_troble = get_inpost_arr('diff_trouble[trb_code]');
					$tmp_help = get_inpost_arr('diff_help[help_code]');
					$tmp_help_guide = get_inpost_arr('diff_help_guide[help_guide_code]');

					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'difficult');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['delete_org_id'] 	= get_session('org_id');
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


	public function sufferer_form3($process_action='Add',$diff_id=0) { //แบบขอรับบริการ (สงเคราะห์)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 5;
		$process_path = 'difficult/sufferer_form3';
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

			//$data['diff_info'] = $this->difficult_model->getAll_diffInfo();

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
			set_js_asset_footer('sufferer_form3.js','difficult'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] 	= 'sufferer_form3';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);
				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					if($row['date_of_pay']!='') {
						$tmp = explode('-',$row['date_of_pay']);
						$data['diff_info']['date_of_pay'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['diff_info']['date_of_pay'] = date("d-m-Y");
					}

					// if($row['date_of_receipt']!='') {
					// 	$tmp = explode('-',$row['date_of_receipt']);
					// 	$data['diff_info']['date_of_receipt'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					// }else{
					// 	$data['diff_info']['date_of_receipt'] = date("d-m-Y");
					// }

					// dieArray($data);
					$this->template->load('index_page',$data,'difficult');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('diff_info[date_of_pay]','วันที่รับเงิน','required|callback_date_check');
				// $frm->set_rules('diff_info[date_of_receipt]','วันที่ออกใบสำคัญรับเงิน','required|callback_date_check');
				$frm->set_rules('diff_info[pay_amount]','จำนวนเงินที่สงเคราะห์','required');
				$frm->set_rules('diff_info[payee_type]','ผู้รับเงิน','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data
				// if(0){//Valid Data

					// $data_update = $_POST['diff_info'];
					$data_update = get_inpost_arr('diff_info');
          unset($data_update['date_of_receipt']);
					$data_update['date_of_pay'] 		= dateChange($data_update['date_of_pay']);
					// $data_update['date_of_receipt'] = dateChange($data_update['date_of_receipt'],4);

					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();

					// $data_update['date_of_visit'] = dateChange($data_update['date_of_visit'],4);
					// dieArray($data_update);
					$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));

					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('difficult/assist_list','refresh');

				}else {
					// $data['diff_info'] = $_POST['diff_info'];
					$data['diff_info'] = get_inpost_arr('diff_info');
					$data['diff_info']['diff_id'] = $diff_id;

					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'difficult');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process

				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['delete_org_id'] 	= get_session('org_id');
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


/*	public function sufferer_form2($process_action='Add',$diff_id=0) { // บันทึกข้อมูลผู้ประสบปัญหา (สคส.02)
		$data = array(); //Set Initial Variable to Views

		/*-- Initial Data for Check User Permission --*/
/*		$user_id = get_session('user_id');
		$app_id = 22;
		$process_path = 'difficult/sufferer_form2';
		/*--END Inizial Data for Check User Permission--*/

/*		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission
		if(count($usrpm)<1){
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

			$data['process_action'] = $process_action;
			$data['content_view'] = 'sufferer_form2';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $app_name;

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_can_edit']=='Yes') {
				////
				page500();
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_can_edit']=='Yes'){ //Add && Submit Form
				////
				page500();
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}else if($process_action=='View' && get_inpost('bt_submit')=='' && $usrpm['perm_can_view']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);

				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['diff_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					/*
					if($row['pers_id']!=0)$data['rd_pers_id'] = 1;
					else $data['rd_pers_id'] = 2;

					if($row['req_pers_id']!=0)$data['rd_req_pers_id'] = 1;
					else $data['rd_req_pers_id'] = 2;
					*/
/*				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_can_edit']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);
				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['diff_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					/*
					if($row['pers_id']!=0)$data['rd_pers_id'] = 1;
					else $data['rd_pers_id'] = 2;

					if($row['req_pers_id']!=0)$data['rd_req_pers_id'] = 1;
					else $data['rd_req_pers_id'] = 2;
					*/
/*				}else {
					page500();
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_can_edit']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('diff_info[date_of_req]','วันที่แจ้งเรื่อง','required|callback_date_check');
				$frm->set_rules('diff_info[pay_amount]','จำนวนเงิน (บาท)','required|numeric');

				/*
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
				*/

/*				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = $_POST['diff_info'];
					$data_update['date_of_req'] = dateChange($data_update['date_of_req'],4);
					$data_update['update_user_id'] = getUser();
					$data_update['update_datetime'] = getDatetime();

					$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
					$data['msg'] = setMsg('021'); //Set Message code 021

					if(get_inpost('state')==1) {
						redirect('difficult/sufferer_form2/Edit/'.$diff_id,'refresh');
					}else if(get_inpost('state')==2){
						$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
						redirect('difficult/assist_list','refresh');
					}else {
						$this->output
						        ->set_content_type('pdf')
						        ->set_output(file_get_contents('assets/modules/difficult/uploads/a2.pdf'));
						//$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
						//redirect('difficult/assist_list','refresh');
					}

				}else {
					/* Modified for this Job */
/*					$row = $this->difficult_model->getOnce_diffInfo($diff_id);
					if(isset($row['diff_id'])) {
						$data['diff_info'] = $row;
						$data['diff_info']['date_of_req'] = $_POST['diff_info']['date_of_req'];
						$data['diff_info']['pay_amount'] = $_POST['diff_info']['pay_amount'];
						/*
						$data['rd_pers_id'] = set_value('rd_pers_id');
						$data['rd_req_pers_id'] = set_value('rd_req_pers_id');
						*/
/*						$data['msg'] = setMsg('022'); //Set Message code 031

					}else {
						page500();
					}
					/* END Modified for this Job */
/*				}

			}else if($process_action=='Delete' && $usrpm['perm_can_edit']=='Yes') { //Delete process
				$data_update = array();
				$data_update['update_user_id'] = getUser();
				$data_update['update_datetime'] = getDatetime();

				$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
				$data['msg'] = setMsg('031'); //Set Message code 031
				redirect('difficult/assist_list','refresh');
			}else {
				page500();
			}

			$this->template->load('index_page',$data,'difficult');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}
		//$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
	}*/

/*	public function authority_book($process_action='Add',$diff_id=0) { // พิมพ์หนังสือมอบอำนาจ
		$data = array(); //Set Initial Variable to Views

		/*-- Initial Data for Check User Permission --*/
/*		$user_id = get_session('user_id');
		$app_id = 23;
		$process_path = 'difficult/authority_book';
		/*--END Inizial Data for Check User Permission--*/

/*		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission
		if(count($usrpm)<1){
			page500();
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			$data['process_action'] = $process_action;
			$data['content_view'] = 'authority_book';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $app_name;

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_can_edit']=='Yes') {
				////
				page500();
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_can_edit']=='Yes'){ //Add && Submit Form
				////
				page500();
			}else if($process_action=='View' && get_inpost('bt_submit')=='' && $usrpm['perm_can_view']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);

				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['diff_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					/*
					if($row['pers_id']!=0)$data['rd_pers_id'] = 1;
					else $data['rd_pers_id'] = 2;

					if($row['req_pers_id']!=0)$data['rd_req_pers_id'] = 1;
					else $data['rd_req_pers_id'] = 2;
					*/
/*				}else {
					page500();
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_can_edit']=='Yes') {

				$row = $this->difficult_model->getOnce_diffInfo($diff_id);
				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['diff_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					/*
					if($row['pers_id']!=0)$data['rd_pers_id'] = 1;
					else $data['rd_pers_id'] = 2;

					if($row['req_pers_id']!=0)$data['rd_req_pers_id'] = 1;
					else $data['rd_req_pers_id'] = 2;
					*/

					/* Modified for this demo Job */
/*					$this->output
							->set_content_type('pdf')
							->set_output(file_get_contents('assets/modules/difficult/uploads/a3.pdf'));
					$data['msg'] = setMsg('041'); //Set Message code 41

					/* End Modified for this demo Job */

/*				}else {
					page500();
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_can_edit']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('diff_info[date_of_req]','วันที่แจ้งเรื่อง','required|callback_date_check');
				$frm->set_rules('diff_info[pay_amount]','จำนวนเงิน (บาท)','required|numeric');

				/*
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
				*/
/*
				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = $_POST['diff_info'];
					$data_update['date_of_req'] = dateChange($data_update['date_of_req'],4);
					$data_update['update_user_id'] = getUser();
					$data_update['update_datetime'] = getDatetime();

					$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
					$data['msg'] = setMsg('021'); //Set Message code 021

					if(get_inpost('state')==1) {
						redirect('difficult/authority_book/Edit/'.$diff_id,'refresh');
					}else if(get_inpost('state')==2){
						$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
						redirect('difficult/assist_list','refresh');
					}else {
						$this->output
						        ->set_content_type('pdf')
						        ->set_output(file_get_contents('assets/modules/difficult/uploads/a3.pdf'));
						//$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
						//redirect('difficult/assist_list','refresh');
					}

				}else {
					/* Modified for this Job */
/*					$row = $this->difficult_model->getOnce_diffInfo($diff_id);
					if(isset($row['diff_id'])) {
						$data['diff_info'] = $row;
						$data['diff_info']['date_of_req'] = $_POST['diff_info']['date_of_req'];
						$data['diff_info']['pay_amount'] = $_POST['diff_info']['pay_amount'];
						/*
						$data['rd_pers_id'] = set_value('rd_pers_id');
						$data['rd_req_pers_id'] = set_value('rd_req_pers_id');
						*/
/*						$data['msg'] = setMsg('022'); //Set Message code 022
					}else {
						page500();
					}
					/* END Modified for this Job */
/*				}

			}else if($process_action=='Delete' && $usrpm['perm_can_edit']=='Yes') { //Delete process
				$data_update = array();
				$data_update['update_user_id'] = getUser();
				$data_update['update_datetime'] = getDatetime();

				$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
				$data['msg'] = setMsg('031'); //Set Message code 031
				redirect('difficult/assist_list','refresh');
			}else {
				page500();
			}

			//$this->template->load('index_page',$data,'difficult'); //Modified for this Job
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}
		//$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
	}*/

/*	public function sufferer_form3($process_action='Add',$diff_id=0) { // แบบประเมินการให้บริการ (สคส.03)
		$data = array(); //Set Initial Variable to Views

		/*-- Initial Data for Check User Permission --*/
/*		$user_id = get_session('user_id');
		$app_id = 24;
		$process_path = 'difficult/sufferer_form3';
		/*--END Inizial Data for Check User Permission--*/

/*		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission
		if(count($usrpm)<1){
			page500();
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			$data['process_action'] = $process_action;
			$data['content_view'] = 'sufferer_form3_estimate';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $app_name;

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_can_edit']=='Yes') {
				////
				page500();
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_can_edit']=='Yes'){ //Add && Submit Form
				////
				page500();
			}else if($process_action=='View' && get_inpost('bt_submit')=='' && $usrpm['perm_can_view']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);

				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					if($row['date_of_eva']!='') {
						$tmp = explode('-',$row['date_of_eva']);
						$data['diff_info']['date_of_eva'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					////
				}else {
					page500();
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_can_edit']=='Yes') {
				$row = $this->difficult_model->getOnce_diffInfo($diff_id);

				if(isset($row['diff_id'])) {
					$data['diff_info'] = $row;

					if($row['date_of_eva']!='') {
						$tmp = explode('-',$row['date_of_eva']);
						$data['diff_info']['date_of_eva'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else {
						$data['diff_info']['date_of_eva'] = date('d-m-Y');
					}
					////
				}else {
					page500();
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_can_edit']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('diff_info[date_of_eva]','วันที่กรอกแบบสอบถาม','trim|callback_date_check');

				////

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = $_POST['diff_info'];
					$data_update['date_of_eva'] = dateChange($data_update['date_of_eva'],4);
					$data_update['update_user_id'] = getUser();
					$data_update['update_datetime'] = getDatetime();

					$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
					$data['msg'] = setMsg('021'); //Set Message code 021

					if(get_inpost('state')==1) {
						redirect('difficult/sufferer_form3/Edit/'.$diff_id,'refresh');
					}else if(get_inpost('state')==2){
						$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
						redirect('difficult/assist_list','refresh');
					}else {
						$this->output
						        ->set_content_type('pdf')
						        ->set_output(file_get_contents('assets/modules/difficult/uploads/a4.pdf'));
						//$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
						//redirect('difficult/assist_list','refresh');
					}

				}else {
					/* Modified for this Job */
/*					$row = $this->difficult_model->getOnce_diffInfo($diff_id);
					if(isset($row['diff_id'])) {
						$data['diff_info'] = $row;

						$data['diff_info']['date_of_eva'] = $_POST['diff_info']['date_of_eva'];
						$data['diff_info']['eva_org'] = $_POST['diff_info']['eva_org'];
						$data['diff_info']['subv_hist'] = $_POST['diff_info']['subv_hist'];
						$data['diff_info']['subv_hist_org'] = $_POST['diff_info']['subv_hist_org'];
						$data['diff_info']['satisfaction_status'] = $_POST['diff_info']['satisfaction_status'];
						$data['diff_info']['eva_remark'] = $_POST['diff_info']['eva_remark'];

						////
						$data['msg'] = setMsg('022'); //Set Message code 022
					}else {
						page500();
					}
					/* END Modified for this Job */
/*				}

			}else if($process_action=='Delete' && $usrpm['perm_can_edit']=='Yes') { //Delete process
				$data_update = array();
				$data_update['update_user_id'] = getUser();
				$data_update['update_datetime'] = getDatetime();

				$this->common_model->update('diff_info',$data_update,array('diff_id'=>$diff_id));
				$data['msg'] = setMsg('031'); //Set Message code 031
				redirect('difficult/assist_list','refresh');
			}else {
				page500();
			}

			$this->template->load('index_page',$data,'difficult');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}
		////
	}*/

/*	public function summary_report($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		$data = array(); //Set Initial Variable to Views

		/*-- Initial Data for Check User Permission --*/
/*		$user_id = get_session('user_id');
		$app_id = 25;
		$process_path = 'difficult/summary_report';
		/*--END Inizial Data for Check User Permission--*/

/*		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_can_view']=='No' || !isset($usrpm['app_id'])){
			page500();
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template
			$data['process_action'] = $process_action;
			$data['content_view'] = 'summary_report';
			$data['head_title'] = $app_name;
			$data['title'] = 'รายงานผลการดำเนินงาน (สคส.04) (ระดับหน่วยงาน)';

			if($process_action='Edit' && uri_seg(4)=='pdf' && $usrpm['perm_can_edit']=='Yes') {
				$this->output
				    ->set_content_type('pdf')
				    ->set_output(file_get_contents('assets/modules/difficult/uploads/a5.pdf'));
			}else if($process_action='View' && $usrpm['perm_can_view']=='Yes'){
				$data['diff_info'] = $this->difficult_model->getAll_diffInfo_forSumary();
			}else {
				page500();
			}

			$this->template->load('index_page',$data,'difficult');
		}
		$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
	}*/



}
