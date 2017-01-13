var links = document.getElementsByTagName("a");
var fileLinks = document.getElementById("list_file").getElementsByTagName("a");
var bottomLinks = document.getElementById("bottom_buttons").getElementsByTagName("a");
var legend = document.getElementById("list_file").getElementsByTagName("figcaption");
var selectedFile = "";
var selectedFileElt;
var currentDir = "web/img/uploads/";
var submitElt = null;
var basicUrl = "http://localhost/blog/web/app_dev.php/";
var newDir = "";
var oldDir = "";
var replaceBy = "_";// char ou string qui remplacera les slash dans le currentDir

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
		event.stopPropagation();
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
	event.stopPropagation();
	newDir = prompt("Enter new directory name : ", "new directory name");

	// pour l'url, on retravaille le currentDir pour éviter les conflits: / devient _
	// côté serveur on fait l'inverse	
	ajaxGet("http://localhost/blog/web/app_dev.php/admin/media/create_directory/" + currentDir.replace(/\//g, replaceBy) + "/" + newDir, showNewDirForm);// showNewDirForm à la place de refreshMainFrame
});

// Gestion edit dir/file button
// appelle de editDirAction
// reception du form et affichage
// renvois du form avec les données
document.getElementById("edit_directory_button").addEventListener('click', function(event){
	event.preventDefault();
	event.stopPropagation();
	if(selectedFileElt.getAttribute("class") == "file") {
		console.log(selectedFileElt.getAttribute("class"));
		oldDir = currentDir.replace(/\//g, replaceBy)+selectedFile;
		newDir = "null";
		ajaxGet(basicUrl+"admin/media/edit_directory/"+oldDir+"/"+newDir, showEditFileForm);
	} else {
		console.log(selectedFileElt.getAttribute("class"));
		newDir = prompt("Enter the new name of dir (only char, numbers or - allowed) : ", "new-dir-name");
		// si le nom est correcte on appelle le serveur
		if(newDir.match(/[a-zA-Z0-9\-]+/g)){
			oldDir = currentDir.replace(/\//g, replaceBy)+selectedFile;
			ajaxGet(basicUrl+"admin/media/edit_directory/"+oldDir+"/"+newDir, showEditDirForm);
		} else {
			alert("The new name contains a forbidden char!");
		}
	}
	console.log(selectedFile);
	console.log(selectedFileElt);
});

// Gestion delete directory button
document.getElementById("delete_directory_button").addEventListener('click', function(event){
	event.preventDefault();
	event.stopPropagation();
	// on récupère le form pour confirmation
	ajaxGet("http://localhost/blog/web/app_dev.php/admin/media/delete_directory/" + currentDir.replace(/\//g, replaceBy) + "/" + selectedFile, showDeleteForm);
});

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
	// en plus d'afficher la réponse, on supprime un form si il y en a un
	document.getElementById("form_management_frame").innerHTML = "";
	//if(document.getELementById("edit_form")))
	//{
	//	document.getElementById("form_management_frame").innerHTML = reponse;
	//} else {
	//	mainFrame.innerHTML = reponse;
	//}
	addListenerToDir(document.getElementsByClassName("directory"));
}

// sur chaque double click d'un dossier on change le currentDir (on rajoute du texte, ou on en retire)
// et on fait un appel ajax pour obtenir ce que contient le dossier
// TODO gérer le "dossier" .. pour revenir en arriere
dirs = document.getElementsByClassName("directory");
// On fait une fonciton pour pouvoir appliquer les listener au nouveau dossier reçu dans refreshMainFrame
function addListenerToDir(listDir) {
	for (var i = 0; i < listDir.length; i++)
	{	
		// TODO
		// pour chaque dir, on va chercher le nom du dir
		// on le rajoute au currentDir + "/"
		// on appelle la fonction ajaxGet avec la route et les params
		listDir[i].addEventListener("dblclick", function(e){
			e.preventDefault();
			e.stopPropagation();
			var dirName = e.target.parentNode.parentNode.childNodes[3].textContent;
			if(dirName !== ".." || dirName !== ".")
			{
				currentDir += dirName + "/";
			} else if ( dirName === ".." ) {
				// TODO
				// si le currentName n'est pas web/img/uploads/
				// ni qq chose en dessous de ce chemin, on peut revenir d'un cran en arriere
				// donc enlever lastSlash/ à web/img/uploads/qqchose/lastSlash/
			}
			console.log(currentDir);
			ajaxGet(basicUrl + "admin/media/find_directory/" + currentDir.replace(/\//g, replaceBy), refreshMainFrame);
		});
	}
}
addListenerToDir(dirs)

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

function showEditDirForm(reponse){
document.getElementById("form_management_frame").innerHTML = reponse;
showForm(basicUrl + "admin/media/edit_directory/" + oldDir + "/" + newDir, "form%5B_token%5D="+ document.getElementById("form__token").value);
}

function showEditFileForm(reponse){
document.getElementById("form_management_frame").innerHTML = reponse;
document.getElementById("confirm_form").addEventListener('submit', function(event){
	event.preventDefault();
	event.stopPropagation();
var requestForm = "image_edit_nested%5Balt%5D="+document.getElementById("image_edit_nested_alt").value
	+"&image_edit_nested%5Bname%5D="+document.getElementById("image_edit_nested_name").value
	+"&image_edit_nested%5Bfigcaption%5D="+document.getElementById("image_edit_nested_figcaption").value
	+"&image_edit_nested%5B_token%5D="+document.getElementById("image_edit_nested__token").value;
ajaxPost(basicUrl+"admin/media/edit_directory/"+oldDir+"/"+newDir, requestForm, refreshMainFrame);
});
}

function showNewDirForm(reponse){
document.getElementById("form_management_frame").innerHTML = reponse;
showForm(basicUrl + "admin/media/create_directory/" + currentDir.replace(/\//g, replaceBy) + "/" + newDir,"form%5B_token%5D=" + document.getElementById("form__token").value);
}

function showDeleteForm(reponse){
document.getElementById("form_management_frame").innerHTML = reponse;
showForm(basicUrl + "admin/media/delete_directory/" + currentDir.replace(/\//g, replaceBy) + "/" + selectedFile, "form%5B_token%5D=" + document.getElementById("form__token").value);
}

function showForm (url, post){
document.getElementById("confirm_form").addEventListener('submit', function(event){
	event.preventDefault();
	event.stopPropagation();
	ajaxPost(url, post, refreshMainFrame);
});
}
