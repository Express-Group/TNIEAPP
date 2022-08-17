<style>
.search-box{float: right;width: 34%;display:none;margin: 1% 5% 0 0;}
.search-box input{border-top-left-radius: 35px;border-bottom-left-radius: 35px;border: 1px solid #eee;}
.search-box button{background: #eee;color: #9e9797;border-top-right-radius: 35px;border-bottom-right-radius: 35px;border: 1px solid #eee;}
</style>
<div class="row blocks">
	<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 col-12">
		<header>
			<a href="<?php echo base_url(); ?>"><img class="logo img-fluid" src="<?php echo MAINASSETURL;?>/images/logo/logo.png"></a>
			<span class="search"><i class="fa fa-search" aria-hidden="true"></i></span>
			<span class="mobile-menus"><i class="fa fa-bars"></i></span>
			<div class="input-group search-box">
				<input value="<?php echo trim($this->input->get('q')); ?>" id="search_term" type="text" class="form-control" placeholder="Search">
				<div class="input-group-append">
					<button id="searchbtn" class="btn" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>
		</header>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(e){
	$('.search').on('click' , function(e){
		$(this).hide();
		$('.search-box').css('display','-webkit-box');
	});
	$('#searchbtn').on('click' , function(e){
		var term = $('#search_term').val().trim();
		if(term!=''){
			window.location.href= "<?php echo base_url('search')?>?q="+term;
		}else{
			alert('Enter valid keywords');
		}
	});
});
</script>