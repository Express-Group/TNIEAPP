<?php
ini_set('display_errors' , 1);
require_once 'db.php';
define('image_url' , 'https://images.newindianexpress.com/');
$articleLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$contentId = (isset($_GET['id']) && $_GET['id']!='') ? $_GET['id'] : '';
$contentType = (isset($_GET['type']) && $_GET['type']!='') ? $_GET['type'] : '';
if($contentId=='' || $contentType==''){
	header("Location: https://www.newindianexpress.com/webcast"); 
	exit;
}
if($contentType=='video'){
	$videoDetails = $connection->query("SELECT content_id , section_name , publish_start_date , title , summary_html , video_script , video_image_path , video_image_alt , video_image_title , agency_name , author_name , meta_Title , meta_description , no_indexed , no_follow FROM video WHERE content_id='".$contentId."' AND status='P' AND publish_start_date < NOW()");
	$videoDetails = $videoDetails->fetch_assoc();
}else{
	$videoDetails = $connection->query("SELECT content_id , section_name , publish_start_date , title , summary_html , article_page_content_html , article_page_image_path , article_page_image_alt , article_page_image_title , agency_name , author_name , meta_Title , meta_description , no_indexed , no_follow FROM article WHERE content_id='".$contentId."' AND status='P' AND publish_start_date < NOW()");
	$videoDetails = $videoDetails->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lan="en">
	<head>
		<title><?php echo preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$videoDetails['title']); ?> - Webcast  | New Indian Express</title>
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
			<?php if($contentType=='article' && count($videoDetails) > 0 && $videoDetails['article_page_image_path']!=''): ?>
			<!--article image section-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="slider embed-section">
						<img src="<?php echo image_url.'uploads/user/imagelibrary/'.$videoDetails['article_page_image_path']; ?>" alt="<?php echo $videoDetails['article_page_image_alt']; ?>" title="<?php echo $videoDetails['article_page_image_title']; ?>" class="img-responsive" style="width:100%;">
					</section>
				</div>
			</div>
			<!--article image ends-->
			<?php endif; ?>
			<?php if(($contentType=='video' && count($videoDetails) > 0) || ($contentType=='article' && count($videoDetails) > 0)): 
			if($contentType=='video'):?>
			<!--youtube embed section-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="slider embed-section">
						<?php echo $videoDetails['video_script']; ?>
					</section>
				</div>
			</div>
			<!--youtube embed section ends-->
			<?php endif; ?>
			<!--article heading section-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="slider article-heading">
						<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
							<?php
							$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$videoDetails['title']);
							?>
							<h5><?php echo $title; ?></h5>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
						<p><?php echo strtoupper($videoDetails['section_name']); ?></p>
						<p><?php echo strtoupper($videoDetails['author_name']); ?></p>
						<p><b><i>PUBLISHED: <?php echo strtoupper(date( 'dF Y, h:i', strtotime($videoDetails['publish_start_date']))).' IST'; ?></i></b></p>
						</div>
					</section>
				</div>
			</div>
			<!--article heading section ends-->
			<?php endif; ?>
			<!--article content section-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="slider article-content">
						<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
							<div class="article-details">
								<div class="social-icons">
									<img class="share-save" src="assets/images/social-icons/share.png">
									<a target="_BLANK" href="https://www.facebook.com/dialog/share?app_id=114452938652867&display=popup&href=<?php echo $articleLink; ?>"><img src="assets/images/social-icons/fb.png"></a>
									<a target="_BLANK" href="http://www.twitter.com/share?url=<?php echo urlencode($articleLink); ?>"><img src="assets/images/social-icons/twitter.png"></a>
									<a target="_BLANK" href="https://api.whatsapp.com/send?text=<?php echo urlencode($articleLink); ?>"><img src="assets/images/social-icons/whatsapp.png"></a>
									<a target="_BLANK" href="mailto:?body=<?php echo urlencode($articleLink); ?>"><img src="assets/images/social-icons/mail.png"></a> 
								</div>
								<div class="contents">
								<?php 
								if($contentType=='video' && count($videoDetails) > 0):
									echo $videoDetails['summary_html'];
								endif;
								?>
								<?php 
								if($contentType=='article' && count($videoDetails) > 0):
									echo $videoDetails['article_page_content_html'];
								endif;
								?>
								</div>
							</div>
							<!--suggestion container starts-->
							<div class="row">
								<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
									<section class="suggestion">
										<div class="row">
											<h3 style="font-weight: 700;color: #fe5723;" class="text-center">SPOTLIGHT</h3>
											<div class="single-item">
												<?php
												$spotlightArticles = $connection->query("SELECT v.content_id , v.section_id , v.section_name , v.publish_start_date , v.title , v.video_image_path , v.video_image_alt , v.video_image_title , w.CustomTitle , w.custom_image_path , w.custom_image_title , w.custom_image_alt FROM video as v INNER JOIN widgetinstancecontent_live as w ON v.content_id = w.content_id WHERE v.status='P' AND v.publish_start_date < NOW() AND w.content_type_id=4 AND w.WidgetInstance_id = '18470' AND w.Status=1");
												while($spotlist = $spotlightArticles->fetch_assoc()):
													$image = image_url.'uploads/user/imagelibrary/logo/nie_logo_150X150.jpg';
													$imageAlt = $imageTitle = '';
													if($spotlist['video_image_path']!=''){
														$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w150X150/' , $spotlist['video_image_path']);
														$imageAlt = $spotlist['video_image_alt'];
														$imageTitle = $spotlist['video_image_title'];
														
													}
													if($spotlist['custom_image_path']!=''){
														$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w150X150/' , $spotlist['custom_image_path']);
														$imageAlt = $spotlist['custom_image_alt'];
														$imageTitle = $spotlist['custom_image_title'];
													}
													$title = ($spotlist['CustomTitle']!='') ? $spotlist['CustomTitle'] : $spotlist['title'];
													$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title);
													$title = (strlen($title) < 63) ? $title : substr($title , 0  ,60).'...';
													echo '<div class="col-md-4">
															<div class="ls">
																<img src="'.$image.'" class="img-responsive">
																<div class="ls-content">
																	<div class="icon">
																		<img src="assets/images/play_button.png" class="img-responsive">
																	</div>
																	<div class="ls-details">
																		<a href="article?id='.$spotlist['content_id'].'&type=video">
																			<p>'.$title.'</p>
																			<p>'.$spotlist['section_name'].'</p>
																		</a>
																	</div>
																</div>
															</div>
														</div>';
												endwhile;
												?>
											</div>
										</div>
										
									</section>
									<script>
									jQuery(function($) { 
									$('.single-item').slick({
									  dots: false,
									  infinite: true,
									  speed: 300,
									  slidesToShow: 3,
									  slidesToScroll: 1,
									  arrows: true,
									  responsive: [
										{
										  breakpoint: 1024,
										  settings: {
											slidesToShow: 3,
											slidesToScroll: 1,
											infinite: true,
											dots: true
										  }
										},
										{
										  breakpoint: 600,
										  settings: {
											slidesToShow: 1,
											slidesToScroll: 1
										  }
										},
										{
										  breakpoint: 480,
										  settings: {
											slidesToShow: 1,
											slidesToScroll: 1
										  }
										}
									  ]
									});
									});
									</script>
								</div>
							</div>
							<!--suggestion container ends-->
						</div>
						<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
							<div class="twitter-widget-1">
								<a class="twitter-timeline" href="https://twitter.com/NewIndianXpress" data-widget-id="432851638651330560">@NewIndianXpress</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
							</div>
							<div class="upcoming-events margin-top-15">
								<div class="event-header">
									<img src="assets/images/timer1.png">
									<span>Next Up</span>
									<span>Catch these sessions live</span>
								</div>
								<div class="event-body">
									<?php
									$nextUpEpressionArticles = $connection->query("SELECT v.content_id , v.section_id , v.section_name , v.publish_start_date , v.title , v.video_image_path , v.video_image_alt , v.video_image_title , w.CustomTitle , w.custom_image_path , w.custom_image_title , w.custom_image_alt FROM video as v INNER JOIN widgetinstancecontent_live as w ON v.content_id = w.content_id WHERE v.status='P' AND v.publish_start_date < NOW() AND w.content_type_id=4 AND w.WidgetInstance_id = '18476' AND w.Status=1");
									while($nextUpArticles = $nextUpEpressionArticles->fetch_assoc()):
										$image = image_url.'uploads/user/imagelibrary/logo/nie_logo_600X300.jpg';
										$imageAlt = $imageTitle = '';
										if($nextUpArticles['video_image_path']!=''){
											$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X300/' , $nextUpArticles['video_image_path']);
											$imageAlt = $nextUpArticles['video_image_alt'];
											$imageTitle = $nextUpArticles['video_image_title'];
											
										}
										if($nextUpArticles['custom_image_path']!=''){
											$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X300/' , $nextUpArticles['custom_image_path']);
											$imageAlt = $nextUpArticles['custom_image_alt'];
											$imageTitle = $nextUpArticles['custom_image_title'];
										}
										$title = ($nextUpArticles['CustomTitle']!='') ? $nextUpArticles['CustomTitle'] : $nextUpArticles['title'];
										$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title);
										$title = (strlen($title) < 63) ? $title : substr($title , 0  ,60).'...';
										echo '<a href="article?id='.$nextUpArticles['content_id'].'&type=video">
												<img src="'.$image.'" class="img-responsive">
												<p>'.$title.'</p>
												<p>'.date( 'F d, Y', strtotime($nextUpArticles['publish_start_date'])).'</p>
											</a>';
									endwhile;
									?>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
			<!--article content section ends-->
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
	</body>
</html>  