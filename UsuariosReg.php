<script src="js/JSUsuarios.js"></script>
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
    
    $Tabla_Niveles = new RegDatos();
    $TodosNiveles = $Tabla_Niveles->Niveles_Obtener_Todos(); //Leer todos los Usuarios

    $VInstEstatus=0;
    $Tabla_Institucion = new RegDatos();    
    if($SUsuaNivel==0) {$InstRegis = $Tabla_Institucion->Institucion_Obtener_Todos($VInstEstatus); }   //Leer todas las cedes    
    else { $InstRegis = $Tabla_Institucion->Institucion_Obtener_InstId($SInstId,$VInstEstatus);}   //Leer la cede del usuario    

       
    include_once (TEMPLATE_DIR."cabecera.php");
    
?>
<main>
    <div class="container-fluid">
        <div >
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="Principal.php">Sistema Control WebApp</a></li>
                <li class="breadcrumb-item"><a href="UsuariosList.php">Listado de Usuarios</a></li>
                <li class="breadcrumb-item active">Nuevo Usuario </li>
            </ol>
        </div>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-2"></i>Registro de Usuario</div>
            <div class="card-body">
                <form id="FormUsuario" name="FormUsuario" enctype="multipart/form-data">

                    <table style="width:100%" >
                        <thead charset="utf8_unicode_ci">
                            <tr>
                                <th>
                                <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">                                            
                                                <label  class="small mb-1" for="TInstId">Instituciones:</label>                                            
                                                <select class="custom-select" id="TInstId" name="TInstId" > // Instituciones                                                    
                                                    <?php if($SUsuaNivel==0) { ?>
                                                    <option value="0"  selected="">Seleccione..</option>    
                                                    <?php  foreach ($InstRegis as $LInstitucion) { ?>
                                                                 <option value="<?php echo $LInstitucion-> InstId; ?>"  ><?php echo $LInstitucion-> InstNomb; ?> </option>
                                                    <?php } }?>
                                                    <?php if($SUsuaNivel==1) { 
                                                          foreach ($InstRegis as $LInstitucion) { ?>
                                                                 <option value="<?php echo $LInstitucion-> InstId; ?>" selected="" ><?php echo $LInstitucion-> InstNomb; ?> </option>
                                                    <?php } }?>
                                                </select>   
                                            </div>
                                        </div>                                        
                                        
                                    </div>   

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TUsuaUser">Usuario:</label>                                       
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaUser" name="TUsuaUser" required disabled>
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TUsuaNomb">Nombre del Usuario:</label>
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaNomb" name="TUsuaNomb" required disabled>                                        
                                            </div>    
                                        </div>    
									</div>
                                    </div>    
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="small mb-1" for="TUsuaClave1">Password:</label>
                                                <input class="form-control py-2" id="TUsuaClave1" name="TUsuaClave1" type="password" placeholder="Enter password" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputConfirmPassword">Confirmar Password:</label>
                                                <input class="form-control py-2" id="TUsuaClave2" name="TUsuaClave2" type="password" placeholder="Confirmar Password" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="small mb-1" for="TChequeo">Actualizar la Clave:</label>
                                                <input cclass="form-check-input"  id="TChequeo" name="TChequeo" type="checkbox" placeholder="Enter password"  checked disabled/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="small mb-1" id="TMensaje">* </label>                                                
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">                                            
                                                <label  class="small mb-1" for="TUsuaNivel">Nivel de Seguridad:</label>                                            
                                                <select class="custom-select" id="TUsuaNivel" name="TUsuaNivel" disabled> 
                                                    <option value="X"  selected="">Seleccione..</option>
                                                    <?php foreach ($TodosNiveles as $LNiveles) {
                                                        if($LNiveles-> UsuaNivel>=$SUsuaNivel) { //permite visualizar niveles iguales o inferior a el que tiene
                                                        ?>
                                                        <option value="<?php echo $LNiveles-> UsuaNivel; ?>"  ><?php echo $LNiveles-> NivelNomb; ?> </option>
                                                    <?php }} ?>
                                                </select>   
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="TUsuaEstatus">Status:</label>                                        
                                            <select class="custom-select" id="TUsuaEstatus" name="TUsuaEstatus" disabled>
                                                <option value="0"  selected="">Activo</option>
                                                <option value="1">Inactivo</option>
                                            </select>
                                        </div>                                         
                                    </div>   
                                    <div class="form-row">
                                                                                                                   
                                    </div>                                                                    
                                </th>                                
                            </tr>
                        </thead>        
                        
                    </table>
                    
                    
                    <div class="card-header" style="text-align: center;" >
                        <a href="#" onclick="NuevoUsuario()" class="btn btn-primary"  >Guardar Nuevo Registro</a>
                    </div>  
                    
                    <div class="input-group mb-3">                     
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaClave" name="TUsuaClave" value=" "  disabled>                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value="Nuevo"  disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaId" name="TUsuaId" value=0  disabled>
                        
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