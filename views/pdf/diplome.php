<?php
require '../vendor/autoload.php';

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
    //Page header
    public function Header()
    {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = 'img/diplomeScolaireVide-01.png';
        $this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}




// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$fontname = TCPDF_FONTS::addTTFfont('/fonts/calibri.ttf', 'TrueTypeUnicode', '', 96);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Fédération Française Aviron');
$pdf->SetTitle('Diplome scolaire');

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
if (@file_exists(dirname(__FILE__) . '/lang/fra.php')) {
    require_once(dirname(__FILE__) . '/lang/fra.php');
    $pdf->setLanguageArray($l);
}
setlocale(LC_ALL, 'fr_fr');

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 9);
// add a page
// add a page
$pdf->AddPage();
$pdf->SetY(36.2);
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(60, 10, '', 0, 0, 'C');
$pdf->Cell(1, 10, 'LE CERCLE NAUTIQUE DE MEAUX AVIRON', 0, 0, 'C');
$pdf->Ln(9);
$pdf->Cell(60, 10, '', 0, 0, 'C');
$pdf->Cell(1, 10, 'ET LA FEDERATION FRANCAISE D\'AVIRON', 0, 0, 'C');

$pdf->AddPage();
// -- set new background ---

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = 'img/diplomeScolaireVide-02.png';
$pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(40, 10, '', 0, 0, 'L');
$pdf->Cell(1, 10, 'a établi un nouveau record de France d\'Aviron Indoor', 0, 0, 'L');
$pdf->Ln(10);


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
$pdf->Output('DIPLOME_SCOLAIRE.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+