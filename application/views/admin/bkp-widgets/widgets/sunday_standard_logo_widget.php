<div class="row">
<div class=" col-lg-3 col-md-3 col-sm-3 col-xs-12 SundayMenu">
<?php
$widget_instance_id =  $content['widget_values']['data-widgetinstanceid'];
$is_home = $content['is_home_page'];
$current_url=$_SERVER['PHP_SELF'];
$view_mode              = $content['mode'];
$header_details = $this->widget_model->select_setting($view_mode); 
?>
<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <div class="sunday_small_logo">
			
			<?php if($is_home != "y") 
			{
			echo '<a href="'.base_url().'">
			
			<img src="'.base_url().'images/FrontEnd/images/sunday_std_nie.jpg"></a>';
			}
			else
			{
				echo '<img src="'.base_url().'images/FrontEnd/images/sunday_std_nie.jpg">';
			} ?>

                
              </div>
          </div>
          </div>
          </div>
        
   

<div class=" col-lg-5 col-md-5 col-sm-5 col-xs-7 ">
<div class="main_logo SundayLogo">

<?php 
	echo '<img src="'.base_url().'images/FrontEnd/images/sunday_std_logo.jpg">';

?>
</div>
</div>


<div class=" col-lg-4 col-md-4 col-sm-4 col-xs-5  ">
<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <ul class="MobileNav SundayMobile">
                   <?php if($content['page_param']!="home") { ?>
                   <li>
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button></li><?php } ?>
                   <li class="MobileSearch"><a href="<?php echo base_url(); ?>topic"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                   <li class="MobileShare dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span><i class="fa fa-share-alt" aria-hidden="true"></i><i class="fa fa-caret-down" aria-hidden="true"></i></span></a><ul class="dropdown-menu">
          <li><a href="<?php echo $header_details['facebook_url'];?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
          <li><a href="<?php echo $header_details['google_plus_url'];?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
          <li><a href="<?php echo $header_details['twitter_url'];?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
          <li><a href="http://www.pinterest.com/newindianexpres" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
          <li><a href="https://instagram.com/newindianexpress/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>  
          <li><a href="<?php echo $header_details['rss_url'];?>" target="_blank"><i class="fa fa-rss"></i></i></a></li>
          
        </ul></li>
                  </ul>
       <div class="large-screen-search">
        <div class="search1">
          <form class="navbar-form formb" action="<?php echo base_url(); ?>topic"  name="SimpleSearchForm" id="SimpleSearchForm" method="get" role="form">
            <div class="input-group">
              <input type="text" class="form-control tbox" placeholder="Search" name="search_term" id="srch-term" value="<?php echo @$_GET['search_term'];?>">
              <div class="input-group-btn">
                <input type="hidden" class="form-control tbox"  name="home_search" value="H" id="home_search">
                <button class="btn btn-default btn-bac" id="search-submit" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </form>
          <label id="error_throw"></label>
        </div>
        <div class="social_icons SocialCenter"><span> <a class="android" href="https://play.google.com/store/apps/details?id=com.newindianexpress.news" target="_blank"><i class="fa fa-android" aria-hidden="true"></i></a> <a class="apple" href="https://itunes.apple.com/in/app/new-indian-express-official/id968640811?mt=8" target="_blank" ><i class="fa fa-apple" aria-hidden="true"></i></a></span> <a class="fb" href="<?php echo $header_details['facebook_url'];?>" target="_blank"><i class="fa fa-facebook"></i></a> <a class="google" href="<?php echo $header_details['google_plus_url'];?>" target="_blank"><i class="fa fa-google-plus"></i></a> <a class="twit" href="<?php echo $header_details['twitter_url'];?>" target="_blank"><i class="fa fa-twitter"></i></a><a class="pinterest" href="http://www.pinterest.com/newindianexpres" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
          <a class="instagram" href="https://instagram.com/newindianexpress/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a> <a class="rss" href="<?php echo $header_details['rss_url'];?>" target="_blank"><i class="fa fa-rss"></i></a> </div>
        </div>
              </div>
              </div>
              </div>
			  <div class="SundayHeader">
      </div></div>