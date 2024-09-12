<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	session_start();
	
	if($_POST){
			
		include_once($_SERVER['DOCUMENT_ROOT'].'Colegio/Directorios.php');
    	//include_once (CSQL_DIR."DatosUsuarios.php");

		$usuario1 = $_POST['TUsuaUsuar'];
		$clave1 = $_POST['TUsuaClave'];

		//$pass_c = sha1($clave1);
		$Repues = new DatosUsuarios();
		$usuar=$Repues->Obtener_Usuario($usuario1,$clave1);	

		if( $usuar){
			if($clave_bd == $pass_c){
				
				$_SESSION['SUsuaId'] = $usuar->UsuaId;
				$_SESSION['SUsuaNomb'] = $usuar->UsuaNomb;
				$_SESSION['SUsuaNivel'] = $usuar->UsuaNivel;
				$_SESSION['SInstId'] = $usuar->InstId;
				$_SESSION['STexto'] = "dark";
				$_SESSION['SFondo'] = "dark";
				
				
				header("Location: principal.php");
				
			} else {
			
			echo "La contraseña no coincide";
			
			}
			
			
			} else {
			echo "NO existe usuario";
		}
		
		
		
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
        <title>Page Title - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
	</head>
    <body class="bg-primary" >
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
					
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
							
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
									<img src="Imagen/cabecera.png" alt="" height="55"  align="center"/>
                                    <div class="card-header"><h3 class="text-center font-weight-light my-1">ACCESO AL SISTEMA</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="form-group"><label class="small mb-1" for="TUsuaUsuar">Usuario</label><input class="form-control py-4" id="TUsuaUsuar" name="TUsuaUsuar" type="text" placeholder="Enter Usuario" /></div>
                                            <div class="form-group"><label class="small mb-1" for="TUsuaClave">Password</label><input class="form-control py-4" id="TUsuaClave" name="TUsuaClave" type="password" placeholder="Enter clave" /></div>
                                            <div class="form-group">
                                                
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><button type="submit" class="btn btn-primary">Login</button></div>
										</form>
									</div>
                                    <div class="card-footer text-center">
                                       
									</div>
								</div>
							</div>
						</div>
					</div>
				</main>
			</div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; JACSISTEMA 2021</div>
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
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
	</body>
</html>
