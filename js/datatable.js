$(document).ready(function(){
    $('#tableArticle').DataTable({
        "destroy": true,
        "responsive": true,
        "ajax": {
            "url": "index.php?action=commanderAjax",
            "cache": false,
            "dataSrc": "",
            "error": function (xhr, error, thrown) {
            console.error("Erreur DataTable AJAX : ", xhr.responseText);
        }
        },
        "columns": [
            { "data": "id_article" },
            { "data": "designation" },
            { "data": "prix" },
            { 
                "data": "categorie",
                "render": function(data, type, row) {
                    // Ajoute un lien hypertexte avec data-bs-toggle pour l'infobulle Bootstrap
                    return '<a href="#" class="category-link" data-bs-toggle="tooltip" data-categorie="' + data + '">' + data + '</a>';
                }
            },
            { "data": "quantite" }
        ],
        "language": {
            "processing": "Traitement en cours...",
            "search": "Rechercher&nbsp;:",
            "lengthMenu": "Afficher _MENU_ éléments",
            "info": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "infoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
            "infoFiltered": "(filtré de _MAX_ éléments au total)",
            "loadingRecords": "Chargement en cours...",
            "zeroRecords": "Aucun élément à afficher",
            "emptyTable": "Aucune donnée disponible dans le tableau",
            "paginate": {
                "first": "Premier",
                "previous": "Précédent",
                "next": "Suivant",
                "last": "Dernier"
            },
            "aria": {
                "sortAscending": ": activer pour trier la colonne par ordre croissant",
                "sortDescending": ": activer pour trier la colonne par ordre décroissant"
            }
        },
        "drawCallback": function() {

            $('.category-link').on('mouseenter', function() {
                var $link = $(this);
                var categorie = $link.data('categorie');

                // Appel AJAX pour récupérer le gain total
                $.ajax({
                    url: 'index.php?action=getGainTotalAjax',
                    method: 'GET',
                    data: { categorie: categorie },
                    success: function(response) {
                        console.log(response); // Vérifier la réponse dans la console
                
                        try {
                            var data = JSON.parse(response);
                            var gainTotal = data.gain_total || 'Non disponible';
                
                            // Ajout de title pour l'infobulle
                            $link.attr('title', categorie + " : " + gainTotal + " €");

                            // Créer l'infobulle
                            var tooltip = bootstrap.Tooltip.getInstance($link[0]);
                            if (tooltip) {
                                tooltip.setContent({ title: categorie + " : " + gainTotal + " €" });
                            } else {
                                new bootstrap.Tooltip($link[0]);  // Créer un infobulle
                                $link.tooltip('show');  // Affiche immédiatement l'infobulle
                            }
                        } catch (e) {
                            console.error('Erreur lors du parsing JSON : ', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erreur lors de la récupération du gain total :", error);
                    }
                });
            });
        }
    });
});


$(document).ready(function(){

    var userRole = $('#tableArticleNonCommander').data('user-role');

    $('#tableArticleNonCommander').DataTable({
        "scrollY": "350px",
        "scrollCollapse": true,
        "destroy": true,
        "responsive": true,
        "ajax": {
            "url": "index.php?action=nonCommanderAjax",
            "cache": false,
            "dataSrc": "",
            "error": function (xhr, error, thrown) {
            console.error("Erreur DataTable AJAX : ", xhr.responseText);
        }
        },
        "columns": [
            { "data": "id_article" },
            { "data": "designation" },
            { "data": "prix" },
            { "data": "categorie" },
            { 
                "data": "id_article",
                "render": function(data){
                    return '<a class="btn btn-success" href="index.php?action=modifier&id=' + data + '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/></svg></a>' + " " + 
                        '<a class="btn btn-danger btn-supp-article" data-bs-toggle="modal" data-bs-target="#suppArticleModal" data-id="' + data + '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16"><path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/></svg></a>';
                }
            }
        ],
        "columnDefs": [
            {
                // Masquer la colonne pour les non-admins
                "targets": [4], // Index de la colonne action
                "visible": userRole === 'Admin' // Affiche seulement si l'utilisateur est admin
            }
        ],
        "language": {
            "processing": "Traitement en cours...",
            "search": "Rechercher&nbsp;:",
            "lengthMenu": "Afficher _MENU_ éléments",
            "info": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "infoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
            "infoFiltered": "(filtré de _MAX_ éléments au total)",
            "loadingRecords": "Chargement en cours...",
            "zeroRecords": "Aucun élément à afficher",
            "emptyTable": "Aucune donnée disponible dans le tableau",
            "paginate": {
                "first": "Premier",
                "previous": "Précédent",
                "next": "Suivant",
                "last": "Dernier"
            },
            "aria": {
                "sortAscending": ": activer pour trier la colonne par ordre croissant",
                "sortDescending": ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });
})

$(document).ready(function(){
    $('#tableCommande').DataTable({
        "scrollY": "350px",
        "scrollCollapse": true,
        "destroy": true,
        "responsive": true,
        "ajax": {
            "url": "index.php?action=commandeAjax",
            "cache": false,
            "dataSrc": "",
            "error": function (xhr, error, thrown) {
            console.error("Erreur DataTable AJAX : ", xhr.responseText);
        }
        },
        "columns": [
            { "data": "id_comm" },
            { "data": "id_client" },
            { "data": "civilite" },
            { "data": "nom" },
            { "data": "prenom" },
            { "data": "mail" },
            { "data": "adresse" },
            { 
                "data": "id_comm",
                "render": function(data){
                    return '<div class="d-flex justify-content-center <?php echo ($role == \'Lecteur\') ? \'d-none\' : \'\'; ?>"><a class="btn btn-danger facture" target="_blank" href="index.php?action=facture&id=' + data + '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/></svg></a></div>'
                }
            }
        ],
        "language": {
            "processing": "Traitement en cours...",
            "search": "Rechercher&nbsp;:",
            "lengthMenu": "Afficher _MENU_ éléments",
            "info": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "infoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
            "infoFiltered": "(filtré de _MAX_ éléments au total)",
            "loadingRecords": "Chargement en cours...",
            "zeroRecords": "Aucun élément à afficher",
            "emptyTable": "Aucune donnée disponible dans le tableau",
            "paginate": {
                "first": "Premier",
                "previous": "Précédent",
                "next": "Suivant",
                "last": "Dernier"
            },
            "aria": {
                "sortAscending": ": activer pour trier la colonne par ordre croissant",
                "sortDescending": ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });
})