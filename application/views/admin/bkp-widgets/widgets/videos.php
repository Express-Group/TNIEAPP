<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color     = $content['widget_bg_color'];
$widget_custom_title = $content['widget_title'];
$widget_instance_id  = $content['widget_values']['data-widgetinstanceid'];
$main_sction_id 	 = "";
$is_home             = $content['is_home_page'];
$widget_section_url  = $content['widget_section_url'];
$view_mode           = $content['mode'];
$max_article         = $content['show_max_article'];
$render_mode         = $content['RenderingMode'];
// widget config block ends
// Code block A - this code block is needed for creating simple tab widget. Do not delete
$domain_name     =  base_url();
$show_simple_tab = "";

if($widget_custom_title == "")
	$widget_custom_title = "Videos";

$show_simple_tab .='<div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-15">
            <div class="allvideo" '.$widget_bg_color.'>
                <fieldset class="FieldTopic">';
					   	
			if($content['widget_title_link'] == 1)
			{
				$show_simple_tab.=	'<legend class="topic"><a href="'.$widget_section_url.'">'.$widget_custom_title.'</a></legend>';
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
					$widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($widget_instance_id , " " ,$content['mode'], $max_article); 						
						
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
					if($render_mode == "manual")            // from widgetinstancecontent table    
					{
						if($get_content['custom_image_path'] != '')
						{
							$original_image_path = $get_content['custom_image_path'];
							$imagealt            = $get_content['custom_image_title'];	
							$imagetitle          = $get_content['custom_image_alt'];												
						}
							$custom_title        = stripslashes($get_content['CustomTitle']);
					}
					if($view_mode == "live")
					{
						if($original_image_path =='')
						{
								$original_image_path = $get_content['video_image_path'];
								$imagealt            = $get_content['video_image_alt'];	
								$imagetitle          = $get_content['video_image_title'];
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
								$Image600X300 	= $original_image_path;
							}
							else
							{
							    $Image600X300  = str_replace("original","w600X300", $original_image_path);
							}
								if (getimagesize(image_url . imagelibrary_image_path . $Image600X300) && $Image600X300 != '')
								{
									$show_image = image_url. imagelibrary_image_path . $Image600X300;
								}
								else {
									$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
								}
								$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
						}
						else {

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
						$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_title);   //to remove first<p> and last</p>  tag
						$display_title = '<a  href="'.$live_article_url.'" class="article_click" >'.$display_title.'</a>';
						
					//  Assign article links block ends hers
						// $play_video_image = image_url. imagelibrary_image_path.'play-circle.png';
						if($i==1){
						$show_simple_tab .= '<ul class="allvideo12 allvideo34">';
				         }
						$show_simple_tab .= '<li class="allvideo1"><div class="ReplyForm">';
						$show_simple_tab .='<a href="'.$live_article_url.'" class="article_click" >';
						
						$show_simple_tab .='<img src="'.$dummy_image.'" data-src="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'" class="play">';
						$show_simple_tab .='<span class="icon-gl-vd icon-vd-center"></span></a>
											<div class="bac_white">
										  </div>';
					
					$show_simple_tab .='</div><p>'.$display_title .'</p></li>';
						if($i==2 || $i==count($widget_contents)){
						$show_simple_tab .= '</ul>';
						$i=0;
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
			
			
			if($content['widget_title_link'] == 1)
			{
		$show_simple_tab .='<div class="arrow_right"><a href="'.$widget_section_url.'" class="landing-arrow">arrow</a></div>';
			}
              $show_simple_tab .='</div>
          </div>
          </div>';
																			  
												
																			  
echo $show_simple_tab;
?>
