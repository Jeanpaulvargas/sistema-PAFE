<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<?php	if(!isset($_SESSION['rs_id'])): ?>
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=agregar_calificacion"><i class="fa fa-plus"></i> Agregar Calificación</a>
			</div>
		</div>
	<?php endif; ?>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="25%">
					<col width="25%">
					<col width="10%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead class="text-center">
					<tr class="bg-gradient-dark text-light">
						<th>No.</th>
						<th>Catalogo Alumno</th>
						<th>Nombre de Alumno</th>
						<th>Examen / Año</th>
						<th>Cantidad Eventos</th>
						<th>Calificación</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php
					$i = 1;
					$where = "";
					if(isset($_SESSION['rs_id'])){
						$where = " where r.student_id = {$_SESSION['rs_id']} ";
					}
					$qry = $conn->query("SELECT c.*,concat(a.nombres,' ',a.apellidos) as name,a.catalogo,concat(e.nombre_examen,'-',e.año_examen) as examen FROM calificaciones c inner join examenes e on e.id_examen = c.id_examen inner join alumnos a on a.id_alumno = c.id_alumno");
					while($row= $qry->fetch_assoc()):
						$subjects = $conn->query("SELECT * FROM detalle_calificaciones where id_calificacion =".$row['id_calificacion'])->num_rows;
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $row['catalogo'] ?></b></td>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b><?php echo ucwords($row['examen']) ?></b></td>
						<td class="text-center"><b><?php echo $subjects ?></b></td>
						<td class="text-center"><b><?php echo $row['nota_calificacion'] ?></b></td>
						<td class="text-center">
							<?php if(isset($_SESSION['login_id'])): ?>
		                    <div class="btn-group">
		                        <a href="./index.php?page=edit_result&id=<?php echo $row['id_calificacion'] ?>" class="btn btn-primary btn-flat">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                         <button data-id="<?php echo $row['id_calificacion'] ?>" type="button" class="btn btn-info btn-flat view_result">
		                          <i class="fas fa-eye"></i>
		                        </button>
		                        <button type="button" class="btn btn-danger btn-flat delete_result" data-id="<?php echo $row['id_calificacion'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
	                      <?php elseif(isset($_SESSION['rs_id'])): ?>
	                      	<button data-id="<?php echo $row['id'] ?>" type="button" class="btn btn-info btn-flat view_result">
		                          <i class="fas fa-eye"></i>
		                          Ver Resultado
		                        </button>
	                      <?php endif; ?>
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
	$('.delete_result').click(function(){
	_conf("¿Estás segur@ de eliminar este resultado?","delete_result",[$(this).attr('data-id')])
	})

	$('.view_result').click(function(){
		uni_modal("Resultados","view_result.php?id="+$(this).attr('data-id'),'mid-large')
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
			url:'ajax.php?action=update_result_stats',
			method:'POST',
			data:{id:id,status:status},
			error:function(err){
				console.log(err)
				alert_toast("Se produjo un error al actualizar el estado del resultado.",'error')
					$('#status_chk').attr('data-state-stats','error').bootstrapToggle('toggle')
					end_load()
			},
			success:function(resp){
				if(resp == 1){
					alert_toast("Resultado actualizado exitosamente",'success')
					end_load()
				}else{
					alert_toast("Se produjo un error al actualizar el estado del resultado.",'error')
					$('#status_chk').attr('data-state-stats','error').bootstrapToggle('toggle')
					end_load()
				}
			}
		})
	})
	})
	function delete_result($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_result',
			method:'POST',
			data:{id:$id},
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