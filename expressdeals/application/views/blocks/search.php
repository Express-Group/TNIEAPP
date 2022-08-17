<?php
$articles= [];
$defaultPath = ASSETURL.'images/logo/medium.jpg';
$CI = &get_instance();
$CI->load->library('pagination');
$term = trim($this->input->get('q'));
$search_by = ($this->input->get('s')=='') ? 1 : $this->input->get('s');
$type = ($this->input->get('t')=='') ? 1 : $this->input->get('t');
$row = ($this->input->get('per_page')!='') ? $this->input->get('per_page') : 0;
if($term!=''){
	$config = [];
	$config['base_url'] = base_url('search').'?q='.$term.'&s='.$search_by.'&t='.$type;
	$config['total_rows'] = $this->homemodel->getSearchCount($term , $search_by , $type);
	$config['per_page'] = 15;
	$config['num_links'] = 5;
	$config['use_page_numbers'] = FALSE;
	$config['page_query_string'] = TRUE;
	$CI->pagination->initialize($config);
	$articles = $this->homemodel->getSearchContent($term , $search_by , $type , $row , $config['per_page']);
}
?>
<div class="row blocks">
	<div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-12 offset-md-3 offset-lg-3 offset-xl-3">
		<div class="search-container">
			<form method="get" action="<?php echo base_url('search'); ?>">
			<div class="form-group">
				<input required type="text" name="q" class="form-control" id="keywords" placeholder="Keywords" value="<?php echo trim($this->input->get('q')); ?>">
			</div>
			<div class="form-group">
				<select name="s" class="form-control" id="search_by">
					<option value="1">Title</option>
					<option value="2">Summary</option>
					<option value="3">Author</option>
				</select>
			</div>
			<div class="form-group">
				<select name="t" class="form-control" id="type">
					<option value="1">Article</option>
					<option value="2">Gallery</option>
					<option value="3">Video</option>
				</select>
			</div>
			<div class="form-group text-center" style="margin:0;">
				<button type="submit" class="btn btn-secondary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
			</div>
			</form>
		</div>
	</div>
</div>
<div class="row blocks">
<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">
		<hr class="border-line">
	</div>
<?php
$i =1;
$count= 1;
$template ='';
foreach($articles as $article){
	$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article['title']);
	$title = (strlen($title) >83) ? substr($title ,0 ,80).'...' : $title;
	$summary = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$article['summary']);
	//$summary = $summary;
	$url = $data['url'].$article['url'];
	$imageDetails = hasImage($article['image_path']);
	$time = date('F d, Y' , strtotime($article['published_date']));
	$imagePath = $imageCaption = $imageAlt = "";
	if($imageDetails['status']==1){
		$imagePath = ASSETURL.IMAGE_PATH. str_replace('original/' ,'medium/' , $article['image_path']);
		$imageCaption = trim($article['image_caption']);
		$imageAlt = trim($article['image_alt']);
	}else{
		$imagePath = ASSETURL.'images/logo/medium.jpg';
	}
	$template.= '<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">';
	$template.= '<div class="single-inner">';
	$template.= '<a class="single-inner-image" href="'.$url.'"><img class="img-fluid lazy-loaded" src="'.$defaultPath.'" data-src="'.$imagePath.'" alt="'.$imageAlt.'" title="'.$imageCaption.'"></a>';
	$template.= '<div class="single-inner-content">';
	$template.= '<a href="'.$url.'"><h4>'.preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title).'</h4></a>';
	$template.= '<time>UPDATED '.$time.'</time>';
	if($article['author_name']!=''){
		$template.= '<span class="author-name">by '.$article['author_name'].'</span>';
	}
	$template.= '<p class="content-summary">'.$summary.'</p>';
	$template.= '</div>'; 
	$template.= '</div>'; 
	$template.= '</div>'; 
	$template.= '<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">
		<hr class="border-line">
	</div>'; 
	$i++;
	
}
echo $template;
if(count($articles)==0){
	echo '<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">';
	echo '<h5 class="text-center">NO RECORDS FOUND</h5>';
	echo '</div>';
}
?>
<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">
	<div class="pagination text-center"> 
	<?php echo $CI->pagination->create_links(); ?>
	</div>
</div>
</div>