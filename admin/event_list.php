<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_event"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="25%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Schedule</th>
						<th>Event</th>
						<th>Venue</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM events order by unix_timestamp(date_created) desc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo date("M d,Y h:i A",strtotime($row['event_datetime']))?></b></td>
						<td><b><?php echo ucwords($row['event']) ?></b></td>
						<td><b><?php echo ucwords($row['venue']) ?></b></td>
						<td class="text-center">
							<div class="d-block">
							<?php if($row['status'] == 0): ?>
							<?php if(strtotime(date("Y-m-d H:i:s")) < strtotime($row['event_datetime'])): ?>
								<span class="badge badge-secondary">Pending</span>
							<?php else: ?>
								<input type="checkbox" name="status_chk" id="" checked data-bootstrap-switch data-toggle="toggle" data-on="Open" data-off="Close" class="switch-toggle status_chk" data-size="xs" data-offstyle="secondary" data-width="5rem" data-id='<?php echo $row['id'] ?>'>
								<br>
								<small><i>Click the swith to update.</i></small>
							<?php endif; ?>
							<?php elseif($row['status'] == 1): ?>
								<input type="checkbox" name="status_chk" id="" checked data-bootstrap-switch data-toggle="toggle" data-on="Open" data-off="Close" class="switch-toggle status_chk" data-size="xs" data-offstyle="secondary" data-width="5rem" data-id='<?php echo $row['id'] ?>'>
								<br>
								<small><i>Click the swith to update.</i></small>
								
							<?php elseif($row['status'] == 2): ?>
								<input type="checkbox" name="status_chk" id="" data-bootstrap-switch data-toggle="toggle" data-on="Open" data-off="Close" class="switch-toggle status_chk" data-size="xs" data-offstyle="secondary" data-width="5rem" data-id='<?php echo $row['id'] ?>'>
								<br>
								<small><i>Click the swith to update.</i></small>
							<?php endif; ?>
							</div>
						</td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="./index.php?page=edit_event&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                         <a href="./index.php?page=view_event&id=<?php echo $row['id'] ?>" class="btn btn-info btn-flat">
		                          <i class="fas fa-eye"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_event" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>

	$(document).ready(function(){
		$('#list').dataTable()
	$('.delete_event').click(function(){
	_conf("Estas seguro de eliminar este evento","delete_event",[$(this).attr('data-id')])
	})

	$('.status_chk').change(function(){
		var status = $(this).prop('checked') == true ? 1 : 2;
		if($(this).attr('data-state-stats') !== undefined && $(this).attr('data-state-stats') == 'error'){
			$(this).removeAttr('data-state-stats')
			return false;
		}
		// return false;
		var id = $(this).attr('data-id');
		start_load()
		$.ajax({
			url:'ajax.php?action=update_event_stats',
			method:'POST',
			data:{id:id,status:status},
			error:function(err){
				console.log(err)
				alert_toast("Algo malo sucedió mientras se actualizaba evento",'error')
					$('#status_chk').attr('data-state-stats','error').bootstrapToggle('toggle')
					end_load()
			},
			success:function(resp){
				if(resp == 1){
					alert_toast("Estado exitósamente actualizado.",'success')
					end_load()
				}else{
					alert_toast("Algo salió mal mientras se actualizaba estado",'error')
					$('#status_chk').attr('data-state-stats','error').bootstrapToggle('toggle')
					end_load()
				}
			}
		})
	})
	})
	function delete_event($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_event',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Datos guardados exitósamente",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>