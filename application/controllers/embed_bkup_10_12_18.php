<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class embed extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function chart($widgetInstanceId=''){
		$widgetInstanceId = base64_decode($widgetInstanceId);
		$filename = $widgetInstanceId.'.json';
		$filepath = FCPATH.'application/views/piechart/';
		if(file_exists($filepath.$filename)){
			$response = [];
			$response['error'] = false;
			$response['wid'] = $widgetInstanceId;
			$this->load->view('admin/embed_chart',$response);
		}else{
			$this->load->view('admin/embed_chart',['error'=>true , 'wid'=>$widgetInstanceId]);
		}
	}
	
	public function table($tableid){
		$tid = (int) base64_decode(trim($tableid));
		if($tid!='' && is_numeric($tid)){
			$response =[];
			$this->load->database();
			$data = $this->db->query("SELECT tid , table_name , total , table_properties FROM tablemaster WHERE tid='".$tid."' LIMIT 1");
			if($data->num_rows()==0){
				$response['error'] = true;
				$response['data'] = [];
			}else{
				$response['error'] = false;
				$response['data'] = $data->result_array();
			}
			$this->load->view('admin/embed_table',$response);
		}else{
			$this->load->view('admin/embed_table',['error'=>true , 'tid'=>$tid]);
		}
	}
}
?> 