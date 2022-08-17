<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color 		= $content['widget_bg_color'];
$widget_custom_title 	= $content['widget_title'];
$widget_instance_id 	= $content['widget_values']['data-widgetinstanceid'];
$widgetsectionid	 	= $content['sectionID'];
$main_sction_id 		= "";
$is_home 				= $content['is_home_page'];
$is_summary_required 	= $content['widget_values']['cdata-showSummary'];
$widget_section_url 	= $content['widget_section_url'];
$view_mode            	= $content['mode'];
$max_article            = $content['show_max_article'];
$render_mode            = $content['RenderingMode'];
// widget config block ends

$domain_name =  base_url();
$show_simple_tab = "";
$show_simple_tab .='<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-15">
					<div class="business" '.$widget_bg_color.'>';

if($content['widget_title_link'] == 1)
{
	$show_simple_tab.=	'<h4 class="MagazinesTitle"><a href="'.$widget_section_url.'">'.$widget_custom_title.'</a></h4>';
}
else
{
	$show_simple_tab.='<h4 class="MagazinesTitle">'.$widget_custom_title.'</h4>';
}
												
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
	$widget_instance_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'] , $content_type ,  $view_mode);
}
//getting content block ends here

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
$show_simple_tab.= '<div class="features business1"><div class="slide HealthSlider HealthLead">';

	$widget_instance_contents1 = $this->widget_model->get_contentdetails_from_database($get_content_ids, $content_type, $is_home, $view_mode);	
	$widget_contents = array();
	foreach ($widget_instance_contents as $key => $value) {
		foreach ($widget_instance_contents1 as $key1 => $value1) {
			if($value['content_id']==$value1['content_id']){
			   $widget_contents[] = array_merge($value, $value1);
			}
		}
	}
	
	$i = 1;
	$count = 1;
	if(count($widget_contents) > 0 )
	{	
		// content list iteration block - Looping through content list and adding it the list
		// content list iteration block starts here
		foreach($widget_contents as $get_content)
		{
					
			$original_image_path = "";
			$imagealt            = "";
			$imagetitle          = "";
			$custom_title        = "";
			$custom_summary      = "";
			if($render_mode == "manual"){
				if($get_content['custom_image_path'] != ''){
					$original_image_path = $get_content['custom_image_path'];
					$imagealt            = $get_content['custom_image_title'];	
					$imagetitle          = $get_content['custom_image_alt'];												
				}
				$custom_title   = $get_content['CustomTitle'];
				$custom_summary = $get_content['CustomSummary']; 
			}
			if($original_image_path ==""){  // from cms || live table   
			   $original_image_path  = $get_content['ImagePhysicalPath'];
			   $imagealt             = $get_content['ImageCaption'];	
			   $imagetitle           = $get_content['ImageAlt'];	
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
				    $Image600X390  = str_replace("original","w600X390", $original_image_path);	
				}
				if (file_exists(destination_base_path . imagelibrary_image_path . $Image600X390) && $Image600X390 != ''){
					$show_image = image_url. imagelibrary_image_path . $Image600X390;
				}
				else {
					$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
				}
				$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			}
			else{
				$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
				$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			}
			
			$content_url = $get_content['url'];
			$param = $content['page_param'];
			$live_article_url = $domain_name.$content_url."?pm=".$param;
			$display_title = ( $custom_title != '') ? $custom_title : ( ($get_content['title'] != '') ? $get_content['title']: '' ) ;
			$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$display_title);
			$display_title = '<a  href="'.$live_article_url.'" class="article_click" >'.$display_title.'</a>';
			if( $custom_summary == '' && $render_mode=="auto")
				{
					$custom_summary =  $get_content['summary_html'];
				}
			$summary  = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_summary);
			////////  For first Article  /////////
			
			if($i<=5)
			{
				$show_simple_tab .= '<div class="business1 papers margin-bottom-15"><a href="'.$live_article_url.'" class="article_click">';
				$show_simple_tab .= '<img data-lazy="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'"></a>';
				$show_simple_tab .= '<h4 class="subtopic">'.$display_title.'</h4>';
				if($is_summary_required== 1){	
				 $show_simple_tab .= $summary;
				}
				$show_simple_tab .= '</div>';
				if($i==5 || $i == count($widget_contents))
				{
					$show_simple_tab .='</div></div>';
				}
			}
			else
			{
				if($i==6)
				{
					$show_simple_tab .='<div class="business2 common_p health-title margin-bottom-15">';
				}
				$show_simple_tab .='<p> <i class="fa fa-angle-right"></i> <a  href="'.$live_article_url.'" class="article_click"  >'.$display_title.'</a></p>';
				
				if($i==count($widget_contents))
				{
					$show_simple_tab .='</div>';  
				}
			}
					
			$i =$i+1;							  
		} // content list iteration block ends here
	}
}
 elseif($view_mode=="adminview"){
	$show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div>';
}



$show_simple_tab .='</div></div></div>';
echo $show_simple_tab;
?>
