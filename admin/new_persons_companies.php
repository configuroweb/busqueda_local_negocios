<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-persons_companies">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group text-dark">
              <label for="" class="control-label">Categoría de Servicios</label>
              <select name="service_id" id="service_id" class="form-control select2 text-dark">
                <option value=""></option>
                <?php
                  $category = $conn->query("SELECT * FROM services order by service asc");
                  while($row = $category->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($service_id) && $service_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['service']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group text-dark">
              <label for="" class="control-label">Area de Servicio</label>
              <select name="areas_id[]" id="areas_id" multiple="multiple" class="form-control select2 text-dark">
                <option value=""></option>
                <?php
                  $areas = $conn->query("SELECT * FROM areas order by area asc");
                  while($row = $areas->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($areas_id) && in_array($row['id'],explode(',',$areas_id)) ? 'selected' : '' ?>><?php echo ucwords($row['area']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group text-dark">
              <label for="" class="control-label">Tipo de Proveedor</label>
              <select name="type" id="type" class="custom-select custom-select-sm">
                <option value="1" <?php echo isset($type) && $type == 1 ? "selected": '' ?>>Independiente / Profesional</option>
                <option value="2" <?php echo isset($type) && $type == 2 ? "selected": '' ?>>Grupo/Compañía</option>
              </select>
            </div>
          </div>
        </div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Nombre</label>
							<input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>">
						</div>
					</div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Contacto #</label>
              <input type="text" class="form-control form-control-sm" name="contact" value="<?php echo isset($contact) ? $contact : '' ?>">
            </div>
          </div>
				</div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Dirección</label>
              <textarea name="address" id="" cols="30" rows="3" class="form-control"><?php echo isset($address) ? $address : '' ?></textarea>
            </div>
          </div>
        </div>
				<div class="row">
					<div class="col-md-10">
						<div class="form-group">
							<label for="" class="control-label">Descripción</label>
							<textarea name="description" id="" cols="30" rows="4" class="summernote form-control"><?php echo isset($description) ? $description : '' ?></textarea>
						</div>
					</div>
				</div>
        <div class="row">
          <div class="col-md-6">
           <div class="form-group">
              <label for="" class="control-label">Imagen</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile" name="img_path" accept="image/*" onchange="displayImgCover(this,$(this))">
                  <label class="custom-file-label" for="customFile">Escoger archivo</label>
                </div>
            </div>
            <div class="form-group d-flex justify-content-center">
              <img src="../assets/uploads/<?php echo isset($img_path) ? $img_path : '' ?>" alt="" id="cover" class="img-fluid img-thumbnail">
            </div>
          </div>
        </div>
        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-persons_companies">Guardar</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button">Cancelar</button>
    		</div>
    	</div>
	</div>
</div>
<script>
	$('#manage-persons_companies').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_persons_companies',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Datos guardados exitósamente',"success");
					setTimeout(function(){
              location.href = 'index.php?page=persons_companies_list'
					},2000)
				}
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
</script>