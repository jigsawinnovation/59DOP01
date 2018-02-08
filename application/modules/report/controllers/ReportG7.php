<?php

/**
 * Created by PhpStorm.
 * User: sanitkeawtawan
 * Date: 6/19/2017 AD
 * Time: 14:54
 */
include_once("Main.php");
class ReportG7 extends Main_Controller {
    private $data=null;
    public function __construct(){
        parent::__construct();
        $param= $this->getParam();
        $this->data = array(
            'content_view'=>'reportG7',
            'layout'=>"landscape",
            'title'=>'แบบประวัติคลังปัญญาผู้สูงอายุ (G7)',
            'res'=>$this->report_mock->reportG7($param['id'],@$param['date'])
        );
        if(!$this->data['res']){
            $this->dataempty();
        }
    }
    function index(){
        $this->template->load('index_page',$this->data);
    }
    function pdf(){
        $this->generate('report_template/index_pdf',$this->data,$this->preview,'report_g7.pdf',array('orientation'=>'landscape'));
    }
}