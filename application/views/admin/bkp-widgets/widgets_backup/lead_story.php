<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color         = $content['widget_bg_color'];
$widget_custom_title     = $content['widget_title'];
$widget_instance_id      =  $content['widget_values']['data-widgetinstanceid'];
$widget_section_url      = $content['widget_section_url'];
$is_home                 = $content['is_home_page'];
$main_sction_id 	     = "";
$is_home                 = $content['is_home_page'];
$is_summary_required     = $content['widget_values']['cdata-showSummary'];
$domain_name             =  base_url();
$view_mode               = $content['mode'];
$show_simple_tab         = "";
$max_article             = $content['show_max_article'];
$render_mode             = $content['RenderingMode'];
//$start_time = microtime(true);
/************* Widget HTML Starts here ***********************/
$show_simple_tab        .='<div class="lead_stories features" '.$widget_bg_color.' id="lead_stori_'.$widget_instance_id.'">';
	// widget title 
	if($content['widget_title_link'] == 1)
	{
		$show_simple_tab.=	'<h4 class="topic"><a href="'.$widget_section_url.'">'.$widget_custom_title.'</a></h4>';
	}
	else
	{
		if(trim($widget_custom_title) != '')
		$show_simple_tab.=	'<h4 class="topic">'.$widget_custom_title.'</h4>';
		else 
		$show_simple_tab.=	'<h4>&nbsp</h4>';
	}
	
	$j = 0;
		              /************************* getting content block - getting content list based on rendering mode ********************/
		//getting content block starts here .
		if($render_mode == "manual")
		{
			$content_type = $content['content_type_id'];  // auto article content type
			$widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($widget_instance_id , " " ,$content['mode'], $max_article); 						
		}
		else
		{
		   $content_type = $content['content_type_id'];  // auto article content type
		   $widget_instance_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'], $content_type ,  $content['mode']);
		}

		$show_simple_tab.='<div class="HomeLeadStories slide">';
		
		              /********************* content list iteration block - Looping through content list and adding it the list ********************/
		// content list iteration block starts here
		if (function_exists('array_column')) 
				{
			$get_content_ids = array_column($widget_instance_contents, 'content_id'); 
				}else
				{
			$get_content_ids = array_map( function($element) { return $element['content_id']; }, $widget_instance_contents);
				}
	$get_content_ids = implode("," ,$get_content_ids);
	if($get_content_ids!='')
	{
	$widget_instance_contents1 = $this->widget_model->get_contentdetails_from_database($get_content_ids, $content_type, $is_home, $view_mode);	
	$widget_contents = array();
		foreach ($widget_instance_contents as $key => $value) {
			foreach ($widget_instance_contents1 as $key1 => $value1) {
				if($value['content_id']==$value1['content_id']){
			       $widget_contents[] = array_merge($value, $value1);
				}
			}
		}
		$i =1;
	if(count($widget_contents)>0)
	{
		foreach($widget_contents as $get_content)
		{
			/*if($content['RenderingMode'] == "manual"):
			$content_type = $get_content['content_type_id'];  // from widgetinstancecontent table
			else:
			 $content_type = $content['content_type_id'];  // from xml
			endif;	
			// getting content details 
			$content_details = $this->widget_model->get_contentdetails_from_database($get_content['content_id'], $content_type, $is_home, $view_mode);*/	
	
			$custom_title        = "";
			$custom_summary      = "";
			$original_image_path = "";
			$imagealt            = "";
			$imagetitle          = "";
			$Image600X390        = "";
			if($render_mode == "manual")            // from widgetinstancecontent table    
			{
				if($get_content['custom_image_path'] != '')
				{
					$original_image_path = $get_content['custom_image_path'];
					$imagealt            = $get_content['custom_image_title'];	
					$imagetitle          = $get_content['custom_image_alt'];												
				}
					$custom_title        = stripslashes($get_content['CustomTitle']);
					$custom_summary      = $get_content['CustomSummary'];

			}
			if($original_image_path =="")                         // from cms || Live table    
			{
				   $original_image_path  = $get_content['ImagePhysicalPath'];
				   $imagealt             = $get_content['ImageCaption'];	
				   $imagetitle           = $get_content['ImageAlt'];	
			}
		
		if ($original_image_path!='' && file_exists(destination_base_path . imagelibrary_image_path .$original_image_path))
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
				$Image600X390 	= str_replace("original","w600X390", $original_image_path);
			}
			if (file_exists(destination_base_path . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
			{
				$show_image = image_url. imagelibrary_image_path . $Image600X390;
			}
			else 
			{
				$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			}
		}	
		else 
		{
			$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
		}	
				
				                               /******************** article title and summary and url ********************/
				$content_url = $get_content['url'];
				$param = $content['page_param']; //page parameter
				$live_article_url = $domain_name. $content_url."?pm=".$param;
			
				if( $custom_title == '')
				{
					$custom_title = stripslashes($get_content['title']);
				}	
				$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_title);   //to remove first<p> and last</p>  tag
								
				if( $custom_summary == '' && $render_mode=="auto")
				{
					$custom_summary =  $get_content['summary_html'];
				}
				$summary  = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_summary);  //to remove first<p> and last</p>  tag
		
				                        /******************** display title and summary block starts here ********************************/
				
				$add_active =($i==1) ? 'active' : '';	
				
				$show_simple_tab .='<div class="item '.$add_active.'">
									<a  href="'.$live_article_url.'"  class="article_click" ><img  src="'.$show_image.'"  title = "'.$imagetitle.'" alt = "'.$imagealt.'"></a><h4 class="subtopic"><a  href="'.$live_article_url.'"  class="article_click" >'.$display_title.'</a></h4>';
                if($is_summary_required== 1){		
				$show_simple_tab .= '<p class="para_bold padding-0 summary">'.$summary.'</p>';
				}
				$show_simple_tab .= '<div class="common_p">';
				if($content['RenderingMode'] == "manual")
				{
	
				$get_related_article 	= $this->widget_model->get_widgetInstanceRelatedarticles_rendering($widget_instance_id, '','',$get_content['content_id'], $view_mode); 
				
									
				if(isset($get_related_article)) {
							
							foreach($get_related_article as $key => $get_article)
							{
				$content_type_id = $get_article['content_type_id'];
				$related_contents = $this->widget_model->get_contentdetails_from_database($get_article['content_id'], $content_type_id, $is_home, $view_mode);	
				if($get_article['CustomTitle'] != '') {
					$Title = $get_article['CustomTitle'];
				} else {
					$Title =  $related_contents[0]['Title'];
				}

				$content_url = $related_contents[0]['url'];
				$param = $content['page_param']; //page parameter
				$related_article_url = $domain_name. $content_url."?pm=".$param;
				
					$Title =  preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$Title);
					
	$show_simple_tab .= '<p>  <i class="fa fa-circle"></i> <a  href="'.$related_article_url.'" class="article_click" >'.$Title.'</a>';
	
	if($content_type_id=='3'){
		$show_simple_tab .= '<i class="fa fa-picture-o lead_relate_icon"></i>';
	}
	elseif($content_type_id=='4'){
		$show_simple_tab .= '<i class="fa fa-video-camera lead_relate_icon"></i>';
	}
	elseif($content_type_id=='5'){
		$show_simple_tab .= '<i class="fa fa-volume-up lead_relate_icon"></i>';
	}
	$show_simple_tab .= '</p>';															
			
		
		}
	}
	
	}
					
	$show_simple_tab .=' </div></div>'; 
			
			
			// display title and summary block ends here					
			//Widget design code block 1 starts here																
		//Widget design code block 1 starts here			
		$i =$i+1;							  
	}
}
} elseif($view_mode=="adminview")
{
	$show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div>';
}
$show_simple_tab .='</div>';

// Adding content Block ends here

$show_simple_tab .='</div>';

	if($content['widget_title_link'] == 1)
	{ 
	$show_simple_tab .='<div class="arrow_right"><a href="'.$widget_section_url.'"  class="landing-arrow">arrow</a></div>';
	}													
//$end_time = microtime(true);
//echo $time_diff = $end_time - $start_time;
echo $show_simple_tab;
?>
