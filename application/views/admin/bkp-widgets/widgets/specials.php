<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color        = $content['widget_bg_color'];
$widget_custom_title    = $content['widget_title'];
$widget_instance_id     = $content['widget_values']['data-widgetinstanceid'];
$widgetsectionid        = $content['sectionID'];
$main_sction_id 	    = "";
$widget_section_url     = $content['widget_section_url'];
$is_home                = $content['is_home_page'];
$view_mode              = $content['mode'];
$domain_name            =  base_url();
$show_simple_tab        = "";
$max_article            = $content['show_max_article'];
$render_mode            = $content['RenderingMode'];

                                 /************* widgets HTML Starts here ***********************/
$show_simple_tab       .='<div class="special" '.$widget_bg_color.'>
							<fieldset class="FieldTopic">';
			
			if($content['widget_title_link'] == 1)
			{
				$show_simple_tab.=	'<legend class="topic"><a href="'.$widget_section_url.'">'.$widget_custom_title.'</a></legend>';
			}
			else
			{
				$show_simple_tab.=	'<legend class="topic">'.$widget_custom_title.'</legend>';
			}
			$show_simple_tab.= ' </fieldset>
			   <div class="SpecialContent">';

			// Adding content Block starts here
														
				//getting content block - getting content list based on rendering mode
				//getting content block starts here . Do not change anything
				if($render_mode == "manual")
				{
					$content_type = $content['content_type_id'];  // manual mode content type
					$widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($widget_instance_id , " " ,$content['mode'], $max_article); 						
				}
				else
				{
				$content_type = $content['content_type_id'];  // auto article content type
				$widget_instance_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'] , $content_type ,  $content['mode']);
				}

				//getting content block ends here

				//Widget code block Starts here
			    // content list iteration block - Looping through content list and adding it the list
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
				$count = 1;
				//print_r($this->db->last_query());exit;
			if(count($widget_contents)>0)
		     {
				foreach($widget_contents as $get_content)
				{
					$custom_title        = "";
					$original_image_path = "";
					$imagealt            = "";
					$imagetitle          = "";
					$Image150X150        = "";
					if($render_mode == "manual")
						{
							if($get_content['custom_image_path'] != '')    // rendering based on view_mode 
							{
								$original_image_path = $get_content['custom_image_path'];
								$imagealt            = $get_content['custom_image_title'];	
								$imagetitle          = $get_content['custom_image_alt'];												
							}
								$custom_title        = stripslashes($get_content['CustomTitle']);

						}
					if($original_image_path =="")                                                // from cms || Live table    
						{
							   $original_image_path  = $get_content['ImagePhysicalPath'];
							   $imagealt             = $get_content['ImageCaption'];	
							   $imagetitle           = $get_content['ImageAlt'];	
						}
					
					if ($original_image_path!='' && getimagesize(image_url . imagelibrary_image_path .$original_image_path))
					{
						$imagedetails = getimagesize(destination_base_path . imagelibrary_image_path.$original_image_path);
						$imagewidth = $imagedetails[0];
						$imageheight = $imagedetails[1];	
					
						if ($imageheight > $imagewidth)
						{
							$Image150X150 	= $original_image_path;
						}
						else
						{
						$Image150X150 	= str_replace("original","w150X150", $original_image_path);
			            }
						
						if (getimagesize(image_url . imagelibrary_image_path . $Image150X150) && $Image150X150 != '')
						{
							$show_image = image_url. imagelibrary_image_path . $Image150X150;
						}
						else 
						{
							$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_150X150.jpg';
						}
					}	
					else 
					{
						$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_150X150.jpg';
					}	
					$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_150X150.jpg';	
						$content_url = $get_content['url'];
						
						$param = $content['page_param'];
						$live_article_url = $domain_name. $content_url."?pm=".$param;
					 	
						if( $custom_title == '')
						{																	
							$custom_title = $get_content['title'];
						}
						$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_title); //to remove first<p> and last</p>  tag
					
					//**************  Loop the Article based on structure *******************//
					if($count <= 3)
					{
						if($count==1){
					   $show_simple_tab.= '<div class="special1">'; 
					   } 
							$show_simple_tab.= '<div class="special1a">
								<div class="special_main_img">
								<figure class="special_img"><a  href="'.$live_article_url.'" class="article_click"  >
								 <img src="'.$dummy_image.'" data-src="'.$show_image.'"  title = "'.$imagetitle.'" alt = "'.$imagealt.'"></a>
									
									</figure>
								  </div>
								<p><a  href="'.$live_article_url.'" class="article_click"  >'. $display_title.'</a></p>
							  </div>';
					 
					  if($count==3 || $i == count($widget_contents))
					   { 
						 $show_simple_tab.=  '</div>';
						 $count=0;
						} 
					
					$count ++;	
					}
						//Widget design code block 1 starts here																
					//Widget design code block 1 starts here			
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
			$show_simple_tab .='</div></div>';
echo $show_simple_tab;
?>
