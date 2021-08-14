<?php include 'admin/db_connect.php' ?>
<?php 
$event = $conn->query("SELECT * FROM events where md5(id) = '{$_GET['c']}'")->fetch_array();
foreach($event as $k => $v){
	$$k = $v;
}

?>
 <div class="content-header">
      <div class="container-md">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo ucwords($event)." Event" ?></h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
            <hr class="border-primary">
      </div><!-- /.container-fluid -->
    </div>

<div class="col-lg-12">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-outline card-primary">
					<div class="card-header">
						<div class="card-tools d-flex justify-content-end" style="width: calc(40%)">
							<a class="btn btn-block btn-sm btn-default btn-flat border-primary col-sm-4 mr-2" href="javascript:void(0)" onclick="location.reload()"><i class="fa fa-redo"></i> Refresh List</a>
							<?php if($status != 2): ?>
							<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_attendee m-0 col-sm-4" href="javascript:void(0)"><i class="fa fa-plus"></i> New Attendee</a>
							<?php endif; ?>
						</div>
					</div>	
					<div class="card-body">
						<?php if($status == 2): ?>
							<div class="alert alert-info"><i class="fa fa-info-circle"></i> Event's Registration and Attendance is now close. </div>
						<?php endif; ?>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Gender</th>
									<th>Email</th>
									<th>Attendance</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i = 1;
							$qry = $conn->query("SELECT a.*,concat(a.lastname,', ',a.firstname,' ',a.middlename) as name,e.event FROM attendees a inner join events e on e.id = a.event_id where e.id = $id order by unix_timestamp(e.date_created) desc ");
							while($row= $qry->fetch_assoc()):
							?>
							<tr>
								<th class="text-center"><?php echo $i++ ?></th>
								<td><b><?php echo ucwords($row['name']) ?></b></td>
								<td><b><?php echo ucwords($row['gender']) ?></b></td>
								<td><b><?php echo $row['email'] ?></b></td>
								<td class="text-center">
									<input type="checkbox" name="status_chk" id="" data-bootstrap-switch data-toggle="toggle" data-on="Present" data-off="Waiting" class="switch-toggle status_chk" data-size="xs" data-onstyle="success" data-offstyle="danger" data-width="5rem" data-id='<?php echo $row['id'] ?>' <?php echo $row['status'] == '1' ? 'checked' : '' ?>>
								</td>
								<td class="text-center">
				                    <div class="btn-group">
										<?php if($status != 2): ?>
				                        <button href="button" class="btn btn-primary btn-flat edit_attendee" data-id="<?php echo $row['id'] ?>"> 
				                          <i class="fas fa-edit"></i>
				                        </button>
										<?php endif; ?>
				                         <button href="button" class="btn btn-info btn-flat view_attendee" data-id="<?php echo $row['id'] ?>">
				                          <i class="fas fa-eye"></i>
				                        </button>
										<?php if($status != 2): ?>
				                        <button type="button" class="btn btn-danger btn-flat delete_attendee" data-id="<?php echo $row['id'] ?>">
				                          <i class="fas fa-trash"></i>
				                        </button>
										<?php endif; ?>
			                      </div>
								</td>
							</tr>	
						<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('table').dataTable()
		$('.view_attendee').click(function(){
			uni_modal("Attendee Details","view_attendee.php?id="+$(this).attr('data-id'))
		})
		$('.new_attendee').click(function(){
			uni_modal("New Attendee","manage_attendee.php?event_id=<?php echo $id ?>","mid-large")
		})
		$('.edit_attendee').click(function(){
			uni_modal("Edit Attendee's Details","manage_attendee.php?id="+$(this).attr('data-id')+"&event_id=<?php echo $id ?>","mid-large")
		})
		$('.delete_attendee').click(function(){
		_conf("Are you sure to delete this attendee?","delete_attendee",[$(this).attr('data-id')])
		})
		$('.status_chk').change(function(){
			var status = $(this).prop('checked') == true ? 1 : 2;
			if($(this).attr('data-state-stats') !== undefined && $(this).attr('data-state-stats') == 'error'){
				$(this).removeAttr('data-state-stats')
				return false;
			}
			var _this = $(this)
			// return false;
			var id = $(this).attr('data-id');
			start_load()
			$.ajax({
				url:'admin/ajax.php?action=update_attendee_stats',
				method:'POST',
				data:{id:id,status:status},
				error:function(err){
					console.log(err)
					alert_toast("Something went wrong while updating the attendee's status.",'error')
						_this.attr('data-state-stats','error').bootstrapToggle('toggle')
						end_load()
				},
				success:function(resp){
					if(resp == 1){
						alert_toast("attendee status successfully updated.",'success')
						end_load()
					}else if(resp == 2){
						alert_toast("Event Registration and Attendance is close.",'error')
						_this.attr('data-state-stats','error').bootstrapToggle('toggle')
						setTimeout(function(){
							location.reload()
						},2000)
					}else{
						alert_toast("Something went wrong while updating the attendee's status.",'error')
						_this.attr('data-state-stats','error').bootstrapToggle('toggle')
						end_load()
					}
				}
			})
		})
	})
		function delete_attendee($id){
		start_load()
		$.ajax({
			url:'admin/ajax.php?action=delete_attendee',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>