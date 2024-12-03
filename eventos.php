<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary nuevo_evento" href="javascript:void(0)"><i class="fa fa-plus"></i> Agregar Nuevo</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="10%">
					<col width="30%">
					<col width="50%">
					<col width="20%">
				</colgroup>
				<thead class="text-center">
					<tr class="bg-gradient-dark text-light">
						<th class="text-center">No.</th>
						<th>Nombre del Evento</th>
						<th>Descripción del Evento</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM eventos");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['nombre_evento']) ?></b></td>
						<td><p class=""><?php echo $row['descripcion_evento'] ?></p></td>
						<td>
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id_evento'] ?>' class="btn btn-primary btn-flat admin_evento">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat eliminar_evento" data-id="<?php echo $row['id_evento'] ?>">
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
		$('.nuevo_evento').click(function(){
			uni_modal("Nuevo Evento","admin_eventos.php")
		})
		$('.admin_evento').click(function(){
			uni_modal("Gestionar Eventos","admin_eventos.php?id_evento="+$(this).attr('data-id'))
		})
	$('.eliminar_evento').click(function(){
	_conf("¿Estás segur@ que desea eliminar este evento?","eliminar_evento",[$(this).attr('data-id')])
	})
	})
	function eliminar_evento($id_evento){
		start_load()
		$.ajax({
			url:'ajax.php?action=eliminar_evento',
			method:'POST',
			data:{id_evento:$id_evento},
			success:function(resp){
				if(resp==1){
					alert_toast("Datos Eliminados Exitosamente",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>