<?php
$sec=30;
$page=Current_url();
$css_path 		= image_url."css/FrontEnd/";
$js_path 		= image_url."js/FrontEnd/";
$images_path	= image_url."images/FrontEnd/";
///if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
$content_id      = @$content_id;
$content_from    = $content_from;
$content_type_id = @$content_type;
$viewmode        = $viewmode;
$settings = $this->widget_model->select_setting($viewmode);
//$page_det = $this->widget_model->widget_article_content_by_id($content_id, $content_type_id);
$page_det        = $article_details;
$page_det        = $page_det[0];
$Image600X390    = "";
$Image600X390 	 = ($content_type_id==1)? $page_det['article_page_image_path']: (($content_type_id==3)? $page_det['first_image_path']: (($content_type_id==4)? $page_det['video_image_path']: $page_det['audio_image_path']));
$bigimage = image_url. imagelibrary_image_path.'logo/nie_logo_1200x800.jpg';
	if ($Image600X390 != '' && getimagesize(image_url_no . imagelibrary_image_path . $Image600X390))
	{
		$imagedetails = getimagesize(image_url_no . imagelibrary_image_path.$Image600X390);
		$imagewidth   = $imagedetails[0];
		$imageheight  = $imagedetails[1];
		$bigimage 	= str_replace("original","w1200X800", $Image600X390);
		if ($imageheight > $imagewidth){
			$Image600X390 	= $Image600X390;
		}else{				
			$Image600X390 	= str_replace("original","w600X390", $Image600X390);
		}
		$image_path = '';
		$image_path = image_url. imagelibrary_image_path . $Image600X390;
		$checkBigImage = explode('/',$Image600X390);
		//print_r($checkBigImage);
		if((int) $checkBigImage[0] >=2020){
			if ($bigimage != '' && getimagesize(image_url_no . imagelibrary_image_path . $bigimage)){
				$bigimage = image_url. imagelibrary_image_path . $bigimage;
			}else{
				$bigimage = $image_path;
			}
		}else{
			$bigimage = $image_path;
		}
		
	}
else
{
	$image_path	   = image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
	$image_caption = '';	
}
$content      = strip_tags($page_det['summary_html']);
$current_url  = explode('?', Current_url());
$share_url    = base_url().$page_det['url'];
$noFollowSectionIds = array(369 ,335 , 356);
$noFollowArticleIds = array(1757263,2042751,2043618,2052847,2063405,2063507,2065541,2067919,2070274,2070734,2100305,2102942,2113684,2117457,2121371,2129606,1553237,
1553844,1928105,1928538,1928542,1929046,1929052,1929078,1931134,1931514,1932956,1940816,1941803,1941808,1943577,1944880,1944891,1947581,1950167,1950667,
1951105,1952745,1954903,1955728,1959733,1959805,1960242,1965080,1966365,1966366,1969350,1975096,1977332,1978146,1982437,1984195,1988831,1988834,1991417,1994665,1994714,1995689,1996211,1996642,1999493,2002048,2002504,2004205,2004208,2006335,2009779,2011126,2013622,2015035,2015970,2016587,2025522,2025530,2025560,2028317,2029865,2030338,2032578,2032580,2033050,2035056,2038894,2041330,1741546,1742430,1745115,1745375,1746170,1748664,1749547,1750728,1759406,
1762665,1763180,1766091,1767241,1767243,1768620,1768720,1769246,1769833,1770837,1772227,1772253,1772738,1772740,1773331,1773807,1774273,1774656,1774657,
1775673,1775678,1776119,1779686,1779687,1779689,1780168,1780674,1783425,1783426,1784050,1784564,1786510,1786511,1787462,1787568,1791394,1791420,1793705,1793707,1793709,1793747,1794295,1796884,1796893,1798370,1804476,1805669,1806326,1808330,1808331,1808333,1809631,1810197,1811280,1811283,1812291,1814517,1815457,1815823,1818872,1818876,1822814,1826564,1827712,1828513,1831937,1832484,1833364,1833416,1833960,1834392,1838047,1840572,1844096,1844097,1844538,1845529,1846534,1846560,1847863,1848466,1848467,1851178,1851179,1852219,1853220,1855895,1860759,1864449,1864451,1864960,1865598,1867929,1867931,1868337,1868825,1880586,1897213,1913662,1560866,1560868,1563442,1563459,1567966,1569134,1581289,1581660,1581661,1589781,1600993,1600995,1601791,1603685,1605485,1611222,1614704,1614705,1619760,1624994,1629924,1645327,1653647,1662400,1678467,1681421,1690839,1721134,1721148,1724245,1724261,1724284,1727854,1731066,1732185,1735093,1735094,1738636,1738713,1739596);

$index        = ($page_det['no_indexed']==1)? 'NOINDEX' : 'INDEX';
$follow       = ($page_det['no_follow'] == 1) ? 'NOFOLLOW' : 'FOLLOW';
if(in_array($content_id , $noFollowArticleIds)){ $index='NOINDEX'; $follow='NOFOLLOW'; }
if(in_array($page_det['section_id'] , $noFollowSectionIds)){ $index='NOINDEX'; $follow='NOFOLLOW'; }

