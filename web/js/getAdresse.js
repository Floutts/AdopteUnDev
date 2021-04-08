$(document).ready(function() {

    let tdAdresse = document.getElementById("tdAdresse");
    getUser();
    let codeCommune;
    let codeDepartement;
    function getUser(){
        var request= $.ajax({
            url: "http://serveur1.arras-sio.com/symfony4-4061/AdopteUnDev/AdopteUnDev/web/index.php?page=developpeur", 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {
            codeDepartement = msg.codeDepartement;
            codeCommune = msg.codeCommune;
            ajaxDepartement(codeDepartement);
            
        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur');
        });
    }

    function ajaxDepartement(codeDepartement){
        var request= $.ajax({
            url: "https://geo.api.gouv.fr/departements/"+codeDepartement, 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {
            tdAdresse.innerText += msg.nom
            tdAdresse.innerText += ",";
            ajaxCommune(codeCommune);
        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur');
        });
    }

    function ajaxCommune(codeCommune){
        var request= $.ajax({
            url: "https://geo.api.gouv.fr/communes/"+codeCommune, 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {
            tdAdresse.innerText += msg.nom
        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert('error')
        });
    }
});