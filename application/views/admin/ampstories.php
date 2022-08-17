<?php
$css = [];
$fonts = [];
$scripts = [];
$template = '';
$j = 1;
foreach($list as $slide){
	$imagePath = image_url.'images/webstories/default/';
	$cssList = json_decode($slide->css , true);
	$fontList = json_decode($slide->fonts , true);
	$scriptList = json_decode($slide->scripts , true);
	$fields = json_decode($slide->fields , true);
	$fields = $fields['fields'];
	$content = str_replace('%page' , $j , $slide->content);
	for($i=0;$i<count($cssList['css']);$i++){
		array_push($css , $cssList['css'][$i]);
	}
	for($i=0;$i<count($fontList['fonts']);$i++){
		array_push($fonts , $fontList['fonts'][$i]);
	}
	for($i=0;$i<count($scriptList['scripts']);$i++){
		array_push($scripts , $scriptList['scripts'][$i]);
	}
	for($i=0;$i<count($fields);$i++){
		if($fields[$i]['type']=='image' || $fields[$i]['type']=='video'){
			if(isset($fields[$i]['imageType']) && $fields[$i]['imageType']=='files'){
				$imagePath = image_url.'images/webstories/files/';
			}
			$content = str_replace($fields[$i]['element'] , $imagePath.$fields[$i]['value'] , $content);
		}else{
			$styles = "";
			if(isset($fields[$i]['color']) && $fields[$i]['color']!=''){
				$styles .="color:".$fields[$i]['color'].";";
			}
			if(isset($fields[$i]['fontSize']) && $fields[$i]['fontSize']!=''){
				$styles .="font-size:".$fields[$i]['fontSize']."px;";
			}
			$textContent = ($styles!='') ? '<span style="'.$styles.'">'.$fields[$i]['value'].'</span>' : $fields[$i]['value'];
			$content = str_replace($fields[$i]['element'] , $textContent , $content);
		}
	}
	$template .=$content;
	$j++;
}
$css = array_unique($css);
$fonts = array_unique($fonts);
$scripts = array_unique($scripts);
?>
<!DOCTYPE html>
<html amp lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,minimum-scale=1" />
		<link rel="canonical" href="<?php echo BASEURL.$story['url']; ?>">
		<link rel="modulepreload" href="https://cdn.ampproject.org/v0.mjs" as="script" crossorigin="anonymous" />
		<link rel="preconnect" href="https://cdn.ampproject.org" />
		<link rel="preload" as="script" href="https://cdn.ampproject.org/v0/amp-story-1.0.js" />
		<link rel="shortcut icon" href="<?php echo image_url; ?>images/FrontEnd/images/favicon.ico" type="image/x-icon" />
		<meta name="title" content="<?php echo $story['meta_title'];?>" />
		<meta name="description" content="<?php echo $story['meta_description'];?>" />
		<meta name="keywords" content="<?php echo $story['tags'];?>" />
		<meta name="news_keywords" content="<?php echo $story['tags'];?>" />
		<meta property="og:title" content="<?php echo $story['meta_title'];?>" />
        <meta property="og:description" content="<?php echo $story['meta_description'];?>" />
		<meta property="twitter:image:width" content="640" />
        <meta property="twitter:image:height" content="853" />
		<meta property="twitter:site" content="@newindianexpress" />
        <meta property="twitter:creator" content="@newindianexpress" />
        <meta property="twitter:title" content="<?php echo $story['meta_title'];?>" />
        <meta property="twitter:description" content="<?php echo $story['meta_description'];?>" />
		<title><?php echo $story['title'];?> | The New Indian Express</title>
		<script async src="https://cdn.ampproject.org/v0.js"></script>
		<script async custom-element="amp-story" src="https://cdn.ampproject.org/v0/amp-story-1.0.js"></script>
		<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
		<?php echo (count($scripts) > 0) ? implode('' , $scripts) : '';?>
		<?php echo (count($fonts) > 0) ? implode('' , $fonts) : '';?>
		<style amp-boilerplate>
		body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
		</style>
		<noscript>
		<style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style>
		</noscript>
		<?php echo (count($css) > 0) ? '<style amp-custom>'.implode('' , $css).'</style>' : '';?>
		<script type="application/ld+json">
            {
                "headline": "<?php echo $story['title'];?>",
                "publisher": { 
					"logo": { 
						"@type": "ImageObject", 
						"url": "<?php echo image_url;?>images/FrontEnd/images/NIE-logo21.jpg", 
						"width": "625", 
						"height": "142" 
					} 
				}
            }
        </script>
	</head>
	<body>
		<amp-story standalone title="<?php echo $story['title']; ?>" publisher="The New Indian Express" publisher-logo-src="<?php echo image_url;?>images/webstories/TNIE_logo.jpg" poster-portrait-src="<?php echo image_url;?>images/webstories/poster_image/<?php echo $story['poster_image']; ?>">
			<?php echo $template; ?>
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
			<amp-story-social-share layout="nodisplay">
                <script type="application/json">
                    { "shareProviders": [{ "provider": "twitter" }, { "provider": "facebook" }, { "provider": "email" }, { "provider": "system" }] }
                </script>
            </amp-story-social-share>
		</amp-story>
	</body>
</html>