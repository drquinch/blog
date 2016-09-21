var topLinkElements = document.getElementsByClassName("top_link_element");

var resumeElt = document.getElementById("resume_articles");

var currentCategory = "all";

var pelemeleContent = "";
var newsContent = "";
var testContent = "";

topLinkElements[0].addEventListener("click", getArticles("all"));
topLinkElements[1].addEventListener("click", getArticles("news"));
topLinkElements[2].addEventListener("click", getArticles("test"));

function savePeleMeleCategory ()
{
	pelemeleContent = resumeElt.innerHTML;
	resumeElt.innerHTML = "";
}

function saveNewsCategory(index)
{
	newsContent = resumeElt.innerHTML;
	resumeElt.innerHTML = "";
}

function saveTestCategory(index)
{
	testContent = resumeElt.innerHTML;
	resumeElt.innerHTML = "";
}

function renderHtml(reponse)
{
	resumeElt.innerHTML = reponse;
}

function getArticles(category)
{
	// on commence par vérifier si on n'est pas déjà sur la catégorie (ex. Si on se trouve sur news et qu'on click sur news, on ne fais rien)
	if (currentCategory.localeCompare(category) !== 0)
	{
		// si la categorie courante est différente de la catégorie sélectionné
		// on vérifie sur quoi l'utilisateur a clické et on sauve (2nd switch) le contenu déjà chargé
		switch (category){
			case "all":
				switch (currentCategory){
					case "news":
						saveNewsCategory();
						break;
					case "test":
						saveTestCategory();
						break;
				}
				//si pelemeleContent n'est pas vide, on le switch tout simplement
				//sinon on envois la requete, dans ce cas ci, on ne fais rien car pele mele est d'office remplis 
				if (pelemeleContent.length !== 0)
				{
					resumeElt.innerHTML = pelemeleContent;
				}
				break;
			case "news":
				switch (currentCategory){
					case "all":
						savePeleMeleCategory();
						break;
					case "test":
						saveTestCategory();
						break;
				}
				//si newsContent n'est pas vide, on le switch tout simplement (on a déjà envoyé une requete pour recuperer le contenu)
				//sinon on envois la requete
				if ( undefined !== newsContent && newsContent.length !== 0)
				{
					resumeELt.innerHTML = newsContent;
				} else {
					ajaxGet("http://localhost/blog/web/app_dev.php/article/article/batch/10/0/" + category, renderHtml);
				}
				break;
			case "test":
				switch (currentCategory){
					case "all":
						savePeleMeleCategory();
						break;
					case "news":
						saveNewsCategory();
						break;
				}
				//si testContent n'est pas vide, on le switch tout simplement (on a deja envoyé une requete pour recuperer le contenu)
				//sinon on envois la requete 
				if (undefined !== testContent && testContent.length !== 0)
				{
					resumeElt.innerHTML = testContent;
				} else {
					ajaxGet("http://localhost/blog/web/app_dev.php/article/article/batch/10/0/" + category, renderHtml);
				}
				break;
		}
		currentCategory = category;
	}
}

function ajaxGet(url, callback)
{
	var req = new XMLHttpRequest();
	req.open("GET", url);
	req.addEventListener("load", function(reponse){
		if (req.status >= 200 && req.status < 400)
		{
			callback(req.responseText);
		} else
		{
			requestError(reponse);
		}
	});

	req.addEventListener("error", function(){

	});

	req.send(null);

}

function requestError(reponse){

}
