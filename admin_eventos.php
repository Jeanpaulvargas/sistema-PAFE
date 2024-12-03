<?php
include 'db_connect.php';
if(isset($_GET['id_evento'])){
	$qry = $conn->query("SELECT * FROM eventos where id_evento={$_GET['id_evento']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-subject">
		<input type="hidden" name="id_evento" value="<?php echo isset($id_evento) ? $id_evento : '' ?>">
		<div id="msg" class="form-group"></div>
		
		<div class="form-group">
			<label for="subject" class="control-label">Evento</label>
			<input type="text" class="form-control form-control-sm" name="subject" id="subject" value="<?php echo isset($nombre_evento) ? $nombre_evento : '' ?>">
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Descripción Evento</label>
			<textarea name="description" id="description" cols="30" rows="4" class="form-control"><?php echo isset($descripcion_evento) ? $descripcion_evento : '' ?></textarea>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#manage-subject').submit(function(e){
			e.preventDefault();
			start_load()
			$.ajax({
				url:'ajax.php?action=guardar_evento,
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp == 1){
						alert_toast("Datos guardados exitosamente.","success");
						setTimeout(function(){
							location.reload()	
						},1750)
					}else if(resp == 2){
						$('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> El Código del Evento ya existe</div>')
						end_load()
					}
				}
			})
		})
	})

</script>