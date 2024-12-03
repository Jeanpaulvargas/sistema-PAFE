<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id_usuario'])){
$user = $conn->query("SELECT * FROM usuarios where id_usuario =".$_GET['id_usuario']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id_usuario" value="<?php echo isset($meta['id_usuario']) ? $meta['id_usuario']: '' ?>">
		<div class="form-group">
			<label for="name">Nombre</label>
			<input type="text" name="nombres" id="nombres" class="form-control" value="<?php echo isset($meta['nombres']) ? $meta['nombres']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="name">Apellido</label>
			<input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php echo isset($meta['apellidos']) ? $meta['apellidos']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Usuario</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Contraseña</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<small><i> Deja este campo en blanco si no desea cambiar la contraseña.</i></small>
		</div>
		

	</form>
</div>
<style>
	img#cimg{
		max-height: 15vh;
		/*max-width: 6vw;*/
	}
</style>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					alert_toast("Datos guardados exitosamente",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">El usuario ya existe</div>')
					end_load()
				}
			}
		})
	})

</script>