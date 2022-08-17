<?php header ("Content-type: text/xml" , true); ?><?php echo "<?xml version='1.0' encoding='utf-8'?>"; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:n="http://www.google.com/schemas/sitemap-news/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php
$baseurl = base_url();
$sectionId = $this->input->get('section_id');
$year = $this->input->get('year');
$month = $this->input->get('month');
$CacheID = "SITEMAP-GET-ARTICLE-FOR-".$section['sid'].'-FOR MONTH-'.$month.'-YEAR-'.$year;
if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''){
	/* $this->db->select("last_updated_on,url");
	$this->db->from("aff_content");
	$this->db->where("section_id",$sectionId);
	$this->db->where("MONTH(last_updated_on)",$month);
	$this->db->where("YEAR(last_updated_on)",$year);
	$this->db->where("status",1);
	$this->db->group_by("content_id");
	$get = $this->db->get();
	$list = $get->result_array(); */
	$list = $this->db->query("SELECT last_updated_on , url FROM aff_content WHERE status=1 AND (approve_status =1 OR approve_status=2) AND section_id='".$sectionId."' AND MONTH(last_updated_on)='".$month."' AND YEAR(last_updated_on)='".$year."' GROUP BY content_id")->result_array();
	$this->memcached_library->add($CacheID,$list);
}else{
	$list = $this->memcached_library->get($CacheID);
}
foreach($list as $items){
?>	
<url>
<loc><?php echo $baseurl.html_entity_decode(@$items['url'], null, "UTF-8"); ?></loc>
<lastmod><?php echo gmdate('Y-m-d\TH:i:s+00:00',strtotime(@$items['last_updated_on'])); ?></lastmod>
<changefreq>monthly</changefreq>
<priority>0.7</priority>
</url>
<?php
}
?>
</urlset>