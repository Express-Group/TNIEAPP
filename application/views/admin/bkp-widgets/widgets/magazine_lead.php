<?php 
// widget config block Starts - This code block assign widget background colour, title and instance id. Do not delete it 
$widget_bg_color     = $content['widget_bg_color'];
$widget_custom_title = $content['widget_title'];
$widget_instance_id  =  $content['widget_values']['data-widgetinstanceid'];
$main_sction_id 	 = "";
$is_home             = $content['is_home_page'];
$is_summary_required = $content['widget_values']['cdata-showSummary'];
$widget_section_url  = $content['widget_section_url'];
$view_mode           = $content['mode'];
$max_article         = $content['show_max_article'];
$render_mode         = $content['RenderingMode'];
// widget config block ends
$domain_name =  base_url();
$show_simple_tab     = "";
$show_simple_tab    .='<div class="row">
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       <div class="MagazinesLead" '.$widget_bg_color.'>';
					   if($content['widget_title_link'] == 1)
{
$show_simple_tab.=	' <legend class="topic"><a href="'.$widget_section_url.'" >'.$widget_custom_title.'</a></legend>';
}
else
{
$show_simple_tab.=	' <legend class="topic">'.$widget_custom_title.'</legend>';
}
					   
					 //  $show_simple_tab    .='<h2 class="MagazinesTitle title">Magazine</h2>';
// Adding content Block starts here
//getting content block - getting content list based on rendering mode
//getting content block starts here . Do not change anything
if($render_mode == "manual")
{
	$content_type = $content['content_type_id'];
  $widget_instance_contents 	= $this->widget_model->get_widgetInstancearticles_rendering($widget_instance_id,"",$content['mode'], $max_article); 						 
}
else
{
  $content_type = $content['content_type_id'];  // auto article content type
  $widget_instance_contents = $this->widget_model->get_all_available_articles_auto($max_article, $content['sectionID'] , $content_type ,  $content['mode']);
}
//getting content block ends here
//Widget code block - code required for simple tab structure creation. Do not delete
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
			foreach ($widget_instance_contents as $key => $value) 
			{
				foreach ($widget_instance_contents1 as $key1 => $value1) 
				{
					if($value['content_id']==$value1['content_id'])
					{
					   $widget_contents[] = array_merge($value, $value1);
					}
				}
			}

$i =1;

if(count($widget_contents)>0)
{
    foreach($widget_contents as $get_content)
	{
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
			$imagealt            = $get_content['custom_image_title'];	
			$imagetitle          = $get_content['custom_image_alt'];												
			}
			$custom_title   = $get_content['CustomTitle'];
			$custom_summary = $get_content['CustomSummary'];
		}
		if($original_image_path =="")      // from cms || live table    
		{
		$original_image_path  = $get_content['ImagePhysicalPath'];
		$imagealt             = $get_content['ImageCaption'];	
		$imagetitle           = $get_content['ImageAlt'];	
		}
		$show_image="";
	    if($i%2 != 0)
		{
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
			
				if (getimagesize(image_url . imagelibrary_image_path . $Image600X390) && $Image600X390 != '')
				{
				$show_image = image_url. imagelibrary_image_path . $Image600X390;
				}
				else 
				{
				$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
				}
			$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			}
		    else
			{
			$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			}
		}
		elseif($i%2 == 0)
		{
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
				else 
				{
				$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
				}
			$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
			}
			else
			{
			$show_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
			$dummy_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
			}
		}
		$content_url = $get_content['url'];
		$param = $content['page_param'];
		$live_article_url = $domain_name.$content_url."?pm=".$param;
	
		if( $custom_title == '')
		{
		$custom_title = $get_content['title'];
		}	
		$display_title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_title);   //to remove first<p> and last</p>  tag
		$display_title = '<a  href="'.$live_article_url.'" class="article_click" >'.$display_title.'</a>';	
		// Assign summary block starts here
		if( $custom_summary == '' && $render_mode=="auto")
		{
		$custom_summary =  $get_content['summary_html'];
		}
		$summary  = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$custom_summary);  //to remove first<p> and last</p>  tag
		// Assign summary block starts here
		//if($i == 1) 
		if($i%2 != 0)
		{
		$show_simple_tab.=	'<div class="MagazinesLead-1"> 
		<div class="MagazinesLead-1Img">
		
		<a  href="'.$live_article_url.'" class="article_click"  >
		<img src="'.$dummy_image.'" data-src="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'"></div>
		<div class="MagazinesLead-1Cont"><h2> '.$display_title.'</a></h2>';
			if($is_summary_required== 1)
			{
			$show_simple_tab.='<p class="summary">'.$summary.'</p>';
			}
			
			if($content['widget_title_link'] == 1)
			{
			$show_simple_tab .=' <div class="arrow_right"><a href="'.$widget_section_url.'" class="landing-arrow">arrow</a></div>';
			}

		$show_simple_tab.='</div>';
		
		$show_simple_tab.='</div>';
		}
		// if($i%2==0)
		elseif($i%2 == 0)
		{
		$show_simple_tab.=	' <div class="MagazinesLead-2">
		<a href="'.$live_article_url.'" class="article_click" >
		<img src="'.$dummy_image.'" data-src="'.$show_image.'" title = "'.$imagetitle.'" alt = "'.$imagealt.'">
		<div class="MagazinesLead-2Cont">
		<h4> '.$display_title.'
		</a></h4>';
			if($is_summary_required== 1)
			{
			$show_simple_tab.='<p class="summary">'.$summary.'</p>';
			}
			
			if($content['widget_title_link'] == 1)
			{
			$show_simple_tab .=' <div class="arrow_right"><a href="'.$widget_section_url.'" class="landing-arrow">arrow</a></div>';
			}


		$show_simple_tab.=	'</div></div>';
		}
	// display title and summary block ends here					
	//Widget design code block 1 starts here																
	//Widget design code block 1 starts here			
		$i =$i+1;							  
	}
  }
} 
 elseif($view_mode=="adminview")
{
$show_simple_tab .='<div class="margin-bottom-10">'.no_articles.'</div>';
}
	// content list iteration block ends here
	// Adding content Block ends here
$show_simple_tab .='</div></div></div>';
echo $show_simple_tab;
?>
