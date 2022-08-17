<?php
$urlparam = strtolower($this->uri->segment(3));
$formurl = ($urlparam=='add') ? base_url(ADMINFOLDER.'section/add') : base_url(ADMINFOLDER.'section/edit/'.$this->uri->segment(4));
?>
<!-- Content -->
<div class="content">
	<div class="page-header d-md-flex justify-content-between">
		<div>
            <h3><?php echo ($urlparam=='add') ? 'Add' : 'Edit'; ?> Section</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'home'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(ADMINFOLDER.'section'); ?>">Section</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo ($urlparam=='add') ? 'Add' : 'Edit'; ?></li>
                </ol>
            </nav>
        </div>
	</div>
	<div class="row">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-6">
                    <div class="pricing-table card">
                        <div class="card-body">
							<form method="post" action="<?php echo base_url(ADMINFOLDER.'section/add') ?>" enctype="multipart/form-data">
							<div class="form-group">
								<label for="section-name">Section Name<sup>*</sup></label>
								<input type="text" value="<?php echo set_value('section_name'); ?>" class="form-control" name="section_name">
								<?php echo form_error('section_name' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="section-url">Section Url <sup>*</sup></label>
								<input type="text" value="<?php echo set_value('section_url'); ?>" class="form-control" name="section_url">
								<?php echo form_error('section_url' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="parent-section">Parent Section</label>
								<select class="form-control" name="parent_section">
									<option value="">Please select any one</option>
									<?php echo section_dropdown(buildTree($sections)); ?>
								</select>
								<?php echo form_error('parent_section' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="section-type">Section Type<sup>*</sup></label>
								<select class="form-control" name="section_type">
									<option value="">Please select any one</option> 
									<option value="1">Article</option>
									<option value="2">Gallery</option>
									<option value="3">Video</option>
								</select>
								<?php echo form_error('section_type' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" id="article_host" name="article_host" checked>
									<label class="custom-control-label" for="article_host">Allow this section to be displayed for content hosting</label>
								</div>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" id="rss" name="rss" checked>
									<label class="custom-control-label" for="rss">Allow this section to be displayed for rss</label>
								</div>
							</div>
							<div class="form-group">
								<label for="section_image">Section Image</label>
								<input type="file" class="form-control" name="section_image" accept="image/*">
								<?php echo form_error('section_image' ,'<p class="error">','</p>'); ?>
							</div>
                            <div class="form-group">
								<label for="status">Status<sup>*</sup></label>
								<select class="form-control" name="status">
									<option value="">Please select any one</option> 
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
								<?php echo form_error('status' ,'<p class="error">','</p>'); ?>
							</div>							
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pricing-table card">
                        <div class="card-body">
							<div class="list-group list-group-flush">
								<a style="color:#fff;font-weight:700;padding:0.20rem .5rem;" class="list-group-item active d-flex justify-content-center">
									SEO TAGS
								</a>              
							</div>
							<div class="form-group">
								<label style="margin-top:2%;" for="meta_title">Meta Title<sup>*</sup></label>
								<input type="text" value="<?php echo set_value('meta_title'); ?>" class="form-control" name="meta_title">
								<?php echo form_error('meta_title' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="meta_description">Meta Description <sup>*</sup></label>
								<textarea class="form-control" name="meta_description"></textarea>
								<?php echo form_error('meta_description' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="meta_keywords">Meta Keywords <sup>*</sup></label>
								<textarea class="form-control" name="meta_keywords"></textarea>
								<?php echo form_error('meta_keywords' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<label for="canonical_url">Canonical Url</label>
								<input type="text" value="<?php echo set_value('canonical_url'); ?>" class="form-control" name="canonical_url">
								<?php echo form_error('canonical_url' ,'<p class="error">','</p>'); ?>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch" style="float: left;   margin-right: 13%;">
									<input type="checkbox" class="custom-control-input" id="no_index" name="no_index">
									<label class="custom-control-label" for="no_index">No Index</label>
								</div>
								<div class="custom-control custom-switch" style="float: left;">
									<input type="checkbox" class="custom-control-input" id="no_follow" name="no_follow">
									<label class="custom-control-label" for="no_follow">No Follow</label>
								</div>
							</div>
							<div class="form-group" style="float: left;width: 100%;    margin: 9px 0 0;">
								<button type="submit" class="btn btn-primary">submit</button>
								<button type="reset" class="btn btn-primary">reset</button>
							</div>
							</form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ./ Content -->   