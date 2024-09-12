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

include_once ($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/CSQL/MantenimientosRegBd.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/CSQL/InstitucionRegBd.php');


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
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <font size=2>
                            <b><table   width="100%">       
                                <tr> 
                                    <td style="text-align: center;"><img src="http://localhost/Mantenimiento/imagen/logo1.jpg" data-toggle="tooltip" data-placement="right" width="100" height="100"> </td>
                                    <td >
                                        <p style="text-align: center;"> REPÚBLICA BOLIVARIANA DE VENEZUELA  </p>
                                        <?php foreach ($InstRegis as $LInstitucion) 
                                        { ?><?php 
                                            if($LInstitucion-> InstId==$VInstId)
                                            { ?>
                                                <p style="text-align: center;"> <?php echo $LInstitucion-> InstNomb;?> </p>
                                                <?php 
                                            }?>
                                            <?php 
                                        }?>
                                        <p style="text-align: center;">  REPORTE HISTORICO DE MANTENIMIENTO </p>
                                    </td>
                                    <td style="text-align: center;"><p><img src="http://localhost/Mantenimiento/imagen/logo2.jpg" data-toggle="tooltip" data-placement="right" width="100" height="100"></p> 
                                </tr>
                            </table></b>
                            </font>  
                        </div>
                    </div>
                    <div  id="ReporteMant">      
                        <font size=1>
                            <?php 
                            $DatosE= array();
                            $Cont=0;
                            foreach ($CantMant as $LCant) 
                            {
                                $DatosE[$Cont]  = $LCant-> CMant ;
                                $Cont=$Cont+1;
                            }
                            //print_r($DatosE);

                            $VCMant=1;
                            $RAreaId=0;$CAreaId=1;
                            $REquiId=""; $VCEquiId=1;
                            $RTecnId=""; $VCTecnId=1;
                            $Cont=0;
                            foreach ($ManteRegis as $LMantenimiento) 
                            {  

                                $VMantEstatus=4;                     
                                if (!($RTecnId==$LMantenimiento-> TecnId)) 
                                { ?>
                                <br>
                                    <div class="form-row">
                                        <div class="col-md-4"> 

                                        <b>Datos del Técnico: </b>
                                        </div>
                                        <div class="col-md-8"> 
                                            <table width="100%" border="1"> 
                                                <tr bgcolor="#ADD8E6"> 
                                                    <td width="40"><b>Cedula:</b></td> <td width="40"> <?php echo $LMantenimiento-> TecnCedu;  ?></td> 
                                                    <td width="80"><b>Apellidos y Nombres:</b></td> <td>  <?php echo $LMantenimiento-> TecnApelNomb; ?> </td> 
                                                </tr> 
                                            </table>
                                        </div>
                                    </div>  
                                    <br>  
                                    <?php $VCEquiId=1;$VCMant=1;$REquiId="";
                                }?>
                                    <?php 
                                if ($VCEquiId==1) 
                                { ?>
                                    <table width="100%" border="1"> <?php 
                                } ?><?php 

                                if (!($REquiId==$LMantenimiento-> EquiId)) 
                                { ?>
                                        <tr bgcolor="#F0F8FF">                                                
                                            <th colspan=3>Equipo Codigo: <?php echo $LMantenimiento->EquiCodi ?>  </th>
                                            <th colspan=4> Descripción: <?php echo $LMantenimiento->EquiDesc ?> </th>
                                        </tr>
                                        <?php $RAreaId=""; $VCEquiId=$VCEquiId+1;$VCAreaId=1;
                                } ?>
                                    <?php 
                                if (!($RAreaId==$LMantenimiento-> AreaId)) 
                                { ?> 
                                        <tr bgcolor="#ADD8E6"> 
                                            <td >..</td> 
                                            <td colspan=3><b>Area de Trabajo:</b></td> <td colspan=5>  <?php echo $LMantenimiento-> AreaNomb; ?> </td> 
                                        </tr> 
                                        <?php $CAreaId=$CAreaId+1;$CMantenimientos=1?> 
                                        <?php 
                                } 
                                if ($CMantenimientos==1) 
                                {?>
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
                                        //$CMantenimientos=1;
                                }?>
                                    <?php 
                                        
                                    ?>
                                        <tr>
                                                
                                            <td><?php echo $CMantenimientos; ?></td>
                                            <td><p align="center"> <b># <?php echo " ".$LMantenimiento-> MantId; ?></b><br>
                                                <?php
                                                switch ($LMantenimiento-> MantEstatus) 
                                                {
                                                    case '0':   echo "Creada";  break;
                                                    case '1': echo "Procesando"; break;
                                                    case '2': echo "Culminada"; break;
                                                    case '3': echo "Deshabilitada"; break;
                                                    default: break;
                                                } 
                                                ?></p>
                                            </td>
                                            <td>
                                                <p> <b>Solicitante:</b><br> <?php echo " ".$LMantenimiento-> MantNombSoli; ?><br></p>
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
                                
                                if ($DatosE[$Cont]==$VCMant) 
                                {
                                    $VCTecnId=""; $Cont=$Cont+1;?>
                                    </table> 

                                    <?php 
                                
                                }$VCMant=$VCMant+1;
                                
                                ?>
                                
                                <?php 
                                $CMantenimientos=$CMantenimientos+1;
                                $RTecnId=$LMantenimiento-> TecnId;

                                $REquiId=$LMantenimiento-> EquiId; 
                                $RAreaId=$LMantenimiento-> AreaId; 
                                
                                
                            } ?>  
                            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TId" name="TId" value="0"  disabled>
                            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value="Table"  disabled>
                        </font>                    
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
    file_put_contents("Historico/tecnico.pdf", $output);
    $DomPdf->output();
    $Archivo="Historico/tecnico.pdf";
    return $Archivo;
?>
