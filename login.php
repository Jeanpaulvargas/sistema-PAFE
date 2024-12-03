<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
  ob_start();
  // if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM informacion_sistema")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  // }
  ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | <?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id_usuario']))
header("location:index.php?page=home");

?>

</head>


<body class="hold-transition ">

<style>
	body{
    height: calc(100%) !important;
    width: calc(100%) !important;
  
      background-image: url("");
      background-size: cover;
      background-repeat: no-repeat;
	}

  #login {
      flex-direction: column !important
    }

	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
	}
  #logo-img {
    height: 150px;
      width: 150px;
      object-fit: scale-down;
      object-position: center center;
      border-radius: 100%;
    }
    #login .col-7,
    #login .col-5 {
      width: 100% !important;
      max-width: unset !important
    }

</style>
<div class="h-100 d-flex align-items-center w-100" id="login">
  	
  		
		
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="w-100">
        <center><img src="assets/uploads/logoejercito.png ?>" alt="" id="logo-img"></center>
        <h2 class="text-black text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h2>
      </div>

    </div>


    <div class="col-5 h-100 bg-gradient">
    <div class="d-flex w-100 h-100 justify-content-center align-items-center">
      <div class="card col-sm-12 col-md-6 col-lg-3 card-outline card-primary rounded-0 shadow"> 			
          <div class="card-header rounded-0">
            <h4 class="text-purle text-center"><b>Ingresar al PAFE</b></h4>
          </div>
          <div class="card-body rounded-0">
  					<form id="login-form" >
            <div class="input-group mb-3">
                <input type="text" class="form-control" autofocus  id="username" name="username" placeholder="Usuario">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>

  						<div class="input-group mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">

              <div class="col-8">
                </div>

  						<div class="w-100 d-flex justify-content-center align-items-center">
                <button class="btn-sm btn-block btn-wave col-md-4 btn-primary m-0 mr-1">Ingresar</button>
              
              </div>

            </div>
  					</form>
  			
            </div>
  		</div>
    
  		</div>
      </div>


</body>
<?php include 'footer.php' ?>
<script>

	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Usuario o Contraseña Incorrecta</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})

	$('.number').on('input keyup keypress',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9 \,]/, '');
        val = val.toLocaleString('en-US')
        $(this).val(val)
    })
</script>	
</html>