<?php
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM services where id={$_GET['id']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-service">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="service" class="control-label">Servicio</label>
			<input type="text" class="form-control form-control-sm" name="service" id="service" value="<?php echo isset($service) ? $service : '' ?>">
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Descripción</label>
			<textarea name="description" id="description" cols="30" rows="10" class="form-control summernote"><?php echo isset($description) ? $description : '' ?></textarea>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('.summernote').summernote({
	        height: 300,
	        toolbar: [
	            [ 'style', [ 'style' ] ],
	            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
	            [ 'fontname', [ 'fontname' ] ],
	            [ 'fontsize', [ 'fontsize' ] ],
	            [ 'color', [ 'color' ] ],
	            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
	            [ 'table', [ 'table' ] ],
	            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
	        ]
	    })
		$('#manage-service').submit(function(e){
			e.preventDefault();
			start_load()
			$.ajax({
				url:'ajax.php?action=save_service',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp == 1){
						alert_toast("Datos guardados exitósamente","success");
						setTimeout(function(){
							location.reload()	
						},1750)
					}
				}
			})
		})
	})

</script>