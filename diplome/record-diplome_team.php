<?php
require_once('tcpdf_include.php');

require 'connexion.php';

function format_date($format, $datechoose){
    setlocale(LC_TIME, "fr_FR","French");
    return utf8_encode(date($format, strtotime($datechoose)));
}
$id_ad = $_GET['token'];

$require = $pdo->prepare("SELECT * FROM record WHERE token = ?");
$require->execute([$id_ad]);
$record = $require->fetch();


class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        // set bacground image
        $img_file = K_PATH_IMAGES.'diplome_record_team.jpg';
        $this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);

        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
        $this->Ln(6);   
    }
    // Page footer
    public function Footer() {       
        // Position at 15 mm from bottom
        $this->SetY(-33);
        // Set font
        $this->SetFont('helvetica', '', 9);
    }
}




// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$fontname = TCPDF_FONTS::addTTFfont('/fonts/calibri.ttf', 'TrueTypeUnicode', '', 96);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Fédération Française Aviron');
$pdf->SetTitle('RECORD DE FRANCE');
$pdf->SetSubject('saison 2023');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
// $pdf->setPrintFooter(false);


$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/fra.php')) {
    require_once(dirname(__FILE__).'/lang/fra.php');
    $pdf->setLanguageArray($l);
}
setlocale(LC_ALL, 'fr_fr');

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 9);
// add a page
$pdf->AddPage('L', 'A4');

$pdf->setPage(1, true);
$pdf->SetY(48.2);
$pdf->SetFont('dejavusans','B',18);
$pdf->Cell(102,10,'',0,0,'L');
$pdf->Cell(1,10,''.$record->nom.'',0,0,'C');
$pdf->Ln(6);
$pdf->SetFont('dejavusans','B',10);
$pdf->Cell(102,10,'',0,0,'L');
$pdf->Cell(1,10,''.ucwords($record->club).'',0,0,'C');
$pdf->SetY(62.2);
$pdf->SetFont('dejavusans','B',12);
$pdf->Cell(40,10,'',0,0,'L');
$pdf->Cell(1,10,'a établi un nouveau record de France d\'Aviron Indoor',0,0,'L');
$pdf->Ln(10);

$pdf->SetFont('dejavusans','B',9);
$pdf->Cell(102,10,'',0,0,'L');
$pdf->SetFont('dejavusans','B',15);
$pdf->Cell(1,10,''.$record->catAge.''.$record->catSexe.'',0,0,'L');
$pdf->Ln(.6);
$pdf->Cell(42,10,'',0,0,'L');
$pdf->SetFont('dejavusans','B',9);
$pdf->Cell(60,10,'Catégorie : ',0,0,'R');

$pdf->Ln(8);

$pdf->SetFont('dejavusans','B',9);
$pdf->Cell(42,10,'',0,0,'L');
$pdf->Cell(60,10,'Épreuve : ',0,0,'R');
$pdf->SetFont('dejavusans','B',15);
$pdf->Cell(1,10,''.$record->catRecord.'',0,0,'L');

$pdf->Ln(8);
if(($record->temps >= 1)){
    $pdf->SetFont('dejavusans','B',9);
    $pdf->Cell(30,10,'',0,0,'L');
    $pdf->Cell(72,10,'Performance : ',0,0,'R'); 
    $pdf->SetFont('dejavusans','B',15);
    $pdf->Cell(1,10,''.$record->temps.'',0,0,'L');   
}else{
    $pdf->SetFont('dejavusans','B',9);
    $pdf->Cell(30,10,'',0,0,'L');
    $pdf->Cell(72,10,'Performance : ',0,0,'R'); 
    $pdf->SetFont('dejavusans','B',15);
    $pdf->Cell(1,10,' '.$record->distance.'',0,0,'L');  
}

$pdf->Ln(8);
$pdf->SetFont('dejavusans','B',9);
$pdf->Cell(38,10,'',0,0,'L');
$pdf->Cell(64,10,'Date : ',0,0,'R');
$pdf->SetFont('dejavusans','B',15);
$pdf->Cell(1,10,''.format_date('d/m/Y', $record->dateRecord).'',0,0,'L');


$pdf->Ln(13.4);
$pdf->Cell(65,10,'',0,0,'L');
$pdf->Cell(1,10,'',0,0,'L');
$pdf->Ln(9.7);
$pdf->SetFont('dejavusans','B',11);
$pdf->Cell(65,10,'',0,0,'L');
$pdf->Cell(1,10,''.date("d/m/Y").'',0,0,'L');

if($record->nbr_participant < 16){
$pdf->SetY(167.2);
$pdf->Cell(130 ,10,'',0,0,'L');
$pdf->SetFont('dejavusans','B',15);
$pdf->Cell(1,10,'EQUIPE',0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('dejavusans','',12);
$pdf->Cell(33 ,10,'',0,0,'L');
$message = $record->name_team;
$pdf->MultiCell(200,0,''.$message.'',0,'C');
}
if($record->nbr_participant > 16 && $record->nbr_participant < 40){
$pdf->SetY(160.2);
$pdf->Cell(130 ,10,'',0,0,'L');
$pdf->SetFont('dejavusans','B',15);
$pdf->Cell(1,10,'EQUIPE',0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('dejavusans','',12);
$pdf->Cell(33 ,10,'',0,0,'L');
$message = $record->name_team;
$pdf->MultiCell(200,0,''.$message.'',0,'C');
}
if($record->nbr_participant > 40){
$pdf->SetY(160.2);
$pdf->Cell(130 ,10,'',0,0,'L');
$pdf->SetFont('dejavusans','B',15);
$pdf->Cell(1,10,'EQUIPE',0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('dejavusans','',7);
$pdf->Cell(33 ,10,'',0,0,'L');
$message = $record->name_team;
$pdf->MultiCell(200,0,''.$message.'',0,'C');
}


setlocale(LC_ALL, 'fr_fr');

ob_end_clean();

//Close and output PDF document
//I : send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
//D : send to the browser and force a file download with the name given by name.
//F : save to a local server file with the name given by name.
//S : return the document as a string (name is ignored).
//FI : equivalent to F + I option
//FD : equivalent to F + D option
//E : return the document as base64 mime multi-part email attachment (RFC 2045)
$pdf->Output('DIPLOME_RECORD_2023.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+