<?php

    $title = 'Ajouter un article';
    ob_start();
?>

<div class="d-flex justify-content-center text-bg-dark">
        <h1 class=" pt-2"><?php echo $title ?></h1>
</div>

<div id="card_ajout" class="d-flex justify-content-center mt-5">
    <div class="card" style="width: 30rem;">
        <div class="card-body">
            <form class="row g-3 add_table" id="add_form" action="" method="post" novalidate>
                <div class="">
                    <label for="id_article" class="form-label">ID article</label>
                    <input type="text" class="form-control" id="id_article" name="id_article" placeholder="Exemple : AA000" required value="<?php
                    if(!empty($_POST['id_article'])){
                        echo $_POST['id_article'];
                    }
                    ?>">
                    <div class="invalid-feedback"><p id="error_id_article"></p></div>
                </div>
                <div class="">
                    <label for="designation" class="form-label">Désignation</label>
                    <input type="text" class="form-control" id="designation" name="designation" required value="<?php
                    if(!empty($_POST['designation'])){
                        echo $_POST['designation'];
                    }
                    ?>">
                    <div class="invalid-feedback"><p id="error_designation"></p></div>
                </div>
                <div class="">
                    <label for="prix" class="form-label">Prix unitaire (€)</label>
                    <input type="text" class="form-control" id="prix" name="prix" required value="<?php
                    if(!empty($_POST['prix'])){
                        echo $_POST['prix'];
                    }
                    ?>">
                    <div class="invalid-feedback"><p id="error_prix"></p></div>
                </div>
                <div class="">
                    <label for="categorie" class="form-label">Catégorie</label>
                    <select class="form-select" id="categorie" name="categorie" required>
                        <option selected disabled value="">Choisir...</option>
                        <?php foreach($categorie as $ligne): ?>
                            <option><?= htmlspecialchars($ligne['categorie'] ?? '') ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback"><p id="error_categorie"></p></div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <input id="btn_ajout_article" class="btn btn-primary" type="submit">
                </div>
            </form>
        </div>
    </div>
</div>

<?php

    $content = ob_get_clean();
    include 'layout.php';

?>