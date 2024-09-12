<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	session_start();
	
	if($_POST){
			
		include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
    	include_once (CSQL_DIR."ColegioBd.php");

		$Usuario1 = $_POST['TUsuaUsuar'];
		$Clave1 = $_POST['TUsuaClave'];

		//$pass_c = sha1($Clave1);
		$Repues = new RegDatos();
		$usuar=$Repues->Usuario_Verificar($Usuario1,$Clave1);	

		if( $usuar){
			//print_r("intitucion".$usuar->InstId);
			if($Clave_bd == $pass_c){
				
				$_SESSION['SUsuaId'] = $usuar->UsuaId;
				$_SESSION['SUsuaNomb'] = $usuar->UsuaNomb;
				$_SESSION['SUsuaNivel'] = $usuar->UsuaNivel;
				$_SESSION['SInstId'] = $usuar->InstId;
				$_SESSION['STexto'] = "dark";
				$_SESSION['SFondo'] = "dark";
				
				header("Location: principal.php");
				
			} else { session_destroy(); echo "La contraseña no coincide   ";}			
		} else {echo "NO existe Usuario";}				
	}
	
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf8_spanish_ci" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WebApp Control de notas</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
	
	</head>
    <body>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
					<section class="vh-100" style="background-color: #9A616D;">
						<div class="container py-5 h-100">
							<div class="row d-flex justify-content-center align-items-center h-100">
							<div class="col col-xl-10">
								<div class="card" style="border-radius: 1rem;">
								<div class="row g-0">
									<div class="col-md-6 col-lg-5 d-none d-md-block">
									<img src="Imagen/Logo1.JPG"
										alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
									</div>
									<div class="col-md-6 col-lg-7 d-flex align-items-center">
									<div class="card-body p-4 p-lg-6 text-black">
										<div class="d-flex align-items-center mb-3 pb-1">
											<i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
											<span class="h3 fw-bold mb-">SISTEMA DE CONTROL</span>
										</div>

										<h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">ACCESO AL SISTEMA</h5>
									<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<div class="form-outline mb-4">
											<input type="text" id="TUsuaUsuar" name="TUsuaUsuar"" class="form-control form-control-lg" placeholder="Enter Usuario" />
											<label class="form-label" for="TUsuaUsuar">Usuario</label>
										</div>

										<div class="form-outline mb-4">
											<input type="password" id="TUsuaClave" name="TUsuaClave" class="form-control form-control-lg" placeholder="Enter Clave" />
											<label class="form-label" for="TUsuaClave">Password</label>
										</div>

										<div class="pt-1 mb-4">
											<button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
										</div>

																				
										</form>

									</div>
									</div>
								</div>
								</div>
							</div>
							</div>
						</div>
					</section>
				</main>
			</div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; JAC SISTEMA 2023 Version 1.00</div>
                            <div>
                                <a href="#">Politica de privacidad</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
        <script src="js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
	</body>
</html>
