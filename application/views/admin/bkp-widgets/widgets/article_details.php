<article class="WidthFloat_L printthis">
<?php
					$widget_instance_id =  $content['widget_values']['data-widgetinstanceid'];
				    $content_id= $content['content_id'];
					$content_type_id = $content['content_type'];
					if($content_id!=''){
										 
					if($content['content_from'] =="live"){
					//$content_details = $this->widget_model->widget_article_content_by_id($content_id, $content_type_id, ""); from live
					$content_details = $content['detail_content'];   // from Template Controller
					}else if($content['content_from']=="archive"){
		            $content_details = $content['detail_content'];
					}
					$content_det= $content_details[0];
					
					$section_id = $content_det['section_id'];
					
					//print_r($content_det);exit;
					$domain_name =  base_url();
					$home_section_name  = 'Home';
					$child_section_name = $content_det['section_name'];
					
					$content_url = $content_det['url'];
					$url_array = explode('/', $content_url);
					$get_seperation_count = count($url_array)-5;
										
					$child_section_url = $domain_name.$url_array[0];
					$sub_section_name = 'Home';
					if($content_det['parent_section_id']!=''&& $content_det['parent_section_id']!=0 ){
					$parent_section_name= ($content_det['parent_section_name']!='')? $content_det['parent_section_name'] : '' ;
					$parent_section_url = $domain_name.$url_array[0];
					$child_section_url = $domain_name.$url_array[0]."/".$url_array[1];
                    if($content_det['grant_section_id']!=''&& $content_det['grant_section_id']!=0 ){
					$grand_parent_section_name = $content_det['grant_parent_section_name'];
					$grand_parent_section_url = $domain_name.$url_array[0];
					$parent_section_url = $domain_name.$url_array[0]."/".$url_array[1];
					$child_section_url = $domain_name.$url_array[0]."/".$url_array[1]."/".$url_array[2];
					$section_link = '<a href="'.$domain_name.'">'.$home_section_name.'</a> <i class="fa fa-angle-right"></i> <a href="'.$grand_parent_section_url.'">'.$grand_parent_section_name.'</a> <i class="fa fa-angle-right"></i> <a href="'.$parent_section_url.'">'.$parent_section_name.'</a> <i class="fa fa-angle-right"></i> <a href="'.$child_section_url.'">'.$child_section_name.'</a>';
					}else{
					$section_link = '<a href="'.$domain_name.'" >'.$home_section_name.'</a> <i class="fa fa-angle-right"></i> <a href="'.$parent_section_url.'">'.$parent_section_name.'</a> <i class="fa fa-angle-right"></i> <a href="'.$child_section_url.'">'.$child_section_name.'</a>';
					}
					}else{
					$section_link = '<a href="'.$domain_name.'">'.$home_section_name.'</a> <i class="fa fa-angle-right"></i> <a href="'.$child_section_url.'">'.$child_section_name.'</a>';
					}
				  echo '<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
				  echo '<div class="bcrums"> 
				   '.$section_link.'  </div>
				  </div>
				  </div>';
				  ?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ArticleDetail">
    <?php 		
					//////  For Article title  ////		
					$content_title = $content_det['title'];
					if( $content_title != '')
					{
						$content_title = stripslashes(preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $content_title));
					}
					else
					{
						$content_title = '';
					}
                    $content_url = '';
					$page_index_number = '';
					if($content_type_id ==1){	
					$linked_to_columnist = $content_det['author_name'];
					$author_name    = $content_det['author_name'];
					$agency_name    = $content_det['agency_name'];
					$is_author      = ($content_det['author_name']!='')? 1 : 0;
					$is_agency      = ($content_det['agency_name']!='')? 1 : 0;
					$author_pos     = stripos($child_section_name, $author_name);
				    $author_url     = ($author_pos === false)? "author/".join("-", explode(" ", $author_name)) : "columns/".join("-", explode(" ", $author_name));
					}else{
					$is_author      = 0;
					$is_agency      = ($content_det['agency_name']!='')? 1 : 0;
					$author_name    = '';
					$agency_name    = $content_det['agency_name'];
					}
					
				   $published_date = date('dS  F Y h:i A' , strtotime($content_det['publish_start_date']));
				   $last_updated_date  = date('dS  F Y h:i A' , strtotime($content_det['last_updated_on']));
				   $allow_social_btn= 1; //$content_det['allow_social_button'];
				   $allow_comments= $content_det['allow_comments'];
				
				   $email_shared = 0; //$content_det['emailed'];
				   if ($email_shared > 999 && $email_shared <= 999999) {
					$email_shared = round($email_shared / 1000, 1).'K';
				   } else if ($email_shared > 999999) {
				   $email_shared = round($email_shared / 1000000, 1).'M';
				   } else {
					$email_shared = $email_shared;
				   }
				   $publish_start_date = $content_det['publish_start_date'];
					?>
    <h1 class="ArticleHead" id="content_head" itemprop="name"><?php echo $content_title;?></h1>
    <p class="ArticlePublish">
      <?php if($is_author==1 && $is_agency==1){ ?>
      By <span><a href="<?php echo base_url().$author_url;?>" target="_blank"><?php echo $author_name;?></a></span>&nbsp;&nbsp;|&nbsp;&nbsp;<span><?php echo $agency_name;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
      <?php }else if($author_name!=''){ ?>
      By <span><a href="<?php echo base_url().$author_url;?>" target="_blank"><?php echo $author_name;?></a></span>&nbsp;&nbsp;|&nbsp;&nbsp;
      <?php }else if($agency_name!=''){ ?>
       By <span><?php echo $agency_name;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
      <?php } ?>
      Published: <span><?php echo $published_date;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
      <?php  if($content_type_id!= 1){ ?>
      Last Updated: <span><?php echo $last_updated_date;?></span>&nbsp;&nbsp;
    <p></p>
    <?php  } ?>
    </p>
    <?php  if($content_type_id=='1'){ ?>
    <p class="ArticlePublish margin-bottom-10"> Last Updated: <span><?php echo $last_updated_date;?></span>&nbsp;&nbsp;|&nbsp;&nbsp; <span class="FontSize" id="incfont" data-toggle="tooltip" title="Zoom In">A+</span><span class="FontSize" id="resetMe" data-toggle="tooltip" title="Reset">A&nbsp;</span><span class="FontSize" id="decfont" data-toggle="tooltip" title="Zoom Out">A-</span> <span id="print_article">&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-print"></i></span></p>
    <?php } ?>
    <?php if($allow_social_btn==1) { ?>
    <div class="Social_Fonts FixedOptions" style="display:none;">
      <div class="PrintSocial" style="visibility:hidden;"> <span class="Share_Icons PositionRelative"><i class="fa fa-envelope-o fa_social" id="popoverId"></i><span class="csbuttons-count"><?php echo $email_shared;?></span></span> <span class="Share_Icons"><a href="javascript:;" class="csbuttons" data-type="twitter" data-txt="<?php echo strip_tags($content_title);?>" data-via="New Indian Express" data-count="true"><i class="fa fa-twitter fa_social"></i></a></span> <span  class="Share_Icons"><a href="javascript:;" class="csbuttons" data-type="facebook" data-count="true"><i class="fa fa-facebook fa_social"></i></a></span> <span class="Share_Icons"><a href="javascript:;" class="csbuttons" data-type="google" data-lang="en" data-count="true"><i class="fa fa-google-plus fa_social"></i></a></span>
        <div id="popover-content" class="popover_mail_form fade right in ">
          <div class="arrow"></div>
          <h3 class="popover-title">Share Via Email</h3>
          <div class="popover-content">
            <form class="form-inline Mail_Tooltip" action="<?php echo base_url(); ?>user/commonwidget/share_article_via_email" name="mail_share" method="post" id="mail_share" role="form">
              <div class="form-group">
                <input type="text" placeholder="Name" name="sender_name" id="name" class="form-control">
                <input type="text" placeholder="Your Mail" name="share_email" id="share_email" class="form-control">
                <input type="text" placeholder="Friends's Mail" name="refer_email" id="refer_email" class="form-control">
                <textarea placeholder="Type your Message" class="form-control" name="message" id="message"></textarea>
                <input type="hidden"  class="content_id" name="content_id" value="<?php echo $content_id;?>" />
                <input type="hidden"  class="section_id" name="section_id" value="<?php echo $section_id;?>" />
                <input type="hidden"  class="content_type_id" name="content_type_id" value="<?php echo $content_type_id;?>" />
                <input type="hidden"  class="article_created_on" name="article_created_on" value="<?php echo $publish_start_date;?>" />
                <input type="reset" value="Reset" class="submit_to_email submit_post">
                <!--<input type="submit" value="share" class="submit_to_email submit_post" name="submit">-->
                <input type="button" value="Share" id="share_submit" class="submit_to_email submit_post" onclick="mail_form_validate();" name="submit">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php  } ?>
  </div>
