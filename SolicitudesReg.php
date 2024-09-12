<script src="js/JSMantenimientos.js"></script>
<?php 
    
    session_start();
     
    if(!isset($_SESSION['SUsuaId'])){
		header("Location: index.php");
	}
	
	$SUsuaId = $_SESSION['SUsuaId'];
    $SUsuaNombr = $_SESSION['SUsuaNombr'];
	$SUsuaNivel = $_SESSION['SUsuaNivel'];
	$SInstId = $_SESSION['SInstId'];
    $SAreaId = $_SESSION['SAreaId'];
    $STexto = $_SESSION['STexto'];
	$SFondo = $_SESSION['SFondo'];
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/Template/inicio.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/Directorios.php');
    include_once (CSQL_DIR."InstitucionRegBd.php");
    include_once (CSQL_DIR."AreasRegBd.php");
    include_once (CSQL_DIR."MantenimientosRegBd.php");
    
    $VInstEstatus=0;
    $Tabla_Institucion = new RInstitucion();    
    if($SUsuaNivel==0) {$InstRegis = $Tabla_Institucion->Obtener_Institucion_Todos($VInstEstatus); }   //Leer todas las cedes    
    else { $InstRegis = $Tabla_Institucion->Obtener_Institucion_Id($SInstId,$VInstEstatus);}   //Leer la cede del usuario    
    

    


    include_once (TEMPLATE_DIR."cabecera.php");
?>
<main>
    <div class="container-fluid">
        <div >
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="Principal.php">Sistema Control de Mantenimientos</a></li>
                <li class="breadcrumb-item"><a href="Solicitudes.php">Listado de Solicitudes</a></li>
                <li class="breadcrumb-item active">Registrar Nueva solicitud </li>
            </ol>
        </div>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-2"></i>Datos de la Solicitud</div>
            <div class="card-body">           
                <form id="FormMantenimiento" name="FormMantenimiento" enctype="multipart/form-data">

                    <table style="width:100%" >
                        <thead charset="utf8_unicode_ci">
                            <tr>
                                <th>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">                                            
                                            <label  class="small mb-1" for="TUsuaNivel">Institucion:</label>                                            
                                            <select class="custom-select" id="TInstId" name="TInstId"> // Instituciones                                                
                                                <option value="0"  selected="">Seleccione..</option>    
                                                <?php  foreach ($InstRegis as $LInstitucion) { ?>
                                                    <option value="<?php echo $LInstitucion-> InstId; ?>"  ><?php echo $LInstitucion-> InstNomb; ?> </option>
                                                <?php }?>                                                
                                            </select> 
                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="TAreaId">Areas de la Institución:</label>
                                            <select class="custom-select" id="TAreaId" name="TAreaId" disabled> 
                                                <option value="0"  selected="">Seleccione..</option>                                                        
                                            </select>   
                                        </div>
                                    </div>                                      
                                </div>   
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="form-group">                                            
                                            <label  class="small mb-1" for="TEquiId">Equipos:</label>                                            
                                            <select class="custom-select" id="TEquiId" name="TEquiId" disabled> // Equipos                                              
                                                <option value="0"  selected="">Seleccione..</option>                                                
                                            </select> 
                                        </div>
                                    </div>  
                                    <div class="col-md-2">                                        
                                        <div class="form-group">                                             
                                            <label  class="small mb-1" >Nuevo Estado:</label>                                                                                                                                    
                                            <select class="custom-select" id="TMantEquiEsta" name="TMantEquiEsta" disabled>
                                                <option value="0" >Seleccione...</option>
                                                <option value="Funcional" >Funcional</option>  
                                                <option value="Inoperativo" >Inoperativo</option>     
                                                
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-md-2">                                        
                                        <div class="form-group">                                             
                                            <label  class="small mb-1" >Estado Actual:</label>                                                                                                                                    
                                        <img src="imagen/Est.png" data-toggle="tooltip" data-placement="right" title="Estatus" id="TEquiEstaEqui" name="TEquiEstaEqui" width="90" height="50">
                                        </div>
                                    </div> 
                                </div>   
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  class="small mb-1" for="TMantNombSoli">Apellido y Nombre Solicitante:</label>                                       
                                            <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantNombSoli" name="TMantNombSoli" value="<?php echo $SUsuaNombr; ?>" required disabled> 
                                        </div>
                                    </div>    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  class="small mb-1" for="TMantFechSoli">Fecha de Solicitud:</label>
                                            <input type="date" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantFechSoli" name="TMantFechSoli" required disabled >                                        
                                        </div>    
                                    </div>    
								</div>
                                
                                <div class="form-row">                                        
                                    <div class="col-md-12">
                                        <label class="small mb-1" for="TMantFallRepo">Falla Presentada por el Equipo</label>                                        
                                        <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantFallRepo" name="TMantFallRepo" required disabled>                                        
                                    </div>                                         
                                </div>   
                                <div class="form-row">                             
                                    <div class="col-md-12">
                                        <label class="small mb-1" for="TTecnId">Técnicos de soporte </label>                                        
                                        <select class="custom-select" id="TTecnId" name="TTecnId" disabled> // Equipos                                              
                                                <option value="0"  selected="">Seleccione..</option>                                                
                                        </select> 
                                    </div>                                                                                                                              
                                </div>                                                                    
                                </th>                                
                            </tr>
                        </thead>        
                        
                    </table>
                    
                    
                    <div class="card-header" style="text-align: center;" >
                        <a href="#" onclick="NuevaSolicitud()" class="btn btn-primary"  >Guardar Solicitud</a>
                    </div>  
                    
                    <div class="input-group mb-3">                                            
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value="Nueva Solicitud"  disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantId" name="TMantId"  disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaId" name="TUsuaId" value=<?php echo $SUsuaId; ?> disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantFechInicServ" name="TMantFechInicServ" disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantTipoServ" name="TMantTipoServ" disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantFallEnco" name="TMantFallEnco" disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantActiReal" name="TMantActiReal" disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantRespUsad" name="TMantRespUsad" disabled>                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantFechFinServ" name="TMantFechFinServ" disabled>                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TMantObse" name="TMantObse" disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGr oup-sizing-default" id="TMantEstatus" name="TMantEstatus" value="0" disabled>
                    </div>
                </form>                
            </div>
        </div>
    </div>
</main>
<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>                