$AMP=0;
$Canonicalurl = $share_url;//($page_det['canonical_url']!='') ? $page_det['canonical_url'] : '';
$StandoutStatus=0;
if($content_type_id==1){
	//$AmpStatus=$this->widget_model->AmpStatus($content_id);
	//if($AmpStatus['status']==1):
	$Canonicalurl = str_replace('.html','.amp',$share_url);
	$AMP=1;
	//endif;
}else if($content_type_id==3){
	$Canonicalurl = str_replace('.html','.amp',$share_url);
	$AMP=1;
}
$meta_title   = stripslashes(str_replace('\\', '', $page_det['meta_Title']));//($page_det['meta_Title']);
$meta_description = stripslashes($page_det['meta_description']);
$tags         = count($page_det['tags'])? $page_det['tags'] : '';

$query_string = ($_SERVER['QUERY_STRING']!='') ? "?".$_SERVER['QUERY_STRING'] : "";

if($content_from =='archive')
{
$index        = 'INDEX';
$follow       = 'FOLLOW';
if(in_array($content_id , $noFollowArticleIds)){ $index='NOINDEX'; $follow='NOFOLLOW'; }
if(in_array($page_det['section_id'] , $noFollowSectionIds)){ $index='NOINDEX'; $follow='NOFOLLOW'; }
if($meta_description=='')
$meta_description	= $meta_title;
}
$pubDate = date_format(date_create($page_det['publish_start_date']),"Y-m-d\TH:i:s\+05:30");
$LastUpDate = date_format(date_create($page_det['last_updated_on']),"Y-m-d\TH:i:s\+05:30");
$newsKeywords = $tags;
if($content_id=='2240571'){
$newsKeywords = 'Bitcoin price, Bitcoin value, bitcoin share, Ethereum, cryptocurrency, Bitcoin trade, cryptocurrency exchange, bitcoin stock, bitcoin news, bitcoin share price, ETH price, top 5 cryptocurrencies, bitcoin latest news, ripple payment, XRP current price, BTC price';	
}

if($content_id=='2265776'){
$newsKeywords = 'employee monitoring software, Work from home, WFH, pandemic, employee monitoring systems,
EmpMonitor, time tracking, workpuls, projects and tasks tracking, computer monitoring, productivity software,
employee monitoring software India, Online Employee PC Monitoring Software';	
}

if($content_id=='2243205'){
$newsKeywords = 'aachi global school, aachi global school vacancies, aachi global school ayanambakkam, aachi global school reviews, aachi global school anna Nagar, 
international schools in Chennai, international schools in Chennai anna nagar, best schools in Chennai anna nagar, matriculation schools in Chennai, CBSE schools in Chennai, best schools in Chennai, Aachi Global International CBSE, ib school Chennai, aachi global school news';	
}
if($content_id=='2245819'){
$newsKeywords = 'higher interest rate, Public Provident Fund, Bajaj Finance FD Calculator, National Pension Scheme, small savings schemes, interest rates, Recurring Deposit, post office RD, RD interest rates, Fixed Deposit, FD interest rates, Bajaj Finance online FD, Systematic Deposit Plan';	
}
if($content_id=='2262713'){
$newsKeywords = 'Bajaj Housing Finance, Bajaj Housing Finance home loan, Bajaj Housing Finance home loan interest rates, Bajaj Housing Finance home loan processing fee, home loan interest rates, emi calculator for home loan Bajaj Housing Finance, Bajaj Housing Finance home loan calculator';	
}
if($content_id=='2267289'){
$newsKeywords = 'binomo, binomo app, binomo india, binomo review, binomo trading app, best trading app in india, 
online earnig mobile app, trading platform app, honest trading app, binomo traders, online trading app, Popular trading platform.';	
}

if($content_id=='2272733'){
$newsKeywords = 'ULIP Plan, ULIP policy, ULIP Investment plan, ULIP investment policy plan, ULIP good returns policy, 
life cover ULIP policy, insurance plans, tax benefits plans, life cover policy, Bajaj Allianz Life Insurance, ULIP calculator, 
ULIP bajaj allianz plan, Bajaj Finance, Bajaj Allianz Life plan, Bajaj Allianz Life policy.';	
}

if($content_id=='2280960'){
$newsKeywords = 'Bajaj Finserv e-home loan,e-home loan fees,e-home loan interest rate,bajaj housing loan,bajaj home loan online,Instant Digital Home Loan, 
Fast Track Home Loan,Bajaj Housing Finance E-Home Loan,Bajaj Housing Finance Limited,Home loan interest rate,Bajaj Finance E-Home Loan,Bajaj Finance Home Loan,Bajaj Finance Digital Home Loan';	
}

if($content_id=='2283520'){
$newsKeywords = 'car insurance online,  car insurance Policy,  Renew Car Insurance Online, 
Car Insurance Policy in India, Car Insurance Renewal, Car Insurance Renewal online, Best car insurance in India,Best Car Insurance Companies in India, Car insurance online check, Bajaj Allianz car insurance';	
}

