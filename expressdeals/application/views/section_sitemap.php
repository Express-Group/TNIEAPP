<?php header ("Content-type: text/xml" , true); ?><?php echo "<?xml version='1.0' encoding='utf-8'?>"; ?>
<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
$min_year = $this->db->query("SELECT DATE_FORMAT((MIN(last_updated_on)), '%Y') as last_year from aff_content")->row_array();
$min_year = $min_year['last_year'];
$baseurl = base_url();
foreach($sectionList as $section):
	for($year=date('Y'); $year>=$min_year; $year--){
		$end_month = 12;
		if($year == date('Y')){
			$end_month = date('m');
		}
		for($month=$end_month; $month>= 1; $month--){
			$total_count = 0;
			$CacheID = "SITEMAP-GET-ROW-FOR-".$section['sid'].'-FOR MONTH-'.$month.'-YEAR-'.$year;
			if(!$this->memcached_library->get($CacheID) && $this->memcached_library->get($CacheID) == ''){
				$this->db->select("content_id");
				$this->db->from("aff_content");
				$this->db->where("section_id",$section['sid']);
				$this->db->where("MONTH(last_updated_on)",$month);
				$this->db->where("YEAR(last_updated_on)",$year);
				$this->db->where("status",1);
				$this->db->group_by("content_id");
				$get = $this->db->get();
				$total_count = $get->num_rows();
				$this->memcached_library->add($CacheID,$total_count);
			}else{
				$total_count = $this->memcached_library->get($CacheID);
			}
			if($total_count > 0){
				?>
				<sitemap><loc><?php echo $baseurl."sitemap.xml?section_id=".$section['sid']."&amp;year=".$year."&amp;month=".$month; ?></loc></sitemap>
				<?php
			}				
		}
	}
endforeach;
?>
</sitemapindex>