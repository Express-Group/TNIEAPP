<?php header("Content-type: text/xml");
$base_url = base_url();
$url =  "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$atom_url= htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
$sectionUrl  = $base_url.$sectionDetails['section_full_path'];
$sectionName = $sectionDetails['section_name'];
echo "<?xml version='1.0' encoding='UTF-8'?> 
<rss version='2.0' xmlns:atom='http://www.w3.org/2005/Atom'>
<channel>
<title>The New Indian Express - $sectionName - $sectionUrl/</title>
<link>$base_url</link>
<atom:link href=\"$atom_url\" rel=\"self\" type=\"application/rss+xml\"/>
<description>RSS Feed from The New Indian Express</description>
<language>en-us</language>
<copyright>Copyright 2016 The New Indian Express. All rights reserved.</copyright>\n";  
if($sectionDetails['section_type'] == 1){
foreach($contentList as $content):
$id= "<id>".$content['content_id']."</id>";
if(isset($parentSectionDetails['section_name']) && $parentSectionDetails['section_name']!=''){
	$psection = $parentSectionDetails['section_name'];
	$section = $sectionDetails['section_name'];
}else{
	$psection = $sectionDetails['section_name'];
	$section = '';
}
$title = html_entity_decode($content['title']);
$title = strip_tags(str_replace(['&#39;' , '&' , '&nbsp;'], ["'" , '&amp;' , ' '] , $title)); 
$title = preg_replace("|&([^;]+?)[\s<&]|","&amp;$1 ",$title);
$title = trim($title);
$author_name = $content['author_name'];
$published_date = date("l, F j, Y h:i A", strtotime($content['last_updated_on']));
$description = $content['summary'];
$story = '<story><![CDATA['.html_entity_decode(str_replace(['&#39;'],["'"],$content['content'])).']]></story>';
$tags = strip_tags(str_replace(['&', '&#39;'], ['&amp;', "'"] ,$content['tags']));
$image_path = '<image> </image>';
$image_caption = '<imagecaption> </imagecaption>';
if($content['image_path']!=''){
	$imageDetails = hasImage($content['image_path']);
	if($imageDetails['status']==1){
		$imagePath = ASSETURL.IMAGE_PATH. str_replace('original/' ,'medium/' , $content['image_path']);
		$image_path = "<image>".$imagePath."</image>";
		$image_caption= "<imagecaption>".strip_tags($content['image_caption'])."</imagecaption>";
	}
}
$link = $base_url.$content['url'];
echo "<item>
$id
<Pcategory>$psection</Pcategory>
<category>$section</category> 
<title>$title</title>
<author>$author_name</author>
<source>$agency_name</source>
<pubDate>$published_date +0530</pubDate>
<description><![CDATA[$description]]></description>
$story
<tags>$tags</tags>
$image_path
$image_caption
<link>$link</link>
</item>";  
endforeach;
}
echo "\n</channel>\n</rss>";
?>