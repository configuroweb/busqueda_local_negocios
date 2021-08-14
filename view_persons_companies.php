<?php include 'admin/db_connect.php' ?>
<?php
if(isset($_GET['id'])){
  $_type = array("","Single/Freelancer","Group/Company");
	$qry = $conn->query("SELECT pc.*,s.service FROM persons_companies pc inner join services s on s.id = pc.service_id where pc.id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
if(!empty($areas_id)){
  $areas= array();
  $aqry = $conn->query("SELECT * FROM areas where id in ($areas_id)");
  while($row=$aqry->fetch_assoc()){
    $areas[] = ucwords($row['area']);
  }
}
}
?>
<div class="container-fluid">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-widget widget-user shadow">
            <div class="widget-user-header bg-dark">
                <h3 class="widget-user-username"><?php echo ucwords($name) ?></h3>
                <h5 class="widget-user-desc"><?php echo $_type[$type] ?></h5>
              </div>
              <div class="widget-user-image">
                <?php if(empty($img_path) || (!empty($img_path) && !is_file('assets/uploads/'.$img_path))): ?>
                <span class="brand-image img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 90px;height:90px"><h4><?php echo strtoupper(substr($name, 0,1)) ?></h4></span>
                <?php else: ?>
                <img class="img-circle elevation-2"  style="width: 90px;height:90px;object-fit: cover;" src="assets/uploads/<?php echo $img_path ?>" alt="User Avatar">
                <?php endif ?>
              </div>
              <div class="card-footer">
                <div class="container-fluid">
                  <dl>
                    <dt>Proveedor de Servicios</dt>
                    <dd><?php echo ucwords($service) ?></dd>
                  </dl>
                  <dl>
                    <dt>Dirección</dt>
                    <dd><?php echo $address ?></dd>
                  </dl>
                 <dl>
                    <dt>Contacto</dt>
                    <dd><?php echo $contact ?></dd>
                  </dl>
                  <dl>
                    <dt>Áreas Servicio</dt>
                    <dd>
                      <?php if(isset($areas)): ?>
                      <?php foreach($areas as $k => $v): ?>
                        <span class="badge badge-primary"><?php echo ucwords($v) ?></span>
                      <?php endforeach; ?>
                      <?php endif; ?>
                    </dd>
                  </dl>

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="callout callout-info">
          <b>Descripción/Otros detalles</b>
          <div>
            <?php echo html_entity_decode($description) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
	
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>