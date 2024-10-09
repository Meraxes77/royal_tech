<?php

    $title = 'Liste des commandes';
    ob_start();

?>

    <div class="d-flex justify-content-center text-bg-dark">
        <h1 class=" pt-2"><?php echo $title ?></h1>
    </div>

    <div class="d-flex justify-content-center m-5">
        <table id="tableCommande" class="nowrap table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">ID commande</th>
                    <th class="text-center">ID client</th>
                    <th class="text-center">Civilité</th>
                    <th class="text-center">Nom</th>
                    <th class="text-center">Prénom</th>
                    <th class="text-center">Mail</th>
                    <th class="text-center">Adresse</th>
                    <th class="text-center">Édition facture</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>

<?php

    $content = ob_get_clean();
    include 'layout.php';

?>