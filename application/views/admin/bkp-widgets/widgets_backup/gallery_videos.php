<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color     = $content['widget_bg_color'];
$widget_custom_title = $content['widget_title'];
$widget_instance_id  = $content['widget_values']['data-widgetinstanceid'];
$widget_section_url  = $content['widget_section_url'];
$main_sction_id 	 = "";
$widget_section_url  = $content['widget_section_url'];
$is_home             = $content['is_home_page'];
$is_summary_required = $content['widget_values']['cdata-showSummary'];
$view_mode           = $content['mode'];
$max_article         = $content['show_max_article'];
$render_mode         = $content['RenderingMode'];
// widget config block ends
//getting tab list for hte widget
if($content['RenderingMode'] == "manual")
{
$widget_instancemainsection	= $this->widget_model->get_widget_mainsection_config_rendering('', $widget_instance_id, $content['mode']);
}else{
$widget_instancemainsection	= $content['widget_values']->widgettab;
}

// Code block A - this code block is needed for creating simple tab widget. Do not delete
$domain_name     =  base_url();
$show_simple_tab = "";
// Code Block A ends here

// Tab Creation Block Starts here
$j = 0;

// // Tab Creation Block- Below code gets the record from windgetinstancemainsection table to create tabs for this widget 
// Adding content Block - to add contents for each tab
// Adding content Block starts here
foreach($widget_instancemainsection as $get_section)
{
//getting content block - getting content list based on rendering mode
//getting content block starts here . Do not change anything
if($render_mode == "manual")
{
$content_type = $content['content_type_id'];  // manual article content type
$widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($get_section['WidgetInstance_id'], $get_section['WidgetInstanceMainSection_id'],$view_mode, $max_article); 
}
else
{
$content_type = $content['content_type_id'];  // auto article content type
$widget_instance_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'] , $content_type ,  $view_mode);
}

//getting content block ends here
//Widget code block - code required for simple tab structure creation. Do not delete
//Widget code block Starts here

$show_simple_tab .='<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 galleries features" id="gallery_video-'.$widget_instance_id.'">';
if($render_mode == "manual")
{
	$widget_title = $get_section['CustomTitle'];
}else{
    $widget_title = $get_section['cdata-customTitle'];
}
if($j==0){
$widget_section_url = $domain_name.$widget_title;
$content_type = 3;  
}
elseif($j==1)
{
$widget_section_url = $domain_name.$widget_title;
$content_type = 4; 
}

$show_simple_tab.=	'<h4 class="topic"><a href="'.$widget_section_url.'">'.$widget_title.'</a></h4>';



$show_simple_tab .='<div class="slide HomeGallery">';                     
//Widget code block ends here

// content list iteration block - Looping through content list and adding it the list
// content list iteration block starts here
$i =1;$k=1;
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
if(count($widget_contents)>0)
{
foreach($widget_contents as $get_content)
{
		
	$original_image_path = "";
	$imagealt            = "";
	$imagetitle          = "";
	$custom_title        = "";
	if($render_mode == "manual")
	{
		if($get_content['custom_image_path'] != '')
		{
			$original_image_path = $get_content['custom_image_path'];
			$imagealt = $get_content['custom_image_title'];	
			$imagetitle= $get_content['custom_image_alt'];												
		}
		$custom_title = $get_content['CustomTitle'];
	}

		if($view_mode == "live")
		{
			if($original_image_path =='')
			{
				if($content_type == '3')
				{
					$original_image_path = $get_content['first_image_path'];
					$imagealt            = $get_content['first_image_alt'];	
					$imagetitle          = $get_content['first_image_title'];
				}
				elseif($content_type == '4')
				{
					$original_image_path = $get_content['video_image_path'];
					$imagealt            = $get_content['video_image_alt'];	
					$imagetitle          = $get_content['video_image_title'];
				}
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
				$Image600X390 	= $original_image_path;
			}
			else
			{
			$Image600X390  = str_replace("original","w600X300", $original_image_path);
			}
			if (file_exists(destination_base_path . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
			{
			$show_image = image_url. imagelibrary_image_path . $Image600X390;
			}
			else
			{
			$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
			}
			$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
			}
			else {
			$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
			}
			$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
				// Code block C ends here
				
				// Assign block - assigning values required for opening the article in light box
				// Assign block starts here
				
				$content_url = $get_content['url'];
				$param = $content['page_param']; //page parameter
				$live_article_url = $domain_name. $content_url."?pm=".$param;
				
				if( $custom_title == '')
				{
				$custom_title = $get_content['title'];
				}	
				
				$display_title =  preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $custom_title);
				//  Assign article links block ends hers


// display title and summary block starts here
if($k<=2){
if($j==0){
$icon ='<span class="icon-gl-vd icon-gl"></span>';	
}else{
$icon ='<span class="icon-gl-vd icon-vd"></span>';		
}

$title = $display_title;

if($k==1){

$show_simple_tab .='<div class="gal_img item">';

$show_simple_tab .='<div class="gallery1"><a   href="'.$live_article_url.'" class="article_click" >'.$icon.'<img src="'.$dummy_image.'" data-lazy="'.$show_image.'"   title = "'.$imagetitle.'" alt = "'.$imagealt.'">
<div class="gallery_cap"><p>'.$display_title.'</p></div></a>
</div>'; 
if($i == count($widget_contents))
{
$show_simple_tab .= '</div>';
}
}else{
$show_simple_tab .='<div class="gallery1"><a   href="'.$live_article_url.'" class="article_click" >'.$icon.'<img src="'.$dummy_image.'" data-lazy="'.$show_image.'"  title = "'.$imagetitle.'" alt = "'.$imagealt.'">
<div class="gallery_cap"><p>'.$display_title.'</p></div></a>
</div>';
if($k == 2)
{
$show_simple_tab .= '</div>';
}
$k=0;

}
}
if($i == count($widget_contents))
{
$show_simple_tab .= '</div>
			</div>
		  </div>';
}
// display title and summary block ends here					
//Widget design code block 1 starts here																
//Widget design code block 1 starts here			
$i =$i+1;	
$k =$k+1;							  
}
}else
{
	$show_simple_tab .= '</div>
	</div>
  </div>';
}
} elseif($view_mode=="adminview")
{
$show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div>';
$show_simple_tab .= '</div>
	</div>
  </div>';
}else
{
$show_simple_tab .= '</div>
	</div>
  </div>';
	
}

// content list iteration block ends here
//$show_simple_tab .= '</div>';
$j++;
}
echo $show_simple_tab;
?>
