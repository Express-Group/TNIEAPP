<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color      = $content['widget_bg_color'];
$widget_custom_title  = $content['widget_title'];
$widget_instance_id   = $content['widget_values']['data-widgetinstanceid'];
$main_sction_id 	  = "";
$widget_section_url   = $content['widget_section_url'];
$is_home              = $content['is_home_page'];
$view_mode            = $content['mode'];
$max_article          = $content['show_max_article'];
$render_mode          = $content['RenderingMode'];
// widget config block ends
// Code block A - this code block is needed for creating simple tab widget. Do not delete
$domain_name =  base_url();

if($widget_custom_title == "")
	$widget_custom_title = "Gallery";
	
$show_simple_tab = "";
$show_simple_tab .='<div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottom-space-10">
            <div class="allgallery" '.$widget_bg_color.'>
                <fieldset class="FieldTopic">';
					   	
			if($content['widget_title_link'] == 1)
			{
				$show_simple_tab.=	' <legend class="topic"><a href="'.$widget_section_url.'">'.$widget_custom_title.'</a></legend>';
			}
			else
			{
				$show_simple_tab.=	'<legend class="topic">'.$widget_custom_title.'</legend>';
			}
			$show_simple_tab .= '</fieldset>';
			
				//getting content block - getting content list based on rendering mode
				//getting content block starts here . Do not change anything
				if($render_mode == "manual")
				{
					$content_type = $content['content_type_id'];  // manual article content type
					$widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($widget_instance_id, " ", $view_mode, $max_article); 						
				}
				else
				{
					 $content_type = $content['content_type_id'];  // auto article content type
                     $widget_instance_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'], $content_type ,  $view_mode);		
				}
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
		if(count($widget_contents)>0)
		     {			
				foreach($widget_contents as $get_content)
				{
					$custom_title        = "";
					$original_image_path = "";
					$imagealt            = "";
					$imagetitle          = "";
					$Image600X300        = "";
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
						if($original_image_path !='' && file_exists(destination_base_path . imagelibrary_image_path .$original_image_path))
						{
							$imagedetails = getimagesize(destination_base_path . imagelibrary_image_path.$original_image_path);
							$imagewidth = $imagedetails[0];
							$imageheight = $imagedetails[1];	
						
							if ($imageheight > $imagewidth)
							{
								$Image600X300 	= $original_image_path;
							}
							else
							{
								$Image600X300  = str_replace("original","w600X300", $original_image_path);
							}
							if (file_exists(destination_base_path . imagelibrary_image_path . $Image600X300) && $Image600X300 != '')
							{
								$show_image = image_url. imagelibrary_image_path . $Image600X300;
							}
							else {
								$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
							}
							$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
						}
						else{
							$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
						}
						$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
						
						$content_url = $get_content['url'];
						$param = $content['page_param']; //page parameter
						$live_article_url = $domain_name. $content_url."?pm=".$param;
					
						if( $custom_title == '')
						{
							$custom_title = stripslashes($get_content['title']);
						}	
						$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_title);
						$display_title = '<a  href="'.$live_article_url.'" class="article_click" >'.$display_title.'</a>';
						
							
					//  Assign article links block ends hers
												
						if($i == 1) {
						
						$show_simple_tab.=	'<div class="allgallery1">  <a  href="'.$live_article_url.'"  class="article_click"  ><figure class="PositionRelative"><img src="'.$dummy_image.'" data-src="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'">
						<span class="icon-gl-vd icon-gl"></span>
						</figure></a></div>';
						$show_simple_tab.=	'<div class="allgallery2 features">
													<h4 class="subtopic"><a href="'.$live_article_url.'" class="article_click"  >'.$display_title.'</a></h4>';
									if($i == count($widget_contents))
									{
										$show_simple_tab .='</div>';
									}
						} else {
							if($i == 2) {
							
													$show_simple_tab.=	'<div class="slide galleries_slider">';
							}
								$show_simple_tab.=	'<div class="gal_split1">';
							
							 $show_simple_tab.=	'<a  href="'.$live_article_url.'"  class="article_click"  >
							 <figure class="PositionRelative"><img data-lazy="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'">
							 <span class="icon-gl-vd icon-gl"></span></figure></a>
												<p><a  href="'.$live_article_url.'"  class="article_click"  >'.strip_tags($display_title).'</a></p>';
							 
								$show_simple_tab.=	'</div>'; 
								if($i == count($widget_contents))
								{
									$show_simple_tab .='</div></div>';
								}
						}
					$i =$i+1;
				}
				// content list iteration block ends here
		}
	}
	 elseif($view_mode=="adminview")
	{
	 $show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div>';
	}
			// Adding content Block ends here
			if($content['widget_title_link'] == 1)
			{
$show_simple_tab .=' <div class="arrow_right"><a href="'.$widget_section_url.'" class="landing-arrow">arrow</a></div>';
			}
$show_simple_tab .='</div>
</div></div>';
																			  
												
																			  
echo $show_simple_tab;
?>
