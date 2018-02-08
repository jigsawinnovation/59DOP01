<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adaptenvir extends MX_Controller {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

	public function adaptenvir_list_ajax($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		// ini_set('max_execution_time', 300);
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

			$this->load->model('adaptenvir_list_model','adaptenvir');
			$list = $this->adaptenvir->get_datatables();
			$data = array();
			$no = $_POST['start'];
			// dieArray($list);
			foreach ($list as $i=>$adaptenvir) {
				$no++;
				$row = array();

			  $pers_info = $this->personal_model->getOnce_PersonalInfo($adaptenvir->pers_id);
			  $row[] = "<center>".$no."</center>";
			  $row[] = $pers_info['pid'];
			  $row[] = $pers_info['prename_th'].$pers_info['name'];

			  $age = '';
/*		    if($pers_info['date_of_birth']!='') {
		      $date = new DateTime($pers_info['date_of_birth']);
		      if($pers_info['date_of_death'] != '0000-00-00'){
		      	$now = new DateTime($pers_info['date_of_death']);
		      }else{
		      	$now = new DateTime();
		      }
		      $interval = $now->diff($date);
		      $age = $interval->y;
		    }
			  $row[] = "<center>".$age."</center>";*/
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

			  $date_of_svy = '-';
		    if($adaptenvir->date_of_svy!='') {
		      $date_of_svy = '<font class="text-sucsess" color="#18bd15">'.dateChange($adaptenvir->date_of_svy,5).'</font>';
		    }
		    $row[] = "<center>".$date_of_svy."</center>";

		    $date_of_consi = '-';
		    if($adaptenvir->date_of_consi!='') {
		      $date_of_consi = '<font class="text-sucsess" color="#18bd15">'.dateChange($adaptenvir->date_of_consi,5).'</font>';
		    }
		    $row[] = "<center>".$date_of_consi."</center>";

		    $date_of_finish = '-';
		    if($adaptenvir->date_of_finish!='') {
		      $date_of_finish = '<font class="text-sucsess" color="#18bd15">'.dateChange($adaptenvir->date_of_finish,5).'</font>';
		    }
		    $row[] = "<center>".$date_of_finish."<center>";
		    $row[] ="<div style='width:100%;text-align:right;'>".number_format($adaptenvir->case_budget,2)."</div>";

		  //   $btn = '<a class="btn btn-default lnk" data-toggle="modal" data-target="#info'.$i.'"><i class="fa fa-info-circle" aria-hidden="true" style="color: #000"></i></a>';

				// $btn = $btn.'<!-- Info Modal -->
			 //                <div class="modal fade" id="info'.$i.'" role="dialog">';

			 //                        $addr = $this->personal_model->getPersonalInfo($adaptenvir->pers_id);
			 //                         // dieArray($addr);

			 //    $btn = $btn.'
			 //                        <div class="modal-dialog modal-lg" style="text-align: left; ">
			 //                          <div class="modal-content">
			 //                           <div class="modal-header" style="background-color: rgb(56, 145, 209); color:white; ">
			 //                              <button type="button" class="close" data-dismiss="modal">&times;</button>
			 //                              <h3 class="modal-title text-left">'.$pers_info['prename_th'].$pers_info['name'].'</h3>
			 //                            </div>
			 //                            <div class="modal-body">
			 //                              <div class="row">
			 //                                <div class="col-xs-12 col-sm-3">
			 //                                  <img src="'.path('noProfilePic.jpg','member').'" class="img-responsive">
			 //                                </div>
			 //                                <div class="col-xs-12 col-sm-9">
			 //                                  <div class="row">
			 //                                    <div class="col-xs-12 col-sm-3"><h4>เลขประจำตัวประชาชน</h4></div><div class="col-xs-12 col-sm-3">'.$pers_info['pid'].'</div>
			 //                                  </div>
			 //                                  <div class="row">
			 //                                    <div class="col-xs-12 col-sm-3"><h4>วันเดือนปีเกิด</h4></div><div class="col-xs-12 col-sm-6">'.@$addr['date_of_birth'].'</div>
			 //                                  </div>
			 //                                  <div class="row">
			 //                                    <div class="col-xs-12 col-sm-3"><h4>เพศ</h4> '.@$adaptenvir->gender_name.'</div>
			 //                                    <div class="col-xs-12 col-sm-3"><h4>สัญชาติ</h4> '.@$adaptenvir->nation_name_th.'</div>
			 //                                    <div class="col-xs-12 col-sm-3"><h4>ศาสนา</h4> '.@$adaptenvir->relg_title.'</div>
			 //                                  </div>
			 //                                  <div class="row">
			 //                                  &nbsp;
			 //                                  </div>
			 //                                  <div class="row">
			 //                                    <div class="col-xs-12 col-sm-3"><h4>ที่อยู่ตามทะเบียนบ้าน</h4></div><div class="col-xs-12 col-sm-5">'.@$addr['reg_add_info'].'</div>
			 //                                  </div><br>

			 //                                </div>
			 //                              </div>
			 //                            </div>
			 //                          </div>
			 //                        </div>
			 //                      </div>
			 //                      <!-- End Info Modal -->';

			 //    $tmp = $this->admin_model->getOnce_Application(30);
			 //    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(30,$user_id); //Check User Permission
			 //    $btn = $btn.' <a ';
			 //                  if(!isset($tmp1['perm_status'])) {
			 //    				$btn = $btn.' readonly ';
			 //                  }else{
			 //                  	$btn = $btn.' href="'.site_url('adaptenvir/inquire1/Edit/'.@$adaptenvir->imp_home_id).'"';
			 //                  }
			 //                  if(isset($tmp['app_name'])){
			 //                  	$btn = $btn.' title="'.$tmp['app_name'].'" ';
			 //                  }
			 //                  $btn = $btn.'
			 //                   class="btn btn-default">
			 //                      <i class="fa fa-pencil-square" aria-hidden="true" style="color: #000"></i>
			 //                  </a>

			 //                  <a data-toggle="modal" data-target="#prt'.$i.'" title="พิมพ์แบบฟอร์ม" class="btn btn-default">
			 //                      <i class="fa fa-file-text" aria-hidden="true" style="color: #000"></i>
			 //                  </a>
			 //                  <!-- Print Modal -->
			 //                  <div class="modal fade" id="prt'.$i.'" role="dialog">
			 //                    <div class="modal-dialog">

			 //                       <!-- Modal content-->
			 //                      <div class="modal-content">
			 //                        <div class="modal-header text-left">
			 //                          <button type="button" class="close" data-dismiss="modal">&times;</button>
			 //                           <h4 class="modal-title" style="color: #333; font-size: 16px;">พิมพ์แบบฟอร์ม</h4>
			 //                         </div>
			 //                        <div class="modal-body">
			 //                          <div class="row">';

			 //                            $tmp = $this->admin_model->getOnce_Application(34);
			 //                            $tmp1 = $this->admin_model->chkOnce_usrmPermiss(34,get_session('user_id')); //Check User Permission
			 //                        	$btn = $btn.'
			 //                            <div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;"
			 //                            ';
			 //                            if(!isset($tmp1['perm_status'])) {
			 //                                $btn = $btn.' class="disabled "';
			 //                              }else if($usrpm['app_id']==34) {
			 //                                $btn = $btn.' class="active" ';
			 //                              }
			 //                            $btn = $btn.'>
			 //                              <a style="color: #333; font-size: 16px;" target="_blank" href="'.site_url('report/D1/pdf?id='.$adaptenvir->imp_home_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
			 //                              	  if(isset($tmp1['perm_status'])) {
			 //                              	  	$btn = $btn.$tmp1['app_name'];
			 //                              	  }
			 //                            $btn = $btn.'
			 //                              </a>
			 //                            </div>';

			 //                            $tmp = $this->admin_model->getOnce_Application(35);
			 //                            $tmp1 = $this->admin_model->chkOnce_usrmPermiss(35,get_session('user_id')); //Check User Permission
			 //                            $btn = $btn.'
			 //                            <div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
			 //                            if(!isset($tmp1['perm_status'])) {
			 //                                $btn = $btn.' class="disabled" ';
			 //                              }else if($usrpm['app_id']==35) {
			 //                                $btn = $btn.' class="active" ';
			 //                              }
			 //                            $btn = $btn.'
			 //                            >
			 //                              <a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/D2/pdf?id='.$adaptenvir->imp_home_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
			 //                              	  if(isset($tmp1['perm_status'])) {
			 //                              		$btn = $btn.$tmp1['app_name'];
			 //                              	   }
			 //                            $btn = $btn.'
			 //                              </a>
			 //                            </div>
			 //                           </div>
			 //                           <br/>
			 //                        </div>
			 //                      </div>
			 //                    </div>
			 //                   </div>
			 //                   <!-- End Print Modal -->';

			 //                    $tmp = $this->admin_model->chkOnce_usrmPermiss(30,$user_id); //Check User Permission
			 //                    if(isset($tmp['perm_status'])) {
			 //                        if($tmp['perm_status']=='Yes') {
			 //                        	$btn = $btn.'
			 //                        <a data-id='.@$adaptenvir->imp_home_id.' onclick="opn(this)" title="ลบ" type="button" class="btn btn-default">
			 //                          <span class="glyphicon glyphicon-trash" style="color: #000"></span>
			 //                        </a>';
			 //                    	}
			 //                    }

		    $tmp = $this->admin_model->getOnce_Application(3);
                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                $btn = '';
                $btn =$btn.'<!-- Single button -->
                <div class="btn-group" style="cursor: pointer;">
                  <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>

                  <ul class="dropdown-menu" style="position: absolute;left: -190px;">';

                  $btn = $btn.' <li><a style="font-size:16px;" data-toggle="modal" data-target="#prt'.$adaptenvir->imp_home_id.'" title="พิมพ์แบบฟอร์ม" >
                       <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #000"></i> พิมพ์แบบฟอร์ม (.PDF)
                   </a></li>';


                  $btn =$btn.'<li><a  style="font-size:16px;"';

                  if(!isset($tmp1['perm_status'])){ $btn =$btn.'class="disabled"';}else{ $btn =$btn.'href="'.site_url("adaptenvir/inquire1/Edit/".$adaptenvir->imp_home_id); }
                  $btn =$btn.'"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>';




                    $tmp = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                    if(isset($tmp['perm_status'])) {
                        if($tmp['perm_status']=='Yes') {
                         $btn = $btn.'<li><a style="font-size:16px;" data-id='.$adaptenvir->imp_home_id.' onclick="opn(this)" title="ลบ" >
                             <i class="fa fa-trash" style="color: #000"></i> ลบรายการ
                          </a></li>';
                      }
                    }

                  $btn = $btn.'</ul>
                              </div>';

                $btn =$btn.'<!-- Print Modal -->
                   <div class="modal fade" id="prt'.$adaptenvir->imp_home_id.'" role="dialog">
                     <div class="modal-dialog">

                        <!-- Modal content-->
                       <div class="modal-content">
                         <div class="modal-header text-left">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" style="color: #333; font-size: 16px;">พิมพ์แบบฟอร์ม</h4>
                          </div>
                         <div class="modal-body">
                           <div class="row">';

                    $tmp = $this->admin_model->getOnce_Application(34);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(34,get_session('user_id')); //Check User Permission

                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;"';
                    if(!isset($tmp1['perm_status'])) {
                      $btn = $btn.' class="disabled "';
                    }else if($usrpm['app_id']==34) {
                      $btn = $btn.' class="active "';
                    }
                    $btn = $btn.'>
                                 <a style="color: #333; font-size: 16px;" target="_blank" href="'.site_url('report/D1/pdf?id='.$adaptenvir->imp_home_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                    if(isset($tmp1['perm_status'])) {
                     $btn = $btn.$tmp1['app_name'];
                    }
                    $btn = $btn.'  </a>
                             </div>';

                    $tmp = $this->admin_model->getOnce_Application(35);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(35,get_session('user_id')); //Check User Permission
                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                    if(!isset($tmp1['perm_status'])) {
                        $btn = $btn.' class="disabled" ';
                    }else if($usrpm['app_id']==35) {
                        $btn = $btn.' class="active" ';
                    }
                    $btn = $btn.'>';

                     $btn = $btn.'<a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/D2/pdf?id='.$adaptenvir->imp_home_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                     if(isset($tmp1['perm_status'])) {
                       $btn = $btn.$tmp1['app_name'];
                     }
                     $btn = $btn.'
                            </a>
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
				"recordsTotal" => $this->adaptenvir->count_all(),
				"recordsFiltered" => $this->adaptenvir->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	public function adaptenvir_list($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		// ini_set('mex_execution_time',300);
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 29;
		$process_path = 'adaptenvir/adaptenvir_list';
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


			set_js_asset_footer('adaptenvir_list_ajax.js','adaptenvir'); //Set JS Index.js

			set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/ion.rangeSlider.min.js'); //Set JS Index.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'adaptenvir_list_ajax';


			$data['impv_home_info'] = $this->adaptenvir_model->getAll_impvHome();
			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			// dieArray($data);
			$this->template->load('index_page',$data,'adaptenvir');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	public function activity_list_ajax($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		// ini_set('max_execution_time', 300);
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 36;
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

			$this->load->model('activity_list_model','adaptenvir');
			$list = $this->adaptenvir->get_datatables();
			$data = array();
			$no = $_POST['start'];
			// dieArray($list);
			foreach ($list as $i=>$adaptenvir) {
				$no++;
				$row = array();

			  //$pers_info = $this->personal_model->getOnce_PersonalInfo($adaptenvir->pers_id);
			  $row[] = "<center>".$no."</center>";
			  $row[] = $adaptenvir->ptype_code_remark;


			  $date_of_svy = '-';
		    if($adaptenvir->date_of_svy!='') {
		      $date_of_svy = '<font class="text-sucsess" color="#18bd15">'.dateChange($adaptenvir->date_of_svy,5).'</font>';
		    }
		    $row[] = "<center>".$date_of_svy."</center>";

		    $consi_result = '-';
		    if($adaptenvir->consi_result=='อนุมัติ') {
		      $consi_result = '<font class="text-sucsess" color="#18bd15">'.$adaptenvir->consi_result.'</font>';
		    }else if($adaptenvir->consi_result=='ไม่อนุมัติ'){
              $consi_result = '<font class="text-sucsess" color="red">'.$adaptenvir->consi_result.'</font>';
		    }

		    $row[] = "<center>".$consi_result."</center>";

		    $date_of_finish = '-';
		    if($adaptenvir->date_of_finish!='') {
		      $date_of_finish = '<font class="text-sucsess" color="#18bd15">'.dateChange($adaptenvir->date_of_finish,5).'</font>';
		    }
		    $row[] = "<center>".$date_of_finish."<center>";

		    $row[] ="<div style='width:100%;text-align:right;'>".number_format($adaptenvir->case_budget,2)."</div>";





			    // $tmp = $this->admin_model->getOnce_Application(30);
			    // $tmp1 = $this->admin_model->chkOnce_usrmPermiss(30,$user_id); //Check User Permission
			    // $btn = ' <a ';
			    //               if(!isset($tmp1['perm_status'])) {
			    // 				$btn = $btn.' readonly ';
			    //               }else{
			    //               	$btn = $btn.' href="'.site_url('adaptenvir/ac_inquire1/Edit/'.@$adaptenvir->impv_place_id).'"';
			    //               }
			    //               if(isset($tmp['app_name'])){
			    //               	$btn = $btn.' title="'.$tmp['app_name'].'" ';
			    //               }
			    //               $btn = $btn.'
			    //                class="btn btn-default">
			    //                   <i class="fa fa-pencil-square" aria-hidden="true" style="color: #000"></i>
			    //               </a>

			    //               <a data-toggle="modal" data-target="#prt'.$i.'" title="พิมพ์แบบฟอร์ม" class="btn btn-default">
			    //                   <i class="fa fa-file-text" aria-hidden="true" style="color: #000"></i>
			    //               </a>
			    //               <!-- Print Modal -->
			    //               <div class="modal fade" id="prt'.$i.'" role="dialog">
			    //                 <div class="modal-dialog">

			    //                    <!-- Modal content-->
			    //                   <div class="modal-content">
			    //                     <div class="modal-header text-left">
			    //                       <button type="button" class="close" data-dismiss="modal">&times;</button>
			    //                        <h4 class="modal-title" style="color: #333; font-size: 16px;">พิมพ์แบบฟอร์ม</h4>
			    //                      </div>
			    //                     <div class="modal-body">
			    //                       <div class="row">';

			    //                         $tmp = $this->admin_model->getOnce_Application(41);
			    //                         $tmp1 = $this->admin_model->chkOnce_usrmPermiss(41,get_session('user_id')); //Check User Permission
			    //                     	$btn = $btn.'
			    //                         <div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;"
			    //                         ';
			    //                         if(!isset($tmp1['perm_status'])) {
			    //                             $btn = $btn.' class="disabled "';
			    //                           }else if($usrpm['app_id']==41) {
			    //                             $btn = $btn.' class="active" ';
			    //                           }
			    //                         $btn = $btn.'>
			    //                           <a style="color: #333; font-size: 16px;" target="_blank" href="'.site_url('report/D3/pdf?id='.$adaptenvir->impv_place_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
			    //                           	  if(isset($tmp1['perm_status'])) {
			    //                           	  	$btn = $btn.$tmp1['app_name'];
			    //                           	  }
			    //                         $btn = $btn.'
			    //                           </a>
			    //                         </div>';

			    //                         $tmp = $this->admin_model->getOnce_Application(42);
			    //                         $tmp1 = $this->admin_model->chkOnce_usrmPermiss(42,get_session('user_id')); //Check User Permission
			    //                         $btn = $btn.'
			    //                         <div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
			    //                         if(!isset($tmp1['perm_status'])) {
			    //                             $btn = $btn.' class="disabled" ';
			    //                           }else if($usrpm['app_id']==42) {
			    //                             $btn = $btn.' class="active" ';
			    //                           }
			    //                         $btn = $btn.'
			    //                         >
			    //                           <a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/D4/pdf?id='.$adaptenvir->impv_place_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
			    //                           	  if(isset($tmp1['perm_status'])) {
			    //                           		$btn = $btn.$tmp1['app_name'];
			    //                           	   }
			    //                         $btn = $btn.'
			    //                           </a>
			    //                         </div>';

			    //                          $tmp = $this->admin_model->getOnce_Application(43);
			    //                         $tmp1 = $this->admin_model->chkOnce_usrmPermiss(43,get_session('user_id')); //Check User Permission
			    //                         $btn = $btn.'
			    //                         <div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
			    //                         if(!isset($tmp1['perm_status'])) {
			    //                             $btn = $btn.' class="disabled" ';
			    //                           }else if($usrpm['app_id']==43) {
			    //                             $btn = $btn.' class="active" ';
			    //                           }
			    //                         $btn = $btn.'
			    //                         >
			    //                           <a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/D5/pdf?id='.$adaptenvir->impv_place_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
			    //                           	  if(isset($tmp1['perm_status'])) {
			    //                           		$btn = $btn.$tmp1['app_name'];
			    //                           	   }
			    //                         $btn = $btn.'
			    //                           </a>
			    //                         </div>
			    //                        </div>
			    //                        <br/>
			    //                     </div>
			    //                   </div>
			    //                 </div>
			    //                </div>
			    //                <!-- End Print Modal -->';

			    //                 $tmp = $this->admin_model->chkOnce_usrmPermiss(37,$user_id); //Check User Permission
			    //                 if(isset($tmp['perm_status'])) {
			    //                     if($tmp['perm_status']=='Yes') {
			    //                     	$btn = $btn.'
			    //                     <a data-id='.@$adaptenvir->impv_place_id.' onclick="opn(this)" title="ลบ" type="button" class="btn btn-default">
			    //                       <span class="glyphicon glyphicon-trash" style="color: #000"></span>
			    //                     </a>';
			    //                 	}
			    //                 }
			     $tmp = $this->admin_model->getOnce_Application(3);
                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                $btn = '';
                $btn =$btn.'<!-- Single button -->
                <div class="btn-group" style="cursor: pointer;">
                  <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>

                  <ul class="dropdown-menu" style="position: absolute;left: -190px;">';

                  $btn = $btn.' <li><a style="font-size:16px;" data-toggle="modal" data-target="#prt'.$adaptenvir->impv_place_id.'" title="พิมพ์แบบฟอร์ม" >
                       <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #000"></i> พิมพ์แบบฟอร์ม (.PDF)
                   </a></li>';


                  $btn =$btn.'<li><a  style="font-size:16px;"';

                  if(!isset($tmp1['perm_status'])){ $btn =$btn.'class="disabled"';}else{ $btn =$btn.'href="'.site_url("adaptenvir/ac_inquire1/Edit/".$adaptenvir->impv_place_id); }
                  $btn =$btn.'"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>';




                    $tmp = $this->admin_model->chkOnce_usrmPermiss(37,$user_id); //Check User Permission
                    if(isset($tmp['perm_status'])) {
                        if($tmp['perm_status']=='Yes') {
                         $btn = $btn.'<li><a style="font-size:16px;" data-id='.$adaptenvir->impv_place_id.' onclick="opn(this)" title="ลบ" >
                             <i class="fa fa-trash" style="color: #000"></i> ลบรายการ
                          </a></li>';
                      }
                    }

                  $btn = $btn.'</ul>
                              </div>';

                $btn =$btn.'<!-- Print Modal -->
                   <div class="modal fade" id="prt'.$adaptenvir->impv_place_id.'" role="dialog">
                     <div class="modal-dialog">

                        <!-- Modal content-->
                       <div class="modal-content">
                         <div class="modal-header text-left">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" style="color: #333; font-size: 16px;">พิมพ์แบบฟอร์ม</h4>
                          </div>
                         <div class="modal-body">
                           <div class="row">';

                    $tmp = $this->admin_model->getOnce_Application(41);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(41,get_session('user_id')); //Check User Permission

                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;"';
                    if(!isset($tmp1['perm_status'])) {
                      $btn = $btn.' class="disabled "';
                    }else if($usrpm['app_id']==41) {
                      $btn = $btn.' class="active "';
                    }
                    $btn = $btn.'>
                                 <a style="color: #333; font-size: 16px;" target="_blank" href="'.site_url('report/D3/pdf?id='.$adaptenvir->impv_place_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                    if(isset($tmp1['perm_status'])) {
                     $btn = $btn.$tmp1['app_name'];
                    }
                    $btn = $btn.'  </a>
                             </div>';

                    $tmp = $this->admin_model->getOnce_Application(42);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(42,get_session('user_id')); //Check User Permission
                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                    if(!isset($tmp1['perm_status'])) {
                        $btn = $btn.' class="disabled" ';
                    }else if($usrpm['app_id']==42) {
                        $btn = $btn.' class="active" ';
                    }
                    $btn = $btn.'>';

                     $btn = $btn.'<a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/D4/pdf?id='.$adaptenvir->impv_place_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                     if(isset($tmp1['perm_status'])) {
                       $btn = $btn.$tmp1['app_name'];
                     }
                     $btn = $btn.'
                            </a>
                          </div>';

                    $tmp = $this->admin_model->getOnce_Application(43);
                    $tmp1 = $this->admin_model->chkOnce_usrmPermiss(43,get_session('user_id')); //Check User Permission

                    $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                    if(!isset($tmp1['perm_status'])) {
                        $btn = $btn.' class="disabled" ';
                      }else if($usrpm['app_id']==43) {
                        $btn = $btn.' class="active" ';
                      }
                    $btn = $btn.'>';
                    $btn = $btn.'<a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/D5/pdf?id='.$adaptenvir->impv_place_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
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

            // dieArray($data);
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->adaptenvir->count_all(),
				"recordsFiltered" => $this->adaptenvir->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	public function activity_list($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 36;
		$process_path = 'adaptenvir/activity_list';
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

			$data['impv_place_info'] = $this->adaptenvir_model->getAll_impvPlace();

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			/*-- Load Datatables for Theme --*/
			set_css_asset_head('../plugins/Static_Full_Version/css/plugins/dataTables/datatables.min.css');
			set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/dataTables/datatables.min.js');
			/*-- End Load Datatables for Theme --*/

  		/*-- Toastr style --*/
  		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
  		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
  		/*-- End Toastr style --*/

			set_js_asset_footer('activity_list_ajax.js','adaptenvir'); //Set JS Index.js

			set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/ion.rangeSlider.min.js'); //Set JS Index.js


			$data['process_action'] = $process_action;
			$data['content_view'] = 'activity_list_ajax';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];
			// dieArray($data);
			$this->template->load('index_page',$data,'adaptenvir');
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

	private function clr_diffInfo_form1() {
		return array(
					'date_of_svy' => date('d-m-Y'),
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
					'req_tel_no_home' => '',
					'req_tel_no_mobile' => '',
					'req_fax_no' => '',
					'req_email_addr' => '',
					'chn_code' => '',

					'pid' => '',
					'pers_id' => '',
					'name' => ' - ',
					'date_of_birth' => ' - ',
					'gender_name' => ' - ',
					'nation_name_th' => ' - ',
					'relg_title' => ' - ',
					'tel_no_home' => '',
					'tel_no_mobile' => '',
					'fax_no' => '',
					'email_addr' => '',
					'reg_addr_id' => '',
					'pre_addr_id' => ''
		);
	}

	public function inquire1($process_action='Add',$imp_home_id=0) { //แบบขอรับบริการ (แจ้งเรื่อง)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 30;
		$process_path = 'adaptenvir/inquire1';
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

			// $data['impv_home_info'] = $this->difficult_model->getAll_diffInfo();

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
			set_js_asset_footer('inquire1.js','adaptenvir'); //Set JS inquire1.js

			set_js_asset_footer('mapmarker.js','webconfig'); //Set JS mapmarker.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'inquire1';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$data['impv_home_info'] = array(
					'date_of_svy'=>date("d-m-Y"),
					'pid' => '',
					'pers_id' => '',
					'name' => ' - ',
					'date_of_birth' => ' - ',
					'gender_name' => ' - ',
					'nation_name_th' => ' - ',
					'relg_title' => ' - ',
					'tel_no_home' => '',
					'tel_no_mobile' => '',
					'fax_no' => '',
					'email_addr' => '',
					'reg_add_info'=> '-',
					'reg_addr_id' => '',
					'pre_addr_id' => ''
				);

				$this->template->load('index_page',$data,'adaptenvir');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('impv_home_info[date_of_svy]','วันที่สอบถาม','required|callback_date_check');
				$frm->set_rules('impv_home_info[pers_id]','เลขประจำตัวประชาชน','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data
					$data_insert = array();
					$data_insert = get_inpost_arr("impv_home_info");
					$data_insert['date_of_svy'] 		= dateChange($data_insert['date_of_svy'],4);
					$data_insert['insert_user_id'] 	= getUser();
					$data_insert['insert_org_id']		= get_session("org_id");
					$data_insert['insert_datetime'] = getDatetime();

					unset($data_insert['pid']);

					$id = $this->common_model->insert('impv_home_info',$data_insert);
					// $id = 1;
					// dieArray($data_insert);

					// update pers_info ///////////////////////////////
					$data_update_pers = get_inpost_arr('pers_info');
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
					unset($data_update_pers['fax_no']);
					unset($data_update_pers['email_addr']);
					unset($data_update_pers['tel_no_mobile']);

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

					$this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('impv_home_info[pers_id]')));
					///////////////////////////////////////////////////

					$trm_condi = @get_inpost_arr("impv_home_condition[hcond_code]");
					if(!empty($trm_condi)){
						foreach ($trm_condi as $row) {
							$hcond_insert = array(
								'impv_home_id' 	=> $id,
								'hcond_code' 		=> $row,
								'hcond_remark' 	=> get_inpost("impv_home_condition[hcond_remark][{$row}]"),
							);
							$this->common_model->insert("impv_home_condition",$hcond_insert);
						}
					}

          // insert pers_family ///////////////////////////////////////////
          //$tmp_family = @get_inpost_arr("pers_family");
          $tmp_family = get_inpost_arr("pers_family[fml_pid]");
          // dieFont(get_inpost("pers_family[fml_relation][0]"));
          // dieArray($_POST['pers_family']);
          if(!empty($tmp_family)){
            if(current($tmp_family) != ''){
              $this->common_model->delete_where('pers_family','pers_id',get_inpost('adm_info[pers_id]'));
              foreach ($tmp_family as $key => $rFml) {
                // dieFont($rFml);

                $fml_insert = array(
                  'pers_id'       => get_inpost('adm_info[pers_id]'),
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

                //dieArray($fml_insert);

                $this->common_model->insert('pers_family',$fml_insert);
              }
              // dieArray($fml_pers_update);
            }
          }
          /////////////////////////////////////////////////////////////////

					// dieArray($hcond_insert);

					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('adaptenvir/inquire1/Edit/'.$id,'refresh');

				}else {
					// $data['impv_home_info'] = $_POST['impv_home_info'];
					// $data['elder_addr_chk'] = set_value('elder_addr_chk');

					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

					$this->template->load('index_page',$data,'adaptenvir');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {

				$row = rowArray($this->common_model->custom_query("
					SELECT * FROM impv_home_info
					WHERE imp_home_id = {$imp_home_id}
					AND delete_user_id IS NULL
					AND (delete_datetime IS NULL || delete_datetime = '0000-00-00 00:00:00')
				"));

				if(isset($row['imp_home_id'])) {
					$pers_info = $this->personal_model->getOnce_PersonalInfo($row['pers_id']);
					$data['impv_home_info'] = array_merge($row,$pers_info);
					$data['addr_info'] = $this->personal_model->getOnce_PersonalAddress($pers_info['pre_addr_id']);
					$data['pers_info'] = $pers_info;

					$data['impv_home_info']['name'] = $pers_info['name'];
          if($pers_info['date_of_birth']!='') {
            $date = new DateTime($pers_info['date_of_birth']);
            $now = new DateTime();
            $interval = $now->diff($date);
            $age = $interval->y;
            $data['impv_home_info']['date_of_birth'] = formatDateThai($pers_info['date_of_birth']).' (อายุ '.$age.' ปี)';
          }else {
          	$data['impv_home_info']['date_of_birth'] = ' - ';
          }
					$data['impv_home_info']['gender_name'] = $pers_info['gender_name']==''?' - ':$pers_info['gender_name'];
					$data['impv_home_info']['nation_name_th'] = $pers_info['nation_name_th']==''?' - ':$pers_info['nation_name_th'];
					$data['impv_home_info']['relg_title'] = $pers_info['relg_title']==''?' - ':$pers_info['relg_title'];
					$data['impv_home_info']['reg_add_info'] = @"{$data['addr_info']['addr_home_no']} หมู่ {$data['addr_info']['addr_moo']} ต. {$data['addr_info']['addr_sub_district']} อ. {$data['addr_info']['addr_district']} จ. {$data['addr_info']['addr_province']} {$data['addr_info']['addr_zipcode']}";

					if($data['impv_home_info']['date_of_svy']!='') {
						$tmp = explode('-',$data['impv_home_info']['date_of_svy']);
						$data['impv_home_info']['date_of_svy'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}

					$trm_condi = $this->common_model->custom_query("
						SELECT * FROM impv_home_condition
						WHERE impv_home_id = {$imp_home_id}
					");
					$data['impv_home_condition'] = sort_array_with($trm_condi,"hcond_code");

					$tmp_family = $this->common_model->custom_query("SELECT * FROM pers_family WHERE pers_id = {$row['pers_id']}");
					// dieArray($tmp_family);
					foreach ($tmp_family as $key => $value) {
						$data['pers_family'][] = array_merge($value,$this->personal_model->getPersonalInfo($value['ref_pers_id']));
					}

					// dieArray($data);
					$this->template->load('index_page',$data,'adaptenvir');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('impv_home_info[date_of_svy]','วันที่สอบถาม','required|callback_date_check');
				$frm->set_rules('impv_home_info[pers_id]','เลขประจำตัวประชาชน','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = array();
					$data_update = get_inpost_arr("impv_home_info");
					$data_update['date_of_svy'] 		= dateChange($data_update['date_of_svy'],4);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();

					unset($data_update['pid']);

					$this->common_model->update('impv_home_info',$data_update,array('imp_home_id'=>$imp_home_id));

					/// impv_home_condition
					$trm_condi = get_inpost_arr("impv_home_condition[hcond_code]");
					if(!empty($trm_condi)){
						$this->common_model->delete_where('impv_home_condition','impv_home_id',$imp_home_id);
						foreach ($trm_condi as $row) {
							$hcond_insert = array(
								'impv_home_id' 	=> $imp_home_id,
								'hcond_code' 		=> $row,
								'hcond_remark' 	=> get_inpost("impv_home_condition[hcond_remark][{$row}]"),
							);
							$this->common_model->insert("impv_home_condition",$hcond_insert);
						}
					}

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

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

					$this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('impv_home_info[pers_id]')));

          // insert pers_family ///////////////////////////////////////////
          //$tmp_family = @get_inpost_arr("pers_family");
          $tmp_family = get_inpost_arr("pers_family[fml_pid]");

          if(!empty($tmp_family)){
            if(current($tmp_family) != ''){
              $this->common_model->delete_where('pers_family','pers_id',get_inpost('adm_info[pers_id]'));
              foreach ($tmp_family as $key => $rFml) {
                $fml_insert = array(
                  'pers_id'       => get_inpost('adm_info[pers_id]'),
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
					redirect('adaptenvir/inquire1/Edit/'.$imp_home_id,'refresh');
				}else {


					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'adaptenvir');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['delete_org_id'] 	= get_session('org_id');
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('impv_home_info',$data_update,array('imp_home_id'=>$imp_home_id));

				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('adaptenvir/adaptenvir_list','refresh');
			}else {
				page500();
				// $this->template->load('index_page',$data,'adaptenvir');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function ac_inquire1($process_action='Add',$impv_place_id=0) { //แบบขอรับบริการ (แจ้งเรื่อง)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 37;
		$process_path = 'adaptenvir/ac_inquire1';
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

  		set_js_asset_footer('mapmarker.js','webconfig'); //Set JS mapmarker.js


			set_js_asset_footer('webservice.js','personals	'); //Set JS sufferer_form1.js
			set_js_asset_footer('ac_inquire1.js','adaptenvir'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'ac_inquire1';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$data['impv_place_info'] = array(
					'date_of_svy'=>date("d-m-Y"),
					'pid' => '',
					'pers_id' => '',
					'name' => ' - ',
					'date_of_birth' => ' - ',
					'gender_name' => ' - ',
					'nation_name_th' => ' - ',
					'relg_title' => ' - ',
					'tel_no_home' => '',
					'tel_no_mobile' => '',
					'fax_no' => '',
					'email_addr' => '',
					'reg_add_info'=>'-',
					'reg_addr_id' => '',
					'pre_addr_id' => ''
				);

				$this->template->load('index_page',$data,'adaptenvir');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('impv_place_info[date_of_svy]','วันที่สอบถาม','required|callback_date_check');
				$frm->set_rules('impv_place_info[pers_id]','เลขประจำตัวประชาชน','required');


				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data
					$data_insert = array();
					$data_insert = get_inpost_arr('impv_place_info');
					$data_insert['date_of_svy'] 		= dateChange($data_insert['date_of_svy'],4);
					$data_insert['insert_user_id'] 	= getUser();
					$data_insert['insert_org_id']		= get_session("org_id");
					$data_insert['insert_datetime'] = getDatetime();

					unset($data_insert['pid']);

					$id = $this->common_model->insert('impv_place_info',$data_insert);

					$trm_condi = get_inpost_arr('impv_place_condition[pcond_code]');
					if(!empty($trm_condi)){
						foreach ($trm_condi as $row) {
							$pcond_insert = array(
								'impv_place_id' 	=> $id,
								'pcond_code' 		=> $row,
								'pcond_remark' 	=> get_inpost("impv_place_condition[pcond_remark][{$row}]"),
							);
							$this->common_model->insert("impv_place_condition",$pcond_insert);
						}
					}
					//// UPDATE ADDRESS AND PERS_INFO //////////////////////////////
					$data_update_pers = get_inpost_arr('pers_info');
					if(get_inpost('elder_addr_chk')!='on') {
						//add new addr
						$data_update_addr = get_inpost_arr('pers_addr');
						$data_update_addr['update_user_id']		= getUser();
						$data_update_addr['update_datetime']	= getDatetime();



						// $this->common_model->update('pers_addr',$data_update_addr,array('addr_id'=>get_inpost('pre_addr_id')));
						$new_addr_id = $this->common_model->insert('pers_addr',$data_insert_addr);
						$data_update_pers['pre_addr_id'] = $new_addr_id;
					}else{
						$data_update_pers['pre_addr_id'] = $data_update_pers['reg_addr_id'];
					}

					unset($data_update_pers['tel_no_home']);
					unset($data_update_pers['fax_no']);
					unset($data_update_pers['email_addr']);
					unset($data_update_pers['tel_no_mobile']);

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

					// $this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('impv_place_info[pers_id]')));
					////////////////////////////////////////////////////////////////

					// insert impv_place_member ////////////////////////////////////
					$impv_place_member = @get_inpost_arr('impv_place_member[pers_id]');
					if(!empty($impv_place_member)){
						foreach ($impv_place_member as $key => $ipmID) {
							$ipm_insert = array(
								'mbr_pers_id' => $ipmID,
								'impv_place_id' => $id,
							);
							$this->common_model->insert('impv_place_member',$ipm_insert);

							$pers_ipm_update = array(
								'occupation' 				=> get_inpost("impv_place_member[occupation][{$key}]"),
								'edu_code' 					=> get_inpost("impv_place_member[edu_code][{$key}]"),
								'healthy' 					=> get_inpost("impv_place_member[healthy][{$key}]"),
								'healthy_self_help' => get_inpost("impv_place_member[healthy_self_help][{$key}]"),

								'update_user_id'	=> getUser(),
								'update_org_id'		=> get_session('org_id'),
								'update_datetime'	=> getDatetime(),
							);


							// $this->common_model->update('pers_info',$pers_ipm_update,array('pers_id'=>$ipmID));

						}
					}
					////////////////////////////////////////////////////////////////

					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('adaptenvir/ac_inquire1/Edit/'.$id,'refresh');
				}else {
					//// SET VALUE //////////////////

					/////////////////////////////////

					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012
					$this->template->load('index_page',$data,'adaptenvir');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = rowArray($this->common_model->custom_query("
					SELECT * FROM impv_place_info
					WHERE impv_place_id = {$impv_place_id}
					AND delete_user_id IS NULL
					AND (delete_datetime IS NULL || delete_datetime = '0000-00-00 00:00:00')
				"));

				if(isset($row['impv_place_id'])) {
					$pers_info = $this->personal_model->getOnce_PersonalInfo($row['pers_id']);
					$data['impv_place_info'] = array_merge($row,$pers_info);
					$data['pers_info'] = $pers_info;
					$data['addr_info'] = $this->personal_model->getOnce_PersonalAddress($pers_info['pre_addr_id']);

					$data['impv_place_info']['name'] = $pers_info['name'];
          if($pers_info['date_of_birth']!='') {
            $date = new DateTime($pers_info['date_of_birth']);
            $now = new DateTime();
            $interval = $now->diff($date);
            $age = $interval->y;
            $data['impv_place_info']['date_of_birth'] = formatDateThai($pers_info['date_of_birth']).' (อายุ '.$age.' ปี)';
          }else {
          	$data['impv_place_info']['date_of_birth'] = ' - ';
          }
					$data['impv_place_info']['gender_name'] = $pers_info['gender_name']==''?' - ':$pers_info['gender_name'];
					$data['impv_place_info']['nation_name_th'] = $pers_info['nation_name_th']==''?' - ':$pers_info['nation_name_th'];
					$data['impv_place_info']['relg_title'] = $pers_info['relg_title']==''?' - ':$pers_info['relg_title'];
					$tmp2 = $this->personal_model->getOnce_PersonalAddress($pers_info['reg_addr_id']);
					$data['impv_place_info']['reg_add_info'] = @"{$tmp2['addr_home_no']} หมู่ {$tmp2['addr_moo']} ต. {$tmp2['addr_sub_district']} อ. {$tmp2['addr_district']} จ. {$tmp2['addr_province']} {$tmp2['addr_zipcode']}";


					if($data['impv_place_info']['date_of_svy']!='') {
						$tmp = explode('-',$data['impv_place_info']['date_of_svy']);
						$data['impv_place_info']['date_of_svy'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}

					$trm_condi = $this->common_model->custom_query("
						SELECT * FROM impv_place_condition
						WHERE impv_place_id = {$impv_place_id}
					");
					$data['impv_place_condition'] = sort_array_with($trm_condi,"pcond_code");

					// $data['impv_place_member'] = $this->common_model->custom_query("SELECT * FROM impv_place_member AS A LEFT JOIN pers_info AS B ON A.mbr_pers_id = B.pers_id");
					$data['impv_place_member'] = array();
					$imvTmp = $this->common_model->custom_query("SELECT * FROM impv_place_member WHERE impv_place_id = {$impv_place_id}");
					foreach ($imvTmp as $key => $value) {
						$data['impv_place_member'][] = array_merge($value,$this->personal_model->getPersonalInfo($value['mbr_pers_id']));
					}

					// dieArray($data);
					$this->template->load('index_page',$data,'adaptenvir');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('impv_place_info[date_of_svy]','วันที่สอบถาม','required|callback_date_check');
				$frm->set_rules('impv_place_info[pers_id]','เลขประจำตัวประชาชน','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = array();
					$data_update = get_inpost_arr("impv_place_info");
					$data_update['date_of_svy'] 		= dateChange($data_update['date_of_svy'],4);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();

					unset($data_update['pid']);

					$this->common_model->update('impv_place_info',$data_update,array('impv_place_id'=>$impv_place_id));

					/// impv_place_condition
					$trm_condi = get_inpost_arr("impv_place_condition[pcond_code]");
					if(!empty($trm_condi)){
						$this->common_model->delete_where('impv_place_condition','impv_place_id',$impv_place_id);
						foreach ($trm_condi as $row) {
							$pcond_insert = array(
								'impv_place_id' 	=> $impv_place_id,
								'pcond_code' 		=> $row,
								'pcond_remark' 	=> get_inpost("impv_place_condition[pcond_remark][{$row}]"),
							);
							$this->common_model->insert("impv_place_condition",$pcond_insert);
						}
					}

					//// UPDATE ADDRESS AND PERS_INFO //////////////////////////////
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

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

					$this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('impv_place_info[pers_id]')));
					////////////////////////////////////////////////////////////////

					// insert impv_place_member ////////////////////////////////////
					$impv_place_member = @get_inpost_arr('impv_place_member[pers_id]');
					if(!empty($impv_place_member)){
						$this->common_model->delete_where('impv_place_member','impv_place_id',$impv_place_id);
						foreach ($impv_place_member as $key => $ipmID) {
							$ipm_insert = array(
								'mbr_pers_id' => $ipmID,
								'impv_place_id' => $impv_place_id,
							);
							$this->common_model->insert('impv_place_member',$ipm_insert);

							$pers_ipm_update = array(
								'occupation' 				=> get_inpost("impv_place_member[occupation][{$key}]"),
								'edu_code' 					=> get_inpost("impv_place_member[edu_code][{$key}]"),
								'healthy' 					=> get_inpost("impv_place_member[healthy][{$key}]"),
								'healthy_self_help' => get_inpost("impv_place_member[healthy_self_help][{$key}]"),

								'update_user_id'	=> getUser(),
								'update_org_id'		=> get_session('org_id'),
								'update_datetime'	=> getDatetime(),
							);
							$this->common_model->update('pers_info',$pers_ipm_update,array('pers_id'=>$ipmID));

						}
					}
					////////////////////////////////////////////////////////////////

					// die();
					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('adaptenvir/ac_inquire1/Edit/'.$impv_place_id,'refresh');


				}else {
					// set value //////////////

					///////////////////////////

					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'adaptenvir');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				$data_update = array();
				$data_update['delete_user_id'] = getUser();
				$data_update['delete_org_id']		= get_session("org_id");
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('impv_place_info',$data_update,array('impv_place_id'=>$impv_place_id));

				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('adaptenvir/activity_list','refresh');
			}else {
				page500();
				$this->template->load('index_page',$data,'adaptenvir');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function agree2($process_action='Add',$imp_home_id=0) { //ยินยอม
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 31;
		$process_path = 'adaptenvir/agree2';
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
  		set_js_asset_footer('webservice.js','personals');
			set_js_asset_footer('agree2.js','adaptenvir'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] 	= 'agree2';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			// $this->template->load('index_page',$data,'adaptenvir');

			// dieArray($usrpm);
			if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = rowArray($this->common_model->custom_query("
					SELECT * FROM impv_home_info
					WHERE imp_home_id = {$imp_home_id}
					AND delete_user_id IS NULL
					AND (delete_datetime IS NULL || delete_datetime = '0000-00-00 00:00:00')
				"));
				// dieArray($row);
				if(isset($row['imp_home_id'])) {
					$data['impv_home_info'] = $row;
					// dieArray($row);
					if($row['cns_pers_id'] == ''){
						$temp = array(
							'pid' => '',
							'cns_pers_id' => '',
							'name' => ' - ',
							'date_of_birth' => ' - ',
							'gender_name' => ' - ',
							'nation_name_th' => ' - ',
							'relg_title' => ' - ',
							'tel_no_home' => '',
							'tel_no_mobile' => '',
							'fax_no' => '',
							'email_addr' => '',
							'reg_addr_id' => '',
							'pre_addr_id' => ''
						);
					}else{
						$temp = $this->personal_model->getOnce_PersonalInfo($row['cns_pers_id']);
						$data['addr_info'] = $this->personal_model->getOnce_PersonalAddress($temp['pre_addr_id']);
						$data['pers_info'] = $temp;
						$data['impv_home_info']['name'] = $temp['name'];
	          if($temp['date_of_birth']!='') {
	            $date = new DateTime($temp['date_of_birth']);
	            $now = new DateTime();
	            $interval = $now->diff($date);
	            $age = $interval->y;
	            $data['impv_home_info']['date_of_birth'] = formatDateThai($temp['date_of_birth']).' (อายุ '.$age.' ปี)';
	          }else {
	          	$data['impv_home_info']['date_of_birth'] = ' - ';
	          }
						$data['impv_home_info']['gender_name'] = $temp['gender_name']==''?' - ':$temp['gender_name'];
						$data['impv_home_info']['nation_name_th'] = $temp['nation_name_th']==''?' - ':$temp['nation_name_th'];
						$data['impv_home_info']['relg_title'] = $temp['relg_title']==''?' - ':$temp['relg_title'];
						$data['impv_home_info']['reg_add_info'] = @"{$data['addr_info']['addr_home_no']} หมู่ {$data['addr_info']['addr_moo']} ต. {$data['addr_info']['addr_sub_district']} อ. {$data['addr_info']['addr_district']} จ. {$data['addr_info']['addr_province']} {$data['addr_info']['addr_zipcode']}";
					}

					$data['impv_home_info'] = array_merge($data['impv_home_info'],$temp);
					// dieArray($data);
					if($row['date_of_consi']!='' && $row['date_of_consi'] != '0000-00-00') {
						// dieFont($row['date_of_consi']);
						$tmp = explode('-',$row['date_of_consi']);
						$data['impv_home_info'] ['date_of_consi'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['impv_home_info'] ['date_of_consi'] = date("d-m-Y");
					}

					$this->template->load('index_page',$data,'adaptenvir');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('impv_home_info[date_of_consi]','วันที่ออกใบสำคัญรับเงิน','required|callback_date_check');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				// dieArray($_POST);
				if($frm->run($this)){//Valid Data

					$data_update = get_inpost_arr('impv_home_info');
					$data_update['date_of_consi'] 	= dateChange($data_update['date_of_consi'],4);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();

					$this->common_model->update('impv_home_info',$data_update,array('imp_home_id'=>$imp_home_id));

					//// UPDATE ADDRESS AND PERS_INFO //////////////////////////////
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

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

					unset($data_update_pers['tel_no_home']);
					unset($data_update_pers['fax_no']);
					unset($data_update_pers['email_addr']);
					unset($data_update_pers['tel_no_mobile']);

					$this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('impv_home_info[cns_pers_id]')));
					////////////////////////////////////////////////////////////////

					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('adaptenvir/agree2/Edit/'.$imp_home_id,'refresh');

				}else {
					// $data['impv_home_info'] = get_inpost_arr('impv_home_info');
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'adaptenvir');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else {
				page500();
				// $this->template->load('index_page',$data,'adaptenvir');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function ac_agree2($process_action='Add',$impv_place_id=0) { //ยินยอม
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 38;
		$process_path = 'adaptenvir/ac_agree2';
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

			set_js_asset_footer('webservice.js','personals'); //Set JS sufferer_form1.js
			set_js_asset_footer('ac_agree2.js','adaptenvir'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] 	= 'ac_agree2';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = $this->adaptenvir_model->getOnce_impvPlace($impv_place_id);
				// dieArray($row);
				if(isset($row['impv_place_id'])) {
					$data['impv_place_info'] = $row;

					if($row['cns_pers_id'] == ''){
						$temp = array(
							'pid' => '',
							'cns_pers_id' => '',
							'name' => ' - ',
							'date_of_birth' => ' - ',
							'gender_name' => ' - ',
							'nation_name_th' => ' - ',
							'relg_title' => ' - ',
							'tel_no_home' => '',
							'tel_no_mobile' => '',
							'fax_no' => '',
							'email_addr' => '',
							'reg_addr_id' => '',
							'pre_addr_id' => ''
						);
					}else{
						$temp = $this->personal_model->getPersonalInfo($row['cns_pers_id']);
						$data['addr_info'] = $this->personal_model->getOnce_PersonalAddress($temp['pre_addr_id']);
						// $data['pers_info'] = $temp;
						// $data['impv_place_info']['name'] = $temp['name'];
	     //      if($temp['date_of_birth']!='') {
	     //        $date = new DateTime($temp['date_of_birth']);
	     //        $now = new DateTime();
	     //        $interval = $now->diff($date);
	     //        $age = $interval->y;
	     //        $data['impv_place_info']['date_of_birth'] = formatDateThai($temp['date_of_birth']).' (อายุ '.$age.' ปี)';
	     //      }else {
	     //      	$data['impv_place_info']['date_of_birth'] = ' - ';
	     //      }
						// $data['impv_place_info']['gender_name'] = $temp['gender_name']==''?' - ':$temp['gender_name'];
						// $data['impv_place_info']['nation_name_th'] = $temp['nation_name_th']==''?' - ':$temp['nation_name_th'];
						// $data['impv_place_info']['relg_title'] = $temp['relg_title']==''?' - ':$temp['relg_title'];
						// $data['impv_place_info']['reg_add_info'] = @"{$data['addr_info']['addr_home_no']} หมู่ {$data['addr_info']['addr_moo']} ต. {$data['addr_info']['addr_sub_district']} อ. {$data['addr_info']['addr_district']} จ. {$data['addr_info']['addr_province']} {$data['addr_info']['addr_zipcode']}";
					}

					$data['impv_place_info'] = array_merge($data['impv_place_info'],$temp);
					// dieArray($data);
					if($row['date_of_consi']!='' && $row['date_of_consi'] != '0000-00-00') {
						// dieFont($row['date_of_consi']);
						$tmp = explode('-',$row['date_of_consi']);
						$data['impv_place_info'] ['date_of_consi'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['impv_place_info'] ['date_of_consi'] = date("d-m-Y");
					}
					// dieArray($data);
					$this->template->load('index_page',$data,'adaptenvir');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('impv_place_info[date_of_consi]','วันที่ออกใบสำคัญรับเงิน','required|callback_date_check');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				// dieArray($_POST);
				if($frm->run($this)){//Valid Data

					$data_update = get_inpost_arr('impv_place_info');
					$data_update['date_of_consi'] 	= dateChange($data_update['date_of_consi'],4);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();

					$this->common_model->update('impv_place_info',$data_update,array('impv_place_id'=>$impv_place_id));

					//// UPDATE ADDRESS AND PERS_INFO //////////////////////////////
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

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

					unset($data_update_pers['tel_no_home']);
					unset($data_update_pers['fax_no']);
					unset($data_update_pers['email_addr']);
					unset($data_update_pers['tel_no_mobile']);

					$this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('impv_place_info[cns_pers_id]')));
					////////////////////////////////////////////////////////////////

					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('adaptenvir/ac_agree2/Edit/'.$impv_place_id,'refresh');

				} else {

					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'adaptenvir');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			} else {
				page500();
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}
		}
	}


	public function assist3($process_action='Add',$imp_home_id=0) { //แบบขอรับบริการ (สงเคราะห์)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 32;
		$process_path = 'adaptenvir/assist3';
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

            set_css_asset_head('../modules/adaptenvir/css/gallery_img.css');
			set_js_asset_footer('assist3.js','adaptenvir'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] 	= 'assist3';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);


			if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = rowArray($this->common_model->custom_query("
					SELECT * FROM impv_home_info
					WHERE imp_home_id = {$imp_home_id}
					AND delete_user_id IS NULL
					AND (delete_datetime IS NULL || delete_datetime = '0000-00-00 00:00:00')
				"));
				if(isset($row['imp_home_id'])) {
					$data['impv_home_info'] = $row;

					if($row['date_of_finish']!='') {
						$tmp = explode('-',$row['date_of_finish']);
						$data['impv_home_info']['date_of_finish'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['impv_home_info']['date_of_finish'] = date("d-m-Y");
					}


					$data['impv_photo'] = $this->adaptenvir_model->get_img($imp_home_id);

						// dieArray($row);



					// dieArray($data);
					$this->template->load('index_page',$data,'adaptenvir');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('impv_home_info[date_of_finish]','วันที่ดำเนินการเสร็จสิ้น','required|callback_date_check');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = get_inpost_arr('impv_home_info');
					$data_update['date_of_finish'] 	= dateChange($data_update['date_of_finish'],4);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();
					// dieArray($data_update);
					$this->common_model->update('impv_home_info',$data_update,array('imp_home_id'=>$imp_home_id));

					// upload images ////////////////////////////////////////
                       if($_FILES['img']['name'][0]!=""){

                 	  $photo = $this->files_model->getMultiImg("img",'assets/modules/adaptenvir/images');


                 	 	      $i=0;
					        foreach ($photo as $key_photo => $value_photo) {

					        	if($_FILES['img']['name'][$i]!=""){

		                           	$insert_photo = array('impv_home_id' 		  =>$imp_home_id,
			                           		        	  'impv_home_photo_file'  =>$value_photo['file'],
			                           		        	  'impv_home_photo_label' =>$value_photo['name'],
			                           		        	  'impv_home_photo_size'  =>$_FILES['img']['size'][$i],
			                           		        	  );

		                           	$this->common_model->insert('impv_home_info_photo',$insert_photo);

		                           }
	                         $i++;
                           }// close loop foreach ($id_photo as $key_photo => $value_photo)

                     }

					/////////////////////////////////////////////////////////


					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('adaptenvir/assist3/Edit/'.$imp_home_id,'refresh');

				}else {
					// $data['impv_home_info'] = $_POST['impv_home_info'];
					// $data['impv_home_info'] = get_inpost_arr('impv_home_info');
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'adaptenvir');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else {
				page500();
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function del_impv_photo(){
  	$id_photo = get_inpost('id_photo');
  	$this->common_model->delete_where('impv_home_info_photo','impv_home_photo_id',$id_photo);
 	echo "remove";
    }

    public function del_impv_place_photo(){
  	$id_photo = get_inpost('id_photo');
  	$this->common_model->delete_where('impv_place_info_photo','impv_place_photo_id',$id_photo);
 	echo "remove";
    }

	public function ac_assist3($process_action='Add',$impv_place_id=0) { //แบบขอรับบริการ (สงเคราะห์)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 39;
		$process_path = 'adaptenvir/ac_assist3';
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

            set_css_asset_head('../modules/adaptenvir/css/gallery_img.css');
			set_js_asset_footer('ac_assist3.js','adaptenvir'); //Set JS sufferer_form1.js

			$data['process_action'] = $process_action;
			$data['content_view'] 	= 'ac_assist3';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] 			= $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = $this->adaptenvir_model->getOnce_impvPlace($impv_place_id);
				if(isset($row['impv_place_id'])) {
					$data['impv_place_info'] = $row;

					if($row['date_of_finish']!='') {
						$tmp = explode('-',$row['date_of_finish']);
						$data['impv_place_info']['date_of_finish'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['impv_place_info']['date_of_finish'] = date("d-m-Y");
					}

					$data['impv_photo'] = $this->adaptenvir_model->get_img_place($impv_place_id);

					// dieArray($data);
					$this->template->load('index_page',$data,'adaptenvir');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('impv_place_info[date_of_finish]','วันที่ดำเนินการเสร็จสิ้น','required|callback_date_check');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = get_inpost_arr('impv_place_info');
					$data_update['date_of_finish'] 	= dateChange($data_update['date_of_finish'],4);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();
					// dieArray($data_update);
					$this->common_model->update('impv_place_info',$data_update,array('impv_place_id'=>$impv_place_id));

					// upload images ////////////////////////////////////////
                       if($_FILES['img']['name'][0]!=""){

                 	  $photo = $this->files_model->getMultiImg("img",'assets/modules/adaptenvir/images');

                 	//dieArray($photo);
                 	 	      $i=0;
					        foreach ($photo as $key_photo => $value_photo) {

					        	if($_FILES['img']['name'][$i]!=""){

		                           	$insert_photo = array('impv_place_id' 		   =>$impv_place_id,
			                           		        	  'impv_place_photo_file'  =>$value_photo['file'],
			                           		        	  'impv_place_photo_label' =>$value_photo['name'],
			                           		        	  'impv_place_photo_size'  =>$_FILES['img']['size'][$i],
			                           		        	  );

		                           	$this->common_model->insert('impv_place_info_photo',$insert_photo);

		                           }
	                         $i++;
                           }// close loop foreach ($id_photo as $key_photo => $value_photo)

                     }

					/////////////////////////////////////////////////////////

					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('adaptenvir/ac_assist3/Edit/'.$impv_place_id,'refresh');

				}else {
					// $data['impv_home_info'] = $_POST['impv_home_info'];
					// $data['impv_home_info'] = get_inpost_arr('impv_home_info');
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'adaptenvir');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else {
				page500();
				$this->template->load('index_page',$data,'adaptenvir');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

}
