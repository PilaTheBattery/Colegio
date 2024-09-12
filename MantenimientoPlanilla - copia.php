<?php 
  ob_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="APLICACION WEB" />
        <meta name="author" content="JACSISTEMA" />
        <title>Colegio Control de Mantenimiento </title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
                <script src="js/all.min.js" crossorigin="anonymous"></script>
                <script src="js/jquery-3.6.0.min.js" type="text/javascript"></script>  
    </head>
    <body class="sb-nav-fixed">
    <div id="layoutSidenav_content">
<?php     
    session_start();
     
	
	$SUsuaId = $_SESSION['SUsuaId'];
    $SUsuaNomb = $_SESSION['SUsuaNomb'];
	$SUsuaNivel = $_SESSION['SUsuaNivel'];
	$SInstId = $_SESSION['SInstId'];
    $SAreaId = $_SESSION['SAreaId'];
    $STexto = $_SESSION['STexto'];
	$SFondo = $_SESSION['SFondo'];
    
    $idMantenimiento=$_GET['Id'];
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/Directorios.php');
    include_once (CSQL_DIR."InstitucionRegBd.php");
    include_once (CSQL_DIR."AreasRegBd.php");
    include_once (CSQL_DIR."MantenimientosRegBd.php");
    include_once (CSQL_DIR."TecnicosRegBd.php");
    
    $VInstEstatus=0;
    $Tabla_Institucion = new RInstitucion();    
    if($SUsuaNivel==0) {$InstRegis = $Tabla_Institucion->Obtener_Institucion_Todos($VInstEstatus); }   //Leer todas las cedes    
    else { $InstRegis = $Tabla_Institucion->Obtener_Institucion_Id($SInstId,$VInstEstatus);}   //Leer la cede del usuario    
        
    $Tabla_Mantenimiento_id = new RMantenimientos();
    $RMantenimientoRegistrado = $Tabla_Mantenimiento_id->Obtener_Mantenimiento_Id($idMantenimiento); //Leer todos los Mantenimientos    
