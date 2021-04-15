$(document).ready(function() {

    

    let codeDepartement;
    let departements = document.getElementById("departements");
    let unDev = document.getElementById("unDev");
    let tCommune = [];

    function ajaxDepartements(){
        var request= $.ajax({
            url: "https://geo.api.gouv.fr/departements?fields=nom,code", 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {

            $.each(msg, function(index,e){
                departements.innerHTML += "<option value="+ e.code +" >" + e.nom + "</option>";
            });

        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur');
        });
    }

    ajaxDepartements();

    departements.addEventListener("change",function(){
        codeDepartement = departements.value;
        //ajaxDeveloppeur();
        ajaxCommune(codeDepartement);
    })

    function ajaxDeveloppeur(){
        var request= $.ajax({
            url: "http://serveur1.arras-sio.com/symfony4-4061/AdopteUnDev/AdopteUnDev/web/index.php?page=developpeurByDepartement&code=" + codeDepartement, 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {

            $.each(msg, function(index,e){
                    unDev.innerHTML = "";
                    for(var key in tCommune){
                        var value = tCommune[key];
                        if (value["code"] == e.codeCommune ){
                            var nameCommune = value["nom"];
                        }
                    }
                	unDev.innerHTML += "<div class=\"row mb-3\">";
                    unDev.innerHTML += "<div class=\"col-md-3\">";
			        unDev.innerHTML += "<div class=\"d-flex flex-row border rounded\">";
                    unDev.innerHTML += "<div class=\"pl-3 pt-2 pr-2 pb-2 w-75 border-left\">";
                    unDev.innerHTML += "<h4 class=\"text-primary\">"+ e.nom +" " + e.prenom +"</h4>";
                    unDev.innerHTML += "<h5 class=\"text-info\">" + e.email + "</h5>";
                    unDev.innerHTML += "<h6 class=\"text\">" + nameCommune + "</h6>";
                    unDev.innerHTML += "<ul class=\"m-0 float-left\" style=\"list-style: none; margin:0; padding: 0\">";
                    unDev.innerHTML += "<li>Langages</li>";
                    unDev.innerHTML += "</ul>";
                    unDev.innerHTML += "</div>";
                    unDev.innerHTML += "</div>";
                    unDev.innerHTML += "</div>";
                    unDev.innerHTML += "</div>";

             
                console.log(tCommune);
            });

        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur');
        });
    }

    function ajaxCommune(codeDepartement){
        var request= $.ajax({
            url: "https://geo.api.gouv.fr/departements/"+ codeDepartement +"/communes?fields=nom&format=json&geometry=centre", 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {
            
            $.each(msg, function(index,e){
                tCommune.push({"code": e.code, "nom" : e.nom});
            })
            console.log(tCommune);
            ajaxDeveloppeur()
        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur');
        });
    }
});