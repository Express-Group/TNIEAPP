<div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready( function(e) {
   $.ajax({
		type:'post',
		cache:false,
		url:'https://www.arcgis.com/apps/opsdashboard/index.html',
		 type: 'html',
		  headers: {  'Access-Control-Allow-Origin': '*' },
		sucess:function(result){
		$('div').html(result);
		}
		
   })
});
</script>
