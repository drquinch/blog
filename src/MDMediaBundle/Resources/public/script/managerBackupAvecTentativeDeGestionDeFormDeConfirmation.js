var links = document.getElementsByTagName("a");
var fileLinks = document.getElementById("list_file").getElementsByTagName("a");
var bottomLinks = document.getElementById("bottom_buttons").getElementsByTagName("a");
var legend = document.getElementById("list_file").getElementsByTagName("figcaption");
var selectedFile = "";
var selectedFileElt;
var currentDir = "web/img/uploads/";
var submitElt = null;

// boucle pour gérer les liens vers d'autres fonctionnalité (donc rien à voir avec la liste de files)
for(var i = 0; i < links.length; i++)
{
	links[i].addEventListener('mouseenter', function(){
		this.style.color = "rgb(0,125,255)";	
	});
	links[i].addEventListener('mouseleave', function(){
		this.style.color = "rgb(40,40,40)";
	});
}

// boucle pour gérer la liste des file
for(var i = 0; i < fileLinks.length; i++)
{
	fileLinks[i].addEventListener('click', function(event){
		event.preventDefault();
		highlightSelectedFile(this.nextSibling.nextSibling);
	});
}

// Gestion new directory button
// on récupère le nom du nouveau répertoir à créer
// on envoit la requete au serveur
// dans la réponse on reçoit la nouvelle arborescence
// on supprime alors la liste des dir et files et on affiche la resultat recu
document.getElementById("new_directory_button").addEventListener('click', function(event){
	event.preventDefault();
	var newDir = prompt("Enter new directory name : ", "new directory name");

	// pour l'url, on retravaille le currentDir pour éviter les conflits: / devient _
	// côté serveur on fait l'inverse	
	ajaxGet("http://localhost/blog/web/app_dev.php/admin/media/create_directory/" + currentDir.replace(/\//g, "_") + "/" + newDir, refreshMainFrame);
});

// Gestion delete directory button
// on appelle d'abord le formulaire de suppression via une requete ajax et en passant le directory à supprimer en parametre
// on intercepte alors les events des links et submit
// on renvois le form dans la requete en mode post
// on recupere le file_tree misa à jour
document.getElementById("delete_directory_button").addEventListener('click', function(event){
	event.preventDefault();
	// on récupère le form pour confirmation
	ajaxGet("http://localhost/blog/web/app_dev.php/admin/media/delete_directory/" + currentDir.replace(/\//g, "_") + "/" + selectedFile, showForm);
	// on peut maintenant modifier le submit du form
	document.getElementById("submit_delete").addEventListener('click', function(event){
		event.preventDefault();
		// on serialize le form et on le passe à la requete ajaxPost
		ajaxPost("http://localhost/blog/web/app_dev.php/admin/media/create_directory/" + currentDir.replace(/\//g, "_") + "/" + selectedFile, serializeForm(document.forms[0]), refreshMainFrame);
	});
});

// method pour serialiser un form et retourner un formdata
function serializeForm(form)
{
	return new FormData(form);
}

// method qui recupere et affiche un form par dessus le reste
function showForm(form)
{
	// on créé d'abord un fond à moitié opaque
	// puis on affiche le form au milieu de l'écran
	var toAdd = "<div id=\"bgnForm\" style=\"height: 100%; width: 100%; background-color: rgba(40,40,40,50);\"></div>" + form;
	document.body.appendChild(toAdd);
}

// method qui cache le form de confirmation
function hiddenForm()
{
	document.body.removeChild(document.getElementById("bgnForm"));
	document.body.removeChild(document.getElementById("confirm_form"));
}

// gestion hover, links de #bottom_buttons
for (var i = 0; i < bottomLinks.length; i++)
{
	bottomLinks[i].addEventListener("mouseenter", function(){
		this.style.color = "rgb(40,40,40)";
	});
	bottomLinks[i].addEventListener("mouseleave", function(){
		this.style.color = "rgb(240,240,240)";
	});
}


// supprime le contenu principale et le réécrit avec la nouvelle arborescence
function refreshMainFrame(reponse)
{
	var mainFrame = document.getElementById("list_file");
	mainFrame.innerHTML = reponse;
}

// change le bgn et rajoute un border pointiller sur l'element selectionne
function highlightSelectedFile(elt)
{
	if (selectedFileElt != null && selectedFileElt != elt)
	{
		selectedFileElt.style.backgroundColor = "white";
		selectedFileElt.style.border = "";
	}

	if (elt.style.backgroundColor == "white")
	{
		elt.style.backgroundColor = "rgb(204,232,255)";
		elt.style.border = "1px solid rgb(153,209,255)";
		selectedFile = elt.innerHTML;
		selectedFileElt = elt;
	} else {
		elt.style.backgroundColor = "white";
		elt.style.border = "";
		selectedFile = "";
		selectedFileElt = null;
	}
}