?>
<main>
<?php foreach ($RMantenimientoRegistrado as $Mantenimiento) { ?>    
    <div class="container-fluid">
    
        <div class="card mb-4" charset="utf8_unicode_ci">            
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                        <table   width="100%">       
                                <tr> 
                                    <td style="text-align: center;"><img src="http://localhost/Mantenimiento/imagen/logo1.jpg" data-toggle="tooltip" data-placement="right" width="100" height="100"> </td>
                                    <td >
                                        <p style="text-align: center;"> REPÚBLICA BOLIVARIANA DE VENEZUELA  </p>
                                        <p style="text-align: center;"> <?php echo $Mantenimiento-> InstNomb;?> </p>
                                        <p style="text-align: center;">  PLANILLA DE MANTENIMIENTO </p>
                                    </td>
                                    <td style="text-align: center;"><p><img src="http://localhost/Mantenimiento/imagen/logo2.jpg" data-toggle="tooltip" data-placement="right" width="100" height="100"></p> 
                                </tr>                            
                        </table>
                        </div>
                    </div>
                               
                    <div class="form-group row">
                        <div class="col-md-6">
                        <table   width="100%"  style="padding-left: 10px;">       
                            <tr> 
                                <td width="50%" style="padding-left: 10px;"> No de Solicitud i/o Servicio:  <?php echo $Mantenimiento-> MantId; ?> </td> 
                                <td width="50%" >Estatus Actual:
                                    <?php  if($Mantenimiento-> MantEstatus=="0") { ?> <label class="btn btn-outline-secondary" > Creada</label> <?php  } ?>
                                    <?php  if($Mantenimiento-> MantEstatus=="1") { ?> <label class="btn btn-outline-secondary" > Procesando</label> <?php  } ?>
                                    <?php  if($Mantenimiento-> MantEstatus=="2") { ?> <label class="btn btn-outline-secondary" > Culminada</label> <?php  } ?>
                                </td>
                            </tr>                             
                        </table>
                                                        
                        </div>
                        <div class="col-md-3">                            
                            
                        </div> 
                    </div>
                    <br>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <table   width="100%" border="1" >       
                            <thead >                      
                                <tr> <th colspan="2" style="text-align: center;">Datos Generales</th> </tr> 
                            </thead>
                            <tbody  >                                
                                <tr> <td width="20%" style="padding-left: 10px;"> Area de Trabajo</td> <td style="padding-left: 10px;"> <label ><?php echo $Mantenimiento-> AreaNomb; ?> </label></td></tr> 
                                <tr> <td width="20%" style="padding-left: 10px;"> Equipo</td> <td style="padding-left: 10px;"> <label ><?php echo $Mantenimiento-> EquiCodi."->".$Mantenimiento-> EquiDesc; ?> </label></td> </tr> 
                                <tr> <td width="20%" style="padding-left: 10px;"> Marca / Modelo</td> <td style="padding-left: 10px;"> <label ><?php echo $Mantenimiento-> EquiMarc." / ".$Mantenimiento-> EquiMode; ?> </label></td> </tr>  
                            </tbody>                           
                        </table>
                        </div>
                    </div>
                    <br>                    
                    <div class="form-group row">
                        <div class="col-md-12">
                        <table   width="100%" border="1">       
                            <thead >                      
                                <tr> <th colspan="4" style="text-align: center">Datos de Solicitud</th> </tr> 
                            </thead>
                            <tbody  >
                                <tr> <td width="20%" style="padding-left: 10px;"> <b>Datos del Solicitante:</b></td> <td style="padding-left: 10px;"> 
                                        <label ><?php echo $Mantenimiento-> MantNombSoli; ?> </label></td> 
                                     <td width="15%" style="padding-left: 10px;"> <b>Fecha Solicitud:</b></td> <td style="padding-left: 10px;" width="15%"> 
                                        <label ><?php $date = new DateTime($Mantenimiento-> MantFechSoli); echo $date->format('Y-m-d'); ?> </label></td>                                     
                                </tr>                                 
                            </tbody>                           
                        </table>
                        </div>
                    </div>  
                    <br>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <table   width="100%" border="1">       
                            <thead >                      
                                <tr> <th style="text-align: center">Descripción del Diagnostico</th> </tr> 
                            </thead>
                            <tr> 
                                <td style="padding-left: 10px; padding-right: 10px;">
                                    <p> <b>Tipo de Servicio  :  </b>
                                        
                                            <input class="form-check-input" type="checkbox" id="T1" value="option1" <?php if ($Mantenimiento-> MantTipoServ=="Preventivo") { ?> checked <?php } ?> >
                                            <label class="form-check-label" for="T1">Preventivo  </label>
                                        
                                            <input class="form-check-input" type="checkbox" id="T2" value="option2"<?php if ($Mantenimiento-> MantTipoServ=="Correctivo") { ?> checked <?php } ?> >
                                            <label class="form-check-label" for="T2">Correctivo  </label>
                                        
                                            <input class="form-check-input" type="checkbox" id="T3" value="option3"<?php if ($Mantenimiento-> MantTipoServ=="Instalación") { ?> checked <?php } ?> >
                                            <label class="form-check-label" for="T3">Instalación  </label>
                                        
                                    </p>
                                    <p>
                                        <div class="form-row">         
                                        <table border="1" width="100%"> 
                                            <tr> 
                                                <td><b>Fallas Reportadas por el Solicitante: </b><u> <?php echo $Mantenimiento-> MantFallRepo; ?> </u> </td> 
                                            </tr> 
                                            <tr> 
                                                <td><b>Fallas Encontradas por el Técnico:    </b><u> <?php echo $Mantenimiento-> MantFallEnco; ?> </u></td> 
                                            </tr> 
                                        </table>
                                        </div>                                               
                                    </p>
                                </td> 
                            </tr>                             
                        </table>
                        </div>
                    </div> 
                    <br>
                    <div class="form-group row">
                        <div class="col-md-12">
                        <table   width="100%" border="1">       
                            <thead >                      
                                <tr> <th style="text-align: center">Descripción Trabajo Realizado</th> </tr> 
                            </thead>
                            <tr> 
                                <td style="padding-left: 10px; padding-right: 10px;">
                                    <p>Estado del Equipo : 
                                        
                                            <input class="form-check-input" type="checkbox" id="E1" value="option1" <?php if ($Mantenimiento-> MantEquiEsta=="Funcional") { ?> checked <?php } ?> >
                                            <label class="form-check-label" for="E1">Funcional</label>
                                        
                                            <input class="form-check-input" type="checkbox" id="E2" value="option2"<?php if ($Mantenimiento-> MantEquiEsta=="Inoperativo") { ?> checked <?php } ?> >
                                            <label class="form-check-label" for="E2">Inoperativo</label>
                                        
                                            <input class="form-check-input" type="checkbox" id="E3" value="option3"<?php if ($Mantenimiento-> MantEquiEsta=="En Mantenimiento") { ?> checked <?php } ?> >
                                            <label class="form-check-label" for="E3">En Mantenimiento</label>
                                        
                                            <input class="form-check-input" type="checkbox" id="E4" value="option4"<?php if ($Mantenimiento-> MantEquiEsta=="Fuera de servicio") { ?> checked <?php } ?> >
                                            <label class="form-check-label" for="E4">Fuera de servicio</label>                                        
                                    </p>
                                        <div class="form-row">                                          
                                        <table border="1" width="100%"> 
                                            <tr> 
                                                <td><b>Actividad Realizada:</b><u> <?php echo $Mantenimiento-> MantActiReal; ?></u></td> 
                                            </tr> 
                                            <tr> 
                                                <td><b>Repuestos Utilizados:</b><u><?php echo $Mantenimiento-> MantRespUsad; ?> </u></td> 
                                            </tr> 
                                        </table>
    
                                        
                                    <div class="form-row"> 
                                        <table border="1" width="100%"> 
                                            <tr> 
                                                <td><b>Observaciones:</b><u> <?php echo $Mantenimiento-> MantObse; ?></u></td> 
                                            </tr> 
                                            
                                        </table>
                                        
                                    </div>                                
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <p>Técnicos de Soporte: <u> CI. <?php echo $Mantenimiento->TecnCedu.' -> '.$Mantenimiento->TecnApelNomb; ?>  </u></p>                            
                                        </div>  
                                    </div>                                                                    
                                </td> 
                            </tr>

                        </table>
                        </div>
                    </div> 
                    
                    <div class="form-row">
                        <table border="0" width="100%"> 
                            <tr> 
                                <td><b>Fecha Solicitud:</b><u> <?php $dateS = new DateTime($Mantenimiento-> MantFechSoli); echo $dateS->format('Y-m-d'); ?></u></td> 
                                <td><b>Fecha Inicio Servicio:</b><u> <?php if (($Mantenimiento->MantEstatus=="1")||($Mantenimiento->MantEstatus=="2")) {                                
                                        $dateI = new DateTime($Mantenimiento-> MantFechInicServ); echo $dateI->format('Y-m-d'); }?></u></td> 
                                <td><b>Fecha Final Servicio:</b><u> <?php if (($Mantenimiento->MantEstatus=="2")) {                                
                                        $dateF = new DateTime($Mantenimiento-> MantFechFinServ); echo $dateF->format('Y-m-d'); }?></u></td> 
                            </tr> 
                        </table>
                    </div>
            </div>

    <?php } ?>
