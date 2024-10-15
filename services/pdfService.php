<?php
require('./library/fpdf/fpdf.php');

class PdfService extends FPDF
{
    // En-tête
    function Header()
    {
        $jour = getdate();
        $semaine = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
        $mois = array(1=>"janvier","février","mars","avril","mai","juin", "juillet","août","septembre","octobre","novembre","décembre");

        $this->Image('./img/logo_societe.png', 10, 6, 50);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', $semaine[date('w')] . ' ' . date('j') . ' ' . $mois[date('n')] . ' ' . date('Y')), 0, 1, 'R', 0);
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function TitreTable($date){
        $this->SetFillColor(105, 105, 105);
        $this->SetTextColor(255);
        $this->SetFont('', 'B');
        $this->Cell(75, 7, iconv('UTF-8', 'ISO-8859-1','Commande N°') . $_GET['id'] . " du " . $date, 1, 1, 'C', true);
    }

    function Table($header, $data)
    {
        $this->SetFillColor(192, 192, 192);
        $this->SetTextColor(0);
        $this->SetFont('', 'B');
        $w = array(75, 35, 30, 50);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, iconv('UTF-8', 'windows-1252', $header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();
        $this->SetTextColor(0);
        $this->SetFont('');
        foreach ($data as $row) {
            $this->Cell($w[0], 6, iconv('UTF-8', 'windows-1252', $row['designation']), 1, 0, 'C');
            $this->Cell($w[1], 6, iconv('UTF-8', 'windows-1252', $row['prix_unit'] . '€'), 1, 0, 'C');
            $this->Cell($w[2], 6, iconv('UTF-8', 'windows-1252', $row['quantite']), 1, 0, 'C');
            $this->Cell($w[3], 6, iconv('UTF-8', 'windows-1252', $row['quantite'] * $row['prix_unit'] . '€'), 1, 0, 'C');
            $this->Ln();
        }
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
    }

    function TotalTable($totalHT, $totalTTC)
    {
        $this->Cell(110, 7, '', 0, 1, 'C');
        $this->Cell(110, 7, '', 0, 0, 'C');
        $this->SetTextColor(0);
        $this->SetFont('', 'B');
        $this->Cell(30, 7, 'Total HT', 1, 0, 'C', true);
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->Cell(50, 7, iconv('UTF-8', 'windows-1252', $totalHT . '€'), 1, 1, 'C');
        $this->Cell(110, 7, '', 0, 0, 'C');
        $this->SetTextColor(0);
        $this->SetFont('', 'B');
        $this->Cell(30, 7, 'Total TTC', 1, 0, 'C', true);
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->Cell(50, 7, iconv('UTF-8', 'windows-1252', $totalTTC . '€'), 1, 0, 'C');
    }
}
?>
