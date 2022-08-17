<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color 		= $content['widget_bg_color'];
$widget_custom_title 	= $content['widget_title'];
$widget_instance_id 	= $content['widget_values']['data-widgetinstanceid'];
$main_sction_id 		= "";
$is_home 				= $content['is_home_page'];
$is_summary_required 	= $content['widget_values']['cdata-showSummary'];
$widget_section_url 	= $content['widget_section_url'];
$view_mode           	= $content['mode'];
$max_article            = $content['show_max_article'];
$render_mode            = $content['RenderingMode'];
if($widget_custom_title == "")
	$widget_custom_title = "Gallery"; 
// widget config block ends

$domain_name =  base_url();
$show_simple_tab = "";
$show_simple_tab .='<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottom-space-10">
<div class="slider LifeGallery" id="lifestyle_gallery_'.$widget_instance_id.'"><fieldset class="FieldTopic">';

if($content['widget_title_link'] == 1)
{
	$show_simple_tab.=	'<legend class="topic"><a href="'.$widget_section_url.'" >'.$widget_custom_title.'</a></legend>';
}
else
{
	if(trim($widget_custom_title) != '')
		$show_simple_tab.=	'<legend class="topic">'.$widget_custom_title.'</legend>';
	else 
		$show_simple_tab.=	'<legend class="topic">&nbsp</legend>';
}
$show_simple_tab.=	'</fieldset>';
// Code Block A ends here


//getting content block - getting content list based on rendering mode
//getting content block starts here . Do not change anything
if($render_mode == "manual")
{
	$content_type = $content['content_type_id'];  // manual article content type
	$widget_instance_contents = $this->widget_model->get_widgetInstancearticles_rendering($widget_instance_id, " ", $view_mode, $max_article);					
}
else
{
	$content_type = $content['content_type_id'];  // auto article content type
	$widget_instance_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'] , $content_type ,  $view_mode);
}

