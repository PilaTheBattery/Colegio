
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
	
    $VInstEstatus=2;
    $Tabla_Datos = new RegDatos();    
    $InstRegis = $Tabla_Datos->Institucion_Obtener_Todos($VInstEstatus);    
    $VPeriEstatus=2;
    $PeriRegis = $Tabla_Datos->Periodos_Obtener_Todos($VPeriEstatus);    
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
                                <a href="Principal.php">Sistema de Control de Colegio</a>
                            </li>
                            <?php if($SUsuaNivel<3){ ?>
                                <li class="breadcrumb-item active">Registro de Periodos Escolares</li>
                            <?php } ?>
                            </ol>
                        </th>
                        <?php if($SUsuaNivel<3){ ?>
                            <th>
                                <a href="PeriodosReg.php"><img src="imagen/BPeriN.png" data-toggle="tooltip" data-placement="right" title="Nuevo Periodo Escolar" width="35" height="35"></a>
                            </th>
                        <?php } ?>
                    </tr>
		        </thead> 
            </table>
        </div>
	    <div class="card mb-1">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Tabla de Periodos Escolares Registrados</div>
            <div class="card-body">
                <div class="table-responsive"><font size=2>
                    <table class="table-striped table-bordered" id="dataTable" style="width:100%" >
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Nombre</th>
                                <th>Fecha Inicial</th  >
                                <th>Fecha Final</th  >
                                <th></th>
                                <th></th>
				                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th># </th>                                    
                                    <th>Nombre</th>
                                    <th>Fecha Inicial</th  >
                                    <th>Fecha Final</th  >
                                    <th></th>
                                    <th></th>
				                </tr>
                            </tfoot>
                            <tbody charset="utf8_unicode_ci" id ="TbodyTablaPeriodos">
                                <?php $Contador=0; foreach ($PeriRegis as $Periodos) { $Contador=$Contador+1; ?>
                                    <tr>
                                        <td><?php echo $Contador;  ?></td>
                                        <td><?php echo  $Periodos-> PeriNomb; ?></td>
                                        <td><?php echo  $Periodos-> PeriFechInic; ?></td>
                                        <td><?php echo  $Periodos-> PeriFechFina; ?></td>
                                        <td>
                                            <?php if(($Periodos-> PeriEstatus==0)&&(($SUsuaNivel==0)||($SInstId==$Periodos-> InstId))){ ?>
                                                <a href="PeriodosMod.php?Id=<?php echo  $Periodos-> PeriId; ?> "><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Periodo" ></a></td>
                                            <?php } ?>
                                        </td>
                                        <td>
                                           <?php if($SUsuaNivel<3){ ?>
                                            <a href="PeriodosCambioStatus.php?Id=<?php echo  $Periodos-> PeriId; ?> ">
                                                <?php 
                                                    switch ($Periodos->PeriEstatus )
                                                    {
                                                    case 0: echo '<img src="imagen/Habilitar0.png" data-toggle="tooltip" data-placement="right" title="Deshabilitar Periodo">'; break;
                                                    case 1: echo '<img src="imagen/Habilitar1.png" data-toggle="tooltip" data-placement="right" title="Habilitar Periodo">'; break;
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
                <label  class="small mb-1" for="PeriEstatus">Periodo a Mostrar:</label>
            </div>
            <div class="col-auto">
                <select class="custom-select" id="PeriEstatus" name="PeriEstatus" >                                                                                 
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
        document.getElementById("PeriEstatus").onchange =ActualizarTabla;
    }
    function ActualizarTabla()
    { 
        VEstatus = document.getElementById('PeriEstatus').value;    
        VInstId= document.getElementById('TInstId').value;
        VConsulta="Consulta Todo";    //Leer todas las instituciones       
            
        var DatosI={};  
        DatosI.Proceso = VConsulta; 
        DatosI.Grupos ="Periodos"; 
        DatosI.PeriId =0; 
        DatosI.InstId =VInstId; 
        DatosI.PeriNomb =""; 
        DatosI.PeriFechInic =""; 
        DatosI.PeriFechFina =""; 
        DatosI.PeriEstatus =VEstatus;        
        Parameters= JSON.stringify(DatosI);

        var tabla="";
        var reg1=1;
        $.ajax({    
            url:"CSQL/ColegioBd.php",
            type: "POST",
            dataType:"json",
            async:false,
            data:{  Parameters:Parameters },
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
                    
                    tabla+='<td >'+data[i].PeriNomb+'</td>'; 
                    tabla+='<td >'+data[i].PeriFechInic+'</td>'; 
                    tabla+='<td >'+data[i].PeriFechFina+'</td>';                     
                    tabla+='<td>';
                        if((data[i].PeriEstatus==0)&&((VUsuaNivel==0)||(VPeriId==data[i].PeriId)))
                        
                        {   tabla+='<a href="PeriodosMod.php?Id='+data[i].PeriId+'"><img src="imagen/REditar.png" data-toggle="tooltip" data-placement="left" title="Editar Periodos" ></a>'; }
                    tabla+='</td>';

                    tabla+='<td>';
                        if(VUsuaNivel==0)
                        { 
                            tabla+='<a href="PeriodosCambioStatus.php?Id='+data[i].PeriId+' ">';

                            switch (data[i].PeriEstatus) 
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
                var edicion =document.getElementById("TbodyTablaPeriodos");
                edicion.innerHTML = tabla;
            }
        });
    }
</script>