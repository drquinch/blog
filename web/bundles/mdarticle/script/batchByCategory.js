var topLinkElements = document.getElementsByClassName("top_link_element");
var subLinkElements = document.getElementsByClassName("sub_link_element");
var bottomPagesLinks = document.getElementsByClassName("bottom_pages_links")[0];

// all, jeuxvideo, livre, news, critique, analyse, dossier, jeuxvideo, science-fiction, autres
//var contentArray = new Array("","","","","","","","","","");

var resumeElt = document.getElementById("resume_articles");
var previousContent;
var previousCat;
var currentCategory = "all";

/*var allContent = "";
var newsContent = "";
var testContent = "";
*/

topLinkElements[0].addEventListener("click", function(e){
		e.preventDefault();
		getArticles("all", "null");
		getPages("all", "null");
	});
topLinkElements[1].addEventListener("click", function(e){
		e.preventDefault();
		getArticles("jeux-video", "null");
		getPages("jeux-video", "null");
	});
/*topLinkElements[2].addEventListener("click", function(e){
		e.preventDefault();
		getArticles("livre", "null");
		getPages("livre", "null");
	});
	*/
subLinkElements[0].addEventListener("click", function(e){
		e.preventDefault();
		getArticles("news", "jeux-video");
		getPages("news", "jeux-video");
	});
subLinkElements[1].addEventListener("click", function(e){
		e.preventDefault();
		getArticles("critique", "jeux-video");
		getPages("critique", "jeux-video");
	});
/*subLinkElements[2].addEventListener("click", function(e){
		e.preventDefault();
		getArticles("analyse", "jeux-video");
		getPages("analyse", "jeux-video");
	});*/
subLinkElements[2].addEventListener("click", function(e){//TODO a changer et prendre 4eme element du tableau
		e.preventDefault();
		getArticles("dossier", "jeux-video");
		getPages("dossier", "jeux-video");
	});
/*subLinkElements[4].addEventListener("click", function(e){
		e.preventDefault();
		getArticles("jeux-video", "livre");
		getPages("jeux-video", "livre");
	});
subLinkElements[5].addEventListener("click", function(e){
		e.preventDefault();
		getArticles("science-fiction", "livre");
		getPages("science-fiction", "livre");
	});
subLinkElements[6].addEventListener("click", function(e){
		e.preventDefault();
		getArticles("autres", "livre");
		getPages("autres", "livre");
	});
*/
/*function saveContent (id)
{
	contentArray[id] = resumeElt.innerHTML;
	resumeELt.innerHTML = "";
}
	
function savePeleMeleCategory ()
{
	allContent = resumeElt.innerHTML;
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
}*/

function renderHtml(reponse)
{
	resumeElt.innerHTML = reponse;
}

function renderBottomPagesLinks(response)
{
	bottomPagesLinks.innerHTML = response;
}

function savePreviousContent ()
{
	previousContent = resumeElt.innerHTML;
	resumeElt.innerHTML = "";
}

function getArticles(category, catParent)
{
	if (category === previousCat)
	{
		resumeElt.innerHTML = previousContent;
	} else {
		previousCat = category;
		savePreviousContent ();
		ajaxGet("http://localhost/blog/web/app_dev.php/article/article/batch/10/0/" + category + "/" + catParent, renderHtml);
	}
}

function getPages(category, catParent)
{
	ajaxGet("http://localhost/blog/web/app_dev.php/pagingbycat/10/0/" + category + "/" + catParent + "/MDArticleBundle:Article", renderBottomPagesLinks)
}

/*function getArticles(category, catParent)
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
						saveContent(3);
						break;
					case "critique":
						saveContent(4);
						break;
					case "analyse":
						saveContent(5);
						break;
					case "dossier":
						saveContent(6);
						break;
				}
				//si pelemeleContent n'est pas vide, on le switch tout simplement
				//sinon on envois la requete, dans ce cas ci, on ne fais rien car pele mele est d'office remplis 
				if (allContent.length !== 0)
				{
					resumeElt.innerHTML = allContent;
				}
				break;
			case "jeux-video":
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
					ajaxGet("http://localhost/blog/web/app_dev.php/article/article/batch/10/0/" + category + "/" + catParent, renderHtml);
				}
				break;
			case "livre":
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
					ajaxGet("http://localhost/blog/web/app_dev.php/article/article/batch/10/0/" + category + "/" + catParent, renderHtml);
				}
				break;
		}
		currentCategory = category;
	}
}*/

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
