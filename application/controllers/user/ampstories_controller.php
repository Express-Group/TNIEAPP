<?php
class ampstories_controller extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library("memcached_library");
	}
	public function index(){
		$webStoryId = trim($this->uri->segment(2));
		if($webStoryId=='' || !is_numeric($webStoryId)){
			$this->output->set_status_header('404');
			show_404();
			exit;
		}
		$data = [];
		$query = "SELECT w.title, w.summary, w.section_id, w.url, w.poster_image, w.author, w.no_index, w.no_follow, w.meta_title, w.meta_description, w.tags, w.created_on, w.modified_on, s.Sectionname FROM webstories_master AS w INNER JOIN sectionmaster AS s ON w.section_id = s.Section_id WHERE w.wsid='".$webStoryId."' AND w.status=1";
		if(!$this->memcached_library->get($query) && $this->memcached_library->get($query) == ''){
			$data['story']  = $this->db->query($query)->row_array();	
			$this->memcached_library->add($query,$data['story']);
		}else{
			$data['story'] = $this->memcached_library->get($query);
		}
		if(!isset($data['story']) || count($data['story'])==0){
			$this->output->set_status_header('404');
			show_404();
			exit;
		}
		$storiesData = "SELECT t.name, t.content, t.fields, t.css, t.fonts, ts.scripts FROM webstories_attributes AS t INNER JOIN webstories_templates AS ts ON t.wtid=ts.wtid WHERE t.wsid='".$webStoryId."' AND t.status=1 ORDER BY t.waid ASC";
		if(!$this->memcached_library->get($storiesData) && $this->memcached_library->get($storiesData) == ''){
			$data['list']  = $this->db->query($storiesData)->result();	
			$this->memcached_library->add($storiesData,$data['list']);
		}else{
			$data['list'] = $this->memcached_library->get($storiesData);
		}
		$this->load->view('admin/ampstories' , $data);
	}

}
?>