if($content_id=='2283965'){
$newsKeywords = 'Bajaj Allianz Life, ULIP, ULIP Fund, Investment Plan, bajaj allianz life insurance ulip plan, bajaj allianz life insurance, life insurance plan, ulip plan,Ulip Investment Plan, ulip fund performance, bajaj allianz investment, bajaj allianz ulip plans, bajaj allianz ulip plans review';	
}
if($content_id=='2290818'){
$newsKeywords = 'Visa platinum plus debit card , platinum plus debit card , induslnd debit card , best bedit card , best induslnd debit card , Induslnd platinum plus debit card benefits , induslnd platinum debit card , Online Induslnd debit card , Induslnd debit card benefits , Induslnd debit card features , Visa platinum plus debit card features , online savings account , savings account interest rate , IndusInd Bank Platinum Plus Debit Card';	
}
if($content_id=='2292822'){
$newsKeywords = 'online PDF converter, How to convert PDF, JPG to PDF Converter, Excel to PDF Converter, Convert PDG file online, best PDF converter, Free online PDF converter, Free Online Document Converter, online word to pdf converter, online JPG to PDF Converter, Lua PDF Converter online, Lua PDF Converter features, Lua PDF Converter free';	
}
if($content_id=='2293391'){
$newsKeywords = 'Small business solutions, Centre of excellence, Cisco Solutions, NipunNet, IaaS for business, Cisco DNA Spaces, nView, IoT Sensor monitoring, surveillance systems, people tracking applications, IoT sensors';	
}

if($content_id=='2296862'){
$newsKeywords = 'cibil score check, cibil score meaning, what is cibil score, what cibil score is good, CIBIL score range, cibil score check online,CIBIL score, credit score,New Credit Customers,Banks Credit score';	
}

if($content_id=='2307348'){
$newsKeywords = 'happenstance slippers, happenstance shoes, happenstance shoes review, happenstance sandals online, happenstance review, happenstance sandals india, sandals for men, sandals for women, fashion sandals';	
}
if($content_id=='2317108'){
$newsKeywords = 'bajaj finserv emi card, bajaj finserv emi card apply online, bajaj finserv emi card login, bajaj finserv emi card customer care number, bajaj finserv emi store, bajaj finserv emi calculator, bajaj finserv emi payment online, bajaj finserv emi apply online, bajaj finserv emi amazon, bajaj finserv emi app, bajaj finserv emi available phones, 5g mobiles in india, 5g mobile under 20000, 5g mobile phones, 5g mobile under 15000, 5g mobile price in india';	
}







?>
<?php
   // $ExpireTime = ($content_from=="live") ? 60 : 86400; // seconds (= 2 mins)
    $ExpireTime = ($content_from=="live") ? 240 : 86400; // seconds (= 4 mins)
	//$this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	$this->output->set_header("Cache-Control: cache, must-revalidate");
	$this->output->set_header("Cache-Control: max-age=".$ExpireTime);
	$this->output->set_header("Pragma: cache");
	$this->output->set_header("Access-Control-Allow-Origin: *");
	
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="alternate" href="<?php echo Current_url().$query_string;?>" hreflang="en"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="max-age=600, public">
<title><?php echo strip_tags($meta_title);?>- The New Indian Express</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="title" content="<?php echo strip_tags($meta_title);?>" />
<meta name="description" content="<?php echo $meta_description;?>">
<meta name="keywords" content="<?php echo $tags;?>">
<meta name="news_keywords" content="<?php echo $newsKeywords;?>">
<meta name="msvalidate.01" content="E3846DEF0DE4D18E294A6521B2CEBBD2" />
<link rel="canonical" href="<?php echo $share_url; ?>" />
<?php if($AMP==1): ?>
<link rel="amphtml" href="<?php echo $Canonicalurl; ?>" />
<?php endif; ?>
<meta name="robots" content="<?php echo $index;?>, <?php echo $follow;?>">
<meta property="fb:app_id" content="2362293504088255" />
<meta property="fb:pages" content="178988994793" />
<meta property="og:url" content="<?php echo $share_url;?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo strip_tags($page_det['title']);?>"/>
<meta property="og:image" content="<?php echo $image_path;?>"/>
<meta property="og:image:width" content="450"/>
<meta property="og:image:height" content="298"/>
<meta property="og:site_name" content="The New Indian Express"/>
<meta property="og:description" content="<?php echo $content;?>"/>
<!--<meta name="twitter:card" content="<?php echo $content;?>" /> -->
<meta name="twitter:card" content="summary_large_image" /> 
<meta name="twitter:creator" content="NewIndianXpress" />
<meta name="twitter:site" content="@newindianexpress.com" />
<meta name="twitter:title" content="<?php echo strip_tags($page_det['title']);?>" />
<meta name="twitter:description" content="<?php echo $content;?>" />
<meta name="twitter:image" content="<?php echo $image_path;?>" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ if (window.scrollY == 0) window.scrollTo(0,1); }; </script>
<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:700' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
<link rel="shortcut icon" href="<?php echo $images_path; ?>images/favicon.ico" type="image/x-icon" />
<link href="//www.googletagservices.com" rel="dns-prefetch">
<link href="//www.googletagservices.com" rel="preconnect" crossorigin>
<link href="//www.google-analytics.com" rel="dns-prefetch">
<link href="https://www.google-analytics.com/" rel="preconnect" crossorigin>
<link href="https://images.newindianexpress.com/" rel="preconnect" crossorigin>
<link href="//tpc.googlesyndication.com" rel="dns-prefetch">
<link href="https://code.jquery.com/" rel="preconnect" crossorigin>
<link rel="stylesheet" href="<?php echo $css_path; ?>css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo $css_path; ?>css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo $css_path; ?>css/style.min.css?v=1.3" type="text/css">
<script src="<?php echo $js_path; ?>js/jquery.min.js"></script>
<script src="<?php echo $js_path; ?>js/slider-custom-lazy.min.js?v=1" type="text/javascript"></script>
<script type="text/javascript">
<?php 
	  $section_id              = $page_det['section_id'];
	  $parent_section_id       = $page_det['parent_section_id'];
	  $grand_parent_section_id = $page_det['grant_section_id'];
	  $mode = $viewmode; ?>
	  var Section_id = '<?php echo $section_id;?>';
	  var PSection_id = '<?php echo $parent_section_id;?>';
	  var GPSection_id = '<?php echo $grand_parent_section_id;?>';
	  var view_mode = '<?php echo $mode;?>';
	  var css_path = '<?php echo $css_path; ?>';
	  <?php if(isset($html_header)&& $html_header==true){ ?>
	   var call_active_menu = 1;
	   <?php }else{ ?>
	   var call_active_menu = 0;
	   <?php }  
	   if(isset($html_rightpanel)&& $html_rightpanel==true){ ?>
	    var call_otherstories = 0;
	  <?php }else{ ?>
	    var call_otherstories = 0;
	<?php  }?>
