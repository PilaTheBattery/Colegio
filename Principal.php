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
    else { $InstRegis = $Tabla_Institucion->Institucion_Obtener_InstId($SInstId,$VInstEstatus);}   //Leer la cede del usuario    

	include_once (TEMPLATE_DIR."cabecera.php");
?>


			
<main>

    <div class="container-fluid">
	
    <ol class="breadcrumb mb-1">
    </ol>
    <img src="Imagen/Fondo01.jpg" alt="" height="90%"  align="center"/>                 
</main>                    
<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>               