<?php
//include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/libreria/fpdf/fpdf.php');
require($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/libreria/fpdf/WriteHTML.php');
date_default_timezone_set('America/El_Salvador');
class PDF extends PDF_HTML
{
    function Header()
    {

        $this->setY(12);  $this->setX(10);
        $this->Image('imagen/logo2.png',10,5,30);
        $this->SetFont('times', 'B', 12);
        $this->Image('imagen/logo1.png',160,5,25);
        
        // Agregamos los datos del cliente
        $this->SetFont('Arial','B',10);    
            
        $this->Ln(50);
    }

    function Footer()
    {
        $this->SetFont('helvetica', 'B', 8);
        $this->SetY(-15);
        $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
        $this->Cell(95,5,date('d/m/Y | g:i:a') ,00,1,'R');
        $this->Line(10,287,200,287);
        $this->Cell(0,5,utf8_decode("Fundación Nacional del Niño © Todos los derechos reservados."),0,0,"C");
            
    }
}

$idMantenimiento=$_GET['Id'];
include_once($_SERVER['DOCUMENT_ROOT'].'/Mantenimiento/Directorios.php');
include_once (CSQL_DIR."MantenimientosRegBd.php");
$Tabla_Mantenimiento_id = new RMantenimientos();
$RMantenimientoRegistrado = $Tabla_Mantenimiento_id->Obtener_Mantenimiento_Id($idMantenimiento); //Leer todos los Mantenimientos    

$pdf = new PDF();
foreach ($RMantenimientoRegistrado as $Mantenimiento) 
{
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->SetTopMargin(15);
    $pdf->SetLeftMargin(10);
    $pdf->SetRightMargin(10);

    $pdf->SetFont('Arial','B',13);
    //$pdf->Text(60,15, utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA '));    
    //$pdf->Text(60,24,  utf8_decode('    PLANILLA DE MANTENIMIENTO      '));
    $pdf->setY(12);
    $pdf->Cell(0,5,utf8_decode('REPÚBLICA BOLIVARIANA DE VENEZUELA'),0,0,'C',0); 
    $pdf->Ln(0.9);
    $pdf->Ln();
    
    $pdf->Cell(0,5,utf8_decode('PLANILLA DE MANTENIMIENTO'),0,0,'C',0); 
    $pdf->SetFont('Arial','',10);
    $pdf->Text(10, 44, utf8_decode('No de Solicitud i/o Servicio: '.$Mantenimiento-> MantId));

    if($Mantenimiento-> MantEstatus=="0") { $pdf->Text(130, 44, utf8_decode('Estatus Actual: Creada'));} 
    if($Mantenimiento-> MantEstatus=="1") { $pdf->Text(130, 44, utf8_decode('Estatus Actual: Procesando'));} 
    if($Mantenimiento-> MantEstatus=="2") { $pdf->Text(130, 44, utf8_decode('Estatus Actual: Culminada'));} 
    
    $pdf->setY(46);$pdf->setX(135);

        $pdf->Ln();$pdf->Ln();
    // En esta parte estan los encabezados
        $pdf->SetFont('Arial','B',10);
        
        //$pdf->Cell(w,h,texto.borde,ln,align,fill); 
        //w: ancho de la celda. Si ponemos 0 la celda se extiende hasta el margen derecho.
        //H: alto de la celda.
        //Texto: el texto que le vamos a añadir.
        //Borde: nos dice si van a ser visibles o no. si es 0 no serán visibles, si es 1 se verán los bordes.
        //Ln: nos dice donde se empezara a escribir después de llamar a esta función. Siendo 0 a la derecha, 1 al comienzo de la siguiente línea, 2 debajo.
        //Align: para alinear el texto. L alineado a la izquierda, C centrado y R alineado a la derecha.
        //Fill: nos dice si el fondo de la celda va a ir con color o no. los valores son True o False        
        $pdf->SetFillColor(248,248,255);
        $pdf->SetFont('Arial','B',12);$pdf->Cell(0, 6, utf8_decode('Datos Generales'),1,0,'C',true);  
        $pdf->SetFillColor(255, 255, 255 );      
        $pdf->Ln();
        $pdf->setX(10);
        $pdf->SetFont('Arial','B',10);$pdf->Cell(40,5,utf8_decode(' Institución:'),1,0,'l',1);  
        $pdf->SetFont('Arial','',9);$pdf->Cell(150,5,utf8_decode($Mantenimiento-> InstNomb),1,0,'l',1);      
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);$pdf->Cell(40,5,utf8_decode(' Area de Trabajo:'),1,0,'l',1);  
        $pdf->SetFont('Arial','',9);$pdf->Cell(150,5,utf8_decode($Mantenimiento-> AreaNomb),1,0,'l',1);      
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);$pdf->Cell(40,5,utf8_decode(' Equipo:'),1,0,'l',1);  
        $pdf->SetFont('Arial','',9);$pdf->Cell(150,5,utf8_decode( $Mantenimiento-> EquiCodi."->".$Mantenimiento-> EquiDesc),1,0,'l',1);      
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);$pdf->Cell(40,5,utf8_decode(' Marca / Modelo :'),1,0,'l',1);  
        $pdf->SetFont('Arial','',9);$pdf->Cell(150,5,utf8_decode($Mantenimiento-> EquiMarc." / ".$Mantenimiento-> EquiMode),1,0,'l',1);   
        
        $pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->setX(10);

        $pdf->SetFillColor(248,248,255);
        $pdf->SetFont('Arial','B',12);$pdf->Cell(0, 6, utf8_decode('Datos de la Solicitud'),1,0,'C',true);  
        $pdf->SetFillColor(255, 255, 255 );      
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);$pdf->Cell(40,5,utf8_decode(' Datos del Solicitante:'),1,0,'l',1);  
        $pdf->SetFont('Arial','',9);$pdf->Cell(70,5,utf8_decode($Mantenimiento-> MantNombSoli),1,0,'l',1);
       
        $pdf->SetFont('Arial','B',10);$pdf->Cell(40,5,utf8_decode(' Fecha Solicitud:'),1,0,'l',1);  
        $pdf->SetFont('Arial','',9);$pdf->Cell(40,5,utf8_decode($Mantenimiento-> MantFechSoli),1,0,'l',1);
        
        $pdf->Ln();$pdf->setX(10);$pdf->Ln();
        $pdf->SetFillColor(248,248,255);
        $pdf->SetFont('Arial','B',12);$pdf->Ln();$pdf->Cell(0, 6, utf8_decode('Descripción del Diagnostico'),1,0,'C',true);  
        $pdf->SetFillColor(255, 255, 255 );      
        $pdf->Ln();   $pdf->Ln(); 
        $pdf->SetFont('Arial','B',10);$pdf->Cell(20,5,utf8_decode(' Tipo de Servicio:'),0,0,'l',1);  
        $pdf->setX(50);$pdf->SetFont('Arial','',9);
            if ($Mantenimiento-> MantTipoServ=="Preventivo") {$pdf->Cell(5,5,'X',1,0,'l',1);  }
            else {$pdf->Cell(5,5,' ',1,0,'l',1);  } 
            $pdf->setX(56);$pdf->Cell(25,5,utf8_decode(' Preventivo'),0,0,'l',1);
            if ($Mantenimiento-> MantTipoServ=="Correctivo") {$pdf->Cell(5,5,'X',1,0,'l',1);  }
            else {$pdf->Cell(5,5,' ',1,0,'l',1);  } 
            $pdf->setX(87);$pdf->Cell(25,5,utf8_decode(' Correctivo'),0,0,'l',1);
            if ($Mantenimiento-> MantTipoServ=="Instalación") {$pdf->Cell(5,5,'X',1,0,'l',1);  }
            else {$pdf->Cell(5,5,' ',1,0,'l',1);  } 
            $pdf->setX(118);$pdf->Cell(25,5,utf8_decode(' Instalación'),0,0,'l',1);
        $pdf->Ln(); $pdf->Ln();        
        $pdf->SetFont('Arial','B',10);$pdf->Cell(65, 6, utf8_decode('Fallas Reportadas por el Solicitante:'),1,0,'l',true);          
        $pdf->SetFont('Arial','',9);$pdf->Cell(0, 6, utf8_decode( $Mantenimiento-> MantFallRepo),1,0,'l',true);          
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);$pdf->Cell(65, 6, utf8_decode('Fallas Encontradas por el Técnico:'),1,0,'l',true);  
        $pdf->SetFont('Arial','',9);$pdf->Cell(0, 6, utf8_decode( $Mantenimiento-> MantFallEnco),1,0,'l',true);  
        
        $pdf->Ln();$pdf->Ln();$pdf->setX(10);        
        $pdf->SetFillColor(248,248,255);$pdf->SetFont('Arial','B',12);
        $pdf->Ln();$pdf->Cell(0, 6, utf8_decode('Descripción Trabajo Realizado'),1,0,'C',true);  
        $pdf->SetFillColor(255, 255, 255 );      
        //Aqui inicia el for con todos los productos
        
        $pdf->Ln();$pdf->Ln();
        $pdf->SetFont('Arial','B',10);$pdf->Cell(18,5,utf8_decode(' Estado del Equipo:'),0,0,'l',1);  
        $pdf->setX(47);$pdf->SetFont('Arial','',10);
            if ($Mantenimiento-> MantEquiEsta=="Funcional") {$pdf->Cell(5,5,'X',1,0,'l',1);  }
            else {$pdf->Cell(5,5,' ',1,0,'l',1);  } $pdf->setX(53);$pdf->Cell(22,5,utf8_decode(' Funcional'),0,0,'l',1);

            if ($Mantenimiento-> MantEquiEsta=="Inoperativo") {$pdf->Cell(5,5,'X',1,0,'l',1);  }
            else {$pdf->Cell(5,5,' ',1,0,'l',1);  } $pdf->setX(81);$pdf->Cell(24,5,utf8_decode(' Inoperativo'),0,0,'l',1);
            
            if ($Mantenimiento-> MantEquiEsta=="En Mantenimiento") {$pdf->Cell(5,5,'X',1,0,'l',1);  }
            else {$pdf->Cell(5,5,' ',1,0,'l',1);  } $pdf->setX(112);$pdf->Cell(35,5,utf8_decode(' En Mantenimiento'),0,0,'l',1);

            if ($Mantenimiento-> MantEquiEsta=="Fuera de servicio") {$pdf->Cell(5,5,'X',1,0,'l',1);  }
            else {$pdf->Cell(5,5,' ',1,0,'l',1);  } $pdf->setX(155);$pdf->Cell(25,5,utf8_decode(' Fuera de servicio'),0,0,'l',1);
            
            
            $pdf->Ln();$pdf->Ln();
            $pdf->SetFont('Arial','B',10);$pdf->Cell(40, 6, utf8_decode('Actividad Realizada:'),1,0,'l',true);          
            $pdf->SetFont('Arial','',9);$pdf->Cell(0, 6, utf8_decode($Mantenimiento-> MantActiReal),1,0,'l',true);          
            $pdf->Ln(); 
            $pdf->SetFont('Arial','B',10);$pdf->Cell(40, 6, utf8_decode('Repuestos Utilizados:'),1,0,'l',true);  
            $pdf->SetFont('Arial','',9);$pdf->Cell(0, 6, utf8_decode( $Mantenimiento-> MantRespUsad),1,0,'l',true);  
            $pdf->Ln();
            $pdf->SetFont('Arial','B',10);$pdf->Cell(40, 6, utf8_decode('Observaciones:'),1,0,'l',true);  
            $pdf->SetFont('Arial','',9);$pdf->Cell(0, 6, utf8_decode($Mantenimiento-> MantObse),1,0,'l',true);  
            
            $pdf->Ln(); $pdf->Ln(); 
            $pdf->SetFont('Arial','B',10);$pdf->Cell(40, 6, utf8_decode('Técnicos de Soporte:'),1,0,'l',true);  
            $pdf->SetFont('Arial','',9);$pdf->Cell(0, 6, utf8_decode($Mantenimiento-> TecnApelNomb),1,0,'l',true);  

            $pdf->Ln();$pdf->Ln();$pdf->Ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(60,5,utf8_decode('Fecha Inicio Solicitud:'),1,0,'C',1);  
            $pdf->Cell(60,5,utf8_decode('Fecha Inicio Servicio:'),1,0,'C',1);        
            $pdf->Cell(0,5,utf8_decode('Fecha Final Servicio:'),1,0,'C',1);  
            $pdf->Ln();
            $dateS = $Mantenimiento-> MantFechSoli; 
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(60,5,$dateS,1,0,'C',1);  
            if (($Mantenimiento->MantEstatus=="1")||($Mantenimiento->MantEstatus=="2")) {$dateI =$Mantenimiento-> MantFechInicServ; } else {$dateI="";}
            $pdf->Cell(60,5,$dateI,1,0,'C',1);        
            if (($Mantenimiento->MantEstatus=="2")) {$dateF = $Mantenimiento-> MantFechFinServ; }else {$dateF="";}
            $pdf->Cell(0,5,$dateF,1,0,'C',1);  

            

  
    //$pdf->Output();
    $pdf -> Output("Reporte_Mantenimiento".$Mantenimiento-> MantId.".pdf", "D");
}   
?>