<?php if (!isset($conn)) {
  include 'db_connect.php';

} ?>

<div class="col-lg-12">
  <div class="card card-outline card-primary">
    <div class="card-header">
          
        </div>
    <div class="card-body">
      <form action="" id="manage-student">
        <input type="hidden" name="id_alumno" value="<?php echo isset($id_alumno) ? $id_alumno : '' ?>">
       
        <!-- <div class="row"> -->
    
        <div id="msg" class=""></div>

        <div class="row">
          <div class="form-group text-dark">
            <div class="form-group">
              <label for="" class="control-label">Catalogo Alumno</label>
              <input type="text" class="form-control form-control-sm" name="catalogo" autofocus value="<?php echo isset($catalogo) ? $catalogo : '' ?>" required>
            </div>
          </div>
        </div>

        <div class="row">
         
            <div class="form-group col-md-4">
              <label for="" class="control-label">Grado</label>
              <input type="text" class="form-control form-control-sm" name="grado" value="<?php echo isset($grado) ? $grado : '' ?>" required>
            </div>
            <div class="form-group col-md-4">
              <label for="" class="control-label">Nombres</label>
              <input type="text" class="form-control form-control-sm" name="nombres" value="<?php echo isset($nombres) ? $nombres : '' ?>" required>
            </div>
            <div class="form-group col-md-4">
              <label for="" class="control-label">Apellidos</label>
              <input type="text" class="form-control form-control-sm" name="apellidos" value="<?php echo isset($apellidos) ? $apellidos : '' ?>"required>
            </div>
        </div>
          <div class="row">
            <div class="form-group col-md-4">
              <label for="" class="control-label">Edad</label>
              <input type="number" class="form-control form-control-sm" name="edad" min="1" value="<?php echo isset($edad) ? $edad : '' ?>" required>
            </div>

            <div class="form-group col-md-4">
              <label for="" class="control-label">Peso (lbs)</label>
              <input type="number" class="form-control form-control-sm" name="peso" min="1" value="<?php echo isset($peso) ? $peso : '' ?>" required>
            </div>
            <div class="form-group col-md-4">
              <label for="" class="control-label">Estatura (cms)</label>
              <input type="number" class="form-control form-control-sm" name="estatura" min="1" value="<?php echo isset($estatura) ? $estatura : '' ?>" required>
            </div>
            </div>
            <div class="row">
            <div class="form-group col-md-4">
              <label for="dob" class="control-label">Fecha de Nacimiento</label>
              <input type="date" name="fecha_nac" id="fecha_nac" value="<?= isset($fecha_nac) ? $fecha_nac : "" ?>" class="form-control form-control-sm rounded-0" required>
            </div>
            <div class="form-group col-md-4">
              <label for="" class="control-label">Telefono</label>
              <input type="text" class="form-control form-control-sm" name="telefono" value="<?php echo isset($telefono) ? $telefono : '' ?>" required>
            </div>

            <div class="form-group col-md-4">
              <label for="" class="control-label">Género</label>
              <select name="id_genero" id="id_genero" class="custom-select custom-select-sm" required>
                  <option>--Seleccione--</option> 
                <option value="1">Masculino</option>
                <option value="2">Femenino</option>
              </select>
            </div>
            </div>
            <div class="row">
            <div class="form-group col-md-4">
              <div class="form-group">
                <label for="" class="control-label">Dirección</label>
                <textarea name="direccion" id="direccion" cols="30" rows="4" class="form-control"><?php echo isset($direccion) ? $direccion : '' ?></textarea>
              </div>
         
            </div>
        </div>
    
      <!-- </div> -->
      </form>
    </div>
    <div class="card-footer border-top border-info">
      <div class="d-flex w-100 justify-content-center align-items-center">
        <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-student">Guardar</button>
        <a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=listado_alumnos">Cancelar</a>
      </div>
    </div>
  </div>
</div>
<script>
  $('#manage-student').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
      url: 'ajax.php?action=save_student',
      data: new FormData($(this)[0]),
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      type: 'POST',
      success: function(resp) {
        if (resp == 1) {
          alert_toast('Datos guardados exitosamente', "success");
          setTimeout(function() {
            location.href = 'index.php?page=listado_alumnos'
          }, 2000)
        } else if (resp == 2) {
          $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> El Código de alumno ya existe.</div>')
          end_load()
        }
      }
    })
  })

  function displayImgCover(input, _this) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#cover').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>