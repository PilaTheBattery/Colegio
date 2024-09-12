
function NuevoPeriodo()
{      
    document.getElementById("TProceso").value="Nuevo";
    LecturaDatosPeriodos(); // obtener datos del formulario Periodos json     
    EnviarJsonPeriodos();      
    history.go(-2);
   Location: reload();
}
async function ModificarPeriodo()
{    
    document.getElementById("TProceso").value="Modificar";
    DatosPeriodos(); // obtener datos del formulario Periodos json 
    EnviarJsonPeriodos();   
    history.go(-3);      
   Location: reload();
}

async function EliminarPeriodo(VPeriId)
{
    var mensaje;
    var opcion = confirm("Esta seguro de Querer eliminar el Periodo");
    if (opcion == true) {
        document.getElementById("TPeriId").value=VPeriId;
        document.getElementById("TProceso").value="Eliminar";  // Proceso
        LecturaDatosPeriodos(); // obtener datos del formulario Periodos json 
        EnviarJsonPeriodos();
        mensaje = "Se ha Eliminado la Periodos OK";
    } else {
        mensaje = "Se Cancelo el proceso de eliminación";
    }
    alert(mensaje);
        
}

async function CambioEstatusPeriodos()
{    
    document.getElementById("TProceso").value="Cambiar Estatus";
    DatosPeriodos(); // obtener datos del formulario Periodos json 
    EnviarJsonPeriodos(); 
    window.history.back();
    history.go(-1);  
    //Location: reload();
}
function LecturaDatosPeriodos() {    
    LProceso = document.getElementById("TProceso").value;  // Proceso
    LPeriId = document.getElementById("TPeriId").value; 
    LInstId = document.getElementById("TInstId").value; 
    LPeriNomb = document.getElementById("TPeriNomb").value; 
    LPeriFechInic = document.getElementById("TPeriFechInic").value; 
    LPeriFechFina = document.getElementById("TPeriFechFina").value; 
    LPeriDesc = document.getElementById("TPeriDesc").value; 
    LPeriEstatus = document.getElementById("TPeriEstatus").value; 

}


function DatosPeriodos() {
    LecturaDatosPeriodos();
    var DatosI={};  
    DatosI.Proceso = LProceso; 
    DatosI.Grupos = "Periodos"; 
    DatosI.PeriId =LPeriId; 
    DatosI.InstId =LInstId; 
    DatosI.PeriNomb =LPeriNomb; 
    DatosI.PeriFechInic =LPeriFechInic; 
    DatosI.PeriFechFina =LPeriFechFina; 
    DatosI.PeriDesc =LPeriDesc; 
    DatosI.PeriEstatus =LPeriEstatus; 
    Parameters= JSON.stringify(DatosI);
}

function EnviarJsonPeriodos()
{
    DatosPeriodos();
   request =$.ajax({
    
        url:"CSQL/ColegioBd.php",
        type: "POST",
        dataType:"json",
        async:false,
        data:{
            Parameters:Parameters      
             },
             success: function(data){
                  if (data==1) {
                    alert("Proceso realizado Sastifactoriamente");
                    if (document.getElementById("TProceso").value=="") {
                       document.getElementById('FormPeriodos').reset();
                       document.getElementById("TPeriNomb").focus();
                       Deshabilitar(); 
                    }else 
                    {
                        history.go(-1);  ;
                    } 

                    
                  }  
                  else {
                    alert("Verificar Información Proceso No realizado");
                  }             
              }
    });
}   

window.onload = function()
{
    //document.getElementById("TPeriFechNaci").onchange=F_Edad;
      //document.getElementById("TParrId").onchange= F_Parroquias; 
}


