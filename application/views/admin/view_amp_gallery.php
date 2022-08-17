<!doctype html>
<?php
$Details = $article_details[0];
$Url=$this->uri->uri_string();
$CI = &get_instance();
$this->live_db = $CI->load->database('live_db', TRUE);
$Section=$this->live_db->query("SELECT `Section_id`, `MenuVisibility`,`Sectionname`, `SectionnameInHTML`, `DisplayOrder`,`Section_landing`, `IsSeperateWebsite`, `URLSectionStructure` FROM `sectionmaster` WHERE `Status` =  1 and `MenuVisibility`=1 AND `ParentSectionID` is NULL ORDER BY `DisplayOrder` ASC;")->result();
$SectionID = @$Details['section_id'];
if($content_from=="live"){
	$content_details = $this->widget_model->widget_article_content_by_id($content_id, $content_type, "");
		$MoreArticle=$this->live_db->query("SELECT title,url,first_image_path FROM gallery WHERE Section_id='".$SectionID."' AND content_id!='".$content_id."' AND publish_start_date <=NOW() AND status='P' ORDER BY  last_updated_on DESC LIMIT 5")->result();
		$prev_id =$this->live_db->query("CALL select_section_previous_article('".$content_id."','".$SectionID."', '".$content_type."', 'ORDER BY content_id DESC LIMIT 1')")->row_array();
}
if($content_from=="archive"){
	$table = "gallery_".$year.","."gallery_related_images_".$year;
	$content_details = $this->widget_model->widget_archive_article_content_by_id($content_id, $content_type, $Details['url'], $table, "");
	$archive_db = $this->load->database('archive_db', TRUE);
	$TableName='gallery_'.$year;
	$MoreArticle=$archive_db->query("SELECT title,url,first_image_path FROM ".$TableName." WHERE Section_id='".$SectionID."' AND content_id!='".$content_id."' AND publish_start_date <=NOW() AND status='P' ORDER BY  last_updated_on DESC LIMIT 5")->result();
	$prev_id=array();
		
}
if(count($Details) > 0):
		$published_date = date('dS  F Y h:i A' , strtotime($Details['publish_start_date']));
		$pubDate = date('Y-m-d\TH:i:s\+05:30' , strtotime($Details['publish_start_date']));
		$UpDate = date('Y-m-d\TH:i:s\+05:30' , strtotime($Details['last_updated_on']));
		if ($Details['first_image_path'] != '' && getimagesize(image_url_no . imagelibrary_image_path . $Details['first_image_path'])){
			$imagedetails = getimagesize(image_url_no . imagelibrary_image_path.$Details['first_image_path']);
			$imagewidth   = $imagedetails[0];
			$imageheight  = $imagedetails[1];
			if ($imageheight > $imagewidth){
				$Image 	= $Details['first_image_path'];
			}else{				
				$Image 	= str_replace("original","w600X390", $Details['first_image_path']);
			}
		$image_path = '';
		$image_path = image_url. imagelibrary_image_path . $Image;
		}else{
			$image_path	   = image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
			$imagewidth   = 600;
			$imageheight  = 390;
			$image_caption = '';	
		}
		$OriginalUrl    = base_url().$Details['url'];
		$schemaDescription = stripcslashes(strip_tags($Details['summary_html']));
		$schemaDescription = str_replace(['"' , "'"] ,['\u0022' ,'\u0027'],$schemaDescription);
