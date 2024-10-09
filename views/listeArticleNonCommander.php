<?php

    $role = isset($_GET['role']) ? $_GET['role'] : '';

    $title = 'Liste des articles non commandés';
    ob_start();

?>
    <div class="d-flex justify-content-center text-bg-dark">
        <h1 class="pt-2"><?php echo $title ?></h1>
    </div>
    
    <div class="d-flex justify-content-center m-5">
        <table id="tableArticleNonCommander" class="nowrap table table-striped table-hover" data-user-role="<?= $_SESSION['role']; ?>">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">ID article</th>
                    <th class="text-center">Désignation</th>
                    <th class="text-center">Prix unitaire (€)</th>
                    <th class="text-center">Catégorie</th>
                    <th class="text-center admin-only">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les données seront chargées par DataTables via AJAX -->
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="suppArticleModal" tabindex="-1" aria-labelledby="suppArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <img class="w-25 me-3" src="img/logo_societe.png" alt="">
                <h1 class="modal-title fs-5" id="suppArticleModalLabel">Supprimer un article ?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Souhaitez vous vraiment supprimer l'article : 
            </div>
            <div class="modal-footer">
                <a id="btnSuppArticleModal" href="#" class="btn btn-danger">Supprimer</a>
            </div>
            </div>
        </div>
    </div>

    
<?php

    $content = ob_get_clean();
    require 'layout.php';