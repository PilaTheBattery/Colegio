
<?php 

	session_start();
	
	if(!isset($_SESSION['SUsuaId'])){
		header("Location: index.php");
	}
	
	$Sid = $_SESSION['SUsuaId'];
	$SUsuaId = $_SESSION['SUsuaId'];
    $SUsuaNomb = $_SESSION['SUsuaNomb'];
	$SUsuaNivel = $_SESSION['SUsuaNivel'];
	$SInstId = $_SESSION['SInstId'];
    $STexto = $_SESSION['STexto'];
	$SFondo = $_SESSION['SFondo'];

	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Template/inicio.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
    include_once (CSQL_DIR."ColegioBd.php");
	
    $VInstEstatus=2;
    $Tabla_Institucion = new RegDatos();    
    $InstRegis = $Tabla_Institucion->Institucion_Obtener_Todos($VInstEstatus);    

    include_once (TEMPLATE_DIR."cabecera.php");
    
?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "scrollX": true
            "autoWidth": false
            var table = $('#dataTable').DataTable();
            table.columns.adjust().draw();
        });
    } );
</script>
<main>
    <div class="container-fluid">        
        <div >
            <table style="width:100%" > 
                <thead>
                    <tr class="breadcrumb mb-2">
                        <th>
                            <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item">
                                <a href="Principal.php">Sistema de Control de Notas</a>
                            </li>
                            <?php if($SUsuaNivel==0){ ?>
                                <li class="breadcrumb-item active">Registro de Instituciones </li>
                            <?php } ?>
                            </ol>
                        </th>
                        <?php if($SUsuaNivel==0){ ?>
                            <th>
                                <a href="InstitucionReg.php"><img src="imagen/NInst.png" data-toggle="tooltip" data-placement="right" title="Nueva Institución" width="35" height="35"></a>
                            </th>
                        <?php } ?>
                    </tr>
		        </thead> 
            </table>
        </div>
	    <div class="card mb-1">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Tabla de Instituciones Registradas</div>
            <div class="card-body">
                <div class="table-responsive"><font size=2>
                    <table class="table-striped table-bordered" id="dataTable" style="width:100%" >
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Nombre de la Institución</th>
                                <th>Dirección</th  >
                                <th>Estados</th>                                    
				    			<th>Municipios</th>
                                    <th></th>
                                    <th></th>
				                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th># </th>
                                    <th>Nombre de la Institución</th>
                                    <th>Dirección</th  >
                                    <th>Estados</th>                                    
									<th>Munipios</th>
                                    <th></th>
                                    <th></th>
				                </tr>
                            </tfoot>
                            <tbody charset="utf8_unicode_ci" id ="TbodyTablaInstitucion">
                                <?php $Contador=0; foreach ($InstRegis as $Institucion) { $Contador=$Contador+1; ?>
                                    <tr>
                                        <td><?php echo $Contador;  ?></td>
                                        <td><?php echo  $Institucion-> InstNomb; ?></td>
                                        <td><?php echo  $Institucion-> InstDire; ?></td>
                                        <td><?php echo  $Institucion-> EstaNomb; ?></td>
                                        <td><?php echo  $Institucion-> MuniNomb; ?></td>                            
                                        <td>
                                            <?php if(($Institucion-> InstEstatus==0)&&(($SUsuaNivel==0)||($SInstId==$Institucion-> InstId))){ ?>
                                                <a href="InstitucionMod.php?Id=<?php echo  $Institucion-> InstId; ?> "><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Institución" ></a></td>
                                            <?php } ?>
                                        <td>
                                           <?php if($SUsuaNivel==0){ ?>
                                            <a href="InstitucionCambioStatus.php?Id=<?php echo  $Institucion-> InstId; ?> ">
                                                <?php 
                                                    switch ($Institucion->InstEstatus )
                                                    {
                                                    case 0: echo '<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Institución">'; break;
                                                    case 1: echo '<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Institución">'; break;
                                                    }
                                                ?>
                                            </a> 
                                            <?php } ?>
                                        </td>
                                    </tr>
				                <?php } ?>
                            </tbody>
			        </table>
                    
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TProceso" name="TProceso" value="Table"  disabled>
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TUsuaNivel" name="TUsuaNivel" value="<?php echo  $SUsuaNivel; ?>"  disabled>
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="TInstId" name="TInstId" value="<?php echo  $SInstId; ?>"  disabled>
                </font></div>                
		    </div>
        </div>
        <div class="form-row">
            <div class="col-auto">
                <label  class="small mb-1" for="TInstEstatus">Instituciones a Mostrar:</label>
            </div>
            <div class="col-auto">
                <select class="custom-select" id="TInstEstatus" name="TInstEstatus" >                                                                                 
                    <option value="0" > Activo</option>
                    <option value="1" > Inactivo</option>                        
                    <option value="2" selected=""> Mostrar Todas </option>
                </select>                         
            </div>
        </div>
    </div>
