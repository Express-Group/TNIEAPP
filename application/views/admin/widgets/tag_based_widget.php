<style>
	@media (min-width: 1200px)
	.col-lg-12 {width: unset;}
</style>
<?php
$count 		= str_replace(["style='background-color:" ,";'"] ,"" ,$content['widget_bg_color']);
$widget_instance_id	 	= $content['widget_values']['data-widgetinstanceid'];
$view_mode              = $content['mode'];
$widget_instance_details= $this->widget_model->getWidgetInstance('', '','', '', $widget_instance_id, $content['mode']);
$widget_position = $content['widget_position'];
$tagName = trim($widget_instance_details['AdvertisementScript']);
$CI = &get_instance();
$this->live_db = $CI->load->database('live_db' , TRUE);
$result = $this->live_db->query("SELECT content_id, title, url, article_page_image_path, article_page_image_title, article_page_image_alt FROM article WHERE tags LIKE '".$tagName."%' AND status = 'P' AND publish_start_date < NOW() LIMIT 3")->result();

$imageUrl = image_url. imagelibrary_image_path;
echo '<div class="VideoGallery"><div class="WidthFloat_L">';
echo '<h4 class="topic"><a target="_BLANK" href="'.BASEURL.'topic/'.str_replace(' ' , '_' , $tagName).'">'.$tagName.'</a></h4>';
foreach($result as $news){
	$image = (($news->article_page_image_path != '') ? str_replace('original', 'w600X300', $imageUrl.$news->article_page_image_path) : 'logo/nie_logo_600X300.jpg');
	$url = $news->url;
	$title = strip_tags($news->title);
	echo '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 VideoGallerySplit">';
		echo '<a href="'.BASEURL.$url.'">';
			echo '<img data-src="'.$image.'" src="'.image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg" title="'.strip_tags($news->article_page_image_title).'" alt="'.strip_tags($news->article_page_image_alt).'">';
			echo '<p style="margin-top: 10px;font-family: \'Droid Serif\';">'.$title.'</p>';
		echo '</a>';
	echo '</div>';
}
echo '</div></div>';
?>