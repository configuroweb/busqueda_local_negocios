<?php 
if(file_exists('../about.html'))
	$content = file_get_contents('../about.html');
?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-about">
			<div class="form-group">
				<textarea name="content" id="content" cols="30" rows="10" class="summernote2 form-control">
						<?php echo isset($content) ? $content : '' ?>
				</textarea>
			</div>
			</form>
		</div>
		<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-about">Guardar</button>
    		</div>
    	</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.summernote2').summernote({
        height: 300,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'insert', [ 'link','picture' ] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ],
        callbacks:{
	        onImageUpload: function(files) {
		      saveImg(files[0]);
		    }
        }

    })
		function saveImg(_file){
		var data = new FormData();
    		data.append("file", _file);
			$.ajax({
		      data: data,
		      type: "POST",
		      url: "ajax.php?action=save_image",
		      cache: false,
		      contentType: false,
		      processData: false,
		      success: function(resp) {
		        var image = $('<img>').attr('src', resp);
           		 $('.summernote2').summernote("insertNode", image[0]);
		      }
		    });
		}
	})
	$('#manage-about').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_about',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Datos guardados exitósamente',"success");
					end_load()
				}
			}
		})
	})
</script>