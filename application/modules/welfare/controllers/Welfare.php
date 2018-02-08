<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welfare extends MX_Controller {

	function __construct() {
		parent::__construct();

		chkUserLogin();

	}
	function __deconstruct() {
		$this->db->close();
	}

  public function getHistory($process_action='View') {
    $data = array(); //Set Initial Variable to Views
    /*-- Initial Data for Check User Permission --*/
    $user_id = get_session('user_id');
    $app_id = 12;
    $process_path = 'welfare/getHistory';
    /*--END Inizial Data for Check User Permission--*/

    $pers_id = get_inpost('pers_id');

    $this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
    $usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

    if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
      echo json_encode(array('code'=>'-1','message'=>'Permission Invalid!'));
      $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
    }else {
        $rows = $this->common_model->custom_query("select * from `adm_info` as A inner join pers_info as B on A.pers_id=B.pers_id where A.pers_id={$pers_id} AND A.date_of_req!='' AND (A.delete_datetime IS NULL AND B.delete_datetime IS NULL)");
        $rs = array();
        if(count($rows)>0) {
          $rs['history'] = 'มีประวัติ';
        }else {
          $rs['history'] = 'ไม่มีประวัติ';
        }

        $rows = $this->common_model->custom_query("select * from `adm_info` as A inner join pers_info as B on A.pers_id=B.pers_id where A.pers_id={$pers_id} AND YEAR(A.date_of_req)=YEAR(CURRENT_TIMESTAMP) AND (A.delete_datetime IS NULL AND B.delete_datetime IS NULL)");
        if(count($rows)>0) {
          $rs['year_now_history'] = count($rows);
        }else {
          $rs['year_now_history'] = '-';
        }

        $row = rowArray($rows);
        $rs['req_org'] = $row['req_org'];

        $rs['code'] = '0';
        $rs['message'] = '';
        echo json_encode($rs);

      $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
    }
  }

  public function getReqHistory($process_action='View') {
    $data = array(); //Set Initial Variable to Views
    /*-- Initial Data for Check User Permission --*/
    $user_id = get_session('user_id');
    $app_id = 12;
    $process_path = 'welfare/getReqHistory';
    /*--END Inizial Data for Check User Permission--*/

    //$pid = str_replace("-","",get_inpost('OfficerPID'));
    //$req_pers_id = get_inpost('req_pers_id');
    $user_id = get_inpost('user_id');

    $this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
    $usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

    if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
      echo json_encode(array());
      $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
    }else {
        $rows = $this->common_model->custom_query("select * from `adm_info` as A inner join pers_info as B on A.pers_id=B.pers_id left join std_prename as C on B.pren_code=C.pren_code left join usrm_org as D on A.insert_org_id=D.org_id where A.insert_user_id={$user_id} AND (A.delete_datetime IS NULL AND B.delete_datetime IS NULL) order by A.insert_datetime DESC");
        $rs = array();
        $num = 1;
        foreach($rows as $row) {
          $org_name = $row['org_short_title']==''?$row['org_title']:$row['org_short_title'];
          $date_of_adm = $row['date_of_adm']!=''?formatDateThai($row['date_of_adm']):'';
          $date_of_dis = $row['date_of_dis']!=''?formatDateThai($row['date_of_dis']):'';
          $rs[] = array("num"=>$num++,'name'=>$row['prename_th'].$row['pers_firstname_th'].' '.$row['pers_lastname_th'],"date_of_adm"=>$date_of_adm,"req_org"=>$org_name,"date_of_dis"=>$date_of_dis);
        }

        echo json_encode($rs);
      $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
    }
  }

	public function getChart(){
		$allYear = $this->common_model->custom_query("SELECT DISTINCT YEAR(date_of_req) AS all_year FROM adm_info WHERE delete_user_id is NULL");
		foreach ($allYear as $key => $row) {

			$tmpReq = rowArray($this->common_model->custom_query("SELECT COUNT(date_of_req) AS count_req FROM adm_info WHERE delete_user_id IS NULL  AND YEAR(date_of_req) = {$row['all_year']}"));
			$tmpDis = rowArray($this->common_model->custom_query("SELECT COUNT(date_of_dis) AS count_dis FROM adm_info WHERE delete_user_id IS NULL AND date_of_dis != '0000-00-00' AND YEAR(date_of_req) = {$row['all_year']}"));

			$chartData[$key]['yyyy'] = $row['all_year'];
			$chartData[$key]['count_req'] = $tmpReq['count_req'];
			$chartData[$key]['count_dis'] = $tmpDis['count_dis'];
		}
		dieArray($chartData);
	}

	public function welfare_list_ajax($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		//ini_set('max_execution_time', 300);
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 12;
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

			$this->load->model('welfare_list_model','welfare');
			$list = $this->welfare->get_datatables();
			$data = array();
			$no = $_POST['start'];
                // dieArray($list);
            // echo "5555";
			foreach ($list as $i=>$welfare) {

        $no++;
        $row = array();

          $pers_info = $this->personal_model->getOnce_PersonalInfo($welfare->pers_id);


          // dieArray($pers_info);
          $row[] = "<center>".$no."</center>";

          $row[] = $pers_info['pid'];
          $row[] = $pers_info['prename_th'].$pers_info['name'];
          $row[] = "เพศ";

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


          $date_of_req = '-';
          if($welfare->date_of_req!='') {
              $date_of_req = '<font class="text-sucsess" color="#18bd15">'.dateChange($welfare->date_of_req,5).'</font>';
          }
          $row[] = "<center>".$date_of_req."</center>";

          $date_of_adm = '';
          if(($welfare->date_of_adm!='')&& ($welfare->date_of_adm!='0000-00-00')) {

                  $date = new DateTime($welfare->date_of_adm);
                        if($welfare->date_of_dis!='' && $welfare->date_of_dis != '0000-00-00'){
                          $now = new DateTime($welfare->date_of_dis);
                        }else{
                          $now = new DateTime();
                        }
                        $interval = $now->diff($date);
                        $days = $interval->days;

              $date_of_adm = '<font class="text-sucsess" color="#18bd15">'.dateChange($welfare->date_of_adm,5).'</font>';
          }

          $row[] = "<center>".$date_of_adm."</center>";
          $row[] ='<center><font class="text-sucsess" color="#18bd15">'.dateChange($welfare->date_of_dis,5).'</font></center>';

          $tmp_irp = rowArray($this->welfare_model->getAll_admIrp($welfare->pers_id));
          // dieArray($tmp_irp);
          if($tmp_irp['date_of_irp']!='' && $tmp_irp['date_of_irp'] != '0000-00-00'){
             $date_irp = '<font class="text-sucsess" color="#18bd15">'.dateChange($tmp_irp['date_of_irp'],5).'</font>';
          }else{
             $date_irp = '';
          }


            $row[] = "<center>".$date_irp."</center>";
						$adm_irp = rowArray($this->welfare_model->getAll_admIrp($welfare->pers_id));
						$irp_result = $this->welfare_model->get_Percentage($adm_irp['irp_id']);
						$ans_rate = $irp_result['ans_rate'];
						$scroe = round($irp_result['ans_percent'],2);
						//$scroe = 0;
						if($scroe <= 30){
								$style_scroe = "background-color: #F44336 !important;";
						}else if($scroe <= 60){
								$style_scroe = "background-color: #ffc107 !important;";
						}else{
								$style_scroe = "background-color: #4caf50 !important;";
						}
						if($adm_irp['irp_id'] != ''){
							$row[] = '<div style="float: left;margin-right:3px;" >'.$ans_rate.'</div><div class="progress" style="background-color: rgba(96, 125, 139, 0.34);margin-bottom: 0px !important;">
													<div class="progress-bar" role="progressbar" aria-valuenow="'.$scroe.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$scroe.'%; '.$style_scroe.' ">
														'.$scroe.'%
													</div>
												</div>';
						}else{
							$row[] = '';
						}
					 	//$row[] = "<center>".$date_irp."</center>";
           	//$row[] = '2';
           $btn = '';



                $tmp = $this->admin_model->getOnce_Application(3);
                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                $btn = '';
                $btn =$btn.'<!-- Single button -->
                <div class="btn-group" style="cursor: pointer;">
                  <i  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle fa fa-gear" aria-hidden="true" style="color: #000"></i>

                  <ul class="dropdown-menu" style="position: absolute;left: -190px;">';

                  $btn = $btn.' <li><a style="font-size:16px;" data-toggle="modal" data-target="#prt'.$welfare->adm_id.'" title="พิมพ์แบบฟอร์ม" >
                       <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #000"></i> พิมพ์แบบฟอร์ม (.PDF)
                   </a></li>';


                  $btn =$btn.'<li><a  style="font-size:16px;"';

                  if(!isset($tmp1['perm_status'])){ $btn =$btn.'class="disabled"';}else{ $btn =$btn.'href="'.site_url("welfare/inform1/Edit/".$welfare->adm_id); }
                  $btn =$btn.'"><i class="fa fa-pencil" aria-hidden="true" style="color: #000"></i> แก้ไขรายการ</a></li>';




                    $tmp = $this->admin_model->chkOnce_usrmPermiss(3,$user_id); //Check User Permission
                    if(isset($tmp['perm_status'])) {
                        if($tmp['perm_status']=='Yes') {
                         $btn = $btn.'<li><a style="font-size:16px;" data-id='.$welfare->adm_id.' onclick="opn(this)" title="ลบ" >
                             <i class="fa fa-trash" style="color: #000"></i> ลบรายการ
                          </a></li>';
                      }
                    }

                  $btn = $btn.'</ul>
                              </div>';

                  $btn = $btn.'<!-- Print Modal -->
                        <div class="modal fade" id="prt'.$welfare->adm.'" role="dialog">
                          <div class="modal-dialog">

                             <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header text-left">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h4 class="modal-title" style="color: #333; font-size: 16px;">พิมพ์แบบฟอร์ม</h4>
                               </div>
                              <div class="modal-body">
                                <div class="row">';

                                  $tmp = $this->admin_model->getOnce_Application(17);
                                  $tmp1 = $this->admin_model->chkOnce_usrmPermiss(17,get_session('user_id')); //Check User Permission
                                $btn = $btn.'
                                  <div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;"
                                  ';
                                  if(!isset($tmp1['perm_status'])) {
                                      $btn = $btn.' class="disabled "';
                                    }else if($usrpm['app_id']==17) {
                                      $btn = $btn.' class="active" ';
                                    }
                                  $btn = $btn.'>
                                    <a style="color: #333; font-size: 16px;" target="_blank" href="'.site_url('report/B1/pdf?id='.$welfare->adm_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                                        if(isset($tmp1['perm_status'])) {
                                          $btn = $btn.$tmp1['app_name'];
                                        }
                                  $btn = $btn.'
                                    </a>
                                  </div>';

                                  $tmp = $this->admin_model->getOnce_Application(18);
                                  $tmp1 = $this->admin_model->chkOnce_usrmPermiss(18,get_session('user_id')); //Check User Permission
                                  $btn = $btn.'
                                  <div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;" ';
                                  if(!isset($tmp1['perm_status'])) {
                                      $btn = $btn.' class="disabled" ';
                                    }else if($usrpm['app_id']==18) {
                                      $btn = $btn.' class="active" ';
                                    }
                                  $btn = $btn.'
                                  >
                                    <a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/B2/pdf?id='.@$welfare->adm_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
                                        if(isset($tmp1['perm_status'])) {
                                        $btn = $btn.$tmp1['app_name'];
                                         }
                                  $btn = $btn.'
                                    </a>
                                  </div>';

                                  $tmp = $this->admin_model->getOnce_Application(19);
                                  $tmp1 = $this->admin_model->chkOnce_usrmPermiss(19,get_session('user_id')); //Check User Permission
                                  $btn = $btn.'<div class="col-xs-12 col-sm-12 text-left" style="margin-bottom: 10px;"';
                                  if(!isset($tmp1['perm_status'])) {
                                      $btn = $btn.' class="disabled" ';
                                    }else if($usrpm['app_id']==19) {
                                      $btn = $btn.' class="active" ';
                                    }
                                  $btn = $btn.'
                                   >
                                    <a style="color: #333; font-size: 16px; margin-bottom: 50px;" target="_blank" href="'.site_url('report/B3/pdf?id='.@$welfare->adm_id).'"><i class="fa fa-print" aria-hidden="true"></i> ';
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




                $row[] = "<center>".$btn."</center>";

                $row[] = "&nbsp;";

                $data[] = $row;
            }

              // dieArray($row);
             // dieArray($data);


			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->welfare->count_all(),
			 				"recordsFiltered" => $this->welfare->count_filtered(),
							"data" => $data,
			);
			//output to json format
			 echo json_encode($output);
			 $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	public function welfare_list($process_action='View') { // รายการสงเคราะห์ผู้สูงอายุในภาวะยากลำบาก
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 12;
		$process_path = 'welfare/welfare_list';
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

			$data['welfare_info'] = $this->welfare_model->getAll_admInfo();

			// dieArray($data);
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

			/*-- datepicker custom --*/
			set_css_asset_head('../plugins/bootstrap-datepicker-custom/dist/css/bootstrap-datepicker.css');
			set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/js/bootstrap-datepicker-custom.js');
			set_js_asset_head('../plugins/bootstrap-datepicker-custom/dist/locales/bootstrap-datepicker.th.min.js');
			/*-- End datepicker custom--*/

  		/*-- Toastr style --*/
  		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
  		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
  		/*-- End Toastr style --*/
        set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/ionRangeSlider/ion.rangeSlider.min.js'); //Set JS Index.js

			set_js_asset_footer('welfare_list_ajax.js','welfare'); //Set JS Index.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'welfare_list_ajax';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page',$data,'welfare');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}

	}

	private function clr_admInfo_form1() {
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
 					'req_tel_no_mobile' => '',
					// 'req_tel_no_home' => '',
					// 'req_fax_no' => '',
					// 'req_email_addr' => '',
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
					'tel_no_mobile' => '',
					// 'fax_no' => '',
					// 'email_addr' => '',

					'reg_addr_id' => '',
					'pre_addr_id' => ''
		);
	}

	/*public function inform1($process_action='Add',$adm_id=0) { //แบบขอรับบริการ (แจ้งเรื่อง)
		$data = array(); //Set Initial Variable to Views
		 Initial Data for Check User Permission
		$user_id = get_session('user_id');
		$app_id = 13;
		$process_path = 'welfare/inform1';
		/*--END Inizial Data for Check User Permission

		$this->webinfo_model->LogSave($app_id,$process_action,'Sign In','Success'); //Save Sign In Log
		$usrpm = $this->admin_model->chkOnce_usrmPermiss($app_id,$user_id); //Check User Permission

		if(@$usrpm['perm_status']=='No' || !isset($usrpm['app_id'])){
			page500();
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		}else {
			$app_name = $usrpm['app_name'];
			$data['usrpm'] = $usrpm;
			$data['user_id'] = $user_id;

			// $data['adm_info'] = $this->difficult_model->getAll_diffInfo();

			$this->load->library('template',
				array('name'=>'admin_template1',
					  'setting'=>array('data_output'=>''))
			); // Set Template

			/*-- datepicker --
			set_css_asset_head('../plugins/bootstrap-datepicker1.3.0/css/datepicker.css');
			set_js_asset_head('../plugins/bootstrap-datepicker1.3.0/js/bootstrap-datepicker.js');
			/*-- End datepicker --*/

	  		/*-- Toastr style --
	  		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/toastr/toastr.min.css');
	  		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/toastr/toastr.min.js');
	  		/*-- End Toastr style --*/

	  		/*-- select2 style --
	  		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/select2/select2.min.css');
	  		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/select2/select2.full.min.js');
	  		/*-- End select2 style --
	  		set_js_asset_footer('webservice.js','personals'); //Set JS sufferer_form1.js

			set_js_asset_footer('inform1.js','welfare'); //Set JS

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
				// $data['adm_info']  = $this->clr_admInfo_form1();

				$data['adm_info']		= $this->clr_admInfo_form1();
				$data['pers_addr'] = array();
				$data['pers_info'] = array();

				$this->template->load('index_page',$data,'welfare');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
				// dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('adm_info[date_of_req]','วันที่แจ้งเรื่อง','required|callback_date_check');
				$frm->set_rules('adm_info[req_pers_id]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
				$frm->set_rules('adm_info[pers_id]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

				//if(get_inpost('rd_pers_id')==1) {
				//	$frm->set_rules('adm_info[pers_id]','เลขประจำตัวประชาชน','required');
				//}

				//$frm->set_rules('adm_info[elder_firstname]','ชื่อตัว','required');
				//$frm->set_rules('adm_info[elder_lastname]','ชื่อสกุล','required');

				//if(get_inpost('rd_req_pers_id')==1) {
				//	$frm->set_rules('adm_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
				//}

				//$frm->set_rules('adm_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
				//$frm->set_rules('adm_info[req_channel]','ช่องทางการรับแจ้ง','required');

				//$frm->set_rules('adm_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				//$frm->set_rules('adm_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data
					//dieArray($_POST);
					$data_insert = array();
					$data_insert = get_inpost_arr('adm_info');
					$data_insert['date_of_req'] 		= dateChange($data_insert['date_of_req'],4);
					$data_insert['insert_user_id'] 	= getUser();
					$data_insert['insert_org_id'] 	= get_session('org_id');
					$data_insert['insert_datetime'] = getDatetime();
					unset($data_insert['req_pid']);

					////////////////////////////////////////////////////////////////////
					unset($data_insert['req_tel_no_home']);
					unset($data_insert['req_tel_no_mobile']);
					unset($data_insert['req_fax_no']);
					unset($data_insert['req_email_addr']);
					////////////////////////////////////////////////////////////////////

					// dieArray($data_insert);
					$id = $this->common_model->insert('adm_info',$data_insert);

					$tmp_dis = get_inpost_arr('pers_disability[dis_code]');
					if(!empty($tmp_dis)){
						$this->common_model->delete_where('pers_disability','pers_id',get_inpost('adm_info[pers_id]'));
						foreach ($tmp_dis as $row) {
							$dis_insert = array(
								'pers_id'			=> get_inpost('adm_info[pers_id]'),
								'dis_code'		    => $row,
								'dis_remark'	    => get_inpost("pers_disability[dis_remark][{$row}]"),
							);
							$this->common_model->insert('pers_disability',$dis_insert);
						}
					}

					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011

					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

					redirect('welfare/inform1/Edit/'.$id,'refresh');

				}else {
					$data['adm_info'] = get_inpost_arr('adm_info');
					$data['elder_addr_chk'] = set_value('elder_addr_chk');

					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

					$this->template->load('index_page',$data,'welfare');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = $this->welfare_model->getOnce_admInfo($adm_id);
				// dieArray($row);
				if(isset($row['adm_id'])) {
					$tmp_req_pers = $this->personal_model->getPersonalInfo($row['req_pers_id']);
					$data['pers_disability'] = $this->welfare_model->getAll_Disability($row['pers_id']);
					$data['addr_info'] = $this->personal_model->getOnce_PersonalAddress($row['pre_addr_id']);
					$data['adm_info'] = $row;
					// dieArray($tmp_req_pers);

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['adm_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['adm_info']['date_of_req'] = date("d-m-Y");
					}
					$data['adm_info']['req_pid'] 						= $tmp_req_pers['pid'];
					$data['adm_info']['req_name'] 					= $tmp_req_pers['name'];
					$data['adm_info']['req_date_of_birth'] 	= $tmp_req_pers['date_of_birth'];
					$data['adm_info']['req_gender_name'] 		= $tmp_req_pers['gender_name'];
					$data['adm_info']['req_nation_name_th'] = $tmp_req_pers['nation_name_th'];
					$data['adm_info']['req_relg_title'] 		= $tmp_req_pers['relg_title'];

					$data['adm_info']['req_tel_no_home'] 		= "";
					$data['adm_info']['req_tel_no_mobile'] 	= "";
					$data['adm_info']['req_fax_no'] 				= "";
					$data['adm_info']['req_email_addr'] 		= "";

					$tmp_pers = $this->personal_model->getPersonalInfo($row['pers_id']);
					$data['adm_info']['pid'] 						= $tmp_pers['pid'];
					$data['adm_info']['name'] 					= $tmp_pers['name'];
					$data['adm_info']['date_of_birth'] 	= $tmp_pers['date_of_birth'];
					$data['adm_info']['gender_name'] 		= $tmp_pers['gender_name'];
					$data['adm_info']['nation_name_th'] = $tmp_pers['nation_name_th'];
					$data['adm_info']['relg_title'] 		= $tmp_pers['relg_title'];

					$data['adm_info']['tel_no_home'] 		= "";
					$data['adm_info']['tel_no_mobile'] 	= "";
					$data['adm_info']['fax_no'] 				= "";
					$data['adm_info']['email_addr'] 		= "";

					$data['adm_info']['reg_addr_id'] 		= $tmp_pers['reg_addr_id'];
					$data['adm_info']['pre_addr_id'] 		= $tmp_pers['pre_addr_id'];

					if($row['pers_id'] == $row['req_pers_id']){
						$data['elder_pers_chk'] = 'on';
					}
					// dieArray($tmp_pers);
					$this->template->load('index_page',$data,'welfare');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('adm_info[date_of_req]','วันที่แจ้งเรื่อง','callback_date_check');
				$frm->set_rules('adm_info[req_pid]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
				$frm->set_rules('adm_info[pid]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

				//if(get_inpost('rd_pers_id')==1) {
				//	$frm->set_rules('adm_info[pers_id]','เลขประจำตัวประชาชน','required');
				//}

				//$frm->set_rules('adm_info[elder_firstname]','ชื่อตัว','required');
				//$frm->set_rules('adm_info[elder_lastname]','ชื่อสกุล','required');

				//if(get_inpost('rd_req_pers_id')==1) {
				//	$frm->set_rules('adm_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
				//}

				//$frm->set_rules('adm_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
				//$frm->set_rules('adm_info[req_channel]','ช่องทางการรับแจ้ง','required');

				//$frm->set_rules('adm_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				//$frm->set_rules('adm_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data
					 //dieArray($_POST);
					$data_update = array();
					$data_update = get_inpost_arr('adm_info');
					$data_update['date_of_req'] 		= dateChange($data_update['date_of_req'],4);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();

					unset($data_update['req_pid']);
					unset($data_update['pid']);

					////////////////////////////////////////////////////////////////////
					unset($data_update['req_tel_no_home']);
					unset($data_update['req_tel_no_mobile']);
					unset($data_update['req_fax_no']);
					unset($data_update['req_email_addr']);
					////////////////////////////////////////////////////////////////////

					// dieArray($data_update);
					$this->common_model->update('adm_info',$data_update,array('adm_id'=>$adm_id));

					$tmp_dis = @get_inpost_arr('pers_disability[dis_code]');

					if(!empty($tmp_dis)){
						$this->common_model->delete_where('pers_disability','pers_id',get_inpost('adm_info[pers_id]'));
						foreach ($tmp_dis as $row) {
							$dis_insert = array(
								'pers_id'			=> get_inpost('adm_info[pers_id]'),
								'dis_code'		=> $row,
								'dis_remark'	=> get_inpost("pers_disability[dis_remark][{$row}]"),
							);
							$this->common_model->insert('pers_disability',$dis_insert);
						}
					}

					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('welfare/inform1/Edit/'.$adm_id,'refresh');
				}else {
					// set value ////////////////////////////////////////////
					$data['adm_info'] 			= get_inpost_arr('adm_info');
					$data['elder_pers_chk'] = set_value('elder_pers_chk');
					/////////////////////////////////////////////////////////
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'welfare');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['delete_org_id']	= get_session('org_id');
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('adm_info',$data_update,array('adm_id'=>$adm_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('welfare/welfare_list','refresh');
			}else {
				page500();
				$this->template->load('index_page',$data,'welfare');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}
		}
	}*/

		public function inform1($process_action='Add',$adm_id=0) { //แบบขอรับบริการ (แจ้งเรื่อง)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 13;
		$process_path = 'welfare/inform1';
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

			$data['adm_info'] = $this->welfare_model->getAll_admInfo();

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
			set_js_asset_footer('inform1.js','welfare'); //Set JS sufferer_form1.js

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
				$data['adm_info'] = $this->clr_admInfo_form1();

				$data['pers_addr'] = array();
				$data['pers_info'] = array();

				$this->template->load('index_page',$data,'welfare');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
                 // dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('adm_info[date_of_req]','วันที่แจ้งเรื่อง','required|callback_date_check');
				$frm->set_rules('adm_info[req_pers_id]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
				$frm->set_rules('adm_info[pers_id]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

				//if(get_inpost('rd_pers_id')==1) {
				//	$frm->set_rules('adm_info[pers_id]','เลขประจำตัวประชาชน','required');
				//}

				//$frm->set_rules('adm_info[elder_firstname]','ชื่อตัว','required');
				//$frm->set_rules('adm_info[elder_lastname]','ชื่อสกุล','required');

				//if(get_inpost('rd_req_pers_id')==1) {
				//	$frm->set_rules('adm_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
				//}

				//$frm->set_rules('adm_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
				//$frm->set_rules('adm_info[req_channel]','ช่องทางการรับแจ้ง','required');

				//$frm->set_rules('adm_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				//$frm->set_rules('adm_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data
					// dieArray(get_inpost_arr("pers_family[pers_id]"));
					$data_insert 	  = array();
					$data_insert 	  = get_inpost_arr('adm_info');
					$data_update_pers = get_inpost_arr('pers_info');



					$data_insert['date_of_req']     = dateChange($data_insert['date_of_req']);
					$data_insert['insert_user_id'] 	= getUser();
					$data_insert['insert_org_id'] 	= get_session('org_id');
					$data_insert['insert_datetime'] = getDatetime();

					// $update_req_pers['tel_no_home'] 	= $data_insert['req_tel_no_home'];

					$update_req_pers['tel_no'] = $data_insert['req_tel_no_mobile'];
					// $update_req_pers['fax_no'] 				= $data_insert['req_fax_no'];
					// $update_req_pers['email_addr'] 		= $data_insert['req_email_addr'];
					$update_req_pers['update_user_id'] 	= getUser();
					$update_req_pers['update_org_id'] 	= get_session('org_id');
					$update_req_pers['update_datetime'] = getDatetime();

                    // dieArray($update_req_pers);
					$this->common_model->update("pers_info",$update_req_pers,array('pers_id'=>$data_insert['req_pers_id']));

					unset($data_insert['req_pid']);
					unset($data_insert['req_tel_no_home']);
					unset($data_insert['req_tel_no_mobile']);
					unset($data_insert['req_fax_no']);
					unset($data_insert['req_email_addr']);

					unset($data_insert['pid']);

                    // dieArray($data_insert);
					$id = $this->common_model->insert('adm_info',$data_insert);

					$tmp_dis = get_inpost_arr('pers_disability[dis_code]');
					if(!empty($tmp_dis)){
						$this->common_model->delete_where('pers_disability','pers_id',get_inpost('adm_info[pers_id]'));
						foreach ($tmp_dis as $row) {
							$dis_insert = array(
								'pers_id'			=> get_inpost('adm_info[pers_id]'),
								'dis_code'		    => $row,
								'dis_remark'	    => get_inpost("pers_disability[dis_remark][{$row}]"),
							);
							$this->common_model->insert('pers_disability',$dis_insert);
						}
					}

					if(get_inpost('elder_addr_chk')!='on') {
						//add new addr
						$data_insert_addr = get_inpost_arr('pers_addr');
						$data_insert_addr['insert_user_id']		= getUser();
						$data_insert_addr['insert_datetime']	= getDatetime();

						$new_addr_id = $this->common_model->insert('pers_addr',$data_insert_addr);
						$data_update_pers['pre_addr_id'] = $new_addr_id;
						$data_update_pers['tel_no'] = $data_update_pers['tel_no_mobile'];
					}else{
						$data_update_pers['pre_addr_id'] = $data_update_pers['reg_addr_id'];
					}



					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

                    $data_update_pers['tel_no'] =  $data_update_pers['tel_no_mobile'];
                    unset($data_update_pers['tel_no_mobile']);

                    // dieArray($data_update_pers);
					$this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('adm_info[pers_id]')));

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

					$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('welfare/inform1/Edit/'.$id,'refresh');

				}else {
					$data['adm_info']		= get_inpost_arr('adm_info');
					$data['adm_info']['adm_id'] = $adm_id;
					$data['elder_addr_chk'] = set_value('elder_addr_chk');

					$data['pers_addr']		= get_inpost_arr('pers_addr');
					$data['pers_info']		= get_inpost_arr('pers_info');

					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

					$this->template->load('index_page',$data,'welfare');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = $this->welfare_model->getOnce_admInfo($adm_id);
				$data['pers_disability'] = $this->welfare_model->getAll_Disability($row['pers_id']);
				// dieArray($row);
				if(isset($row['adm_id'])) {
					$data['adm_info'] = $row;
					$data['addr_info'] = $this->personal_model->getOnce_PersonalAddress($row['pre_addr_id']);
					// dieArray($data['addr_info']);
					$data['adm_info']['name'] = $row['name'];
		            if($row['date_of_birth']!='') {
		              $date = new DateTime($row['date_of_birth']);
		              $now = new DateTime();
		              $interval = $now->diff($date);
		              $age = $interval->y;
		              $data['adm_info']['date_of_birth'] = formatDateThai($row['date_of_birth']).' (อายุ '.$age.' ปี)';
		            }else {
		            	$data['adm_info']['date_of_birth'] = ' - ';
		            }
					$data['adm_info']['gender_name'] = $row['gender_name']==''?' - ':$row['gender_name'];
					$data['adm_info']['nation_name_th'] = $row['nation_name_th']==''?' - ':$row['nation_name_th'];
					$data['adm_info']['relg_title'] = $row['relg_title']==''?' - ':$row['relg_title'];
					$tmp2 = $this->personal_model->getOnce_PersonalAddress($row['reg_addr_id']);
					$data['adm_info']['reg_add_info'] = @"{$tmp2['addr_home_no']} หมู่ {$tmp2['addr_moo']} ต. {$tmp2['addr_sub_district']} อ. {$tmp2['addr_district']} จ. {$tmp2['addr_province']} {$tmp2['addr_zipcode']}";

					if($row['date_of_req']!='') {
						$tmp = explode('-',$row['date_of_req']);
						$data['adm_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}
					//dieArray($data['adm_info']);

						$data['adm_info']['req_pid'] = '';
						$data['adm_info']['req_name'] = ' - ';
						$data['adm_info']['req_date_of_birth'] = ' - ';
						$data['adm_info']['req_gender_name'] = ' - ';
						$data['adm_info']['req_nation_name_th'] = ' - ';
						$data['adm_info']['req_relg_title'] = ' - ';
						$data['adm_info']['req_pers_id'] = '';
						// $data['adm_info']['req_tel_no_home'] = '';
						// $data['adm_info']['req_tel_no_mobile'] = '';
						// $data['adm_info']['req_fax_no'] = '';
						// $data['adm_info']['req_email_addr'] = '';

                        $data['adm_info']['tel_no_mobile'] = $row['tel_no'];
					$row['req_pers_id'] = $row['req_pers_id']==''?0:$row['req_pers_id'];
					$tmp = $this->personal_model->getOnce_PersonalInfo($row['req_pers_id']);
					  // dieArray($tmp);
					if(isset($tmp['pid'])) {
						$data['adm_info']['req_pid'] = $tmp['pid'];
						$data['adm_info']['req_name'] = $tmp['name'];
			            if($tmp['date_of_birth']!='') {
			              $date = new DateTime($tmp['date_of_birth']);
			              $now = new DateTime();
			              $interval = $now->diff($date);
			              $age = $interval->y;
			              $data['adm_info']['req_date_of_birth'] = formatDateThai($tmp['date_of_birth']).' (อายุ '.$age.' ปี)';
			            }else {
			            	$data['adm_info']['req_date_of_birth'] = ' - ';
			            }
						$data['adm_info']['req_gender_name'] = $tmp['gender_name']==''?' - ':$tmp['gender_name'];
						$data['adm_info']['req_nation_name_th'] = $tmp['nation_name_th']==''?' - ':$tmp['nation_name_th'];
						$data['adm_info']['relg_title'] = $tmp['relg_title']==''?' - ':$tmp['relg_title'];
						$data['adm_info']['req_pers_id'] = $tmp['pers_id'];
						// $data['adm_info']['req_tel_no_home'] = $tmp['tel_no_home'];
						$data['adm_info']['req_tel_no_mobile'] = $tmp['tel_no'];
						// $data['adm_info']['req_fax_no'] = $tmp['fax_no'];
						// $data['adm_info']['req_email_addr'] = $tmp['email_addr'];
						$tmp1 = $this->personal_model->getOnce_PersonalAddress($tmp['reg_addr_id']);
						$data['adm_info']['req_reg_add_info'] = @"{$tmp1['addr_home_no']} หมู่ {$tmp1['addr_moo']} ต. {$tmp1['addr_sub_district']} อ. {$tmp1['addr_district']} จ. {$tmp1['addr_province']} {$tmp1['addr_zipcode']}";

					}

					$tmp_family = $this->common_model->custom_query("SELECT * FROM pers_family WHERE pers_id = {$row['pers_id']}");
					// dieArray($tmp_family);
					foreach ($tmp_family as $key => $value) {
						$data['pers_family'][] = array_merge($value,$this->personal_model->getPersonalInfo($value['ref_pers_id']));
					}

					   // dieArray($data);
					$this->template->load('index_page',$data,'welfare');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				//$process_action='Edited';
				 // dieArray($_POST);
				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('adm_info[date_of_req]','วันที่แจ้งเรื่อง','callback_date_check');
				$frm->set_rules('adm_info[req_pid]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
				$frm->set_rules('adm_info[pid]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

				//if(get_inpost('rd_pers_id')==1) {
				//	$frm->set_rules('adm_info[pers_id]','เลขประจำตัวประชาชน','required');
				//}

				//$frm->set_rules('adm_info[elder_firstname]','ชื่อตัว','required');
				//$frm->set_rules('adm_info[elder_lastname]','ชื่อสกุล','required');

				//if(get_inpost('rd_req_pers_id')==1) {
				//	$frm->set_rules('adm_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
				//}

				//$frm->set_rules('adm_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
				//$frm->set_rules('adm_info[req_channel]','ช่องทางการรับแจ้ง','required');

				//$frm->set_rules('adm_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
				//$frm->set_rules('adm_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				if($frm->run($this)){//Valid Data

					$data_update = array();
					$data_update = get_inpost_arr('adm_info');
					$data_update_pers = get_inpost_arr('pers_info');

					$data_update['date_of_req']		= dateChange($data_update['date_of_req']);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();


					// $update_req_pers['tel_no_home'] 	= $data_update['req_tel_no_home'];
					$update_req_pers['tel_no'] = $data_update['req_tel_no_mobile'];
					// $update_req_pers['fax_no'] 				= $data_update['req_fax_no'];
					// $update_req_pers['email_addr'] 		= $data_update['req_email_addr'];
					$update_req_pers['update_user_id'] 	= getUser();
					$update_req_pers['update_org_id'] 	= get_session('org_id');
					$update_req_pers['update_datetime'] = getDatetime();

					$this->common_model->update("pers_info",$update_req_pers,array('pers_id'=>$data_update['req_pers_id']));

					unset($data_update['req_pid']);
					unset($data_update['req_tel_no_home']);
					unset($data_update['req_tel_no_mobile']);
					unset($data_update['req_fax_no']);
					unset($data_update['req_email_addr']);

					unset($data_update['pid']);
					unset($data_update['pre_addr_status']);

					$this->common_model->update('adm_info',$data_update,array('adm_id'=>$adm_id));

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

                    $data_update_pers['tel_no'] = $data_update_pers['tel_no_mobile'];
                    unset($data_update_pers['tel_no_mobile']);

					$data_update_pers['update_user_id'] 	= getUser();
					$data_update_pers['update_org_id'] 		= get_session('org_id');
					$data_update_pers['update_datetime'] 	= getDatetime();

					$this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('adm_info[pers_id]')));

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
					redirect('welfare/inform1/Edit/'.$adm_id,'refresh');
				}else {
					$data['adm_info'] 			= get_inpost_arr('adm_info');
					$data['adm_info']['adm_id'] = $adm_id;

					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'welfare');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['delete_org_id'] 	= get_session('org_id');
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('adm_info',$data_update,array('adm_id'=>$adm_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('welfare/welfare_list','refresh');
			}else {
				page500();
				// $this->template->load('index_page',$data,'difficult');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function admission2($process_action='Add',$adm_id=0) { //แบบขอรับบริการ (ตรวจเยี่ยม)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 14;
		$process_path = 'welfare/admission2';
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

			// $data['adm_info'] = $this->difficult_model->getAll_diffInfo();

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

  		/*-- jasny style --*/
  		set_css_asset_head('../plugins/Static_Full_Version/css/plugins/jasny/jasny-bootstrap.min.css');
  		set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/jasny/jasny-bootstrap.min.js');
  		/*-- End jasny style --*/

  		/*-- dropzone style --*/
  		// set_css_asset_head('../plugins/Static_Full_Version/css/plugins/dropzone/dropzone.css');
  		// set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/dropzone/dropzone.js');
  		/*-- End dropzone style --*/


			set_js_asset_footer('admission2.js','welfare'); //Set JS inform1.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'admission2';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			// dieArray($usrpm);
			if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$row = $this->welfare_model->getOnce_admInfo($adm_id);
				// dieArray($row);
				if(isset($row['adm_id'])) {
					$data['adm_info'] = $row;

					if($row['date_of_adm']!='' && $row['date_of_adm'] != '0000-00-00') {
						$tmp = explode('-',$row['date_of_adm']);
						$data['adm_info']['date_of_adm'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['adm_info']['date_of_adm'] = date("d-m-Y");
					}

					if($row['date_of_dis']!='' && $row['date_of_dis'] != '0000-00-00') {
						$tmp = explode('-',$row['date_of_dis']);
						$data['adm_info']['date_of_dis'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
					}else{
						$data['adm_info']['date_of_dis'] = '';
					}


					$this->template->load('index_page',$data,'welfare');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
				$process_action='Edited';

				$this->load->library('form_validation');
				$frm=$this->form_validation;

				$frm->set_rules('adm_info[date_of_adm]','วันที่รับเข้า','required|callback_date_check');
				$frm->set_rules('adm_info[adm_case_reason_code]','สาเหตุการรับเข้า','required');

				$frm->set_message("required","กรุณากรอกข้อมูล %s");
				$frm->set_message("numeric","%s ต้องเป็นตัวเลข");
				$frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

				// dieArray($_FILES);
				if($frm->run($this)){//Valid Data

					// adm_info
					$data_update = get_inpost_arr('adm_info');
					$data_update['date_of_adm'] 		= dateChange($data_update['date_of_adm']);
					$data_update['date_of_dis'] 		= dateChange($data_update['date_of_dis']);
					$data_update['update_user_id'] 	= getUser();
					$data_update['update_org_id'] 	= get_session('org_id');
					$data_update['update_datetime'] = getDatetime();

					// File upload //////////////////
					$fileUpload = $this->files_model->getOnceImg("belonging_att_file",'assets/modules/welfare/images');
					if($fileUpload != ''){
						$data_update['belonging_att_file']	= $fileUpload;
						$data_update['belonging_att_label'] = $_FILES['belonging_att_file']['name'];
						$data_update['belonging_att_size']	= $_FILES['belonging_att_file']['size'];
					}
					/////////////////////////////////

					// dieArray($data_update);
					$this->common_model->update('adm_info',$data_update,array('adm_id'=>$adm_id));

					$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
					redirect('welfare/admission2/Edit/'.$adm_id,'refresh');
				}else {
					$data['adm_info'] = get_inpost_arr('adm_info');
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
					$this->template->load('index_page',$data,'welfare');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}

			}else {
				page500();
				$this->template->load('index_page',$data,'welfare');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}

	}

	public function estimate3($process_action='View',$adm_id=0,$irp_id=0) { //แบบขอรับบริการ (สงเคราะห์)
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 15;
		$process_path = 'welfare/estimate3';
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

			// $data['adm_info'] = $this->difficult_model->getAll_diffInfo();

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

			set_js_asset_footer('estimate3.js','welfare'); //Set JS estimate3.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'estimate3';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$data['csrf'] = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			$data['adm_id'] = $adm_id;

			if($process_action=='View' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				/*-- Load Datatables for Theme --*/
				set_css_asset_head('../plugins/Static_Full_Version/css/plugins/dataTables/datatables.min.css');
				set_js_asset_footer('../plugins/Static_Full_Version/js/plugins/dataTables/datatables.min.js');
				/*-- End Load Datatables for Theme --*/

				$data['adm_info'] = $this->welfare_model->getOnce_admInfo($adm_id);
				if(isset($data['adm_info']['pers_id'])) {

					$data['irp_info'] = $this->welfare_model->getAll_admIrp($data['adm_info']['pers_id']);

					$this->template->load('index_page',$data,'welfare');
				}else {
					page500();
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			}else if($process_action=='Delete' ) {

             $this->common_model->delete_where('adm_irp','irp_id',$irp_id);
             $this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
             $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
             redirect('welfare/estimate3/View/'.$adm_id,'refresh');

            }else{
				page500();
				$this->template->load('index_page',$data,'welfare');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}
		}
	}

	public function inform4($process_action='Add',$adm_id=0,$irp_id = 0) { //แบบขอรับบริการ (สงเคราะห์)
	 $data = array(); //Set Initial Variable to Views
	 /*-- Initial Data for Check User Permission --*/
	 $user_id = get_session('user_id');
	 $app_id = 15;
	 $process_path = 'welfare/inform4';
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

		 set_js_asset_footer('inform4.js','welfare'); //Set JS inform4.js

		 $data['process_action'] = $process_action;
		 $data['content_view'] = 'inform4';

		 $tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
		 $data['head_title'] = $tmp['app_name'];
		 $data['title'] = $usrpm['app_name'];

		 $data['csrf'] = array(
			 'name' => $this->security->get_csrf_token_name(),
			 'hash' => $this->security->get_csrf_hash()
		 );



		if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
			$data['adm_irp'] = array(
				'date_of_irp' 	=> date('d-m-Y'),
				'irp_name' 			=> '',
				'nurse_name' 		=> '',
				'almoner_name' 	=> '',
			);
			$data['adm_info'] = $this->welfare_model->getOnce_admInfo($adm_id);

			$this->template->load('index_page',$data,'welfare');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

		}else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form

			 $this->load->library('form_validation');
			 $frm=$this->form_validation;

			 $frm->set_rules('adm_irp[date_of_irp]','วันที่ประเมิน','required|callback_date_check');

			 $frm->set_message("required","กรุณากรอกข้อมูล %s");
			 $frm->set_message("numeric","%s ต้องเป็นตัวเลข");
			 $frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

			 if($frm->run($this)){//Valid Data
			 	// dieArray($_POST);
			 	$data['adm_info'] = $this->welfare_model->getOnce_admInfo($adm_id);

			 	$data_insert = get_inpost_arr('adm_irp');
			 	$data_insert['pers_id'] 		= $data['adm_info']['pers_id'];
			 	$data_insert['date_of_irp'] = dateChange($data_insert['date_of_irp']);
			 	$data_insert['irp_org_id'] 	= get_session('org_id');
				$irp_id = $this->common_model->insert('adm_irp',$data_insert);

				// IRP แบบประเมิน
				$tmp_point_answer_id = get_inpost_arr('point_answer_id');
				$tmp_ans_answer_id = get_inpost_arr('ans_answer_id');
				$tmp_irp = get_inpost_arr('ans_answer_id');
				if(!empty($tmp_irp)){
					foreach ($tmp_irp as $q_id => $ans_id) {
						$answer =  $this->welfare_model->getAll_irpAnswer($q_id);
						$answer = sort_array_with($answer,'qstn_id');
			 			// dieArray($answer);
						$irp_insert = array(
							'irp_id' 			=> $irp_id,
							'qstn_id' 		=> $q_id,
							'ans_id' 			=> $tmp_ans_answer_id[$q_id],
							'ans_points' 	=> $tmp_point_answer_id[$q_id],
							'ans_full_score' => get_inpost("question[{$q_id}][ans_full_score]"),
						);
						$this->common_model->insert('adm_irp_result',$irp_insert);
					}
					// dieArray($irp_insert);
				}

				// Treatment
				$tmp_dim = $this->input->post('adm_trm_result',true);
				// dieArray($tmp_dim);
				if(!empty($tmp_dim)){
					foreach ($tmp_dim as $dimension => $diRow) {
						$tmp_trm = $diRow;
						foreach ($tmp_trm['prgm_id'] as $key => $row) {
							$trm_insert = array(
								'irp_id' => $irp_id,
								'qstn_id' => $dimension,
								'prgm_id' => $row,
								'treatment_within' => $tmp_trm['treatment_within'][$row],
							);
							$this->common_model->insert('adm_trm_result',$trm_insert);
						}
					}
					// dieArray($trm_insert);
				}

				$this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('welfare/estimate3/View/'.$adm_id,'refresh');
			 }else {
				 // $data['adm_info'] = $_POST['adm_info'];
				 $data['adm_irp']		= get_inpost_arr('adm_irp');
				 $this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

				 $this->template->load('index_page',$data,'welfare');
				 $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			 }

		}else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
			$data['adm_info'] = $this->welfare_model->getOnce_admInfo($adm_id);
			$data['adm_irp']	= $this->welfare_model->getOnce_admIrp($data['adm_info']['pers_id'],$irp_id);
		 	// dieArray($data);
		 if(isset($data['adm_irp']['irp_id'])) {
				if($data['adm_irp']['date_of_irp']!='') {
					 $tmp = explode('-',$data['adm_irp']['date_of_irp']);
					 $data['adm_irp']['date_of_irp'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
				}else{
					 $data['adm_irp']['date_of_irp'] = date("d-m-Y");
				}

				$data['adm_irp_result'] = $this->welfare_model->getAll_adm_irp_result($irp_id);
				$data['adm_trm_result'] = $this->welfare_model->getAll_adm_trm_result($irp_id);

				// dieArray($data);

				$this->template->load('index_page',$data,'welfare');
		  }else {
			  page500();
			  $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		  }
		}else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
			 // $process_action='Edited';
			 //dieArray($_POST);
			 $this->load->library('form_validation');
			 $frm=$this->form_validation;

			 $frm->set_rules('adm_irp[date_of_irp]','วันที่ประเมิน','required|callback_date_check');

			 $frm->set_message("required","กรุณากรอกข้อมูล %s");
			 $frm->set_message("numeric","%s ต้องเป็นตัวเลข");
			 $frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

			 if($frm->run($this)){//Valid Data
			 	$data['adm_info'] = $this->welfare_model->getOnce_admInfo($adm_id);

				$data_update = get_inpost_arr('adm_irp');
			 	$data_update['pers_id'] 		= $data['adm_info']['pers_id'];
			 	$data_update['date_of_irp'] = dateChange($data_update['date_of_irp']);
			 	$data_update['irp_org_id'] 	= get_session('org_id');

				$this->common_model->update('adm_irp',$data_update,array('irp_id'=>$irp_id));

				// IRP แบบประเมิน
				$tmp_point_answer_id = get_inpost_arr('point_answer_id');
				$tmp_ans_answer_id = get_inpost_arr('ans_answer_id');
				$tmp_irp = get_inpost_arr('ans_answer_id');
				//dieArray($tmp_irp);
				if(!empty($tmp_irp)){
					$this->common_model->delete_where('adm_irp_result','irp_id',$irp_id);
					foreach ($tmp_irp as $q_id => $ans_id) {
						$answer =  $this->welfare_model->getAll_irpAnswer($q_id);
						$answer = sort_array_with($answer,'qstn_id');
			 			// dieArray($answer);
						$irp_insert = array(
							'irp_id' 			=> $irp_id,
							'qstn_id' 		=> $q_id,
							'ans_id' 			=> $tmp_ans_answer_id[$q_id],
							'ans_points' 	=> $tmp_point_answer_id[$q_id],
							'ans_full_score' => get_inpost("question[{$q_id}][ans_full_score]"),
						);
						$this->common_model->insert('adm_irp_result',$irp_insert);
					}
					//dieArray($irp_insert);
				}

				// Treatment
				$tmp_dim = $this->input->post('adm_trm_result',true);
				// dieArray($tmp_dim);
				if(!empty($tmp_dim)){
					$this->common_model->delete_where('adm_trm_result','irp_id',$irp_id);
					foreach ($tmp_dim as $dimension => $diRow) {
						$tmp_trm = $diRow;
						foreach ($tmp_trm['prgm_id'] as $key => $row) {
							$trm_insert = array(
								'irp_id' => $irp_id,
								'qstn_id' => $dimension,
								'prgm_id' => $row,
								'treatment_within' => $tmp_trm['treatment_within'][$row],
							);
							$this->common_model->insert('adm_trm_result',$trm_insert);
						}
					}
					// dieArray($trm_insert);
				}


				$this->session->set_flashdata('msg',setMsg('021')); //Set Message code 021
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect('welfare/estimate3/View/'.$adm_id,'refresh');
			}else {

				$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
				$this->template->load('index_page',$data,'welfare');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}

		}else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process
			 $data_update = array();
			 $data_update['delete_user_id'] = getUser();
			 $data_update['delete_datetime'] = getDatetime();

			 $this->common_model->update('adm_info',$data_update,array('adm_id'=>$adm_id));
			 $this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
			 $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
			 redirect('welfare/assist_list','refresh');
		}else {
			 page500();
			 $this->template->load('index_page',$data,'welfare');
			 $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
		}

	 }
 	}

	public function pers_of_dis_status($pers_id=''){
		$adm_info = $this->common_model->custom_query("SELECT adm_info.adm_id,adm_info.pers_id, adm_info.date_of_dis, usrm_org.org_id, usrm_org.org_short_title
		FROM adm_info JOIN usrm_org ON adm_info.insert_org_id = usrm_org.org_id
		WHERE pers_id = '".$pers_id."' ORDER BY adm_info.date_of_dis ASC LIMIT 1 ");
		$row_adm_info = rowArray($adm_info);
		if(isset($row_adm_info['pers_id'])){
			if($row_adm_info['date_of_dis']=='' || $row_adm_info['date_of_dis']=='0000-00-00'){
				$dis_status = 1;
			}else{
				$dis_status = 0;
			}
		}else{
			$dis_status = 0;
		}
		$goto_page = '';
		if($row_adm_info['org_id'] == get_session('org_id')){
				$goto_page = 'welfare/inform1/Edit/'.$row_adm_info['adm_id'];
		}else{
				$goto_page = '';
		}

		$arr_data = array('goto_page'=>$goto_page,'org_name'=>$row_adm_info['org_short_title'],'dis_status' => $dis_status);
		echo json_encode($arr_data);
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

  private function webblock_form() {
    $orgs =array();
    $org = get_session('org_id');
    $orgs = $this->common_model->custom_query("SELECT * FROM usrm_org WHERE org_id = {$org}");

    return array(
            'org_id' => '',
            'org_title' => $orgs[0]['org_title'],
            'org_short_title'=> $orgs[0]['org_short_title'],
            'addr_home_no'=> '',
            'addr_moo' => '',
            'addr_alley' => '',
            'addr_lane'=> '',
            'addr_road' => '',
            'addr_sub_district'=> '',
            'addr_district' => '',
            'addr_province' => '',
            'addr_zipcode'=> '',
            'addr_gps'=> '',
            'tel_no'=> '',
            'fax_no'=> '',
            'email_addr'=> '',
            'mngr_pren_code'=> '',
            'mngr_firstname_th'=> '',
            'mngr_lastname_th'=> '',
            'mngr_position'=> '',
            'mngr_img_file'=> '',
            'mngr_img_label'=> '',
            'mngr_img_size'=> ''
    );
  }




  public function webblock_list($process_action='Add',$adm_id=0) { //แบบขอรับบริการ (แจ้งเรื่อง)
    $data = array(); //Set Initial Variable to Views
    /*-- Initial Data for Check User Permission --*/
    $user_id = get_session('user_id');
    $app_id = 157;
    $process_path = 'welfare/webblock_list';
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

      $data['adm_info'] = $this->welfare_model->getAll_admInfo();

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
      set_js_asset_footer('webblock_list.js','welfare'); //Set JS sufferer_form1.js

      $data['process_action'] = $process_action;
      $data['content_view'] = 'webblock_list';

      $tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
      $data['head_title'] = $tmp['app_name'];
      $data['title'] = $usrpm['app_name'];

      $data['csrf'] = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
      );

      if($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
        $org = get_session('org_id');
        $adm_info = $this->common_model->query("SELECT * FROM adm_blog_info WHERE org_id = {$org}")->row_array();
        $adm_info_photo = $this->common_model->query("SELECT * FROM adm_blog_photo WHERE org_id = {$org}")->result_array();
        if (!empty($adm_info)){
          $data['webblock_info'] = $adm_info;
          $data['web_info_photo'] = $adm_info_photo;
        }
        else{
          $data['webblock_info'] = $this->webblock_form();
        }
       // dieArray($data);


        // $data['pers_addr'] = array();
        // $data['pers_info'] = array();

        $this->template->load('index_page',$data,'welfare');
        $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log

      }else if($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes'){ //Add && Submit Form
      //  dieArray($_FILES);
        // upload image profile  config


        $config['upload_path'] = 'assets/modules/welfare/uploads/';
        $config['allowed_types']        = 'jpeg|jpg|png';
        $config['max_size']             = 5120;  //5MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);


        $this->load->library('form_validation');
        $frm=$this->form_validation;

       //  $frm->set_rules('webblock_info[date_of_req]','วันที่แจ้งเรื่อง','required|callback_date_check');
         $frm->set_rules('webblock_info[org_title]','ชื่อองค์กร','required');
        // $frm->set_rules('webblock_info[pers_id]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

        // //if(get_inpost('rd_pers_id')==1) {
        // //  $frm->set_rules('adm_info[pers_id]','เลขประจำตัวประชาชน','required');
        // //}

        // //$frm->set_rules('adm_info[elder_firstname]','ชื่อตัว','required');
        // //$frm->set_rules('adm_info[elder_lastname]','ชื่อสกุล','required');

        // //if(get_inpost('rd_req_pers_id')==1) {
        // //  $frm->set_rules('adm_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
        // //}

        // //$frm->set_rules('adm_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
        // //$frm->set_rules('adm_info[req_channel]','ช่องทางการรับแจ้ง','required');

        // //$frm->set_rules('adm_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
        // //$frm->set_rules('adm_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

        $frm->set_message("required","กรุณากรอกข้อมูล %s");
        $frm->set_message("numeric","%s ต้องเป็นตัวเลข");
        $frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

        if($frm->run($this)){//Valid Data
          // dieArray(get_inpost_arr("pers_family[pers_id]"));
          $data_insert    = array();
          $data_insert    = get_inpost_arr('webblock_info');

          //update
          $org = get_session('org_id');
          $adm_info = $this->common_model->query("SELECT * FROM adm_blog_info WHERE org_id = {$org}")->row_array();
        //  dieArray($adm_info);
          if (!empty($adm_info)){
                  //check  file upload
            if (!empty($_FILES['img_webblock']['name'])){
                if (!$this->upload->do_upload('img_webblock')) {
                      $error = array('error' => $this->upload->display_errors());
                      $this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

                      $this->template->load('index_page',$data,'welfare');
                      $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
                  } else {
                      $upload_data = $this->upload->data();

                      $data_insert['mngr_img_file']  = $upload_data['full_path'];
                      $data_insert['mngr_img_label']   = $upload_data['file_name'];
                      $data_insert['mngr_img_size'] = $upload_data['file_size'];
                     // dieArray($upload_data);
                       // $data_update_pers = get_inpost_arr('pers_info')
                    $data_insert['org_id'] = get_session('org_id');
                    $data_insert['update_user_id']  = getUser();
                    $data_insert['update_org_id']   = get_session('org_id');
                    $data_insert['update_datetime'] = getDatetime();
                                        // dieArray($data_insert);
                    $id = $this->common_model->update('adm_blog_info',$data_insert,array('org_id'=>$org)); // insert
                }
              }


                //รุปบรรยากาศ check data
                $temp_img = array();
                $thu_img = array();

                foreach($_FILES['blog_photo_file'] as $key => $val) //defult patent
                {
                    $i = 0;
                    foreach($val as $new_key)
                    {
                        $temp_img[$i][$key] = $new_key;
                        $i++;
                    }
                }


                $i = 0;
                foreach($temp_img as $key => $val)
                {
                    $_FILES[$i] = $val;
                    $i++;
                }
               // dieArray($_FILES);
                  unset($_FILES['img_webblock']);  // clear file
                  unset($_FILES['blog_photo_file']); // clear file

                 $adm_info_photo = $this->common_model->query("SELECT * FROM adm_blog_photo WHERE org_id = {$org}")->result_array();
              //   dieArray($_FILES );
                foreach($_FILES as $key => $value)
                {
                        if( ! empty($value['name']))
                        {

                            if($this->upload->do_upload($key))
                            {
                                $result = $this->upload->data();


                                if (!empty($adm_info_photo[$key])){
                                  $thu_img['blog_photo_file']  = $result['full_path'];
                                  $thu_img['blog_photo_label']   = $result['file_name'];
                                  $thu_img['blog_photo_size'] = $result['file_size'];
                                  $thu_img['org_id'] = get_session('org_id');
                                  $id = $this->common_model->update('adm_blog_photo',$thu_img,array('blog_photo_id'=>$adm_info_photo[$key]['blog_photo_id']));
                                }
                                else{
                                  $thu_img['blog_photo_file']  = $result['full_path'];
                                  $thu_img['blog_photo_label']   = $result['file_name'];
                                  $thu_img['blog_photo_size'] = $result['file_size'];
                                  $thu_img['org_id'] = get_session('org_id');
                                  $id = $this->common_model->insert('adm_blog_photo',$thu_img);
                                }

                            }
                            else{
                              $error = array('error' => $this->upload->display_errors());
                              dieArray($error);
                            }
                        }

                  }

          }else{

          //check  file upload
          if (!$this->upload->do_upload('img_webblock') && !empty($_FILES['img_webblock']['name'])) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

                $this->template->load('index_page',$data,'welfare');
                $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
            } else {
                $upload_data = $this->upload->data();

                $data_insert['mngr_img_file']  = $upload_data['full_path'];
                $data_insert['mngr_img_label']   = $upload_data['file_name'];
                $data_insert['mngr_img_size'] = $upload_data['file_size'];
               // dieArray($upload_data);
          }
         // $data_update_pers = get_inpost_arr('pers_info');

          $data_insert['org_id'] = get_session('org_id');
          $data_insert['insert_user_id']  = getUser();
          $data_insert['insert_org_id']   = get_session('org_id');
          $data_insert['insert_datetime'] = getDatetime();
                              // dieArray($data_insert);
          $id = $this->common_model->insert('adm_blog_info',$data_insert); // insert

                  //รุปบรรยากาศ check data
          $temp_img = array();
          $thu_img = array();
          foreach($_FILES['blog_photo_file'] as $key => $val) //defult patent
          {
              $i = 0;
              foreach($val as $new_key)
              {
                  $temp_img[$i][$key] = $new_key;
                  $i++;
              }
          }
          $i = 0;
          foreach($temp_img as $key => $val)
          {
              $_FILES['file'.$i] = $val;
              $i++;
          }
            unset($_FILES['img_webblock']);  // clear file
            unset($_FILES['blog_photo_file']); // clear file

          foreach($_FILES as $key => $value)
          {
                if( ! empty($value['name']))
                {

                    if($this->upload->do_upload($key))
                    {
                        $result = $this->upload->data();

                        $thu_img['blog_photo_file']  = $result['full_path'];
                        $thu_img['blog_photo_label']   = $result['file_name'];
                        $thu_img['blog_photo_size'] = $result['file_size'];
                        $thu_img['org_id'] = get_session('org_id');
                        $id = $this->common_model->insert('adm_blog_photo',$thu_img);
                    }
                    else{
                      $error = array('error' => $this->upload->display_errors());
                      dieArray($error);
                    }
                }

          }
        }



          /////////////////////////////////////////////////////////////////

          $this->session->set_flashdata('msg',setMsg('011')); //Set Message code 011
          $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
          redirect('welfare/webblock_list','refresh');

        }else {
          $data['adm_info']   = get_inpost_arr('adm_info');
          $data['adm_info']['adm_id'] = $adm_id;
          $data['elder_addr_chk'] = set_value('elder_addr_chk');

          $data['pers_addr']    = get_inpost_arr('pers_addr');
          $data['pers_info']    = get_inpost_arr('pers_info');

          $this->session->set_flashdata('msg',setMsg('012')); //Set Message code 012

          $this->template->load('index_page',$data,'welfare');
          $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
        }

      }else if($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
        $row = $this->welfare_model->getOnce_admInfo($adm_id);
        $data['pers_disability'] = $this->welfare_model->getAll_Disability($row['pers_id']);
        // dieArray($row);
        if(isset($row['adm_id'])) {
          $data['adm_info'] = $row;
          $data['addr_info'] = $this->personal_model->getOnce_PersonalAddress($row['pre_addr_id']);
          // dieArray($data['addr_info']);
          $data['adm_info']['name'] = $row['name'];
                if($row['date_of_birth']!='') {
                  $date = new DateTime($row['date_of_birth']);
                  $now = new DateTime();
                  $interval = $now->diff($date);
                  $age = $interval->y;
                  $data['adm_info']['date_of_birth'] = formatDateThai($row['date_of_birth']).' (อายุ '.$age.' ปี)';
                }else {
                  $data['adm_info']['date_of_birth'] = ' - ';
                }
          $data['adm_info']['gender_name'] = $row['gender_name']==''?' - ':$row['gender_name'];
          $data['adm_info']['nation_name_th'] = $row['nation_name_th']==''?' - ':$row['nation_name_th'];
          $data['adm_info']['relg_title'] = $row['relg_title']==''?' - ':$row['relg_title'];
          $tmp2 = $this->personal_model->getOnce_PersonalAddress($row['reg_addr_id']);
          $data['adm_info']['reg_add_info'] = @"{$tmp2['addr_home_no']} หมู่ {$tmp2['addr_moo']} ต. {$tmp2['addr_sub_district']} อ. {$tmp2['addr_district']} จ. {$tmp2['addr_province']} {$tmp2['addr_zipcode']}";

          if($row['date_of_req']!='') {
            $tmp = explode('-',$row['date_of_req']);
            $data['adm_info']['date_of_req'] = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
          }
          //dieArray($data['adm_info']);

            $data['adm_info']['req_pid'] = '';
            $data['adm_info']['req_name'] = ' - ';
            $data['adm_info']['req_date_of_birth'] = ' - ';
            $data['adm_info']['req_gender_name'] = ' - ';
            $data['adm_info']['req_nation_name_th'] = ' - ';
            $data['adm_info']['req_relg_title'] = ' - ';
            $data['adm_info']['req_pers_id'] = '';
            // $data['adm_info']['req_tel_no_home'] = '';
            // $data['adm_info']['req_tel_no_mobile'] = '';
            // $data['adm_info']['req_fax_no'] = '';
            // $data['adm_info']['req_email_addr'] = '';

                        $data['adm_info']['tel_no_mobile'] = $row['tel_no'];
          $row['req_pers_id'] = $row['req_pers_id']==''?0:$row['req_pers_id'];
          $tmp = $this->personal_model->getOnce_PersonalInfo($row['req_pers_id']);
            // dieArray($tmp);
          if(isset($tmp['pid'])) {
            $data['adm_info']['req_pid'] = $tmp['pid'];
            $data['adm_info']['req_name'] = $tmp['name'];
                  if($tmp['date_of_birth']!='') {
                    $date = new DateTime($tmp['date_of_birth']);
                    $now = new DateTime();
                    $interval = $now->diff($date);
                    $age = $interval->y;
                    $data['adm_info']['req_date_of_birth'] = formatDateThai($tmp['date_of_birth']).' (อายุ '.$age.' ปี)';
                  }else {
                    $data['adm_info']['req_date_of_birth'] = ' - ';
                  }
            $data['adm_info']['req_gender_name'] = $tmp['gender_name']==''?' - ':$tmp['gender_name'];
            $data['adm_info']['req_nation_name_th'] = $tmp['nation_name_th']==''?' - ':$tmp['nation_name_th'];
            $data['adm_info']['relg_title'] = $tmp['relg_title']==''?' - ':$tmp['relg_title'];
            $data['adm_info']['req_pers_id'] = $tmp['pers_id'];
            // $data['adm_info']['req_tel_no_home'] = $tmp['tel_no_home'];
            $data['adm_info']['req_tel_no_mobile'] = $tmp['tel_no'];
            // $data['adm_info']['req_fax_no'] = $tmp['fax_no'];
            // $data['adm_info']['req_email_addr'] = $tmp['email_addr'];
            $tmp1 = $this->personal_model->getOnce_PersonalAddress($tmp['reg_addr_id']);
            $data['adm_info']['req_reg_add_info'] = @"{$tmp1['addr_home_no']} หมู่ {$tmp1['addr_moo']} ต. {$tmp1['addr_sub_district']} อ. {$tmp1['addr_district']} จ. {$tmp1['addr_province']} {$tmp1['addr_zipcode']}";

          }

          $tmp_family = $this->common_model->custom_query("SELECT * FROM pers_family WHERE pers_id = {$row['pers_id']}");
          // dieArray($tmp_family);
          foreach ($tmp_family as $key => $value) {
            $data['pers_family'][] = array_merge($value,$this->personal_model->getPersonalInfo($value['ref_pers_id']));
          }

             // dieArray($data);
          $this->template->load('index_page',$data,'welfare');
        }else {
          page500();
          $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
        }

      }else if($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') { //Edit && Submit Form
        //$process_action='Edited';
         // dieArray($_POST);
        $this->load->library('form_validation');
        $frm=$this->form_validation;

        $frm->set_rules('adm_info[date_of_req]','วันที่แจ้งเรื่อง','callback_date_check');
        $frm->set_rules('adm_info[req_pid]','เลขประจำตัวประชาชน (ผู้แจ้งเรื่อง)','required');
        $frm->set_rules('adm_info[pid]','เลขประจำตัวประชาชน (ผู้สูงอายุ)','required');

        //if(get_inpost('rd_pers_id')==1) {
        //  $frm->set_rules('adm_info[pers_id]','เลขประจำตัวประชาชน','required');
        //}

        //$frm->set_rules('adm_info[elder_firstname]','ชื่อตัว','required');
        //$frm->set_rules('adm_info[elder_lastname]','ชื่อสกุล','required');

        //if(get_inpost('rd_req_pers_id')==1) {
        //  $frm->set_rules('adm_info[req_pers_id]','เลขประจำตัวประชาชนข้อมูลผู้ยื่นคำขอ','required');
        //}

        //$frm->set_rules('adm_info[req_firstname]','ชื่อสกุลผู้ยื่นคำขอ','required');
        //$frm->set_rules('adm_info[req_channel]','ช่องทางการรับแจ้ง','required');

        //$frm->set_rules('adm_info[date_of_visit]','วันที่ตรวจเยี่ยม','required|callback_date_check');
        //$frm->set_rules('adm_info[visitor_name]','เจ้าหน้าที่ผู้ตรวจเยี่ยม','required');

        $frm->set_message("required","กรุณากรอกข้อมูล %s");
        $frm->set_message("numeric","%s ต้องเป็นตัวเลข");
        $frm->set_message("date_check","%s รูปบบของวันที่ต้องถูกต้อง");

        if($frm->run($this)){//Valid Data

          $data_update = array();
          $data_update = get_inpost_arr('adm_info');
          $data_update_pers = get_inpost_arr('pers_info');

          $data_update['date_of_req']   = dateChange($data_update['date_of_req']);
          $data_update['update_user_id']  = getUser();
          $data_update['update_org_id']   = get_session('org_id');
          $data_update['update_datetime'] = getDatetime();


          // $update_req_pers['tel_no_home']  = $data_update['req_tel_no_home'];
          $update_req_pers['tel_no'] = $data_update['req_tel_no_mobile'];
          // $update_req_pers['fax_no']         = $data_update['req_fax_no'];
          // $update_req_pers['email_addr']     = $data_update['req_email_addr'];
          $update_req_pers['update_user_id']  = getUser();
          $update_req_pers['update_org_id']   = get_session('org_id');
          $update_req_pers['update_datetime'] = getDatetime();

          $this->common_model->update("pers_info",$update_req_pers,array('pers_id'=>$data_update['req_pers_id']));

          unset($data_update['req_pid']);
          unset($data_update['req_tel_no_home']);
          unset($data_update['req_tel_no_mobile']);
          unset($data_update['req_fax_no']);
          unset($data_update['req_email_addr']);

          unset($data_update['pid']);
          unset($data_update['pre_addr_status']);

          $this->common_model->update('adm_info',$data_update,array('adm_id'=>$adm_id));

          if(get_inpost('elder_addr_chk')!='on') {
            //add new addr
            $data_update_addr = get_inpost_arr('pers_addr');
            $data_update_addr['update_user_id']   = getUser();
            $data_update_addr['update_datetime']  = getDatetime();

            $this->common_model->update('pers_addr',$data_update_addr,array('addr_id'=>get_inpost('pre_addr_id')));
            // $new_addr_id = $this->common_model->insert('pers_addr',$data_insert_addr);
            // $data_update_pers['pre_addr_id'] = $new_addr_id;
          }else{
            $data_update_pers['pre_addr_id'] = $data_update_pers['reg_addr_id'];
          }

                    $data_update_pers['tel_no'] = $data_update_pers['tel_no_mobile'];
                    unset($data_update_pers['tel_no_mobile']);

          $data_update_pers['update_user_id']   = getUser();
          $data_update_pers['update_org_id']    = get_session('org_id');
          $data_update_pers['update_datetime']  = getDatetime();

          $this->common_model->update('pers_info',$data_update_pers,array('pers_id'=>get_inpost('adm_info[pers_id]')));

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
          redirect('welfare/inform1/Edit/'.$adm_id,'refresh');
        }else {
          $data['adm_info']       = get_inpost_arr('adm_info');
          $data['adm_info']['adm_id'] = $adm_id;

          $this->session->set_flashdata('msg',setMsg('022')); //Set Message code 022
          $this->template->load('index_page',$data,'welfare');
          $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
        }

      }else if($process_action=='Delete' && $usrpm['perm_status']=='Yes') { //Delete process

      $org = get_session('org_id');
        if ($adm_id != '' && $adm_id != 'img' ){
          $adm_info_photo = $this->common_model->query("SELECT * FROM adm_blog_photo WHERE org_id = {$org}")->result_array();
          //dieArray($adm_info_photo);
          $this->common_model->delete_where('adm_blog_photo','blog_photo_id',$adm_info_photo[$adm_id]['blog_photo_id']);


          $this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
          $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
          redirect('welfare/webblock_list','refresh');
        }

        $data_update = array();
        $data_update['mngr_img_file']  ='';
        $data_update['mngr_img_label']   = '';
       // $data_update['delete_datetime'] = getDatetime();

        $this->common_model->update('adm_blog_info',$data_update,array('org_id'=>get_session('org_id')));
        $this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
        $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
        redirect('welfare/webblock_list','refresh');
      }else {
        page500();
        // $this->template->load('index_page',$data,'difficult');
        $this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
      }

    }

  }


}
