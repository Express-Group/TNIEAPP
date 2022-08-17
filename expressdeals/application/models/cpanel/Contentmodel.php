<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Contentmodel extends CI_Model{
	private $tbl = 'aff_content';
	private $sectiontbl = 'aff_sections';
	private $relatedtbl = 'aff_content_related';
	private $mappingtbl = 'aff_content_maping';
	private $producttbl = 'aff_products';
	private $productrealtedtbl = 'aff_products_related';
	public function __construct(){
		parent::__construct();
	}
	
	public function get_sections(){
		
		return $this->db->select('sid , section_name , parent_id , article_hosting , section_type')->where('status' ,1)->order_by('order_by' , 'ASC')->get($this->sectiontbl)->result();
	}
	
	public function get_countries(){
		return $this->db->select('cid , name')->order_by('name' , 'ASC')->get('aff_country')->result();
	}
	
	public function get_states($cid){
		return $this->db->select('sid , name')->where('cid' , $cid)->order_by('name' , 'ASC')->get('aff_states')->result();
	}
	
	public function getImagesCount($search , $perpage ,$rows){
		return $this->db->query("SELECT img.id FROM aff_images AS img INNER JOIN aff_users AS user ON img.created_by = user.uid WHERE img.status=1 ".$search."")->num_rows();
	}
	
	public function getImages($search , $perpage ,$rows){
		return $this->db->query("SELECT img.id , img.file_path , img.caption , img.alt , img.image_name ,user.username FROM aff_images AS img INNER JOIN aff_users AS user ON img.created_by = user.uid WHERE img.status=1 ".$search." ORDER BY img.id DESC LIMIT ".$rows." , ".$perpage."")->result();
	}
	
	public function getSectionDetails($sid){
		return $this->db->select('sid , section_name , parent_id , article_hosting , section_type , section_path , section_full_path')->where('sid' , $sid)->get($this->sectiontbl)->row_array();
	}
	
	public function insertArticle($data , $relatedData , $mapping  ,$productID =[] , $productTitle = []){
		$this->db->insert($this->tbl , $data);
		$contentID = $this->db->insert_id();
		if($contentID!='' && $contentID!=0 && $contentID!=null){
			$this->db->trans_begin();
			$relatedData['content_id'] = $contentID;
			$mappingData =[];
			$productRelated = [];
			$this->db->where('content_id' , $contentID);
			$this->db->update($this->tbl , ['url' => $data['url'].$contentID.'.html']);
			$this->db->insert($this->relatedtbl , $relatedData);
			if($mapping!='' && is_array($mapping) && count($mapping) > 0){
				for($i=0;$i<count($mapping);$i++){
					$mappingData[] = ['content_id' => $contentID , 'section_id' => $mapping[$i]];
				}
				if(count($mappingData) >0){
					 $this->db->insert_batch($this->mappingtbl, $mappingData);
				}
			}
			if($productID!='' && is_array($productID) && count($productID) > 0){
				for($j=0;$j<count($productID);$j++){
					$productRelated[] = ['content_id' => $contentID , 'pid' => $productID[$j] , 'title' => $productTitle[$j]];		
				}
				if(count($productRelated) >0){
					 $this->db->insert_batch($this->productrealtedtbl, $productRelated);
				}
			}				
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$this->db->where('content_id' ,$contentID);
				$this->db->delete($this->tbl);
				return 'FAILED';
			}else{
				$this->db->trans_commit();
				return 'SUCCESS';
			}
		}else{
			return 'FAILED';
		}
	}
	
	public function updateArticle($data , $relatedData , $mapping , $productID=[] , $productTitle=[] , $contentID){
		$this->db->where('content_id' , $contentID);
		$status = $this->db->update($this->tbl , $data);
		if($status!='' && $status!=0 && $status!=null){
			$this->db->trans_begin();
			$mappingData =[];
			$relatedData['content_id'] = $contentID;
			$this->db->where('content_id' , $contentID);
			$this->db->update($this->relatedtbl , $relatedData);
			$this->db->where('content_id' , $contentID);
			$this->db->delete($this->mappingtbl);
			$this->db->where('content_id' , $contentID);
			$this->db->delete($this->productrealtedtbl);
			if($mapping!='' && is_array($mapping) && count($mapping) > 0){
				for($i=0;$i<count($mapping);$i++){
					$mappingData[] = ['content_id' => $contentID , 'section_id' => $mapping[$i]];
				}
				if(count($mappingData) >0){
					 $this->db->insert_batch($this->mappingtbl, $mappingData);
				}
			}
			if($productID!='' && is_array($productID) && count($productID) > 0){
				for($j=0;$j<count($productID);$j++){
					$productRelated[] = ['content_id' => $contentID , 'pid' => $productID[$j] , 'title' => $productTitle[$j]];		
				}
				if(count($productRelated) >0){
					 $this->db->insert_batch($this->productrealtedtbl, $productRelated);
				}
			}
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return 'FAILED';
			}else{
				$this->db->trans_commit();
				return 'SUCCESS';
			}
		}else{
			return 'FAILED';
		}
	}
	
	public function getArticleCount($search=''){
		return $this->db->query("SELECT article.content_id FROM ".$this->tbl." AS article INNER JOIN aff_users AS user ON  article.created_by = user.uid INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id INNER JOIN ".$this->sectiontbl." AS section ON article.section_id = section.sid WHERE ".$search." GROUP BY article.content_id")->num_rows();
	}
	
	public function getArticle($search , $perPage , $row , $orderBy){
		return $this->db->query("SELECT article.content_id , article.title , article.url , article.image_path , article.image_alt ,article.author_name , article.status , DATE_FORMAT(article.last_updated_on, '%D %b %Y %h:%i:%s %p') as modified_on ,  user.username  , section.section_full_path , section.section_name FROM ".$this->tbl." AS article INNER JOIN aff_users AS user ON  article.created_by = user.uid INNER JOIN ".$this->relatedtbl." AS related ON article.content_id = related.content_id LEFT JOIN ".$this->mappingtbl." AS mapping ON article.content_id = mapping.content_id INNER JOIN ".$this->sectiontbl." AS section ON article.section_id = section.sid WHERE ".$search." GROUP BY article.content_id ".$orderBy." LIMIT ".$row ." , ".$perPage."")->result();
	}
	
	public function articleDetails($content_id){
		$details = [];
		$details['articleDetails'] =  $this->db->select('*')->where('content_id' , $content_id)->get($this->tbl)->row_array();
		$details['relatedDetails'] =  $this->db->select('*')->where('content_id' , $content_id)->get($this->relatedtbl)->row_array();
		$details['mappingDetails'] =  $this->db->select('*')->where('content_id' , $content_id)->get($this->mappingtbl)->result_array();
		$details['productDetails'] =  $this->db->query("SELECT product.product_name , product.image_path , related .title , related.pid FROM ".$this->productrealtedtbl." AS  related INNER JOIN ".$this->producttbl." AS product ON related.pid = product.pid WHERE related.content_id='".$content_id."'")->result_array();
		return $details;
	}
	
	public function set_temp($image_id){
		$this->load->model(ADMINFOLDER.'imagemodel');
		$response = [];
		$response['status'] = 0;
		$details = $this->imagemodel->get_data($image_id);
		if(count($details) > 0){
			$response['status'] = 1;
			$timestamp = time();
			$file = explode('.' , $details['file_path']);
			$originalPath = 'image_'.$timestamp.'.'.$file[1];
			$smallPath = 'image_small_'.$timestamp.'.'.$file[1];
			$mediumPath = 'image_medium_'.$timestamp.'.'.$file[1];
			$largePath = 'image_large_'.$timestamp.'.'.$file[1];
			$exlargePath = 'image_exlarge_'.$timestamp.'.'.$file[1];
			copy(FCPATH.CONTENT_IMAGE_PATH.$details['file_path'] , FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$originalPath);
			copy(FCPATH.CONTENT_IMAGE_PATH. str_replace('original/' ,'small/',$details['file_path']) , FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$smallPath);
			copy(FCPATH.CONTENT_IMAGE_PATH.str_replace('original/' ,'medium/',$details['file_path']) , FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$mediumPath);
			copy(FCPATH.CONTENT_IMAGE_PATH.str_replace('original/' ,'large/',$details['file_path']) , FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$largePath);
			copy(FCPATH.CONTENT_IMAGE_PATH.str_replace('original/' ,'exlarge/',$details['file_path']) , FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$exlargePath);
			$data['image_id'] = $details['id'];
			$data['image_path'] = $originalPath;
			$data['image_name'] = $details['image_name'];
			$data['caption'] = $details['caption'];
			$data['alt'] = $details['alt'];
			$data['created_by'] = $data['modified_by'] = $this->session->userdata('uid');
			$data['modified_on'] = date('Y-m-d H:i:s');
			$result = $this->imagemodel->insert_temp($data);
			$response['temp_id'] = $result;
			$response['image_name'] = $data['image_name'];
			$response['path'] = ASSETURL.IMAGE_TEMP_PATH.$originalPath; 
		}
		return $response;
	}
	
	public function remove_temp($image_id){
		$this->load->model(ADMINFOLDER.'imagemodel');
		$result = $this->db->select('*')->where('image_id', $image_id)->get('aff_temp_images')->result_array();
		foreach($result as $details){
			$originalPath = $details['image_path'];
			$smallPath = str_replace('image_' , 'image_small_' , $details['image_path']);
			$mediumPath = str_replace('image_' , 'image_medium_' , $details['image_path']);
			$largePath = str_replace('image_' , 'image_large_' , $details['image_path']);
			$exlargePath = str_replace('image_' , 'image_exlarge_' , $details['image_path']);
			@unlink(FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$originalPath);
			@unlink(FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$smallPath);
			@unlink(FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$mediumPath);
			@unlink(FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$largePath);
			@unlink(FCPATH.ASSET_PATH.IMAGE_TEMP_PATH.$exlargePath);
			$this->imagemodel->remove_tempdata($details['id']);
		}
	}
	
	public function getProductDetails($search){
		return $this->db->query("SELECT product.pid , product.product_name , product.image_path , section.section_name FROM ".$this->producttbl." AS product INNER JOIN aff_users AS user ON product.created_by = user.uid INNER JOIN ".$this->sectiontbl." AS section ON product.section_id = section.sid WHERE product.pid !='' ".$search." ORDER BY product.pid DESC")->result_array();
	}
	
	
	
	
}?>