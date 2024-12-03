<?php
include 'db_connect.php';
if(isset($_GET['id_examen'])){
	$qry = $conn->query("SELECT * FROM examenes where id_examen={$_GET['id_examen']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-class">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div id="msg" class="form-group"></div>
		<div class="form-group">
			<label for="level" class="control-label">Nombre del Examen</label>
			<input type="text" class="form-control form-control-sm" name="level" id="level" value="<?php echo isset($nombre_examen) ? $nombre_examen : '' ?>">
		</div>
		<div class="form-group">
			<label for="section" class="control-label">Año del examen</label>
			<input type="text" class="form-control form-control-sm" name="section" id="section" value="<?php echo isset($año_examen) ? $año_examen : '' ?>">
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#manage-class').submit(function(e){
			e.preventDefault();
			start_load()
			$('#msg').html('')
			$.ajax({
				url:'ajax.php?action=guardar_examen',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp == 1){
						alert_toast("Datos guardados exitosamente","success");
						setTimeout(function(){
							location.reload()	
						},1750)
					}else if(resp == 2){
						$('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> El examne ya existe actualmente</div>')
						end_load()
					}
				}
			})
		})
	})

</script>