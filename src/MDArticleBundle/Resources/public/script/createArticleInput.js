// on créé les différents array
var inputs = [document.getElementById("article_tags"),
				document.getElementById("article_games"),
				document.getElementById("article_licences"),
				document.getElementById("article_developers"),
				document.getElementById("article_publishers")];
var urls = ["http://localhost/blog/web/app_dev.php/tags/tag/json_all",
			"http://localhost/blog/web/app_dev.php/game/game/json_all",
			"http://localhost/blog/web/app_dev.php/game/licence/json_all",
			"http://localhost/blog/web/app_dev.php/game/developer/json_all",
			"http://localhost/blog/web/app_dev.php/game/publisher/json_all"];

//on affecte les valeurs par défaut de chacun des champs //TODO
//inputTextTagElt.value = "tag 1, tag 2, ...";

for (var i = 0; i < urls.length; i++)
{
	// closure pour capturer la valeur de i
	(function (i){
		inputs[i].autocompletion = new AutoCompletion();
		inputs[i].setElementList = function (resp) {
			this.autocompletion.elementList = new Array();
				var tempList = new Array();
				tempList = JSON.parse(resp);
				// après avoir parsé le json, on transforme le array d'objet en simple array de string
				for (var i = 0; i < tempList.elements.length; i++)
				{
					//console.log(tempList.elements[i].element);
					this.autocompletion.elementList.push(tempList.elements[i].element);
				}
				console.log(this.autocompletion.elementList);
		};
		// on récupère les données en bdd et on l'injecte dans l'objet autocompletion
		ajaxGet(urls[i], function(resp){
			inputs[i].setElementList(resp);
		});
		// ajout de l'EL keyup à chapue input text
		inputs[i].addEventListener('keyup', function(e){
			// on vérifie d'abord si le focus est bien sur l'input actuel
			if (this === document.activeElement)
			{
				var inputText = "";
				// on soustrait d'abord tout le contenu avant ', ' (', ' y compris) et on l'envois à l'objet autocompletion
				if(~e.target.value.indexOf(', '))
				{
					inputText = e.target.value.substring(e.target.value.lastIndexOf(', ')+2, e.target.value.length);
				} else {
					inputText = e.target.value;
				}
				this.autocompletion.setInputText(inputText);
				
				// TODO si on n'a pas appuyé sur backspace et si ce nest pas keyup sur shift
				// on recherche le mot le plus proche qui pourrait coller
				result = this.autocompletion.completeWord();
				// highlight du texte
				this.autocompletion.highlightInputText(e);
				console.log(this.autocompletion.proposal);
			}
		});
	})(i);
}
