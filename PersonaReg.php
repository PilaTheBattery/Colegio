<script src="js/JSInstitucion.js"></script>
<?php 


    session_start();
     
    if(!isset($_SESSION['SUsuaId'])){
		header("Location: index.php");
	}
	
    $SUsuaId = $_SESSION['SUsuaId'];
    $SUsuaNomb = $_SESSION['SUsuaNomb'];
	$SUsuaNivel = $_SESSION['SUsuaNivel'];
	$SInstId = $_SESSION['SInstId'];
    $STexto = $_SESSION['STexto'];
	$SFondo = $_SESSION['SFondo'];
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Template/inicio.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	
    include_once (CSQL_DIR."ColegioBd.php");

      
      
    $VInstEstatus=0;
    $Tabla_Institucion = new RegDatos();    
    if($SUsuaNivel==0) {$InstRegis = $Tabla_Institucion->Institucion_Obtener_Todos($VInstEstatus); }   //Leer todas las cedes    
    else { $InstRegis = $Tabla_Institucion->Institucion_Obtener_InstId($SInstId);}   //Leer la cede del usuario    
  
    include_once (TEMPLATE_DIR."cabecera.php");
?>
<main>
    <div class="container-fluid">
        <div >
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="Principal.php">Sistema Control Colegio</a></li>
                <li class="breadcrumb-item"><a href="PersonasList.php">Listado de Personas</a></li>
                <li class="breadcrumb-item active">Nueva Persona </li>
            </ol>
        </div>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-2"></i>Registro de la Persona</div>
            <div class="card-body">
                <form id="FormPersona" name="FormPersona" enctype="multipart/form-data">

                    <table style="width:100%" >
                        <thead charset="utf8_unicode_ci">
                            <tr>
                                <th>
                                    <div class="form-row">
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="small mb-1" for="TInstId">Instituciob:</label>
                                                <select class="custom-select" id="TInstId" name="TInstId" > 
                                                    <option value="X"  selected="" disabled>Seleccione..</option>
                                                    <?php   foreach ($InstRegis as $LInst) 
                                                            {?>
                                                            <option value="<?php echo $LInst-> InstId; ?>"  <?php if($LInst-> InstId== $SInstId){echo 'selected="selected"';}  ?> ><?php echo $LInst-> InstNomb; ?> </option>
                                                    <?php   } ?>
                                                </select>   
                                            </div>
                                        </div>
									</div>
                                    </div>    
                                    <div class="form-row">
                                        <div class="col-md-7">
                                            <div class="input-group mb-3">
                                                <label class="small" >Cedula Identidad </label>
                                                <select class="custom-select" id="TPersNaci" name="TPersNaci" > 
                                                    <option value="V"  selected="">V</option>
                                                    <option value="E"  >E</option>
                                                </select>  
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TPersCedu" name="TPersCedu" value="" required > 
                                            </div>
                                        </div>
                                        
                                                                                
                                    </div>  
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <label  class="small mb-1" for="TInstDire">Dirección de la Institución:</label>                                                                                       
                                                <textarea class="form-control"  rows="2"  id="TInstDire" name="TInstDire" required ></textarea>
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstCont">Contacto de la Institución:</label>
                                                <textarea class="form-control"  rows="2"  id="TInstCont" name="TInstCont" required ></textarea>                                                
                                            </div>    
                                        </div>    
									</div>
                                    </div>    
                                </th>                                
                            </tr>
                        </thead>        
                        
                    </table>
                    
                    
                    <div class="card-header" style="text-align: center;" >
                        <a href="#" onclick="NuevoInstitucion()" class="btn btn-primary"  >Guardar Nuevo Registro</a>
                    </div>  
                    
                    <div class="input-group mb-3">                     
                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=" "  >
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value=0  >
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstEstatus" name="TInstEstatus" value=0  >
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>                