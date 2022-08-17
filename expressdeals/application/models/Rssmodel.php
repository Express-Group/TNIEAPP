<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rssmodel extends CI_Model{
	
	private $contenttbl = 'aff_content';
	private $relatedtbl = 'aff_content_related';
	private $mappingtbl = 'aff_content_maping';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('memcached_library');
	}
	
	public function articleList($sid){
		if(IS_MEMCACHE){
			$CacheID = 'ARTICLELIST-'.$sid;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''):
				$result = $this->db->query("SELECT article.content_id , article.title , article.url , article.summary , article.content , article.section_id , article.content_type  , article.published_date , article.image_path , article.image_alt  , article.image_caption , article.author_name FROM ".$this->contenttbl." AS article INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) AND article.content_type=1 AND (mapping.section_id='".$sid."' OR article.section_id='".$sid."') GROUP BY article.content_id ORDER BY article.last_updated_on DESC")->result_array();
				$this->memcached_library->add($CacheID,$result);
			else:
				$result = $this->memcached_library->get($CacheID);
			endif;
			return $result;
		}else{
			return $result = $this->db->query("SELECT article.content_id , article.title , article.url , article.summary , article.content , article.section_id , article.content_type  , article.published_date , article.image_path , article.image_alt  , article.image_caption , article.author_name FROM ".$this->contenttbl." AS article INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id WHERE article.status =1 AND (article.approve_status=1 OR article.approve_status=2) AND article.content_type=1 AND (mapping.section_id='".$sid."' OR article.section_id='".$sid."') GROUP BY article.content_id ORDER BY article.last_updated_on DESC")->result_array();
		}
		
	}
}
?>