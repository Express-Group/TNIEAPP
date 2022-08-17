<?php
Class scrolling_data extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function fetch_scrolling_data($type , $section_id){
		$qry ='';
		if($section_id !=''){ $qry = "FIND_IN_SET('$section_id', section_id) AND" ; }		
		$content=$this->db->query("SELECT sid,content,created_on FROM scrolling_newsmaster WHERE  ".$qry." status=1 ORDER BY created_on DESC");
		return $content->result();
	}
	
	public function save_scrolling_data($data){
		return $this->db->insert('scrolling_newsmaster',array('content'=>$data,'status'=>1));
	}
	
	public function save_edit_scrolling_data($data,$sid){
		$this->db->where('sid',$sid);
		return $this->db->update('scrolling_newsmaster',array('content'=>$data));
	}
	
	public function delete_data($sid){
		$this->db->where('sid',$sid);
		return $this->db->update('scrolling_newsmaster',array('status'=>0));
	}

}
?>