if (function_exists('array_column')) 
{
	$get_content_ids = array_column($widget_instance_contents, 'content_id'); 
}
else
{
	$get_content_ids = array_map( function($element) { return $element['content_id']; }, $widget_instance_contents);
}
$get_content_ids = implode("," ,$get_content_ids);
if($get_content_ids!='')
{
	$widget_instance_contents1 = $this->widget_model->get_contentdetails_from_database($get_content_ids, $content_type, $is_home, $view_mode);	
	//print_r($widget_instance_contents1);exit;
	$widget_contents = array();
	foreach ($widget_instance_contents as $key => $value) {
		foreach ($widget_instance_contents1 as $key1 => $value1) {
			if($value['content_id']==$value1['content_id']){
				$widget_contents[] = array_merge($value, $value1);
			}
		}
	}
	$i =1;
	//echo '<pre>'; print_r($widget_contents);exit;
	// content list iteration block - Looping through content list and adding it the list
	// content list iteration block starts here
	if(count($widget_contents)>0)
	{			
		foreach($widget_contents as $get_content)
		{			
			$custom_title        = "";
			$original_image_path = "";
			$imagealt            = "";
			$imagetitle          = "";
			$Image600X390        = "";
			if($render_mode == "manual")
			{
				if($get_content['custom_image_path'] != '')
				{
					$original_image_path = $get_content['custom_image_path'];
					$imagealt            = $get_content['custom_image_title'];	
					$imagetitle          = $get_content['custom_image_alt'];												
				}
				$custom_title            = stripslashes($get_content['CustomTitle']);
			}
			if($view_mode == "live")
			{
				if($original_image_path =='')
				{
					$original_image_path = $get_content['first_image_path'];
					$imagealt            = $get_content['first_image_alt'];	
					$imagetitle          = $get_content['first_image_title'];
				}
			}
			else
			{
				if($original_image_path =="")                         // from cms imagemaster table    
				{
				$original_image_path  = $get_content['ImagePhysicalPath'];
				$imagealt             = $get_content['ImageCaption'];	
				$imagetitle           = $get_content['ImageAlt'];	
				}
			}
			
			$left_side_show_image="";
			if($original_image_path !='' && getimagesize(image_url . imagelibrary_image_path .$original_image_path))
			{
				$imagedetails = getimagesize(destination_base_path . imagelibrary_image_path.$original_image_path);
				$imagewidth = $imagedetails[0];
				$imageheight = $imagedetails[1];	
			
				if ($imageheight > $imagewidth)
				{
					$Image600X390 	= $original_image_path;
				}
				else
				{
				    $Image600X390  = str_replace("original","w600X390", $original_image_path); 
				}
				if(getimagesize(image_url . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
				{
					$left_side_show_image = image_url. imagelibrary_image_path . $Image600X390; 
				}
				else{
					$left_side_show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
				}
				$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			}
			else {
				$left_side_show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			}
			$dummy_image = image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			
			$content_url = $get_content['url'];
			$param = $content['page_param']; //page parameter
			$live_article_url = $domain_name. $content_url."?pm=".$param;

			$display_title = ( $custom_title != '') ? $custom_title : ( ($get_content['title'] != '') ? stripslashes($get_content['title']) : '' ) ;
			$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$display_title);
			$display_title = '<a  href="'.$live_article_url.'" class="article_click" >'.$display_title.'</a>';
			//  Assign article links block ends hers
			if($i==1)
			{
				$show_simple_tab.= '<div id="carousel_'.$widget_instance_id.'" class="flexslider LifeGalleryLeft" '.$widget_bg_color.'><ul class="slides">';
			}
			if($i > 1 ) {
				$show_simple_tab .='<li><figure class="PositionRelative">';
				$show_simple_tab .='<a  href="'.$live_article_url.'"  class="article_click" ><img src="'.$left_side_show_image.'">';
				$show_simple_tab .='<img class="GalleryListing lifestyle_gallery_thumb" src="'.image_url. imagelibrary_image_path.'/gallery-icon.png"></a></figure></li>';
			}
			if($i == count($widget_contents))
			{
				$show_simple_tab .='</ul></div>';	
			}// display title and summary block ends here		
			$i =$i+1;							  
		} // 1st foreach loop ends here
	
		$k =1;
		foreach($widget_contents as $get_content)
		{
	
			$custom_title        = "";
			$original_image_path = "";
			$imagealt            = "";
			$imagetitle          = "";
			$Image600X390        = "";
			if($render_mode == "manual")
			{
				if($get_content['custom_image_path'] != '')
				{
					$original_image_path = $get_content['custom_image_path'];
					$imagealt            = $get_content['custom_image_title'];	
					$imagetitle          = $get_content['custom_image_alt'];												
				}
				$custom_title            = stripslashes($get_content['CustomTitle']);
			}
			if($view_mode == "live")
			{
				if($original_image_path =='')
				{
					$original_image_path = $get_content['first_image_path'];
					$imagealt            = $get_content['first_image_alt'];	
					$imagetitle          = $get_content['first_image_title'];
				}
			}
			else
			{
				if($original_image_path =="")                         // from cms imagemaster table    
				{
				$original_image_path  = $get_content['ImagePhysicalPath'];
				$imagealt             = $get_content['ImageCaption'];	
				$imagetitle           = $get_content['ImageAlt'];	
				}
			}
			
			$show_image="";
			if($original_image_path !='' && getimagesize(image_url . imagelibrary_image_path .$original_image_path))
			{
				$imagedetails = getimagesize(destination_base_path . imagelibrary_image_path.$original_image_path);
				$imagewidth = $imagedetails[0];
				$imageheight = $imagedetails[1];	
			
				if ($imageheight > $imagewidth)
				{
					$Image600X390 	= $original_image_path;
				}
				else
				{
				    $Image600X390  = str_replace("original","w600X390", $original_image_path);
				}
				if(getimagesize(image_url . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
				{
					$show_image = image_url. imagelibrary_image_path . $Image600X390;
				}
				else{
					$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
				}
				$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			}
			else {
				$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			}
			$dummy_image = image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			
			$content_url = $get_content['url'];
			$param = $content['page_param']; //page parameter
			$live_article_url = $domain_name. $content_url."?pm=".$param;
		
			$display_title = ( $custom_title != '') ? $custom_title : ( ($get_content['title'] != '') ? stripslashes($get_content['title']) : '' ) ;
			$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$display_title);
			$display_title = '<a  href="'.$live_article_url.'" class="article_click" >'.$display_title.'</a>';
	
			//  Assign article links block ends hers
			if($k==1)
			{
				$show_simple_tab.= '<div id="slider_'.$widget_instance_id.'" class="flexslider LifeGalleryRight"> <ul class="slides">';
				
				$show_simple_tab .='<li><figure class="PositionRelative"><a  href="'.$live_article_url.'"  class="article_click" ><img src="'.$show_image.'">';
				$show_simple_tab .='<img class="GalleryListing " src="'.image_url. imagelibrary_image_path.'gallery-icon.png"> </a></figure>';
				$show_simple_tab .='<p class="subtopic"><a  href="'.$live_article_url.'"  class="article_click" >'.$display_title.'</a></p></li>';
				
			}// display title and summary block ends here	
			if($k == count($widget_contents))
			{
				$show_simple_tab .='</ul></div>';
				
				if($content['widget_title_link'] == 1)
				{
				$show_simple_tab .='<div class="arrow_right"><a href="'.$widget_section_url.'" class="landing-arrow">arrow</a></div>';
				}
			}	
			$k =$k+1;							  
		}
	}
}
 elseif($view_mode=="adminview")
{
	$show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div>';
}

// content list iteration block ends here
$show_simple_tab .='</div></div></div>';
echo $show_simple_tab;



?>
<script type="text/javascript">
$(window).load(function(){
$('#carousel_<?php echo $widget_instance_id;?>').flexslider({
animation: "slide",
controlNav: false,
animationLoop: false,
slideshow: false,
itemWidth: 150,
itemHeight: 75,
itemMargin: 5,
asNavFor: '#slider_<?php echo $widget_instance_id;?>'
});

$('#slider_<?php echo $widget_instance_id;?>').flexslider({
animation: "slide",
controlNav: false,
animationLoop: false,
slideshow: false,
sync: "#carousel_<?php echo $widget_instance_id;?>",
start: function(slider){
$('body').removeClass('loading');
}
});
$('#carousel_<?php echo $widget_instance_id;?> li').on('mouseover',function(){
$(this).trigger('click');
});
});
</script>

