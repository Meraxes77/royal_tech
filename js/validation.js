$('#id_article').on('input', function(){

    // Tous les caratères en majuscule
    this.value = this.value.toUpperCase();

    if(id_article.value.length == 5){

        // Si OK met la class Bootstrap is-valid (vert)
        $('#id_article').addClass('is-valid').removeClass('is-invalid');
        return true;

    }else{

        // Si pas OK met la class Bootstrap is-invalid (rouge)
        $('#id_article').addClass('is-invalid').removeClass('is-valid');
        $('#error_id_article').html(`Veuillez saisir 5 caractères.`);
        return false;

    }

});

$('#designation').on('input', function(){

    // Le 1er caratère en majuscule
    this.value = this.value.charAt(0).toUpperCase() + this.value.substring(1).toLowerCase();

    if(designation.value.length >= 1){

        // Si OK met la class Bootstrap is-valid (vert)
        $('#designation').addClass('is-valid').removeClass('is-invalid');
        return true;

    }else{

        // Si pas OK met la class Bootstrap is-invalid (rouge)
        $('#designation').addClass('is-invalid').removeClass('is-valid');
        $('#error_designation').html(`Veuillez ajouter une désignation.`);
        return false;

    }

});

$('#prix').on('input', function(){

    // Regex pour exclure les lettres
    var prixFormat = /^\d*\.?\d*$/;

    if(prix.value.match(prixFormat)){

        // Si OK met la class Bootstrap is-valid (vert)
        $('#prix').addClass('is-valid').removeClass('is-invalid');
        return true;

    }else{

        // Si pas OK met la class Bootstrap is-invalid (rouge)
        $('#prix').addClass('is-invalid').removeClass('is-valid');
        $('#error_prix').html(`Veuillez saisir un nombre`);
        return false;

    }

});

$('#categorie').on('change', function(){

    var categorie = $('#categorie').val();

    if(categorie !== ''){

        // Si OK met la class Bootstrap is-valid (vert)
        $('#categorie').addClass('is-valid').removeClass('is-invalid');
        return true;

    }else{

        // Si pas OK met la class Bootstrap is-invalid (rouge)
        $('#categorie').addClass('is-invalid').removeClass('is-valid');
        return false;

    }

});

$('#btn_ajout_article').on('click', function(e){

    var categorie = $('#categorie').val();

    if(id_article.value.length === 0 || designation.value.length === 0 || prix.value.length === 0 || categorie === null){

        e.preventDefault();

        if(id_article.value.length === 0){
    
            $('#id_article').addClass('is-invalid').removeClass('is-valid');
            $('#error_id_article').html(`Veuillez saisir un identifiant pour l'article`);
    
        }
        if(designation.value.length === 0){
    
            $('#designation').addClass('is-invalid').removeClass('is-valid');
            $('#error_designation').html(`Veuillez saisir un identifiant pour l'article`);
    
        }
        if(prix.value.length === 0){
    
            $('#prix').addClass('is-invalid').removeClass('is-valid');
            $('#error_prix').html(`Veuillez saisir un identifiant pour l'article`);
    
        }
        if(categorie === null){
    
            $('#categorie').addClass('is-invalid').removeClass('is-valid');
            $('#error_categorie').html(`Veuillez saisir un identifiant pour l'article`);
    
        }

    };

});