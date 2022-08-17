<?php
require_once 'db.php';
define('image_url' , 'https://images.newindianexpress.com/');
ini_set('display_errors' , 1);

?>
<!DOCTYPE html>
<html lan="en">
	<head>
		<title>Webcast | New Indian Express</title>
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
		<script src="assets/js/partialviewslider.min.js?version=16"></script>
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
						<div style="display:none;" class="col-md-1 col-xs-2 col-sm-2 pull-right search-mb">
							<img src="assets/images/search.png" class="search-btn">
						</div>
						<div style="display:none;" class="col-md-4 pull-right subscribe-btn">
							<div>Subscribe</div>
							<div><span class="exp-btn">Express</span> <span class="exp-btn">Expressions</span></div>
							<div>Time Pass</div>
						</div>
					</header>
				</div>
			</div>
			<!--header ends-->
			<div class="row">
				<!--slider-->
				<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 padding-right-0">
					<section class="slider">
						<h5 class="slider-title-main">TRENDING</h5>
						<ul id="partial-view" style="display:none;">
							<?php
							$sliderArticles = $connection->query("SELECT v.content_id , v.section_id , v.section_name , v.publish_start_date , v.title , v.video_image_path , v.video_image_alt , v.video_image_title , w.CustomTitle , w.custom_image_path , w.custom_image_title , w.custom_image_alt FROM video as v INNER JOIN widgetinstancecontent_live as w ON v.content_id = w.content_id WHERE v.status='P' AND v.publish_start_date < NOW() AND w.content_type_id=4 AND w.WidgetInstance_id = '18467' AND w.Status=1");
							while($slides = $sliderArticles->fetch_assoc()):
								$image = image_url.'uploads/user/imagelibrary/logo/nie_logo_600X300.jpg';
								$imageAlt = $imageTitle = '';
								if($slides['video_image_path']!=''){
									$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X390/' , $slides['video_image_path']);
									$imageAlt = $slides['video_image_alt'];
									$imageTitle = $slides['video_image_title'];
									
								}
								if($slides['custom_image_path']!=''){
									$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X390/' , $slides['custom_image_path']);
									$imageAlt = $slides['custom_image_alt'];
									$imageTitle = $slides['custom_image_title'];
								}
								$title = ($slides['CustomTitle']!='') ? $slides['CustomTitle'] : $slides['title'];
								$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title);
								$title = (strlen($title) < 63) ? $title : substr($title , 0  ,60).'...';
								echo '<li>';
								echo '<img src="'.$image.'" alt="'.$imageAlt.'" title="'.$imageTitle.'" />';
								echo '<div class="slider-text">
										<div class="col-md-2 col-sm-2 col-xs-2" style="padding: 0;">
											<img style="margin-left: -16%;" class="img-responsive" src="assets/images/play_button.png">
										</div>
										<div class="col-md-10 col-sm-10 col-xs-10">
											<p><a style="color:#000;text-decoration:none;" href="article?id='.$slides['content_id'].'&type=video">'.$title.'</a></p>
										</div>
									</div>';
								echo '</li>';
							endwhile;
							?>
						</ul>
						<script>
						$(document).ready(function(){
							if(screen.width < 800 || document.documentElement.clientWidth < 800) {
								var partialView = $('#partial-view').partialViewSlider({width:100});
							}else{
								var partialView = $('#partial-view').partialViewSlider({width:100});
							}
							$('#partial-view').show();
						});
						</script>
					</section>
				</div>
				<!--slider ends-->
				<!--slider-->
				<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 padding-left-0">
					<section class="slider">
						<h5 class="slider-title-main">COMING UP</h5>
						<ul id="partial-view1" style="display:none;">
							<li><img class="pimg1" src="assets/images/expressions.jpg"></li> 
							
							
						</ul>
						<script>
						$(document).ready(function(){
							if(screen.width < 800 || document.documentElement.clientWidth < 800) {
								var partialView = $('#partial-view1').partialViewSlider({width:100});
							}else{
								var partialView = $('#partial-view1').partialViewSlider({width:100});
							}
							$('#partial-view1').show();
						});
						</script>
					</section>
				</div>
				<!--slider ends-->
			</div>
			<!--banner starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="image-banner presenting-patner">
							<h4 class="text-center"><b>Presenting Partners</b></h4>
							<img src="assets/images/presenting-patner.jpg" class="img-responsive presenting-patner-1">
							<div class="col-xs-6 presenting-patner-2">
								<img src="assets/images/patner1.jpg" class="img-responsive" style="margin-bottom:5px;">
								<img src="assets/images/patner2.jpg" class="img-responsive" style="margin-bottom:5px;">
							</div>
							<div class="col-xs-6 presenting-patner-2">
								<img src="assets/images/patner3.jpg" class="img-responsive" style="margin-bottom:5px;">
								<img src="assets/images/patner4.jpg" class="img-responsive" style="margin-bottom:5px;">
							</div>
							<div class="col-xs-6 col-xs-offset-3 presenting-patner-2">
								<img src="assets/images/patner5.jpg" class="img-responsive" style="margin-bottom:5px;">
							</div>
					</section>
				</div>
			</div>
			<!--banner ends-->
			<!--banner starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="image-banner">
							<img src="assets/images/express-header3.png" class="img-responsive">
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
							$expressionArticles = $connection->query("SELECT v.content_id , v.section_id , v.section_name , v.publish_start_date , v.title , v.video_image_path , v.video_image_alt , v.video_image_title , w.CustomTitle , w.custom_image_path , w.custom_image_title , w.custom_image_alt FROM video as v INNER JOIN widgetinstancecontent_live as w ON v.content_id = w.content_id WHERE v.status='P' AND v.publish_start_date < NOW() AND w.content_type_id=4 AND w.WidgetInstance_id = '18468' AND w.Status=1 LIMIT 9");
							$e=1;
							while($expressionSlides = $expressionArticles->fetch_assoc()):
								$image = image_url.'uploads/user/imagelibrary/logo/nie_logo_600X300.jpg';
								$imageAlt = $imageTitle = '';
								if($expressionSlides['video_image_path']!=''){
									$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X300/' , $expressionSlides['video_image_path']);
									$imageAlt = $expressionSlides['video_image_alt'];
									$imageTitle = $expressionSlides['video_image_title'];
									
								}
								if($expressionSlides['custom_image_path']!=''){
									$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X300/' , $expressionSlides['custom_image_path']);
									$imageAlt = $expressionSlides['custom_image_alt'];
									$imageTitle = $expressionSlides['custom_image_title'];
								}
								$title = ($expressionSlides['CustomTitle']!='') ? $expressionSlides['CustomTitle'] : $expressionSlides['title'];
								$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title);
								$title = (strlen($title) < 50) ? $title : substr($title , 0  ,47).'...';
								if($e==1){
									echo '<div class="row margin-bottom-15">';
								}
								echo '<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">';
								echo '<a href="article?id='.$expressionSlides['content_id'].'&type=video">
										<img src="'.$image.'" alt="'.$imageAlt.'" title="'.$imageTitle.'" class="img-responsive">
										<img src="assets/images/icon.webp" class="icon">
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
							?>
							<div class="row margin-bottom-15">
								<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-right">
									<a href="section?section=expressions" class="read-more" style="cursor:pointer;">Watch More >></a>
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
										<img src="assets/images/exp-4-6_Ashok Ghelot.jpg" class="img-responsive">
										<p>Express Expressions : Ashok Gehlot </p>
										<p>June 04, 2020</p>
									</a>
									<a>
										<img src="assets/images/ExpAnil-05-06.jpg" class="img-responsive">
										<p> Anil Sahasrabudhe, Chairman, All India Council for Technical Education
											On Online Education in he Post-Virus World In Conversation with Kaveree Bamzai, Author and Journalist
											And S. Vaidhyasubramaniam,Vice-Chancellor, Sastra Deemed University
											</p>
										<p>June 05, 2020</p>
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
			<!--hr ends-->
			<!--banner starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="image-banner">
							<img src="assets/images/timepass_header.png" class="img-responsive">
					</section>
				</div>
			</div>
			<!--banner ends-->
			<!--timepass container starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="expression-container">
						<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
							<?php
							$timepassArticles = $connection->query("SELECT v.content_id , v.section_id , v.section_name , v.publish_start_date , v.title , v.video_image_path , v.video_image_alt , v.video_image_title , w.CustomTitle , w.custom_image_path , w.custom_image_title , w.custom_image_alt FROM video as v INNER JOIN widgetinstancecontent_live as w ON v.content_id = w.content_id WHERE v.status='P' AND v.publish_start_date < NOW() AND w.content_type_id=4 AND w.WidgetInstance_id = '18469' AND w.Status=1 LIMIT 9");
							$t=1;
							while($timepassSlides = $timepassArticles->fetch_assoc()):
								$image = image_url.'uploads/user/imagelibrary/logo/nie_logo_600X300.jpg';
								$imageAlt = $imageTitle = '';
								if($timepassSlides['video_image_path']!=''){
									$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X300/' , $timepassSlides['video_image_path']);
									$imageAlt = $timepassSlides['video_image_alt'];
									$imageTitle = $timepassSlides['video_image_title'];
									
								}
								if($timepassSlides['custom_image_path']!=''){
									$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X300/' , $timepassSlides['custom_image_path']);
									$imageAlt = $timepassSlides['custom_image_alt'];
									$imageTitle = $timepassSlides['custom_image_title'];
								}
								$title = ($timepassSlides['CustomTitle']!='') ? $timepassSlides['CustomTitle'] : $timepassSlides['title'];
								$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title);
								$title = (strlen($title) < 50) ? $title : substr($title , 0  ,47).'...';
								if($t==1){
									echo '<div class="row margin-bottom-15">';
								}
								echo '<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">';
								echo '<a href="article?id='.$timepassSlides['content_id'].'&type=video">
										<img src="'.$image.'" alt="'.$imageAlt.'" title="'.$imageTitle.'" class="img-responsive">
										<img src="assets/images/icon.webp" class="icon">
										<p>'.$title.'</p>
										<p>'.strtoupper($timepassSlides['section_name']).'</p>
									</a>';
								echo '</div>';
								if($t==3){
									echo '</div>';
									$t=1;
								}else{
									$t++;
								}
							endwhile;
							if($t!=1){
								echo '</div>';
							}
							?>	
							<div class="row margin-bottom-15">
								<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-right">
									<a href="section?section=timepass" class="read-more" style="cursor:pointer;background: #ff5722;">Watch More >></a>
								</div>
							</div>	
						</div>
						<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
							<div class="upcoming-events timepass-events">
								<div class="event-header">
									<img src="assets/images/timer1.png">
									<span>Next Up</span>
									<span>Catch these sessions live</span>
									<a onclick="nextup(1)"  style="background: #ffebe4;color: #fe5723;cursor:pointer;">See all</a>
								</div>
								<div class="event-body">
									<a>
										<img src="assets/images/radhika.jpg" class="img-responsive">
										<p>Time Pass: Radika Apte,Actor</p>
										<p>June  05, 2020</p>
									</a>
									

									<a>
										<img src="assets/images/time-05-06.jpg" class="img-responsive">
										<p>Time Pass: Shruti Haasan, actor and singer..</p>
										<p>June  05, 2020</p>
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
			<!--timepass container ends-->
			<!--hr starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="hr">
							<hr>
					</section>
				</div>
			</div>
			<!--hr ends-->
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
									echo '<div class="col-md-3">
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
					  slidesToShow: 4,
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
							slidesToShow: 2,
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
			<!--hr starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="hr">
							<hr>
					</section>
				</div>
			</div>
			<!--hr ends-->
			<!--stories container starts-->
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<section class="stories-container">
						<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
							<h3 style="font-weight: 700;color: #fe5723;margin-top:0;" class="text-center r-z">READING ZONE</h3>
							<?php
								$readingZoneArticles = $connection->query("SELECT v.content_id , v.section_id , v.section_name , v.publish_start_date , v.title , v.article_page_image_path , v.article_page_image_alt , v.article_page_image_title , v.summary_html , w.CustomTitle , w.custom_image_path , w.custom_image_title , w.custom_image_alt FROM article as v INNER JOIN widgetinstancecontent_live as w ON v.content_id = w.content_id WHERE v.status='P' AND v.publish_start_date < NOW() AND w.content_type_id=1 AND w.WidgetInstance_id = '18471' AND w.Status=1 LIMIT 5");
								while($readingZone = $readingZoneArticles->fetch_assoc()):
									$image = image_url.'uploads/user/imagelibrary/logo/nie_logo_150X150.jpg';
									$imageAlt = $imageTitle = '';
									if($readingZone['article_page_image_path']!=''){
										$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w150X150/' , $readingZone['article_page_image_path']);
										$imageAlt = $readingZone['article_page_image_alt'];
										$imageTitle = $readingZone['article_page_image_title'];
										
									}
									if($readingZone['custom_image_path']!=''){
										$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w150X150/' , $readingZone['custom_image_path']);
										$imageAlt = $readingZone['custom_image_alt'];
										$imageTitle = $readingZone['custom_image_title'];
									}
									$title = ($readingZone['CustomTitle']!='') ? $readingZone['CustomTitle'] : $readingZone['title'];
									$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title);
									$summary = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$readingZone['summary_html']);
									//$title = (strlen($title) < 63) ? $title : substr($title , 0  ,60).'...';
									echo '<div class="row margin-bottom-15">
											<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
												<a href="article?id='.$readingZone['content_id'].'&type=article">
													<img src="'.$image.'" alt="'.$imageAlt.'" title="'.$imageTitle.'" class="img-responsive">
												</a>
											</div>
											<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
												<a href="article?id='.$readingZone['content_id'].'&type=article">
													<p>'.$title.'</p>
													<div>'.$summary.'</div>
													<span>'.date( 'F d, Y', strtotime($readingZone['publish_start_date'])).'</span>
												</a>
											</div>
											
										</div>';
								endwhile;
								?>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
							<h3 style="font-weight: 700;color: #fe5723;margin-top:0;visibility:hidden;" class="text-center">NEWS FEED</h3>
							<div class="more-stories">
								<?php
								$nf=1;
								$newsFeedTemp = '';
								$newsFeedArticles = $connection->query("SELECT v.content_id , v.section_id , v.section_name , v.publish_start_date , v.title , v.article_page_image_path , v.article_page_image_alt , v.article_page_image_title , v.summary_html , w.CustomTitle , w.custom_image_path , w.custom_image_title , w.custom_image_alt FROM article as v INNER JOIN widgetinstancecontent_live as w ON v.content_id = w.content_id WHERE v.status='P' AND v.publish_start_date < NOW() AND w.content_type_id=1 AND w.WidgetInstance_id = '18474' AND w.Status=1 LIMIT 4");
								while($newsFeed = $newsFeedArticles->fetch_assoc()):
									$image = image_url.'uploads/user/imagelibrary/logo/nie_logo_600X390.jpg';
									$imageAlt = $imageTitle = '';
									if($newsFeed['article_page_image_path']!=''){
										$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X390/' , $newsFeed['article_page_image_path']);
										$imageAlt = $newsFeed['article_page_image_alt'];
										$imageTitle = $newsFeed['article_page_image_title'];
										
									}
									if($newsFeed['custom_image_path']!=''){
										$image  = image_url.'uploads/user/imagelibrary/'.str_replace('original/' , 'w600X390/' , $newsFeed['custom_image_path']);
										$imageAlt = $newsFeed['custom_image_alt'];
										$imageTitle = $newsFeed['custom_image_title'];
									}
									$title = ($newsFeed['CustomTitle']!='') ? $newsFeed['CustomTitle'] : $newsFeed['title'];
									$title = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$title);
									$summary = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$newsFeed['summary_html']);
									$title = (strlen($title) < 63) ? $title : substr($title , 0  ,60).'...';
									if($nf==1){
										echo '<div class="more-stories-header">
												<img src="'.$image.'" alt="'.$imageAlt.'" tittle="'.$imageTitle.'" class="img-responsive">
												<span></span>
											</div>';
									}
									$newsFeedTemp .= '<div class="row margin-bottom-15">
														<div class="col-md-1 col-lg-1 col-sm-1 col-xs-1">
																<img src="assets/images/play_button.png">
														</div>
														<div class="col-md-11 col-lg-11 col-sm-11 col-xs-11">
															<a href="article?id='.$newsFeed['content_id'].'&type=article">
																<p>'.$title.'</p>
																<div>'.$summary.'</div>
																<span>'.date( 'F d, Y', strtotime($newsFeed['publish_start_date'])).'</span>
															</a>
														</div>
													</div>';
									$nf++;
								endwhile;
								?>
								
								<div class="more-stories-body">
								<?php echo $newsFeedTemp; ?>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
			<!--stories container ends-->
			
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