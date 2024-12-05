<?php
require('../utilsPDF/fpdf.php');

// Capturar los datos de la adopción desde la URL
$plantaId = $_GET['planta'];
$nombre = urldecode($_GET['nombre']);
$email = urldecode($_GET['email']);
$direccion = urldecode($_GET['direccion']);

// Crear una nueva instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título
$pdf->Cell(190, 10, 'Comprobante de Adopcion', 0, 1, 'C');
$pdf->Ln(10);

// Datos del adoptante
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Nombre Completo:', 0, 0);
$pdf->Cell(140, 10, $nombre, 0, 1);
$pdf->Cell(50, 10, 'Correo Electronico:', 0, 0);
$pdf->Cell(140, 10, $email, 0, 1);
$pdf->Cell(50, 10, 'Direccion:', 0, 0);
$pdf->Cell(140, 10, $direccion, 0, 1);

// Información de la planta
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Detalles de la Planta', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'ID Planta:', 0, 0);
$pdf->Cell(140, 10, $plantaId, 0, 1);

// Pie de página
$pdf->Ln(20);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(190, 10, 'Gracias por apoyar el vivero UADY', 0, 1, 'C');

// Salida del archivo PDF
$pdf->Output('D', 'Comprobante_Adopcion.pdf');
?>
