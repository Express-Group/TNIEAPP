<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color = $content['widget_bg_color'];
$widget_custom_title = $content['widget_title'];
$widget_instance_id =  $content['widget_values']['data-widgetinstanceid'];
$main_sction_id 	= "";
$widget_section_url = $content['widget_section_url'];
$is_home = $content['is_home_page'];
$is_summary_required = $content['widget_values']['cdata-showSummary'];

// widget config block ends
//getting tab list for hte widget
$widget_instancemainsection	= $this->widget_model->get_widget_mainsection_config_rendering('', $widget_instance_id, $content['mode']);
// Code block A - this code block is needed for creating simple tab widget. Do not delete
$domain_name =  base_url();
$is_home = $content['is_home_page'];

$show_simple_tab = "";
$show_simple_tab .='<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="GallerySlider features">
<div class="slide GalleryLeadSlider">';
					   	
													$url_structure = $content['url_structure'];
													$section_landing =  "0,".$content['sectionID'].", 'section', this, '".$url_structure."'";	
													if($content['widget_title_link'] == 1)
													{
														//$show_simple_tab.=	' <legend class="topic"><a href="#" onclick="call_url('.$section_landing.')"  >'.$widget_custom_title.'</a></legend>';
													}
													else
													{
														//$show_simple_tab.=	'<legend class="topic">'.$widget_custom_title.'</legend>';
													}
													
													
													//$show_simple_tab .= '</fieldset>';
													
													$j = 0;
													// Adding content Block starts here
													foreach($widget_instancemainsection as $get_section)
													{		
														//getting content block - getting content list based on rendering mode
														//getting content block starts here . Do not change anything
														if($content['RenderingMode'] == "manual")
														{
															$widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($get_section['WidgetInstance_id'], $get_section['WidgetInstanceMainSection_id'],$content['mode']); 		
														}
														else
														{
															 
															//$widget_instance_contents = $this->widget_model->get_all_available_video_auto($content['show_max_article'], $widget_instancemainsection[$j]['Section_ID'], $content['mode']);
															
															$widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($get_section['WidgetInstance_id'], $get_section['WidgetInstanceMainSection_id'],$content['mode']); 	
															
														}
														
														$i =1;
														$count = 1;
														foreach($widget_instance_contents as $get_content)
														{
															$content_type = @$get_content['content_type_id'];

															$content_details = $this->widget_model->get_contentdetails_from_live_database($get_content['content_id'], $content_type,$is_home);	

															$original_image_path = "";
															$imagealt ="";
															$imagetitle="";
															if($content['RenderingMode'] == "manual")
															{
																if(@$get_content['custom_image_path'] != '')
																{
																	$original_image_path = $get_content['custom_image_path'];
																	$imagealt = $get_content['custom_image_title'];	
																	$imagetitle= $get_content['custom_image_alt'];												
																}
															}

															if(@$original_image_path =='')
															{
																$original_image_path = @$content_details[0]['video_image_path'];
																$imagealt = @$content_details[0]['video_image_alt'];	
																$imagetitle= @$content_details[0]['video_image_title'];
																		
															}
															
															// Code block C - if rendering mode is auto then this code blocks retrieve required image from article related image if content type is article (This widget uses only article- Do not change
															// Code block C  starts here
															
																$show_image="";

																if($original_image_path !='')
																{
																	 $Image600X390  = str_replace("original","w600X390", @$original_image_path);
																																				
																		if (getimagesize(image_url . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
																		{
																			$show_image = image_url. imagelibrary_image_path . $Image600X390;
																		}
	
																		else {
																			$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
																		}
																		$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
																}
																else {
																			$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
																		}
																		$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
																// Code block C ends here
																
																// Assign block - assigning values required for opening the article in light box
																// Assign block starts here
																if(@$content_details[0]['grant_parent_section_name']!='' &&  @$content_details[0]['parent_section_name']!='')
																{
																	 $url_section_value = join( "-",( explode(" ",$content_details[0]['grant_parent_section_name'] ) ) )."/".join( "-",( explode(" ",$content_details[0]['parent_section_name'] ) ) )."/".join( "-",( explode(" ",$content_details[0]['section_name'] ) ) ); 
																}
																																														
																else if(@$content_details[0]['parent_section_name'] != '')
																{
																 $url_section_value = join( "-",( explode(" ",@$content_details[0]['parent_section_name'] ) ) )."/".join( "-",( explode(" ",@$content_details[0]['section_name'] ) ) ); 

																}
																else
																{
																$url_section_value = join( "-",( explode(" ",@$content_details[0]['section_name'] ) ) ); 
																}
																
																$contentID = @$get_content['content_id'];
																$section_ID = @$content_details[0]['Section_id'];
																$contentTypeID = @$get_content['content_type_id'];
																																
																$string_value = $contentID.",".$section_ID.", 'article', this, '".$url_structure."'";
																
																$content_url_title = join( "-",( explode(" ",@$content_details[0]['url_title']) ) );
																$content_url_title = preg_replace('/[^A-Za-z0-9\-]/', '', $content_url_title);
																$param = $content['page_param'];
																$live_string_value = $domain_name.$url_section_value."/". $content_url_title."-". $contentID."-1"."?pm=".$param;
																$custom_title = @$get_content['CustomTitle'];
																if($custom_title != '')
																{
																	$display_title = $custom_title;
																}
																else
																{
																	$display_title = @$content_details[0]['title'];
																}	
																
																$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$display_title);
																$display_title = '<a  href="'.$live_string_value.'" class="article_click" >'.$display_title.'</a>';
															//  Assign article links block ends hers
																$lastpublishedon = $content_details[0]['publish_on'];
																	
															//  Assign article links block ends hers

																$play_gallery_image = image_url. imagelibrary_image_path.'play-circle.png';
																
																	//echo '<br>sdfsf: <img data-src="'.$show_image.'"/>';
																	$show_simple_tab.= '<div class="item">
																	<div class="GallerySliderLeft">
																	<figure class="PositionRelative">

																	<a  href="'.$live_string_value.'"  class="article_click" ><img data-lazy="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'"><img src="'.$play_gallery_image.'" class="GalleryIcon"></a>

																	</figure>
																	</div>
																	<div class="GallerySliderRight">
																	<p><a  href="'.$live_string_value.'" class="article_click" >'.$custom_title.'</a></p>
																	
																	</div>
																	</div>';
																					
																
															$i =$i+1;
															//$show_simple_tab .='</div>';
														}
														// content list iteration block ends here
														$j++;
													}
												
													// Adding content Block ends here
													$show_simple_tab .=' </div>
													';
															
													
			$show_simple_tab .='</div>
</div>
</div>
';
																			  
												
																			  
echo $show_simple_tab;
?>

