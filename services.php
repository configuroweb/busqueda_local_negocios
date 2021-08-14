<?php include 'admin/db_connect.php' ?>

<div class="col-lg-12 py-3">
	<div class="d-flex justify-content-center">
		<div class="form-group" style="width:calc(50%) ">
			<div class="input-group">
              <input type="search" id="filter" class="form-control form-control-sm" placeholder="Search...">
              <div class="input-group-append">
                  <button type="button" id="search" class="btn btn-sm btn-primary">
                      <i class="fa fa-search"></i>
                  </button>
              </div>
          </div>
		</div>
	</div>
	<div class="row " id="service-list">
		<?php 
		$services = $conn->query("SELECT * FROM services order by service asc");
		while($row = $services->fetch_assoc()):
			$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
			unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
			$desc = strtr(html_entity_decode($row['description']),$trans);
			$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
		?>
		<div class="col-md-4  s-item" data-id = "<?php  echo $row['id'] ?>" data-title="<?php echo ucwords($row['service']) ?>">
			<div class="callout callout-success">
				<dl>
					<dt><h5><b><?php echo $row['service'] ?></b></h5></dt>
					<dd><p class="truncate"><?php echo strip_tags($desc) ?></p></dd>
				</dl>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
</div>
<style>
.s-item{
    cursor:pointer
} 
.s-item:hover .callout{
    box-shadow: 0 1rem 3rem black!important;
    opacity: .9
}
</style>
<script>
	$('.s-item').click(function(){
          uni_modal($(this).attr('data-title'),"view_service.php?id="+$(this).attr('data-id'),'mid-large')
        })
	function _filter(){
		var _ftxt = $('#filter').val().toLowerCase()
		$('.s-item').each(function(){
			var _content = $(this).text().toLowerCase()
			if(_content.includes(_ftxt) == true){
				$(this).toggle(true)
			}else{
				$(this).toggle(false)
			}
		})
		check_list()
	}
	function check_list(){
		var count = $('.s-item:visible').length
		if(count > 0){
			if($('#ns').length > 0)
				$('#ns').remove()
		}else{
			var ns = $('<div class="col-md-12 text-center text-white" id="ns"><b><i>No data to be display.</i></b></b></div>')
			$('#service-list').append(ns)
		}
	}
	$('#search').click(function(){
	    _filter()
	  })
	  $('#filter').on('keypress',function(e){
	    if(e.which ==13){
	    _filter()
	     return false; 
	    }
	  })
	  $('#filter').on('search', function () {
	      _filter()
	  })
</script>