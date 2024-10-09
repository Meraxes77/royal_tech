<?php

    $title = 'Connexion';
    ob_start();

?>

<div id="card_login" class="d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 30rem;">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <img id="logo" src="img/logo_societe.png" alt="Logo de la société RoyalTech" class="w-25">
                <h5 class="card-title d-flex align-items-center ps-3 fw-bold"><div class="texte_orange">Back-Office - Royal</div><div class="texte_gris">Tech</div></h5>
            </div>
            <br>
            <h6 class="card-subtitle mb-2 text-body-secondary">Connexion</h6>
            <form action="#" method="POST">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <div class="">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" class="form-control" id="login" name="login" autocomplete="username" required>
                </div>
                <div class="">
                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" autocomplete="current-password" required>
                </div>
                <div class="form-group mt-2 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">Connexion</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

    $content = ob_get_clean();
    include 'layout.php';

?>