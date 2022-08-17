<style>
.first-wrapper-inner{position: relative;}
.first-wrapper-inner img{}
.first-wrapper-inner h4{position: absolute; bottom: 0; left: 0; color: white;    padding: 10px; font-weight: bold; margin: 0; background: linear-gradient(to bottom, transparent 0, rgba(0, 0, 0, 1) 80%);font-size: 16px !important;}
.second-wrapper-inner p{padding-top: 5px;}
</style>
<?php
if(trim($this->input->get('term'))!=''){
	$_GET['term'] = htmlspecialchars($_GET['term']);
	$_GET['term'] = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_SPECIAL_CHARS);
}
extract($_GET);
$searchtype =(isset($search) && $search!='')?$search:'';
function pager($parameter=[]){
	$config=['base_url'=>$parameter['base_url'],'total_rows'=>$parameter['total_rows'],'per_page'=>$parameter['per_page'],'num_links'=>5,'page_query_string'=>TRUE,'reuse_query_string'=>FALSE,'suffix'=>$parameter['suffix'],'cur_tag_open'=>'<a class="active">','cur_tag_close'=>'</a>','use_page_numbers'=>TRUE,'first_url'=>$parameter['first_url'],'first_link'=>FALSE,'last_link'=>FALSE];
	return $config;
}
if($searchtype=='short'){
	$this->live_db = $this->load->database('live_db', TRUE);
	$term=(isset($term) && $term!='')?$term:'';
	if($term!=''){
		$widget_url=$content['widget_section_url'];
		$pattern="SELECT title,url,article_page_image_path,summary_html,publish_start_date FROM article WHERE (title LIKE '%".$term."%' OR author_name LIKE '%".$term."%') AND publish_start_date < NOW() AND status='P'  ORDER BY publish_start_date DESC";
		$check_query=@$_COOKIE['shortend'];
		if($check_query==base64_encode($pattern)){
			$query_count=@$_COOKIE['shortend_count'];
		}else{
			if(!$this->memcached_library->get($pattern." LIMIT 100") && $this->memcached_library->get($pattern." LIMIT 100") == ''){
				$query=$this->live_db->query($pattern." LIMIT 100");
				$query_count=$query->num_rows();
				$this->memcached_library->add($pattern." LIMIT 100",$query_count);
			}else{
				$query_count = $this->memcached_library->get($pattern." LIMIT 100");
			}
			setcookie('shortend', base64_encode($pattern),time() + (60 * 15));
			setcookie('shortend_count',$query_count,time() + (60 * 15));
		}
		if($query_count >=100){ $query_count = 100; }else{ $query_count = $query_count;}
		$this->pagination->initialize(pager(['total_rows'=>$query_count,'per_page'=>10,'base_url'=>$widget_url,'suffix'=>'&term='.$term.'&request=ALL&search=short','first_url'=>$widget_url.'?term='.$term.'&request=ALL&search=short']));
		$row=(isset($_GET['per_page']) && $_GET['per_page'])?$_GET['per_page']:0;
		$pagination=$this->pagination->create_links();
		if(!$this->memcached_library->get($pattern.$row) && $this->memcached_library->get($pattern.$row) == ''){
			$Result=$this->live_db->query($pattern." LIMIT ".$row.", 10")->result();
			$this->memcached_library->add($pattern.$row,$Result);
		}else{
			$Result = $this->memcached_library->get($pattern.$row);
		}
	}else{
		$Result	=[];
		$pagination='';
	}
?>
	<style>
		#shortsearch{width:65%;padding: 5px 6px 7px;}
	</style>
	<div class="col-md-12">
		<div class="form-group">
			<input class="adv_inputs" type="text" value="<?php print $term ?>" id="shortsearch" name="shortsearch">
			<button class="btn btn-primary adv_search_btn" onclick="short_search(0);">Search</button>
			<button class="btn btn-primary adv_search_btn" onclick="short_search(1);">Advance Search</button>
		</div>
		<!--<ul class="ascending" id="table_sorter"><li style="float:left;">Search results for <span class="active"><?php echo $term ?></span></li></ul>-->
		<?php if($term!=''): ?>
		<fieldset class="FieldTopic topic-ls"><legend class="topic"><?php echo $term ?></legend></fieldset>
		<?php endif; ?>
		<?php
			print '<table id="example" class="display result-section table" cellspacing="0" width="100%">';
			foreach($Result as $fetched):
					$publisheddate    = date('jS F Y', strtotime($fetched->publish_start_date));
					$u=image_url;
					$fetched->article_page_image_path=($fetched->article_page_image_path=='')?'logo/nie_logo_600X390.jpg':$fetched->article_page_image_path;
					$low='logo/nie_logo_600X390.jpg';
					$fetched->article_page_image_path = str_replace('/original','/w600X390',$fetched->article_page_image_path);
					
					print '<tr class="tr-topic">';
					print '<td><figure class="result-section-figure"><img src="'.$u.imagelibrary_image_path.$low.'" data-src="'.$u.imagelibrary_image_path.$fetched->article_page_image_path.'" class=""></figure></td>';
					print '<td><div class="search-row_type"><h4><a class="article_click" href="'.BASEURL.$fetched->url.'">'.strip_tags($fetched->title).'</a></h4><p>'.strip_tags($fetched->summary_html).'</p><date>published on : '.$publisheddate.'</date></div></td>';
					print '</tr>';
			endforeach;
			print '</table>';
			if(count($Result) == 0):
				print '<div class="search_count text-center"><p>Your search did not match any content</p></div>';
				
			endif;
		?>
		<div class="pagina"><?php echo $pagination; ?></div>
		<?php if($term!='' && count($Result) > 0): ?>
		<div class="pagina"><?php print '<button class="btn btn-primary adv_search_btn" onclick="short_search(1);">More from archive</button>'; ?></div>
		<?php endif; ?>
	</div>
	<script>
	function short_search(type){
		if($('#shortsearch').val()!=''){
			if(type==0){
				if($('#shortsearch').val().length < 3 ){
					alert('Please Enter more than 2 letters');
				}else{
					window.location.href=base_url+'topic?term='+$('#shortsearch').val()+'&request=ALL&search=short';
				}
				
			}
			if(type==1){
				window.location.href=base_url+'topic?term='+$('#shortsearch').val()+'&request=ALL&type=title&row_type=A&request=MIN';
			}
		}
	}
	</script>
	
	
<?php
}else{
$term=(isset($term) && $term!='')?$term:'';
$type=(isset($type) && $type!='')?$type:'';
$row_type=(isset($row_type) && $row_type!='')?$row_type:'';
$button='';
$widget_url=$content['widget_section_url'];

$tags=$this->uri->segment(2);
$tag_type=$this->uri->segment(3);
$tag_type=($tag_type!='')?$tag_type:'article';
?>
<style>
	.advance_search{
		margin-top:2%;
		text-align:center;
	}
	.advance_search label{
		width:20%;
	}
	.advance_search .adv_inputs{
		width:60%;
		padding:3px;
	}
	.adv_search_result{
		width:100%;
		float:left;
	}
	.error_search{
		padding-bottom: 7px;
		width: 100%;
		float: left;
		display:none;
		color:#f00;
	}
	.load_more_url{
		padding-right:4px;
		color:#666666;
	}
	
	.search-row_type p{
		margin-bottom:0px;
		font-size:13px;
		padding-top:3px;
	}
	.result-section-figure{
		width:130px;
		border:none;
	}
</style>
<?php if($tags==''): ?>
<div class="well advance_search">
	<div class="col-md-12 text-center">
		<span class="error_search"> * Enter a valid keyword</span>
	</div>
	<div class="form-group">
		<label>Key Words : </label>
		<input class="adv_inputs" type="text" value="<?php print $term; ?>" id="keyword" name="keyword" onkeypress="trigger_event(event)">
	</div>
	<div class="form-group">
		<label>Search By : </label>
		<select  class="adv_inputs" id="field" name="field">
			<option value="">Please Select</option>
			<option value="title" <?php if($type=='title'): print 'selected'; endif; ?> >Title</option>
			<option value="summary_html" <?php if($type=='summary_html'): print 'selected'; endif; ?> >Short Description</option>
			<option value="author_name" <?php if($type=='author_name'): print 'selected'; endif; ?>  >Author</option>
			<option value="agency_name" <?php if($type=='agency_name'): print 'selected'; endif; ?> >Agency</option>
		</select>
	</div>
	<div class="form-group">
		<label>Content Type : </label>
		<select  class="adv_inputs" id="type" name="type">
			<option value="">Please Select</option>
			<option value="A" <?php if($row_type=='A'): print 'selected'; endif; ?>>Article</option>
			<option value="V" <?php if($row_type=='V'): print 'selected'; endif; ?>>Video</option>
			<option value="G" <?php if($row_type=='G'): print 'selected'; endif; ?>>Gallery</option>
		</select>
	</div>
	<div class="form-group">
		<button class="btn btn-primary adv_search_btn" onclick="adv_search();">Search</button>
	</div>
</div>
<?php endif; ?>
<div class="adv_search_result">
	
	<?php
	$result=[];
	$pagination='';
	$this->live_db = $this->load->database('live_db', TRUE);
	$CI=&get_instance();
	$this->archive_db = $CI->load->database('archive_db', TRUE);
	
	if($this->input->get('request')==''){ $_GET['request'] = 'ALL'; }
	/*for keyword search*/
	if(isset($_GET['request']) && $_GET['request']=='ALL' && $term!=''):
	
		$pattern="SELECT title,url,article_page_image_path,summary_html,publish_start_date FROM article WHERE (title LIKE '%".$term."%' OR summary_html LIKE '%".$term."%' OR author_name LIKE '%".$term."%' OR agency_name LIKE '".$term."%') AND publish_start_date <=NOW() AND status='P' ORDER BY publish_start_date DESC";
		$check_query=@$_COOKIE['end'];
		if($check_query==base64_encode($pattern)){
			$query_count=@$_COOKIE['end_count'];
		}else{
			if(!$this->memcached_library->get($pattern) && $this->memcached_library->get($pattern) == ''){
				$query=$this->live_db->query($pattern);
				$query_count=$query->num_rows();
				$this->memcached_library->add($pattern,$query_count);
			}else{
				$query_count = $this->memcached_library->get($pattern);
			}
			setcookie('end', base64_encode($pattern),time() + (60 * 15));
			setcookie('end_count',$query_count,time() + (60 * 15));
		}
		
		$check_archive=@$_COOKIE['archive_'.$term];
		if($check_archive==''){
			$hasarchive['archive_result']=[];
			$range=range(2009,date('Y'));
			foreach($range as $ranger):
				$table='article_'.$ranger;
				if($this->archive_db->table_exists($table)){
					$archive_pattern="SELECT title,url,article_page_image_path,summary_html FROM ".$table." WHERE (title LIKE '%".$term."%' OR summary_html LIKE '%".$term."%' OR author_name LIKE '%".$term."%' OR agency_name LIKE '%".$term."%') AND publish_start_date <=NOW() AND status='P'";					
					if(!$this->memcached_library->get($archive_pattern) && $this->memcached_library->get($archive_pattern) == ''){
						$temp_query=$this->archive_db->query($archive_pattern);
						$archivecount1 = $temp_query->num_rows();
						$this->memcached_library->add($archive_pattern,$archivecount1);
					}else{
						$archivecount1 = $this->memcached_library->get($archive_pattern);
					}
					$data['table']=$table;
					$data['count']=$archivecount1;
					if($archivecount1!=0):
						$hasarchive['archive_result'][]=$data;
					endif;
				}
			endforeach;
			setcookie('archive_'.$term,json_encode($hasarchive),time() + (60 * 15));
			$archivelist=$hasarchive;
		}else{
			$archivelist=json_decode($check_archive,true);
		}
		
		if(isset($_GET['archive']) && $_GET['archive']==true && $_GET['year']!=''){
			$archive_count=array_reverse($archivelist['archive_result']);
			for($i=0;$i<count($archive_count);$i++){
				$y="article_".$_GET['year'];
				if(in_array($y,$archive_count[$i])){
					$archive_total=$archive_count[$i]['count'];
					$archive_tbl=$archive_count[$i]['table'];
					if($i < count($archive_count)-1){
						$nxt='<a href="'.$widget_url.'?term='.$term.'&request=ALL&archive=true&year='.str_replace('article_','',$archive_count[$i+1]['table']).'">More from '.str_replace('article_','',$archive_count[$i+1]['table']).'</a>';
					}
				}
			}
			$this->pagination->initialize(pager(['total_rows'=>$archive_total,'per_page'=>15,'base_url'=>$widget_url,'suffix'=>'&term='.$term.'&request=ALL&archive=true&year='.$_GET['year'],'first_url'=>$widget_url.'?term='.$term.'&request=ALL&archive=true&year='.$_GET['year']]));
			$row=(isset($_GET['per_page']) && $_GET['per_page'])?$_GET['per_page']:0;
			$pagination=$this->pagination->create_links();
			
			$pattern_archive="SELECT title,url,article_page_image_path,summary_html,publish_start_date FROM ".$archive_tbl." WHERE (title LIKE '%".$term."%' OR summary_html LIKE '%".$term."%' OR author_name LIKE '%".$term."%' OR agency_name LIKE '%".$term."%') AND publish_start_date <=NOW() AND status='P'";
			if(!$this->memcached_library->get($pattern_archive.$row) && $this->memcached_library->get($pattern_archive.$row) == ''){
				$Result = $this->archive_db->query($pattern_archive." LIMIT ".$row.", 15")->result();
				$this->memcached_library->add($pattern_archive.$row,$Result);
			}else{
				$Result = $this->memcached_library->get($pattern_archive.$row);
			}
			$LastPage = floor(($_GET['per_page']/15) + 1);
			$queryLastPage=ceil($archive_total/15);
			if($LastPage==$queryLastPage):
				$button=$nxt;
			endif;
			$loadmore='';
			$arc=array_reverse($archivelist['archive_result']);
			if(count($arc) !=0){
					$loadmore .=' <a class ="load_more_url" href="'.$widget_url.'?term='.$term.'&request=ALL">Latest</a>';
					for($a=0;$a<count($arc);$a++){
						$load_year=str_replace('article_','',$arc[$a]['table']);
						if($load_year!=$_GET['year']):
							$load_url=$widget_url.'?term='.$term.'&request=ALL&archive=true&year='.$load_year;
							$loadmore .=' <a class="load_more_url" href="'.$load_url.'">'.$load_year.'</a>';
						else:
							$loadmore .=' <a class ="load_more_url" style="color:#EA8E1A;">'.$load_year.'</a>';
						endif;
					}
			}
			
			
		}else{
			$this->pagination->initialize(pager(['total_rows'=>$query_count,'per_page'=>15,'base_url'=>$widget_url,'suffix'=>'&term='.$term.'&request=ALL','first_url'=>$widget_url.'?term='.$term.'&request=ALL']));
			$row=(isset($_GET['per_page']) && $_GET['per_page'])?$_GET['per_page']:0;
			$pagination=$this->pagination->create_links();
			$cookie_result=@$_COOKIE['NORMAL_'.$row.'_'.$term];
			if(!$this->memcached_library->get($pattern.'live'.$row) && $this->memcached_library->get($pattern.'live'.$row) == ''){
				$Result=$this->live_db->query($pattern." LIMIT ".$row.", 15")->result();
				$this->memcached_library->add($pattern.'live'.$row,$Result);
			}else{
				$Result = $this->memcached_library->get($pattern.'live'.$row);
			}
			$LastPage = floor(($_GET['per_page']/15) + 1);
			$queryLastPage=ceil($query_count/15);
			$arc=array_reverse($archivelist['archive_result']);
			if($LastPage==$queryLastPage):
				if(count($arc) !=0){
					$button='<a href="'.$widget_url.'?term='.$term.'&request=ALL&archive=true&year='.str_replace('article_','',$arc[0]['table']).'">More from '.str_replace('article_','',$arc[0]['table']).'</a>';
				}
			endif;
			$loadmore='';
			if(count($arc) !=0){
					$loadmore='';
					$loadmore .=' <a class ="load_more_url" style="color:#EA8E1A;">Latest</a>';
					for($a=0;$a<count($arc);$a++){
						$load_year=str_replace('article_','',$arc[$a]['table']);
						$load_url=$widget_url.'?term='.$term.'&request=ALL&archive=true&year='.$load_year;
						$loadmore .=' <a class="load_more_url" href="'.$load_url.'">'.$load_year.'</a>';
					}
			}
		}
	endif;
	/*end*/
	
	if(isset($_GET['request']) && $_GET['request']=='MIN' && $term!=''):
		if($type==''){
			if($row_type=='G'):
				$type_query=" (title LIKE '%".$term."%' OR summary_html LIKE '%".$term."%' OR agency_name LIKE '%".$term."%')";
			else:
				$type_query=" (title LIKE '%".$term."%' OR summary_html LIKE '%".$term."%' OR author_name LIKE '%".$term."%' OR agency_name LIKE '%".$term."%')";
			endif;
		}else{
			$type_query=" ".$type." LIKE '%".$term."%'";
		}
		switch($row_type){
			case 'A':
				$live_db='article';
				$archive_db_new='article_'.$_GET['year'];
				$image_path='article_page_image_path';
			break;
			case 'V':
				$live_db='video';
				$archive_db_new='video_'.$_GET['year'];
				$image_path='video_image_path';
			break;
			case 'G':
				$live_db='gallery';
				$archive_db_new='gallery_'.$_GET['year'];
				$image_path='first_image_path';
			break;
			default:
				$live_db='article';
				$archive_db_new='article_'.$_GET['year'];
				$image_path='article_page_image_path';
			break;
		}
		
		$pattern="SELECT title,url,".$image_path." as article_page_image_path,summary_html,publish_start_date FROM ".$live_db." WHERE ".$type_query." AND publish_start_date <=NOW() AND status='P' ORDER BY publish_start_date DESC";
		$check_query=(isset($_COOKIE['end_min']) && $_COOKIE['end_min']!='') ? $_COOKIE['end_min'] : '';
		if($check_query==base64_encode($pattern)){
			$query_count=@$_COOKIE['end_count_min'];
		}else{		
			if(!$this->memcached_library->get($pattern.'livecount') && $this->memcached_library->get($pattern.'livecount') == ''){
				$query=$this->live_db->query($pattern);
				$query_count=$query->num_rows();
				$this->memcached_library->add($pattern.'livecount',$query_count);
			}else{
				$query_count = $this->memcached_library->get($pattern.'livecount');
			}
			setcookie('end_min', base64_encode($pattern),time() + (60 * 15));
			setcookie('end_count_min',$query_count,time() + (60 * 15));
		}
		
		$check_archive=@$_COOKIE['archive_min_'.$live_db.'_'.$term];
		if($check_archive==''){
			$hasarchive['archive_result']=[];
			$range=range(2009,date('Y'));
			foreach($range as $ranger):
				$table=$live_db.'_'.$ranger;
				if($this->archive_db->table_exists($table)){
					$archive_pattern="SELECT title,url,".$image_path." as article_page_image_path ,summary_html FROM ".$table." WHERE ".$type_query." AND publish_start_date <=NOW() AND status='P' ORDER BY publish_start_date DESC";
					if(!$this->memcached_library->get($archive_pattern.'archive1') && $this->memcached_library->get($archive_pattern.'archive1') == ''){
						$temp_query=$this->archive_db->query($archive_pattern);
						$archivecount2 = $temp_query->num_rows();
						$this->memcached_library->add($archive_pattern.'archive1',$archivecount2);
					}else{
						$archivecount2 = $this->memcached_library->get($archive_pattern.'archive1');
					}
					$data['table']=$table;
					$data['count']=$archivecount2;
					if($archivecount2!=0):
						$hasarchive['archive_result'][]=$data;
					endif;
				}
			endforeach;
			setcookie('archive_min_'.$live_db.'_'.$term,json_encode($hasarchive),time() + (60 * 15));
			$archivelist=$hasarchive;
		}else{
			$archivelist=json_decode($check_archive,true);
		}
		
		if(isset($_GET['archive']) && $_GET['archive']==true && $_GET['year']!=''){
			$archive_count=array_reverse($archivelist['archive_result']);
			for($i=0;$i<count($archive_count);$i++){
				$y=$live_db."_".$_GET['year'];
				if(in_array($y,$archive_count[$i])){
					$archive_total=$archive_count[$i]['count'];
					$archive_tbl=$archive_count[$i]['table'];
					if($i < count($archive_count)-1){
						$nxt='<a href="'.$widget_url.'?term='.$term.'&type='.$type.'&row_type='.$row_type.'&request=MIN&archive=true&year='.str_replace(array('article_','video_','gallery_'),'',$archive_count[$i+1]['table']).'">More from '.str_replace(array('article_','video_','gallery_'),'',$archive_count[$i+1]['table']).'</a>';
					}
				}
			}
			$this->pagination->initialize(pager(['total_rows'=>$archive_total,'per_page'=>15,'base_url'=>$widget_url,'suffix'=>'&term='.$term.'&request=MIN&type='.$type.'&row_type='.$row_type.'&archive=true&year='.$_GET['year'],'first_url'=>$widget_url.'?term='.$term.'&request=MIN&type='.$type.'&row_type='.$row_type.'&archive=true&year='.$_GET['year']]));
			$row=(isset($_GET['per_page']) && $_GET['per_page'])?$_GET['per_page']:0;
			$pagination=$this->pagination->create_links();
			
			$pattern_arc="SELECT title,url,".$image_path." as article_page_image_path ,summary_html,publish_start_date FROM ".$archive_db_new." WHERE ".$type_query." AND publish_start_date < NOW() AND status='P' ORDER BY publish_start_date DESC";
			if(!$this->memcached_library->get($pattern_arc.'arc2'.$row) && $this->memcached_library->get($pattern_arc.'arc2'.$row) == ''){
				$Result=$this->archive_db->query($pattern_arc." LIMIT ".$row.", 15")->result();
				$this->memcached_library->add($pattern_arc.'arc2'.$row,$Result);
			}else{
				$Result = $this->memcached_library->get($pattern_arc.'arc2'.$row);
			}
			$LastPage = floor(($_GET['per_page']/15) + 1);
			$queryLastPage=ceil($archive_total/15);
			if($LastPage==$queryLastPage):
				$button=$nxt;
			endif;
			$arc=array_reverse($archivelist['archive_result']);
			if(count($arc) !=0){
					$loadmore='';
					$loadmore .=' <a class ="load_more_url" href="'.$widget_url.'?term='.$term.'&request=MIN&type='.$type.'&row_type='.$row_type.'">Latest</a>';
					for($a=0;$a<count($arc);$a++){
						$load_year=str_replace(array('article_','video_','gallery_'),'',$arc[$a]['table']);
						if($load_year!=$_GET['year']):
							$load_url=$widget_url.'?term='.$term.'&request=MIN&archive=true&year='.$load_year.'&type='.$type.'&row_type='.$row_type;
							$loadmore .=' <a class="load_more_url" href="'.$load_url.'">'.$load_year.'</a>';
						else:
							$loadmore .=' <a class ="load_more_url" style="color:#EA8E1A;">'.$load_year.'</a>';
						endif;
					}
			}
			
			
		}else{
			$this->pagination->initialize(pager(['total_rows'=>$query_count,'per_page'=>15,'base_url'=>$widget_url,'suffix'=>'&term='.$term.'&request=MIN&type='.$type.'&row_type='.$row_type,'first_url'=>$widget_url.'?term='.$term.'&request=MIN&type='.$type.'&row_type='.$row_type]));
			$row=(isset($_GET['per_page']) && $_GET['per_page'])?$_GET['per_page']:0;
			$pagination=$this->pagination->create_links();
			if(!$this->memcached_library->get($pattern.'liveminarticle'.$row) && $this->memcached_library->get($pattern.'liveminarticle'.$row) == ''){
				$Result=$this->live_db->query($pattern." LIMIT ".$row.", 15")->result();
				$this->memcached_library->add($pattern.'liveminarticle'.$row,$Result);
			}else{
				$Result = $this->memcached_library->get($pattern.'liveminarticle'.$row);
			}
			$LastPage = floor(($_GET['per_page']/15) + 1);
			$queryLastPage=ceil($query_count/15);
			$arc=array_reverse($archivelist['archive_result']);
			if($LastPage==$queryLastPage):
				
				if(count($arc) !=0){
					$button='<a href="'.$widget_url.'?term='.$term.'&request=MIN&type='.$type.'&row_type='.$row_type.'&archive=true&year='.str_replace(array('article_','video_','gallery_'),'',$arc[0]['table']).'">More from '.str_replace(array('article_','video_','gallery_'),'',$arc[0]['table']).'</a>';
				}
			endif;
			$loadmore='';
			if(count($arc) !=0){
					$loadmore .=' <a class ="load_more_url" style="color:#EA8E1A;">Latest</a>';
					for($a=0;$a<count($arc);$a++){
						$load_year=str_replace(array('article_','video_','gallery_'),'',$arc[$a]['table']);
						$load_url=$widget_url.'?term='.$term.'&request=MIN&archive=true&year='.$load_year.'&type='.$type.'&row_type='.$row_type;
						$loadmore .=' <a class="load_more_url" href="'.$load_url.'">'.$load_year.'</a>';
					}
			}
			
		}
		
	endif;
	
	if($tags!=''){
		$image_col=' article_page_image_path ';
		if($tag_type=='article'){ $image_col=' article_page_image_path '; }
		if($tag_type=='video'){ $image_col='video_image_path'; }
		if($tag_type=='gallery'){ $image_col='first_image_path'; }
		$cookie_tag='';
		if(isset($_COOKIE['tag_'.$tag_type.str_replace(' ','_',$tags)])){
			$cookie_tag=@$_COOKIE['tag_'.$tag_type.str_replace(' ','_',$tags)];
		}
		$tag_query="SELECT title,url," .$image_col. " as article_page_image_path ,summary_html,publish_start_date FROM ".$tag_type." WHERE tags LIKE '%".$tags."%' AND publish_start_date < NOW() AND status='P' ORDER BY publish_start_date DESC";
		if($cookie_tag==base64_encode($tag_query)){
			$total_count=@$_COOKIE['tag_end_count'];
		}else{			
			if(!$this->memcached_library->get($tag_query.'tagcount') && $this->memcached_library->get($tag_query.'tagcount') == ''){
				$total_count=$this->live_db->query($tag_query)->num_rows();
				$this->memcached_library->add($tag_query.'tagcount',$total_count);
			}else{
				$total_count = $this->memcached_library->get($tag_query.'tagcount');
			}
			setcookie('tag_', base64_encode($tag_query),time() + (60 * 15));
			setcookie('tag_end_count',$total_count,time() + (60 * 15));
		}
		if($tags=='Commonwealth Games' || $tags=='Chess'){
			$this->pagination->initialize(pager(['total_rows'=>$total_count,'per_page'=>20,'base_url'=>$widget_url,'suffix'=>'','first_url'=>$widget_url]));
		}else{
			$this->pagination->initialize(pager(['total_rows'=>$total_count,'per_page'=>20,'base_url'=>$widget_url,'suffix'=>'','first_url'=>$widget_url]));	
		}
		$row=(isset($_GET['per_page']) && $_GET['per_page'])?$_GET['per_page']:0;
		$pagination=$this->pagination->create_links();
		if(!$this->memcached_library->get($tag_query.'tagresult1'.$row) && $this->memcached_library->get($tag_query.'tagresult1'.$row) == ''){
			if($tags=='Commonwealth Games' || $tags=='Chess'){
				$Result=$this->live_db->query($tag_query." LIMIT ".$row.", 20")->result();
			}else{
				$Result=$this->live_db->query($tag_query." LIMIT ".$row.", 20")->result();
			}
			$this->memcached_library->add($tag_query.'tagresult1'.$row,$Result);
		}else{
			$Result = $this->memcached_library->get($tag_query.'tagresult1'.$row);
		}
		
	}

	if(count($Result) > 0):
		$title_type ='';
		if($term=='') { $title= str_replace('_',' ',$this->uri->segment(2)); $title_type='Tag';} else { $title= $term ; $title_type='Search';}
		if($title_type=='Tag' && ($title=='Commonwealth Games' || $title=='Chess')){
			if($title == 'Commonwealth Games'){
				echo '<picture>';
					echo '<source media="(max-width:650px)" srcset="https://images.newindianexpress.com/images/static_img/commonwealth_games_mobile.jpg">';
					echo '<img src="https://images.newindianexpress.com/images/static_img/commonwealth_games_2022_600x100.jpg" alt="Commonwealth Games" title="Commonwealth Games" style="margin-bottom: 10px;">';
				echo '</picture>';
			}
			elseif($title == 'Chess'){
				echo '<picture>';
					echo '<source media="(max-width:650px)" srcset="https://images.newindianexpress.com/images/static_img/chess_olympiad_mobile.jpg">';
					echo '<img src="https://images.newindianexpress.com/images/static_img/chess_olympiad_600x100.jpg" alt="Chess Olympaid" title="Chess Olympaid" style="margin-bottom: 10px;">';
				echo '</picture>';
			}
		}else{
			echo '<fieldset class="FieldTopic topic-ls"><legend class="topic">'.$title.'</legend></fieldset>';
		}
		
		/* if($title_type=='Tag'){
			echo '<fieldset class="FieldTopic topic-ls"><legend class="topic">'.$title.'</legend></fieldset>';
		}else{
			print '<ul class="ascending" id="table_sorter"><li style="float:left;">'.$title_type.' results for <span class="active">'. $title .'</span></li></ul>';
		} */
	endif;
	if($title_type=='Tag' && ($title=='Commonwealth Games' || $title=='Chess')){
		print '<div class="row"><div class="SundaySecond col-lg-12">';
	}else{
		print '<table id="example" class="display result-section '.(($title_type=='Tag') ? ' table ' : '').'" cellspacing="0" width="100%">';
	}
	$rowCount = 1;
	foreach($Result as $fetched):
			$publisheddate    = date('jS F Y', strtotime($fetched->publish_start_date));
			$u=image_url;
			$fetched->article_page_image_path=($fetched->article_page_image_path=='')?'logo/nie_logo_600X390.jpg':$fetched->article_page_image_path;
			$low='logo/nie_logo_600X390.jpg';
			if($title_type=='Tag' && ($title=='Commonwealth Games' || $title=='Chess')){
				if($rowCount==1){
					print '<div class="WidthFloat_L">';
				}
				if($rowCount < 3){
					print '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 SundaySecondSplit">
						<div class="first-wrapper-inner">
							<a href="'.BASEURL.$fetched->url.'" target="_blank">
								<img src="'.$u.imagelibrary_image_path.$low.'" data-src="'.str_replace('/original','/w600X390' , $u.imagelibrary_image_path.$fetched->article_page_image_path).'" style="width: 100%;">
								<h4>'.strip_tags($fetched->title).'</h4>
								<date>published on : '.$publisheddate.'</date>
							</a>
						</div>	
					</div>';
				}
				if($rowCount==3){
					print '<div class="WidthFloat_L">';
				}
				if($rowCount >= 3 && $rowCount <= 5){
					print '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 SundaySecondSplit">
						<div class="second-wrapper-inner">
							<a href="'.BASEURL.$fetched->url.'" target="_blank">
								<img src="'.$u.imagelibrary_image_path.$low.'" data-src="'.str_replace('/original','/w600X390' , $u.imagelibrary_image_path.$fetched->article_page_image_path).'" style="width: 100%;">
								<p>'.strip_tags($fetched->title).'</p>
							</a>
						</div>	
					</div>';
				}
				if($rowCount==2){
					print '</div>';
				}
				if($rowCount==5){
					print '</div>';
					$rowCount = 3;
				}else{
					$rowCount++;
				}
				
			}else{
				print '<tr class="tr-topic">';
				print '<td><figure class="result-section-figure"><img src="'.$u.imagelibrary_image_path.$low.'" data-src="'.str_replace('/original','/w600X390' , $u.imagelibrary_image_path.$fetched->article_page_image_path).'" class=""></figure></td>';
				print '<td><div class="search-row_type"><h4><a class="article_click" href="'.BASEURL.$fetched->url.'">'.strip_tags($fetched->title).'</a></h4><p>'.strip_tags($fetched->summary_html).'</p><date>published on : '.$publisheddate.'</date></div></td>';
				print '</tr>';

			}
	endforeach;
	if($title_type=='Tag'  && ($title=='Commonwealth Games' || $title=='Chess')){
		if($rowCount!=3){
			print '</div>';
		}
		print '</div></div>';
	}else{
		print '</table>';
	}
	
	if(count($Result) == 0  && count($_GET) > 0):
		print '<div class="search_count text-center"><p>Your search did not match any content In Live</p></div>';
	endif;
	print '<div class="pagina">'.$pagination.$button.'</div>';
	if($tags==''):
		print '<div class="search_count" style="margin-top:5px;text-align:center;"><p><span>More from  :</span>'.$loadmore.'</p></div>';
	endif;
	
	?>
</div>
<script>
function adv_search(){
	var keyword,search_by,row_type_type,url;
	keyword=$('#keyword').val().trim().replace(/[^a-zA-Z ]/g, "");
	search_by=$('#field').val().trim();
	row_type_type=$('#type').val().trim();
	if(keyword==''){
		$('.error_search').show().html(' * Enter a valid keyword');
	}else if(keyword.length < 3){
		$('.error_search').show().html(' * Please Enter more than 2 letters');
	}else{
		if(keyword!='' && search_by=='' && row_type_type==''){
			url='<?php print $widget_url ?>?term='+keyword+'&request=ALL';
		}else{
			url='<?php print $widget_url ?>?term='+keyword+'&type='+search_by+'&row_type='+row_type_type+'&request=MIN';
		}
		window.location.href=url;
	}
	
}
function trigger_event(e){
	if(e.keyCode === 13){
       e.preventDefault();
       $('.adv_search_btn').trigger('click');
    }
}
</script>
<?php } ?>