</main>

<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/Colegio/Directorios.php');
	include_once (TEMPLATE_DIR."pie.php");
 ?>


 <script>
    $(document).ready(function() {

    } );

    window.onload = function()
    {
        document.getElementById("TInstEstatus").onchange =MostrarInstitucion;
    }
    function MostrarInstitucion()
    { 
        VEstatus = document.getElementById('TInstEstatus').value;
        VUsuaNivel= document.getElementById('TUsuaNivel').value;
        VInstId= document.getElementById('TInstId').value;
        VConsulta="Consulta Todo";    //Leer todas las instituciones       
            
        var DatosI={};  
        DatosI.Proceso = VConsulta; 
        DatosI.InstId = VInstId;
        DatosI.InstNomb = "X";
        DatosI.InstDesc = "X";
        DatosI.EstaId = 0;
        DatosI.MuniId = 0;
        DatosI.ParrId = 0;
        DatosI.InstDire= "X";
        DatosI.InstCont= "X";
        DatosI.InstEstatus= VEstatus;
        Parameters_Inst= JSON.stringify(DatosI);

        var tabla="";
        var reg1=1;
        $.ajax({    
            url:"CSQL/InstitucionRegBd.php",
            type: "POST",
            dataType:"json",
            async:false,
            data:{  Parameters_Inst:Parameters_Inst },
            success: function(data)
            {
                data = JSON.stringify(data).replace(/null/g, '""');  //pasa objeto a array y elimina null de los elementos
                data = JSON.parse(data); // pasa de array a objeto         
                //for(var i in data){reg1+=1;}
                //document.getElementById("TCReg").value=reg1;
                for(var i in data)
                {              
                    tabla+='<tr>';
                    tabla+='<td>'+reg1+'</td>';                 
                    
                    tabla+='<td >'+data[i].InstNomb+'</td>'; 
                    tabla+='<td >'+data[i].InstDire+'</td>'; 
                    tabla+='<td >'+data[i].EstaNomb+'</td>'; 
                    tabla+='<td >'+data[i].MuniNomb+'</td>';                            				         
                    tabla+='<td>';
                        if((data[i].InstEstatus==0)&&((VUsuaNivel==0)||(VInstId==data[i].InstId)))
                        
                        {   tabla+='<a href="InstitucionMod.php?Id='+data[i].InstId+'"><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Institución" ></a>'; }
                    tabla+='</td>';

                    tabla+='<td>';
                        if(VUsuaNivel==0)
                        { 
                            tabla+='<a href="InstitucionCambioStatus.php?Id='+data[i].InstId+' ">';

                            switch (data[i].InstEstatus) 
                            {
                                case '0': tabla+='<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Area de Trabajo">';  break;
                                case '1': tabla+='<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Area de Trabajo">'; break;                        
                            }                    
                            tabla+='</a>';
                        } 
                        tabla+='</td>';
                    tabla+='</tr>';
                    reg1+=1;
                }								
                var edicion =document.getElementById("TbodyTablaInstitucion");
                edicion.innerHTML = tabla;
            }
        });
    }
</script>