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
    
    $IdInstitucion=$_GET['Id'];

    include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Template/inicio.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');	
    include_once (CSQL_DIR."ColegioBd.php");

      
    $Tabla_Estados = new RegDatos();
    $EstadosRegistrados = $Tabla_Estados->Estados_Obtener();
    $VStatus=0;
    $VInstEstatus=2; //estatus todos
    $Tabla_Institucion = new RegDatos();
    $InstRegis = $Tabla_Institucion->Institucion_Obtener_Todos($VInstEstatus);
    $RInstitucionRegistrada = $Tabla_Institucion->Institucion_Obtener_InstId($IdInstitucion); //Leer todos los Institucions
    
    include_once (TEMPLATE_DIR."cabecera.php");
?>
<main>
    <div class="container-fluid">
        <div >
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="Principal.php">Sistema Control Colegio</a></li>
                <li class="breadcrumb-item"><a href="InstitucionList.php">Listado de Instituciones</a></li>
                <li class="breadcrumb-item active">Nueva Institución </li>
            </ol>
        </div>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-2"></i>Registro de la Institución</div>
            <div class="card-body">
            <?php foreach ($RInstitucionRegistrada as $Institucion) { ?>
                <form id="FormInstitucion" name="FormInstitucion" enctype="multipart/form-data">

                    <table style="width:100%" >
                        <thead charset="utf8_unicode_ci">
                            <tr>
                                <th>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstNomb">Nombre de la Institución:</label>                                                                                       
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstNomb" name="TInstNomb" value="<?php echo $Institucion-> InstNomb; ?>" required >
                                                
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstDesc">Descripción de la Institución:</label>
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstDesc" name="TInstDesc" value="<?php echo $Institucion-> InstDesc; ?>" required >
                                            </div>    
                                        </div>    
									</div>
                                    </div>    
                                    <?php                         
                                        
                                        $Tabla_Parroquia = new RegDatos();
                                        $LocalidadRegistrada = $Tabla_Parroquia->Localidad_Obtener_ParrId($Institucion-> ParrId); //Leer todos los estados
                                        
                                        foreach ($LocalidadRegistrada as $LParroquia) 
                                        { ?>
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="TEstaId">Estados:</label>
                                                        <select class="custom-select" id="TEstaId" name="TEstaId" > 
                                                            <option value="X"  selected="">Seleccione..</option>
                                                            <?php foreach ($EstadosRegistrados as $LEstados) 
                                                                { ?>
                                                                    <option value="<?php echo $LEstados-> EstaId; ?>"  <?php if($LEstados-> EstaId== $LParroquia-> EstaId){echo 'selected="selected"';}  ?> ><?php echo $LEstados-> EstaNomb; ?> </option>
                                                            <?php  } ?>
                                                                
                                                            <option value="<?php echo $LEstados-> EstaId; ?>"  ><?php echo $LEstados-> EstaNomb; ?> </option>
                                                            
                                                        </select>   
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="TMuniId">Municipios:</label>
                                                        <select class="custom-select" id="TMuniId" name="TMuniId" disabled> 
                                                            <option value="X"  selected="">Seleccione..</option> 
                                                            <option value="<?php echo $LParroquia-> MuniId; ?>"   selected=""><?php echo $LParroquia-> MuniNomb; ?> </option>                                                   
                                                        </select>   
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="TParrId">Paroquias:</label>
                                                        <select class="custom-select" id="TParrId" name="TParrId" disabled> 
                                                            <option value="X"  selected="">Seleccione..</option>                                                    
                                                            <option value="<?php echo $LParroquia-> ParrId; ?>"   selected=""><?php echo $LParroquia-> ParrNomb; ?> </option>
                                                        </select>   
                                                    </div>
                                                </div>                                                                                        
                                            </div>  
                                    <?php 
                                        } ?>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstDire">Dirección de la Institución:</label>                                                                                       
                                                <textarea class="form-control"  rows="2"  id="TInstDire" name="TInstDire"  required > <?php echo $Institucion-> InstDire; ?> </textarea>
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstCont">Contacto de la Institución:</label>
                                                <textarea class="form-control"  rows="2"  id="TInstCont" name="TInstCont" required > <?php echo $Institucion-> InstCont; ?> </textarea>                                                
                                            </div>    
                                        </div>    
									</div>
                                    </div>    
                                </th>                                
                            </tr>
                        </thead>        
                        
                    </table>
                    
                    
                    <div class="card-header" style="text-align: center;" >
                        <a href="#" onclick="ModificarInstitucion()" class="btn btn-primary"  >Guardar Registro Modificado</a>
                    </div>  
                    
                    <div class="input-group mb-3">                     
                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=" "  >
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value="<?php echo $Institucion-> InstId; ?>"  >
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstEstatus" name="TInstEstatus" value="<?php echo $Institucion-> InstEstatus; ?>"  >
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>                