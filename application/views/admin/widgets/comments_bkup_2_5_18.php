<?php
$content_id      = $content['content_id'];
$content_from    = $content['content_from'];
$content_type_id = $content['content_type'];
$view_mode       = $content['mode'];

if($content_id!=''){
if($content_from=="live" || $content_from=="archive"){
$content_det        = $content['detail_content'][0];
$allow_comments     = $content_det['allow_comments'];
$section_tag		=	$content_det['tags'];
}else{
$content_det     = $content['detail_content'][0];
$allow_comments = $content_det['Allowcomments'];
$article_tags     = count($content_det['Tags'])? $content_det['Tags'] : '';
$get_tags         = array(); $tags = '';
if(isset($article_tags) && trim($article_tags) != '') 
$get_tags	      = $this->widget_model->get_tags_by_id($article_tags);
if(count($get_tags)>0){
foreach($get_tags as $tag){
$arry_tags[]      = trim($tag->tag_name);
}
$tags             = implode(',', $arry_tags); 
}
$section_tag		=	$tags;
}

$article_id			=	$content_id;
$article_title		=	strip_tags($content_det['title']);

if($allow_comments == 1) { ?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ArticleDetail">
    <div class="ArticleComments">
      <?php /*?><?php 	
		$article_comments = $this->comment_model->get_comments_by_article_id($content_id); 
		$comments_count = ($article_comments['count']>0)? '('.$article_comments['count'].')': '' ;
		?><?php */?>
      <!--<h4 class="ArticleHead comment_head">Comments<span id="comments_count">--><?php /*?><?php echo $comments_count;?><?php */?></span></h4>
    <div id='vuukle-emote'></div>
                  <div id='vuukle-comments'></div>
				  <div class='vuukle-powerbar'></div> 
                  <script type=text/javascript>

var VUUKLE_CONFIG = {
                        apiKey: "6f27340a-c671-45a9-ae0c-13b8d5595b42",
                        articleId: "<?php echo $article_id; ?>",
                        tags: "<?php echo $section_tag;?>"
                    };
                        (function () {
                            var d = document,
                                    s = d.createElement('script');
                            s.src = 'https://cdn.vuukle.com/platform.js';
                            (d.head || d.body).appendChild(s);
                        })();

                  </script>
    </div>
  </div>
</div>
<?php } 
}
?>



