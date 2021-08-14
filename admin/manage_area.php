<?php
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM areas where id={$_GET['id']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-area">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="area" class="control-label">Area</label>
			<input type="text" class="form-control form-control-sm" name="area" id="area" value="<?php echo isset($area) ? $area : '' ?>">
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#manage-area').submit(function(e){
			e.preventDefault();
			start_load()
			$.ajax({
				url:'ajax.php?action=save_area',
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