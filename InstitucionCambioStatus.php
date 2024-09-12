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
      
    $VStatus=0;
    $VInstEstatus=2; //estatus todos
    $Tabla_Institucion = new RegDatos();
    $InstRegis = $Tabla_Institucion->Institucion_Obtener_Todos($VInstEstatus);
    $RInstitucionRegistrada = $Tabla_Institucion->Institucion_Obtener_InstId($IdInstitucion); //Leer todos los Institucions
    
    include_once (TEMPLATE_DIR."cabecera.php");
    $Cantidad=0;
?>
<main>
    <div class="container-fluid">
        <div >
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="Principal.php">Sistema Control de Mantenimientos</a></li>
                <li class="breadcrumb-item"><a href="InstitucionList.php">Listado de Instituciones</a></li>
                <li class="breadcrumb-item active">Institución Cambio de Estatus</li>
            </ol>
        </div>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-2"></i>Estatus de la Institución</div>
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
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstNomb" name="TInstNomb" value="<?php echo $Institucion-> InstNomb; ?>" disabled>
                                                
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstDesc">Descripción de la Institución:</label>
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstDesc" name="TInstDesc" value="<?php echo $Institucion-> InstDesc; ?>" disabled >
                                            </div>    
                                        </div>    
									</div>
                                    </div>    
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="TEstaId">Estados:</label>
                                                        
                                                        <select class="custom-select" id="TEstaId" name="TEstaId" disabled> 
                                                            <option value="<?php echo $Institucion-> EstaId; ?>"  selected="" ><?php echo $Institucion-> EstaNomb; ?> </option>
                                                        </select>   
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="TMuniId">Municipios:</label>
                                                        <select class="custom-select" id="TMuniId" name="TMuniId" disabled> 
                                                            <option value="<?php echo $Institucion-> MuniId; ?>"   selected=""><?php echo $Institucion-> MuniNomb; ?> </option>                                                   
                                                        </select>   
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="TParrId">Paroquias:</label>
                                                        <select class="custom-select" id="TParrId" name="TParrId" disabled>                                                         
                                                            <option value="<?php echo $Institucion-> ParrId; ?>"   selected=""><?php echo $Institucion-> ParrNomb; ?> </option>
                                                        </select>   
                                                    </div>
                                                </div>                                                                                        
                                            </div>  
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstDire">Dirección de la Institución:</label>                                                                                       
                                                <textarea class="form-control"  rows="2"  id="TInstDire" name="TInstDire"  disabled > <?php echo $Institucion-> InstDire; ?> </textarea>
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstCont">Contacto de la Institución:</label>
                                                <textarea class="form-control"  rows="2"  id="TInstCont" name="TInstCont" disabled > <?php echo $Institucion-> InstCont; ?> </textarea>                                                
                                            </div>    
                                        </div>    
									</div>
                                   

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstEstatus1">Status Actual:</label>                                                                                       
                                                <select class="custom-select" id="TInstEstatus1" name="TInstEstatus1" disabled>                                                         
                                                    <?php if( $Institucion-> InstEstatus=="0") {?>
                                                            <option value="0"   selected=""> Activa</option>
                                                    <?php }?>
                                                    <?php if( $Institucion-> InstEstatus=="1") {?>
                                                            <option value="1"   selected=""> Inactiva</option>
                                                    <?php }?>
                                                </select>                                                   
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TInstEstatus">Nuevo Status:</label>
                                                <select class="custom-select" id="TInstEstatus" name="TInstEstatus" disabled>                                                         
                                                    <?php if( $Institucion-> InstEstatus=="1") {?>
                                                            <option value="0"   selected=""> Activa</option>
                                                    <?php }?>
                                                    <?php if( $Institucion-> InstEstatus=="0") {?>
                                                            <option value="1"   selected=""> Inactiva</option>
                                                    <?php }?>
                                                </select>     
                                            </div>    
                                        </div>    
									</div>
                                    </div>    
                                </th>                                
                            </tr>
                        </thead>        
                        
                    </table>
                    
                    
                    <div class="card-header" style="text-align: center;" >
                        <?php if(( $Institucion-> InstEstatus=="0")&&( $Cantidad==0)) {?>
                            <a href="#" onclick="CambioEstatusInstitucion()" class="btn btn-danger"  >Deshabilitar la Institución</a>
                        <?php }?>
                        <?php if( $Institucion-> InstEstatus=="1") {?>
                            <a href="#" onclick="CambioEstatusInstitucion()" class="btn btn-success"  >Habilitar la Institución</a>
                        <?php }?>
                        <?php if(( $Institucion-> InstEstatus=="0")&&( $Cantidad>0)) {?>
                            <a href="#" onclick="" class="btn btn-secondary"  >Debe Deshabilitar primero todas las Areas de Trabajo</a>
                        <?php }?>
                        
                    </div>  
                    
                    <div class="input-group mb-3">                     
                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=" "  >
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value="<?php echo $Institucion-> InstId; ?>"  >
                        
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