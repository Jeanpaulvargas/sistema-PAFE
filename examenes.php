<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary nuevo_examen" href="javascript:void(0)"><i class="fa fa-plus"></i> Agregar Nuevo</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="10%">
					<col width="50%">
					<col width="20%">
					<col width="20%">
				</colgroup>
				<thead class="text-center">
					<tr class="bg-gradient-dark text-light">
						<th>No.</th>
						<th>Nombre del Examen</th>
						<th>Año del Examen</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM examenes");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th><?php echo $i++ ?></th>
						<td><b><?php echo $row['nombre_examen'] ?></b></td>
						<td><b><?php echo $row['año_examen'] ?></b></td>
						<td>
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id_examen'] ?>' class="btn btn-primary btn-flat admin_examen">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat eliminar_examen" data-id="<?php echo $row['id_examen'] ?>">
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
		$('.nuevo_examen').click(function(){
			uni_modal("Gestionar examen por año","admin_examen.php")
		})
		$('.admin_examen').click(function(){
			uni_modal("Gestionar examen por año","admin_examen.php?id_examen="+$(this).attr('data-id'))
		})
	$('.eliminar_examen').click(function(){
	_conf("¿Está segur@ que desea eliminar este examen?","eliminar_examen",[$(this).attr('data-id')])
	})
	})
	function eliminar_examen($id_examen){
		start_load()
		$.ajax({
			url:'ajax.php?action=eliminar_examen',
			method:'POST',
			data:{id_examen:$id_examen},
			success:function(resp){
				if(resp==1){
					alert_toast("Datos eliminados exitosamente",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>