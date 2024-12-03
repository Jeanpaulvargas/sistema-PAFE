<?php include('db_connect.php') ?>
<!-- Info boxes -->
<style>
    #website-cover {
    display: block;
    width: 400px;
    position: absolute;
    top: 30%;
    left: 45%;

    }
</style>
<?php if($_SESSION['login_tipo'] == 1): ?>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total de Alumnos</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM alumnos")->num_rows; ?>
                </span>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total de Examenes por Año</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM examenes")->num_rows; ?>
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total de Eventos</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM eventos")->num_rows; ?>
                </span>
              </div>
            </div>
          </div>

          
      </div>
      <div class="row">
        
        <img src="assets/uploads/logoguatesf.png" alt="Website Cover"  id="website-cover">
     
        </div>
      
<?php else: ?>
	 <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Bienvenid@ <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
          
<?php endif; ?>
