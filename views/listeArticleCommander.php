<?php

    $title = 'Liste des articles commandés';
    ob_start();

?>

    <div class="d-flex justify-content-center text-bg-dark">
        <h1 class=" pt-2"><?php echo $title ?></h1>
    </div>
    
    <div class="d-flex justify-content-center m-5">
        <table id="tableArticle" class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Id article</th>
                    <th>Désignation</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                
                </tbody>
            </table>
    </div>
    
<?php

    $content = ob_get_clean();
    require 'layout.php';