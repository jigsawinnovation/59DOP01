<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: sanitkeawtawan
 * Date: 8/1/2017 AD
 * Time: 13:44
 */
include_once("Main.php");
class ReportB0 extends Main_Controller {
    private $data=null;
    public function __construct(){
        parent::__construct();
        $param= $this->getParam();
        $data['rows']=$this->report_mock->reportB0(@$param['id']);
        $data['headers']=array(
            'ข้อมูลผู้สูงอายุที่รับบริการในศูนย์พัฒนาการจัดสวัสดิการสังคม' ,
            'กรมกิจการผู้สูงอายุ กระทรวงการพัฒนาสังคมและความมั่นคงของมนุษย์' ,
            'ข้อมูล ณ วันที่ '.dateTH(date('Y-m-d')).' (จำนวน '.count($data['rows']).' รายการ)',
            ' '
        );
        if(!$data['rows']){
            $this->dataempty();
        }
        $this->data = array(
            'content_view'=>'reportB0',
            'title'=>'ข้อมูลผู้สูงอายุที่รับบริการในศูนย์พัฒนาการจัดสวัสดิการสังคม',
            'res'=>$data);
    }
    function index(){
        $this->template->load('index_xls',$this->data);
    }
    function xls(){
        $this->excel(APPPATH . '/../assets/modules/report/static/2.1.xls',$this->data,'D','report_B0',array(),9);

    }

}