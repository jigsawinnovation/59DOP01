<?php
class Wisd_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getAll_admInfo() {
		return $this->common_model->custom_query("
			SELECT * FROM wisd_info
			WHERE (delete_user_id IS NULL && delete_datetime IS NULL)
			ORDER BY insert_datetime DESC,update_datetime DESC
		");
	}

	public function getOnce_admInfo($adm_id = ''){
               /*return rowArray($this->common_model->custom_query("select A.*,B.*,C.*,D.*,E.*,F.*,G.*,CONCAT(B.pers_firstname_th, ' ', B.pers_lastname_th) as name
                from wisd_info as A
                                    left join pers_info as B       on A.pers_id=B.pers_id
                                    left join std_prename as C     on B.pren_code=C.pren_code
                                    left join std_gender as D      on B.gender_code=D.gender_code
                                    left join std_nationality as E on B.nation_code=E.nation_code
                                    left join std_religion as F    on B.relg_code=F.relg_code
                                    left join std_edu_level as G    on B.edu_code=G.edu_code

                where (A.delete_user_id IS NULL && A.delete_datetime IS NULL) and
                      (B.delete_user_id IS NULL && B.delete_datetime IS NULL)
                      and knwl_id={$adm_id}
                "));*/
		return rowArray($this->common_model->custom_query("select A.*,B.*,C.*,D.*,E.*,G.*,H.addr_code,CONCAT(B.pers_firstname_th, ' ', B.pers_lastname_th) as name
                from wisd_info as A
                                    left join pers_info as B       on A.pers_id=B.pers_id
                                    left join std_prename as C     on B.pren_code=C.pren_code
                                    left join std_gender as D      on B.gender_code=D.gender_code
                                    left join std_nationality as E on B.nation_code=E.nation_code
                                    left join std_edu_level as G    on B.edu_code=G.edu_code
                                    LEFT JOIN pers_addr as H       on B.reg_addr_id = H.addr_id
                where (A.delete_user_id IS NULL && A.delete_datetime IS NULL) and
                      (B.delete_user_id IS NULL && B.delete_datetime IS NULL)
                      and knwl_id={$adm_id}
                "));
		}



	public function getAll_Disability($pers_id='') {
		if($pers_id == ''){
			return array();
		}
		$tmp = array();
    $tmp = $this->common_model->get_where_custom('pers_disability', 'pers_id', $pers_id);
    $tmp = sort_array_with($tmp,'dis_code');
    return $tmp;
	}

	public function getAll_caseReason($type = "การรับเข้า"){
		return $this->common_model->get_where_custom('std_case_reason', 'case_reason_type', $type);
	}

	public function getAll_admIrp($pers_id = ''){
		if($pers_id == ''){
			return array();
		}
		return $this->common_model->custom_query("
			SELECT A.*,B.* FROM adm_irp AS A
			LEFT JOIN usrm_org AS B ON A.irp_org_id = B.org_id
			WHERE pers_id = {$pers_id}
			ORDER BY date_of_irp DESC
		");
	}

	public function getOnce_admIrp($pers_id = '',$irp_id=''){
		if($pers_id == '' || $irp_id == ''){
			return array();
		}
		return rowArray($this->common_model->custom_query("
			SELECT A.*,B.* FROM adm_irp AS A
			LEFT JOIN usrm_org AS B ON A.irp_org_id = B.org_id
			WHERE A.pers_id = {$pers_id}
			AND A.irp_id = {$irp_id}
		"));
	}

	public function getAll_irpDimension(){
		return $this->common_model->get_where_custom_order('std_irp', 'qstn_type', 'Dimension','qstn_id','ASC');
	}

	public function getAll_irpQuestion($parent=''){
		if($parent == ''){
			return array();
		}
		return $this->common_model->custom_query("
			SELECT * FROM std_irp
			WHERE qstn_type = 'Question'
			AND qstn_pid = {$parent}
			ORDER BY qstn_id ASC
		");
	}

	public function getAll_irpAnswer($parent=''){
		if($parent == ''){
			return array();
		}
		return $this->common_model->custom_query("
			SELECT * FROM std_irp
			WHERE qstn_type = 'Answer'
			AND qstn_pid = {$parent}
			ORDER BY qstn_id ASC
		");
	}

	public function get_Percentage($irp_id='',$q_id=''){
		if($irp_id == ''){
			return array();
		}
		$question = "";
		if($q_id != ''){
			$question = "AND qstn_id = {$q_id}";
		}
		$countIrp = rowArray($this->common_model->custom_query("SELECT SUM(ans_points) AS ans_points ,SUM(ans_full_score) AS ans_full_score FROM adm_irp_result WHERE irp_id = {$irp_id} {$question}"));

		$irp_result = array(
			'ans_points' => $countIrp['ans_points'],
			'ans_full_score' => $countIrp['ans_full_score'],
			'ans_percent'	=> ($countIrp['ans_points']/$countIrp['ans_full_score'])*100,
		);

		return $irp_result;
	}

	public function getAll_Progarm($dimension = ''){
		if($dimension == ''){
			return array();
		}
		return $this->common_model->custom_query("
			SELECT * FROM std_programs
			WHERE qstn_id = {$dimension}
			OR qstn_id = '999'
			ORDER BY qstn_id ASC ,prgm_title DESC
		");
	}

	public function getAll_adm_irp_result($irp_id=''){
		if($irp_id == ''){
			return array();
		}
		$tmp = $this->common_model->custom_query("
			SELECT * FROM adm_irp_result
			WHERE irp_id = {$irp_id}
		");

		return sort_array_with($tmp,'qstn_id');
	}

	public function getAll_adm_trm_result($irp_id=''){
		if($irp_id == ''){
			return array();
		}
		$tmp = $this->common_model->custom_query("
			SELECT * FROM adm_trm_result
			WHERE irp_id = {$irp_id}
		");
		return sort_array_with($tmp,'prgm_id');
	}

    //แสดงสาขาภูมิปัญญาตามเลข id
	public function get_wisd_branch_by_knwlid($knwl_id = 0){
		return $this->common_model->custom_query("
			SELECT
				A.*,B.*
			FROM
					wisd_branch AS A
			    LEFT JOIN std_wisdom AS B ON A.wisd_code = B.wis_code
			WHERE A.knwl_id = {$knwl_id}
			AND A.delete_user_id IS NULL
			AND (A.delete_org_id IS NULL || A.delete_datetime IS NULL)
			GROUP BY A.branch_id

		");

	}

	public function get_photo($branch_id = 0){
		return $this->common_model->custom_query("SELECT * FROM wisd_photo WHERE branch_id={$branch_id}");
	}

	public function get_photo_head($branch_id = 0){
		return $this->common_model->custom_query("SELECT *,wisdom_photo_file LIKE '%Head%' AS result FROM wisd_photo WHERE branch_id={$branch_id} GROUP BY result DESC");
	}

	public function get_photo_head_ajax($branch_id = 0){
		return $this->common_model->custom_query("SELECT *,wisdom_photo_file LIKE '%Head%' AS result FROM wisd_photo WHERE branch_id={$branch_id} ");
	}

	public function download_file_branch($knwl_id = 0){
		return rowArray($this->common_model->custom_query("SELECT wisd_sp_file,wisd_sp_label FROM wisd_branch WHERE knwl_id={$knwl_id} AND wisd_sp_file IS NOT NULL LIMIT 1"));
	}

	public function convert_date($date='',$mode='',$year_birth=''){
		$date_str = explode("-",$date);
		$day_str  = explode(" ", $date_str[2]);
		// dieArray($day_str);
		$month    = array('01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน','07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม');
		foreach ($month as $key => $value) {
			if($key==$date_str[1]){
				$month_th = $value;
			}
		}

		$year_th = $date_str[0]+543;

		if($year_birth==''){
		   $age  = date("Y")-$date_str[0];
        }else{
           $year_str = explode("-",$year_birth);
           $age  = $date_str[0]-$year_str[0];
        }

        if($mode=="NoAge"){
           return $day_str[0]." ".$month_th." ".$year_th;
        }else if($mode==''){
		   return $day_str[0]." ".$month_th." ".$year_th." อายุ ".$age." ปี";
	    }else if($mode=='showAge'){
	       return $age;
	    }
	}

	public function search_wisd_info_by_persid($pers_id=0){
		return rowArray($this->common_model->custom_query("SELECT * FROM wisd_info WHERE pers_id={$pers_id} AND delete_user_id IS NULL && delete_datetime IS NULL"));
	}

	public function repeatedly($proj_id=0,$pers_id=0){
		$result = $this->common_model->query("SELECT * FROM wisd_proj_expert WHERE proj_id={$proj_id} AND pers_id={$pers_id}");
	    if($result->num_rows()>0){
	    	return "true";
	    }else{
	    	return "false";
	    }
	}

	public function show_expert($proj_id=0){
		$result = $this->common_model->custom_query("SELECT
														A.*, B.pid,
														B.date_of_birth,
														B.tel_no,
														CONCAT(
															B.pers_firstname_th,
															' ',
															B.pers_lastname_th
														) AS name,
														C.prename_th
													FROM
														wisd_proj_expert AS A
													LEFT JOIN pers_info AS B ON A.pers_id = B.pers_id
													LEFT JOIN std_prename AS C ON B.pren_code = C.pren_code
													WHERE
														A.proj_id = {$proj_id}
													AND B.delete_user_id IS NULL
													AND B.delete_org_id IS NULL");
		return $result;
	}

	public function del_expert($tb_name,$column,$column_id){
		foreach ($column as $key => $value) {
			$this->db->where($value, $column_id[$key]);
		}
		$this->db->delete($tb_name);
  }

  public function get_expert($proj_id=0){
     return $this->common_model->custom_query("SELECT
													A.*, CONCAT(
														B.pers_firstname_th,
														' ',
														B.pers_lastname_th
													) AS name,
													C.*
												FROM
													wisd_proj_expert AS A
												LEFT JOIN pers_info AS B ON A.pers_id=B.pers_id
												LEFT JOIN std_prename as C ON B.pren_code=C.pren_code
												WHERE A.proj_id = {$proj_id} ");
  }

  public function convert_number($number=0){
    $numbet_arr = str_replace(",","", $number);
    return $numbet_arr;
  }

  public function serach_value($knwl_id=0,$data=''){
  	$arr_value = explode(",", $data);
  	$count     = count($arr_value)-1;
  	// dieArray($arr_value);
  	$this->db->select('*');
    $this->db->from('wisd_branch');
    $this->db->where('knwl_id', $knwl_id);
    $this->db->where("(delete_user_id IS NULL AND delete_datetime IS NULL)");
    $str = "(";
  	foreach ($arr_value as $key => $value) {
  		if($key!=0){

  			if($key==1){
              $str = $str."wisd_code = ".$value;
  			}else{
  			  $str = $str." OR wisd_code = ".$value;
  			}
  		}

  	}

    $str = $str.")";
  	$this->db->where("".$str);

  	// dieArray($this->db);
  	$query = $this->db->get();

  	if($query->num_rows()>0){
  		return "true";
  	}else{
  		return "false";
  	}
  }

}
?>
