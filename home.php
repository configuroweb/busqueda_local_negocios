<?php include('admin/db_connect.php') ?>
<div class="d-block w-100 position-relative rounded-bottom shadow-lg mb-4">
  <img src="assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>"  style="object-fit: cover;width: 100%;height:80vh" class="img-fluid  rounded-bottom" alt="">
  <div class="position-absolute d-flex justify-content-center w-100" style="z-index: 1;bottom: -2rem">
    <div class="card card-outline card-primary" style="width:calc(80%);">
      <div class="card-body">
        <div class="d-100 d-flex justify-content-center align-items-end">
          <div class="col-sm-4 form-group">
            <label for="service">Categoría de Servicios</label>
            <select name="service_id" id="" class="form-control select2 select2-sm">
              <option value=""></option>
              <?php 
              $services = $conn->query("SELECT * FROM services order by service asc");
              while($row = $services->fetch_assoc()):
              ?>
              <option value="<?php echo $row['id'] ?>" <?php echo isset($_GET['s']) && $_GET['s'] == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['service']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-sm-4 form-group">
            <label for="service">Ubicación</label>
            <select name="area_id" id="" class="form-control select2 select2-sm">
              <option value=""></option>
              <?php 
              $areas = $conn->query("SELECT * FROM areas order by area asc");
              while($row = $areas->fetch_assoc()):
              ?>
              <option value="<?php echo $row['id'] ?>" <?php echo isset($_GET['a']) && $_GET['a'] == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['area']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-3">
            <button class="btn btn-sb btn-flat btn-primary bg-gradient-primary" id="find_sp">Buscar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-lg-12 mt-4">
  <div class="row " id="sp-list">
      
  </div>
</div>
<div class="d-none" id="clone-sp-item">
  <div class="card card-widget widget-user mx-1 my-1 rounded-bottom sp-item" style="width: 18rem; cursor: pointer;">
          <div class="widget-user-header bg-info">
            <h3 class="widget-user-username sp-name"></h3>
            <h6 class="widget-user-desc sp-c"></h6>
          </div>
          <div class="widget-user-image">
            <img class="img-circle elevation-2 sp-img  bg-white" src="" alt="User Avatar" style="height: 90px">
          </div>
      </div>
</div>
<style> 
.sp-item:hover{
    box-shadow: 0 1rem 3rem black!important;
    opacity: .9
}
</style>
<script>

 $('#find_sp').click(function(){
  var s = $('[name="service_id"]').val()
  var a = $('[name="area_id"]').val()
  window.history.pushState({}, null, 'index.php?search&s='+s+'&a='+a);
  load_sp();
 })
 $(document).ready(function(){
    load_sp()
 })
 function load_sp(){
    var nl = new URLSearchParams(window.location.search);
    var s =nl.get('s') || '';
    var a =nl.get('a') || '';
    if(s == '' || a==''){
      $('#sp-list').html('');
      return false;
    }
    $('#ns').remove()
    start_load();
    $.ajax({
      url:'admin/ajax.php?action=find_sp',
      method:"POST",
      data:{s:s,a:a},
      error:function(err){
        alert_toast("An error occured",'error')
        end_load()
      },
      success:function(resp){
        if(typeof (JSON.parse(resp)) ==='object'){
            resp = JSON.parse(resp)
            if(resp.length <= 0){
              $('#sp-list').html('<div class="d-block text-center" id="ns"><b>No Result.</b></div>');
            }else{
              $('#sp-list').html('');
              Object.keys(resp).map(k=>{
                var data = resp[k]
                var item = $('#clone-sp-item .sp-item').clone();
                item.find('.sp-name').text(data.name)
                item.find('.sp-c').text(data.type)
                item.find('.sp-img').attr('src','assets/uploads/'+data.img_path)
                item.attr('data-id',data.id)
                $('#sp-list').append(item)
              })
            }
        }
      },
      complete:function(){
        end_load()
        console.log($('#sp-list'))
        $("html, body").animate({ scrollTop: $('#sp-list').offset().top }, "fast");
         $('.sp-item').click(function(){
          uni_modal("","view_persons_companies.php?view=user&id="+$(this).attr('data-id'),'large')
        })
      }
    })
 }
</script>