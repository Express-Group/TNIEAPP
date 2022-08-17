<!DOCTYPE html>
<html lan="en">
	<head>
		<meta charset="UTF-8">
		<title>Leadcontent - Newindianexpress</title>
		<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
		<style>
			 @font-face {font-family: Droid-serif;src: url(<?php echo image_url ?>css/FrontEnd/fonts/DroidSerifFonts/droid-serif.regular.ttf);}
			 body{background:#eee;}
			.nax{width: 100%;float: left;background:#fff;}
			.nax-i{width: 100%;float: left;flex: 0 0 auto;box-shadow: 1px 1px 1px #00000045;position: relative;}
			.nax-img{width:30%;float:left;}
			.nax-img img{padding:7px;display: block;height: auto;max-width: 100%;width: 100%;}
			.nax-data{float: left;width: 66%;padding-left: 10px;padding-top: 2%;position: absolute;right: 0;bottom: 0;}
			.nax-data h5 {margin: 10px 0 5px;font-size: 15px;font-family: Droid-serif;}
			.nax-data p:first-of-type{margin-bottom: 4px;font-size: 16px;font-family: Droid-serif;margin-top: 10px;}
			.nax-data p:last-child{font-family: 'Oswald', sans-serif;font-weight: bold;color: green;margin-bottom: 3px;font-size: 16px;margin-top: 6px;}
			.nax-i-50{width: 48.9%;margin-bottom: 20px;margin-right: 2%;background: #fff;}
			.nax-1{background: #eee;height: 500px;overflow-y: scroll;}
			.right-hide{margin-right: 0;}
			@media only screen and (max-width: 500px) {
				.nax-i-50{width:100%;margin-right:0;}
			}
		</style>
		
	</head>
	<body>
		<?php if($single){ ?>
		<div class="nax">
			<div class="nax-i">
				<div class="nax-img">
					<img src="<?php echo image_url.'images/leadcontent/'.$data[0]->imagepath ?>" class="img-responsive"> 
				</div>
				<div class="nax-data">
					<h5><?php echo $data[0]->title; ?></h5>
					<p><?php echo $data[0]->description; ?></p>
					<p style="color:<?php echo $data[0]->color ?>;"><?php echo $data[0]->result; ?></p>
				</div>
			</div>
		</div>
		<?php }else{
		echo '<div class="nax nax-1">';
		$i=1;
		foreach($data as $result){?>
			<div class="nax-i nax-i-50 <?php if($i==2){ echo 'right-hide';}?>">
				<div class="nax-img">
					<img src="<?php echo image_url.'images/leadcontent/'.$result->imagepath ?>" class="img-responsive"> 
				</div>
				<div class="nax-data">
					<h5><?php echo $result->title; ?></h5>
					<p><?php echo $result->description; ?></p>
					<p style="color:<?php echo $result->color ?>;"><?php echo $result->result; ?></p>
				</div>
			</div>
		<?php
		if($i==2){ $i=1;}else{ $i++;}
		}
		echo '</div>';
		} ?>
	</body>
</html> 