</main>
            
 			</div>
		</div>
         <script src="js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>        
        <script src="js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
		<script src="assets/demo/datatables-demo.js"></script>
	</body>
</html>

<?php 
    $html=ob_get_clean();    
  
    use Dompdf\Dompdf; //para incluir el namespace de la librería
    use Dompdf\Options;//para incluir las opciones de la librería
    //include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/libreria/dompdf7/vendor/autoload.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/libreria/dompdf/autoload.inc.php');
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->setIsRemoteEnabled(true);
    //$options->set('isRemoteEnabled', true);
    //$options->set('isHtml5ParserEnabled', true);

    $DomPdf = new Dompdf($options);   
    $DomPdf->loadHtml($html);   

    $DomPdf->setPaper('letter', 'portrait'); //tipo de hoja carta en vertical
    //$DomPdf->setPaper('A4','landscape'); HORIZONTAL
    //$DomPdf->setPaper('A4', 'portrait'); VERTICAL
    $DomPdf->render();// Renderizar el PDF
   $DomPdf->stream("ReporteSolicitud.pdf", ['Attachment' => false]);  //false se visualiza  true para descargar
   exit(0);
   //header("Content-type: application/pdf");
    //header("Content-Disposition: inline; filename=documento.pdf");
    echo $DomPdf->output();
?>