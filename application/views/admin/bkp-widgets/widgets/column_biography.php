<?php 
$widget_instance_id =  $content['widget_values']['data-widgetinstanceid'];
$page_section_id = $content['page_param'];
$author_id = '';
$section_details = $this->widget_model->get_section_by_id($page_section_id);
$linked_to_columnist = $section_details['AuthorID'];
if($linked_to_columnist != '' || $linked_to_columnist != NULL){
	$author_id = $section_details['AuthorID'];
}
else
{
	$author_name_in_url = ( $this->uri->segment(2) != '' ) ? $this->uri->segment(2) : ''; 
	if($author_name_in_url != ''){
		$author_id_details = $this->widget_model->get_author_by_name($author_name_in_url);
		$author_id = $author_id_details[0]['Author_id'];
	}
}
$show_image = "";
if($author_id != '') {
$author_det = $this->widget_model->get_author($author_id);
$author_name = $author_det[0]['AuthorName'];
//$author_image= $author_det[0]['Displayimage'];
$ShortBiography= $author_det[0]['ShortBiography'];
$column_id= $author_det[0]['column_id'];
//$author_image_id = $author_det[0]['Content_id'];
$author_image = "";
$imagealt = "";
$imagetitle  = "";
/*$image_id  = $author_det[0]['image_id'] ;
if($image_id!='')
{
	$author_details = $this->widget_model->get_image_by_contentid($image_id);
	$author_image  = $author_details['ImagePhysicalPath']; 
	$imagealt             = $author_details['ImageCaption'];	
	$imagetitle           = $author_details['ImageAlt'];
}*/
	
$image_path=$author_det[0]['image_path'] ;
if($image_path !='')
{
	$author_image  = $author_det[0]['image_path']; 
	$imagealt             = $author_det[0]['image_alt'];	
	$imagetitle           = $author_det[0]['image_caption'];
}	
	
//print_r($author_det);exit;
$topicname = $this->widget_model->gettopic_name();
//$image_data = $this->widget_model->get_image_data($author_image_id);																
								
$Image150X150 	= str_replace("original","w150X150", $author_image);
$show_image = "";
if (getimagesize(image_url . $author_image ) && $author_image  != '')
{	
	//die('test');
	 $show_image = image_url. $author_image ;
}
//die();
	

?>
<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="AskPrabhu">
      <table>
      <tbody><tr>
      <td class="AskPrabhuLeft">
      <h2 class="topic WhiteTopic"><?php echo $author_name;?></h2>
      <h4 class="Italic">
	  <?php foreach($topicname as $data)
			{
		   $id = $data['column_id'];
		   if(isset($topic_id)){ if($topic_id == $id){  echo $data['column_name']; }} 
			} ?>
                                                </h4>
      <p><?php echo $ShortBiography;?></p>
      </td>
      <td class="AskPrabhuRight">
	  <?php if($show_image != '') { ?>
      <figure>
      <img src="<?php echo $show_image;?>" data-src="<?php echo $show_image;?>" title="<?php echo $imagetitle; ?>" alt="<?php echo $imagealt; ?>">
      </figure>
	  <?php } ?>
      </td>
      </tr>
      </tbody></table>
      </div>
</div>
</div>
<?php } ?>