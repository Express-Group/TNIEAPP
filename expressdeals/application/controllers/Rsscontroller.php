<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rsscontroller extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('homemodel');
		$this->load->model('rssmodel');
	}
	
	public function index(){
		$sectionId = $this->input->get('section');
		if($sectionId!='' && is_numeric($sectionId)){
			$data['sectionDetails'] = $this->homemodel->sectionDetails($sectionId);
			$data['parentSectionDetails'] = []; 
			if($data['sectionDetails']['parent_id']!=null){
				$data['parentSectionDetails'] = $this->homemodel->sectionDetails($data['sectionDetails']['parent_id']);
			}
			$contentType = $data['sectionDetails']['section_type'];
			switch($contentType){
				case 1:
					$data['contentList'] = $this->rssmodel->articleList($sectionId);
				break;
				case 2:
					$data['contentList'] = [];
				break;
				case 3:
					$data['contentList'] = [];
				break;
				case 4:
					$data['contentList'] = [];
				break;
				default:
					$data['contentList'] = [];
				break;
				
			}
			$this->load->view('rssfeed' , $data);
		}else{
			show_404();
		}	
	}
	
	public function sitemap(){
		if(count($_GET)==0){
			$data['sectionList'] = $this->homemodel->menuDetails();
			echo $response = $this->load->view("section_sitemap",$data,true);
		}else{
			$data = [];
			echo $response = $this->load->view("section_article_sitemap",$data,true);
		}
	}
}
?>