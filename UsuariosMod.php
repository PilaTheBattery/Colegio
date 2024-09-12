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
    $idUsuario=$_GET['Id'];
    
    $Tabla_Niveles = new RegDatos();
    $TodosNiveles = $Tabla_Niveles->Niveles_Obtener_Todos(); //Leer todos los Usuarios
    
    $VInstEstatus=0;
    $Tabla_Institucion = new RegDatos();    
    if($SUsuaNivel==0) {$InstRegis = $Tabla_Institucion->Institucion_Obtener_Todos($VInstEstatus); }   //Leer todas las cedes    
    else { $InstRegis = $Tabla_Institucion->Institucion_Obtener_InstId($SInstId,$VInstEstatus);}   //Leer la cede del usuario    

     
    $Tabla_Usuarios_id = new RegDatos();
    $RUsuarioRegistrado = $Tabla_Usuarios_id->Usuario_Obtener_UsuaId($idUsuario); //Leer todos los Usuarios

   
    include_once (TEMPLATE_DIR."cabecera.php");
?>
<main>
    <div class="container-fluid">
        <div >
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="Principal.php">Sistema Control WebApp</a></li>
                <?php if(($SUsuaNivel<2))
                { ?>  
                    <li class="breadcrumb-item"><a href="UsuariosList.php">Listado de Usuarios</a></li>
                <?php }?>
                <li class="breadcrumb-item active">Modificar Datos del Usuario </li>
            </ol>
        </div>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-2"></i>Datos del Usuario</div>
            <div class="card-body">
            <?php foreach ($RUsuarioRegistrado as $Usuario) { ?>
                <form id="FormUsuario" name="FormUsuario" enctype="multipart/form-data">

                    <table style="width:100%" >
                        <thead charset="utf8_unicode_ci">
                            <tr>
                                <th>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">                                            
                                                <label  class="small mb-1" for="TUsuaNivel">Institucion:</label>                                            
                                            <select class="custom-select" id="TInstId" name="TInstId" 
                                                <?php if(($SUsuaNivel>1))
                                                       { ?>  
                                                         disabled  
                                                 <?php }?>
                                                 > // Instituciones
                                                    <?php   foreach ($InstRegis as $LInstitucion) 
                                                            { 
                                                                if($Usuario-> InstId==$LInstitucion-> InstId)  
                                                                {?>   
                                                                    <option value="<?php echo $LInstitucion-> InstId; ?>" selected="" ><?php echo $LInstitucion-> InstNomb; ?> </option>
                                                    <?php       } 
                                                                else 
                                                                { ?>                                                          
                                                                 <option value="<?php echo $LInstitucion-> InstId; ?>"  ><?php echo $LInstitucion-> InstNomb; ?> </option>
                                                    <?php       } 
                                                            }?>
                                                </select>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TUsuaUser">Usuario:</label>                                       
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaUser" name="TUsuaUser" value="<?php echo $Usuario-> UsuaUser; ?>"   disabled>
                                            </div>
                                        </div>    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  class="small mb-1" for="TUsuaNomb">Nombre del Usuario:</label>
                                                <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaNomb" name="TUsuaNomb" value="<?php echo $Usuario-> UsuaNomb; ?>" required >                                        
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
                                                <input cclass="form-check-input"  id="TChequeo" name="TChequeo" type="checkbox" placeholder="Enter password" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="small mb-1" id="TMensaje">* No se modificara la contraseña </label>                                                
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">                                            
                                                <label  class="small mb-1" for="TUsuaNivel">Nivel de Seguridad:</label>                                            
                                                <select class="custom-select" id="TUsuaNivel" name="TUsuaNivel" 
                                                        <?php if(($SUsuaNivel>1))
                                                            { ?>  
                                                                disabled  
                                                        <?php }?> 
                                                 >     
                                                <?php 
                                                    foreach($TodosNiveles as $LNiveles) 
                                                    {
                                                        if($LNiveles-> UsuaNivel>=$SUsuaNivel) 
                                                        { 
                                                            if($LNiveles-> UsuaNivel==$Usuario-> UsuaNivel)  
                                                            {  ?>   
                                                                    <option value="<?php echo $LNiveles-> UsuaNivel; ?>"  selected=""><?php echo $LNiveles-> NivelNomb; ?> </option>
                                                <?php       }
                                                            else 
                                                            {  ?>   
                                                                    <option value="<?php echo $LNiveles-> UsuaNivel; ?>"  ><?php echo $LNiveles-> NivelNomb; ?> </option>
                                                <?php       }
                                                        }
                                                    } ?>
                                                </select>   
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="TUsuaEstatus">Status:</label>                                        
                                            <select class="custom-select" id="TUsuaEstatus" name="TUsuaEstatus" disabled>                                                
                                                <?php       if($Usuario-> UsuaEstatus==0)  
                                                            {?>   
                                                                <option value="0"  selected="">Activo</option>
                                                                <option value="1">Inactivo</option>      
                                                    <?php   } 
                                                            else 
                                                            { ?>                                                          
                                                            <option value="0">Activo</option>
                                                            <option value="1" selected="">Inactivo</option>      
                                                    <?php    
                                                            }?>
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
                        <a href="#" onclick="ModificarUsuario()" class="btn btn-primary"  >Guardar Registro Modificado</a>
                    </div>  
                    
                    <div class="input-group mb-3">                     
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaClave" name="TUsuaClave" value=""  disabled>                        
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value=" "  disabled>
                        <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaId" name="TUsuaId" value="<?php echo $Usuario-> UsuaId; ?>" disabled>
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