$(document).ready(function () {
<!--replace slick preview as arrow-->
$('.slick-prev').addClass('fa fa-chevron-left');
$('.slick-next').addClass('fa fa-chevron-right');	
});
</script>

<!-- Start Advertisement Script -->
<?php 
if(SHOWADS):
	echo urldecode($header_ad_script);
	$articleHeaderScript = rawurldecode(stripslashes($settings['article_header_script']));
	echo ($section_id==356) ? str_replace('<script type="text/javascript" src="https://backfills.ph.affinity.com/phdd/affdd.js"></script>' ,'' ,$articleHeaderScript) : $articleHeaderScript;
endif;
?>
<!-- End Advertisement Script -->

<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "WebSite", 
  "name" : "The New Indian Express",
  "url" : "https://www.newindianexpress.com",
  "potentialAction" : {
    "@type" : "SearchAction",
    "target" : "https://www.newindianexpress.com/topic?term={search_term}&request=ALL&search=short",
    "query-input" : "required name=search_term"
  }                     
}
</script>

<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Organization",
  "name" : "The New Indian Express",
  "url" : "https://www.newindianexpress.com",
  "sameAs" : [
    "https://www.facebook.com/thenewindianxpress",
	"https://twitter.com/NewIndianXpress",
	"https://www.youtube.com/user/thenewindianxpress",
	"https://en.wikipedia.org/wiki/The_New_Indian_Express"
  ]
}
</script>
<?php
$schematitle = strip_tags($page_det['title']);
$schematitle = (count($schematitle) >= 110) ? $schematitle : substr($schematitle , 0 , 107).'...';
if($content_from!='live'){
	$articleDescription = str_replace(['"' , "'"] ,['\u0022' ,'\u0027'],stripslashes($page_det['summary_html']));
	$articleDescription = stripslashes(html_entity_decode($articleDescription));	
}else{
	$articleDescription = stripslashes(html_entity_decode($page_det['summary_html']));	
}
$articleDescription = strip_tags($articleDescription);
$schemadata= [
	"@context" => "http://schema.org",
	"@type" => "NewsArticle",
	"mainEntityOfPage" => [
		"@type" => "WebPage",
		"@id" => $share_url
	],
	"headline" => $schematitle,
	"description" => $articleDescription
];
if($content_type_id==1){
if($content_from!='live'){
	$articleBody = str_replace(['"' , "'"] ,['\u0022' ,'\u0027'],$page_det['article_page_content_html']);
	$articleBody = stripslashes(html_entity_decode($articleBody));	
}else{
	$articleBody = stripslashes(html_entity_decode($page_det['article_page_content_html']));	
}
$articleBody = strip_tags($articleBody);
$schemadata["articleBody"] = $articleBody;
$schemadata["wordCount"] = strlen(strip_tags($page_det['article_page_content_html']));
}
$schemadata["datePublished"] = $pubDate;
$schemadata["dateModified"] = $LastUpDate;
$schemadata["inLanguage"] = "en";
$schemadata["keywords"] = strip_tags($page_det['tags']);
$schemadata["publisher"] = [
	"@type" => "Organization",
	"name" => "The New Indian Express",
	"logo" =>[
		"@type" => "ImageObject",
		"url" => image_url."images/FrontEnd/images/NIE-logo21.jpg",
		"width" => 165,
		"height" => 60
	]
];
$schemadata["author"] = [
	"@type" => "Person",
	"name" => (isset($page_det['author_name']) && $page_det['author_name']!='') ? $page_det['author_name'] : $page_det['agency_name']
];
$schemadata["image"] = [
	"@type" => "ImageObject",
	"url" => $bigimage,
	"width" => 1200,
	"height" =>800
	
];
$schemadata = json_encode(utf8ize($schemadata));
$schemadata = str_replace(["\\n" ,'\"' ,"\\t"], ["" ,"\u0022",""], $schemadata);
?>
<script type="application/ld+json">
<?php echo $schemadata; ?>
</script>
<?php 
/* if($content_type_id==1 && $page_det['section_id']==363){
	$LiveCount=$this->widget_model->GetLiveNewsCount($content_id,$page_det['section_id']); 
	if($LiveCount!=0){
		$liveFile = FCPATH.'application/views/LIVENOW/'.$content_id.'.json';
		$liveLastUpdated = date_format(date_create(date('Y-m-d H:i:s' , filemtime($liveFile))),"Y-m-d\TH:i:s\+05:30");
		$liveSchema = [];
		$liveSchema['@context'] = 'http://schema.org';
		$liveSchema['@type'] = 'LiveBlogPosting';
		$liveSchema['url'] = $share_url;
		$liveSchema['mainEntityOfPage'] = $share_url;
		$liveSchema['about'] = [];
		$liveSchema['about']['@type'] = 'Event';
		$liveSchema['about']['name'] = $schematitle;
		$liveSchema['about']['startDate'] = $pubDate;
		$liveSchema['about']['endDate'] = $liveLastUpdated;
		$liveSchema['about']['eventAttendanceMode'] = 'Mixed';
		$liveSchema['about']['eventStatus'] = 'Live';
		$liveSchema['about']['location'] = [];
		$liveSchema['about']['location']['@type'] = 'Place';
		$liveSchema['about']['location']['name'] = 'India';
		$liveSchema['about']['location']['address'] = [];
		$liveSchema['about']['location']['address']['@type'] = 'PostalAddress';
		$liveSchema['about']['location']['address']['name'] = 'India';
		$liveSchema = json_encode(utf8ize($liveSchema));
		$liveSchema = str_replace(["\\n" ,'\"' ,"\\t"], ["" ,"\u0022",""], $liveSchema);
		echo '<script type="application/ld+json">'.$liveSchema.'</script>';
	}
} */
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MMDZD5');</script>
<!-- End Google Tag Manager -->
<script type="text/javascript">
	window.GUMLET_CONFIG = {
		hosts: [{
			current: "images.newindianexpress.com",
			gumlet: "images.newindianexpress.com"
		}],
		lazy_load: true
	};
	(function(){d=document;s=d.createElement("script");s.src="https://cdn.gumlet.com/gumlet.js/2.0/gumlet.min.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();
</script>
<style>img{height:auto;}</style>
<?php if($section_id!=356): ?>
<script> const scriptEl = document.createElement('script'); scriptEl.src = 'https://trinitymedia.ai/player/trinity/2900008700/?pageURL=' + encodeURIComponent(window.location.href); document.currentScript.parentNode.insertBefore(scriptEl, document.currentScript); </script> 
<?php endif;?>
</head>
<?php
$content_url = $page_det['url'];

$url_array = explode('/', $content_url);
$get_seperation_count = count($url_array)-4;

$sectionURL = ($get_seperation_count==1)? $url_array[0] : (($get_seperation_count==2)? $url_array[0]."/".$url_array[1] : $url_array[0]."/".$url_array[1]."/".$url_array[2]);
$section_url = base_url().$sectionURL."/";
/*if($content_from=="live"){
$section_url =  $section_url; 
}*/
?>
<body class="article_body" itemscope itemtype="<?php echo $section_url;?>">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MMDZD5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php 
	if($viewmode == "live")
	{
	?>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-2311935-30', 'auto');
ga('send', 'pageview');
setTimeout("ga('send','event','adjusted bounce rate','page visit 30 seconds or more')",30000);
</script>
<!-- Begin comScore Tag -->
<script>
  var _comscore = _comscore || [];
  _comscore.push({ c1: "2", c2: "16833363" });
  (function() {
    var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
    s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
    el.parentNode.insertBefore(s, el);
  })();
</script>
<noscript>
  <img src="https://sb.scorecardresearch.com/p?c1=2&c2=16833363&cv=2.0&cj=1" />
</noscript>
<!-- End comScore Tag -->
<?php	
	}
?>
<style>
.cssload-container-article img{
position: absolute;
    right:0;
    top: 0;
    width: 70px;
}
.cssload-container-article .cssload-zenith {
    height: 70px;
    width: 70px;
}
.cssload-container-article figure{ 
    left: 50%;
    position: fixed;
    top: 50%;
}

.CenterMarginBg{
	z-index:0;
}
.sticky-right{width:300px;}

@media only screen and (max-width: 1550px) and (min-width: 1297px){

.main-menu {
	 margin-left: 0 !important;
	  width: 100% !important;
}
.widget-container-30 .col-lg-12{
	padding:0 !important;
}

.RightArrow {
    margin-left: 1085px;
    top: 360px;
}
.LeftArrow{
left: 38px;
}
.PrintSocial{
	left:1%;
}
}

.article-col .col-md-4{
	margin-top:3%;
}
.LeftArrow,.RightArrow{
	display:none !important;
}
/* .section-header,.section-content,.section-footer{
	background:#fff;
} */
.player-tools{width: 100%;float: left;margin: 15px 0 15px;display: flex;justify-content: center;}
.player-tools img{width: 32px;margin-right: 8px;cursor: pointer;}
.player-voice-tools{width: 100%;float: left;border-top: 1px solid #0075ff;padding: 15px 0 15px;}
.player-voice-tools .form-control{border: none;box-shadow: none;display: flex;justify-content: space-around;margin-bottom: 10px;}
.player-voice-tools label{font-weight: 500;color: #8d8686;}
.player-voice-tools input[type=range]{margin-bottom: 15px;}
.hidetools{opacity: .2;pointer-events:none;}
.ArticleDetail .popover{width: 210px!important;}
</style>
<div class="cssload-container cssload-container-article" id="load_spinner">
  <figure> <img src="<?php echo $images_path; ?>images/loader-Nie.png" />
    <div class="cssload-zenith"></div>
  </figure>
</div>
<div class="container side-bar-overlay">
  <div class="left-trans"></div>
  <div class="right-trans"></div>
</div>
<?php //echo $header; ?>
<!--<div class="wait" id="load_spinner">
   <i class="wait-spinner wait-spin centerZone"></i>
  </div>-->
<div class=""  data-remodal-options="hashTracking: false, closeOnOutsideClick: false" role="dialog"  id="" style="position:relative;"> <?php echo  $header.$body .$footer; ?> </div>
<?php 
if(isset($_GET['pm'])!=0 && is_numeric($_GET['pm'])){
$section_details = $this->widget_model->get_sectionDetails($_GET['pm'], $viewmode); //live db
$close_url       = (count($section_details)>0)? base_url().$section_details['URLSectionStructure']: "home";
}else{
$close_url ="home";
}

?>
<!--<script src="<?php echo $js_path; ?>js/remodal_custom.min.js" type="text/javascript"></script>
--> 
<script src="<?php echo image_url; ?>js/FrontEnd/js/remodal-article_updated.js?version=2.1"></script>
<script src="<?php echo $js_path; ?>js/jquery.csbuttons.js" type="text/javascript"></script> 
<?php if($content_type_id==1){ ?>
<script src="<?php echo $js_path; ?>js/article-pagination.js?art=<?php print rand(1,12000); ?>" type="text/javascript"></script>
<?php } ?>
<?php if($content_type_id==1 || $content_type_id==3){ ?>
<script src="<?php echo $js_path; ?>js/jquery.twbsPagination.min.js" type="text/javascript"></script>
<?php } ?>
<script>
var close_url = "<?php echo $close_url;?>";
$( document ).ready(function() {
	$('#load_spinner').hide();
	$('.menu').affix({
	offset: {
	top: $('header').height()
	}
	});
/*$("html, body").animate({
	scrollTop: 0
});*/
//$('html').addClass('loading_time');
//var inst = $('[data-remodal-id=article]').remodal();
//inst.open();
 //$('[data-remodal-id=article]').remodal();

$(document).on('opened', '.remodal', function () {
  console.log('Modal is opened');
   $('.SectionContainer').append('<button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>');
 $('.CenterMarginBg').hide();
  $('#load_spinner').hide();
  $('.side-bar-overlay').show();
   $('.menu').affix({
	offset: {
	top: $('header').height()
	}
	});	
	$('.remodal-close').affix({
	offset: {
	top: $('header').height()
	}
	});
});

   $(document).on('closed', '.remodal', function () {	
	<?php /*?><?php if($close_url =='home'){ ?>
	window.location.href = '<?php echo base_url();?>';
    <?php } else {	?>
	window.location.href = '<?php echo $close_url;?>';
	 <?php  }?><?php */?>

	 var bck = localStorage.getItem("callback_section");
	 if(bck =='null'||bck ==null)
	   {
		window.location.href ="https://www.newindianexpress.com/";
	   }
	 else
	   {
	 window.location.href = localStorage.getItem("callback_section");
	   }
	 //window.location.href = (localStorage.getItem("callback_section")!="null")? localStorage.getItem("callback_section"): //window.location.origin;
   });

$('.remodal-main-overlay:not(.container)').click(function(){
//inst.close();
});
  $('.LeftArrow').click(function(){
  //inst.close();
  $('#load_spinner').show();
 });
  $('.RightArrow').click(function(){
  //inst.close();
  $('#load_spinner').show();
 });
});
</script>
<script src="<?php echo $js_path; ?>js/postscribe.min.js"></script>
<div class="mobile_share">
	<!--<span id="mbp" style="display:none;" onclick="mfb('prev')"><img src="<?php echo image_url ?>images/FrontEnd/images/social-article/prev.png?v=1"></span>-->
	<span class="mfb" onclick="mfb('flipboard')"><svg aria-hidden="true" data-prefix="fab" data-icon="flipboard" class="" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="font-size: 24px;width: 23px;float: left;margin: 0 32%;box-shadow: 2px 2px #2c457c;"><path fill="#fff" d="M0 32v448h448V32H0zm358.4 179.2h-89.6v89.6h-89.6v89.6H89.6V121.6h268.8v89.6z"></path></svg> flipboard</span>
	<span class="mf" onclick="mfb('facebook')"><i class="fa fa-facebook-square" aria-hidden="true"></i> facebook</span>
	<span class="mt" onclick="mfb('twitter')"><i class="fa fa-twitter-square" aria-hidden="true"></i> twitter</span>
	<span class="mw" onclick="mfb('whatsapp')"><i class="fa fa-whatsapp" aria-hidden="true"></i> whatsapp</span>
	<span class="mbn" id="mbn" style="display:none;" onclick="mfb('prev')"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i> Next</span> 
	<script>
		var mb_prev = $('#mb_prev').val();
		var mb_next = $('#mb_next').val();
		if(mb_prev!='' && mb_prev!=undefined){
			$('#mbn').show();
		} 
		/* if(mb_next!='' && mb_next!=undefined){
			$('#mbn').show();
		} */
		function mfb(type){
			if(type=='whatsapp'){
				$('.whatsapp').click();
			}else if(type=='email'){
				var sub =$('a[data-type="twitter"]').attr('data-txt');
				var body  =$('meta[property="og:url"]').attr('content');
				window.open('mailto:?subject='+sub+'&body='+body);
			}else if(type=='prev'){
				window.location.href= mb_prev;
			}else if(type=='next'){
				if(mb_next!=undefined && mb_next!=''){
					window.location.href= mb_next;
				}
			}else{
				$('a[data-type="'+type+'"]').click();
			}
		}
	</script>
</div>
<?php
$countryCode = ['US','EU'];
$country = (isset($_SERVER['HTTP_CLOUDFRONT_VIEWER_COUNTRY']) && $_SERVER['HTTP_CLOUDFRONT_VIEWER_COUNTRY']!='') ? $_SERVER['HTTP_CLOUDFRONT_VIEWER_COUNTRY'] : '';
if(in_array($country , $countryCode)):
?>
<script type="text/javascript">
    (function (){ var s,m,n,h,v,se,lk,lk1,bk; n=false; s= decodeURIComponent(document.cookie); m = s.split(';'); for(h=0;h<m.length;h++){ if(m[h]==' cookieagree=1'){n=true;break;}}if(n==false){v = document.createElement('div');v.setAttribute('style','position: fixed;left: 0px;right: 0px;height: auto;min-height: 15px;z-index: 2147483647;background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(29, 47, 157, 0.9) 35%, rgb(66, 68, 69) 100%);color: rgb(255, 255, 255);line-height: 15px;padding: 8px 18px;font-size: 14px;text-align: left;bottom: 0px;opacity: 1;');v.setAttribute('id','ckgre');se = document.createElement('span');se.setAttribute('style','padding: 5px 0 5px 0;float:left;');lk =document.createElement('button');lk.setAttribute('onclick','ckagree()');lk.setAttribute('style' , 'float: right;display: block;padding: 5px 8px;min-width: 100px;margin-left: 5px;border-radius: 25px;cursor: pointer;color: rgb(0, 0, 0);background: rgb(241, 214, 0);text-align: center;border: none;font-weight: bold;outline: none;');lk.appendChild(document.createTextNode("Agree"));	se.appendChild(document.createTextNode("We use cookies to enhance your experience. By continuing to visit our site you agree to our use of cookies."));lk1 = document.createElement('a');lk1.href=document.location.protocol+"//"+document.location.hostname+"/cookies-info";lk1.setAttribute('style','text-decoration: none;color: rgb(241, 214, 0);margin-left: 5px;');lk1.setAttribute('target','_BLANK');lk1.appendChild(document.createTextNode("More info"));se.appendChild(lk1);v.appendChild(se);v.appendChild(lk);bk = document.getElementsByTagName('body')[0];bk.insertBefore(v,bk.childNodes[0]);}})();function ckagree(){ document.cookie = "cookieagree=1;path=/";$('#ckgre').hide(1000, function(){ $(this).remove();});}
</script>
<?php
endif;
?>
<script type="text/javascript">
	var stickyRight = {};stickyRight.isDesktop = "<?php echo (isset($_SERVER['HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER']) && $_SERVER['HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER']=='true') ? 1 : 0 ?>";stickyRight.advClass = $( ".sticky-right" ).last();	stickyRight.advInnerClass = $(stickyRight.advClass).children(".sticky");stickyRight.articleContainer = $('.SectionContainer');stickyRight.offset = {top : 40 , left: 0 , right : 10 , bottom : 25};	stickyRight.execute = function(){if(this.isDesktop=='1' && this.advClass.length > 0 && this.articleContainer.length > 0){window.addEventListener("scroll", function(){			var fh = stickyRight.articleContainer.height() + stickyRight.articleContainer.offset().top - stickyRight.advInnerClass.height() - stickyRight.offset.top - stickyRight.offset.bottom;var wh = $(window).scrollTop() | $("body").scrollTop();var jh = stickyRight.advClass.offset().top;stickyRight.offset.left = stickyRight.offset.left + stickyRight.advInnerClass.offset().left;if (wh  > jh - stickyRight.offset.top && wh < fh){		stickyRight.advClass.removeAttr("style");stickyRight.advInnerClass.css({ position: "fixed", top: stickyRight.offset.top + "px", bottom: "auto" ,zIndex :1});}else{if(wh > jh - stickyRight.offset.top && wh > fh){						stickyRight.advClass.css({ position: "absolute", left: "auto", bottom: stickyRight.offset.bottom + "px", top: "auto" });stickyRight.advInnerClass.removeAttr("style");}else{if(wh < jh){stickyRight.advClass.removeAttr("style");				stickyRight.advInnerClass.removeAttr("style");}}}});}};stickyRight.execute();

<?php if(SHOWADS): ?>
var ffFlag = (navigator.userAgent.toLowerCase().indexOf('firefox') !== -1);
if(ffFlag) {
$(window).bind("load", function() {
    googletag.pubads().refresh();  
});
}
<?php endif; ?>
$(document).ready(function(e){
	var synth = window.speechSynthesis;
	$('#speak').popover({ 
		title : 'Listen to this article',
		html : true,
		placement : "bottom",
		content: function(){
			return '<div class="player-tools"><span data-action="play" class="speak-action play-action hidetools"><img src="<?php echo image_url; ?>images/speech/play.png"></span><span style="display:none;" data-action="resume" class="speak-action resume-action"><img src="<?php echo image_url; ?>images/speech/play.png"></span><span data-action="pause" class="speak-action"><img src="<?php echo image_url; ?>images/speech/pause1.png"></span><span data-action="stop" class="speak-action"><img src="<?php echo image_url; ?>images/speech/stop.png"></span></div><div class="player-voice-tools hidetools"><div class="form-control"><label class="radio-inline"><input value="0" type="radio" name="voice">Male</label><label class="radio-inline"><input value="5" type="radio" name="voice" checked>Female</label></div><label>Volume</label><input type="range" id="volume" min="0" max="1" value="1" step="0.1"><label>Rate</label><input type="range" id="rate" min="0.1" max="10" value="1" step="0.1"><label>Pitch</label><input type="range" id="pitch" min="0" max="2" step="0.1" value="1"></div>';   
        }
	});
	/* $('#speak').on('shown.bs.popover', function(){
		$('.play-action').trigger('click');
	}); */
	$(document).on('click' , '.speak-action' , function(e){
		if (!'speechSynthesis' in window){
			alert('Sorry your browser does not support speech synthesis.');
			return false;
		}
		var action= $(this).data('action');
		var voices = speechSynthesis.getVoices();
		console.log(voices);
		var timerSpeed = 7500;
		var iOS = /Mac|iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
		switch(action){
			case 'play' :
				var speechtext = new SpeechSynthesisUtterance();
				speechtext.text = "<?php echo htmlspecialchars_decode(strip_tags($page_det['title']) , ENT_QUOTES).'. '; ?>"+$('#speaktext').val().trim();
				speechtext.voice = voices[2];
				if(screen.width > 800 || document.documentElement.clientWidth > 800){
					speechtext.voice = voices[$('input[name="voice"]:checked').val()];
				}
				speechtext.volume = ($('#volume').val()!= undefined) ? parseFloat($('#volume').val()) : 1;
				speechtext.rate = ($('#rate').val()!= undefined) ? parseFloat($('#rate').val()) : 1;
				speechtext.pitch = ($('#pitch').val()!= undefined) ? parseFloat($('#pitch').val()) : 1;
				if(iOS==true && (screen.width < 800 || document.documentElement.clientWidth < 800)){
					speechtext.voice = voices[5];
					speechtext.pitch = 0.8;
				}
				if(iOS==true && (screen.width > 800 || document.documentElement.clientWidth > 800)){
					speechtext.voice = voices[50];
					speechtext.pitch = 0.7;
				}
				
				speechtext.lang = 'en-GB';
				setTimeout(() => {
					synth.speak(speechtext);
				}, 0);
				if(screen.width > 800 || document.documentElement.clientWidth > 800){
					timer = setTimeout(function pauseResumeTimer(){
						synth.pause();
						console.log(speechtext);
						setTimeout(() => {
							synth.resume();
						}, 0);
						timer = setTimeout(pauseResumeTimer, timerSpeed)
					}, timerSpeed);
				}
				$('.speak-action').removeClass('hidetools');
				$(this).addClass('hidetools');
				$('.player-voice-tools').addClass('hidetools');
				$('.controls-action').show();
				$('.play-btn').hide();
				$('.pause-btn').show().removeClass('hidetools');
			break;
			case 'pause' :
				synth.pause();
				if(screen.width > 800 || document.documentElement.clientWidth > 800){
					clearTimeout(timer);
				}
				$('.speak-action').removeClass('hidetools');
				$('.resume-action').show();
				$('.play-action').hide();
				$(this).addClass('hidetools');
				$('.pause-btn').hide();
				$('.resume-btn').show();
				//$('#speak').popover('hide');
				
			break;
			case 'resume' :
				synth.resume();
				if(screen.width > 800 || document.documentElement.clientWidth > 800){
					timer = setTimeout(function pauseResumeTimer(){
						synth.pause();
						console.log(speechtext);
						setTimeout(() => {
							synth.resume();
						}, 0);
						timer = setTimeout(pauseResumeTimer, timerSpeed)
					}, timerSpeed);
				}
				$('.speak-action').removeClass('hidetools');
				$('.resume-action').hide();
				$('.play-action').show().addClass('hidetools');
				$(this).addClass('hidetools');
				$('.pause-btn').show();
				$('.resume-btn').hide();
				//$('#speak').popover('hide');
			break;
			case 'stop' :
				synth.cancel();
				if(screen.width > 800 || document.documentElement.clientWidth > 800){
					clearTimeout(timer);
				}
				$('.speak-action').addClass('hidetools');
				$('.resume-action').hide();
				$('.play-action').show().removeClass('hidetools');
				$('.player-voice-tools').removeClass('hidetools');
				$('.controls-action').hide();
				$('.play-btn').show();
				$('.pause-btn ,.resume-btn ,.controls-action').hide();
				$('.play-btn').show().removeClass('hidetools');
				$('#speak').popover('hide');
			break;
		}
	});
});
</script>
</script> 
</body>
</html>
