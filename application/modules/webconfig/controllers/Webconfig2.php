<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webconfig2 extends MX_Controller {

	function __construct() {
		parent::__construct();

		$this->load->library('template',
			array('name'=>'admin_template1',
				  'setting'=>array('data_output'=>''))
		);

	}
	function __deconstruct() {
		$this->db->close();
	}	
	
	public function main($process_action='View'){
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 77;
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

			//$data['welfare_info'] = $this->welfare_model->getAll_admInfo();
			$data['news_list'] = $this->webinfo_model->newsList();
			//dieArray($data);

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

			set_js_asset_footer('webconfig.js','webconfig'); //Set JS Index.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'webconfig';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page',$data,'webconfig');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}
	}
	
	
	public function webconfig_about($process_action='View') {
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 76;
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

			//$data['welfare_info'] = $this->welfare_model->getAll_admInfo();
			$data['about_list'] = $this->webinfo_model->aboutList();
			//dieArray($data);

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

			set_js_asset_footer('webconfig_about.js','webconfig'); //Set JS Index.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'webconfig_about';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page',$data,'webconfig');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}
	}
	
	public function infrm2($process_action='Add', $about_id=0) {
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 76;
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

			//$data['welfare_info'] = $this->welfare_model->getAll_admInfo();

			
			//dieArray($data);

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

			set_js_asset_footer('infrm2.js','webconfig'); //Set JS Index.js
			$data['process_action'] = $process_action;
			$data['content_view'] = 'inform2';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			if ($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				$this->template->load('index_page',$data,'webconfig');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				
				
			} else if ($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') {
				
				$this->load->library('form_validation');
				$frm=$this->form_validation;
				
				$frm->set_rules("about_title", "��������ǡѺ���", "required");
				$frm->set_rules("about_detail", "��������´����ǡѺ���", "required");
				
				if ($frm->run($this)) {
					$data_insert = array();
					
					$data_insert["about_title"] = get_inpost("about_title");
					$data_insert["about_detail"] = get_inpost("about_detail");
					$data_insert["insert_user_id"] = get_session('user_id');
					$data_insert["insert_datetime"] = date("Y-m-d H:i:s");
					
					$this->common_model->insert("web_about", $data_insert);
					$this->session->set_flashdata('msg',setMsg('011'));
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success');
					redirect("webconfig/webconfig_about", "refresh");
				} else {
					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 01
					$this->template->load('index_page',$data,'webconfig');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			} else if ($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$result = $this->webinfo_model->getDataAbout($about_id);
				$data['about_title'] = $result['about_title'];
				$data['about_detail'] = $result['about_detail'];
				$data['about_id'] = $result['about_id'];
				//dieArray($data['news_images']);
				$this->template->load('index_page',$data,'webconfig');
			} else if ($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') {
				//dieArray($this->input->post());
				$this->load->library('form_validation');
				$result = $this->webinfo_model->getDataAbout($about_id);
				$frm=$this->form_validation;
				
				$frm->set_rules("about_title", "��������ǡѺ���", "required");
				$frm->set_rules("about_detail", "��������´����ǡѺ���", "required");
				
				if ($frm->run($this)) {
					$data_update = array();
					$data_update["about_title"] = get_inpost("about_title");
					$data_update["about_detail"] = get_inpost("about_detail");
					$data_update["update_user_id"] = get_session('user_id');
					$data_update["update_datetime"] = date("Y-m-d H:i:s");
					
					$this->common_model->update("web_about", $data_update, array('about_id'=>$about_id));
					$this->session->set_flashdata('msg',setMsg('021'));
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success');
					redirect("webconfig/infrm2/Edit/".$about_id, "refresh");
				} else {
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 01
					$this->template->load('index_page',$data,'webconfig');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			} else if ($process_action=='Delete' && $usrpm['perm_status']=='Yes') {
				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('web_about',$data_update,array('about_id'=>$about_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect("webconfig/webconfig_about", "refresh");
			} else {
				page500();
				$this->template->load('index_page',$data,'webconfig');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}
		}
	}
	
	public function webconfig_news($process_action='View') {
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 77;
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

			//$data['welfare_info'] = $this->welfare_model->getAll_admInfo();
			$data['news_list'] = $this->webinfo_model->newsList();
			//dieArray($data);

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

			set_js_asset_footer('webconfig_news.js','webconfig'); //Set JS Index.js

			$data['process_action'] = $process_action;
			$data['content_view'] = 'webconfig_news';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			$this->template->load('index_page',$data,'webconfig');
			$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
		}
	}
	
	public function infrm1($process_action='Add', $news_id=0) {
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 77;
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

			//$data['welfare_info'] = $this->welfare_model->getAll_admInfo();

			
			//dieArray($data);

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

			set_js_asset_footer('infrm1.js','webconfig'); //Set JS Index.js
			$data['process_action'] = $process_action;
			$data['content_view'] = 'inform1';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			if ($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				$this->template->load('index_page',$data,'webconfig');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				
				
			} else if ($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') {
				
				$this->load->library('form_validation');
				$frm=$this->form_validation;
				
				$frm->set_rules("news_name", "���͢��ǻ������ѹ��", "required");
				$frm->set_rules("news_detail", "���͢��ǻ������ѹ��", "required");
				
				if ($frm->run($this)) {
					$data_insert = array();
					$data_insert["news_image_title"] = $this->files_model->getOnceImg("news_images", "assets/modules/webconfig/images");
					$data_insert["news_images"] = serialize($this->files_model->getMultiImg("images", "assets/modules/webconfig/images"));
					
					$data_insert["news_name"] = trim($this->input->post("news_name"));
					$data_insert["news_detail"] = $this->input->post("news_detail");
					$data_insert["news_description"] = $this->input->post("news_description");
					$data_insert["news_keywords"] = $this->input->post("news_keywords");
					$data_insert["news_author"] = $this->input->post("news_author");
					$data_insert["insert_user_id"] = get_session('user_id');
					$data_insert["insert_datetime"] = date("Y-m-d H:i:s");
					
					$this->common_model->insert("web_news", $data_insert);
					$this->session->set_flashdata('msg',setMsg('011'));
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success');
					redirect("webconfig/main", "refresh");
				} else {
					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 01
					$this->template->load('index_page',$data,'webconfig');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			} else if ($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$result = $this->webinfo_model->getDataNews($news_id);
				$data['news_image_title'] = $result['news_image_title'];
				$data['news_name'] = $result['news_name'];
				$data['news_detail'] = $result['news_detail'];
				$data['news_description'] = $result['news_description'];
				$data['news_keywords'] = $result['news_keywords'];
				$data['news_author'] = $result['news_author'];
				$data['news_images'] = unserialize($result['news_images']);
				$data['news_id'] = $result['news_id'];
				//dieArray($data['news_images']);
				$this->template->load('index_page',$data,'webconfig');
			} else if ($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') {
				$this->load->library('form_validation');
				$result = $this->webinfo_model->getDataNews($news_id);
				$frm=$this->form_validation;
				
				$frm->set_rules("news_name", "���͢��ǻ������ѹ��", "required");
				$frm->set_rules("news_detail", "���͢��ǻ������ѹ��", "required");
				
				if ($frm->run($this)) {
					$data_update = array();
					if ($_FILES['news_images']['name'] != "") {
						$data_update["news_image_title"] = $this->files_model->getOnceImg("news_images", "assets/modules/webconfig/images");
					}
					
					if ($_FILES['images']['name'][0] != "") {
						$imageOld = unserialize($result['news_images']);
						$imageNew = $this->files_model->getMultiImg("images", "assets/modules/webconfig/images");
						$merge	= array_merge($imageOld, $imageNew);
						$allImage = array_values($merge);
						$data_update["news_images"] = serialize($allImage);
					}
					
					
					$data_update["news_name"] = trim($this->input->post("news_name"));
					$data_update["news_detail"] = $this->input->post("news_detail");
					$data_update["news_description"] = $this->input->post("news_description");
					$data_update["news_keywords"] = $this->input->post("news_keywords");
					$data_update["news_author"] = $this->input->post("news_author");
					$data_update["insert_user_id"] = get_session('user_id');
					$data_update["insert_datetime"] = date("Y-m-d H:i:s");
					
					$this->common_model->update("web_news", $data_update, array('news_id'=>$news_id));
					$this->session->set_flashdata('msg',setMsg('021'));
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success');
					redirect("webconfig/infrm1/Edit/".$news_id, "refresh");
				} else {
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 01
					$this->template->load('index_page',$data,'webconfig');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			} else if ($process_action=='Delete' && $usrpm['perm_status']=='Yes') {
				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['delete_datetime'] = getDatetime();

				$this->common_model->update('web_news',$data_update,array('news_id'=>$news_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect("webconfig", "refresh");
			} else {
				page500();
				$this->template->load('index_page',$data,'webconfig');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}
		}
	}
	
	public function delete_image($news_id=0, $image=0) {
		$result = $this->webinfo_model->getDataNews($news_id);
		$images = unserialize($result['news_images']);
		unset($images[$image]);
		$newsAll = array_values($images);
		
		$data_update["news_images"] = serialize($newsAll);
		$this->common_model->update("web_news", $data_update, "news_id = '$news_id'");
		$this->session->set_flashdata('msg',setMsg('021'));
		redirect("webconfig/infrm1/Edit/".$news_id, "refresh");
	}
	
	public function webconfig_detail($process_action='Edit', $web_id=1) {
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 77;
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

			//$data['welfare_info'] = $this->welfare_model->getAll_admInfo();

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

			set_js_asset_footer('web_detail.js','webconfig'); //Set JS Index.js
			$data['process_action'] = $process_action;
			$data['content_view'] = 'webconfig_detail';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];
			//dieArray($this->input->post("bt_submit"));
			if ($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				
				$web = $this->webinfo_model->getDataWebDetail();
				$data['web_title'] = $web['web_title'];
				$data['web_icon'] = $web['web_icon'];
				$data['web_logo'] = $web['web_logo'];
				$data['web_address'] = $web['web_address'];
				$data['web_phone'] = $web['web_phone'];
				$data['web_fax'] = $web['web_fax'];
				$data['web_email'] = $web['web_email'];
				$data['web_keyword'] = $web['web_keyword'];
				$data['web_description'] = $web['web_description'];
				$data['web_author'] = $web['web_author'];
				$data['web_condition_link'] = $web['web_condition_link'];
				$data['web_policy_link'] = $web['web_policy_link'];
				$data['web_privacy_policy_link'] = $web['web_privacy_policy_link'];
				$data['web_security_policy_link'] = $web['web_security_policy_link'];
				$this->template->load('index_page',$data,'webconfig');
			} else if ($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') {
				//dieArray($data);
				$this->load->library('form_validation');
				$result = $this->webinfo_model->getDataWebDetail($web_id);
				$frm=$this->form_validation;
				
				$frm->set_rules("web_title", "�������䫵�", "required");
				$frm->set_rules("web_address", "�������", "required");
				
				if ($frm->run($this)) {
					$data_update = array();
					
					if (@$_FILES['web_icon']['name'] != "") {
						$data_update["web_icon"] = $this->files_model->getOnceImg("web_icon", "assets/modules/webconfig/images");
					}
					
					if (@$_FILES['web_logo']['name'] != "") {
						$data_update["web_logo"] = $this->files_model->getOnceImg("web_logo", "assets/modules/webconfig/images");
					}
					
					$data_update["web_title"] = trim($this->input->post("web_title"));
					$data_update["web_address"] = $this->input->post("web_address");
					$data_update["web_phone"] = $this->input->post("web_phone");
					$data_update["web_fax"] = $this->input->post("web_fax");
					$data_update["web_email"] = $this->input->post("web_email");
					$data_update["web_keyword"] = $this->input->post("web_keyword");
					$data_update["web_description"] = $this->input->post("web_description");
					$data_update["web_author"] = $this->input->post("web_author");
					$data_update["web_condition_link"] = $this->input->post("web_condition_link");
					$data_update["web_policy_link"] = $this->input->post("web_policy_link");
					$data_update["web_privacy_policy_link"] = $this->input->post("web_privacy_policy_link");
					$data_update["web_security_policy_link"] = $this->input->post("web_security_policy_link");
					
					$this->common_model->update("web_detail", $data_update, array('web_id'=>$web_id));
					$this->session->set_flashdata('msg',setMsg('021'));
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success');
					redirect("webconfig/webconfig_detail/Edit/".$web_id, "refresh");
				} else {
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 01
					$this->template->load('index_page',$data,'webconfig');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			}  else {
				page500();
				$this->template->load('index_page',$data,'webconfig');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}
		}
		
	}
	
	public function delete_icon() {
		$result = $this->webinfo_model->getDataWebDetail(1);
		$data_update["web_icon"] = NULL;
		
		$this->common_model->update("web_detail", $data_update, "web_id = '1'");
		$this->session->set_flashdata('msg',setMsg('021'));
		redirect("webconfig/webconfig_detail/Edit/1", "refresh");
	}
	
	public function delete_logo() {
		$result = $this->webinfo_model->getDataWebDetail(1);
		$data_update["web_logo"] = NULL;
		
		$this->common_model->update("web_detail", $data_update, "web_id = '1'");
		$this->session->set_flashdata('msg',setMsg('021'));
		redirect("webconfig/webconfig_detail/Edit/1", "refresh");
	}
	
	public function webconfig_slide($process_action='View', $web_id=0) {
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 77;
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

			//$data['welfare_info'] = $this->welfare_model->getAll_admInfo();

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

			set_js_asset_footer('web_slide.js','webconfig'); //Set JS Index.js
			$data['process_action'] = $process_action;
			$data['content_view'] = 'webconfig_slide';
			$data['slide'] = $this->webinfo_model->getDataSlide();
			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];
			$this->template->load('index_page',$data,'webconfig');
		}
	}
	
	public function infrm3($process_action='Add', $slide_id=0) {
		$data = array(); //Set Initial Variable to Views
		/*-- Initial Data for Check User Permission --*/
		$user_id = get_session('user_id');
		$app_id = 77;
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

			//$data['welfare_info'] = $this->welfare_model->getAll_admInfo();

			
			//dieArray($data);

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

			set_js_asset_footer('infrm3.js','webconfig'); //Set JS Index.js
			$data['process_action'] = $process_action;
			$data['content_view'] = 'inform3';

			$tmp = $this->admin_model->getOnce_Application($usrpm['app_parent_id']); //Used for find root application
			
			$data['head_title'] = $tmp['app_name'];
			$data['title'] = $usrpm['app_name'];

			if ($process_action=='Add' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$this->template->load('index_page',$data,'webconfig');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				
			} else if ($process_action=='Added' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') {
				
				$this->load->library('form_validation');
				$frm=$this->form_validation;
				
				$frm->set_rules("slide_name", "���͢��ǻ������ѹ��", "required");
				
				if ($frm->run($this)) {
					$data_insert = array();
					$data_insert["slide_image"] = $this->files_model->getOnceImg("slide_image", "assets/modules/webconfig/images");
					
					
					$data_insert["slide_name"] = trim($this->input->post("slide_name"));
					$data_insert["slide_link"] = $this->input->post("slide_link");
					$data_insert["slide_status"] = (int)$this->input->post("slide_status");
					$data_insert["insert_user_id"] = get_session('user_id');
					$data_insert["insert_datetime"] = date("Y-m-d H:i:s");
					
					$this->common_model->insert("web_slide", $data_insert);
					$this->session->set_flashdata('msg',setMsg('011'));
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success');
					redirect("webconfig/webconfig_slide", "refresh");
				} else {
					$this->session->set_flashdata('msg',setMsg('012')); //Set Message code 01
					$this->template->load('index_page',$data,'webconfig');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			} else if ($process_action=='Edit' && get_inpost('bt_submit')=='' && $usrpm['perm_status']=='Yes') {
				$result = $this->webinfo_model->getDataSlideRow($slide_id);
				$data['slide_name'] = $result['slide_name'];
				$data['slide_image'] = $result['slide_image'];
				$data['slide_link'] = $result['slide_link'];
				$data['slide_status'] = $result['slide_status'];
				$data['slide_id'] = $result['slide_id'];
				//dieArray($data['news_images']);
				$this->template->load('index_page',$data,'webconfig');
			} else if ($process_action=='Edited' && get_inpost('bt_submit')!='' && $usrpm['perm_status']=='Yes') {
				$this->load->library('form_validation');
				$frm=$this->form_validation;
				
				$frm->set_rules("slide_name", "���͢��ǻ������ѹ��", "required");
				
				if ($frm->run($this)) {
					$data_update = array();
					if (@$_FILES['slide_image']['name'] != "") {
						$data_update["slide_image"] = $this->files_model->getOnceImg("slide_image", "assets/modules/webconfig/images");
					}
					
					
					$data_update["slide_name"] = trim($this->input->post("slide_name"));
					$data_update["slide_link"] = $this->input->post("slide_link");
					$data_update["slide_status"] = (int)$this->input->post("slide_status");
					$data_update["update_user_id"] = get_session('user_id');
					$data_update["update_datetime"] = date("Y-m-d H:i:s");
					
					$this->common_model->update("web_slide", $data_update, array('slide_id'=>$slide_id));
					$this->session->set_flashdata('msg',setMsg('021'));
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success');
					redirect("webconfig/infrm3/Edit/".$slide_id, "refresh");
				} else {
					$this->session->set_flashdata('msg',setMsg('022')); //Set Message code 01
					$this->template->load('index_page',$data,'webconfig');
					$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
				}
			} else if ($process_action=='Delete' && $usrpm['perm_status']=='Yes') {
				$data_update = array();
				$data_update['delete_user_id'] 	= getUser();
				$data_update['dalete_datetime'] = getDatetime();

				$this->common_model->update('web_slide',$data_update,array('slide_id'=>$slide_id));
				$this->session->set_flashdata('msg',setMsg('031')); //Set Message code 031
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Success'); //Save Sign Out Log
				redirect("webconfig", "refresh");
			} else {
				page500();
				$this->template->load('index_page',$data,'webconfig');
				$this->webinfo_model->LogSave($app_id,$process_action,'Sign Out','Fail'); //Save Sign Out Log
			}
		}
	}
	
	public function delete_image_slide($slide_id = 0) {
		$result = $this->webinfo_model->getDataWebDetail(1);
		$data_update["slide_image"] = NULL;
		
		$this->common_model->update("web_slide", $data_update, "slide_id = '$slide_id'");
		$this->session->set_flashdata('msg',setMsg('021'));
		redirect("webconfig/infrm3/Edit/1", "refresh");
	}
}
