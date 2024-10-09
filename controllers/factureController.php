<?php

require 'models/facture.class.php';  // Modèle pour les factures
require 'services/pdfService.php';  // Service pour générer le PDF

class FactureController {

    // Génère le fichier PDF avec les infos client et leur commande
    public function afficherFacture($id_comm) {
        try {
            // Instanciation du modèle
            $factures = new Facture();
    
            // Récupération des données de la facture
            $facture = $factures->getFactureById($id_comm);
    
            // Vérification si la facture existe
            if (empty($facture)) {
                throw new Exception("Facture non trouvée.");
            }
    
            // Calcul des totaux
            $totalHT = 0;
            foreach ($facture as $ligne) {
                $totalHT += $ligne['quantite'] * $ligne['prix_unit'];   
            }
            $totalTTC = $totalHT * 1.2;  // calcul TVA
    
            // Informations du client
            $client = $facture[0];  // Le client est le même pour toutes les lignes de la facture
    
            // Génération du PDF via le service PDF
            $pdfService = new PdfService();
            $pdfService->AliasNbPages();
            $pdfService->AddPage();
            $pdfService->SetFont('Times', '', 12);
    
            // Affichage des informations du client dans le PDF
            $pdfService->Cell(0, 10, iconv('UTF-8', 'windows-1252', $client['civilite'] . ' ' . $client['nom'] . ' ' . $client['prenom']), 0, 1, 'R');
            $pdfService->Cell(0, 10, iconv('UTF-8', 'windows-1252', $client['adresse']), 0, 1, 'R');
            $pdfService->Cell(0, 10, iconv('UTF-8', 'windows-1252', $client['code_postal'] . ' ' . $client['ville']), 0, 1, 'R');
            $pdfService->Cell(0, 10, iconv('UTF-8', 'windows-1252', htmlspecialchars($client['mail'] ?? '')), 0, 1, 'R');
    
            $pdfService->Ln();
            $pdfService->TitreTable();
            $pdfService->Table(['Désignation article', 'Prix unitaire', 'Quantité', 'Prix total HT'], $facture);
            $pdfService->TotalTable($totalHT, $totalTTC);
    
            // Sortie du PDF dans le navigateur
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="facture_'.$id_comm.'.pdf"');
            $pdfService->Output('I');
        } catch (Exception $e) {
            // Affiche un message d'erreur en cas de problème
            echo "Erreur lors de l'affichage de la facture : " . $e->getMessage();
        }
    }
    
}
