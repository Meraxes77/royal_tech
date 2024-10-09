<?php

    $title = 'Volumes des ventes';
    ob_start();

?>

    <div class="d-flex justify-content-center text-bg-dark">
            <h1 class=" pt-2"><?php echo $title ?></h1>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <img class="img-fluid" src="index.php?action=graphVentes" alt="Graphique des volumes de ventes">
    </div>

<?php

    $content = ob_get_clean();
    include 'layout.php';

?>