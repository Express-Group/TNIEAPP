<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="AskPrabhuReply">
			<h2 class="AskPrabhuTitle title">Your Replies</h2>
			<div id="content" ></div>
			<table>
				<?php 
$Order='';
$per_page=10;
if (isset($_GET['pn']))
	$page=$_GET['pn'];
else
	$page=1;
$start = ($page-1)*$per_page;
$get_result = $this->widget_model->display_askprabhu_qnlist($start,$per_page); 
		
		foreach($get_result as $result)
		{
			$questions=$result['Questiontext'];
			$answers=$result['AnswerInHTML'];
			//$answers = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1',$answers); 
			$username=$result['UserName'];
			$place=$result['Place'];
			$date=$result['Modifiedon'];
			$display_date=date("d-m-Y",strtotime($date));
			
?>
				<tr>
					<td class="UserDetail"><p><?php echo $username ?></p>
						<p><?php echo $place ?> <span class="WidthFloat_L"><?php echo $display_date ?></span></p></td>
					<td class="UserQuestion"><p>Q:<?php echo $questions;  ?> </p>
						<div class="down_arrow"> </div></td>
				</tr>
				<tr>
					<td colspan="2" class="PrabhuAnswer"><div>A: <?php echo $answers;  ?></div></td>
				</tr>
				<?php  }?>
			</table>
			<div id="loading" ></div>
			<div class="pagina">
				<?php 



//getting number of rows and calculating no of pages
$this->db->reconnect();
$total_rows=$this->db->query('CALL display_askprabhu_qnlist("'.$Order.'")');
$count=trim($total_rows->num_rows());
//$count='7';

$pages = ceil($count/$per_page); ?>
				<div id="content" ></div>
				<?php

$url= $_SERVER['PHP_SELF'];
				//Show page links
				if($count > 10)
				{
				for($i=1; $i<=$pages; $i++)
				{
					//if($count <= 50)
					if ($i == 6) break;
					{
					?>
				<a href="<?php echo $url .'?pn=' .$i; ?>" <?php if($i==$page){  ?> class="active" <?php }?>><?php echo $i; ?></a>
				<?php
				
				}}
				}
				
				?>
				<?php if($count > 50){ ?>
				<a href="#">More</a>
				<?php } ?>
				<!-- <a href="#"><i class="fa fa-angle-double-left"></i></a> <a href="#"><i class="fa fa-angle-left"></i></a> <a href="#" class="active">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#"><i class="fa fa-angle-right"></i></a> <a href="#"><i class="fa fa-angle-double-right"></i></a>--> 
			</div>
		</div>
	</div>
</div>
<?php ?>
