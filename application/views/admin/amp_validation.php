<!doctype html>
<html amp>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui">
		<title><?php print strip_tags($content['meta_Title']); ?> - The New Indian Express</title>
		<script async src="https://cdn.ampproject.org/v0.js"></script>
		<script async custom-element="amp-image-lightbox" src="https://cdn.ampproject.org/v0/amp-image-lightbox-0.1.js"></script>
		<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
		<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
		<script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>
		<script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>
		<link rel="canonical" href="<?php print base_url($content['url']); ?>">
		<link rel="shortcut icon" href="<?php print image_url; ?>images/FrontEnd/images/favicon.ico" type="image/x-icon" />
		<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
		<style amp-custom>
			@font-face {font-family: Droid regular; src: url(<?php echo image_url ?>css/FrontEnd/fonts/DroidSerifFonts/droid-serif.regular.ttf);}
			@font-face {font-family: Droid bold; src: url(<?php echo image_url ?>css/FrontEnd/fonts/DroidSerifFonts/DroidSerif-Bold.ttf);}
			 body {font-family: "Droid regular", serif;line-height: 1.5; }
			.header{padding:10px;text-align:center;}
			.article{padding:10px;background: #f9f9f9;}
			.articleImageContainer{margin:0;}
			amp-image-lightbox.ampimagecontainer{background:white;}
			figcaption{font-size:11px;padding: 5px;background: rgba(158, 158, 158, 0.31);}
			.article_heading{margin-top:5px;margin-bottom: 8px; color: #000;font-size: 23px;font-weight: normal; font-family: Droid bold;line-height: 1.3;}
			.social-icons{margin-bottom:9px;}
			.author-details{margin: 0;font-size: 11px;margin-bottom: 5px;}
			.menu-icon{text-align: left;float: left;margin-top: 5px;margin-left: 7px;}

			#sidebar ul {margin: 0;padding: 0;list-style-type: none;}
			#sidebar ul li{padding: 10px 31px 7px;border-bottom: 1px solid rgba(158, 158, 158, 0.13);}
			#sidebar ul li a,#sidebar ul li a:hover,#sidebar ul li a:active,#sidebar ul li a:focus{color:#000;text-decoration:none;}
			.close-event{float: right; width: 100%;text-align: right;padding: 9px;}
			.tag_element{margin-left:8px;background: #fff;padding: 3px 13px 3px;border-radius: 12px;float:left;margin-bottom:6px;font-size: 13px;}
			.tag_element,.tag_element:active,.tag_element:focus,.tag_element:hover{text-decoration:none;color:#000;}
			.tag_heading,.tags,.more_article{float:left;}
			.tags{padding:10px;background: #f9f9f9;}
			.more_article,.footer{padding:10px;}
			.more_article_row{width:100%;float:left;margin-bottom: 7px;border-bottom: 1px solid #e1e1e1;padding-bottom: 10px;}
			.more_article_row amp-img{float:left;margin-right: 9px;}
			.more_article_row a,.more_article_row a:hover,.more_article_row a:active,.more_article_row a:focus{color:#2828b1;text-decoration:none;font-size: 14px;}
			.socialicons{margin-top: 5px;}
			.footer{background: #505050;color:#55acee;float:left;font-size:13px;}
			.footer_copyright{text-align:center;float:center;width:100%;margin-top:4px;}
			.footer a{text-decoration:none;color:#ccc;}
			.tags{width:95%;}
			.tag_heading{font-size: 15px;}
			.amp-fixed{width: 100%;float: left;position: fixed;bottom: 0;background: #fff;height: 45px;box-shadow: -2px -2px 6px 0 rgba(0,0,0,.3);display:flex; z-index: 9999999999;}
			.amp-fixed amp-social-share{float:left;margin-bottom:0;border-right: 1px solid #fff;flex: 1;}
			#amp-next{width: 24%;float: left;background: #b3afaf;height: 45px;color: #fff;text-align: center;padding-top: 9px;text-decoration: none;}
			.article blockquote{margin:0 auto;}
		</style>
	</head>
	<body>
		<div class="header">
			<a href="<?php print BASEURL; ?>"><amp-img alt="NIE logo"
				src="<?php print image_url; ?>images/FrontEnd/images/new_logo.jpg"
				width="200"
				height="30">
			</amp-img></a>
		</div>
		<article class="article">
			<h2 class="article_heading"><?php print strip_tags($content['title']); ?></h2>
			<?php
				if($content['author_name']!=''){
					print '<span class="author-details">By '.$content['author_name'].'| </span>';
				}
				if($content['agency_name']!=''){
					print '<span class="author-details">'.$content['agency_name'].' |</span>';
				}
				$published_date = date('dS  F Y h:i A' , strtotime($content['publish_start_date']));
				if ($content['article_page_image_path'] != '' && getimagesize(image_url_no . imagelibrary_image_path . $content['article_page_image_path'])){
					$imagedetails = getimagesize(image_url_no . imagelibrary_image_path.$content['article_page_image_path']);
					$imagewidth   = $imagedetails[0];
					$imageheight  = $imagedetails[1];
					if ($imageheight > $imagewidth){
						$Image 	= $content['article_page_image_path'];
					}else{				
						$Image 	= str_replace("original","w600X390", $content['article_page_image_path']);
					}
					$image_path = '';
					$image_path = image_url. imagelibrary_image_path . $Image;
				}else{
					$image_path	   = image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
					$imagewidth   = 600;
					$imageheight  = 390;
					$image_caption = '';	
				}
				$article= preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $content['article_page_content_html']);
				$article=str_replace(['<img','</img>'],['<amp-img width="320" height="200" layout="responsive"','</amp-img'],$article);
				$article = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $article);
				$article = preg_replace('/style=\\"[^\\"]*\\"/', '', $article);
				$article = preg_replace('/data-src=\\"[^\\"]*\\"/', '', $article);
				$article = preg_replace('/(<[^>]+) onclick=".*?"/i', '$1', $article);
				$article = preg_replace('/<g[^>]*>/i', '', $article);
				$article = str_replace(['<pm.n>','<itc.ns>','</pm.n>','</itc.ns>'],'',$article);
				$article = str_replace(['<p sourcefrom="ptitool">' , '<p sourcefrom=ptitool>'],'<p>',$article); 
				$article = str_replace('<p><iframe frameborder="0" height="500" scrolling="no" src="http://www.newindianexpress.com/embed/leadcontent/" style="width:100%;" width="630"></iframe></p>' ,'',$article); 
				$article = str_replace(['<iframe allowtransparency="true"','</iframe>'] ,['<amp-iframe layout="responsive" sandbox="allow-scripts allow-same-origin allow-popups"','</amp-iframe>'],$article);
				$article = str_replace('<iframe' ,'<amp-iframe layout="responsive" sandbox="allow-scripts allow-same-origin allow-popups"',$article);
				$article = str_replace('width="100%"' , 'width="320px"' ,$article);
				$article = str_replace(['<script async="" src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>' ,'<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>','<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>' , '<script async="" src="//platform.instagram.com/en_US/embeds.js"></script>' ,'<script async src="//www.instagram.com/embed.js">'] ,['','','','',''],$article);
				$article = str_replace('<script src="https://public.flourish.studio/resources/embed.js"></script>' ,'',$article);
				$article = str_replace('<p><amp-iframe layout="responsive" sandbox="allow-scripts allow-same-origin allow-popups" frameborder="0" height="500" scrolling="no" src="http://www.newindianexpress.com/embed/leadcontent/" width="630"></amp-iframe></p>' ,'',$article); 
				$article = str_replace(['http://images.newindianexpress.com' , 'http://www.newindianexpress.com'],['https://images.newindianexpress.com' , 'https://www.newindianexpress.com'] ,$article);
				
				$html = new domDocument;
				$html->loadHTML($article);
				$html->preserveWhiteSpace = false; 
				$twitter = $html->getElementsByTagName('blockquote');
				foreach ($twitter as $twitterTweet){
					$className = $twitterTweet->getAttribute('class');
					if($className=='twitter-tweet'){
						$aTag = $twitterTweet->getElementsByTagName('a');
						foreach($aTag as $TagId){
							$tweetId = $TagId->getAttribute('href');
							if($tweetId!=''){
								$ID = explode('?',substr($tweetId , strripos($tweetId ,'/') + 1 , strlen($tweetId)));
								$ID = $ID[0];
								if(is_numeric($ID)){
									$elementhtml = $html->saveHTML($twitterTweet);
									$titleNode = $html->createElement("amp-twitter");
									$titleNode->setAttribute('width','356');
									$titleNode->setAttribute('height','415');
									$titleNode->setAttribute('data-tweetid',$ID);
									$twitterTweet->nodeValue = '';
									$twitterTweet->appendChild($titleNode);
								}
								
							}
							
						}
					}else if($className=='instagram-media'){
						$instaId = explode('/' , str_replace('https://www.instagram.com/p/','',$twitterTweet->getAttribute('data-instgrm-permalink')));
						$instaId = $instaId[0];
						$titleNode = $html->createElement("amp-instagram");
						$titleNode->setAttribute('width','400');
						$titleNode->setAttribute('height','400');
						$titleNode->setAttribute('layout','responsive');
						$titleNode->setAttribute('data-shortcode',$instaId);
						$twitterTweet->nodeValue = '';
						$twitterTweet->appendChild($titleNode);
					}
				}
				$flourish = $html->getElementsByTagName('div');
				foreach ($flourish as $flourishElement){
					$className = $flourishElement->getAttribute('class');
					if($className=='flourish-embed flourish-chart' ||$className =='flourish-embed'){
						$flourishElement->setAttribute('class','none');
						$flourishElement->nodeValue = '';
					}
				} 
				$flourish = $html->getElementsByTagName('p');
				foreach ($flourish as $flourishElement){
					$className = $flourishElement->getAttribute('class');
					if($className=='flourish-embed flourish-chart'){
						$flourishElement->setAttribute('class','none');
						$flourishElement->nodeValue = '';
					}
				}
				$article = $html->saveHTML();
				$article = str_replace(['<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">' ,'<html><body>' , '</body></html>'] ,['','',''] , $article);
			?>
			<span class="author-details">Published: <?php print $published_date; ?></span>
			<div class="socialicons">
				<amp-social-share type="email" width="38" height="33" class="social-icons"></amp-social-share>
				<amp-social-share type="facebook" data-param-app_id="1001847326609171" width="38" height="33" class="social-icons"></amp-social-share>
				<amp-social-share type="gplus" width="38" height="33" class="social-icons"></amp-social-share>
				<amp-social-share type="twitter" width="38" height="33" class="social-icons"></amp-social-share>
			</div>
			<figure class="articleImageContainer">
				<amp-img on="tap:artilceImage" role="button" tabindex="0" src="<?php print $image_path; ?>" width=320 height=200 layout="responsive"></amp-img>
				<figcaption><?php print $content['article_page_image_title']; ?></figcaption>
			</figure>			
			<amp-image-lightbox class="ampimagecontainer" id="artilceImage" layout="nodisplay"></amp-image-lightbox>
			<?php echo $article; ?>
		</article>
		<div class="footer">
			<div class="footer_copyright">Copyrights New Indian Express.<?php print date('Y'); ?></div>
			<div class="footer_copyright"><a href="https://www.dinamani.com" target="_blank">Dinamani | </a><a href="http://www.kannadaprabha.com" target="_blank">Kannada Prabha | </a><a href="https://www.samakalikamalayalam.com" target="_blank">Samakalika Malayalam | </a><a href="http://www.malayalamvaarika.com" target="_blank">Malayalam Vaarika  | </a><a href="https://www.indulgexpress.com" target="_blank">Indulgexpress  | </a><a href="http://www.edexlive.com" target="_blank">Edex Live  | </a><a href="https://www.cinemaexpress.com" target="_blank">Cinema Express  | </a><a href="http://www.eventxpress.com" target="_blank">Event Xpress </a></div>	
			<div class="footer_copyright"><a href="<?php print BASEURL?>contact-us">Contact Us | </a><a href="<?php print BASEURL?>careers">About Us | </a><a href="<?php print BASEURL?>about-us">Careers |  </a><a href="<?php print BASEURL?>privacy-policy">Privacy Policy | </a><a href="<?php print BASEURL?>topic">Search |  </a><a href="<?php print BASEURL?>terms-of-use">Terms of Use | </a><a href="<?php print BASEURL?>advertise-with-us">Advertise With Us </a></div>
		</div>
	</body>
</html> 