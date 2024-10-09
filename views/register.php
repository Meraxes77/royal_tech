<?php

    $title = 'RoyalTech - Inscription';
    ob_start();

?>

<div id="card_register" class="d-flex justify-content-center align-items-center vh-100">
        <div class="card" style="width: 30rem;">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <img id="logo" src="img/logo_societe.png" alt="Logo de la société RoyalTech" class="w-25">
                    <h5 class="card-title d-flex align-items-center ps-3 fw-bold"><div class="texte_orange">Back-Office - Royal</div><div class="texte_gris">Tech</div></h5>
                </div>
                <hr>
                <h6 class="card-subtitle mb-2 text-center">Inscription</h6>
                <form action="#" method="post">
                <div class="">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" class="form-control" id="login" name="login" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="">
                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="d-none">
                    <label for="role" class="form-label">ID Role</label>
                    <input type="text" class="form-control" id="role" name="role" value="" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="">
                    <label for="nom_role" class="form-label">Rôle</label>
                    <select class="form-select" id="nom_role" name="nom_role" required>
                        <option selected disabled value="">Choisir...</option>
                        <?php foreach($listeRole as $ligne): ?>
                            <option><?= htmlspecialchars($ligne['role'] ?? '') ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid state.
                    </div>
                </div>
                <br>
                <div class="form-group mt-2 d-flex justify-content-evenly">
                    <button type="submit" class="btn btn-success">Inscription</button>
                    <a role="button" class="btn btn-danger" href="index.php?action=login">Retour</a>
                </div>
            </form>
            </div>
        </div>
    </div>

<?php

    $content = ob_get_clean();
    include 'layout.php';

?>