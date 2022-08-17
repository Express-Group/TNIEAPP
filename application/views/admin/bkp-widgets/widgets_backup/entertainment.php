<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color     = $content['widget_bg_color'];
$widget_custom_title = $content['widget_title'];
$widget_instance_id  = $content['widget_values']['data-widgetinstanceid'];
$main_sction_id 	 = "";
$is_home             = $content['is_home_page'];
$is_summary_required = $content['widget_values']['cdata-showSummary'];
$widget_section_url  = $content['widget_section_url'];
$view_mode           = $content['mode'];
$max_article         = $content['show_max_article'];
$render_mode         = $content['RenderingMode'];
// widget config block ends
//getting tab list for hte widget
// Code block A - this code block is needed for creating simple tab widget. Do not delete
$domain_name =  base_url();
$show_simple_tab = "";
 if($content['widget_title_link'] == 1)
	{
		$widget_title=	'<a href="'.$widget_section_url.'">'.$widget_custom_title.'</a>';
	}
	else
	{
		$widget_title=	$widget_custom_title;
	}
					
$show_simple_tab .='<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 enter_all feature">
		    <h4 class="EnterTitle">'.$widget_title.'</h4>
            <div class="enter slide HomeEntertainment" id="HomeEntertainment_'.$widget_instance_id.'">';
													
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
			
			$i =1;
			$l=1;
			
			if(count($widget_instance_contents)>0)
		     {			
				foreach($widget_instance_contents as $get_content)
				{
if($render_mode == "manual"):
					$content_type = $get_content['content_type_id'];  // from widgetinstancecontent table
					else:
					 $content_type = $content['content_type_id'];  // from xml
					endif;	
					// getting content details 
					$content_details = $this->widget_model->get_contentdetails_from_database($get_content['content_id'], $content_type, $is_home, $view_mode);				
					
				$original_image_path = "";
				$imagealt            = "";
				$imagetitle          = "";
				$custom_title        = "";
				$custom_summary      = "";
				if($render_mode == "manual")
				{
					if($get_content['custom_image_path'] != '')
					{
						$original_image_path = $get_content['custom_image_path'];
						$imagealt = $get_content['custom_image_title'];	
						$imagetitle= $get_content['custom_image_alt'];												
					}
					$custom_title   = $get_content['CustomTitle'];
					$custom_summary = $get_content['CustomSummary'];
				}

				if($original_image_path =='')
				{
					if($content_type=='1')
					{
						 $original_image_path  = $content_details[0]['ImagePhysicalPath'];
					     $imagealt             = $content_details[0]['ImageCaption'];	
					     $imagetitle           = $content_details[0]['ImageAlt'];	
					}
					elseif(($content_type=='3' || $content_type=='4') && $view_mode =="adminview")
					{
						 $original_image_path  = $content_details[0]['ImagePhysicalPath'];
					     $imagealt             = $content_details[0]['ImageCaption'];	
					     $imagetitle           = $content_details[0]['ImageAlt'];	
					}
					elseif($content_type=='3' && $view_mode =="live")
					{
							$original_image_path = $content_details[0]['first_image_path'];
							$imagealt = $content_details[0]['first_image_alt'];	
							$imagetitle= $content_details[0]['first_image_title'];
					}
					elseif($content_type=='4' && $view_mode =="live")
					{
							$original_image_path = $content_details[0]['video_image_path'];
							$imagealt = $content_details[0]['video_image_alt'];	
							$imagetitle= $content_details[0]['video_image_title'];
					}
							
				}

				$show_image="";$is_image = false;
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
								$is_image = true;
							}
							else {
								$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
							}
							$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
					}
					else
					{
							$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
							$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
							$is_image = false;
					}
					
					$content_url = $content_details[0]['url'];
					$param = $content['page_param']; //page parameter
					$live_article_url = $domain_name. $content_url."?pm=".$param;
					// Assign block ends here
					// Assign article links block - creating links for  article summary Display article																$custom_title = $get_content['CustomTitle'];
					
					if( $custom_title == '')
					{
						$custom_title = $content_details[0]['title'];
					}	
					$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_title);
					
					$display_title = '<a  href="'.$live_article_url.'"  class="article_click" >'.$display_title.'</a>';
				//  Assign article links block ends hers
				
				// Assign summary block - creating links for  article summary
					// Assign summary block starts here
					if( $custom_summary == '' && $render_mode=="auto" )
					{
					  $custom_summary = $content_details[0]['summary_html'];
					}
					$summary  = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_summary);
					// Assign summary block starts here
					$play_video_image = image_url. imagelibrary_image_path.'play-circle.png';
					$gallery_icon= image_url. imagelibrary_image_path.'gallery-icon.png';
					$add_active=($l==1)?'active':'';
					if($i <= 4) {
					if($i==1){
					$show_simple_tab.='<div class="item '.$add_active.'">';
					$show_simple_tab.='<div class="WidthFloat_L">';
					$show_simple_tab.='<div class="enter1">
					<div class="enter1a">
							<h5>'.$display_title.'</h5>';
							if($is_summary_required== 1){	
							$show_simple_tab.='<p class="summary">'.$summary.'</p>';
							}
					$show_simple_tab.='</div>
					</div>';
					$show_simple_tab.='<div class="enter2"> 
						<a  href="'.$live_article_url.'" ><img data-lazy="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'">';                                                              if($content_type== '4')
					{
						$show_simple_tab.='<img class="GalleryIcon"  src="'.$play_video_image.'">';
					}else if($content_type == '3'){
						$show_simple_tab.='<img class="GalleryIcon"  src="'.$gallery_icon.'">';
					}
					$show_simple_tab.='</a> 
					</div></div>';
					if($l == count($widget_instance_contents))
						{
							$show_simple_tab.='</div>';
						}
					}else if($i==2){
					$show_simple_tab.='<div class="WidthFloat_L">';
					$show_simple_tab.='<div class="enter3"> 
				<a  href="'.$live_article_url.'" ><img  data-lazy="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'">';
				if($content_type == '4')
					{
						$show_simple_tab.='<img class="GalleryIcon"  src="'.$play_video_image.'">';
					}else if($content_type == '3'){
						$show_simple_tab.='<img class="GalleryIcon"  src="'.$gallery_icon.'">';
					}
				$show_simple_tab.='</a>
				<div class="TransSmall"> <a  href="'.$live_article_url.'" >'.$display_title.'</a> </div>'; 
					$show_simple_tab.='</div>';
					 if($l == count($widget_instance_contents))
						{
							$show_simple_tab.='</div></div>';
						}
					}else if($i==3){
					$show_image = ($is_image)? str_replace("w600X300", "w600X390", $show_image) : str_replace("_600X300", "_600X390", $show_image);	
					$show_simple_tab.='<div class="enter4"><div class="enter4ab">
						<div class="enter4a">
						<figure> <a  href="'.$live_article_url.'" ><img data-lazy="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'">';
						if($content_type == '4')
						{
							$show_simple_tab.='<img class="GalleryIcon"  src="'.$play_video_image.'">';
						}else if($content_type == '3'){
							$show_simple_tab.='<img class="GalleryIcon"  src="'.$gallery_icon.'">';
						}
						$show_simple_tab.='</a> </figure>
					  </div>
						<div class="enter4b">
						<h6>'.$display_title.'</h6>';
						if($is_summary_required== 1){	
						$show_simple_tab.='<p class="summary">'.$custom_summary.'</p>';
						}
						$show_simple_tab.='<div class="left_arrow"></div>
						<div class="top_arrow"></div>
					  </div>
					  </div>';
					  if($l == count($widget_instance_contents))
						{
							$show_simple_tab.='</div></div></div>';
						}
					}else if($i==4){
					$show_image = ($is_image)? str_replace("w600X300", "w600X390", $show_image) : str_replace("_600X300", "_600X390", $show_image);
					$show_simple_tab.='<div class="enter4cd">
						<div class="enter4c">
						<h6>'.$display_title.'</h6>';
						if($is_summary_required== 1){	
						$show_simple_tab.='<p class="summary">'.$custom_summary.'</p>';
						}
						$show_simple_tab.='<div class="right_arrow"></div>
						<div class="bottom_arrow"></div>
					  </div>
						<div class="enter4d">
						<figure> <a  href="'.$live_article_url.'" ><img data-lazy="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'">';
						if($content_type == '4')
						{
							$show_simple_tab.='<img class="GalleryIcon"  src="'.$play_video_image.'">';
						}else if($content_type == '3'){
							$show_simple_tab.='<img class="GalleryIcon"  src="'.$gallery_icon.'">';
						}
					$show_simple_tab.='</a> </figure>
					  </div>
					  </div></div></div></div>';
						$i=0;
					}
				
					} 
					if($l == count($widget_instance_contents))
					{
						$show_simple_tab .='</div>';
						if($content['widget_title_link'] == 1)
						{
						$show_simple_tab .='<div class="arrow_right"><a href="'.$widget_section_url.'" class="landing-arrow">arrow</a></div>';
						}
					}
					
					// display title and summary block ends here					
					//Widget design code block 1 starts here																
				//Widget design code block 1 starts here			
				$i =$i+1;	
				$l++;						  
			}
			 }
			/*}*/
			 elseif($view_mode=="adminview")
			{
			 $show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div></div>';
			}else
			{
				 $show_simple_tab .='</div>';
			}
			 
			// content list iteration block ends here
	
		// Adding content Block ends here
		$show_simple_tab .='</div>
							  </div> ';
																			  
												
																			  
echo $show_simple_tab;
?>
