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
        <title>WebApp Control de Notas </title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
                <script src="js/all.min.js" crossorigin="anonymous"></script>
                <script src="js/jquery-3.6.0.min.js" type="text/javascript"></script>  
    </head>
    <body class="sb-nav-fixed">
        <div id="layoutSidenav_content">
            <?php    
                session_start();

            include_once ($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/CSQL/ColegioBd.php');
           


            $DatosR=json_decode($_POST['Parameters_Report'], false); //descodifica los datos pos en formato Json		
                
            $VInstId=(isset($DatosR->InstId))?$DatosR->InstId:0;
            $VAreaId=(isset($DatosR->AreaId))?$DatosR->AreaId:0;
            $VEquiId=(isset($DatosR->EquiId))?$DatosR->EquiId:0;
            $VTecnId=(isset($DatosR->TecnId))?$DatosR->TecnId:0;
            $VMantId=(isset($DatosR->MantId))?$DatosR->MantId:0;
            $VMantEstatus=(isset($DatosR->MantEstatus))?$DatosR->MantEstatus:0;
            $VGrupo=(isset($DatosR->Grupo))?$DatosR->Grupo:"";

            $VInstEstatus=0;
            $Tabla_Institucion = new RInstitucion();        
            $InstRegis = $Tabla_Institucion->Obtener_Institucion_Id($VInstId,$VInstEstatus);   //Leer la cede del usuario     
            
            $Tabla_CMantenimientos = new RMantenimientos();
            $ManteRegis = $Tabla_CMantenimientos->Obtener_Mantenimientos_Parametros($VInstId,$VAreaId,$VEquiId,$VTecnId,$VMantId,$VMantEstatus);
            $CantMant = $Tabla_CMantenimientos->Mant_Cant_Parametros($VInstId,$VAreaId,$VEquiId,$VTecnId,$VMantId,$VMantEstatus,$VGrupo);
            ?>
            <main>
                <div class="container-fluid">        
                    <div class="card-body">
                        <?php 
                            $DatosE= array();  
                            $Cont=0;
                            foreach ($CantMant as $LCant) 
                            {                           
                                $DatosE[$Cont]  = $LCant-> CMant ;
                                $Cont=$Cont+1;
                            }
                                
                            $RInstId=0;$CInstId=0;
                            $RAreaId=0;$CAreaId=0;
                            $REquiId=""; $VCEquiId=1;
                            $Cont=0;                            
                            foreach ($ManteRegis as $LMantenimiento) 
                            {                                    
                            $VMantEstatus=4; $Contador=0;                     
                                if ($RInstId==0) {
                        ?>
                          
                        <div class="form-group row">
                                <div class="col-md-12">
                                    <table   width="100%">       
                                        <tr> 
                                            <td style="text-align: center;"><img src="http://localhost/Mantenimiento/imagen/logo1.jpg" data-toggle="tooltip" data-placement="right" width="100" height="100"> </td>
                                            <td >
                                            <p style="text-align: center;"> REPÚBLICA BOLIVARIANA DE VENEZUELA  </p>
                                            <p style="text-align: center;"> <?php echo $LMantenimiento-> InstNomb;?> </p>
                                            <p style="text-align: center;">  REPORTE HISTORICO DE MANTENIMIENTO </p>
                                            </td>
                                            <td style="text-align: center;"><p><img src="http://localhost/Mantenimiento/imagen/logo2.jpg" data-toggle="tooltip" data-placement="right" width="100" height="100"></p> 
                                        </tr>                            
                                    </table>
                                </div>
                            </div>
                        <div  id="ReporteMant">
                        <?php }$RInstId=$RInstId+1?>
                            <font size=1>
                                
                                
                                    <?php 
                                    if (!($RAreaId==$LMantenimiento-> AreaId)) 
                                    { ?> 
                                            <br> 
                                        <table width="100%" border="1"> 
                                            <tr bgcolor="#ADD8E6"> 
                                                <td><b>Cede:</b></td> <td> <?php echo $LMantenimiento-> InstNomb; ?></td> 
                                                <td><b>Area de Trabajo:</b></td> <td>  <?php echo $LMantenimiento-> AreaNomb; ?> </td> 
                                            </tr> 
                                        </table>
                                        <?php $RAreaId=$LMantenimiento-> AreaId; $CInstId=$CInstId+1;?> 
                                        <?php 
                                    } ?> <?php 
                                    
                                    if (!($REquiId==$LMantenimiento-> EquiId)&&($VCEquiId==1)) 
                                    { ?>
                                        
                                        <table width="100%" border="1">
                                            <tr bgcolor="#F0F8FF">                                                
                                                <td colspan=3><b>Equipo Codigo: </b><?php echo $LMantenimiento->EquiCodi ?>  </td>
                                                <td colspan=4><b>Descripción: </b><?php echo $LMantenimiento->EquiDesc ?> </td>
                                            </tr>
                                            <tr bgcolor="#D3D3D3">
                                                <td width="15"># </td>
                                                <td width="48">Solicitud</td>
                                                <td width="58">Operarios</td>
                                                <td width="58">Fechas:</td>
                                                <td width="110">Diagnosticos y Servicio</td>
                                                <td width="110">Proceso</td>
                                                <td width="110">Información</td>                                                
                                            </tr>                                              
                                        <?php 
                                    $REquiId=$LMantenimiento-> EquiId; 
                                    }?>
                                    <tr>
                                               
                                        <td><?php echo $VCEquiId; ?></td>
                                                <td><p align="center"> <b># <?php echo " ".$LMantenimiento-> MantId; ?></b><br>                                                
                                                        <?php                                         
                                                switch ($LMantenimiento-> MantEstatus) {
                                                    case '0':   echo "Creada";  break;
                                                    case '1': echo "Procesando"; break;
                                                    case '2': echo "Culminada"; break;
                                                    case '3': echo "Deshabilitada"; break;
                                                    default: break;
                                                }
                                                
                                                
                                                ?></p>
                                                </td>
                                                <td><p> <b>Solicitante:</b> <?php echo " ".$LMantenimiento-> MantNombSoli; ?><br><br>
                                                        <b>Técnico: </b><?php echo " ".$LMantenimiento-> TecnApelNomb; ?></p>
                                                </td>
                                                <td><p> <b>Sol:</b><?php echo " ".$LMantenimiento-> MantFechSoli; ?><br>
                                                        <b>Ini:</b><?php echo " ".$LMantenimiento-> MantFechInicServ; ?><br>
                                                        <b>Fin:</b><?php echo " ".$LMantenimiento-> MantFechFinServ; ?></p>
                                                </td>                                        
                                                <td><p> <b>Reportada:</b><?php echo " ".$LMantenimiento-> MantFallRepo; ?><br>
                                                        <b>Encontrada:</b><?php echo " ".$LMantenimiento-> MantFallEnco; ?><br>
                                                        <b>Servicio:</b><?php echo " ".$LMantenimiento-> MantActiReal; ?></p>
                                                </td>
                                                <td><p> <b>Tipo Serv:</b><?php echo " ".$LMantenimiento-> MantTipoServ; ?><br>                                                
                                                        <b>Est. Equipo:</b><?php echo " ".$LMantenimiento-> MantEquiEsta; ?></p>
                                                </td>        
                                                <td><p> <b>Repuestos Usados:</b><?php echo " ".$LMantenimiento-> MantRespUsad; ?><br>                                                
                                                        <b>Observaciones:</b><?php echo " ".$LMantenimiento-> MantObse; ?></p>
                                                </td>        
                                                
                                    </tr>  

                                    <?php
                                
                                                            
                                    if ($DatosE[$Cont]==$VCEquiId) {                                ;
                                        $VCEquiId=0; $Cont=$Cont+1;?>
                                        
                                        </table> 
                                    <?php }$VCEquiId=$VCEquiId+1;                            ?>
                                    
                                    
                                
                                <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TId" name="TId" value="0"  disabled>
                                <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value="Table"  disabled>
                                        
                            </font>
                            <?php } ?>  
                        </div>
                    </div>
                </div>                                 
            </main>
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
    $html=ob_get_clean(); 
    $DomPdf->loadHtml($html);   
    
    $DomPdf->setPaper('letter', $orientation = 'portrait'); //tipo de hoja carta en vertical
    //$DomPdf->setPaper('A4','landscape'); HORIZONTAL
    //$DomPdf->setPaper('A4', 'portrait'); VERTICAL
    $DomPdf->render();// Renderizar el PDF
    //$DomPdf->stream("ReporteTecnico.pdf", ['Attachment' => false]);  //false se visualiza  true para descargar
    //exit(0);
  
   // header("Content-type: application/pdf");
    //header("Content-Disposition: inline; filename=documento.pdf");
    
//Asigmanos el nombre al archivo desde vista navegador usando la funcion TIME()
    //  echo $DomPdf->output();    
    $output = $DomPdf->output();
    //$DomPdf->stream("Soporte.pdf");
    file_put_contents("Historico/Equipo.pdf", $output);
    $DomPdf->output();
    $Archivo="Historico/Equipo.pdf";
    return $Archivo;
?>
