
function NuevoGrado()
{      
    document.getElementById("TProceso").value="Nuevo";
    LecturaDatosGrado(); // obtener datos del formulario Grado json     
    EnviarJsonGrado();      
    history.go(-2);
    Location: reload();
}
async function ModificarGrado()
{    
    document.getElementById("TProceso").value="Modificar";
    DatosGrado(); // obtener datos del formulario Grado json 
    EnviarJsonGrado();   
    history.go(-2);      
    Location: reload();
}

async function EliminarGrado(VGradId)
{
    var mensaje;
    var opcion = confirm("Esta seguro de Querer eliminar El Grado");
    if (opcion == true) {
        document.getElementById("TGradId").value=VGradId;
        document.getElementById("TProceso").value="Eliminar";  // Proceso
        LecturaDatosGrado(); // obtener datos del formulario Grado json 
        EnviarJsonGrado();
        mensaje = "Se ha Eliminado la Grado OK";
    } else {
        mensaje = "Se Cancelo el proceso de eliminación";
    }
    alert(mensaje);
        
}

async function CambioEstatusGrado()
{    
    document.getElementById("TProceso").value="Cambiar Estatus";
    DatosGrado(); // obtener datos del formulario Grado json 
    EnviarJsonGrado(); 
    window.history.back();
    history.go(-2);  
    //Location: reload();
}
function LecturaDatosGrado() {    
    LProceso = document.getElementById("TProceso").value;  // Proceso
    LGradId = document.getElementById("TGradId").value;      
    LInstId = document.getElementById("TInstId").value;     
    LGradNomb = document.getElementById('TGradNomb').value;     
    LGradDesc = document.getElementById("TGradDesc").value; 
    LGradEstatus= document.getElementById('TGradEstatus').value; 
}


function DatosGrado() {
    LecturaDatosGrado();
    var DatosI={};  
    DatosI.Proceso = LProceso; 
    DatosI.Grupos = "Grado"; 
    DatosI.GradId = LGradId;
    DatosI.InstId = LInstId;    
    DatosI.GradNomb = LGradNomb;
    DatosI.GradDesc = LGradDesc;    
    DatosI.GradEstatus= LGradEstatus;
    Parameters= JSON.stringify(DatosI);
}

function EnviarJsonGrado()
{
    DatosGrado();
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
                    if (document.getElementById("TProceso").value==" ") {
                       document.getElementById('FormGrado').reset();
                       document.getElementById("TGradNomb").focus();
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
    //document.getElementById("TGradFechNaci").onchange=F_Edad;
      //document.getElementById("TParrId").onchange= F_Parroquias; 
}


