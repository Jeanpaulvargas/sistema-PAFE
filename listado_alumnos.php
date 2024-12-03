<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=nuevo_alumno"><i class="fa fa-plus"></i> Agregar Nuevo</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <table class="table table-bordered table-hover table-striped"> -->
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
				</colgroup>
				<thead class="text-center">
					<tr class="bg-gradient-dark text-light">
						<th>No.</th>
						<th>Catalogo</th>
						<th>Nombre</th>
						<th>Estado</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php
					$i = 1;
					$qry = $conn->query("SELECT *,concat(nombres,' ',apellidos) as name FROM alumnos");
					while ($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++ ?></td>
							<td class=""><b><?php echo $row['catalogo'] ?></b></td>
							<td><b><?php echo ucwords($row['name']) ?></b></td>

							<td class="text-center">
								<?php
										 switch ($row['estado']) {
											case 0:
												echo '<span class="rounded-pill badge badge-danger bg-gradient-danger px-3">Inactivo</span>';
												break;
											case 1:
												echo '<span class="rounded-pill badge badge-success bg-gradient-success px-3">Activo</span>';
												break; 
										}
										?>
							</td>

							<td class="text-center">
								<div class="btn-group">
									<a href="index.php?page=editar_alumno&id_alumno=<?php echo $row['id_alumno'] ?>" class="btn btn-primary btn-flat ">
										<i class="fas fa-edit"></i>
									</a>
									<button type="button" class="btn btn-danger btn-flat eliminar_alumno" data-id="<?php echo $row['id_alumno'] ?>">
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
<style>
	table td {
		vertical-align: middle !important;
	}
</style>
<script>
	$(document).ready(function() {
		$('#list').dataTable()
		$('.view_student').click(function() {
			uni_modal("Detalles de Alumnos", "listado_alumnos.php?id_alumno=" + $(this).attr('data-id'), "large")
		})
		$('.eliminar_alumno').click(function() {
			_conf("Está segur@ que desea eliminar este alumno", "eliminar_alumno", [$(this).attr('data-id')])
		})
	})

	function eliminar_alumno($id_alumno) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=eliminar_alumno',
			method: 'POST',
			data: {
				id_alumno: $id_alumno
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Datos eliminados exitosamente", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>
