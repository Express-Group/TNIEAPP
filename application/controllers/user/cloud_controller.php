<?php

class cloud_controller extends CI_Controller{
	private $dbconnection;
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}
	
	public function index(){
		$contentID = $this->uri->segment(1);
		if($contentID=='' || !is_numeric($contentID)){
			redirect(base_url('error'),400);
		}
		$archive = $this->input->get('archive');
		$CI = & get_instance();
		$this->dbconnection = ($archive!='') ?  $CI->load->database('archive_db',true) : $CI->load->database('live_db' ,TRUE);
		$content =array();
		if($archive!=''){
			if($this->dbconnection->table_exists('article_'.$archive)){
				$content = $this->dbconnection->query("SELECT content_id , url ,  title , summary_html , article_page_content_html , article_page_image_path , article_page_image_title , article_page_image_alt , meta_Title , author_name , agency_name , publish_start_date FROM article_".$archive." WHERE content_id='".$contentID."' AND status='P'")->row_array();
			}
		}else{
			$content = $this->dbconnection->query("SELECT content_id , url , title , summary_html , article_page_content_html , article_page_image_path , article_page_image_title , article_page_image_alt , meta_Title , author_name , agency_name , publish_start_date FROM article WHERE content_id='".$contentID."' AND status='P'")->row_array();
		}
		if(count($content) > 0){
			$data['content'] = $content;
			$this->load->view('admin/amp_validation' ,$data);
		}else{
			redirect(base_url('error'),400);
		}
		
		
	}
}
?> 