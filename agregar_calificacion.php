<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-result">
        <input type="hidden" name="id_calificacion" value="<?php echo isset($id_calificacion) ? $id_calificacion : '' ?>">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div id="msg" class=""></div>
            <div class="form-group">
                <label for="" class="control-label">Alumno</label>
                <select name="student_id" id="student_id" class="form-control select2 select2-sm" required>
                  <option></option> 
                  <?php 
                        $classes = $conn->query("SELECT a.*,concat(nombres,' ',apellidos) as name FROM alumnos a order by concat(nombres,' ',apellidos) asc ");
                        while($row = $classes->fetch_array()):
                  ?>
                        <option value="<?php echo $row['id_alumno'] ?>" <?php echo isset($id_alumno) && $id_alumno == $row['id_alumno'] ? "selected" : '' ?>><?php echo $row['catalogo'].' | '.ucwords($row['name']) ?></option>
                  <?php endwhile; ?>
                </select>
                
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="d-flex justify-content-center align-items-center">
            	<div class="form-group col-sm-4">
	                <label for="" class="control-label">Nombre del Evento</label>
	                <select name="subject_id" id="subject_id" class="form-control select2 select2-sm input-sm">
	                  <option></option> 
	                  <?php 
	                        $classes = $conn->query("SELECT * FROM eventos");
	                        while($row = $classes->fetch_array()):
	                  ?>
	                        <option value="<?php echo $row['id_evento'] ?>" data-json='<?php echo json_encode($row) ?>'><?php echo $row['nombre_evento'] ?></option>
	                  <?php endwhile; ?>
	                </select>
	            </div>
	            <div class="form-group col-sm-3">
	                <label for="" class="control-label">Repeticiones / Tiempo (Eje. 30 / 9:10) </label>
	                <input type="text" class="form-control form-control-sm text-right" name="cantidad" id="cantidad" maxlength="6">
	            </div>
				<div class="form-group col-sm-3">
	                <label for="" class="control-label">Porcentaje</label>
	                <input type="text" class="form-control form-control-sm text-right" id="mark" readonly>
	            </div>
	            <button class="btn btn-sm btn-primary bg-gradient-primary" type="button" id="add_mark">Agregar</button>
            </div>
        </div>
    	<hr>
    	<div class="col-md-8 offset-md-2">
            <table class="table table-bordered" id="mark-list">
            	<thead>
            		<tr class="text-center">
						<th>Código</th>
            			<th>Evento</th>
            			<th>Repeticiones / Tiempo</th>
            			<th>Procentaje</th>
            			<th></th>
            		</tr>
            	</thead>
            	<tbody>
            		<?php if(isset($id_calificacion)): ?>
            		<?php 
            			$items=$conn->query("SELECT dc.*,e.id_evento as eid,e.nombre_evento FROM detalle_calificaciones dc inner join eventos e on e.id_evento = dc.id_evento where dc.id_calificacion = $id_calificacion ");
            			while($row = $items->fetch_assoc()):
            		?>
            		<tr data-id="<?php echo $row['eid'] ?>">
            			<td ><input type="hidden" name="id_evento[]" value="<?php echo $row['id_evento'] ?>"></td>
            			<td class="text-center"><?php echo ucwords($row['nombre_evento']) ?></td>
            			<td><input type="hidden" name="cantidad[]" value="<?php echo $row['cantidad/tiempo'] ?>"><?php echo $row['cantidad/tiempo'] ?></td>
						<td><input type="hidden" name="mark[]" value="<?php echo $row['puntos_evento'] ?>"><?php echo $row['puntos_evento'] ?></td>
            			<td class="text-center"><button class="btn btn-sm btn-danger" type="button" onclick="$(this).closest('tr').remove() && calc_ave()"><i class="fa fa-times"></i></button></td>
            		</tr>
            		<?php endwhile; ?>
            		<script>
            			$(document).ready(function(){
            				calc_ave()
            			})
            		</script>
            		<?php endif; ?>

            	</tbody>
            	<tfoot>
					   <tr  class="text-center">
            			<th colspan="3">Promedio</th>
            			<th id="average" class="text-center"></th>
            			<th></th>
            		</tr>
            	</tfoot>
            </table>
            <input type="hidden" name="nota_calificacion" value="<?php echo isset($nota_calificacion) ? $nota_calificacion : '' ?>">
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-result">Guardar</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=calificaciones">Cancelar</a>
  		</div>
  	</div>
	</div>
