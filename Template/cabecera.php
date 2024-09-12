    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-<?php echo  $STexto; ?> bg-<?php echo  $SFondo; ?>">
            <a class="navbar-brand" href="index.php">Aplicacion Web</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button><!-- Navbar Search-->
			<?php   foreach ($InstRegis as $LInstitucion) 
                    { 
                        if($SInstId==$LInstitucion-> InstId)  
                        {?> 				
				    		<a class="navbar-brand" href="#">Sede: <?php echo  $LInstitucion-> InstNomb; ?></a>
			<?php 		}
					} ?>
			<!--<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
				<input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
				<div class="input-group-append">
				<button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
				</div>
                </div>
			</form>-->
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $SUsuaNomb; ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal">Configuracion</a>
						<a class="dropdown-item" href="UsuariosMod.php?Id=<?php echo  $SUsuaId; ?>">Usuario</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Salir</a>
					</div>
				</li>
			</ul>
		</nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
								<div class="sb-nav-link-icon">
									<i class="fas fa-tachometer-alt"></i>
								</div>
                                Ascceso
							</a>
							<div class="sb-sidenav-menu-heading">
								Interface
							</div>								
							<?php if(($SUsuaNivel == 0) ||  ($SUsuaNivel == 1)) { ?>	
																		
							<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
								<div class="sb-nav-link-icon">
									<i class="fas fa-warehouse"></i>
								</div>							
								Administrador
								<div class="sb-sidenav-collapse-arrow">
									<i class="fas fa-angle-down"></i>
								</div>
							</a>
							<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
								<nav class="sb-sidenav-menu-nested nav">
								
									<a class="nav-link" href="UsuariosList.php">Usuarios</a>

									
									<?php 	if(($SUsuaNivel == 0) || ($SUsuaNivel == 1))
											{ ?>
												<a class="nav-link" href="InstitucionList.php">Instituciones/Sedes</a>
									<?php 	} ?>
								</nav>
							</div>
							<?php } ?>
							
						

							<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRegistro" aria-expanded="false" aria-controls="collapseRegistro">
								<div class="sb-nav-link-icon">
									<i class="fas fa-columns"></i>
								</div>				
									Registro
								<div class="sb-sidenav-collapse-arrow">
									<i class="fas fa-angle-down"></i>
								</div>
							</a>
							<div class="collapse" id="collapseRegistro" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
								<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
									<a class="nav-link" href="EstudianteList.php">Estudiantes</a>
								</nav>
							</div>
							</a>
							
							<div class="collapse" id="collapseRegistro" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
								<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
									<a class="nav-link" href="PeriodoList.php">Periodos</a>
								</nav>
							</div>
							</a>
							<div class="collapse" id="collapseRegistro" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
								<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
									<a class="nav-link" href="GradosList.php">Grados</a>
								</nav>
							</div>
							</a>
							</a>
							<div class="collapse" id="collapseRegistro" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
								<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
									<a class="nav-link" href="SeccionList.php">Secciones</a>
								</nav>
							</div>
							</a>
							
							<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReporte" aria-expanded="false" aria-controls="collapseReporte">
								<div class="sb-nav-link-icon">
									<i class="fa fa-print"></i>
								</div>				
									Reportes
								<div class="sb-sidenav-collapse-arrow">
									<i class="fas fa-angle-down"></i>
								</div>
							</a>
							<div class="collapse" id="collapseReporte" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
								<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
									<a class="nav-link" href="EquiposHistMant.php">Hist. Mant. x Equipo</a>									
								</nav>
							</div>
							

							<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInfo" aria-expanded="false" aria-controls="collapseInfo">
								<div class="sb-nav-link-icon">
									<i class="fas fa-circle-info"></i>
								</div>				
									Información
								<div class="sb-sidenav-collapse-arrow">
									<i class="fas fa-angle-down"></i>
								</div>
							</a>
							<div class="collapse" id="collapseInfo" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
								<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
									<a class="nav-link" href="#" id="TAcerca" name="TAcerca">Acerca de...</a>
									<a class="nav-link" href="Manual.pdf" target="_blank">Manual</a>
								</nav>
							</div>									
								
						</div>
						</div>										
							
				</nav>
				

			</div>
            <div id="layoutSidenav_content">
            