?>
<html amp>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,minimal-ui">
		<meta name="amp-consent-blocking" content="amp-ad">
		<title><?php print strip_tags($Details['meta_Title']); ?> - The New Indian Express</title>
		<script async src="https://cdn.ampproject.org/v0.js"></script>
		<script async custom-element="amp-image-lightbox" src="https://cdn.ampproject.org/v0/amp-image-lightbox-0.1.js"></script>
		<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
		<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
		<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
		<script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>	
		<script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>
		<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script> 
		<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
		<script async custom-element="amp-consent" src="https://cdn.ampproject.org/v0/amp-consent-0.1.js"></script>
		<link rel="canonical" href="<?php print $OriginalUrl; ?>">
		<link rel="shortcut icon" href="<?php print image_url; ?>images/FrontEnd/images/favicon.ico" type="image/x-icon" />
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:700" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
		<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
		

			<script type="application/ld+json">
			{
				"@context": "http:\/\/schema.org",
				"@type": "NewsArticle",
				"mainEntityOfPage": {
					"@type": "WebPage",
						"@id": "<?php echo $OriginalUrl; ?>"
				},
				"headline": "<?php echo strip_tags($Details['title']); ?>",
				"description": "<?php echo $schemaDescription; ?>",
				"datePublished": "<?php echo $pubDate; ?>",
				"dateModified": "<?php  echo $UpDate; ?>",
				"publisher": {
					"@type": "Organization",
					"name": "New Indian Express",
					"logo": {
						"@type": "ImageObject",
						"url": "<?php echo image_url; ?>images/FrontEnd/images/new_logo.jpg",
						"width": "616",
						"height": "81"
					}
				},
				"inLanguage": "en",
				"keywords": "<?php echo strip_tags($Details['tags']) ?>",
				"author": {
					"@type": "Person",
					"name": "<?php echo (isset($Details['author_name']) && $Details['author_name']!='') ? $Details['author_name'] : $Details['agency_name']; ?>"
				},
				"image": {
					"@type": "ImageObject",
					"url": "<?php echo $image_path ?>",
					"width": "<?php echo @$imagewidth ?>",
					"height": "<?php echo @$imageheight ?>"
				}	
			}		
			</script>
		<style amp-custom>
			@font-face {font-family: Droid regular; src: url(<?php echo image_url ?>css/FrontEnd/fonts/DroidSerifFonts/droid-serif.regular.ttf);}
			@font-face {font-family: Droid bold; src: url(<?php echo image_url ?>css/FrontEnd/fonts/DroidSerifFonts/DroidSerif-Bold.ttf);}
			 body {font-family: "Droid regular", serif;line-height: 1.5;position:relative; }
			.header{padding:6px 10px 3px;text-align:center;}
			.article{padding:10px;/* background: #f9f9f9; */float:left; width: calc(100% - 20px);}
			.articleImageContainer{margin:0 0 25px;position:relative;}
			amp-image-lightbox.ampimagecontainer{background:white;}
			figcaption{font-size:12px;padding: 5px;background: #000;color:#fff;}
			.article_heading{margin-top:5px;margin-bottom: 8px; color: #000;font-size: 23px;font-weight: normal; font-family: Droid bold;line-height: 1.3;}
			.social-icons{margin-bottom:9px;}
			.author-details{margin: 0;font-size: 11px;margin-bottom: 5px;}
			.menu-icon{text-align: left;float: left;margin-top: 5px;margin-left: 7px;}

			#sidebar ul {margin: 0;padding: 0;list-style-type: none;}
			#sidebar ul li{padding: 10px 31px 7px;border-bottom: 1px solid rgba(158, 158, 158, 0.13);}
			#sidebar ul li a,#sidebar ul li a:hover,#sidebar ul li a:active,#sidebar ul li a:focus{color: #09155E;text-decoration: none;   font-family: 'Oswald', sans-serif;font-weight: bold;}
			.close-event{float: right; width: 100%;text-align: right;padding: 9px;}
			.tag_element{margin-left:8px;background: #fff;padding: 5px 13px 5px;border-radius: 12px;float:left;margin-bottom:6px;font-size: 13px;    border: 1px solid #ddd;}
			.tag_element,.tag_element:active,.tag_element:focus,.tag_element:hover{text-decoration:none;color: #680101;font-weight: bold;}
			.tag_heading,.tags,.more_article{float:left;}
			.tags{padding:10px;/* background: #f9f9f9; */width:95%;}
			.more_article,.footer{padding:10px;}
			.more_article_row{width:100%;float:left;margin-bottom: 7px;border-bottom: 1px solid #e1e1e1;padding-bottom: 10px;}
			.more_article_row amp-img{float:left;margin-right: 9px;}
			.more_article_row a,.more_article_row a:hover,.more_article_row a:active,.more_article_row a:focus{color: #000;text-decoration: none;    font-size: 14px;line-height: 1.5;display: flex;}
			.socialicons{margin-top: 5px;}
			.footer{background: #505050;color:#55acee;float:left;font-size:13px;}
			.footer_copyright{text-align:center;float:center;width:100%;margin-top:4px;}
			.footer a{text-decoration:none;color:#ccc;}
			.tag_heading{font-size: 15px;text-transform: uppercase;color: #09155E;margin-top: 5px;}
			.amp-fixed{width: 100%;float: left;position: fixed;bottom: 0;background: #fff;height: 45px;box-shadow: -2px -2px 6px 0 rgba(0,0,0,.3);display:flex; z-index: 9999999999;}
			.amp-fixed amp-social-share{float:left;margin-bottom:0;border-right: 1px solid #fff;flex: 1;}
			#amp-next{width: 24%;float: left;background: #b3afaf;height: 45px;color: #fff;text-align: center;padding-top: 9px;text-decoration: none;}
			.article blockquote{margin:0 auto;}
			.articleImageContainer amp-img{border-top-left-radius: 8px;border-top-right-radius: 8px;}
			.articleImageContainer figcaption{border-bottom-left-radius: 8px;border-bottom-right-radius: 8px;}
			.nie-logo{margin-top: 3px;}
			.refresh-list{background: #09155E; border: none;color: #fff;padding: 10px 14px 10px;border-radius: 5px;position:relative;}
			.live-content{float: left;width: 87%;margin: 1%;background: #fff;padding: 5%;border-radius: 8px;border: 1px solid #ddd;margin-bottom: 6%;position:relative;}
			.live-content .time{float: left;width: 100%;margin-bottom: 5px;color: #6b6565;font-size: 13px;}
			.live-content .content_title{float: left;width: 100%;font-family: "Droid bold", serif;margin: 10px 0 10px;font-size: 18px;}
			.live-content .content_description{float: left;width: 100%;font-size: 14px;line-height: 1.6;}
			.live-socialicons{position: absolute;top: 0;right: 0;}
			.live-fb{border-bottom-left-radius: 8px;}
			.live-ti{border-top-right-radius: 8px;}
			.live-update-t{margin: 1%;background: #f00;padding: 2% 5% 1%;color: #fff;text-align: center;text-transform: uppercase;}
			.more_article h3{font-family: 'Roboto Condensed';}
			.more_article h3::before{content: " ";width: 2px;height: 14px;border-left: 22px solid #09155E;display: inline-block;background: #fff;    border-right: 2px solid red;margin-right: 2%;}
			amp-sidebar{background:#fff;}
			.gallery-count{position: absolute;color: #fff;top: 6px;left: 5px;padding: 2px 8px 2px;font-size: 12px;}
			.gallery-count b{font-size: 22px;}
			.no-cap amp-img{border-bottom-left-radius: 8px;border-bottom-right-radius: 8px;}
			.flip-fixed {position: fixed;bottom: -20%;width: 100%;right: -16px;}

			.align-center-button{display:flex;align-items: center;justify-content:center;flex-direction: row;width:100%}amp-web-push-widget .subscribe{display: flex;flex-direction: row;align-items: center;border-radius:2px;border:1px solid #007ae2;margin:0;padding:8px 15px;cursor:pointer;outline:0;font-size:16px;font-weight:400;background:#0e82e5;color:#fff;-webkit-tap-highlight-color:transparent}amp-web-push-widget .unsubscribe{border-radius:2px;border:1px solid #b3b3b3;margin:0;padding:8px 15px;cursor:pointer;outline:0;font-size:15px;font-weight:400;background:#bdbdbd;color:#555;-webkit-tap-highlight-color:transparent}amp-web-push-widget .subscribe .subscribe-icon{margin-right:10px}amp-web-push-widget .subscribe:active{transform:scale(.99)}
		</style>
	  <script async custom-element="amp-web-push" src="https://cdn.ampproject.org/v0/amp-web-push-0.1.js"></script>
	</head>
	<body>
		<amp-analytics type="googleanalytics">
			<script type="application/json">
			{
				"vars": {
				"account": "UA-2311935-30"
				},
				"triggers": {
					"trackPageview": {
						"on": "visible",
						"request": "pageview"
					}
				}
			}
			</script>
		</amp-analytics>

		<amp-analytics type="comscore"> 
		<script type="application/json">
		{
		"vars": {"c2": "16833363"},
		"extraUrlParams": {"comscorekw": "amp"}
		}
		</script>
		</amp-analytics> 
		
		<amp-sidebar id="sidebar" layout="nodisplay"  side="right" >
			<div class="close-event">
			<amp-img class="amp-close-image"
			src="<?php print image_url; ?>images/FrontEnd/images/close_btn.png"
			width="15"
			height="15"
			
			alt="close sidebar"
			on="tap:sidebar.close"
			role="button"
			tabindex="0"></amp-img>
			</div>
			<ul class="">
				<?php
					$m=1;
					print '<li><a href="'.BASEURL.'elections/elections-2019">Election</a></li>';

					foreach($Section as $SectionDetails):
						if(strip_tags($SectionDetails->SectionnameInHTML)=='Education'){
							break;
						}
						if($SectionDetails->URLSectionStructure=="Home"){
							$SectionUrl=BASEURL;
						}else{
							$SectionUrl=BASEURL.$SectionDetails->URLSectionStructure;
						}
						if($m < 13):
							print '<li><a href="'.$SectionUrl.'">'.strip_tags($SectionDetails->SectionnameInHTML).'</a></li>';
						endif;
						$m++;
					endforeach;
				?>
			</ul>
		</amp-sidebar>
		<div class="header">
		<amp-img alt="NIE menu"
			on="tap:sidebar.toggle"
			src="<?php print image_url; ?>images/FrontEnd/images/hamburger_menu.png"
			width="25"
			height="30"
			role="image"
			tabindex="1"
			class="menu-icon">
		</amp-img>
		<a href="<?php print BASEURL; ?>"><amp-img class="nie-logo" alt="NIE logo"
			src="<?php print image_url; ?>images/FrontEnd/images/new_logo.jpg"
			width="210"
			height="27">
		</amp-img></a>
		</div>
		<amp-consent id="googlefc" layout="nodisplay" type="googlefc"><script type="application/json">{"clientConfig":{"publisherIdentifier":"pub-4861350176551585"}}</script></amp-consent>
		<article class="article">
			<h2 class="article_heading"><?php print strip_tags($Details['title']); ?></h2>
			<?php
			if(isset($Details['author_name']) && $Details['author_name']!=''){
				print '<span class="author-details">By '.$Details['author_name'].'| </span>';
			}
			if($Details['agency_name']!=''){
				print '<span class="author-details">'.$Details['agency_name'].' |</span>';
			}
			?>
			<span class="author-details">Published: <?php print $published_date; ?></span>
			<div class="socialicons">
				<amp-social-share type="email" width="38" height="33" class="social-icons"></amp-social-share>
				<amp-social-share type="facebook" data-param-app_id="1001847326609171" width="38" height="33" class="social-icons"></amp-social-share>
				<amp-social-share type="gplus" width="38" height="33" class="social-icons"></amp-social-share>
				<amp-social-share type="twitter" width="38" height="33" class="social-icons"></amp-social-share>
			</div>
			<?php
			$i=1;
			$ads =['<amp-ad width=300 height=250 type="doubleclick" data-slot="/3167926/NIE_AMP_ATF_300x250" data-multi-size-validation="false"></amp-ad>' , '<amp-ad width=300 height=250 type="doubleclick" data-slot="/3167926/NIE_AMP_MID_300x250" data-multi-size-validation="false"></amp-ad>' ,'<amp-ad width=300 height=250 type="doubleclick" data-slot="/3167926/NIE_AMP_BTF_300x250" data-multi-size-validation="false"></amp-ad>' ,'<amp-ad width=320 height=100 type="doubleclick" data-slot="/3167926/NIE_AMP_BTF_320x100" data-multi-size-validation="false"> </amp-ad>'];
			$advcount=0;
			$galleryfullcount = count($content_details);
			foreach($content_details as $gallery_image){
				$gallery_caption = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $gallery_image['gallery_image_title']);
				$gallery_alt =  $gallery_image['gallery_image_alt'];
				$Image600X390= str_replace(' ', "%20",$gallery_image['gallery_image_path']);
				$imagewidth = 600;
				$imageheight = 390;
				 if(getimagesize(image_url_no . imagelibrary_image_path . $Image600X390) && $Image600X390 != ''){
					  $imagedetails = getimagesize(image_url_no . imagelibrary_image_path.$Image600X390);
					  $imagewidth = $imagedetails[0];
                      $imageheight = $imagedetails[1];
					  $show_gallery_image = image_url. imagelibrary_image_path . $Image600X390;
				 }else{
					 $show_gallery_image	= image_url. imagelibrary_image_path.'logo/nie_logo_600X390.jpg';
				 }
				 echo '<figure class="articleImageContainer '.(($gallery_caption=='') ? 'no-cap' : '').'">';
				 echo '<amp-img  tabindex="0" src="'.$show_gallery_image.'" width='.$imagewidth.' height='.$imageheight.' layout="responsive"></amp-img>';
				 if($gallery_caption!=''):
					echo '<figcaption>'.$gallery_caption.'</figcaption>';
				 endif;
				 echo '<span class="gallery-count"><b>'.$i.'</b><span> / '.$galleryfullcount.'</span></span>';
				 echo '</figure>';
				 if($i%2==0){
					 if(isset($ads[$advcount]) && $ads[$advcount]!=''){
						 echo $ads[$advcount];
					 }
					$advcount++;
				 }
				 $i++;
			}
			?>		
			   
			
			

			<!-- <amp-ad width=300 height=250 type="doubleclick" data-slot="/42115163/IP_newindianexpress.com_300x250_BTF1_AMP"></amp-ad> -->
		
		</article>
		<amp-web-push id="amp-web-push" layout="nodisplay" helper-iframe-url="https://www.newindianexpress.com/helper-iframe.html" permission-dialog-url="https://www.newindianexpress.com/permission-dialog.html" service-worker-url="https://www.newindianexpress.com/service-worker.js" > </amp-web-push> <!-- Subscription widget --> <div class="align-center-button"> <amp-web-push-widget visibility="unsubscribed" layout="fixed" width="250" height="45"> <button class="subscribe" on="tap:amp-web-push.subscribe"> <amp-img class="subscribe-icon" width="18" height="18" layout="fixed" src="data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNTYgMjU2Ij48dGl0bGU+UHVzaEFsZXJ0PC90aXRsZT48ZyBpZD0iRm9ybWFfMSIgZGF0YS1uYW1lPSJGb3JtYSAxIj48ZyBpZD0iRm9ybWFfMS0yIiBkYXRhLW5hbWU9IkZvcm1hIDEtMiI+PHBhdGggZD0iTTEzMi4wNywyNTBjMTguNjIsMCwzMy43MS0xMS41MywzMy43MS0yMUg5OC4zNkM5OC4zNiwyMzguNDIsMTEzLjQ2LDI1MCwxMzIuMDcsMjUwWk0yMTksMjAwLjUydjBhNTcuNDIsNTcuNDIsMCwwLDEtMTguNTQtNDIuMzFWMTE0LjcyYTY4LjM2LDY4LjM2LDAsMCwwLTQzLjI0LTYzLjU1VjM1LjlhMjUuMTYsMjUuMTYsMCwxLDAtNTAuMzIsMFY1MS4xN2E2OC4zNiw2OC4zNiwwLDAsMC00My4yMyw2My41NXY0My40NmE1Ny40Miw1Ny40MiwwLDAsMS0xOC41NCw0Mi4zMXYwYTEwLjQ5LDEwLjQ5LDAsMCwwLDYuNTcsMTguNjdIMjEyLjQzQTEwLjQ5LDEwLjQ5LDAsMCwwLDIxOSwyMDAuNTJaTTEzMi4wNyw0NS40MmExMS4zMywxMS4zMywwLDEsMSwxMS4zNi0xMS4zM0ExMS4zMywxMS4zMywwLDAsMSwxMzIuMDcsNDUuNDJabTczLjg3LTE3LjY3LTYuNDUsOS43OGE4My40Niw4My40NiwwLDAsMSwzNi4xNSw1NC43N2wxMS41My0yLjA2YTk1LjIzLDk1LjIzLDAsMCwwLTQxLjIzLTYyLjVoMFpNNjQuNDYsMzcuNTJMNTgsMjcuNzVhOTUuMjMsOTUuMjMsMCwwLDAtNDEuMjMsNjIuNWwxMS41MywyLjA2QTgzLjQ2LDgzLjQ2LDAsMCwxLDY0LjQ1LDM3LjU0aDBaIiBmaWxsPSIjZmZmIi8+PC9nPjwvZz48L3N2Zz4="> </amp-img> Subscribe to Notifications </button> </amp-web-push-widget> </div>
		
		<?php
		if($Details['tags']!=''):
				$Tags=explode(',',$Details['tags']);
				print '<div class="tags">';
					print '<a class="tag_heading"> Tags : </a>';
				for($i=0;$i<count($Tags);$i++):
					if($Tags[$i]!=''):
						$tag_title = join( "_",( explode(" ", trim($Tags[$i]) ) ) );
						$tag_url_title = preg_replace('/[^A-Za-z0-9\_]/', '', $tag_title); 
						$TagUrl=BASEURL.'topic/'.$tag_url_title;
						print '<a class="tag_element" href="'.$TagUrl.'">'.$Tags[$i].'</a>';
					endif;
				endfor;
				print '</div>';
			endif;
			?>
			
			
			<?php
			print '<div class="more_article">';
			if(count($MoreArticle) > 0){
				print '<h3>More from this section</h3>';
				foreach($MoreArticle as $MoreArticleDetails):
					if($MoreArticleDetails->first_image_path==""){
						$Image=image_url. imagelibrary_image_path.'logo/nie_logo_600X300.jpg';
					}else{
						$Image=image_url . imagelibrary_image_path.$MoreArticleDetails->first_image_path;
					}
					?>
						<div class="more_article_row">
						<amp-img  src="<?php print $Image; ?>" width=100 height=67 ></amp-img>
						<span><a href="<?php print BASEURL.str_replace('.html','.amp',$MoreArticleDetails->url); ?>"><?php print strip_tags($MoreArticleDetails->title); ?></a></span>
						</div>
					<?php
				endforeach;
			}
			?>
			
			<?php
			print '</div>';
			?>
			
			<div class="footer">
				<div class="footer_copyright">Copyrights New Indian Express.<?php print date('Y'); ?></div>
				
				<div class="footer_copyright"><a href="https://www.dinamani.com" target="_blank">Dinamani | </a><a href="https://www.kannadaprabha.com" target="_blank">Kannada Prabha | </a><a href="https://www.samakalikamalayalam.com" target="_blank">Samakalika Malayalam | </a><a href="http://www.malayalamvaarika.com" target="_blank">Malayalam Vaarika  | </a><a href="https://www.indulgexpress.com" target="_blank">Indulgexpress  | </a><a href="https://www.edexlive.com" target="_blank">Edex Live  | </a><a href="https://www.cinemaexpress.com" target="_blank">Cinema Express  | </a><a href="http://www.eventxpress.com" target="_blank">Event Xpress </a></div>
				
				<div class="footer_copyright"><a href="<?php print BASEURL?>contact-us">Contact Us | </a><a href="<?php print BASEURL?>careers">About Us | </a><a href="<?php print BASEURL?>about-us">Careers |  </a><a href="<?php print BASEURL?>privacy-policy">Privacy Policy | </a><a href="<?php print BASEURL?>topic">Search |  </a><a href="<?php print BASEURL?>terms-of-use">Terms of Use | </a><a href="<?php print BASEURL?>advertise-with-us">Advertise With Us </a></div>
			</div>
			<div class="amp-fixed">
				<amp-social-share type="facebook" data-param-app_id="254325784911610" width="45" height="45" class="social-icons"></amp-social-share>
				<amp-social-share type="twitter" width="45" height="45" class="social-icons"></amp-social-share>
				<amp-social-share type="whatsapp" width="45" height="45"  data-param-text="CANONICAL_URL"></amp-social-share>
				<?php
					if(count($prev_id) > 0){
						echo '<a href="'.BASEURL.str_replace('.html','.amp',$prev_id['url']).'" id="amp-next">Next >></a>';
					}
				?>
			</div>
	</body>
</html>
<?php endif; ?> 