</div>
<script>
	$('#student_id').change(function(){
		var class_id = $('#student_id option[value="'+$(this).val()+'"]').attr('data-class_id');
		var _class = $('#student_id option[value="'+$(this).val()+'"]').attr('data-class');
		$('[name="class_id"]').val(class_id)
		$('#class').text("Año actual: "+_class);
	})
	$('#add_mark').click(function(){
		var id_evento = $('#subject_id').val()
		var cantidad = $('#cantidad').val()
		var mark = $('#mark').val()
		if(id_evento == '' && cantidad == ''){
			alert_toast("Debe seleccionar un evento e ingresar las repeticiones/tiempo para ser agregadas.","error");
			return false;
		}
		var sData = $('#subject_id option[value="'+id_evento+'"]').attr('data-json')
			sData = JSON.parse(sData)
		if($('#mark-list tr[data-id="'+id_evento+'"]').length > 0){
			alert_toast("El evento ya existe","error");
			return false;
		}
		var tr = $('<tr data-id="'+id_evento+'"></tr>')
		tr.append('<td class="text-center"><input type="hidden" name="id_evento[]" value="'+id_evento+'">'+sData.id_evento+'</td>')
		tr.append('<td class="text-center">'+sData.nombre_evento+'</td>')
		tr.append('<td class="text-center"><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td>')
		tr.append('<td class="text-center"><input type="hidden" name="mark[]" value="'+mark+'">'+mark+'</td>')
		tr.append('<td class="text-center"><button class="btn btn-sm btn-danger" type="button" onclick="$(this).closest(\'tr\').remove() && calc_ave()"><i class="fa fa-times"></i></button></td>')
		$('#mark-list tbody').append(tr);
		$('#subject_id').val('').trigger('change');
		$('#mark').val('');
		$('#cantidad').val('');
		calc_ave();

	})
	function calc_ave(){
		var total = 0;
		var i = 0;
		$('#mark-list [name="mark[]"]').each(function(){
			i++;
			total = total + parseFloat($(this).val())
		})
		$('#average').text(parseFloat(total/i).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2}))
		$('[name="nota_calificacion"]').val(parseFloat(total/i).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2}))
	}
	$('#manage-result').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=guardar_calificacion',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Datos guardados exitosamente',"success");
					setTimeout(function(){
              location.href = 'index.php?page=calificaciones'
					},2000)
				}else if(resp == 2){
          $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> El Código del Alumno existe actualmente</div>')
          end_load()
        }
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }

  document.getElementById("cantidad").onchange = function(){porcentaje()};
    function porcentaje() {

		try {

	
        // Creando el objeto para hacer el request
        var request = new XMLHttpRequest();
 
        // Objeto PHP que consultaremos
        request.open("POST", "porcentaje.php");
 
        // Definiendo el listener
        request.onreadystatechange = function() {
            // Revision si fue completada la peticion y si fue exitosa
            if(this.readyState === 4 && this.status === 200) {
                // Ingresando la respuesta obtenida del PHP
                document.getElementById("mark").value = this.responseText;
            }
        };
 
        // Recogiendo la data del HTML
        var myForm = document.getElementById("manage-result");
        var formData = new FormData(myForm);
 
        // Enviando la data al PHP
        request.send(formData);
	} catch (ex) {
		console.error("Se encontró un error:", ex.message);

	}

    }

  </script>