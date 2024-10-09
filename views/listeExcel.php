<?php

    $title = 'Liste des fichiers Excel';
    ob_start();

    

?>

<div class="d-flex justify-content-center text-bg-dark">
        <h1 class=" pt-2"><?php echo $title ?></h1>
</div>

    <div class="d-flex justify-content-center m-5">
        <table id="tableListeExcel" class="nowrap table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">Fichiers Excel</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($excelFiles)): ?>
                    <?php foreach ($excelFiles as $file): ?>
                        <tr>
                            <td>
                                <div class="d-flex justify-items-center">
                                    <a href="index.php?action=afficherExcel&nomFichier=<?php echo urlencode($file); ?>" class="me-2"><img class="img-excel" src="img/Excel-logo.png" alt=""></a>
                                    <?php echo $file; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun fichier Excel trouvé dans le dossier.</p>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<?php

    $content = ob_get_clean();
    include 'layout.php';

?>