<?php
require_once 'db.php';
define('image_url' , 'https://images.newindianexpress.com/');
ini_set('display_errors' , 1);


 $section = (isset($_GET['section']) && $_GET['section']!='') ? $_GET['section'] : '';
 //$section_id = ($_GET['section']=='timepass') ? '435': '436';
if($section=='timepass')
{
$section_id	='435';
$banner_img		=	"timepass_header.png";
}
else
{
$section_id	='436'; 
$banner_img		=	"express-header3.png";
}

if($section==''){
	header("Location: https://www.newindianexpress.com/webcast"); 
	exit;
}
?>
<!DOCTYPE html>
<html lan="en">
	<head>
		<title>webcast | New Indian Express</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="<?php echo image_url; ?>images/FrontEnd/images/favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/slick.css">
		<link rel="stylesheet" href="assets/css/slick-theme.css">
		<link rel="stylesheet" href="assets/css/partialviewslider.min.css">
		<link rel="stylesheet" href="assets/css/style.css?version=23">
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/slick.js"></script>
		<script src="assets/js/partialviewslider.min.js"></script>
		<style>
		.pager-expressions>.active>a, .pager-expressions>.active>a:focus, .pager-expressions>.active>a:hover, .pager-expressions>.active>span, .pager-expressions>.active>span:focus, .pager-expressions>.active>span:hover{
			background-color: #0055a4;
			border-color: #0055a4;
		}
		.pager-timepass>.active>a, .pager-timepass>.active>a:focus, .pager-timepass>.active>a:hover, .pager-timepass>.active>span, .pager-timepass>.active>span:focus, .pager-timepass>.active>span:hover{
			background-color: #ff5722;
			border-color: #ff5722;
		}
		</style>
	</head>
	<body>
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
		<div class="container">
			<!--header-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<header>
						<div class="col-md-1  col-xs-3 col-sm-3" style="border-right: 1px solid #beb9b994;">
							<img src="assets/images/group.jpg" class="img-responsive">
						</div>
						<div class="col-md-3 col-sm-9 col-xs-9 text-center">
							<a href="/webcast"><img src="assets/images/expression-logo2.png" class="expressions-logo"></a>
							<a href="/webcast"><img src="assets/images/expressions_mobile.png" class="expressions-mb-logo"></a>
						</div>
						<div class="col-md-3 hidden-xs hidden-sm">
							<a href="/webcast"><img src="assets/images/timepass.png" class="timepass-logo"></a>
						</div>
						<div class="col-md-1 col-xs-2 col-sm-2 pull-right search-mb hidden">
							<img src="assets/images/search.png" class="search-btn">
						</div>
						<div class="col-md-4 pull-right subscribe-btn hidden">
							<div>Subscribe</div>
							<div><span class="exp-btn">Express</span> <span class="exp-btn">Expressions</span></div>
							<div>Time Pass</div>
						</div>
					</header>
				</div>
			</div>
			<!--header ends-->
			
			
			<!--banner starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="image-banner">
					
							
							<img src="assets/images/<?php echo $banner_img;?>" class="img-responsive">
					</section>
				</div>
			</div>
			<!--banner ends-->
			<!--expression container starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="expression-container">
						<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
							<?php
							$limit = 9;
							if(isset($_GET["page"]) && $_GET["page"]!=''){  
								$pn  = $_GET["page"];  
							}else{  
							  $pn=1;  
							}
							$startFrom = ($pn-1) * $limit; 
							$TotalRows = $connection->query("SELECT content_id  FROM video  WHERE status='P' AND publish_start_date < NOW() AND section_id= '{$section_id}' ");
							$TotalRows = $TotalRows->num_rows;
							$totalLinks = ceil($TotalRows / $limit);
							$pageLink = "<ul class='pagination pager-".$_GET['section']."'>"; 
							$expressionArticles = $connection->query("SELECT content_id ,section_id , section_name ,publish_start_date , title , video_image_path , video_image_alt , video_image_title  FROM video  WHERE status='P' AND publish_start_date < NOW() AND section_id= '{$section_id}' ORDER BY publish_start_date DESC LIMIT {$startFrom}, {$limit}");
							$e=1;
							while($expressionSlides = $expressionArticles->fetch_assoc()):
								$image = image_url.'uploads/user/imagelibrary/logo/nie_logo_600X300.jpg';
								$imageAlt = $imageTitle = '';
								if($expressionSlides['video_image_path']!=''){
									$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X300/' , $expressionSlides['video_image_path']);
									$imageAlt = $expressionSlides['video_image_alt'];
									$imageTitle = $expressionSlides['video_image_title'];
									
								}
								
								$title = $expressionSlides['title'];
								$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title);
								$title = (strlen($title) < 50) ? $title : substr($title , 0  ,47).'...';
								if($e==1){
									echo '<div class="row margin-bottom-15">';
								}
								echo '<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">';
								echo '<a href="article?id='.$expressionSlides['content_id'].'&type=video">
										<img src="'.$image.'" alt="'.$imageAlt.'" title="'.$imageTitle.'" class="img-responsive">
										<p>'.$title.'</p>
										<p>'.strtoupper($expressionSlides['section_name']).'</p>
									</a>';
								echo '</div>';
								if($e==3){
									echo '</div>';
									$e=1;
								}else{
									$e++;
								}
							endwhile;
							if($e!=1){
								echo '</div>';
							}
							for($i=1; $i<=$totalLinks; $i++):
								if($i==$pn):
								$pageLink .= "<li class='active'><a href='section?page=".$i."&section=".$_GET['section']."'>".$i."</a></li>"; 
								else:
								$pageLink .= "<li><a href='section?page=".$i."&section=".$_GET['section']."'>".$i."</a></li>";
								endif;
							endfor;
							$pageLink .= "</ul>"; 
							?>
							<div class="row margin-bottom-15">	
								<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
								<?php
								if($TotalRows > 0){
									echo $pageLink;
								}
								?>
								</div>
							</div>							
						</div>
						<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
							<div class="upcoming-events express-expressions-events">
								<div class="event-header">
									<img src="assets/images/timer.png">
									<span>Next Up</span>
									<span>Catch these sessions live</span>
									<a onclick="nextup(0);" style="cursor:pointer;">See all</a>
								</div>
								<div class="event-body">
									<a>
										<img src="https://images.newindianexpress.com/uploads/user/imagelibrary/2020/5/30/w600X300/ira_a.jpg" class="img-responsive">
										<p>Time Pass: Yoga guru Ira Trivedi shares a dummy’s guide fo...</p>
										<p>May 30, 2020</p>
									</a>
									<a>
										<img src="https://images.newindianexpress.com/uploads/user/imagelibrary/2020/5/30/w600X300/time_pass_a.jpg" class="img-responsive">
										<p>Anuvab Pal and Sonali Gupta tell how to deal with the new no...</p>
										<p>May 30, 2020</p>
									</a>
									<a class="sp-inner">
										<img src="https://images.newindianexpress.com/uploads/user/imagelibrary/2020/5/30/w600X300/ira_a.jpg" class="img-responsive">
										<p>Time Pass: Yoga guru Ira Trivedi shares a dummy’s guide fo...</p>
										<p>May 30, 2020</p>
									</a>
									<a class="sp-inner">
										<img src="https://images.newindianexpress.com/uploads/user/imagelibrary/2020/5/30/w600X300/time_pass_a.jpg" class="img-responsive">
										<p>Anuvab Pal and Sonali Gupta tell how to deal with the new no...</p>
										<p>May 30, 2020</p>
									</a>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
			<!--expression container ends-->
			<!--hr starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="hr">
							<hr>
					</section>
				</div>
			</div>		
			
			
			
			
			
			<!--footer starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="footer">
						<p class="text-center">Copyright - newindianexpress.com 2020</p>
						<p><a class="AllTopic" href="https://epaper.morningstandard.in/" rel="nofollow" target="_blank">The Morning Standard | </a><a class="AllTopic" href="https://www.dinamani.com" rel="nofollow" target="_blank">Dinamani | </a> <a class="AllTopic" href="https://www.kannadaprabha.com" rel="nofollow" target="_blank">Kannada Prabha | </a>  <a class="AllTopic" href="https://www.samakalikamalayalam.com" rel="nofollow" target="_blank">Samakalika Malayalam | </a><a class="AllTopic" href="https://www.indulgexpress.com" rel="nofollow" target="_blank">Indulgexpress  | </a>  <a class="AllTopic" href="https://www.edexlive.com" rel="nofollow" target="_blank">Edex Live  | </a> <a class="AllTopic" href="https://www.cinemaexpress.com" rel="nofollow" target="_blank">Cinema Express |  </a> <a class="AllTopic" href="http://www.eventxpress.com" rel="nofollow" target="_blank">Event Xpress </a></p>
						<p> <a class="AllTopic" href="https://www.newindianexpress.com/contact-us">Contact Us | </a> <a class="AllTopic" href="https://www.newindianexpress.com/about-us">About Us | </a> <a class="AllTopic" href="https://www.newindianexpress.com/careers">Careers | </a><a class="AllTopic" href="https://www.newindianexpress.com/privacy-policy">Privacy Policy | </a> <a class="AllTopic" href="https://www.newindianexpress.com/topic">Search | </a> <a class="AllTopic" href="https://www.newindianexpress.com/terms-of-use">Terms of Use | </a> <a class="AllTopic" href="https://www.newindianexpress.com/advertise-with-us">Advertise With Us </a></p>
						<p> <a class="AllTopic" href="https://www.newindianexpress.com/">Home | </a> <a class="AllTopic" href="https://www.newindianexpress.com/nation">Nation | </a> <a class="AllTopic" href="https://www.newindianexpress.com/world">World | </a> <a class="AllTopic" href="https://www.newindianexpress.com/cities">Cities | </a> <a class="AllTopic" href="https://www.newindianexpress.com/business">Business | </a> <a class="AllTopic" href="https://www.newindianexpress.com/opinions/columns">Columns | </a> <a class="AllTopic" href="https://www.newindianexpress.com/entertainment">Entertainment | </a> <a class="AllTopic" href="https://www.newindianexpress.com/sport">Sport | </a> <a class="AllTopic" href="https://www.newindianexpress.com/magazine">Magazine | </a> <a class="AllTopic" href="https://www.newindianexpress.com/thesundaystandard">The Sunday Standard  </a></p>
					</section>
				</div>
			</div>
			<!--footer ends-->
		</div>
		<script>
			function nextup(type){
				if(type==1){
					$('.timepass-events').find('.event-body').css({'height' :'497px' , 'overflow-y':'scroll'});
					$('.timepass-events').find('.sp-inner').show();
				}else{
					$('.express-expressions-events').find('.event-body').css({'height' :'497px' , 'overflow-y':'scroll'});
					$('.express-expressions-events').find('.sp-inner').show();
				}
			}
		</script>
	</body>
</html> 