</div>
<?php
	  
	/* ------------------------------------- Article content Type --------------------------------------------*/	
				  
	if($content_type_id=='1'){
	
	$article_body_text =  stripslashes($content_det['article_page_content_html']);	
	
	$Image600X390=$content_det['article_page_image_path'];
	
	if (getimagesize(image_url . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
	{
	$imagedetails = getimagesize(destination_base_path . imagelibrary_image_path.$content_det['article_page_image_path']);
	$imagewidth = $imagedetails[0];
	$imageheight = $imagedetails[1];
	
	if ($imageheight > $imagewidth)
	{
		$Image600X390 	= $content_det['article_page_image_path'];
	}
	else
	{				
		$Image600X390 	= str_replace("original","w600X390", $content_det['article_page_image_path']);
	}
	$image_path='';
	
		$image_path = image_url. imagelibrary_image_path . $Image600X390;
		
	}
	else{
	$image_path='';
	$image_caption='';	
	}
	$show_image = ($image_path != '') ? $image_path : "no_image";
	$image_caption= $content_det['article_page_image_title'];
	$image_alt =  $content_det['article_page_image_alt'];
	$content_url       = base_url().$content_det['url'];
	$page_index_number = ($content_det['allow_pagination']==1)? $content['image_number'] : "no_pagination";
	?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ArticleDetail ArticleDetailContent">
  <div id="content" class="content" itemprop="description">
    <?php if($show_image!='no_image'){ ?>
    <figure class="AticleImg">
      <div class="image-Zoomin"><i class="fa fa-search-plus"></i><i class="fa fa-search-minus"></i></div>
      <img src="<?php echo $show_image;?>" title="<?php echo $image_caption;?>" alt="<?php echo $image_alt;?>" itemprop="image">
      <?php if($image_caption!=''){ ?>
      <p class="AticleImgBottom"><?php echo strip_tags($image_caption);?></p>
      <?php } ?>
    </figure>
    <?php } ?>
     <div id="storyContent">
    <?php echo $article_body_text; ?> 
    </div>
    </div>
  <?php 
	  if($content['content_from']=="live"){
	 $Related_article_content = $this->widget_model->get_related_article_by_contentid($content_id, $content['content_from']);
	 if(count($Related_article_content)>0){
	 ?>
  <ul class="RelatedArticle" style="display:none;">
    <div class="RelatedArt">Related Article</div>
    <?php foreach ($Related_article_content as $get_article){
		$relatedarticle_title = strip_tags($get_article['related_articletitle']);
		$related_url          = $get_article['related_articleurl'];
		$param                = "?pm=".$content['page_param'];
		$domain_name          =  base_url();
		$related_article_url  = $domain_name.$related_url.$param;
		?>
    <li><a href="<?php echo $related_article_url;?>"  class="article_click" target="_blank"><i class="fa fa-angle-right"></i><?php echo $relatedarticle_title;?></a></li>
    <?php  } }?>
  </ul>
  <?php }elseif($content['content_from']=="archive"){
	 $live_query_string 	    = explode("/",$this->uri->uri_string());
	 $year                      = $live_query_string[count($live_query_string)-4];
	 $table                     = "relatedcontent_".$year;
	 $Related_article_content = $this->widget_model->get_related_article_from_archieve($content_id, $table);
	 if(count($Related_article_content)>0){
	 ?>
  <ul class="RelatedArticle" style="display:none;">
    <div class="RelatedArt">Related Article</div>
    <?php foreach ($Related_article_content as $get_article){
		$relatedarticle_title = strip_tags($get_article['related_articletitle']);
		$related_url          = $get_article['related_articleurl'];
		$param                = "?pm=".$content['page_param'];
		$domain_name          =  base_url();
		$related_article_url  = $domain_name.$related_url.$param;
		?>
    <li><a href="<?php echo $related_article_url;?>"  class="article_click" target="_blank"><i class="fa fa-angle-right"></i><?php echo $relatedarticle_title;?></a></li>
    <?php  } }?>
  </ul>
  <?php }
	  ?>
  <!--<div class="pagination pagina">
    <ul>
      <li><a href="javascript:;" id="prev" class="prevnext element-disabled">« Previous</a></li>
      <li><a href="javascript:;" id="next" class="prevnext">Next »</a></li>
    </ul>
    <br />
  </div>-->
  <div class="text-center">
  <ul class="article_pagination" id="article_pagination">
    </ul></div>
  <div id="keywordline"></div>
</div>
<?php }
	/* ------------------------------------- Gallery content Type --------------------------------------------*/	
else if($content_type_id=='3'){ 
$get_gallery_images	 = $content_details;
$image_number        = $content['image_number'];
$content_url         = base_url().$content_details[0]['url'];
$page_index_number   = $content['image_number'];
?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 features">
  <?php if(count($get_gallery_images)> 1){ ?>
  <div class="text-center play-pause-icon"> <span id="auto-play" class="cursor-pointer"><i class="fa fa-play" title="Play"></i> </span> </div>
  <?php } ?>
  <div class="slide GalleryDetail GalleryDetailSlide" style="width:100% !important">
    <?php foreach($get_gallery_images as $gallery_image){ 
				  
                  $gallery_caption = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $gallery_image['gallery_image_title']);
				  $gallery_alt =  $gallery_image['gallery_image_alt'];
				  $Image600X390= $gallery_image['gallery_image_path'];
				  if (getimagesize(image_url . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
					{
				  $imagedetails = getimagesize(destination_base_path . imagelibrary_image_path.$gallery_image['gallery_image_path']);
					$imagewidth = $imagedetails[0];
                    $imageheight = $imagedetails[1];
					if ($imageheight > $imagewidth)
					{
						$Image600X390 	= $gallery_image['gallery_image_path'];
						$is_verticle    = 'style="width:100%"';
					}else
					{				
						$Image600X390 	= str_replace("original","w600X390", $gallery_image['gallery_image_path']);
						$is_verticle    = '';
					}
						$show_gallery_image = image_url. imagelibrary_image_path . $Image600X390;
					}else{
						$show_gallery_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
						$is_verticle        = '';
					}
                  ?>
    <div class="item">
      <figure class="PositionRelative"> <img src="<?php echo $show_gallery_image;?>" title="<?php echo $gallery_caption;?>" alt="<?php echo $gallery_alt;?>" <?php echo $is_verticle;?>>
       <?php if($gallery_caption!=''){ ?>
        <div class="TransLarge Font14"><?php echo $gallery_caption;?></div>
         <?php } ?>
      </figure>
    </div>
    <?php 
					 } ?>
  </div>
  <?php if(count($get_gallery_images)> 1){ ?>
  <div class="text-center">
    <ul class="gallery_pagination" id="gallery_pagination">
    </ul>
  </div>
  <?php } ?>
    <script>
var currentimageIndex = "<?php echo (($image_number)> count($get_gallery_images))? 1: $image_number;  ?>";
var TotalIndex = "<?php echo (count($get_gallery_images));  ?>";
$( document ).ready(function() {
$('html').addClass('gallery_video_remodal');
<?php if(($image_number) > 1 ){ ?>
 $('.GalleryDetailSlide').slick('slickGoTo', <?php echo $image_number-1;?>);
<?php } ?>
});
</script>
  <div id="keywordline"></div>
</div>
<?php 
							}
						/* ------------------------------------- Video content Type --------------------------------------------*/	
							else if($content_type_id=='4')
							{    
							 $video_scipt       = htmlspecialchars_decode($content_det['video_script']);
							 $video_description = $content_det['summary_html'];
						?>
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="videodetail" style="text-align: center;">
    <?php if($content_det['video_site']=='ventunovideo'){ 
	//$video_scipt = trim(stripslashes($video_scipt),'"');
	?>
    <object width="630" height="441" id="ventuno_player_0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
      <param name="movie" value="http://cfplayer.ventunotech.com/player/vtn_player_2.swf?vID==<?php echo $video_scipt;?>"/>
      <param name="allowscriptaccess" value="always"/>
      <param name="allowFullScreen" value="true"/>
      <param name="wmode" value="transparent"/>
      <embed src="http://cfplayer.ventunotech.com/player/vtn_player_2.swf?vID==<?php echo $video_scipt;?>" width="630" height="441" 
wmode="transparent" allownetworking="all" allowscriptaccess="always" allowfullscreen="true"></embed>
    </object>
    <?php }else{
		echo $video_scipt;
	}
		 ?>
    <p> <?php echo $video_description;?></p>
  </div>
  <div id="keywordline"></div>
</div>
<script>
						 $( document ).ready(function() {
						 $('html').addClass('gallery_video_remodal');
						});
						</script>
<?php 
							}
					/* ------------------------------------- Audio content Type --------------------------------------------*/	
							else 
							{ 
							 $audio_path       = image_url. audio_source_path.$content_det['audio_path'];
							 $audio_description = $content_det['summary_html'];
							?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="GalleryDetail">
      <audio class="margin-left-10 margin-top-5" controls="" src="<?php echo $audio_path;?>"> </audio>
      <p> <?php echo $audio_description;?></p>
    </div>
    <div id="keywordline"></div>
  </div>
  <?php	}
}?>
  <?php 
			  $article_tags= $content_det['tags'];
              $get_tags =array();
			  if($article_tags!='')
			  $get_tags=  explode(",", $article_tags);
			  if(count($get_tags)>0){
			   ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ArticleDetail">
    <div class="tags">
      <div> <span>TAGS</span> </div>
      <?php foreach($get_tags as $tag){
				     $tag_title = join( "_",( explode(" ", trim($tag) ) ) );
		             $tag_url_title = preg_replace('/[^A-Za-z0-9\_]/', '', $tag_title); 

							$tag_link = base_url().'topic/'.$tag_url_title; 
                            echo '<a href="'.$tag_link.'">'.$tag.'</a>';
                            } ?>
    </div>
  </div>
  <?php }  ?>
</div>
</article>
<div class="NextArticle FixedOptions" style="display:none;">
  <?php
					//$time1 = microtime(true);
					$prev_article = $this->widget_model->get_section_previous_article($content['content_id'], $content_det['section_id'],$content_type_id);
					$next_article = $this->widget_model->get_section_next_article($content['content_id'], $content_det['section_id'],$content_type_id);
										
//$time2 = microtime(true);
//echo "script execution time: ".($time2-$time1); //value in seconds				

					//print_r($select_section_prev_article);exit;
					?>
  <?php if(count($prev_article)> 0){
					$prev_content_id = $prev_article['content_id'];
					$prev_section_id = $prev_article['section_id'];
					$param = $content['page_param'];
					$prev_string_value = $domain_name.$prev_article['url']."?pm=".$param;
	                 ?>
  <a class="prev_article_click LeftArrow" href="<?php echo $prev_string_value;?>" title="<?php echo strip_tags($prev_article['title']);?>"><i class="fa fa-chevron-left"></i></a>
  <?php } ?>
  <?php if(count($next_article)> 0){
					$next_content_id = $next_article['content_id'];
					$next_section_id = $next_article['section_id'];
					$param = $content['page_param'];
					$next_string_value = $domain_name.$next_article['url']."?pm=".$param;
					?>
  <a class="next_article_click RightArrow" href="<?php echo $next_string_value;?>" title="<?php echo strip_tags($next_article['title']);?>"><i class="fa fa-chevron-right"></i></a>
  <?php } ?>
</div>
<!--style overwriting editor body content-->
<style>
.ArticleDetailContent li{float: none; list-style: initial;}
.ArticleDetailContent blockquote {
    padding-left: 20px !important;
    padding-right: 8px !important;
    border-left-width: 5px;
    border-color: #ccc;
    font-style: italic;
	margin:10px 0 !important;
	padding: 12px 16px !important;
	font-size:13px !important;
}
.ArticleDetailContent blockquote p{font-size:13px !important;text-align:center;}
@media screen and ( max-width: 768px){
 audio { width:100%;}
}
</style>
<script type="text/javascript">
	var base_url        = "<?php echo base_url(); ?>";
	var content_id      = "<?php echo $content_id; ?>";
	var content_type_id = "<?php echo $content_type_id; ?>";
	var page_Indexid    = "<?php echo $page_index_number; ?>";
	var section_id      = "<?php echo $section_id; ?>";
	//location.reload(true);
	var content_url     = "<?php echo $content_url; ?>";
	var page_param      = "<?php echo $content['page_param']; ?>";
	var content_from    = "<?php echo $content['content_from']; ?>";
</script>
<div class="recent_news">
<div id="topover" class="slide-open" style="visibility: hidden;">
  <p>O<br>
    P<br>
    E<br>
    N</p>
</div>
</div>
<?php /*?><?php 
$recent_article = $this->widget_model->get_section_recent_article($content['content_id'], $content_det['section_id'],$content_type_id, $content['mode']);  
if(count($recent_article)> 0){ 
$recent_text = "Article";	
if($content_type_id=='3'){
$recent_text = "Gallery";	
$img_path = $recent_article['first_image_path']; 
$img_title = $recent_article['first_image_path']; 
$img_alt = $recent_article['first_image_alt']; 
}elseif($content_type_id=='4'){
$recent_text = "Video";
$img_path = $recent_article['video_image_path']; 
$img_title = $recent_article['video_image_title']; 
$img_alt = $recent_article['video_image_alt']; 
}elseif($content_type_id=='5'){
$recent_text = "Audio";
$img_path = $recent_article['audio_image_path']; 
$img_title = $recent_article['audio_image_title']; 
$img_alt = $recent_article['audio_image_alt']; 
}else{
$img_path = $recent_article['article_page_image_path']; 
$img_title = '';
$img_alt = '';
}

$recent_string_value = $domain_name.$recent_article['url']."?pm=".$content['page_param'];
if (getimagesize(image_url . imagelibrary_image_path . $img_path) && $img_path != '')
{
$recent_article_img = image_url. imagelibrary_image_path.$img_path;	
}else{
$recent_article_img = image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
}
?>
<div id="topover" class="slide-open" style="visibility: hidden;">
  <p>O<br>
    P<br>
    E<br>
    N</p>
</div>
<div id="slidebox" class="slide-box"> <i class="fa fa-times slide-close"></i>
  <h4 class="SiteColor article-recent">Recent <?php echo $recent_text;?> in <?php echo $content_det['section_name'];?></h4>
  <div class="slide-headlines"> <img src="<?php echo $recent_article_img; ?>" title="<?php echo $img_title;?>" alt="<?php echo $img_alt;?>" />
    <h4 class="subtopic"><a href="<?php echo $recent_string_value;?>"><?php echo $recent_article['title'];?></a></h4>
    <div class="slider-lead">
      <?php  echo substr($recent_article['summary_html'], 0, 150);?>
      <a href="<?php echo $recent_string_value;?>"><span class="arrows SiteColor">Read More <i class="fa fa-angle-double-right"></i> </span></a> </div>
  </div>
</div>
<?php } ?><?php */?>
<script src="<?php echo base_url(); ?>js/FrontEnd/js/remodal-article.js"></script>
<?php //echo "open me";exit;?>
