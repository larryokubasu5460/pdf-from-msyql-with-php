<?php
require_once("library/tcpdf.php");
require_once("library/config/tcpdf_config.php");
require_once("dbconnect.php");

//database connect and view data
global $conn;

if(isset($_POST['pdf'])){
  error_reporting(0);
  $secid=$_POST['secid'];
  $fdate=$_POST['fDate'];

 $query=mysqli_query($conn, "SELECT * FROM registration WHERE DATE='$fdate'");
 while($row=mysqli_fetch_array($query))
 {
   $patid=$row['PATIENT_ID'];
   $date=$row['DATE'];
   $age=$row['AGE'];
   $gender=$row['GENDER'];
   $secid=$row['SECRETARY_ID'];

}

}

class pdf extends TCPDF
{
  //Page header
     public function Header() {
         // Logo
         $image_file = K_PATH_IMAGES.'logo_example.png';
         $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
         // Set font
         $this->Ln(5);
         $this->SetFont('helvetica', 'B', 20);
         // Title
         $this->Cell(0, 15, 'HOSPITAL RECORDS', 0, false, 'C', 0, '', 0, false, 'M', 'M');
     }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        date_default_timezone_set(Africa/Nairobi);
        $today= date("F j, Y/ g:i A", time());
        $this->Cell(0, 10, 'Generated Date & Time: '.$today, 0, 0,'L');
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

}

// create new PDF document
$pdf = new PDF('P','mm','A4');
global $secid;
global $fdate;
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Larry Okubasu');
$pdf->SetTitle('Patient Registration');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//add page
$pdf->AddPage();
$pdf->Ln(18);

$pdf->SetFont('times','B',10);
$pdf->cell(189,3, 'Report as on :- '.$fdate,1,1,'C');
$pdf->Ln(3);
//set font
$pdf->SetFont('times','B',10);
$pdf->Cell(130, 5, 'Secretary ID :- '.$secid,0,1,);


//page table
$pdf->SetFont('times','B',10);
$pdf->Cell(189,5, 'LIST OF ADMITTED PATIENTS', 0,1,'C');
$pdf->Ln(3);
$pdf->SetFillColor(224,235,255);
$pdf->Cell(20,10,' SL No', 1,0,'C',1);
$pdf->Cell(40, 10,'PATIENT ID',1,0,'C',1);
$pdf->Cell(30, 10,'DATE',1,0, 'C',1);
$pdf->Cell(30, 10,'GENDER',1,0, 'C',1);
$pdf->Cell(25, 10,'AGE',1,0, 'C',1);
$pdf->Cell(30, 10,'SEC ID',1,1, 'C',1);
$pdf->SetFont('times','',10);

if(isset($_POST['pdf'])){
  $secid=$_POST['secid'];
  $fdate=$_POST['fDate'];

  $getpat="SELECT `PATIENT_ID`,`DATE`,`AGE`,`GENDER`,`SECRETARY_ID` FROM `registration` WHERE `DATE` = '$fdate'";
  $queryget=mysqli_query($conn, $getpat);
  $i=1;
  $max=15;

  while($result= mysqli_fetch_array($queryget)){
    $patid=$result['PATIENT_ID'];
    $date=$result['DATE'];
    $age=$result['AGE'];
    $gender=$result['GENDER'];
    $secid=$result['SECRETARY_ID'];

    if(($i%$max)==0){
      $pdf->AddPage();
      $pdf->Ln(18);
      $pdf->SetFont('times','B',10);
      $pdf->Cell(189,3, 'Report as on :- '.$fdate.' ',1,1,'C');
      $pdf->Ln(7);
      //setFOnt
      $pdf->SetFont('times','B',10);
      $pdf->Cell(130,5, 'Secretary ID :-'.$secid.'',0,1);

      //page
      $pdf->SetFont('times','B',10);
      $pdf->Cell(189,5, 'LIST OF ADMITTED PATIENTS', 0,1,'C');
      $pdf->Ln(3);
      $pdf->SetFillColor(224,235,255);
      $pdf->Cell(20,10,' SL No', 1,0,'C',1);
      $pdf->Cell(40, 10,'PATIENT ID',1,0,'C',1);
      $pdf->Cell(30, 10,'DATE',1,0, 'C',1);
      $pdf->Cell(30, 10,'GENDER',1,0, 'C',1);
      $pdf->Cell(25, 10,'AGE',1,0, 'C',1);
      $pdf->Cell(30, 10,'SEC ID',1,1, 'C',1);
      $pdf->SetFont('times','',10);
    }
    $pdf->Ln(3);
    $pdf->Cell(20,9,$i,0,0,'C');
    $pdf->Cell(40,9,$patid,0,0,'C');
    $pdf->Cell(30,9,$date,0,0,'C');
    $pdf->Cell(30,9,$age,0,0,'C');
    $pdf->Cell(25,9,$gender,0,0,'C');
    $pdf->Cell(30,9,$secid,0,1,'C');
    $i++;


  }
}


// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Patients'.$secid.'.pdf', 'I');

 ?>
